<?php

namespace App\Http\Controllers;

use App\Models\Komentar;
use Illuminate\Http\Request;

class KomentarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Komentar::with(['user', 'berita' => function($query) {
            $query->select('id', 'judul');
        }]);

        // Filter by user
        if ($request->has('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        // Filter by berita
        if ($request->has('berita_id')) {
            $query->where('berita_id', $request->berita_id);
        }

        // Search in konten
        if ($request->has('search')) {
            $query->where('konten', 'like', '%' . $request->search . '%');
        }

        $komentars = $query->latest()->paginate(10)
            ->appends($request->all());
            
        return view('admin.komentar.index', compact('komentars'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'konten' => 'required|string|max:1000',
            'berita_id' => 'required|exists:beritas,id'
        ]);

        $komentar = Komentar::create([
            'konten' => $request->konten,
            'berita_id' => $request->berita_id,
            'user_id' => auth()->id()
        ]);

        return redirect()->back()
            ->with('success', 'Komentar berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Komentar $komentar)
    {
        return view('admin.komentar.show', compact('komentar'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Komentar $komentar)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Komentar $komentar)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Komentar $komentar)
    {
        $komentar->delete();

        return redirect()->route('admin.komentar.index')
            ->with('success', 'Komentar berhasil dihapus!');
    }
}