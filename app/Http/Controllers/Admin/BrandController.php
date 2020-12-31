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
        $data_brand = Brand::select('brand.brandName', 'brand.brandSlug', 'brand.brandThumb', 'brand.created', 'brand.brandStatus', 'brand.brandID')
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
        //id post
        $sid = $rq->sid;
        $title_new = $rq->post_title;

        $title_slug = addslashes($rq->post_slug);
        if(empty($title_slug) || $title_slug == ''):
           $title_slug = Str::slug($title_new);
        endif;

        //xử lý description
        $description = $rq->post_description;
        if($description != ''){
            $dom = new \DomDocument();
            libxml_use_internal_errors(true);
            $dom->loadHtml('<?xml encoding="utf-8" ?>'.$description, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
            $images = $dom->getElementsByTagName('img');
            foreach($images as $k => $img){
                $data = $img->getAttribute('src');
                $check_img_is_upload = str_replace( 'data:image', '', $data);
                if ($check_img_is_upload != $data){
                    list($type, $data) = explode(';', $data);
                    list(, $data)      = explode(',', $data);
                    $data = base64_decode($data);
                    $timestamp = $datetime_convert;
                    $image_name= "/images/upload/brand_".$timestamp.'_upload_des'.$k.'.png';
                    $path = $_SERVER['DOCUMENT_ROOT'].$image_name;
                    file_put_contents($path, $data);
                    $img->removeAttribute('src');
                    $img->setAttribute('src', $image_name);
                }
            }
            $description = $dom->saveHTML();
        }

        $content = htmlspecialchars($rq->post_content);

        //xử lý thumbnail
        $thumbnail_alt = addslashes($rq->post_thumb_alt);
        $name_thumb_img1 = "";
        $image = new Image();
        $name_field = "thumbnail_file";
        $datetime_now=date('Y-m-d H:i:s');
        $datetime_convert=strtotime($datetime_now);
        if($rq->thumbnail_file):
            $file = $rq->file($name_field);
            $timestamp = $datetime_convert;
            $name = "brand-".$timestamp. '-' .$file->getClientOriginalName();
            $name_thumb_img1 = $name;
            $image->filePath = $name;
            $url_foder_upload = "/images/brand/";
            $file->move(base_path().$url_foder_upload,$name);
        else:
           if(isset($rq->thumbnail_file_link) && $rq->thumbnail_file_link !=""):
               $name_thumb_img1 = $rq->thumbnail_file_link;
           else:
               $name_thumb_img1 = "";
           endif;
        endif;

        $seo_title = $rq->seo_title;
        $seo_keyword = $rq->seo_keyword;
        $seo_description = $rq->seo_description;

        $updated = $rq->created;
        $status = (int)$rq->status;

        if($sid > 0){
            //update
            $data = array(
                'brandName' => $title_new,
                'brandSlug' => $title_slug,
                'brandDescription' => $description,
                'brandContent' => $content,
                'brandThumb' => $name_thumb_img1,
                'brandThumb_alt' => $thumbnail_alt,
                'brandStatus' => $status,
                'updated' => date('Y-m-d h:i:s'),
                'seo_title' => $seo_title,
                'seo_keyword' =>$seo_keyword,
                'seo_description' =>$seo_description
            );
            $respons = Brand::where ("brandID", "=", $sid)->update($data);
            $msg = "Brand has been Updated";
            $url = route('admin.brandDetail', array($sid));
            Helpers::msg_move_page($msg,$url);
        } else{
            // insert
            $data = array(
                'brandName' => $title_new,
                'brandSlug' => $title_slug,
                'brandDescription' => $description,
                'brandContent' => $content,
                'brandThumb' => $name_thumb_img1,
                'brandThumb_alt' => $thumbnail_alt,
                'brandStatus' => $status,
                'created' => $updated,
                'updated' => $updated,
                'seo_title' => $seo_title,
                'seo_keyword' =>$seo_keyword,
                'seo_description' =>$seo_description
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
}
