<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

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
    protected $redirectTo = '/home';

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
        //dd($data);
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'num_socio' => ['required', 'integer','unique:users'],
            'nome_informal' => ['required','string', 'max:40'],
            'tipo_socio' => ['required','in:P,NP,A'],
            'sexo' => ['required','in:M,F'],
            'data_nascimento' =>['required', 'date']
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'num_socio' => $data['num_socio'],
            'name' => $data['name'],
            'nome_informal' => $data['nome_informal'],
            'password' => Hash::make($data['data_nascimento']),
            'tipo_socio' => $data['tipo_socio'],
            'email' => $data['email'],
            'sexo' => $data['sexo'],
            'data_nascimento' => $data['data_nascimento']
        ]);
    }
}
