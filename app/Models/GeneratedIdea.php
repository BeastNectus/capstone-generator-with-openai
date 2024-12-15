<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GeneratedIdea extends Model
{
    protected $fillable = [
        'title',
        'description',
        'programming_languages',
        'suggested_roles',
        'similar_projects',
        'timeline',
        'industry_id',
        'project_type_id',
        'difficulty'
    ];

    protected $casts = [
        'programming_languages' => 'array',
        'suggested_roles' => 'array',
        'similar_projects' => 'array',
        'timeline' => 'array'
    ];

    public function industry()
    {
        return $this->belongsTo(Industry::class);
    }

    public function projectType()
    {
        return $this->belongsTo(ProjectType::class);
    }
}
