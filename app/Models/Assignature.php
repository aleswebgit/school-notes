<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignature extends Model {
  use HasFactory;

  protected $fillable = [
    'name',
    'description',
    'curse',
    'year',
    'user_id',
  ];
}
