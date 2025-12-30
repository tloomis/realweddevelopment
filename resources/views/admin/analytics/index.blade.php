<x-app-layout>
    <!-- Dashboard Header -->
    <div class="dashboard-header" style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h1 class="dashboard-title">Analytics & Reports</h1>
            <p class="dashboard-subtitle">Track revenue, invoices, and client metrics across your business.</p>
        </div>
        <a href="{{ route('admin.analytics.reports') }}" class="btn-dashboard" style="background: white; color: #0891b2; border: 2px solid white; font-size: 0.9375rem; padding: 0.75rem 1.5rem; text-decoration: none;">
            View Detailed Reports
        </a>
    </div>

    <!-- Summary Statistics -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-label">Total Revenue</div>
            <div class="stat-value">${{ number_format($stats['total_revenue'], 2) }}</div>
            <div style="font-size: 0.875rem; color: #64748b; margin-top: 0.5rem;">From {{ $stats['paid_invoices'] }} paid invoices</div>
        </div>

        <div class="stat-card">
            <div class="stat-label">Outstanding</div>
            <div class="stat-value" style="color: #f59e0b;">${{ number_format($stats['total_outstanding'], 2) }}</div>
            <div style="font-size: 0.875rem; color: #64748b; margin-top: 0.5rem;">{{ $stats['overdue_invoices'] }} overdue invoices</div>
        </div>

        <div class="stat-card">
            <div class="stat-label">Total Invoices</div>
            <div class="stat-value">{{ $stats['total_invoices'] }}</div>
            <div style="font-size: 0.875rem; color: #64748b; margin-top: 0.5rem;">Across {{ $stats['total_clients'] }} clients</div>
        </div>

        <div class="stat-card">
            <div class="stat-label">Avg Invoice Value</div>
            <div class="stat-value">${{ number_format($stats['avg_invoice_value'], 2) }}</div>
            <div style="font-size: 0.875rem; color: #64748b; margin-top: 0.5rem;">Per invoice</div>
        </div>
    </div>

    <!-- Charts Row 1 -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(500px, 1fr)); gap: 1.5rem; margin-bottom: 1.5rem;">
        <!-- Revenue by Month Chart -->
        <div class="content-card">
            <div class="content-card-header">
                <h2 class="content-card-title">Revenue by Month (Last 12 Months)</h2>
            </div>
            <div class="content-card-body">
                <canvas id="revenueChart" style="max-height: 300px;"></canvas>
            </div>
        </div>

        <!-- Invoice Status Distribution -->
        <div class="content-card">
            <div class="content-card-header">
                <h2 class="content-card-title">Invoice Status Distribution</h2>
            </div>
            <div class="content-card-body">
                <canvas id="statusChart" style="max-height: 300px;"></canvas>
            </div>
        </div>
    </div>

    <!-- Charts Row 2 -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(500px, 1fr)); gap: 1.5rem; margin-bottom: 1.5rem;">
        <!-- Invoices Created per Month -->
        <div class="content-card">
            <div class="content-card-header">
                <h2 class="content-card-title">Invoices Created per Month</h2>
            </div>
            <div class="content-card-body">
                <canvas id="invoicesChart" style="max-height: 300px;"></canvas>
            </div>
        </div>

        <!-- Top Clients by Revenue -->
        <div class="content-card">
            <div class="content-card-header">
                <h2 class="content-card-title">Top 10 Clients by Revenue</h2>
            </div>
            <div class="content-card-body">
                <canvas id="clientsChart" style="max-height: 300px;"></canvas>
            </div>
        </div>
    </div>

    @vite(['resources/js/app.js'])

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Revenue by Month Chart
            const revenueCtx = document.getElementById('revenueChart').getContext('2d');
            new Chart(revenueCtx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($revenueByMonth->pluck('month')) !!},
                    datasets: [{
                        label: 'Revenue ($)',
                        data: {!! json_encode($revenueByMonth->pluck('revenue')) !!},
                        borderColor: '#10b981',
                        backgroundColor: 'rgba(16, 185, 129, 0.1)',
                        tension: 0.4,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return '$' + value.toLocaleString();
                                }
                            }
                        }
                    }
                }
            });

            // Invoice Status Chart
            const statusCtx = document.getElementById('statusChart').getContext('2d');
            const statusColors = {
                'draft': '#6b7280',
                'sent': '#0891b2',
                'paid': '#10b981',
                'overdue': '#ef4444',
                'cancelled': '#78716c'
            };
            new Chart(statusCtx, {
                type: 'doughnut',
                data: {
                    labels: {!! json_encode($invoicesByStatus->pluck('status')) !!},
                    datasets: [{
                        data: {!! json_encode($invoicesByStatus->pluck('count')) !!},
                        backgroundColor: {!! json_encode($invoicesByStatus->pluck('status')->map(fn($s) => $statusColors[$s] ?? '#6b7280')) !!}
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });

            // Invoices Created per Month
            const invoicesCtx = document.getElementById('invoicesChart').getContext('2d');
            new Chart(invoicesCtx, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($invoicesByMonth->pluck('month')) !!},
                    datasets: [{
                        label: 'Invoices Created',
                        data: {!! json_encode($invoicesByMonth->pluck('count')) !!},
                        backgroundColor: '#0891b2'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    }
                }
            });

            // Top Clients Chart
            const clientsCtx = document.getElementById('clientsChart').getContext('2d');
            new Chart(clientsCtx, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($topClients->pluck('name')) !!},
                    datasets: [{
                        label: 'Revenue ($)',
                        data: {!! json_encode($topClients->pluck('invoices_sum_total')) !!},
                        backgroundColor: '#8b5cf6'
                    }]
                },
                options: {
                    indexAxis: 'y',
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        x: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return '$' + value.toLocaleString();
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
</x-app-layout>
