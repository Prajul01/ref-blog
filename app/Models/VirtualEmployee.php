<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VirtualEmployee extends Model
{
    use HasFactory;

    protected $table='virtual_employee';
    protected $fillable=['fname','lname','email','phone','companyName','message'];
}
