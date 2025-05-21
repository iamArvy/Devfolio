<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Social extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'value',
        'icon',
        'link'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
