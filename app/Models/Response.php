<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Response extends Model
{
    protected $fillable = ['answers', 'feedback'];

    protected $casts = [
        'answers' => 'json'
    ];

    public function setAnswersAttribute($value)
    {
        $this->attributes['answers'] = is_string($value) ? $value : json_encode($value);
    }

    public function getAnswersAttribute($value)
    {
        return json_decode($value, true);
    }
}
