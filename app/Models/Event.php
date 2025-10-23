<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'type',
        'date',
        'image',
        'created_by',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public static array $types = [
        'meteor_shower' => 'Meteor Shower',
        'eclipse' => 'Eclipse',
        'planet_alignment' => 'Planet Alignment',
        'comet_appearance' => 'Comet Appearance',
        'supermoon' => 'Supermoon',
        'other' => 'Other',
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
            return $query->where('title', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
        }
        return $query;
    }

    public function scopeFilterByType($query, $type)
    {
        if ($type) {
            return $query->where('type', $type);
        }
        return $query;
    }

    public function scopeSort($query, $sort = 'latest')
    {
        return match($sort) {
            'oldest' => $query->oldest(),
            'title' => $query->orderBy('title'),
            'date' => $query->orderBy('date'),
            default => $query->latest(),
        };
    }

    public function getFormattedType(): string
    {
        return self::$types[$this->type] ?? $this->type;
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