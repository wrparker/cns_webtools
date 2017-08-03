<?php

namespace App\Http\Controllers;
use App\FundingOpportunity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


class FundingOpportunityController extends WebAppController
{
    /**
     * Used in parent class for API.
     *
     * @return \App\Model (the model type you're going to use).
     */
   public function constructorSetModel(){
       return new \App\FundingOpportunity();
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
            $FundingOpportunities = FundingOpportunity::where('name', 'LIKE', '%'.$request->input('search').'%')
                ->orderBy('name')->paginate(50);
            return view('FundingOpportunities.listOpportunity', compact('FundingOpportunities', 'search' , 'gid'));
        }
        else {
            $FundingOpportunities = FundingOpportunity::orderBy('name')->paginate(50);
            return view('FundingOpportunities.listOpportunity', compact('FundingOpportunities', 'gid'));
        }
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $gid = self::$gid;
        return view('FundingOpportunities.opportunityEditor', compact('gid'));
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
        $fundingOpp = new FundingOpportunity();
        $fundingOpp = $this->request_to_DB_fields($fundingOpp, $request);
        $fundingOpp->save();
        $request->session()->flash('status', 'Successfully created Funding Opportunity: ' .$fundingOpp->name);
        return redirect(route('FundingOpportunities.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(FundingOpportunity $funding_opportunity)
    {
        return $funding_opportunity;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(FundingOpportunity $funding_opportunity)
    {
        $gid = self::$gid;
        return view('FundingOpportunities.opportunityEditor', compact('funding_opportunity', 'gid'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FundingOpportunity $funding_opportunity)
    {
        $funding_opportunity = $this->request_to_DB_fields($funding_opportunity, $request);
        $funding_opportunity->save();
        $request->session()->flash('status', 'Successfully edited Funding Opportunity: ' .$funding_opportunity->name);
        return redirect(route('FundingOpportunities.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, FundingOpportunity $funding_opportunity)
    {
        $name = $funding_opportunity->name;
        $funding_opportunity->delete();
        $request->session()->flash('status', 'Successfully deleted Funding Opportunity: ' .$name);
        return redirect(route('FundingOpportunities.index'));
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
                    $del = FundingOpportunity::findOrFail($item);
                    $del->delete();
                }
            }
        }
        $request->session()->flash('status', 'Successfully deleted selected items');
        return redirect(route('FundingOpportunities.index'));
    }

    private function request_to_DB_fields($fundingOpp, Request $request){
        $this->request_through_validator($request);
        $fundingOpp->name = $request->input('name');
        $fundingOpp->timestamps;
        $fundingOpp->announced = $request->input('announced');
        $fundingOpp->agency = $request->input('agency');
        $fundingOpp->sponsor_deadline = $request->input('sponsor_deadline');

        $fundingOpp->link_internal = ($request->input('link_internal') == null) ?  null : $request->input('link_internal');
        $fundingOpp->link_external =  ($request->input('link_external') == null) ? null : $request->input('link_external');


        $fundingOpp->internal_deadline = $request->input('internal_deadline');
        $fundingOpp->visible = $request->input('visible');
        $fundingOpp->limited_submission = $request->input('limited_submission');
        $fundingOpp->status = $request->input('status');
        $fundingOpp->funding_type = $request->input('funding_type');
        $fundingOpp->timestamps;
        return $fundingOpp;
    }

    private function request_through_validator(Request $request){
        $this->validate($request, [
            'name' => 'required',
            'visible' => 'required|boolean',
            'status' => 'required|boolean',
            'limited_submission' => 'required|boolean',
            'announced' => 'required|date_format:m/d/Y',
            'sponsor_deadline'=> 'required|date_format:m/d/Y',
            'internal_deadline'=> 'required|date_format:m/d/Y',
            'internal_deadline'=> 'required|date_format:m/d/Y',
            'funding_type'=> 'required',
            'link_internal' => 'nullable|url',
            'link_external' => 'nullable|url',
            'agency' => 'required'
        ]);

    }


}
