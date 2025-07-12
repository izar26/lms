<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
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
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    // app/Http/Controllers/Auth/LoginController.php

// ... (kode yang sudah ada)

/**
 * Where to redirect users after login.
 *
 * @return string
 */
public function redirectTo()
{
    // Ambil peran dari user yang sedang login
    $role_id = auth()->user()->role_id;

    // Tentukan tujuan redirect berdasarkan role_id
    switch ($role_id) {
        case 1: // Administrator
            return '/admin/dashboard';
            break;
        case 2: // Instructor
            return '/instructor/dashboard';
            break;
        default: // Peserta dan lainnya
            return '/home';
            break;
    }
}
}
