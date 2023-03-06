<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;

class Transfer extends Model
{
    use HasFactory, Notifiable, SoftDeletes;


    /**
     * @var string[]
     */
    protected $fillable = [
        'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function animal()
    {
        return $this->belongsTo(Animal::class);
    }

    public function scopeGetTransferWithDetails($query)
    {
        return $query->select('id','owner_id','adopter_user_id','animal_id','status')
        ->addSelect([
            'owner_name' => User::select('name')
                ->whereColumn('id', '=', 'transfers.owner_id')
        ])->addSelect([
            'owner_surname' => User::select('surname')
                ->whereColumn('id', '=', 'transfers.owner_id')
        ])->addSelect([
            'owner_phone' => User::select('phone_number')
                ->whereColumn('id', '=', 'transfers.owner_id')
        ])->addSelect([
            'owner_email' => User::select('email')
                ->whereColumn('id', '=', 'transfers.owner_id')
        ])->addSelect([
            'adopter_name' => User::select('name')
                ->whereColumn('id', '=', 'transfers.adopter_user_id')
        ])->addSelect([
            'adopter_surname' => User::select('surname')
                ->whereColumn('id', '=', 'transfers.adopter_user_id')
        ])->addSelect([
            'adopter_phone' => User::select('phone_number')
                ->whereColumn('id', '=', 'transfers.adopter_user_id')
        ])->addSelect([
            'adopter_email' => User::select('email')
                ->whereColumn('id', '=', 'transfers.adopter_user_id')
        ])->addSelect([
            'animal_name' => Animal::select('name')
                ->whereColumn('id', '=', 'transfers.animal_id')
        ])->addSelect([
            'animal_gender' => Animal::select('gender')
                ->whereColumn('id', '=', 'transfers.animal_id')
        ]) ->addSelect([
            'animal_pedigree' => Animal::select('pedigree')
                ->whereColumn('id', '=', 'transfers.animal_id')
        ])->addSelect([
            'category_id' => Animal::select('category_id')
                ->whereColumn('id','=','transfers.animal_id')
        ])->addSelect([
            'animal_category' => Category::select('name')
                ->whereColumn('id', '=', 'category_id')
        ]);
    }
}
