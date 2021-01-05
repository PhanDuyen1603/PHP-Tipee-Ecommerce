<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Discount_code;
use App\Libraries\Helpers;
use Illuminate\Support\Str;
use DB, File, Image;

class DiscountCodeController extends Controller
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

    public function listDiscountCode(){
        $data_code = Discount_code::get();
        return view('admin.discount-code.index')->with(['data_discount_code' => $data_code]);
    }

    public function createDiscountCode(){
        return view('admin.discount-code.single');
    }

    public function discountCodeDetail($id){
        $data_code = Discount_code::where('id', '=', $id)->first();
        if($data_code){
            return view('admin.discount-code.single')->with(['data_code' => $data_code]);
        } else{
            return view('404');
        }
    }

    public function postDiscountCodeDetail(Request $rq){
        //id page
        $sid = $rq->sid;

        $code = $rq->post_title;

        $expired = $rq->expired;
        $expired = date('Y-m-d H:i:s', strtotime($expired));
        $type = $rq->type_discount;
        if($rq->percent != '' && $rq->percent > 0){
            $percent = $rq->percent;
            $discount_money = 0;
        } else{
            $discount_money = $rq->discount_money;
            $percent = 0;
        }
        if($rq->apply_for_order != '' && $rq->apply_for_order > 0){
            $apply_for_order = $rq->apply_for_order;
        } else{
            $apply_for_order = 0;
        }
        if($sid == 0){
            $data = array(
                'code' => $code,
                'expired' => $expired,
                'type' => $type,
                'percent' => $percent,
                'discount_money' => $discount_money,
                'apply_for_order' => $apply_for_order,
                'status' => $rq->status,
            );
            $respons = Discount_code::create($data);
            $id_insert= $respons->id;
            if($id_insert>0):
                $msg = "Discount Code has been registered";
                $url= route('admin.discountCode');
                Helpers::msg_move_page($msg,$url);
            endif;
        } else{
            $data = array(
                'code' => $code,
                'expired' => $expired,
                'type' => $type,
                'percent' => $percent,
                'discount_money' => $discount_money,
                'apply_for_order' => $apply_for_order,
                'status' => $rq->status,
            );
            $respons = Discount_code::where ("id","=", $sid)->update($data);
            $msg = "Discount Code has been Updated";
            $url= route('admin.discountCodeDetail', array($sid));
            Helpers::msg_move_page($msg,$url);
        }
        
    }
}
