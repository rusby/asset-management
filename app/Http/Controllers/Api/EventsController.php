<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Http\Resources\DataResource;
use Illuminate\Support\Facades\Validator;


class EventsController extends Controller
{
    public function index()
    {
        $event = Event::latest()->paginate(5);
        return new DataResource(true, 'List Data Event', $event);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_event'     => 'required',
            'lokasi' => 'required',
            'jadwal' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $event = Event::create([
            'nama_event' => $request->nama_event,
            'lokasi' => $request->lokasi,
            'jadwal'   => $request->jadwal,
        ]);

        return new DataResource(true, 'Data Event Berhasil Ditambahkan!', $event);
    }

    public function show(Event $event)
    {
        return new DataResource(true, 'Data Event Ditemukan!', $event);
    }

    public function update(Request $request, Event $event)
    {
        $validator = Validator::make($request->all(), [
            'nama_event'     => 'required',
            'lokasi' => 'required',
            'jadwal' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $panitia = json_encode($panitia);
        $event->update([
            'nama_event' => $request->nama_event,
            'lokasi' => $request->lokasi,
            'jadwal'   => $request->jadwal,
        ]);
        return new DataResource(true, 'Data Event Berhasil Diubah!', $event);
    }

    public function destroy(Event $event)
    {
        $event->delete();
        return new DataResource(true, 'Data Event Berhasil Dihapus!', null);
    }
}
