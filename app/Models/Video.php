<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;
    protected $fillable=['id','title','description','thumbnail','url_video'];
    protected $visible=['id','title','description','url_video'];
}
