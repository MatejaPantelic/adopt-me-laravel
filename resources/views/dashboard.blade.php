<style>
    .homepage-image
    {
        background-image: url({{public_path("PasNaslovna.jpg")}});
    }

    .rows--3
      {
        display: grid;
        place-items: center;
        grid-template-columns: 1fr 1fr 1fr;
      }

    .round-image
    {
        border-radius: 50%;
        --circle-radius: 300px;
        height: var(--circle-radius);
        width: var(--circle-radius);
        line-height: var(--circle-radius);
        object-fit: contain;
        border: 2px solid #8d9ab3;
    }
</style>
{{--@dd($animals)--}}
@php
function getPictureName($animalType)
{
    //if($animalType === "dog")
        return "PasNaslovna.jpg";
}
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 homepage-image">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900" style="text-align-size: 32px">
                    <p style="text-align:center">Adopt your new best friend!!!</p>
                </div>
                <div class="rows--3">
                    @foreach($animals as $animal)
                        <div>
{{--                            <img src="{{getPictureName($animal)}}" alt="">--}}
                            @if($animal === "dog")
                                <img src="{{asset("PasNaslovna.jpg")}}" class="round-image" alt="">
                            @endif
                            @if($animal === "cat")
                                <img src="{{asset("cat_image.jpg")}}" class="round-image" alt="">
                            @endif
                            @if($animal === "lizard")
                                <img src="{{asset("Lizard_image.jpg")}}" class="round-image" alt="">
                            @endif
                                <a href="#">See all {{$animal}}s</a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
