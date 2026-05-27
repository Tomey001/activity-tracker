<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Activity extends Model
{
    use HasFactory;

    // These columns can be filled in by our forms
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'status',
        'activity_date',
    ];

    // Cast activity_date as a date type
    protected $casts = [
        'activity_date' => 'date',
    ];

    // An activity BELONGS TO one user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // An activity HAS MANY logs
    public function logs()
    {
        return $this->hasMany(ActivityLog::class);
    }
}