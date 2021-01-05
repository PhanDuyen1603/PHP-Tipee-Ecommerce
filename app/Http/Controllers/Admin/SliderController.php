<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Slishow;
use Illuminate\Support\Facades\Hash;
use App\Libraries\Helpers;
use Illuminate\Support\Str;
use DB, File, Image, Cache;

class SliderController extends Controller
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

    public function listSlider(){
        $data_slider = Slishow::get();
        return view('admin.slider-home.index')->with(['data_slider' => $data_slider]);
    }

    public function createSlider(){
        return view('admin.slider-home.single');
    }

    public function sliderDetail($id){
        $data_slider = Slishow::where('slishow.id', '=', $id)->first();
        if($data_slider){
            return view('admin.slider-home.single')->with(['data_slider' => $data_slider]);
        } else{
            return view('404');
        }
    }

    public function postSliderDetail(Request $rq){
        //id page
        $sid = $rq->sid;
        $datetime_now=date('Y-m-d H:i:s');
        $datetime_convert=strtotime($datetime_now);

        $title_new = $rq->post_title;

        /*PC up load*/
        $name_thumb_pc="";
        $name_field_pc="csv_slishow";
        $name_text_pc="slishow_upload";
        if($rq->hasFile($name_field_pc)):
            $file = $rq->file($name_field_pc);
            $timestamp = $datetime_convert;
            $name = "slider-".$timestamp. '-' .$file->getClientOriginalName();
            $name_thumb_pc='/img/uploads/slider/'.$name;
            $file->move(base_path().'/img/uploads/slider/',$name);
        else:
            if($rq->input($name_text_pc) !=""):
                $name_thumb_pc = $rq->input($name_text_pc);
            else:
                $name_thumb_pc = "";
            endif;
        endif;
        /*End pc upload*/

        /*Mobile up load*/
        $name_thumb_mobile = "";
        $name_field_mobile = "csv_slishow_mobile";
        $name_text_mobile = "slishow_upload_mobile";
        if($rq->hasFile($name_field_mobile)):
            $file = $rq->file($name_field_mobile);
            $timestamp = $datetime_convert;
            $name = "slider-mobile-".$timestamp. '-' .$file->getClientOriginalName();
            $name_thumb_mobile = '/img/uploads/slider/'.$name;
            $file->move(base_path().'/img/uploads/slider/',$name);
        else:
            if($rq->input($name_text_mobile) !=""):
                $name_thumb_mobile = $rq->input($name_text_mobile);
            else:
                $name_thumb_mobile = "";
            endif;
        endif;
        /*End Mobile upload*/
        
        if($sid == 0){
            $data = array(
                'name' => $title_new,
                'src' => $name_thumb_pc,
                'src_mobile' => $name_thumb_mobile,
                'order' => $rq->order,
                'link' => $rq->link,
                'description' => '',
                'target' => $rq->target,
                'status' => $rq->status,
                'updated' => $rq->created,
                'created' => $rq->created,
            );
            $respons = Slishow::create($data);
            $id_insert= $respons->id;
            Cache::forget('slider_home');
            if($id_insert>0):
                $msg = "Slider has been registered";
                $url= route('admin.slider');
                Helpers::msg_move_page($msg,$url);
            endif;
        } else{
            $data = array(
                'name' => $title_new,
                'src' => $name_thumb_pc,
                'src_mobile' => $name_thumb_mobile,
                'order' => $rq->order,
                'link' => $rq->link,
                'description' => '',
                'target' => $rq->target,
                'status' => $rq->status,
                'updated' => date('Y-m-d h:i:s')
            );
            $respons = Slishow::where ("id","=", $sid)->update($data);
            Cache::forget('slider_home');
            $msg = "Silder has been Updated";
            $url= route('admin.sliderDetail', array($sid));
            Helpers::msg_move_page($msg,$url);
        }
        
    }
}
