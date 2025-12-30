<?php

use App\Http\Controllers\Admin\AnalyticsController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Client\DashboardController as ClientDashboardController;
use App\Http\Controllers\Client\PaymentController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

// Contact form route
Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');

// Legacy dashboard route - redirect based on role
Route::get('/dashboard', function () {
    if (auth()->check()) {
        if (auth()->user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('client.dashboard');
    }
    return redirect()->route('login');
})->middleware(['auth'])->name('dashboard');

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Analytics Routes
    Route::get('/analytics', [AnalyticsController::class, 'index'])->name('analytics');
    Route::get('/analytics/reports', [AnalyticsController::class, 'reports'])->name('analytics.reports');

    Route::get('/clients/create', [ClientController::class, 'create'])->name('clients.create');
    Route::post('/clients', [ClientController::class, 'store'])->name('clients.store');
    Route::get('/clients/{user}', [ClientController::class, 'show'])->name('clients.show');
    Route::post('/clients/{user}/impersonate', [ClientController::class, 'impersonate'])->name('clients.impersonate');

    // Client Notes
    Route::post('/clients/{user}/notes', [ClientController::class, 'storeNote'])->name('clients.notes.store');
    Route::delete('/notes/{note}', [ClientController::class, 'deleteNote'])->name('notes.delete');

    // Client Messages
    Route::post('/clients/{user}/messages', [ClientController::class, 'storeMessage'])->name('clients.messages.store');
    Route::patch('/messages/{message}/read', [ClientController::class, 'markMessageAsRead'])->name('messages.read');

    // Client Invoices
    Route::post('/clients/{user}/invoices', [ClientController::class, 'storeInvoice'])->name('clients.invoices.store');
    Route::patch('/invoices/{invoice}/status', [ClientController::class, 'updateInvoiceStatus'])->name('invoices.status');
    Route::delete('/invoices/{invoice}', [ClientController::class, 'deleteInvoice'])->name('invoices.delete');
    Route::get('/invoices/{invoice}/pdf', [ClientController::class, 'downloadInvoicePdf'])->name('invoices.pdf');

    // Invoice Inquiries
    Route::post('/inquiries/{inquiry}/respond', [ClientController::class, 'respondToInquiry'])->name('inquiries.respond');

    // File Management
    Route::post('/clients/{user}/files/upload', [ClientController::class, 'uploadFileForClient'])->name('files.upload');
    Route::get('/files/{file}/download', [ClientController::class, 'downloadFileAdmin'])->name('files.download');
    Route::delete('/files/{file}', [ClientController::class, 'deleteFileAdmin'])->name('files.delete');
    Route::patch('/files/{file}/toggle-visibility', [ClientController::class, 'toggleFileVisibility'])->name('files.toggle-visibility');
});

// Impersonation Routes
Route::middleware(['auth'])->group(function () {
    Route::post('/stop-impersonating', [ClientController::class, 'stopImpersonating'])->name('stop-impersonating');
});

// Client Routes
Route::middleware(['auth'])->prefix('client')->name('client.')->group(function () {
    Route::get('/dashboard', [ClientDashboardController::class, 'index'])->name('dashboard');
    Route::get('/invoices/{invoice}', [ClientDashboardController::class, 'showInvoice'])->name('invoices.show');
    Route::get('/invoices/{invoice}/pdf', [ClientDashboardController::class, 'downloadInvoicePdf'])->name('invoices.pdf');
    Route::post('/invoices/{invoice}/inquiries', [ClientDashboardController::class, 'storeInquiry'])->name('invoices.inquiries.store');

    // File Upload Routes
    Route::post('/files/upload', [ClientDashboardController::class, 'uploadFile'])->name('files.upload');
    Route::get('/files/{file}/download', [ClientDashboardController::class, 'downloadFile'])->name('files.download');
    Route::delete('/files/{file}', [ClientDashboardController::class, 'deleteFile'])->name('files.delete');

    // Payment Routes
    Route::get('/invoices/{invoice}/payment', [PaymentController::class, 'show'])->name('payment.show');
    Route::post('/invoices/{invoice}/payment/checkout', [PaymentController::class, 'createCheckoutSession'])->name('payment.checkout');
    Route::get('/invoices/{invoice}/payment/success', [PaymentController::class, 'success'])->name('payment.success');
    Route::get('/invoices/{invoice}/payment/cancel', [PaymentController::class, 'cancel'])->name('payment.cancel');
});

// Profile Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
