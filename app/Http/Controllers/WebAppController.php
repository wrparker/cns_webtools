<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class WebAppController extends Controller
{
    private static $model = null;

    public function __construct()
    {
        self::$model = $this->setModel();
        //If statement below allows public showing of information.
        //Do not require authentication or user group for @show action.
        //Will likely need to add some query stuff for show... or something for searching.
        if(Route::getcurrentRoute() !== null && strstr(Route::getCurrentRoute()->getActionName(), '@', false) !== "@publicIndex"){
            $this->middleware(function ($request, $next) {
                if(Auth::user() === null){  //prevents a null exception.
                    return redirect ('/');
                }
                else if(!Auth::user()->groups->contains(APP_FUNDINGOPPORTUNITIES)  //TODO: change this.
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

    public function setModel(){
        return null;
    }


    /**
     * Display a listing of the resource.  Specify "items" to get #items per page.
     *
     * This should handle all the API requests.  Can add in searchability.
     * @return array \Illuminate\Http\Response
     */
    public function publicIndex(Request $request)
    {
        $model = self::$model;
        //$model = null;
        if($model === null){
            return "Error.  Model Null.";
        }
        else{
            //Build Append Array.
            if(sizeof($request->query() == 0)){
                return $model::orderBy('name')->get();
            }
            else{
                $appendArray = array();
                if(isset($request->query()["orderBy"])) {
                    $appendArray += ['orderBy' => $request->query()["orderBy"]];
                }

                if(isset($request->query()["searchName"])) {
                    $appendArray += ['searchName' => $request->query()["searchName"]];
                }

                //Items is always last.  It tells us to start pagination.
                if(isset($request->query()["items"])) {
                    $appendArray += ['items' => $request->query()['items']];
                }
            }

            //GET Query Parameter "searchName"
            if(isset($request->query()["searchName"])){
                $models = $model::where('name', 'LIKE', '%'.$request->query()["searchName"].'%')
                    ->orderby('name');
                if(isset($request->query()["items"])){
                    return $models->paginate($request->query()["items"])
                        ->appends(['items' => $request->query()["items"],
                            'searchName' => $request->query()['searchName'],
                        ]);
                }
                else{
                    return $models->get();
                }

            }

            if(isset($request->query()["items"])){
                return $model::orderBy('name')
                    ->paginate($request->query()["items"])->appends(['items' => $request->query()["items"]]);
            }
            else { //List All
                return $model::orderBy('name')->get();
            }
        }
    }

}


