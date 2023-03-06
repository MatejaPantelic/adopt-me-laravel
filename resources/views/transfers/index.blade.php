<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Requests') }}
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

                    @can('transfers')
                        <h4>All requests</h4>
                        <table class="table table-striped table-bordered table-responsive">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col" colspan="2" class="text-center">Request from</th>
                                    <th scope="col" colspan="2" class="text-center">Request to</th>
                                    <th scope="col" colspan="3" class="text-center">About animal</th>
                                    <th scope="col" colspan="2" class="text-center">About transfer</th>
                            </thead>
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Animal name</th>
                                    <th scope="col">Category</th>
                                    <th scope="col">Gender</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                            </thead>
                            <tbody>
                                @foreach ($transfers as $transfer)
                                        <tr>
                                            <td>{{ $transfer->adopter_name . ' ' . $transfer->adopter_surname }}</td>
                                            <td>{{ $transfer->adopter_email }}</td>
                                            <td>{{ $transfer->owner_name . ' ' . $transfer->owner_surname }}</td>
                                            <td>{{ $transfer->owner_email }}</td>
                                            <td>{{ $transfer->animal_name }}</td>
                                            <td>{{ $transfer->animal_category }}</td>
                                            <td>{{ $transfer->animal_gender }}</td>
                                            <td>{{ ucfirst(str_replace('_', ' ', $transfer->status))  }}</td>
                                            <td>
                                                <form class="d-inline" method="POST"
                                                        action="{{ route('transfer.destroy', ['transfer_id' => $transfer->id, 'animal_id' => $transfer->animal_id]) }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger"
                                                            onclick="return confirm('Are you sure you want delete this transfer?')">
                                                            Delete</button>
                                                    </form>
                                            </td>
                                        </tr>
                                @endforeach

                            </tbody>
                        </table>
                    @endcan
                    @cannot('transfers')
                        <h4>Requests recived</h4>
                        <table class="table table-striped table-bordered">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col" colspan="3" class="text-center">Request from</th>
                                    <th scope="col" colspan="5" class="text-center">About animal</th>
                            </thead>
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Name</th>
                                    <th scope="col">Phone</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Animal name</th>
                                    <th scope="col">Category</th>
                                    <th scope="col">Gender</th>
                                    <th scope="col">Pedigree</th>
                                    <th scope="col">Action</th>
                            </thead>
                            <tbody>
                                @foreach ($transfers as $transfer)
                                    @if ($transfer->owner_id == Auth::user()->id && $transfer->status == 'request_sent')
                                        <tr>
                                            <td>{{ $transfer->adopter_name . ' ' . $transfer->adopter_surname }}</td>
                                            <td>{{ $transfer->adopter_phone }}</td>
                                            <td>{{ $transfer->adopter_email }}</td>
                                            <td>{{ $transfer->animal_name }}</td>
                                            <td>{{ $transfer->animal_category }}</td>
                                            <td>{{ $transfer->animal_gender }}</td>
                                            <td>{{ $transfer->animal_pedigree }}</td>
                                            <td>
                                                <form class="d-inline" method="POST"
                                                    action="{{ route('transfer.accept', [
                                                        'transfer_id' => $transfer->id,
                                                        'adopter_id' => $transfer->adopter_user_id,
                                                        'animal_id' => $transfer->animal_id,
                                                    ]) }}">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success">Accept</button>
                                                </form>
                                                <form class="d-inline" method="POST"
                                                    action="{{ route('transfer.deny', [
                                                        'transfer_id' => $transfer->id,
                                                        'adopter_id' => $transfer->adopter_user_id,
                                                        'animal_id' => $transfer->animal_id,
                                                    ]) }}">
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger">Deny</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach

                            </tbody>
                        </table>

                        <h4>Send requests</h4>
                        <table class="table table-striped table-bordered">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col" colspan="3" class="text-center">Request to</th>
                                    <th scope="col" colspan="5" class="text-center">About animal</th>
                            </thead>
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Name</th>
                                    <th scope="col">Phone</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Animal name</th>
                                    <th scope="col">Category</th>
                                    <th scope="col">Gender</th>
                                    <th scope="col">Pedigree</th>
                                    <th scope="col">Action</th>
                            </thead>
                            <tbody>
                                @foreach ($transfers as $transfer)
                                    @if ($transfer->adopter_user_id == Auth::user()->id)
                                        <tr>
                                            <td>{{ $transfer->owner_name . ' ' . $transfer->owner_surname }}</td>
                                            <td>{{ $transfer->owner_phone }}</td>
                                            <td>{{ $transfer->owner_email }}</td>
                                            <td>{{ $transfer->animal_name }}</td>
                                            <td>{{ $transfer->animal_category }}</td>
                                            <td>{{ $transfer->animal_gender }}</td>
                                            <td>{{ $transfer->animal_pedigree }}</td>
                                            <td>
                                                @if ($transfer->status == 'request_sent')
                                                    <form class="d-inline" method="POST"
                                                        action="{{ route('transfer.destroy', ['transfer_id' => $transfer->id, 'animal_id' => $transfer->animal_id]) }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-secondary"
                                                            onclick="return confirm('Are you sure you want cancel this request?')">
                                                            Cancel request</button>
                                                    </form>
                                                @elseif ($transfer->status == 'request_denied')
                                                    <span class="text-danger">Request was denied.</span>
                                                @elseif ($transfer->status == 'request_accepted')
                                                    <span class="text-success">Request was accepted.</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach

                            </tbody>
                        </table>
                    @endcannot

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
