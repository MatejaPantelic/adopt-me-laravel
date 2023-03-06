<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;


class Category extends Model
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name',
    ];

    public function animal()
    {
        return $this->hasMany(Animal::class, 'category_id');
    }
}
