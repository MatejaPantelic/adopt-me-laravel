<?php

namespace App\Http\Interfaces;

use App\Http\Requests\AnimalRequest;

interface AnimalInterface {

    public function getAnimals();
    public function  createAnimal();
    public function  saveAnimal(AnimalRequest $request);
    public function  showAnimalDetails($animal_id);
    public function  updateAnimal(AnimalRequest $request, $animal_id);
    public function  deleteAnimal($animal_id);
    public function  adoptAnimal($animal_id,$user_id);
    public function  filterAnimals($request);
    public function  searchAnimals($request);
}
