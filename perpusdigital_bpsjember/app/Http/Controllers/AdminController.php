<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Publikasi;
use App\Models\Kategori;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $userCount = User::count();
        $publicationCount = Publikasi::count();
        $acceptedPublicationCount = Publikasi::where('status', 'diterima')->count();
        $categoryCount = Kategori::count();
        $users = User::with('roles')->latest()->take(7)->get();

        $operatorCount = User::whereHas('roles', function ($query) {
            $query->where('role_name', 'operator');
        })->count();

        $regularUserCount = User::whereHas('roles', function ($query) {
            $query->where('role_name', 'pengguna');
        })->count();

        $publicationsTodayCount = Publikasi::whereDate('created_at', Carbon::today())->count();

        return view('dashboard-user.admin-dashboard', compact(
            'userCount',
            'publicationCount',
            'acceptedPublicationCount',
            'categoryCount',
            'users',
            'operatorCount',
            'regularUserCount',
            'publicationsTodayCount'
        ));
    }

    public function showUsersPage(Request $request)
    {
        $search = $request->input('search');
        $date = $request->input('date');
        $query = User::with('roles')->latest();

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if (!empty($date)) {
            $query->whereDate('created_at', $date);
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(8);

        if ($request->ajax()) {
            return response()->view('dashboard-user.tabelpengguna-admindashboard', compact('users'));
        }

        return view('dashboard-user.tabelpengguna-admindashboard', compact('users'));
    }

    public function destroyUser(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $user->delete();

        return back()->with('success', 'Pengguna berhasil dihapus.');
    }
}
