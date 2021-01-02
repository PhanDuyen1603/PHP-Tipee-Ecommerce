<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Category_Theme;
use App\Libraries\Helpers;
use Illuminate\Support\Str;
use DB, File, Image, Config;

class CategoryProductController extends Controller
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

    public function listCategoryProduct(){
        $data_category = Category_Theme::select('category_theme.*')
            ->orderBy('category_theme.created', 'DESC')
            ->paginate(20);
        return view('admin.category-product.index')->with(['data_category' => $data_category]);
    }
    public function searchCategoryProduct(Request $rq){
        if($rq->search_title != ''){
            $data_category = Category_Theme::select('category_theme.*')
                ->where('category_theme.categoryName', 'LIKE', '%'.$rq->search_title.'%')
                ->orderBy('category_theme.created', 'DESC')
                ->paginate(20);
        } else{
            $data_category = Category_Theme::select('category_theme.*')
                ->orderBy('category_theme.created', 'DESC')
                ->paginate(20);
        }
        return view('admin.category-product.search')->with(['data_category' => $data_category]);
    }
    public function createCategoryProduct(){
        return view('admin.category-product.single');
    }

    public function categoryProductDetail($id){
        $post_category = Category_Theme::where('category_theme.categoryID', '=', $id)->first();
        if($post_category){
            return view('admin.category-product.single')->with(['post_category' => $post_category]);
        } else{
            return view('404');
        }
    }

    public function postCategoryProductDetail(Request $rq){
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
                    $image_name= "/images/upload/category_product_".$timestamp.'_upload_des'.$k.'.png';
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
                    $image_name= "/images/upload/category_product_".$timestamp.'_upload_des'.$k.'.png';
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
            $name = "category_product-".$timestamp. '-' .$file->getClientOriginalName();
            $name_thumb_img1 = $name;
            $image->filePath = $name;
            $url_foder_upload = "/images/category/";
            $file->move(base_path().$url_foder_upload,$name);
        else:
           if(isset($rq->thumbnail_file_link) && $rq->thumbnail_file_link !=""):
               $name_thumb_img1 = $rq->thumbnail_file_link;
           else:
               $name_thumb_img1 = "";
           endif;
        endif;

        $categoryShort=(int)$rq->post_short;
        $categoryIndex=0;
        if(isset($rq->categoryIndex)):
            $categoryIndex=(int)$rq->categoryIndex;
        endif;

        $check_showhome=0;
        if(isset($rq->check_showhome)):
            $check_showhome=(int)$rq->check_showhome;
        endif;

        $theme_category_icon = htmlspecialchars($rq->theme_category_icon);

        $seo_title = $rq->seo_title;
        $seo_keyword = $rq->seo_keyword;
        $seo_description = $rq->seo_description;

        $updated = $rq->created;
        $status = (int)$rq->status;

        if($sid > 0){
            //update
            $data = array(
                'categoryName' => $title_new,
                'categoryName_en' => $title_en,
                'categorySlug' => $title_slug,
                'categoryParent' => $category_parent,
                'categoryDescription' => $description,
                'categoryDescription_en' => $description_en,
                'thubnail' => $name_thumb_img1,
                'thubnail_alt' => $thumbnail_alt,
                'categoryShort' => $categoryShort,
                'categoryIndex' => $categoryIndex,
                'showhome' => $check_showhome,
                'theme_category_icon' => $theme_category_icon,
                'seo_title' => $seo_title,
                'seo_keyword' =>$seo_keyword,
                'seo_description' =>$seo_description,
                'updated' => date('Y-m-d h:i:s'),
                'status_category' => $status
            );
            $respons = Category_Theme::where ("categoryID", "=", $sid)->update($data);
            $msg = "Category has been Updated";
            $url = route('admin.categoryProductDetail', array($sid));
            Helpers::msg_move_page($msg,$url);
        } else{
            // insert
            $data = array(
                'categoryName' => $title_new,
                'categoryName_en' => $title_en,
                'categorySlug' => $title_slug,
                'categoryParent' => $category_parent,
                'categoryDescription' => $description,
                'categoryDescription_en' => $description_en,
                'thubnail' => $name_thumb_img1,
                'thubnail_alt' => $thumbnail_alt,
                'categoryShort' => $categoryShort,
                'categoryIndex' => $categoryIndex,
                'showhome' => $check_showhome,
                'theme_category_icon' => $theme_category_icon,
                'seo_title' => $seo_title,
                'seo_keyword' =>$seo_keyword,
                'seo_description' =>$seo_description,
                'created' => $updated,
                'updated' => $updated,
                'status_category' => $status
            );
            $respons = Category_Theme::create($data);
            $id_insert= $respons->categoryID;
            if($id_insert>0):
                $msg = "Category has been registered";
                $url = route('admin.categoryProductDetail', array($id_insert));
                Helpers::msg_move_page($msg,$url);
            endif;
        }
        
    }
}
