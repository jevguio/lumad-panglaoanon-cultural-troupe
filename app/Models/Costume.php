<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Costume extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'status',
        'date_returned',
        'date_lost',
        'img',
        'date_complied',
        'report_detail',
        'report_img'
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
}
