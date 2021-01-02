<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use App\Model\Theme;
use App\WebService\WebService;


session_start();



class HomeController extends Controller
{
    public function index(){
        $allProducts = Theme::all();
       
        return view('home.index')->with('allProducts',$allProducts);
    }

}
