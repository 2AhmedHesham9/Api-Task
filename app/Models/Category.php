<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'catigories';
    protected $fillable=['category','created_at','updated_at'];
    use HasFactory;
}
