<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Picture extends Model
{
    use HasFactory;

    protected $fillable = ['imageable_type' , 'imageable_id' , 'name' , 'file_name' , 'mime_type' , 'featured' , '	thumbnail'];
}
