<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    // Menampilkan Laporan Milik User Sendiri di Dashboard
    public function index()
    {
        // Ambil laporan dimana user_id sama dengan user yang login
        $reports = Report::where('user_id', Auth::id())->latest()->get();
        
        return view('dashboard', compact('reports'));
    }

    // 1. Tampilkan Halaman Form
    public function create()
    {
        return view('reports.create');
    }

    // 2. Simpan Data ke Database (Logic Utama)
    public function store(Request $request)
    {
        // A. Validasi (Cek inputan user)
        $request->validate([
            'title' => 'required|max:255',
            'category' => 'required',
            'description' => 'required',
            'location' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Wajib gambar, max 2MB
        ]);

        // B. Upload Foto ke Folder 'storage/app/public/reports'
        // Laravel akan memberikan nama acak biar ga bentrok
        $imagePath = $request->file('image')->store('reports', 'public');

        // C. Simpan ke Database
        Report::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'category' => $request->category,
            'description' => $request->description,
            'location' => $request->location,
            'image' => $imagePath,
            'status' => 'pending',
            // Tambahkan ini:
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ]);

        // D. Balikin ke Halaman Depan dengan Pesan Sukses
        return redirect()->route('dashboard')
            ->with('success', 'Laporanmu berhasil dikirim, tunggu konfirmasi admin ya!');
    }
}