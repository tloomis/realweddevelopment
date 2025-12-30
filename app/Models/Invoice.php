<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'invoice_number',
        'user_id',
        'created_by',
        'status',
        'issue_date',
        'due_date',
        'notes',
        'subtotal',
        'tax_rate',
        'tax_amount',
        'total',
        'paid_date',
        'payment_method',
        'payment_reference',
        'payment_notes',
        'payment_reminder_sent_at',
    ];

    protected $casts = [
        'issue_date' => 'date',
        'due_date' => 'date',
        'paid_date' => 'date',
        'payment_reminder_sent_at' => 'datetime',
        'subtotal' => 'decimal:2',
        'tax_rate' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }

    public function inquiries()
    {
        return $this->hasMany(InvoiceInquiry::class);
    }

    public function fileUploads()
    {
        return $this->hasMany(FileUpload::class);
    }

    public function getStatusBadgeAttribute()
    {
        return match($this->status) {
            'draft' => ['text' => 'Draft', 'color' => '#64748b'],
            'sent' => ['text' => 'Sent', 'color' => '#0891b2'],
            'paid' => ['text' => 'Paid', 'color' => '#10b981'],
            'overdue' => ['text' => 'Overdue', 'color' => '#ef4444'],
            'cancelled' => ['text' => 'Cancelled', 'color' => '#6b7280'],
            default => ['text' => 'Unknown', 'color' => '#6b7280'],
        };
    }
}
