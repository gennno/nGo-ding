<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable as AuthenticatableTrait;

class User extends Model implements Authenticatable
{
    use HasFactory, AuthenticatableTrait;

    protected $table = 'user'; // Specify the table name here

    protected $primaryKey = 'email'; // Set the primary key field

    protected $fillable = [
        'email',
        'name',
        'password',
        'no_hp',
        'avatar',
        'roles',
    ];

    // Define the method that returns the name of the unique identifier for the user.
    public function getAuthIdentifierName()
    {
        return 'email';
    }

    // Define the method that returns the unique identifier for the user.
    public function getAuthIdentifier()
    {
        return $this->email;
    }

    // Define the method that returns the password for the user.
    public function getAuthPassword()
    {
        return $this->password;
    }

    public $timestamps = true;

    /**
     * Get the students associated with the user.
     */
    public function students()
    {
        return $this->hasMany(Student::class, 'user_email', 'email');
    }

    /**
     * Get the mentors associated with the user.
     */
    public function mentors()
    {
        return $this->hasMany(Mentor::class, 'user_email', 'email');
    }
}
