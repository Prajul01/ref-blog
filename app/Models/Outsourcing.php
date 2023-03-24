<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Outsourcing extends Model
{
    use HasFactory;
    protected $table='outsourcing';
    protected $fillable=['fname','lname','email','phone','companyName','message'];
}
