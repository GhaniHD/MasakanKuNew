<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.dashboard');
    }

    public function userRecipes()
    {
        $users = User::with('recipes')->get();
        return view('admin.user_recipes', compact('users'));
    }
}

