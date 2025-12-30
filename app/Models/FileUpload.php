<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class FileUpload extends Model
{
    protected $fillable = [
        'user_id',
        'uploaded_by',
        'invoice_id',
        'filename',
        'stored_filename',
        'file_path',
        'file_size',
        'mime_type',
        'description',
        'is_visible_to_client',
    ];

    protected $casts = [
        'is_visible_to_client' => 'boolean',
        'file_size' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    /**
     * Get human readable file size
     */
    public function getFormattedFileSizeAttribute()
    {
        $bytes = $this->file_size;

        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        } elseif ($bytes > 1) {
            return $bytes . ' bytes';
        } elseif ($bytes == 1) {
            return $bytes . ' byte';
        } else {
            return '0 bytes';
        }
    }

    /**
     * Get file icon based on mime type
     */
    public function getFileIconAttribute()
    {
        $mime = $this->mime_type;

        if (str_starts_with($mime, 'image/')) {
            return '🖼️';
        } elseif (str_starts_with($mime, 'video/')) {
            return '🎥';
        } elseif (str_starts_with($mime, 'audio/')) {
            return '🎵';
        } elseif ($mime === 'application/pdf') {
            return '📄';
        } elseif (str_contains($mime, 'word') || str_contains($mime, 'document')) {
            return '📝';
        } elseif (str_contains($mime, 'sheet') || str_contains($mime, 'excel')) {
            return '📊';
        } elseif (str_contains($mime, 'zip') || str_contains($mime, 'compressed')) {
            return '📦';
        } else {
            return '📎';
        }
    }

    /**
     * Delete file from storage when model is deleted
     */
    protected static function booted()
    {
        static::deleting(function ($fileUpload) {
            if (Storage::exists($fileUpload->file_path)) {
                Storage::delete($fileUpload->file_path);
            }
        });
    }
}
