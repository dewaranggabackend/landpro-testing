<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class syarat extends Model
{
    protected $table = 'syarat';
    protected $fillable = ['judul', 'isi'];
}
