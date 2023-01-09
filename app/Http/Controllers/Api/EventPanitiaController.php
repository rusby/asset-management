<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EventPanitia;
use App\Http\Resources\DataResource;
use Illuminate\Support\Facades\Validator;

class EventPanitiaController extends Controller
{
    public function index()
    {
        $eventPanitia = EventPanitia::latest()->paginate(5);
        return new DataResource(true, 'List Data Event Panitia', $eventPanitia);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_event'     => 'required',
            'user.*.id_user' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $no = 1;
        $panitia = [];
        foreach ($request->user as $key => $value) {
            $panitia[] = [
                "Panitia ".$no => $value,
            ];
            $no++;
        }
        $panitia = json_encode($panitia);

        $eventPanitia = EventPanitia::create([
            'id_event' => $request->id_event,
            'id_user'   => $panitia,
        ]);

        return new DataResource(true, 'Data Event Panitia Berhasil Ditambahkan!', $eventPanitia);
    }

    public function show(EventPanitia $eventPanitia)
    {
        return new DataResource(true, 'Data Event Panitia Ditemukan!', $eventPanitia);
    }

    public function update(Request $request, EventPanitia $eventPanitia)
    {
        $validator = Validator::make($request->all(), [
            'id_event'     => 'required',
            'user.*.id_user' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $no = 1;
        $panitia = [];
        foreach ($request->user as $key => $value) {
            $panitia[] = [
                "Panitia ".$no => $value,
            ];
            $no++;
        }

        $panitia = json_encode($panitia);
        $eventPanitia->update([
            'id_event' => $request->id_event,
            'id_user'   => $panitia,
        ]);
        return new DataResource(true, 'Data Event Panitia Berhasil Diubah!', $eventPanitia);
    }

    public function destroy(EventPanitia $eventPanitia)
    {
        $eventPanitia->delete();
        return new DataResource(true, 'Data Event Panitia Berhasil Dihapus!', null);
    }
}
