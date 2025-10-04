<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventHighlights extends Model
{
    //
    protected $fillable = ['event_id'];

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }
    public function files()
    {
        return $this->hasMany(FileUploads::class, 'event_highlights_id');
    }
}
