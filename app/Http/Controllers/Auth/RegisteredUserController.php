<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Invitation;
use App\Models\Person;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(Request $request): View
    {
        $invitation = null;
        
        if ($request->has('token')) {
            $invitation = Invitation::with(['person', 'invitedBy'])
                ->where('token', $request->token)
                ->whereNull('accepted_at')
                ->where('expires_at', '>', now())
                ->firstOrFail();
        }

        return view('auth.register', [
            'invitation' => $invitation
        ]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'invitation_token' => ['sometimes', 'string'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Gestion de l'invitation
        if ($request->filled('invitation_token')) {
            $invitation = Invitation::where('token', $request->invitation_token)
                ->where('email', $request->email)
                ->first();

            if ($invitation) {
                // Associer la personne à l'utilisateur
                Person::where('id', $invitation->person_id)
                    ->update(['user_id' => $user->id]);
                
                // Marquer l'invitation comme acceptée
                $invitation->update(['accepted_at' => now()]);
            }
        }

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}