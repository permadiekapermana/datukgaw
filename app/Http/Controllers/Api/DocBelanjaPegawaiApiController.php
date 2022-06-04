<?php

namespace App\Http\Controllers\Api;

use App\Models\DocBelanjaPegawai;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use Auth;
use File;
use Illuminate\Support\Facades\Storage;
use GuzzleHttp\Client;

class DocBelanjaPegawaiApiController extends Controller
{
    protected $user;
 
    public function __construct()
    {
        //$this->user = JWTAuth::parseToken()->authenticate();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function get(Request $request)
    {
        $data = DocBelanjaPegawai::orderBy('created_dt')
                ->paginate(10);
        
        
        if ($data->isEmpty()){
            return response()->json([
                'status' => 200,
                'message' => 'Data Not Found',
                'data' => $data
            ], Response::HTTP_OK);
        } else {
            return response()->json([
                'status' => 200,
                'message' => 'Data Found',
                'data' => $data
            ], Response::HTTP_OK);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Validate data
        $data = $request->only('date', 'jenis_dokumen', 'tipe_dokumen', 'nama_dokumen', 'nomor_dokumen', 'deskripsi_dokumen', 'file', 'created_by', 'updated_by');
        $validator = Validator::make($data, [
            'date' => 'required|date',
            'jenis_dokumen' => 'required|string',
            'tipe_dokumen' => 'required|string',
            'nama_dokumen' => 'required|string',
            'nomor_dokumen' => 'required|string',
            'deskripsi_dokumen' => 'required|string',
            'file' => 'required|mimes:pdf|max:10000',
            'created_by' => 'string',
            'updated_by' => 'string'
        ],[
            'date.required' => 'Date is Required',
            'jenis_dokumen.required' => 'Jenis Dokumen is Required',
            'jenis_dokumen.String' => 'Jenis Dokumen Must Be String',
            'tipe_dokumen.required' => 'Tipe Dokumen is Required',
            'tipe_dokumen.String' => 'Tipe Dokumen Must Be String',
            'nama_dokumen.required' => 'Nama Dokumen is Required',
            'nama_dokumen.String' => 'Nama Dokumen Must Be String',
            'nomor_dokumen.required' => 'Nomor Dokumen is Required',
            'nomor_dokumen.String' => 'Nomor Dokumen Must Be String',
            'deskripsi_dokumen.required' => 'Deskripsi Dokumen is Required',
            'deskripsi_dokumen.String' => 'Deskripsi Dokumen Must Be String',
            'file.required' => 'File is Required',
            'file.mimes' => 'File Must Be PDF Type',
            'file.max' => 'File Max 10 Mb',
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }

        // save upload file to variabel $file
		$file = $request->file('file');
		$nama_file = time().'_'.$file->getClientOriginalName();
 
        //created directory file 
        $path = storage_path('app/public/file');
        if(!File::isDirectory($path)){
            File::makeDirectory($path, 0777, true, true);
        }
		$file->move($path,$nama_file);

        //Request is valid, create new doc
        $doc = DocBelanjaPegawai::create([
            'date' => $request->date,
            'jenis_dokumen' => $request->jenis_dokumen,
            'tipe_dokumen' => $request->tipe_dokumen,
            'nama_dokumen' => $request->nama_dokumen,
            'nomor_dokumen' => $request->nomor_dokumen,
            'deskripsi_dokumen' => $request->deskripsi_dokumen,
            'file' => $nama_file,
            'user_id' => Auth::id(),
            'created_by' => Auth::user()->name,
            'updated_by' => Auth::user()->name,
        ]);
        
        // Doc Belanja Pegawai created, return success response
        return response()->json([
            'status' => 200,
            'message' => 'Doc Belanja Pegawai created successfully',
            'data' => $doc
        ], Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DocBelanjaPegawai  $data
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = DocBelanjaPegawai::find($id);
        
        if (!$data) {
            return response()->json([
                'status' => 200,
                'message' => 'Data Not Found',
                'data' => null
            ], Response::HTTP_OK);
        } else {
            return response()->json([
                'status' => 200,
                'message' => 'Data Found',
                'data' => $data
            ], Response::HTTP_OK);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DocBelanjaPegawai  $id
     * @return \Illuminate\Http\Response
     */
    public function put(Request $request, $id)
    {
        $found = DocBelanjaPegawai::find($id);
        if (!$found) {
            return Response::json(['message' => 'Id not found'], 200);
        }
        //Validate data
        $data = $request->only('date', 'jenis_dokumen', 'tipe_dokumen', 'nama_dokumen', 'nomor_dokumen', 'deskripsi_dokumen', 'file', 'created_by', 'updated_by');
        $validator = Validator::make($data, [
            'date' => 'required|date',
            'jenis_dokumen' => 'required|string',
            'tipe_dokumen' => 'required|string',
            'nama_dokumen' => 'required|string',
            'nomor_dokumen' => 'required|string',
            'deskripsi_dokumen' => 'required|string',
            'file' => 'required|mimes:pdf|max:10000',
        ],[
            'date.required' => 'Date is Required',
            'jenis_dokumen.required' => 'Jenis Dokumen is Required',
            'jenis_dokumen.String' => 'Jenis Dokumen Must Be String',
            'tipe_dokumen.required' => 'Tipe Dokumen is Required',
            'tipe_dokumen.String' => 'Tipe Dokumen Must Be String',
            'nama_dokumen.required' => 'Nama Dokumen is Required',
            'nama_dokumen.String' => 'Nama Dokumen Must Be String',
            'nomor_dokumen.required' => 'Nomor Dokumen is Required',
            'nomor_dokumen.String' => 'Nomor Dokumen Must Be String',
            'deskripsi_dokumen.required' => 'Deskripsi Dokumen is Required',
            'deskripsi_dokumen.String' => 'Deskripsi Dokumen Must Be String',
            'file.required' => 'File is Required',
            'file.mimes' => 'File Must Be PDF Type',
            'file.max' => 'File Max 10 Mb',
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }

        // save upload file to variabel $file
		$file = $request->file('file');
		$nama_file = time().'_'.$file->getClientOriginalName();
 
        //created directory file 
        $path = storage_path('app/public/file');
        if(!File::isDirectory($path)){
            File::makeDirectory($path, 0777, true, true);
        }
		$file->move($path,$nama_file);
        
        //Request is valid
        $found->update([
            'date' => $request->date,
            'jenis_dokumen' => $request->jenis_dokumen,
            'tipe_dokumen' => $request->tipe_dokumen,
            'nama_dokumen' => $request->nama_dokumen,
            'nomor_dokumen' => $request->nomor_dokumen,
            'deskripsi_dokumen' => $request->deskripsi_dokumen,
            'file' => $nama_file,
            'user_id' => Auth::id(),
            'updated_dt' => date("Y-m-d H:i:s"),
            'updated_by' => Auth::user()->name
        ]);

        // return success response
        return response()->json([
            'status' => 200,
            'message' => 'Data updated successfully',
            'data' => $found
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DocBelanjaPegawai  $doc
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //get data doc by id
        $doc = DocBelanjaPegawai::where('id', '=', $id)->get();
        //count data for True or false
        $count = count($doc);
        //check for delete
        if($count === 1){
            //delete
            $doc[0]->delete();
            //response success
            return response()->json([
                'status' => 200,
                'message' => 'Data deleted successfully'
            ], Response::HTTP_OK);
        } else {
            //response id not found
            return response()->json([
                'status' => 200,
                'message' => 'Data deleted successfully'
            ], Response::HTTP_OK);
        }
    }

    public function download($id)
    {
        $doc = DocBelanjaPegawai::where('id', '=', $id)->get();
        //$file = $doc[0]["id"];

        $count = count($doc);

        if($count===1){
            $ids = $doc[0]["id"];
            $file = $doc[0]["file"];
            //download document
            if(Storage::disk('public')->exists("file/$file")){
                $path = Storage::disk('public')->path("file/$file");
                $content = File_get_contents($path);
                return response($content)->withHeaders([
                    'Content-Type'=>mime_content_type($path)
                ]);
            }
        } else if($count===0) {
            //return response id not found
            return response()->json([
                'status' => 200,
                'message' => 'ID Not Found'
            ], Response::HTTP_OK);
        }
    }

    public function comboTahun()
    {
        $arr = DocBelanjaPegawai::selectRaw('YEAR(date) as tahun')->groupBy('tahun')->distinct()->get();
                    
        if ($arr->isEmpty()){
            return response()->json([
                'status' => 200,
                'message' => 'Data Not Found',
                'data' => $arr
            ], Response::HTTP_OK);
        } else {
            return response()->json([
                'status' => 200,
                'message' => 'Data Found',
                'data' => $arr
            ], Response::HTTP_OK);
        }
    }

}