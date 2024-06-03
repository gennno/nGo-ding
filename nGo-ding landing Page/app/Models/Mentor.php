<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mentor extends Model
{
    use HasFactory;

    // Define the table associated with the Mentor model
    protected $table = 'mentor';

    // Specify the primary key of the table
    protected $primaryKey = 'id_mentor';

    // Set the fillable fields to allow mass assignment
    protected $fillable = [
        'email',
    ];

    // Indicate if the IDs are auto-incrementing
    public $incrementing = true;

    // Define the relationship with the User model
    public function user()
    {
        return $this->belongsTo(User::class, 'email', 'email');
    }

    // Disable timestamps if not necessary
    public $timestamps = true;
}

