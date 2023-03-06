<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('List of animals') }}
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

                    <h6 class="pb-3">Do you have an animal for adoption? Add it here.
                        <span class="label label-default">
                            <a href="{{ route('animal.create') }}" class="btn btn-primary" role="button"
                                aria-pressed="true">Add animal</a>
                        </span>
                    </h6>

                    <h4>Filter animals</h4>
                    <div class="row">
                        <div class="col-9">
                            <form action="{{ route('animal.filter') }}" method="POST">
                                @csrf
                                <div class="row pb-5">
                                    <div class="col-3">
                                        <label for="category">Category</label>
                                        <select class="form-control" name="category" id="category">
                                            <option value="all_categories" selected>All categories</option>
                                            @foreach ($categories as $category)
                                                <option value={{ $category->id }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-3">
                                        <label for="gender">Gender</label>
                                        <select class="form-control" name="gender" id="gender">
                                            <option value="all_genders" selected>All genders</option>
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>
                                        </select>
                                    </div>
                                    <div class="col-3">
                                        <label for="animal_status">Animal status</label>
                                        <select class="form-control" name="animal_status" id="animal_status">
                                            <option value="all_statuses" selected>All statuses</option>
                                            <option value="giving_away">Giving away</option>
                                            <option value="adopting">Adopting</option>
                                            <option value="in_process">In process</option>
                                        </select>
                                    </div>
                                    <div class="col-3" style="margin-top: 30px">
                                        <button type="submit" class="btn btn-secondary">Apply filters</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-3">
                            <form class="form-inline" style="margin-top: 30px" action="{{ route('animal.search') }}" method="GET">
                                <input class="form-control mr-sm-2 w-50" type="search" placeholder="Search"
                                    aria-label="Search" name="search">
                                <button class="btn btn-outline-success my-2 my-sm-0 " type="submit">Search</button>
                            </form>
                        </div>
                    </div>

                    <table class="table table-striped table-bordered">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Name</th>
                                <th scope="col">Breed</th>
                                <th scope="col">Category</th>
                                <th scope="col">Gender</th>
                                <th scope="col">Pedigree</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                        </thead>
                        <tbody>
                            @foreach ($animals as $animal)
                                @if ($animal->status != 'adopted' || ($animal->status == 'adopted' && $animal->user_id == Auth::user()->id))
                                    <tr>
                                        <td>{{ $animal->name }}</td>
                                        <td>{{ $animal->breed }}</td>
                                        <td>{{ $animal->category }}</td>
                                        <td>{{ $animal->gender }}</td>
                                        <td>{{ $animal->pedigree }}</td>
                                        <td>{{ ucfirst(str_replace('_', ' ', $animal->status)) }}</td>
                                        <td>
                                            <form class="d-inline" method="GET"
                                                action="{{ route('animal.show', ['animal' => $animal->id]) }}">
                                                <button type="submit" class="btn btn-info">Show more</button>
                                            </form>
                                            @if ($animal->status == 'giving_away' && $animal->user_id != optional(Auth::user())->id)
                                                <form class="d-inline" method="GET"
                                                    action="{{ route('animal.adopt', ['animal' => $animal->id, 'user_id' => $animal->user_id]) }}">
                                                    <button type="submit" class="btn btn-success">Adopt</button>
                                                </form>
                                            @endif
                                            @can('edit-animal')
                                                <form class="d-inline float-right" method="POST"
                                                    action="{{ route('animal.destroy', ['animal' => $animal->id]) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger d-inline"
                                                        onclick="return confirm('Are you sure you want delete this animal?')"><i
                                                            class="fa fa-trash" aria-hidden="true"></i></button>
                                                </form>
                                            @endcan
                                            @cannot('edit-animal')
                                                @if ($animal->user_id == optional(Auth::user())->id)
                                                    <form class="d-inline float-right" method="POST"
                                                        action="{{ route('animal.destroy', ['animal' => $animal->id]) }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-outline-danger d-inline"
                                                            onclick="return confirm('Are you sure you want delete this animal?')"><i
                                                                class="fa fa-trash" aria-hidden="true"></i></button>
                                                    </form>
                                                @endif
                                            @endcannot


                                        </td>
                                    </tr>
                                @endif
                            @endforeach

                        </tbody>
                    </table>
                </div>
                <div class="pagination justify-content-center">
                    {{ $animals->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
