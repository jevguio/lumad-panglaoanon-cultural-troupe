<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FileUploads extends Model
{
    //
    protected $fillable = ['event_highlights_id','paths','type'];

    public function event()
    {
        return $this->belongsTo(EventHighlights::class, 'event_highlights_id');
    }
}
