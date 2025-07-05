<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Validation extends Model
{
    protected $fillable = [
        'document_id',
        'validated_by',
        'status',
        'commentaire',
        'validated_at',
    ];

    protected $casts = [
        'validated_at' => 'datetime',
    ];

    // Relationships
    public function document()
    {
        return $this->belongsTo(Document::class);
    }

    public function validator()
    {
        return $this->belongsTo(User::class, 'validated_by');
    }

    // Alternative name for compatibility
    public function formateur()
    {
        return $this->belongsTo(User::class, 'validated_by');
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'Pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'Approved');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'Rejected');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Helper methods
    public function isPending()
    {
        return $this->status === 'Pending';
    }

    public function isApproved()
    {
        return $this->status === 'Approved';
    }

    public function isRejected()
    {
        return $this->status === 'Rejected';
    }

    public function getStatusBadgeClass()
    {
        return match ($this->status) {
            'Pending' => 'badge-warning',
            'Approved' => 'badge-success',
            'Rejected' => 'badge-danger',
            default => 'badge-secondary'
        };
    }

    public function getStatusIcon()
    {
        return match ($this->status) {
            'Pending' => 'fas fa-clock',
            'Approved' => 'fas fa-check-circle',
            'Rejected' => 'fas fa-times-circle',
            default => 'fas fa-question-circle'
        };
    }

    // Auto-set validated_at when status changes
    public function setStatusAttribute($value)
    {
        $this->attributes['status'] = $value;

        if ($value !== 'Pending' && !$this->validated_at) {
            $this->attributes['validated_at'] = now();
        }
    }
}