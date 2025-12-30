<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index()
    {
        $clients = User::where('role', 'client')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.dashboard', compact('clients'));
    }
}
