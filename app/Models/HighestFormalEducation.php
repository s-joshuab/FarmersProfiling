<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HighestFormalEducation extends Model
{
    use HasFactory;


    protected $table = 'highest_formal_education';

    protected $fillable = ['education'];

}
