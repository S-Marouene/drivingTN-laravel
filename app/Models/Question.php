<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Question extends Model
{
    protected $fillable = ['exam_id', 'position', 'question_text', 'image_path', 'audio_path', 'options', 'correct_option'];
    protected $casts = ['options' => 'array', 'correct_option' => 'integer'];
    public function exam(): BelongsTo { return $this->belongsTo(Exam::class); }
}
