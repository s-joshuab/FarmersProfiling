<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FarmersProfile extends Model
{
    use HasFactory;

    protected $table = 'farmersprofile';

    protected $fillable = [
        'ref_no',
        'status',
        'sname',
        'fname',
        'mname',
        'ename',
        'sex',
        'spouse',
        'mother',
        'number',
        'emergency',
        'regions',
        'provinces_id',
        'municipalities_id',
        'barangays_id',
        'purok',
        'house',
        'dob',
        'pob',
        'religion',
        // 'cstatus',
        'civil_status_id',
        'highest_formal_education_id',
        'pwd',
        'benefits',
        'livelihood',
        'gross',
        'grosses',
        'parcels',
        'arb',
      //  'crops_id',
        //'machineries_id'
    ];
    public function crops()
    {
        return $this->hasMany(crops::class, 'farmersprofile_id');
    }

    public function benefits()
    {
        return $this->hasMany(Benefits::class, 'farmersprofile_id');
    }

    public function user()
{
    return $this->belongsTo(User::class);
}

    // public function province()
    // {
    //     return $this->belongsTo(Provinces::class, 'provinces_id');
    // }

    // public function municipality()
    // {
    //     return $this->belongsTo(Municipalities::class, 'municipalities_id');
    // }

    public function barangay()
    {
        return $this->belongsTo(Barangays::class, 'barangays_id');
    }

    public function others()
    {
        return $this->hasMany(Others::class, 'farmersprofile_id');
    }

    public function civil_status()
    {
        return $this->belongsTo(Status::class, 'civil_status_id');
    }

    public function highest_formal_education()
    {
        return $this->belongsTo(HighestFormalEducation::class, 'highest_formal_education_id');
    }


    public function machineries()
    {
        return $this->hasMany(machineries::class, 'farmersprofile_id');
    }

    public function commodities()
    {
        return $this->belongsToMany(Commodities::class);
    }

    public function farmersNumbers()
    {
        return $this->hasMany(FarmersNumber::class, 'farmersprofile_id');
    }

    public function qrCode()
    {
        return $this->hasOne(QrCode::class, 'farmersprofile_id');
    }


}
