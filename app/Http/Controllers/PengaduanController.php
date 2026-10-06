<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePengaduanRequest;
use App\Http\Requests\UpdatePengaduanRequest;
use App\Models\Kategori;
use App\Models\Pengaduan;
use Illuminate\Support\Facades\Storage;

class PengaduanController extends Controller
{
    public function index()
    {
        $pengaduans = auth()->user()->pengaduans()
            ->with('kategori')
            ->latest()
            ->paginate(10);

        return view('pengaduan.index', compact('pengaduans'));
    }

    public function create()
    {
        $kategoris = Kategori::all();
        return view('pengaduan.create', compact('kategoris'));
    }

    public function store(StorePengaduanRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('', 'public');
        }

        $data['user_id'] = auth()->id();
        $data['status'] = Pengaduan::STATUS_DIAJUKAN;

        Pengaduan::create($data);

        return redirect()->route('pengaduan.index')
            ->with('success', 'Pengaduan berhasil diajukan.');
    }

    public function show(Pengaduan $pengaduan)
    {
        // Pastikan user hanya bisa lihat miliknya
        if ($pengaduan->user_id != auth()->id()) {
            abort(403);
        }

        $pengaduan->load('kategori', 'user');
        return view('pengaduan.show', compact('pengaduan'));
    }

    public function edit(Pengaduan $pengaduan)
    {
        if ($pengaduan->user_id != auth()->id()) {
            abort(403);
        }

        if ($pengaduan->status !== Pengaduan::STATUS_DIAJUKAN) {
            return redirect()->route('pengaduan.show', $pengaduan)
                ->with('error', 'Pengaduan yang sudah diproses tidak dapat diedit.');
        }

        $kategoris = Kategori::all();
        return view('pengaduan.edit', compact('pengaduan', 'kategoris'));
    }

    public function update(UpdatePengaduanRequest $request, Pengaduan $pengaduan)
    {
        if ($pengaduan->user_id != auth()->id()) {
            abort(403);
        }

        if ($pengaduan->status !== Pengaduan::STATUS_DIAJUKAN) {
            return redirect()->route('pengaduan.show', $pengaduan)
                ->with('error', 'Pengaduan yang sudah diproses tidak dapat diedit.');
        }

        $data = $request->validated();

        if ($request->hasFile('foto')) {
            // Hapus foto lama
            if ($pengaduan->foto) {
                Storage::disk('public')->delete($pengaduan->foto);
            }
            $data['foto'] = $request->file('foto')->store('', 'public');
        }

        $pengaduan->update($data);

        return redirect()->route('pengaduan.show', $pengaduan)
            ->with('success', 'Pengaduan berhasil diperbarui.');
    }

    public function destroy(Pengaduan $pengaduan)
    {
        if ($pengaduan->user_id != auth()->id()) {
            abort(403);
        }

        if ($pengaduan->status !== Pengaduan::STATUS_DIAJUKAN) {
            return redirect()->route('pengaduan.show', $pengaduan)
                ->with('error', 'Pengaduan yang sudah diproses tidak dapat dihapus.');
        }

        if ($pengaduan->foto) {
            Storage::disk('public')->delete($pengaduan->foto);
        }

        $pengaduan->delete();

        return redirect()->route('pengaduan.index')
            ->with('success', 'Pengaduan berhasil dihapus.');
    }
}
