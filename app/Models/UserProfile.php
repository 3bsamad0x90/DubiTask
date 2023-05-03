<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    use HasFactory;
    protected $fillable = [
        'map_location',
        'date_of_birth',
        'user_id'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
