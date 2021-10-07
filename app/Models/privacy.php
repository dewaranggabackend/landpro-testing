<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class privacy extends Model
{
    protected $table = 'privacy';
    protected $fillable = ['judul', 'isi'];
}
