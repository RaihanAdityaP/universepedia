<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'date',
        'location',
        'type',
        'visibility',
        'time',
        'duration',
        'image',
        'is_recurring',
    ];

    protected $casts = [
        'date' => 'date',
        'time' => 'datetime:H:i',
        'is_recurring' => 'boolean',
    ];

    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/' . $this->image) : asset('images/default-event.png');
    }

    public function getTypeColorAttribute()
    {
        return match($this->type) {
            'meteor_shower' => 'warning',
            'eclipse' => 'dark',
            'planet_alignment' => 'info',
            'rocket_launch' => 'success',
            'asteroid_flyby' => 'danger',
            default => 'secondary'
        };
    }

    public function getFormattedDateAttribute()
    {
        return $this->date->format('d M Y');
    }

    public function getDaysUntilAttribute()
    {
        return $this->date->diffInDays(now(), false);
    }

    public function scopeUpcoming($query)
    {
        return $query->where('date', '>=', now()->toDateString());
    }

    public function scopePast($query)
    {
        return $query->where('date', '<', now()->toDateString());
    }
}