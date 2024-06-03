<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'enrollment';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id_enroll';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_student',
        'id_course',
        'date',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * Get the student associated with the enrollment.
     */
    public function student()
    {
        return $this->belongsTo(Student::class, 'id_student', 'id_student');
    }

    /**
     * Get the course associated with the enrollment.
     */
    public function course()
    {
        return $this->belongsTo(Course::class, 'id_course', 'id_course');
    }
}
