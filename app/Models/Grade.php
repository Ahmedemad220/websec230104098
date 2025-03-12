<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model {
    protected $fillable = ['course_name', 'course_code', 'credit_hours', 'letter_grade', 'grade_point', 'term'];
}