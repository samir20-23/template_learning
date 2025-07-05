<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    use HasFactory;

    protected $fillable = ['id','name', 'description','created_at','updated_at'];

    public function documents()
    {
        return $this->hasMany(Document::class, 'categorie_id');
    }
}
