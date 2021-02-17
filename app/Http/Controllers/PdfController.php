<?php

namespace App\Http\Controllers;

use App\Models\Pdf;
use Illuminate\Http\Request;

class PdfController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pdfs = Pdf::all();
        $fields = [
            ["id", "ID"],
            ["filename", "Filename"],
            ["description", "Description"],
            ["parsed", "Parsed?"]
        ];

        return view("pdf.index", compact("pdfs", "fields"));
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
        // ini_set('memory_limit', '256M');
        // ini_set('post_max_size', '256M');
        // ini_set('upload_max_filesize', '256M');
        $this->validate($request, [
            'file' => 'required|mimetypes:application/pdf|max:100000',
            'description' => 'required'
        ]);
        $path = $request->file('file')->store('pdfs');
        $file = $request->file('file');

        $pdf = new Pdf();
        $pdf->file = $path;
        $pdf->filename = $file->getClientOriginalName();
        $pdf->description = $request->description;

        $pdf->save();
        return redirect()->back()->with('success', "PDF added successfully");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\pdf  $pdf
     * @return \Illuminate\Http\Response
     */
    public function show(Pdf $Pdf)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\pdf  $pdf
     * @return \Illuminate\Http\Response
     */
    public function edit(Pdf $Pdf)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\pdf  $pdf
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pdf $Pdf)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\pdf  $pdf
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pdf $Pdf)
    {
        //
    }
}
