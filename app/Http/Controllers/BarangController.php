<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use DataTables;

class BarangController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');  
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Barang::latest()->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $actionBtn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm editBarang " data-id="'.json_decode($row->id).'">Edit</a> <a href="javascript:void(0)" class="deleteBarang btn btn-danger btn-sm" data-id="'.json_decode($row->id).'">Delete</a>';
                        return $actionBtn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('barang.index');
    }

    public function create()
    {
        return view('barang.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'gambar'      => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'nama_barang' => 'required',
            'deskripsi'   => 'required',
        ]);

        $gambar = "";
        if (request()->hasFile('gambar')){
            $uploadgambar = $request->file('gambar');
            $dataGambar = $this->uploadDataFile($uploadgambar);
            $gambar = $dataGambar['fileBase64'];
        }

        $databarang = [
            'nama_barang' => $request->nama_barang, 
            'deskripsi' => $request->deskripsi, 
            'status_in' => $request->status_in, 
            'gambar' => $gambar, 
        ];

		Barang::create($databarang);
        return redirect()->route('barangs.index')->with('success', 'Barang Added successfully.');
    }

    public function show(Barang $barang)
    {
        return view('barang.index', compact('barang'));
    }
    
    public function edit(Barang $barang)
    {
		$barang = Barang::find($barang);
		return response()->json($barang);
    }

    public function update(Request $request, Barang $barang)
    {
        $validator = Validator::make($request->all(), [
            'nama_barang_edit'      => 'required',
            'deskripsi_edit'        => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        
        if ($request->hasFile('gambar_edit')) {
            
            $uploadgamstatus_inbar = $request->file('gambar_edit');
            $dataGambar = $this->uploadDataFile($uploadgambar);
            // Storage::delete('public/upload/barang/'.$barang->$dataGambar['originalFileName']);

            $gambar = $dataGambar['fileBase64'];
            $databarang  = [
                'nama_barang' => $request->nama_barang_edit,
                'deskripsi'   => $request->deskripsi_edit,
                'status_in'   => $request->status_in_edit,
                'gambar'      => $gambar,
            ];
            $barang->update($databarang);
        } else {
            $databarang  = array(
                'nama_barang' => $request->nama_barang_edit,
                'deskripsi'   => $request->deskripsi_edit,
                'status_in'   => $request->status_in_edit,
            );
            $barang->update($databarang);
        }

        return redirect()->route('barangs.index')->with('success', 'Data Barang has been updated successfully');

    }

    public function destroy(Barang $barang)
    {
        $barang->delete();
        return redirect()->route('barangs.index')->with('success', 'Data Barang deleted successfully');

    }

    public function uploadDataFile($fileNameupload){
        if (!\File::exists(public_path("upload/barang"))) {
			\File::makeDirectory(public_path("upload/barang"), 0755, true, true);
		}

        $fileBase64 = base64_encode(file_get_contents($fileNameupload->path()));
        $extFile  = $fileNameupload->getClientOriginalExtension();
        $fileOriginalName = $fileNameupload->getClientOriginalName();
        $originalName    = pathinfo($fileOriginalName, PATHINFO_FILENAME);
        $fileNameToStore    = $originalName.'_'.time().'.'.$extFile;
        $fileNameupload->move(public_path("upload/barang"), $fileNameToStore);
        $dataArr = array(
            "originalFileName" => $fileOriginalName,
            "fileBase64" => $fileBase64,
            "extFile" => $extFile,
            "fileNameToStore" => $fileNameToStore,
        );
        return $dataArr; 
    }

}
