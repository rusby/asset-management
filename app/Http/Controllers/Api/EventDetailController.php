<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EventDetail;
use App\Http\Resources\DataResource;
use Illuminate\Support\Facades\Validator;


class EventDetailController extends Controller
{
    public function index()
    {
        $eventDetail = EventDetail::latest()->paginate(5);
        return new DataResource(true, 'List Data Event Detail', $eventDetail);
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

        $eventDetail = EventDetail::create([
            'id_event' => $request->id_event,
            'id_barang' => $request->id_barang,
            'status_mutasi' => $request->status,
        ]);

        return new DataResource(true, 'Data Event Detail Berhasil Ditambahkan!', $eventDetail);
    }

    public function show(EventDetail $eventDetail)
    {
        return new DataResource(true, 'Data Event Detail Ditemukan!', $eventDetail);
    }

    public function update(Request $request, EventDetail $eventDetail)
    {
        $validator = Validator::make($request->all(), [
            'id_event'     => 'required',
            'id_barang' => 'required',
            'status_mutasi' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        
        $eventDetail->update([
            'id_event' => $request->id_event,
            'id_barang' => $request->id_barang,
            'status_mutasi' => $request->status,
        ]);
        return new DataResource(true, 'Data Event Detail Berhasil Diubah!', $eventDetail);
    }

    public function destroy(EventDetail $eventDetail)
    {
        $eventDetail->delete();
        return new DataResource(true, 'Data Event Detail Berhasil Dihapus!', null);
    }
}
