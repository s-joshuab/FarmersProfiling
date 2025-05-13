<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Activitylog\LogOptions;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Activitylog\Models\Activity;

class User extends Authenticatable
{

    use HasApiTokens, HasFactory, Notifiable;
    use LogsActivity;
    use Notifiable;

    protected static $logAttributes = ['name', 'username', 'email', 'password'];

    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'image',
        'username',
        'email',
        'password',
        'phone_number',
        'status',
        'user_type',
        'provinces_id',
        'municipalities_id',
        'barangays_id'
    ];
    public function province()
    {
        return $this->belongsTo(Provinces::class, 'provinces_id');
    }

    public function municipality()
    {
        return $this->belongsTo(Municipalities::class, 'municipalities_id');
    }

    public function barangay()
    {
        return $this->belongsTo(Barangays::class, 'barangays_id');
    }

    public function farmerProfile()
{
    return $this->hasOne(FarmersProfile::class);
}

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**activ
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    static public function getEmailSingle($email)
    {
        return User::where('email', '=', $email)->first();
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'username', 'email', 'password']);
    }

    public function activity(){
        return $this->hasMany(Activity::class, 'causer_id');
    }

    public function causer()
    {
        return $this->belongsTo(User::class, 'causer_id');
    }

}

