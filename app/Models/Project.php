<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    protected $table='projects';
    protected $fillable=['image','title','description','links','contributors','excerpt','thumbnail'];

    public function setLinksAttribute($value)
    {
        $this->attributes['links'] = json_encode($value);
    }

    public function getLinksAttribute($value)
    {
        return json_decode($value, true);
    }
}
