<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // <-- Pastikan model User di-import

class PenggunaController extends Controller
{
       public function index()
    {

        $users = User::latest()->paginate(10);

        
        return view('dashboard-user.users.index', [
            'users' => $users
        ]);
    }


}
