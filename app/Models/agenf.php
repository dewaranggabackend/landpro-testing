<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class agenf extends Model
{
    protected $table = 'agenf';
    protected $fillable = ['user_id', 'agen_id'];

    public function pengguna () {
        return $this->belongsTo(User::class, 'agen_id', 'id');
    }
}
