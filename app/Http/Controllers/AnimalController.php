<?php

namespace App\Http\Controllers;

use App\Http\Repositories\AnimalRepository;
use App\Http\Requests\AnimalRequest;
use App\Models\Animal;
use Illuminate\Http\Request;

class AnimalController extends Controller
{
    protected $animalRepository;

    public function __construct(AnimalRepository $animalRepository)
    {
        $this->animalRepository = $animalRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = $this->animalRepository->getAnimals();
        return view('animals.index')
            ->with([
                'animals' => $data['animals'],
                'categories' => $data['categories']
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = $this->animalRepository->createAnimal();

        return view('animals.create')
            ->with([
                'categories' => $categories,
                'action' => 'create'
            ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(AnimalRequest $request)
    {
        $this->animalRepository->saveAnimal($request);

        return redirect()
            ->route('animal.index')
            ->withSuccess('The animal ' . $request->name . ' was created.');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = $this->animalRepository->showAnimalDetails($id);

        return view('animals.create')
            ->with([
                'animal' => $data['animal'],
                'categories' => $data['categories'],
                'action' => 'update',
            ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(AnimalRequest $request, $id)
    {
        $this->animalRepository->updateAnimal($request, $id);
        return redirect()
            ->route('animal.index')
            ->withSuccess('The animal with id ' . $id . ' was updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ($this->animalRepository->deleteAnimal($id) == true) {
            return  redirect()->back()
                ->withSuccess('The animal with id ' . $id . ' has been deleted.');
        } else {
            return  redirect()->back()
                ->withSuccess('The animal with id ' . $id . ' was not deleted.');
        }
    }

    public function adopt($id, $user_id)
    {
        $this->animalRepository->adoptAnimal($id, $user_id);
        return  redirect()->back()
            ->withSuccess('The request for adopting was sent to the owners email.');
    }

    public function filter(Request $request)
    {
        $data = $this->animalRepository->filterAnimals($request);

        return view('animals.index')
            ->with([
                'animals' => $data['animals'],
                'categories' => $data['categories']
            ]);
    }

    public function search(Request $request)
    {
        $data = $this->animalRepository->searchAnimals($request);
        foreach ($data['animals'] as $animal) {
            foreach ($data['categories'] as $cat) {
                if ($animal->category_id == $cat->id) {
                    $animal->category=$cat->name;
                }
            }
        }
        return view('animals.index')
            ->with([
                'animals' => $data['animals'],
                'categories' => $data['categories']
            ]);
    }
}
