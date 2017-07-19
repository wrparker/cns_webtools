<?php

namespace App\Http\Controllers;

use App\MathPhd;
use Illuminate\Http\Request;

class MathPhdController extends WebAppController
{

    /**
     * Used in parent class for API.
     *
     * @return \App\Model (the model type you're going to use).
     */
    public function constructorSetModel(){
        return new \App\MathPhd();
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $gid = self::$gid;
        $search =$request->input('search');
        if(isset($search)){
            $items = MathPhd::where('firstname', 'LIKE', '%'.$request->input('search').'%')
                ->orWhere('lastname', 'LIKE', '%'.$request->input('search').'%')
                ->orderBy('lastname')->paginate(50);
            return view('MathPhds.list', compact('items', 'search' , 'gid'));
        }
        else {
            $items = MathPhd::orderBy('lastname')->paginate(50);
            return view('MathPhds.list', compact('items', 'gid'));
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\MathPhd  $mathPhd
     * @return \Illuminate\Http\Response
     */
    public function show(MathPhd $mathPhd)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\MathPhd  $mathPhd
     * @return \Illuminate\Http\Response
     */
    public function edit(MathPhd $mathPhd)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\MathPhd  $mathPhd
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MathPhd $mathPhd)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\MathPhd  $mathPhd
     * @return \Illuminate\Http\Response
     */
    public function destroy(MathPhd $mathPhd)
    {
        //
    }
}
