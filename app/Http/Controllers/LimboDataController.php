<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\LimboData;
use Illuminate\Http\Request;

class LimboDataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $p = $request->page_no;
        $pp = $request->per_page;
        $doc = $request->document_id;
        $range = json_encode([$p * $pp, ($p+1) * $pp]);

        $limbo = new LimboData();
        $limbo->range = $range;
        $limbo->text = $request->data;
        $limbo->changes = $request->changelog;
        $limbo->document_id = $doc;
        $limbo->save();

        $response_text = "Data added for document with id: $doc for the range: $range successfully!!";

        return response($response_text);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LimboData  $limboData
     * @return \Illuminate\Http\Response
     */

    public function parsed_data($id)
    {
        $data = Document::find($id)->with("limbo_data")->get()->first();
        $fields = [
            ['id', 'ID'],
            ['range', 'Range'],
            ['rows', 'Rows'],
            ['parse', 'Parse']
        ];
        // dd($data->first());

        return view("limbo_data.index", compact("data", "fields"));
    }

    public function show(LimboData $limboData)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\LimboData  $limboData
     * @return \Illuminate\Http\Response
     */
    public function edit(LimboData $limboData)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LimboData  $limboData
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LimboData $limboData)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LimboData  $limboData
     * @return \Illuminate\Http\Response
     */
    public function destroy(LimboData $limboData)
    {
        //
    }
}
