<?php

// app/Models/Project.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'title',
        'description',
        'url',
        'repo_url',
        'image_path',
        'tech_stack',
    ];
}
