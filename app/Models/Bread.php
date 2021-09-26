<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bread extends Model
{
    use HasFactory;

    protected $table = "bread";
    protected $fillable = [
        "name","img","rating","price","views"
    ];
}
