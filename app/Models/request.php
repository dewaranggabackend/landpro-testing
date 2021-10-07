<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class request extends Model
{
    protected $table = 'request'; 
    protected $fillable = ['users_id'];

    public function nama () {
        return $this->belongsTo(User::class, 'users_id', 'id');
    }
}
