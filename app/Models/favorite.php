<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class favorite extends Model
{
    protected $table = 'favorite';
    protected $fillable = ['users_id', 'properti_id'];

    public function properti () {
        return $this->belongsTo('\App\Models\properti', 'properti_id', 'id');
    }

    public function pengguna () {
        return $this->belongsTo(User::class, 'users_id', 'id');
    }
}
