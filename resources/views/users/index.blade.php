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

                    <h4 class="pt-10 pb-2">Registered users</h4>
                    <table class="table table-striped table-bordered table-responsive">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Name</th>
                                <th scope="col">Surname</th>
                                <th scope="col">Phone number</th>
                                <th scope="col">Email</th>
                                <th scope="col">Address</th>
                                <th scope="col">City</th>
                                <th scope="col">Action</th>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->surname }}</td>
                                    <td>{{ $user->phone_number }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->address }}</td>
                                    <td>{{ $user->city }}</td>
                                    <td>
                                        @if ($user->hasRole('guest'))
                                            <form class="d-inline" method="POST"
                                                action="{{ route('user.assignAdmin', ['user_id' => $user->id]) }}">
                                                @csrf
                                                <button type="submit" class="btn btn-success">Make admin</button>
                                            </form>
                                        @endif
                                        @if ($user->hasRole('admin'))
                                            <form class="d-inline" method="POST"
                                                action="{{ route('user.assignGuest', ['user_id' => $user->id]) }}">
                                                @csrf
                                                <button type="submit" class="btn btn-success">Make guest</button>
                                            </form>
                                        @endif
                                        <form class="d-inline" method="POST"
                                            action="{{ route('user.destroy', ['user' => $user->id]) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger"
                                                onclick="return confirm('Are you sure you want delete this user?')">Delete</button>
                                        </form>
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
