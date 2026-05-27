<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ActivityLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'activity_id',
        'user_id',
        'old_status',
        'new_status',
        'remark',
    ];

    // A log BELONGS TO one activity
    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }

    // A log BELONGS TO one user (who made the update)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}