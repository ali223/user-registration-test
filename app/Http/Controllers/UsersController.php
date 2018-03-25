<?php

namespace App\Http\Controllers;

use App\Mail\ActivationEmail;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class UsersController extends Controller
{
    public function showLoginForm()
    {
        return view('users.login-form');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'email',
            'password' => 'min:5'
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if (auth()->attempt($credentials)) {
            return redirect()->route('dashboard');
        }

        if ($user) {
            return redirect()
                ->route('login')
                ->withErrors('Invalid Password')
                ->withInput();
        }

        $user = $this->createUser($request);

        auth()->login($user);

        Mail::to($user)->send(new ActivationEmail($user));

        return redirect()->route('dashboard');
    }

    public function logout()
    {
        auth()->logout();

        return redirect()->route('login');
    }

    public function activate(Request $request)
    {
        $user = User::where('activation_token', $request->input('token'))->first();

        if (! $user) {        
            return redirect()->route('dashboard')
                            ->with('message', 'Error activating your account'); 
        }

        $user->activate();

        if (auth()->check()) {
            return redirect()
                ->route('dashboard')
                ->with('message', 'Account activated successfully');            
        }

        return redirect()
            ->route('login')
            ->with('message', 'Account activated successfully');
    }

    protected function createUser(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'email|unique:users',
            'password' => 'min:5'
        ]);

        return User::create([
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
            'activation_token' => str_random()
        ]);
    }
}
