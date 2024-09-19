<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreSignupEmail extends Model
{
    use HasFactory;
    protected $fillable = ['email'];
}
