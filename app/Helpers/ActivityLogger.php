<?php

namespace App\Helpers;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class ActivityLogger
{
    public static function log(string $action, $model = null, string $description = null, $oldValue = null, $newValue = null): void
    {
        if (!Auth::check()) {
            return;
        }

        $data = [
            'user_id' => Auth::id(),
            'action' => $action,
            'description' => $description,
            'old_value' => $oldValue ? json_encode($oldValue) : null,
            'new_value' => $newValue ? json_encode($newValue) : null,
        ];

        if ($model && is_object($model)) {
            $data['model'] = class_basename($model);
            $data['model_id'] = $model->id ?? null;
            
            if (!$description) {
                $data['description'] = self::generateDescription($action, $model);
            }
        } else {
            $data['model'] = 'System';  
            $data['model_id'] = 0;     
        }

        ActivityLog::create($data);
    }

    private static function generateDescription(string $action, $model): string
    {
        $modelName = class_basename($model);
        $itemName = $model->title ?? $model->name ?? "item #{$model->id}";

        return match($action) {
            'create' => "Created {$modelName}: {$itemName}",
            'update' => "Updated {$modelName}: {$itemName}",
            'delete' => "Deleted {$modelName}: {$itemName}",
            'soft_delete' => "Soft deleted {$modelName}: {$itemName}",
            'force_delete' => "Permanently deleted {$modelName}: {$itemName}",
            'restore' => "Restored {$modelName}: {$itemName}",
            'favorite' => "Added {$modelName} to favorites: {$itemName}",
            'unfavorite' => "Removed {$modelName} from favorites: {$itemName}",
            'comment' => "Commented on {$modelName}: {$itemName}",
            'delete_comment' => "Deleted a comment on {$modelName}: {$itemName}",
            'rate' => "Rated {$modelName}: {$itemName}",
            default => "{$action} {$modelName}: {$itemName}",
        };
    }
}