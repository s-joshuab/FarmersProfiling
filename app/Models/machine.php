<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Machine extends Model
{
    use HasFactory;


    protected $table = 'machine';

    protected $fillable = [
        'machine'
    ];

    public function machineries()
    {
        return $this->hasMany(Machineries::class, 'machine_id');
    }
}
