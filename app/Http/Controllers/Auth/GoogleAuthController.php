<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    // Redirige al usuario a la página de autenticación de Google.
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

     // Obtener la información del usuario de Google.
    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // Busca un usuario que ya se haya registrado con esta cuenta de Google
            $user = User::where('google_id', $googleUser->id)->first();

            if ($user) {
                // Si el usuario existe, inicia sesión
                Auth::login($user);
                return redirect()->intended('/home');
            }

            // Comprueba si ya existe un usuario con el mismo correo electrónico
            $user = User::where('email', $googleUser->email)->first();

            if ($user) {
                // Si el usuario existe, vincula la cuenta de Google con él
                $user->update(['google_id' => $googleUser->id, 'avatar' => $googleUser->avatar]);
            } else {
                // Si no existe ningún usuario, crea uno nuevo
                $user = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'google_id' => $googleUser->id,
                    'avatar' => $googleUser->avatar,
                    'password' => null, // La contraseña es nula ya que se autentican con Google
                ]);
            }

            // Inicia sesión con el usuario
            Auth::login($user);

            // Redirige a la página de inicio
            return redirect()->intended('/home');

        } catch (Exception $e) {
            return redirect('/login')->with('error', 'Ocurrió un error durante la autenticación con Google.');
        }
    }
}