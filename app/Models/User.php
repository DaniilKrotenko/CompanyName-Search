<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'last_name', 'first_name', 'email'];

    public $incrementing = false;

    protected static function newFactory()
    {
        return UserFactory::new();
    }

    public function positions()
    {
        return $this->hasMany(Position::class);
    }


}
