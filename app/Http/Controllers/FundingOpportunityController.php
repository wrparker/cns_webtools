<?php

namespace App\Http\Controllers;


use App\FundingOpportunity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class FundingOpportunityController extends Controller
{

    public function __construct()
    {
        //If statement below allows public showing of information.
        //Do not require authentication or user group for @show action.
        //Will likely need to add some query stuff for show... or something for searching.
        if(strstr(Route::getCurrentRoute()->getActionName(), '@', false) !== "@show"){
        $this->middleware(function ($request, $next) {
            if(Auth::user() === null){  //prevents a null exception.
                return redirect ('/');
            }
            else if(!Auth::user()->groups->contains(APP_FUNDINGOPPORTUNITIES)
                    && !Auth::user()->groups->contains(APP_SUPERUSER) ){
                $request->session()->flash('error', 'You are not authorized to the funding opportunities application.');
                return redirect('/');
            }
            else{
                return $next($request);
            }
        });
        }



    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //TODO: Add a check here to see if you're logged in trying to look at thigns vs just grabbing stuff.
        $FundingOpportunities = FundingOpportunity::orderBy('id', 'desc')->paginate(10);
        return view('FundingOpportunities.listOpportunity', compact('FundingOpportunities'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('FundingOpportunities.opportunityEditor');
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
    public function show($id)
    {
        $f = FundingOpportunity::findorFail($id);
        return $f;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $funding_opp = FundingOpportunity::findOrFail($id);
        return view('FundingOpportunities.opportunityEditor')->with('fundingOpp', $funding_opp);

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
        $fundingOpp = FundingOpportunity::findorFail($id);
        $fundingOpp = $this->request_to_DB_fields($fundingOpp, $request);
        $fundingOpp->save();


        $request->session()->flash('status', 'Successfully edited Funding Opportunity: ' .$fundingOpp->name);
        return redirect(route('FundingOpportunities.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {

        $fundingOpp = FundingOpportunity::findorFail($id);
        $name = $fundingOpp->name;
        $fundingOpp->delete();
        $request->session()->flash('status', 'Successfully deleted Funding Opportunity: ' .$name);
        return redirect(route('FundingOpportunities.index'));
    }

    private function request_to_DB_fields($fundingOpp, Request $request){
        $this->request_through_validator($request);
        $fundingOpp->name = $request->input('name');
        $fundingOpp->timestamps;
        $fundingOpp->announced = $request->input('announced');
        $fundingOpp->sponsor_deadline = $request->input('sponsor_deadline');
        $fundingOpp->internal_deadline = $request->input('internal_deadline');
        $fundingOpp->link_internal = $request->input('link_internal');
        $fundingOpp->link_external = $request->input('link_external');
        $fundingOpp->visible = $request->input('visible');
        $fundingOpp->limited_submission = $request->input('limited_submission');
        $fundingOpp->status = $request->input('status');
        $fundingOpp->user = -1;
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
            'funding_type'=> 'required',  //Uncomment when fixed...
        ]);

    }


}
