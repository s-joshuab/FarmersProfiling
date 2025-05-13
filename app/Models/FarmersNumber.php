<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

class FarmersNumber extends Model
{
    use HasFactory;

    protected $primaryKey = 'farmersnumber'; // Specify the new primary key

    protected $fillable = [
        'barangays_id',
        'farmersprofile_id',
        'farmersnumber',
    ];

    public $incrementing = false; // Set to false to prevent auto-incrementing

    protected $keyType = 'string'; // Specify the key type as string if farmersnumber is string

    public $timestamps = false; // If you don't have created_at and updated_at columns

    protected $table = 'farmersnumber';

    public function farmersprofile()
    {
        return $this->belongsTo(FarmersProfile::class, 'farmersprofile_id');
    }

    public function barangay()
    {
        return $this->belongsTo(Barangays::class, 'barangays_id');
    }
}
