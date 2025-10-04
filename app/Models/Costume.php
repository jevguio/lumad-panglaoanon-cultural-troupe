<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Costume extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'status',
        'date_returned',
        'date_lost',
        'date_complied',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
}
