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
        dd($request->all());
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
