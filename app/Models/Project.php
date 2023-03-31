<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    protected $table='projects';
    protected $fillable=['image','title','description','links','contributors_id','excerpt','client'];

    public function setLinksAttribute($value)
    {
        $this->attributes['links'] = json_encode($value);
    }

    public function getLinksAttribute($value)
    {
        return json_decode($value, true);
    }
//    public function contributors()
//    {
//        return $this->belongsToMany(Contributor::class);
//    }
    public function contributors()
    {
        return $this->belongsToMany(Contributor::class, 'project_contributor')->withPivot('contributor_id');
    }
    public function getFirstContributorIdAttribute()
    {
        return $this->contributors->first()->pivot->getAttribute('contributor_id');
    }
}
