<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventPerformer extends Model
{
    use HasFactory;
    protected $table = "event_user";
    protected $fillable = ['event_id', 'user_id', 'status','attendance'];
 
  
    public function performer()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    public function event()
    {
        return $this->belongsTo(Event::class,'event_id');
    }
    
    
    
}
