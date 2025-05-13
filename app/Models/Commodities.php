<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commodities extends Model
{
    use HasFactory;

    protected $table = 'commodities';

    protected $fillable = [
        'commodities',
        'category',

    ];

    public function crops()
    {
        return $this->hasMany(Crops::class, 'commodities_id');
    }
}
