<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Variable_Theme;
use App\Libraries\Helpers;
use Illuminate\Support\Str;
use DB, File, Image, Config;

class VariableProductController extends Controller
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

    public function listVariableProduct(){
        $data_variable = Variable_Theme::select('variable_theme.*')
            ->where('variable_theme.variable_theme_parent', '=', 0)
            ->orderBy('variable_theme.created', 'DESC')
            ->paginate(20);
        return view('admin.variable.index')->with(['data_variable' => $data_variable]);
    }
    public function searchVariableProduct(Request $rq){
        if($rq->search_title != ''){
            $data_variable = Variable_Theme::select('variable_theme.*')
                ->where('variable_theme.variable_theme_name', 'LIKE', '%'.$rq->search_title.'%')
                ->orderBy('variable_theme.created', 'DESC')
                ->paginate(20);
        } else{
            $data_variable = Variable_Theme::select('variable_theme.*')
                ->orderBy('variable_theme.created', 'DESC')
                ->paginate(20);
        }
        return view('admin.variable.search')->with(['data_variable' => $data_variable]);
    }
    public function createVariableProduct(){
        return view('admin.variable.single');
    }

    public function variableProductDetail($id){
        $post_variable = Variable_Theme::where('variable_theme.variable_themeID', '=', $id)->first();
        if($post_variable){
            return view('admin.variable.single')->with(['post_variable' => $post_variable]);
        } else{
            return view('404');
        }
    }

    public function postVariableProductDetail(Request $rq){
        //id post
        $sid = $rq->sid;
        $title_new = $rq->post_title;
        $title_en = $rq->post_title_en;

        $title_slug = addslashes($rq->post_slug);
        if(empty($title_slug) || $title_slug == ''):
           $title_slug = Str::slug($title_new);
        endif;
        $category_parent = (int)$rq->category_parent;

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
                    $image_name= "/images/upload/variable_product_".$timestamp.'_upload_des'.$k.'.png';
                    $path = $_SERVER['DOCUMENT_ROOT'].$image_name;
                    file_put_contents($path, $data);
                    $img->removeAttribute('src');
                    $img->setAttribute('src', $image_name);
                }
            }
            $description = $dom->saveHTML();
        }

        $description_en = $rq->post_description_en;
        if($description_en != ''){
            $dom = new \DomDocument();
            libxml_use_internal_errors(true);
            $dom->loadHtml('<?xml encoding="utf-8" ?>'.$description_en, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
            $images = $dom->getElementsByTagName('img');
            foreach($images as $k => $img){
                $data = $img->getAttribute('src');
                $check_img_is_upload = str_replace( 'data:image', '', $data);
                if ($check_img_is_upload != $data){
                    list($type, $data) = explode(';', $data);
                    list(, $data)      = explode(',', $data);
                    $data = base64_decode($data);
                    $timestamp = $datetime_convert;
                    $image_name= "/images/upload/variable_product_".$timestamp.'_upload_des'.$k.'.png';
                    $path = $_SERVER['DOCUMENT_ROOT'].$image_name;
                    file_put_contents($path, $data);
                    $img->removeAttribute('src');
                    $img->setAttribute('src', $image_name);
                }
            }
            $description_en = $dom->saveHTML();
        }

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
            $name = "variable_product-".$timestamp. '-' .$file->getClientOriginalName();
            $name_thumb_img1 = $name;
            $image->filePath = $name;
            $url_foder_upload = "/images/variable/";
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
                'variable_theme_name' => $title_new,
                'variable_theme_name_en' => $title_en,
                'variable_theme_slug' => $title_slug,
                'variable_theme_parent' => $category_parent,
                'variable_theme_description' => $description,
                'variable_theme_description_en' => $description_en,
                'thubnail' => $name_thumb_img1,
                'thubnail_alt' => $thumbnail_alt,
                'seo_title' => $seo_title,
                'seo_keyword' =>$seo_keyword,
                'seo_description' =>$seo_description,
                'updated' => date('Y-m-d h:i:s'),
                'variable_theme_status' => $status
            );
            $respons = Variable_Theme::where ("variable_themeID", "=", $sid)->update($data);
            $msg = "Variable has been Updated";
            $url = route('admin.variableProductDetail', array($sid));
            Helpers::msg_move_page($msg,$url);
        } else{
            // insert
            $data = array(
                'variable_theme_name' => $title_new,
                'variable_theme_name_en' => $title_en,
                'variable_theme_slug' => $title_slug,
                'variable_theme_parent' => $category_parent,
                'variable_theme_description' => $description,
                'variable_theme_description_en' => $description_en,
                'thubnail' => $name_thumb_img1,
                'thubnail_alt' => $thumbnail_alt,
                'seo_title' => $seo_title,
                'seo_keyword' =>$seo_keyword,
                'seo_description' =>$seo_description,
                'created' => $updated,
                'updated' => $updated,
                'variable_theme_status' => $status
            );
            $respons = Variable_Theme::create($data);
            $id_insert= $respons->id;
            if($id_insert>0):
                $msg = "Variable has been registered";
                $url = route('admin.variableProductDetail', array($id_insert));
                Helpers::msg_move_page($msg,$url);
            endif;
        }
        
    }
}
