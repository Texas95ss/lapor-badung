<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    // Halaman Dashboard Admin
    public function index()
    {
        // CEK SECURITY: Kalau bukan admin, tendang keluar!
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Anda tidak punya akses ke halaman ini!');
        }

        // Ambil semua laporan terbaru (paling atas)
        $reports = Report::with('user')->latest()->get();

        return view('admin.index', compact('reports'));
    }

    // Fungsi Update Status (Pending -> Proses -> Selesai)
    public function update(Request $request, Report $report)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        // Validasi input status
        $request->validate([
            'status' => 'required|in:pending,proses,selesai,ditolak',
        ]);

        // Update database
        $report->update([
            'status' => $request->status
        ]);

        return redirect()->back()->with('success', 'Status laporan berhasil diperbarui!');
    }
}