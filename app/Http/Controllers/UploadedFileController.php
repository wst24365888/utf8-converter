<?php

namespace App\Http\Controllers;

use App\Models\UploadedFile;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UploadedFileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('upload_page');
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
        // supported mime types

        $supportedMimeTypes = "txt,csv";

        // validator

        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:' . $supportedMimeTypes . '|max:2048'
        ]);

        if ($validator->fails()) {
            return response(["success" => false, "message" => $validator->errors(), "file_id" => null]);
        }

        // store file

        $fileName = time() . '_' . $request->file->getClientOriginalName();
        $filePath = Storage::putFileAs('public/uploads', $request->file('file'), $fileName);

        // add to db

        $file = new UploadedFile;

        $file->file_name = $fileName;
        $file->file_path = "/app/" . $filePath;
        $file->save();

        // read file

        $fileContent = Storage::get($filePath);

        // get encoding list

        $encoding_list = mb_list_encodings();
        $confilic_encoding_list = [
            "GB18030",
            "ISO-8859-1",
            "ISO-8859-2",
            "ISO-8859-3",
            "ISO-8859-4",
            "ISO-8859-5",
            "ISO-8859-6",
            "ISO-8859-7",
            "ISO-8859-8",
            "ISO-8859-9",
            "ISO-8859-10",
            "ISO-8859-13",
            "ISO-8859-14",
            "ISO-8859-15",
            "ISO-8859-16",
            "CP936"
        ];

        foreach ($confilic_encoding_list as $index => $encoding) {
            if (($key = array_search($encoding, $encoding_list)) !== false) {
                unset($encoding_list[$key]);
            }
        }

        // convert to utf-8

        $fileContent = mb_convert_encoding($fileContent, "UTF-8", mb_detect_encoding($fileContent, $encoding_list, true));
        Storage::put($filePath, $fileContent);

        return response(["success" => true, "message" => "Uploaded complete. File path: " . $filePath, "file_id" => $file->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $file = UploadedFile::find($id);
        return response()->download(storage_path() . $file->file_path, $file->file_name);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
