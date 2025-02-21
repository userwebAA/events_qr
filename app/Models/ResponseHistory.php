<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResponseHistory extends Model
{
    protected $table = 'response_history';
    
    protected $fillable = [
        'table_id',
        'question_id',
        'selected_option',
        'feedback',
    ];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
