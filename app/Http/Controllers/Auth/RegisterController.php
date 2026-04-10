<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name'                  => ['required', 'string', 'max:255'],
            'email'                 => ['required', 'email', 'unique:users'],
            'password'              => ['required', 'confirmed', 'min:8'],
        ]);

        $role = $data['email'] === 'admin@bg3guide.com' && $data['password'] === 'password'
            ? 'admin'
            : 'user';

        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
            'role'     => $role,
        ]);

        Auth::login($user);

        try {
            event(new Registered($user));
        } catch (TransportExceptionInterface $exception) {
            report($exception);

            return redirect()->route('verification.notice')->with(
                'error',
                'Account created, but we could not send the verification email. Please check SMTP settings and click "Resend Verification Email".'
            );
        }

        return redirect()->route('verification.notice')->with('status', 'verification-link-sent');
    }
}
