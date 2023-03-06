<?php

namespace App\Http\Repositories;

use App\Http\Interfaces\AnimalInterface;
use App\Http\Requests\AnimalRequest;
use App\Mail\AnimalMailable;
use App\Models\Animal;
use App\Models\Category;
use App\Models\Transfer;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class AnimalRepository implements AnimalInterface
{

    protected $animalModel;

    public function __construct(Animal $animal)
    {
        $this->animalModel = $animal;
    }


    public function getAnimals()
    {
        $animals = Animal::GetAnimalWithCategory([])->paginate(15);

        Cache::put('animals',$animals);
        $cachedAnimals=Cache::get('animals');

        $categories=Category::select('id','name','description')->get();
        return ['animals' => $cachedAnimals, 'categories' => $categories];
    }

    public function createAnimal()
    {
        return Category::select('id','name','description')->get();
    }
    public function saveAnimal(AnimalRequest $request)
    {
        // Animal::create($request->all());  //uvek cuva pedigree:yes
        $animal = new Animal();
        $animal->user_id = $request->user_id;
        $animal->name = $request->name;
        $animal->category_id = $request->category_id;
        $animal->breed = $request->breed;
        $animal->gender = $request->gender;
        $animal->pedigree = $request->pedigree;
        $animal->status = $request->status;
        $animal->birth_date = $request->birth_date;
        $animal->color = $request->color;
        $animal->weight = $request->weight;
        $animal->description = $request->description;
        $animal->save();
        $animal->searchable();
    }
    public function showAnimalDetails($animal_id)
    {
        $animal=Animal::GetAnimalWithOwner($animal_id)->first();
        $categories = Category::select('id','name','description')->get();

        return ['animal' => $animal, 'categories' => $categories];
    }
    public function updateAnimal(AnimalRequest $request, $animal_id)
    {
        Animal::where('id', '=', $animal_id)->update([
            'name' => $request->name,
            'breed' => $request->breed,
            'category_id' => $request->category_id,
            'gender' => $request->gender,
            'pedigree' => $request->pedigree,
            'status' => $request->status,
            'birth_date' => $request->birth_date,
            'color' => $request->color,
            'weight' => $request->weight,
            'description' => $request->description,
        ]);
        Animal::where('id', '=', $animal_id)->searchable();
    }
    public function deleteAnimal($animal_id)
    {
        Animal::where('id', '=', $animal_id)->unsearchable();
        return Animal::where('id', $animal_id)->delete();
    }

    public function adoptAnimal($animal_id,$user_id)
    {
        $transfer=new Transfer();
        $transfer->owner_id=$user_id;
        $transfer->adopter_user_id=Auth::user()->id;
        $transfer->animal_id=$animal_id;
        $transfer->status='request_sent';
        $transfer->save();
        Animal::where('id','=',$animal_id)->update(['status'=>'in_process']);

        $animal=Animal::GetAnimalWithOwner($animal_id)->first();
        Mail::to($animal->owner_email)->send(new AnimalMailable($animal));
    }

    public function filterAnimals($request)
    {
        $condition=[];
        if($request->category!="all_categories"){
            $condition+=['animals.category_id'=>$request->category];
        }
        if($request->gender!='all_genders'){
            $condition+=['animals.gender'=>$request->gender];
        }
        if($request->animal_status!='all_statuses'){
            $condition+=['animals.status'=>$request->animal_status];
        }
        $animals=Animal::GetAnimalWithCategory($condition)->paginate(15);
        $categories=Category::select('id','name','description')->get();
        return ['animals' => $animals, 'categories' => $categories];
    }

    public function searchAnimals($request)
    {
        $animals = Animal::search($request->search)->paginate(15);
        $categories=Category::select('id','name','description')->get();
        return ['animals' => $animals, 'categories' => $categories];
    }
}
