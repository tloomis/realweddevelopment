<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    /**
     * Get database-specific date format function
     */
    private function getDateFormatSql($column, $format = '%Y-%m')
    {
        $driver = DB::connection()->getDriverName();

        if ($driver === 'sqlite') {
            return "strftime('$format', $column)";
        } else {
            // MySQL/PostgreSQL
            $mysqlFormat = str_replace('%', '', $format);
            return "DATE_FORMAT($column, \"%$mysqlFormat\")";
        }
    }

    public function index()
    {
        $dateFormat = $this->getDateFormatSql('paid_date');

        // Get revenue by month for the last 12 months
        $revenueByMonth = Invoice::where('status', 'paid')
            ->where('paid_date', '>=', now()->subMonths(12))
            ->select(
                DB::raw("$dateFormat as month"),
                DB::raw('SUM(total) as revenue')
            )
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Get invoice status distribution
        $invoicesByStatus = Invoice::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get();

        // Get top clients by revenue
        $topClients = User::withSum(['invoices' => function ($query) {
            $query->where('status', 'paid');
        }], 'total')
            ->orderByDesc('invoices_sum_total')
            ->limit(10)
            ->get();

        $createdDateFormat = $this->getDateFormatSql('created_at');

        // Monthly trends (invoices created per month)
        $invoicesByMonth = Invoice::where('created_at', '>=', now()->subMonths(12))
            ->select(
                DB::raw("$createdDateFormat as month"),
                DB::raw('count(*) as count')
            )
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Summary statistics
        $stats = [
            'total_revenue' => Invoice::where('status', 'paid')->sum('total'),
            'total_outstanding' => Invoice::whereIn('status', ['sent', 'overdue'])->sum('total'),
            'total_invoices' => Invoice::count(),
            'paid_invoices' => Invoice::where('status', 'paid')->count(),
            'total_clients' => User::count(),
            'overdue_invoices' => Invoice::where('status', 'overdue')->count(),
            'avg_invoice_value' => Invoice::avg('total'),
        ];

        return view('admin.analytics.index', compact(
            'revenueByMonth',
            'invoicesByStatus',
            'topClients',
            'invoicesByMonth',
            'stats'
        ));
    }

    public function reports(Request $request)
    {
        $reportType = $request->get('type', 'revenue');
        $startDate = $request->get('start_date', now()->subMonths(12)->format('Y-m-d'));
        $endDate = $request->get('end_date', now()->format('Y-m-d'));

        $data = match($reportType) {
            'revenue' => $this->getRevenueReport($startDate, $endDate),
            'overdue' => $this->getOverdueReport(),
            'payment-history' => $this->getPaymentHistoryReport($startDate, $endDate),
            default => []
        };

        return view('admin.analytics.reports', compact('data', 'reportType', 'startDate', 'endDate'));
    }

    private function getRevenueReport($startDate, $endDate)
    {
        return Invoice::where('status', 'paid')
            ->whereBetween('paid_date', [$startDate, $endDate])
            ->with('user')
            ->orderBy('paid_date', 'desc')
            ->get();
    }

    private function getOverdueReport()
    {
        return Invoice::where('status', 'overdue')
            ->with('user')
            ->orderBy('due_date', 'asc')
            ->get();
    }

    private function getPaymentHistoryReport($startDate, $endDate)
    {
        return Invoice::where('status', 'paid')
            ->whereBetween('paid_date', [$startDate, $endDate])
            ->with('user')
            ->select('payment_method', DB::raw('count(*) as count'), DB::raw('SUM(total) as total'))
            ->groupBy('payment_method')
            ->get();
    }
}
