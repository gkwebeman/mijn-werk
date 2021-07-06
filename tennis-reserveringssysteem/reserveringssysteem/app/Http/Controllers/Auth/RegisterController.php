<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\Club;
use App\Models\Clubs;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data,
        [
            'firstname' => ['required', 'string', 'max:255'],
            'prefix' => ['string', 'max:255', 'nullable'],
            'lastname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'clubNumber' => ['required', 'exists:clubs,number'],
            'member' => ['required'],
        ],
        [
            'firstname.required' => 'Dit veld is verplicht.',
            'firstname.max' => 'Voornaam mag niet meer dan 255 tekens zijn.',
            'prefix.max' => 'Tussenvoegel mag niet meer dan 255 tekens zijn.',
            'lastname.required' => 'Dit veld is verplicht.',
            'lastname.max' => 'Achternaam mag niet meer dan 255 tekens zijn.',
            'email.required' => 'Dit veld is verplicht.',
            'email.email' => 'Het moet een geldig emailadres zijn.',
            'email.unique' => 'Dit emailadres is al in gebruik.',
            'email.max' => 'Email mag niet meer dan 255 tekens zijn.',
            'password.required' => 'Dit veld is verplicht.',
            'password.min' => 'Wachtwoord moet uit minimaal 8 tekens bestaan.',
            'password.confirmed' => 'Wachtwoorden komen niet overeen.',
            'clubNumber.required' => 'Dit veld is verplicht.',
            'clubNumber.exists' => 'Dit is geen geldig clubnummer',
            'member.required' => 'Dit veld is verplicht.',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $clubs_id = Club::where('number', $data['clubNumber'])->value('id');

        return User::create([
            'firstname' => $data['firstname'],
            'prefix' => $data['prefix'],
            'lastname' => $data['lastname'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'member' => $data['member'],
            'roles_id' => 3,
            'clubs_id' => $clubs_id,
        ]);
    }
}
