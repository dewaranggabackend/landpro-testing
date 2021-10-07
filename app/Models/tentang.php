<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tentang extends Model
{
    protected $table = 'tentang';
    protected $fillable = ['judul', 'isi'];
}
