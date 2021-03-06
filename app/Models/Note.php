<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model {
  use HasFactory;

  protected $fillable = [
    'note',
    'student_id',
    'exam_id',
  ];
  
  public function student() {
    return $this->belongsTo(Student::class);
  }
  
  public function exam() {
    return $this->belongsTo(Exam::class);
  }
}
