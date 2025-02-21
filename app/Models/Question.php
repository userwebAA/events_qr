<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Response;

class Question extends Model
{
    protected $fillable = [
        'content',
        'options',
        'order'
    ];

    protected $casts = [
        'options' => 'array',
        'order' => 'integer'
    ];

    public function responses()
    {
        return $this->hasMany(Response::class);
    }
}
