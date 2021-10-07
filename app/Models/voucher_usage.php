<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class voucher_usage extends Model
{
    protected $table = 'history_voucher';
    protected $fillable = ['users_id', 'voucher'];
}
