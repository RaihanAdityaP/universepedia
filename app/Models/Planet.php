<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Planet extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'size',
        'distance',
        'image',
        'created_by',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favoritable');
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable')->whereNull('parent_id')->with('user', 'replies');
    }

    public function ratings()
    {
        return $this->morphMany(Rating::class, 'ratable');
    }

    public function scopeSearch($query, $search)
    {
        if ($search) {
            return $query->where('name', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
        }
        return $query;
    }

    public function scopeSort($query, $sort = 'latest')
    {
        return match($sort) {
            'oldest' => $query->oldest(),
            'name' => $query->orderBy('name'),
            default => $query->latest(),
        };
    }

    public function averageRating()
    {
        return $this->ratings()->avg('rating') ?? 0;
    }

    public function totalRatings()
    {
        return $this->ratings()->count();
    }
}