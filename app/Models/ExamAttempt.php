<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExamAttempt extends Model
{
    protected $fillable = ['exam_id', 'score', 'total_questions', 'passed', 'answers'];
    protected $casts = ['passed' => 'boolean', 'answers' => 'array'];
    public function exam(): BelongsTo { return $this->belongsTo(Exam::class); }
}
