<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\JenisKelaminResource;
use App\Models\JenisKelamin;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class JenisKelaminController extends Controller
{
    /**
     * Menampilkan daftar master data jenis kelamin.
     */
    public function index(): AnonymousResourceCollection
    {
        $jenisKelamin = JenisKelamin::all();

        return JenisKelaminResource::collection($jenisKelamin);
    }
    public function show(string|int $id): JenisKelaminResource
    {
        $jenisKelamin = JenisKelamin::findOrFail($id);

        return new JenisKelaminResource($jenisKelamin);
    }
}
