<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Brand;
use App\Libraries\Helpers;
use Illuminate\Support\Str;
use DB, File, Image, Config;

class BrandController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function listBrand(){
        $data_brand = Brand::select('brand.brandName', 'brandOrigin','brand.brandDescription',  'brand.created', 'brand.brandStatus', 'brand.brandID')
            ->orderBy('brand.created', 'DESC')
            ->get();
        return view('admin.brand.index')->with(['data_brand' => $data_brand]);
    }

    public function createBrand(){
        return view('admin.brand.single');
    }



    public function brandDetail($id){
        $post_brand = Brand::where('brand.brandID', '=', $id)->first();
        if($post_brand){
            return view('admin.brand.single')->with(['post_brand' => $post_brand]);
        } else{
            return view('404');
        }
    }

    public function postBrandDetail(Request $rq){
        $title = $rq->post_title;
        $description = $rq->post_description;  
        $origin = $rq->post_origin;
        $status = (int)$rq->status;  
        $updated = $rq->created;
        
        $data = array(
            'brandName' => $title,
            'brandOrigin' => $origin,
            'brandDescription' => $description,
            'brandStatus' => $status,
            'created' => $updated,
            'updated' => $updated

        );
        $respons = Brand::create($data);
        $id_insert= $respons->id;

        if($id_insert>0):
            $msg = "Brand has been registered";
            $url = route('admin.brandDetail', array($id_insert));
            Helpers::msg_move_page($msg,$url);
        endif;
    }

}
