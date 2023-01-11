<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MutasiStock;
use App\Http\Resources\DataResource;
use Illuminate\Support\Facades\Validator;

class MutasiStockController extends Controller
{
    public function index()
    {
        $mutasiStock = MutasiStock::latest()->paginate(5);
        return new DataResource(true, 'List Data Mutasi Stock', $mutasiStock);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_event'     => 'required',
            'id_barang' => 'required',
            'status_mutasi' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $mutasiStock = MutasiStock::create([
            'id_event' => $request->id_event,
            'id_barang' => $request->id_barang,
            'status_mutasi' => $request->status_mutasi,
        ]);

        return new DataResource(true, 'Data Mutasi Stock Berhasil Ditambahkan!', $mutasiStock);
    }

    public function show(MutasiStock $mutasiStock)
    {
        return new DataResource(true, 'Data Mutasi Stock Ditemukan!', $mutasiStock);
    }

    public function update(Request $request, MutasiStock $mutasiStock)
    {
        $validator = Validator::make($request->all(), [
            'id_event'     => 'required',
            'id_barang' => 'required',
            'status_mutasi' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        
        $mutasiStock->update([
            'id_event' => $request->id_event,
            'id_barang' => $request->id_barang,
            'status_mutasi' => $request->status_mutasi,
        ]);
        return new DataResource(true, 'Data Mutasi Stock Berhasil Diubah!', $mutasiStock);
    }

    public function destroy(MutasiStock $mutasiStock)
    {
        $mutasiStock->delete();
        return new DataResource(true, 'Data Mutasi Stock Berhasil Dihapus!', null);
    }
}
