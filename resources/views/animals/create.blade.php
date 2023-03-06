<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add your animal') }}
        </h2>
        @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if ($action == 'create')
                        <form method="POST" action="{{ route('animal.store') }}">
                            @csrf
                        @else
                            <form method="POST" action="{{ route('animal.update', ['animal' => $animal->id]) }}">
                                @csrf
                                @method('PUT')
                                <p class="pt-5 mb-0 text-info">Animal information</p>
                                <hr class="mt-0">
                    @endif

                    <div class="form-group">
                        <input id="user_id" type="hidden" class="form-control" name="user_id"
                            value="{{ optional(Auth::user())->id }}" autocomplete="user_id" autofocus>
                    </div>
                    <div class="form-group">
                        <label for="name">Name of animal</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                            name="name" value="{{ $animal->name ?? old('name') }}">
                        @error('name')
                            <p class="text-danger">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="breed">Breed</label>
                        <input type="text" class="form-control @error('breed') is-invalid @enderror" id="breed"
                            name="breed" value="{{ $animal->breed ?? old('breed') }}">
                        @error('breed')
                            <p class="text-danger">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="category_id">Category</label>
                        <select class="form-control" name="category_id" id="category_id">
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    @if (isset($animal) && $category->id == $animal->category_id) selected="selected"
                                        @elseif($category->id == old('category_id')) selected="selected" @endif>
                                    {{ $category->name ?? $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @if ($action == 'create')
                            @can('edit-categories')
                                <small id="emailHelp" class="form-text text-muted">Category does not exist? Create it <a
                                        href="{{ route('category.index') }}"> here</a></small>
                            @endcan
                        @endif
                    </div>
                    <p>Gender</p>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="gender" id="male" value="male"
                            @if (isset($animal->gender) && $animal->gender == 'male') checked @endif>
                        <label class="form-check-label" for="male">Male</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="gender" id="female" value="female"
                            @if (isset($animal->gender) && $animal->gender == 'female') checked @endif>
                        <label class="form-check-label" for="female">Female</label>
                    </div>
                    @error('gender')
                        <p class="text-danger">
                            {{ $message }}
                        </p>
                    @enderror
                    <br><br>
                    <p>Pedigree</p>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="pedigree" id="yes" value="yes"
                            @if (isset($animal->pedigree) && $animal->pedigree == 'yes') checked @endif>
                        <label class="form-check-label" for="yes">Yes</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="pedigree" id="no" value="no"
                            @if (isset($animal->pedigree) && $animal->pedigree == 'no') checked @endif>
                        <label class="form-check-label" for="no">No</label>
                    </div>
                    @error('pedigree')
                        <p class="text-danger">
                            {{ $message }}
                        </p>
                    @enderror
                    <br><br>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select class="form-control" name="status" id="status">
                            <option value="adopting" @if (isset($animal->status) && $animal->status == 'adopting') selected @endif>
                                Adopting
                            </option>
                            <option value="giving_away" @if (isset($animal->status) && $animal->status == 'giving_away') selected @endif>
                                Giving away
                            </option>
                            @if (isset($animal->status) && $animal->status == 'adopted')
                                <option value="adopted" selected>
                                    Adopted
                                </option>
                            @elseif(isset($animal->status) && $animal->status == 'in_process')
                                <option value="in_process" selected>
                                    In process
                                </option>
                            @endif
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="birth_date">Birth date</label>
                        <input type="date" class="form-control @error('birth_date') is-invalid @enderror"
                            id="birth_date" name="birth_date"
                            @if (isset($animal->birth_date)) value={{ $animal->birth_date }}>
                            @else
                                value="{{ old('birth_date') ? old('birth_date') : date('Y-m-d') }}"> @endif
                            @error('birth_date')
                            <p class="text-danger">
                                {{ $message }}
                            </p>
                        @enderror
                            </div>
                        <div class="form-group">
                            <label for="color">Color</label>
                            <input type="text" class="form-control  @error('color') is-invalid @enderror"
                                id="color" name="color" value="{{ $animal->color ?? old('color') }}">
                            @error('color')
                                <p class="text-danger">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="weight">Weight</label>
                            <input type="text" class="form-control  @error('weight') is-invalid @enderror"
                                id="weight" name="weight" value="{{ $animal->weight ?? old('weight') }}">
                            @error('weight')
                                <p class="text-danger">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="description">Description </label>
                            <input type="text" class="form-control  @error('description') is-invalid @enderror"
                                id="description" name="description"
                                value="{{ $animal->description ?? old('description') }}">
                            @error('description')
                                <p class="text-danger">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        @if ($action == 'update')
                            <p class="pt-5 mb-0 text-info">Owner information</p>
                            <hr class="mt-0">
                            <div class="form-group">
                                <label for="owner_name">Owner name </label>
                                <input type="text" class="form-control" id="owner_name" name="owner_name"
                                    value="{{ $animal->owner_name . ' ' . $animal->owner_surname ?? old('owner_name') }}"
                                    disabled>
                            </div>
                            <div class="form-group">
                                <label for="owner_email">Owner email </label>
                                <input type="text" class="form-control" id="owner_email" name="owner_email"
                                    value="{{ $animal->owner_email ?? old('owner_email') }}" disabled>
                            </div>
                            <div class="form-group">
                                <label for="owner_phone">Owner phone </label>
                                <input type="text" class="form-control" id="owner_phone" name="owner_phone"
                                    value="{{ $animal->owner_phone ?? old('owner_phone') }}" disabled>
                            </div>
                        @endif

                        <a href="{{ url()->previous() }}" class="btn btn-secondary" role="button"
                            aria-pressed="true">Back</a>

                        @if ($action == 'create')
                            <button type="submit" class="btn btn-primary float-right">Create</button>
                        @else
                            @can('edit-animal')
                                <button type="submit" class="btn btn-primary float-right">Update</button>
                            @else
                                @if ($animal->user_id == Auth::user()->id)
                                    <button type="submit" class="btn btn-primary float-right">Update</button>
                                @endif
                            @endcan

                        @endif

                        </form>
                    </div>
                </div>
            </div>
        </div>
</x-app-layout>
