<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'mode', 'status', 'is_show_event',  'description', 'required_performers', 'time', 'date', 'type', 'venue', 'client'];

    protected $casts = [
        'selected_performers' => 'array',
    ];
 
    public function selectedPerformers()
    {
        return $this->belongsToMany(User::class, 'event_user');
    }
    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }
    public function highlights()
    {
        return $this->hasMany(EventHighlights::class,'event_id','id');
    }
    public function performers()
    {
        return $this->belongsToMany(User::class, 'event_user')
            ->withPivot(['status','attendance'])
            ->withTimestamps();
    }
    
    
    
}
