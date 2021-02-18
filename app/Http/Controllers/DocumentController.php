<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Spatie\PdfToText\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $documents = Document::all();
        $fields = [
            ['id', 'ID'],
            ['filename', 'Filename'],
            ['description', 'Description'],
            ['parsed', 'Parsed?']
        ];
        $headers = ['ID', 'Filename', 'Description', 'Parsed?'];

        // $fields = [1,2,3];

        return view("documents.index", compact("documents", "fields", "headers"));        
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
        $this->validate($request, [
            'file' => 'required|mimetypes:application/pdf|max:100000',
            'description' => 'required'
        ]);
        $path = $request->file('file')->store('pdfs');
        $file = $request->file('file');

        $document = new Document();
        $document->file = $path;
        $document->filename = $file->getClientOriginalName();
        $document->description = $request->description;

        $document->save();
        return redirect()->back()->with('success', "PDF added successfully");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function show(Document $document)
    {
        $file = $document->file;
            
        $raw_contents =  Pdf::getText(storage_path("app/".$file));
        
        $contents = explode("\n", $raw_contents);

        $contents = array_slice($contents, 0, 100);
        // dd($contents);

        return view("documents.show", compact("contents"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function edit(Document $document)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Document $document)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function destroy(Document $document)
    {
        //
    }
}
