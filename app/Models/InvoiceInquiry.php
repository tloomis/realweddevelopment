<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceInquiry extends Model
{
    protected $fillable = [
        'invoice_id',
        'user_id',
        'subject',
        'message',
        'status',
        'admin_response',
        'responded_by',
        'responded_at',
    ];

    protected $casts = [
        'responded_at' => 'datetime',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function responder()
    {
        return $this->belongsTo(User::class, 'responded_by');
    }

    public function getStatusBadgeAttribute()
    {
        return match($this->status) {
            'open' => ['text' => 'Open', 'color' => '#0891b2'],
            'in_progress' => ['text' => 'In Progress', 'color' => '#f59e0b'],
            'resolved' => ['text' => 'Resolved', 'color' => '#10b981'],
            default => ['text' => 'Unknown', 'color' => '#6b7280'],
        };
    }
}
