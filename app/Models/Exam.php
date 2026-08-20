<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Exam extends Model
{
    protected $fillable = ['title', 'description', 'is_published'];
    protected $casts = ['is_published' => 'boolean'];
    public function questions(): HasMany { return $this->hasMany(Question::class)->orderBy('position'); }
    public function attempts(): HasMany { return $this->hasMany(ExamAttempt::class); }
    public function isComplete(): bool { return $this->questions()->count() === 30; }
}
