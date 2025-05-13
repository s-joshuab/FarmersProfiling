<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Crops extends Model
{
    use HasFactory;

    protected $table = 'crops';
    protected $fillable = [
        'commodities_id',
        'farmersprofile_id',
        'farm_size',
        'farm_location',
        'barangays_id',
    ];

    public function farmersProfile()
    {
        return $this->belongsTo(FarmersProfile::class, 'farmersprofile_id'); // Use the correct foreign key column name
    }

    public function commodity()
    {
        return $this->belongsTo(Commodities::class, 'commodities_id');
    }

    public function barangay()
    {
        return $this->belongsTo(Barangays::class, 'barangays_id');
    }

}
