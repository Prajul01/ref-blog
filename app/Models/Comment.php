<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $table='comments';
    protected $fillable=['fname','lname','email','comments','blog_id'];

    public function blog(){
        return $this->belongsTo(Blog::class);
    }
}
