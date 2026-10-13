<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SiswaResource;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class SiswaController extends Controller
{
    /**
     * Menampilkan daftar master data siswa beserta relasi kelas dan jenis kelamin.
     */
    public function index(): AnonymousResourceCollection
    {
        $siswa = Siswa::with(['kelas', 'jenisKelamin'])->get();

        return SiswaResource::collection($siswa);
    }

    public function show(string|int $id): SiswaResource
    {
        $siswa = Siswa::with(['kelas', 'jenisKelamin'])->findOrFail($id);

        return new SiswaResource($siswa);
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nis' => 'required|string|max:20|unique:siswa,nis',
            'nama' => 'required|string|max:255',
            'kelas_id' => 'required|exists:kelas,id',
            'jenis_kelamin_id' => 'required|exists:jenis_kelamin,id',
        ]);

        $siswa = Siswa::create($validated);

        return response()->json([
            'message' => 'Siswa berhasil ditambahkan.',
            'data' => new SiswaResource($siswa),
        ], 201);
    }

    public function update(Request $request, string|int $id)
    {
        $siswa = Siswa::find($id);

        if (! $siswa) {
            return response()->json([
                'message' => 'Siswa tidak ditemukan.',
            ], 404);
        }

        $request->validate([
            'nis' => 'required|string|max:20|unique:siswa,nis,' . $siswa->id,
            'nama' => 'required|string|max:255',
            'kelas_id' => 'required|exists:kelas,id',
            'jenis_kelamin_id' => 'required|exists:jenis_kelamin,id',
        ]);

        $siswa->update($request->all());

        return response()->json([
            'message' => 'Siswa berhasil diperbarui.',
            'data' => $siswa
        ], 200);
    }
}
