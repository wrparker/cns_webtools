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
                else if($this->verifyAccess()){
                    return $next($request);
                }
                else{
                    $request->session()->flash('error', 'You are not authorized to the funding opportunities application.');
                    return redirect('/');

                }
            });
        }
    }

    /**
    * Basically be able to set the model.  This function gets overriden in child class.
     *
     *@return null
     */

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

    /**
     * Determines whether a user has backend access to a web application.
     * @return boolean
     */

    public function verifyAccess(){
        $className = get_class(self::$model);
        $className = substr($className, 4);  //Remove the App\
        $id =  \App\Group::where('model_name', $className)->get();
        if(sizeof($id) > 1){
            echo "Fatal Error.  Non-unique model_name.";
            die();
        }
        if(Auth::user() === null){
            echo "No use logged in.  Cannot use function";
            die();
        }
        else if(Auth::user()->isAdmin() || Auth::user()->groups->contains($id[0]->id)){
            return true;
        }
        else{
            return false;
        }
    }

}


