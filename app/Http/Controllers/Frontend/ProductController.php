<?php
namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Validator;
use Mail;
use Redirect;
use App\Libraries\Helpers;
use App\Facades\WebService;
use App\Models\User,DB;
use App\Model\CategoryProduct;
use App\Model\Product;

class ProductController extends Controller
{
    public function productDetail($slug){
        $data_customers = Product::where('slug',$slug)->first();
        $category = '';
        return view('product.single', compact('data_customers','category'));
    }
    
}
