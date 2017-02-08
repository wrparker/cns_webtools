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

        $fundingOppType->name = $request->input('fundingType');
        $fundingOppType->timestamps;
        $fundingOppType->save();

        $request->session()->flash('status', 'Successfully created Funding Type: ' .$fundingOppType->name);

        return redirect(route('FundingOpportunityTypes.index'));

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
        $request->session()->flash("status", "Successfully deleted the Funding Opportunity Type - \"" .$deleteMe->name."\" !");
        return redirect(route('FundingOpportunityTypes.index'));
    }
    public function update($id, Request $request){
        $this->validate($request, [
            'fundingType' => 'required|max:255'
        ]);

        $updateMe = FundingOpportunityType::find($id);
        $oldName = $updateMe->name;
        $updateMe->name = $request->input('fundingType');
        $updateMe->save();
        $request->session()->flash("status", "Successfully updated \"".$oldName."\" to  \"" .$updateMe->name."\" !");
        return redirect(route('FundingOpportunityTypes.index'));
    }

    public function show($id){
        return FundingOpportunityType::find($id);
    }

}
