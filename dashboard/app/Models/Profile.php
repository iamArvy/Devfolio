<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'fullname',
        'job_description',
        'bio',
        'phone',
        'email',
        'location'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
