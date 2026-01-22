<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function index(Request $request)
    {
        // 1. Siapkan Query Dasar (Ambil semua laporan terbaru)
        $query = Report::with('user')->latest();

        // 2. Logika Pencarian (Kalau ada ketikan di kolom cari)
        if ($request->has('cari') && $request->cari != '') {
            $keyword = $request->cari;
            // Cari di Judul ATAU Lokasi
            $query->where(function($q) use ($keyword) {
                $q->where('title', 'like', '%' . $keyword . '%')
                  ->orWhere('location', 'like', '%' . $keyword . '%');
            });
        }

        // 3. Logika Filter Kategori (Kalau dropdown kategori dipilih)
        if ($request->has('kategori') && $request->kategori != '') {
            $query->where('category', $request->kategori);
        }

        // 4. Eksekusi (Ambil datanya setelah disaring)
        $reports = $query->get();

        return view('welcome', compact('reports'));
    }

    // Menampilkan Detail 1 Laporan Spesifik
    public function show(Report $report)
    {
        return view('reports.show', compact('report'));
    }
}