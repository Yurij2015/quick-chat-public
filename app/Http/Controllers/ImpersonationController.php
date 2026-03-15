<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class ImpersonationController extends Controller
{
    public function loginAs(User $user): RedirectResponse
    {
        // Store the original admin ID in the session before switching
        session()->put('impersonated_by', Auth::id());

        Auth::login($user);

        return redirect()->route('dashboard');
    }

    public function leave(): RedirectResponse
    {
        if (session()->has('impersonated_by')) {
            $adminId = session()->pull('impersonated_by');
            Auth::loginUsingId($adminId);
        }

        return redirect()->route('dashboard');
    }
}
