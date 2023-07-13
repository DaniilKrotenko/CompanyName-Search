<?php

namespace App\Models;

use Database\Factories\CompanyFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{

    use HasFactory;

    protected $table = 'companies';
    protected $primaryKey = 'id';

    protected $fillable = ['id', 'name', 'address'];

    public $incrementing = false;

    protected static function newFactory()
    {
        return CompanyFactory::new();
    }

    public function positions()
    {
        return $this->hasMany(Position::class);
    }
}
