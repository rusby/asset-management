<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Barang;
use App\Http\Resources\DataResource;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class BarangController extends Controller
{
    public function index()
    {
        $barangs = Barang::latest()->paginate(5);
        return new DataResource(true, 'List Data Barang', $barangs);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'gambar'     => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'nama_barang'     => 'required',
            'deskripsi'   => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        
        $gambar = "";
        if (request()->hasFile('gambar')){
            $uploadgambar = $request->file('gambar');
            $dataGambar = $this->uploadDataFile($uploadgambar);
            $gambar = $dataGambar['fileBase64'];
        }

    
        $barang = Barang::create([
            'gambar'      => $gambar,
            'nama_barang' => $request->nama_barang,
            'deskripsi'   => $request->deskripsi,
            'status_in'      => $request->status,
        ]);

        return new DataResource(true, 'Data Barang Berhasil Ditambahkan!', $barang);
    }

    public function show(Barang $barang)
    {
        return new DataResource(true, 'Data Barang Ditemukan!', $barang);
    }

    public function update(Request $request, Barang $barang)
    {
        // var_dump($request->all());die;
        $validator = Validator::make($request->all(), [
            'gambar'     => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'nama_barang'     => 'required',
            'deskripsi'   => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        
        if ($request->hasFile('gambar')) {
            Storage::delete('public/upload/barang/'.$barang->gambar);

            $uploadgambar = $request->file('gambar');
            $dataGambar = $this->uploadDataFile($uploadgambar);
            $gambar = $dataGambar['fileBase64'];
            $barang->update([
                'gambar'      => $gambar,
                'nama_barang' => $request->nama_barang,
                'deskripsi'   => $request->deskripsi,
                'status_in'      => $request->status,
            ]);

        } else {
            $barang->update([
                'nama_barang' => $request->nama_barang,
                'deskripsi'   => $request->deskripsi,
                'status_in'      => $request->status,
            ]);
        }
        return new DataResource(true, 'Data Barang Berhasil Diubah!', $barang);
    }

    public function destroy(Barang $barang)
    {
        Storage::delete('public/upload/barang/'.$barang->gambar);
        $barang->delete();
        return new DataResource(true, 'Data Barang Berhasil Dihapus!', null);
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
            "fileBase64" => $fileBase64,
            "extFile" => $extFile,
            "fileNameToStore" => $fileNameToStore,
        );
        return $dataArr; 
    }

}
