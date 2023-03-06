<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Scout\Searchable;

class Animal extends Model
{
    use HasFactory, Notifiable, SoftDeletes, Searchable;

    protected $fillable = [
        'user_id',
        'category_id',
        'name',
        'breed',
        'gender',
        'status',
    ];

    /**
     * Get the name of the index associated with the model.
     *
     * @return string
     */
    public function searchableAs()
    {
        return 'animals_index';
    }

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        $array = $this->toArray();
        $array = $this->transform($array);

        $array['category'] = $this->category->name;

        // Customize the data array...

        return $array;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function transfer()
    {
        return $this->hasMany(Transfer::class, 'animal_id');
    }

    public function scopeGetAnimalWithCategory($query, $condition)
    {
        return $query->addSelect([
            'category' => Category::select('name')
                ->whereColumn('id', '=', 'animals.category_id')
        ])->where($condition);
    }
    public function scopeGetAnimalWithOwner($query, $animal_id)
    {
        return $query->select('id', 'user_id', 'category_id', 'name', 'breed', 'gender', 'pedigree', 'status', 'birth_date', 'color', 'weight', 'description')
            ->addSelect([
                'owner_name' => User::select('name')
                    ->whereColumn('id', '=', 'animals.user_id')
            ])->addSelect([
                'owner_surname' => User::select('surname')
                    ->whereColumn('id', '=', 'animals.user_id')
            ])->addSelect([
                'owner_phone' => User::select('phone_number')
                    ->whereColumn('id', '=', 'animals.user_id')
            ])->addSelect([
                'owner_email' => User::select('email')
                    ->whereColumn('id', '=', 'animals.user_id')
            ])->where('id', '=', $animal_id);
    }
}
