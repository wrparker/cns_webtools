<?php

namespace App\Http\Controllers;

use App\FundingOpportunityType;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class FundingOpportunityTypeController extends Controller
{
    public function store(Request $request){

        $this->validate($request, [
           'fundingType' => 'required|max:255'
        ]);

        $fundingOppType = new FundingOpportunityType;

        $fundingOppType->type = $request->input('fundingType');
        $fundingOppType->timestamps;
        $fundingOppType->save();

        $request->session()->flash('status', 'Task was successful!');

        return redirect(URL::to('FundingOpportunityTypes'));

    }

    //TODO Refactor--add documentation in code.
    public function index(){
        $types = FundingOpportunityType::orderBy('id', 'desc')->paginate(10);
        return view ('FundingOpportunities.listType', compact('types'));
    }

    public function create(){
        return view('FundingOpportunities.createType');
    }

    public function edit($id){
        $fundingOppType = FundingOpportunityType::find($id);
        return view('FundingOpportunities.editType', compact('fundingOppType'));
    }


    public function destroy($id, Request $request){
        $deleteMe = FundingOpportunityType::find($id);
        $deleteMe->delete();
        $request->session()->flash("status", "Successfully deleted the Funding Opportunity Type - \"" .$deleteMe->type."\" !");
        return redirect('FundingOpportunityTypes');
    }
    public function update($id, Request $request){
        $this->validate($request, [
            'fundingType' => 'required|max:255'
        ]);

        $updateMe = FundingOpportunityType::find($id);
        $oldName = $updateMe->type;
        $updateMe->type = $request->input('fundingType');
        $updateMe->save();
        $request->session()->flash("status", "Successfully updated \"".$oldName."\" to  \"" .$updateMe->type."\" !");
        return redirect(URL::to('FundingOpportunityTypes'));
    }

    public function show($id){
        return FundingOpportunityType::find($id);
    }

}
