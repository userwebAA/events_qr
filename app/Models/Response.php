<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Question;

class Response extends Model
{
    protected $fillable = [
        'question_id',
        'selected_option',
        'table_id',
        'feedback'
    ];

    protected $casts = [
        'question_id' => 'integer'
    ];

    public function question()
    {
        return $this->belongsTo(Question::class)
                    ->where('id', '>=', 0); // Exclure l'ID -1 de la relation
    }
}
