<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DataTables;

class EventController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');  
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Event::latest()->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $actionBtn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm editEvent " data-id="'.json_decode($row->id).'">Edit</a> <a href="javascript:void(0)" class="deleteEvent btn btn-danger btn-sm" data-id="'.json_decode($row->id).'">Delete</a> ';
                        return $actionBtn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('event.index');
    }

    public function create()
    {
        //
    }   

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_event' => 'required',
            'lokasi'   => 'required',
            'jadwal'   => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $dataevent = [
            'nama_event' => $request->nama_event, 
            'lokasi' => $request->lokasi, 
            'jadwal' => $request->status_in, 
        ];

		Event::create($dataevent);
        return redirect()->route('events.index')->with('success', 'Event Added successfully.');
    }

    public function show(Event $event)
    {
        
    }

    public function edit(Event $event)
    {
        $event = Event::find($event)->toArray();
		return response()->json($event);
    }

    public function update(Request $request, Event $event)
    {
        $validator = Validator::make($request->all(), [
            'nama_event_edit' => 'required',
            'lokasi_edit'   => 'required',
            'jadwal_edit'   => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $dataevent = [
            'nama_event' => $request->nama_event_edit, 
            'lokasi' => $request->lokasi_edit, 
            'jadwal' => $request->jadwal, 
        ];

        $event->update($dataevent);
    }

    public function destroy(Event $event)
    {
        $event->delete();
        return redirect()->route('events.index')->with('success', 'Data Barang deleted successfully');

    }
}
