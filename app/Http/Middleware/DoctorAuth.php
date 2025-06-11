<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class DoctorAuth
{
    public function handle(Request $request, Closure $next)
    {
        if (!session()->has('doctor_id')) {
            return redirect()->route('doctor.login');
        }
        return $next($request);
    }
}
