<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('List of categories') }}
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
                    @can('edit-categories')
                        <h4 class="pb-2">Create new category </h4>
                        <form class="form-inline" method="POST" action="{{ route('category.store') }}">
                            @csrf
                            <div class="form-group mb-2">
                                <label for="name">Name: </label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="breed" name="name" id="name" value="{{ old('name') }}">
                            </div>
                            <div class="form-group mx-sm-3 mb-2">
                                <label for="description">Description: </label>
                                <input type="text" class="form-control" name="description" id="description"
                                    value="{{ old('description') }}">
                            </div>
                            <button type="submit" class="btn btn-primary mb-2">Create</button>
                        </form>
                    @endcan
                    <h4 class="pt-10 pb-2">Existing categories </h4>
                    <table class="table table-striped table-bordered ">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Description</th>
                                @can('edit-categories')
                                    <th scope="col">Action</th>
                                @endcan

                        </thead>
                        <tbody>
                            @foreach ($categories as $category)
                                <tr>
                                    <td>{{ $category->id }}</td>
                                    <td>{{ $category->name }}</td>
                                    <td>{{ $category->description }}</td>
                                    @can('edit-categories')
                                        <td align="center">
                                            <form class="d-inline" method="POST"
                                                action="{{ route('category.destroy', ['category' => $category->id]) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger w-50"
                                                    onclick="return confirm('Are you sure you want delete this category?')">Delete</button>
                                            </form>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
