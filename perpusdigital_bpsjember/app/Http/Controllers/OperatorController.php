<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Publikasi;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class OperatorController extends Controller
{
    public function index()
    {
        $operatorId = Auth::id();

        $jumlahPublikasi = Publikasi::where('uploaded_by', $operatorId)->count();
        $jumlahDiterima  = Publikasi::where('uploaded_by', $operatorId)->where('status', 'diterima')->count();
        $jumlahTertunda  = Publikasi::where('uploaded_by', $operatorId)->where('status', 'tertunda')->count();
        $jumlahDitolak   = Publikasi::where('uploaded_by', $operatorId)->where('status', 'ditolak')->count();

        $recentPublications = Publikasi::where('uploaded_by', $operatorId)
            ->latest()
            ->take(7)
            ->get();

        return view('dashboard-user.operator-dashboard', [
            'jumlahPublikasi' => $jumlahPublikasi,
            'jumlahDiterima'  => $jumlahDiterima,
            'jumlahTertunda'  => $jumlahTertunda,
            'jumlahDitolak'   => $jumlahDitolak,
            'recentPublications' => $recentPublications,
        ]);
    }

    public function daftarPublikasi(Request $request)
    {
        $operatorId = Auth::id();

        // Mulai query dasar
        $query = Publikasi::where('uploaded_by', $operatorId);

        // Jika ada filter status (misal: ?status=diterima)
        if ($request->has('status') && in_array($request->status, ['diterima', 'tertunda', 'ditolak'])) {
            $query->where('status', $request->status);
        }

        // Ambil hasil dengan pagination
        $recentPublications = $query->latest()->paginate(10);

        return view('dashboard-user.tabelpublikasi-operatordashboard', compact('recentPublications'));
    }

    public function detailPublikasi($id)
    {
        $publikasi = Publikasi::with(['kategori', 'user'])
            ->where('id', $id)
            ->where(function ($query) {
                $query->where('uploaded_by', Auth::id())
                    ->orWhere('status', 'diterima');
            })
            ->firstOrFail();

        return view('dashboard-user.detailpublikasi-operatordashboard', compact('publikasi'));
    }


}
