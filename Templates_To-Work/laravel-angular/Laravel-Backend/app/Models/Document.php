<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'type',
        'chemin_fichier',
        'original_name',
        'file_size',
        'mime_type',
        'description',
        'status',
        'is_public',
        'download_count',
        'categorie_id',
        'user_id'
    ];

    protected $casts = [
        'is_public' => 'boolean',
        'file_size' => 'integer',
        'download_count' => 'integer',
    ];

    // Relationships
    public function categorie()
    {
        return $this->belongsTo(Categorie::class, 'categorie_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function validation()
    {
        return $this->hasOne(Validation::class);
    }

    public function validations()
    {
        return $this->hasMany(Validation::class);
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopePublic($query)
    {
        return $query->where('is_public', true);
    }

    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('categorie_id', $categoryId);
    }

    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%")
                ->orWhere('original_name', 'like', "%{$search}%");
        });
    }

    // Helper methods
    public function getFileExtension()
    {
        return pathinfo($this->original_name ?? $this->chemin_fichier, PATHINFO_EXTENSION);
    }

    public function getFormattedFileSize()
    {
        if (!$this->file_size)
            return 'Unknown';

        $bytes = $this->file_size;
        $units = ['B', 'KB', 'MB', 'GB'];

        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, 2) . ' ' . $units[$i];
    }

    public function getFileIcon()
    {
        $extension = strtolower($this->getFileExtension());

        return match ($extension) {
            'pdf' => 'fas fa-file-pdf text-danger',
            'doc', 'docx' => 'fas fa-file-word text-primary',
            'xls', 'xlsx' => 'fas fa-file-excel text-success',
            'ppt', 'pptx' => 'fas fa-file-powerpoint text-warning',
            'jpg', 'jpeg', 'png', 'gif' => 'fas fa-file-image text-info',
            'mp4', 'avi', 'mov' => 'fas fa-file-video text-purple',
            'mp3', 'wav' => 'fas fa-file-audio text-orange',
            'zip', 'rar' => 'fas fa-file-archive text-secondary',
            'txt' => 'fas fa-file-alt text-muted',
            default => 'fas fa-file text-dark'
        };
    }

    public function getStatusBadgeClass()
    {
        return match ($this->status) {
            'published' => 'badge-success',
            'draft' => 'badge-warning',
            'archived' => 'badge-secondary',
            default => 'badge-info'
        };
    }

    public function getStatusIcon()
    {
        return match ($this->status) {
            'published' => 'fas fa-check-circle',
            'draft' => 'fas fa-edit',
            'archived' => 'fas fa-archive',
            default => 'fas fa-file'
        };
    }

    public function fileExists()
    {
        return Storage::disk('public')->exists($this->chemin_fichier);
    } 

    public function fileUrl()
    {
        return asset('storage/' . $this->chemin_fichier);
    }

    public function isImage()
    {
        return str_starts_with($this->mime_type, 'image/');
    }
    public function getDownloadUrl()
    {
        return route('documents.download', $this);
    }

    public function getViewUrl()
    {
        return route('documents.view', $this);
    }

    public function incrementDownloadCount()
    {
        $this->increment('download_count');
    }

    // Validation status helpers
    public function needsValidation()
    {
        return !$this->validation || $this->validation->isPending();
    }

    public function isValidated()
    {
        return $this->validation && $this->validation->isApproved();
    }

    public function isRejected()
    {
        return $this->validation && $this->validation->isRejected();
    }

    public function getValidationStatus()
    {
        if (!$this->validation) {
            return 'Not Submitted';
        }
        return $this->validation->status;
    }

    public function getValidationBadgeClass()
    {
        if (!$this->validation) {
            return 'badge-secondary';
        }
        return $this->validation->getStatusBadgeClass();
    }

    // Boot method for model events
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($document) {
            // Delete file when document is deleted
            if ($document->fileExists()) {
                Storage::delete($document->chemin_fichier);
            }

            // Delete related validations
            $document->validations()->delete();
        });
    }

    public function scopeNeedsValidation($query)
    {
        return $query
            // no validation record at all
            ->whereDoesntHave('validation')
            // or validations with status = Pending
            ->orWhereHas('validation', function ($q) {
                $q->where('status', 'Pending');
            });
    }
}
