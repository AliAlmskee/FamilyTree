<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Middleware\RequireSitePassword;
use App\Models\Configuration;
use Illuminate\Http\Request;

class SiteGateController extends Controller
{
    /**
     * Show the site password gate form.
     */
    public function show()
    {
        return view('site-gate');
    }

    /**
     * Verify the gate password and allow access.
     */
    public function verify(Request $request)
    {
        $request->validate([
            'gate_password' => 'required|string',
        ]);

        $stored = Configuration::get(RequireSitePassword::CONFIG_KEY);

        if (empty($stored)) {
            return redirect()->route('site-gate')
                ->withErrors(['gate_password' => 'لم يتم تعيين كلمة مرور للموقع.']);
        }

        if ($request->gate_password !== $stored) {
            return redirect()->back()
                ->withErrors(['gate_password' => 'كلمة المرور غير صحيحة.'])
                ->withInput();
        }

        $request->session()->put(RequireSitePassword::SESSION_KEY, true);

        return redirect()->intended('/');
    }
}
