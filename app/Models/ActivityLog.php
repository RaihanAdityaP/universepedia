<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'action',
        'model',
        'model_id',
        'description',
        'old_value',
        'new_value', 
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getFormattedAction(): string
    {
        return match($this->action) {
            'create' => 'Created',
            'update' => 'Updated',
            'delete' => 'Deleted',
            'soft_delete' => 'Soft Deleted',
            'force_delete' => 'Permanently Deleted',
            'restore' => 'Restored',
            'favorite' => 'Favorited',
            'unfavorite' => 'Unfavorited',
            'login' => 'Logged In',        
            'logout' => 'Logged Out',   
            'register' => 'Registered',  
            'view' => 'Viewed',
            'comment' => 'Commented',
            'delete_comment' => 'Deleted Comment',
            'restore_comment' => 'Restored Comment',
            'force_delete_comment' => 'Permanently Deleted Comment',
            'rate' => 'Rated',
            default => ucfirst($this->action),
        };
    }
}