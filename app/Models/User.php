<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Middlewares\RoleMiddleware;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'surname',
        'email',
        'password',
        'surname',
        'address',
        'city',
        'phone_number',
        'pet',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'pet' => 'array'
    ];

    public function animal()
    {
        return $this->hasMany(Animal::class, 'user_id');
    }

    public function transfer()
    {
        return $this->hasMany(Transfer::class, 'user_id');
    }

    public function transfer1()
    {
        return $this->hasMany(Transfer::class, 'adopter_user_id');
    }

    public function scopeGetAllUsers($query)
    {
        return $query->select('id','name','surname','phone_number','email','address','city')
            ->where('id','!=',Auth::user()->id);
    }
}
