<?php

namespace App\Models;

use Database\Factories\PositionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{

    use HasFactory;

    protected $table = 'positions';
    protected $fillable = ['id', 'position', 'user_id', 'company_id'];

    protected static function newFactory()
    {
        return PositionFactory::new();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
