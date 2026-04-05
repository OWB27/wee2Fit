<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Lang;

class UserTag extends Model
{
    protected $fillable = [
        'name',
        'slug',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_tag_user')->withTimestamps();
    }

    public function displayName(): string
    {
        $key = 'messages.user_tag_' . $this->slug;

        return Lang::has($key) ? __($key) : $this->name;
    }
}
