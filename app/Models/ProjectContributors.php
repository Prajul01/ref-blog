<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectContributors extends Model
{
    use HasFactory;
    protected $table='project_contributors';
    protected $fillable=['project_id','contributor_id'];
}
