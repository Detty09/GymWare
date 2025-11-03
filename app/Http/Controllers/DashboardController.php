<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $coaches = User::where('is_coach', true)
            ->where('id', '!=', $user->id)
            ->get();

        return view('dashboard', compact('user', 'coaches'));
    }
}
