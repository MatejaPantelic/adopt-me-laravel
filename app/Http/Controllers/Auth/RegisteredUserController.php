<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'phone_number' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            // 'pet.adopting' => ['exclude_with:pet.giving_away'],
            // 'pet.giving_away' => ['exclude_with:pet.adopting'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'password' => ['required'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'surname'=> $request->surname,
            'phone_number'=>$request->phone_number,
            'address'=> $request->address,
            'city'=> $request->city,
            'email' => $request->email,
            // 'pet' => $this->getPet($request),
            'password' => Hash::make($request->password),

        ])->assignRole('guest');

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }

    /**
     * @param Request $request
     * @return array
     */
    // private function getPet(Request $request): array
    // {
    //     $pet = [];

    //     if (isset($request->pet)) {
    //         $values = $request->pet;
    //     }

    //     if (isset($values['adopting'])) {
    //         $pet[] = 'adopting';
    //     }

    //     if (isset($values['giving_away'])) {
    //         $pet[] = 'giving_away';
    //     }

    //     return $pet;
    // }

}
