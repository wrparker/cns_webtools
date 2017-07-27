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
                ->orderBy('id', 'desc')->paginate(50);
            return view('MathPhds.list', compact('items', 'search' , 'gid'));
        }
        else {
            $items = MathPhd::orderBy('id', 'desc')->paginate(50);
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
        $gid = self::$gid;
        return view('MathPhds.edit', compact('gid'));
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
        $item = new MathPhd();
        //validate it here.
        $item = $this->request_to_DB_fields($item, $request);
        $item->save();
        $request->session()->flash('status', 'Successfully created Math PhD: ' .$item->firstname . ' ' .$item->lastname);
        return redirect(route('MathPhds.index'));

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
        return $mathPhd;
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
        $gid = self::$gid;
        $item = $mathPhd;
        return view('MathPhds.edit', compact('item', 'gid'));
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
        $mathPhd = $this->request_to_DB_fields($mathPhd, $request);
        $mathPhd->save();
        $request->session()->flash('status', 'Successfully edited Math Phd: ' .$mathPhd->name);
        return redirect(route('MathPhds.index'));

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\MathPhd  $mathPhd
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, MathPhd $mathPhd)
    {

        $name = $mathPhd->firstname . ' ' .$mathPhd->lastname;
        $mathPhd->delete();
        $request->session()->flash('status', 'Successfully deleted Math PhD: ' .$name);
        return redirect(route('MathPhds.index'));
        //
    }

    /**
     * Removes the specified resources from storage
     *
     * @param  Request
     * @return \Illuminate\Http\Response
     */
    public function destroyBulk(Request $request)
    {
        $toDelete = array_keys($request->toArray());
        if(array_key_exists('delete_bulk', $request->toArray()) === true){
            foreach($toDelete as $item){
                if(strstr($item, "item_") !== false  ){
                    $item = substr($item, 5);
                    $del = MathPhd::findOrFail($item);
                    $del->delete();
                }
            }
        }
        $request->session()->flash('status', 'Successfully deleted selected items');
        return redirect(route('MathPhds.index'));
    }


    //validation.

    private function request_to_DB_fields($item, Request $request){
        $this->request_through_validator($request);
        $item->lastname = $request->input('lastname');
        $item->firstname = $request->input('firstname');
        $item->advisors = $request->input('advisors');
        $item->degree = $request->input('degree');
        $item->year = $request->input('year');
        $item->dissertation = $request->input('dissertation');
        $item->job1 = $request->input('job1');
        $item->job = $request->input('job');
        $item->misc = $request->input('misc');
        return $item;
    }

    private function request_through_validator(Request $request){
        $this->validate($request, [
            'lastname' => 'required',
            'firstname' => 'required',
            'advisors' => 'required',
            'degree' => 'required',
            'year' => 'numeric|required',
            'dissertation' => 'required',
            'job1' => 'nullable',
            'job' => 'nullable',
            'misc' => 'nullable'

        ]);

    }
}
