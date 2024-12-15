<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectType extends Model
{
    protected $fillable = ['name'];
    
    public function generatedIdeas()
    {
        return $this->hasMany(GeneratedIdea::class);
    }
}
