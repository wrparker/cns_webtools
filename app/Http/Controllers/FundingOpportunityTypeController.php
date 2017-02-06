<?php

namespace App\Http\Controllers;

use App\FundingOpportunityType;

use Illuminate\Http\Request;

class FundingOpportunityTypeController extends Controller
{
    public function store(Request $request){

        $this->validate($request, [
           'fundingType' => 'required|max:255'
        ]);
        $types = FundingOpportunityType::all();
        return view('FundingOpportunities.listType', compact('types'));
    }

    //TODO Refactor.
    public function index(){
        $types = FundingOpportunityType::all();
        return view ('FundingOpportunities.listType', compact('types'));
    }

    public function delete(){
        return "Hi";
    }

}
