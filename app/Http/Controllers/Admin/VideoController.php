<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Video_page;
use App\Libraries\Helpers;
use Illuminate\Support\Str;
use DB, File, Image;

class VideoController extends Controller
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

    public function listVideo(){
        $data_video = Video_page::get();
        return view('admin.video-page.index')->with(['data_video' => $data_video]);
    }

    public function createVideo(){
        return view('admin.video-page.single');
    }

    public function videoDetail($id){
        $video_detail = Video_page::where('id', '=', $id)->first();
        if($video_detail){
            return view('admin.video-page.single')->with(['video_detail' => $video_detail]);
        } else{
            return view('404');
        }
    }

    public function postVideoDetail(Request $rq){
        //id page
        $sid = $rq->sid;

        $title_new = $rq->post_title;

        //xử lý thumbnail
        $name_thumb_img1 = "";
        $image = new Image();
        $name_field = "thumbnail_file";
        $datetime_now=date('Y-m-d H:i:s');
        $datetime_convert=strtotime($datetime_now);
        if($rq->thumbnail_file):
            $file = $rq->file($name_field);
            $timestamp = $datetime_convert;
            $name = "videos-".$timestamp. '-' .$file->getClientOriginalName();
            $name_thumb_img1=$name;
            $image->filePath = $name;
            $url_foder_upload = "/images/videos/";
            $file->move(base_path().$url_foder_upload,$name);
        else:
           if(isset($rq->thumbnail_file_link) && $rq->thumbnail_file_link !=""):
               $name_thumb_img1= $rq->thumbnail_file_link;
           else:
               $name_thumb_img1= "";
           endif;
        endif;


        if($sid == 0){
            $data = array(
                'title' => $title_new,
                'url' => $rq->post_url,
                'order' => $rq->post_order,
                'thumb' => $name_thumb_img1,
                'thumb_alt' => $rq->post_thumb_alt,
                'status' => $rq->status,
                'updated_at' => $rq->created,
                'created_at' => $rq->created,
            );
            $respons = Video_page::create($data);
            $id_insert= $respons->id;
            if($id_insert>0):
                $msg = "Video has been registered";
                $url= route('admin.listVideo');
                Helpers::msg_move_page($msg,$url);
            endif;
        } else{
            $data = array(
                'title' => $title_new,
                'url' => $rq->post_url,
                'order' => $rq->post_order,
                'thumb' => $name_thumb_img1,
                'thumb_alt' => $rq->post_thumb_alt,
                'status' => $rq->status,
                'updated_at' => date('Y-m-d h:i:s')
            );
            $respons = Video_page::where ("id","=",$sid)->update($data);
            $msg = "Video has been Updated";
            $url= route('admin.videoDetail', array($sid));
            Helpers::msg_move_page($msg,$url);
        }
        
    }
}
