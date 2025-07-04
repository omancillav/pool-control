<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class FacebookAuthController extends Controller
{
    //Redirige al usuario a la página de autenticación de Facebook.
    public function redirect()
    {
        return Socialite::driver('facebook')->redirect();
    }

    // Obtener la información del usuario de Facebook.
    public function callback()
    {
        try {
            $facebookUser = Socialite::driver('facebook')->user();

            // Busca un usuario que ya se haya registrado con esta cuenta de Facebook
            $user = User::where('facebook_id', $facebookUser->id)->first();

            if ($user) {
                // Si el usuario existe, inicia sesión
                Auth::login($user);
                return redirect()->intended('/home');
            }

            // Comprueba si ya existe un usuario con el mismo correo electrónico
            $user = User::where('email', $facebookUser->email)->first();

            if ($user) {
                // Si el usuario existe, vincula la cuenta de Facebook con él
                $user->update(['facebook_id' => $facebookUser->id, 'avatar' => $facebookUser->avatar]);
            } else {
                // Si no existe ningún usuario, crea uno nuevo
                $user = User::create([
                    'name' => $facebookUser->name,
                    'email' => $facebookUser->email,
                    'facebook_id' => $facebookUser->id,
                    'avatar' => $facebookUser->avatar,
                    'password' => null, // La contraseña es nula ya que se autentican con Facebook
                ]);
            }

            // Inicia sesión con el usuario
            Auth::login($user);

            // Redirige a la página de inicio
            return redirect()->intended('/home');

        } catch (Exception $e) {
            return redirect('/login')->with('error', 'Ocurrió un error durante la autenticación con Facebook.');
        }
    }
}