<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public $timestamps = true;

    protected $table = 'posts';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'created_at',
        'updated_at',
        'title',
        'content',
        'imageUrl',
        'published',
        'user_id',
    ];

    protected $casts = [
        'id' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'title' => 'string',
        'content' => 'string',
        'imageUrl' => 'string',
        'published' => 'boolean',
        'user_id' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function published(Builder $query)
    {
        return $query->where('published', true);
    }
}
