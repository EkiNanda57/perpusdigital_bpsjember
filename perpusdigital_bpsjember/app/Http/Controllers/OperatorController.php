<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Publikasi;
use App\Models\User; // <-- PENTING: Pastikan ini ada
use Illuminate\Support\Facades\Auth;

class OperatorController extends Controller
{
    public function index()
    {
       
        $operatorId = Auth::id();

        $jumlahPublikasi = Publikasi::where('uploaded_by', $operatorId)->count();
        $jumlahDiterima  = Publikasi::where('uploaded_by', $operatorId)->where('status', 'diterima')->count();
        $jumlahTertunda  = Publikasi::where('uploaded_by', $operatorId)->where('status', 'tertunda')->count();

     
        $recentPublications = Publikasi::where('uploaded_by', $operatorId)
                                 ->latest()
                                 ->take(5)  
                                 ->get();

     
        return view('dashboard-user.operator-dashboard', [
       
            'jumlahPublikasi' => $jumlahPublikasi,
            'jumlahDiterima'  => $jumlahDiterima,
            'jumlahTertunda'  => $jumlahTertunda,

            'recentPublications' => $recentPublications,
   

    ]);
}
}

