<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Theme, App\Model\Category_Theme, App\Model\Join_Category_Theme, App\Model\Theme_variable_sku, App\Model\Theme_variable_sku_value;
use Illuminate\Support\Facades\Hash;
use App\Libraries\Helpers;
use Illuminate\Support\Str;
use DB, File, Image, Config;
use Illuminate\Pagination\Paginator;

class ProductController extends Controller
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

    public function listProduct(){
        $data_product = Theme::select('theme.*')
            ->where('theme.group_combo', '=', '')
            ->orderBy('theme.created', 'DESC')
            ->paginate(20);
        $count_item = Theme::select('theme.*')
            ->where('theme.group_combo', '=', '')
            ->count();
        return view('admin.product.index')->with(['data_product' => $data_product, 'total_item' => $count_item]);
    }

    public function searchProduct(Request $rq){
        $query = '';
        
        if(isset($rq->search_title) && $rq->search_title != ''){
            $search_title = $rq->search_title;
        } else{
            $search_title = '';
        }

        if(isset($rq->category_theme) && $rq->category_theme != ''){
            $category = $rq->category_theme;
        } else{
            $category = '';
        }

        if($category != '' && $search_title == ''){
            $data_product = Theme::join('join_category_theme', 'join_category_theme.id_theme', '=', 'theme.id')
                ->join('category_theme', 'category_theme.categoryID', '=', 'join_category_theme.id_category_theme')
                ->where('theme.group_combo', '=', '')
                ->where('category_theme.categoryID', '=', $category)
                ->select('theme.id', 'theme.title', 'theme.slug', 'theme.thubnail', 'theme.price_origin', 'theme.price_promotion', 'theme.start_event', 'theme.end_event', 'theme.item_new', 'theme.flash_sale', 'theme.sale_top_week', 'theme.propose', 'theme.store_status', 'theme.status', 'theme.created')
                ->groupBy('theme.id')
                ->orderBy('theme.created', 'DESC')
                ->paginate(20);
            $count_item = Theme::join('join_category_theme', 'join_category_theme.id_theme', '=', 'theme.id')
                ->join('category_theme', 'category_theme.categoryID', '=', 'join_category_theme.id_category_theme')
                ->where('theme.group_combo', '=', '')
                ->where('category_theme.categoryID', '=', $category)
                ->count();
        }
        if($search_title != '' && $category == ''){
            $data_product = Theme::where('theme.group_combo', '=', '')
                ->where('theme.title', 'LIKE', '%'.$search_title.'%')
                ->select('theme.id', 'theme.title', 'theme.slug', 'theme.thubnail', 'theme.price_origin', 'theme.price_promotion', 'theme.start_event', 'theme.end_event', 'theme.item_new', 'theme.flash_sale', 'theme.sale_top_week', 'theme.propose', 'theme.store_status', 'theme.status', 'theme.created')
                ->orderBy('theme.created', 'DESC')
                ->paginate(20);
            $count_item = Theme::where('theme.group_combo', '=', '')
                ->where('theme.title', 'LIKE', '%'.$search_title.'%')
                ->count();
        }
        if($search_title != '' && $category != ''){
            $data_product = Theme::join('join_category_theme', 'join_category_theme.id_theme', '=', 'theme.id')
                ->join('category_theme', 'category_theme.categoryID', '=', 'join_category_theme.id_category_theme')
                ->where('theme.group_combo', '=', '')
                ->where('category_theme.categoryID', '=', $category)
                ->where('theme.title', 'LIKE', '%'.$search_title.'%')
                ->select('theme.id', 'theme.title', 'theme.slug', 'theme.thubnail', 'theme.price_origin', 'theme.price_promotion', 'theme.start_event', 'theme.end_event', 'theme.item_new', 'theme.flash_sale', 'theme.sale_top_week', 'theme.propose', 'theme.store_status', 'theme.status', 'theme.created')
                ->groupBy('theme.id')
                ->orderBy('theme.created', 'DESC')
                ->paginate(20);
            $count_item = Theme::join('join_category_theme', 'join_category_theme.id_theme', '=', 'theme.id')
                ->join('category_theme', 'category_theme.categoryID', '=', 'join_category_theme.id_category_theme')
                ->where('theme.group_combo', '=', '')
                ->where('category_theme.categoryID', '=', $category)
                ->where('theme.title', 'LIKE', '%'.$search_title.'%')
                ->count();
        }
        
        return view('admin.product.filter')->with(['data_product' => $data_product, 'total_item' => $count_item]);
    }

    public function createProduct(){
        return view('admin.product.single');
    }

    public function productDetail($id){
        $product_detail = Theme::where('theme.id', '=', $id)->first();
        if($product_detail){
            return view('admin.product.single')->with(['product_detail' => $product_detail]);
        } else{
            return view('404');
        }
    }

    public function postProductDetail(Request $rq){
        $datetime_now = date('Y-m-d H:i:s');
        $datetime_convert = strtotime($datetime_now);
        //id post
        $sid = $rq->sid;
        $title_new=htmlspecialchars($rq->post_title);
        $title_en=htmlspecialchars($rq->post_title_en);

        $title_slug=addslashes($rq->post_slug);
        if(empty($title_slug) || $title_slug==''):
           $title_slug=Str::slug($title_new);
        endif;

        //xử lý description
        $description=$rq->post_description;
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
                    $image_name= "/images/upload/product_".$timestamp.'_upload_des'.$k.'.png';
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
                    $image_name= "/images/upload/product_".$timestamp.'_upload_des'.$k.'.png';
                    $path = $_SERVER['DOCUMENT_ROOT'].$image_name;
                    file_put_contents($path, $data);
                    $img->removeAttribute('src');
                    $img->setAttribute('src', $image_name);
                }
            }
            $description_en = $dom->saveHTML();
        }

        //xử lý content
        $content=htmlspecialchars($rq->post_content);
        $content_en=htmlspecialchars($rq->post_content_en);

        //xử lý thumbnail
        $thumbnail_alt=addslashes($rq->post_thumb_alt);
        $name_thumb_img1 = "";
        $image = new Image();
        $name_field = "thumbnail_file";
        
        if($rq->thumbnail_file):
            $file = $rq->file($name_field);
            $timestamp = $datetime_convert;
            $name = "product-".$timestamp. '-' .$file->getClientOriginalName();
            $name_thumb_img1 = $name;
            $image->filePath = $name;
            $url_foder_upload = "/images/product/";
            $file->move(base_path().$url_foder_upload,$name);
        else:
           if(isset($rq->thumbnail_file_link) && $rq->thumbnail_file_link !=""):
               $name_thumb_img1 = $rq->thumbnail_file_link;
           else:
               $name_thumb_img1 = "";
           endif;
        endif;

        $product_detail_weight = htmlspecialchars($rq->product_detail_weight);
        $product_detail_size = htmlspecialchars($rq->product_detail_size);
        $product_detail_ingredients = htmlspecialchars($rq->product_detail_ingredients);
        $product_detail_source = htmlspecialchars($rq->product_detail_source);
        $product_expiry_date = htmlspecialchars($rq->product_expiry_date);
        $theme_code=addslashes($rq->theme_code);

        //time start - end event
        $start_event_get=addslashes($rq->start_event);
        $start_event = date("Y-m-d H:i:s", strtotime($start_event_get));

        $end_event_get=addslashes($rq->end_event);
        $end_event = date("Y-m-d H:i:s", strtotime($end_event_get));

        if(isset($rq->store_status)):
            $store_status=(int)$rq->store_status;
        else:
             $store_status=0;
        endif;

        if(isset($rq->countdown)):
            $countdown=(int)$rq->countdown;
        else:
             $countdown=0;
        endif;

        //xử lý price
        $price_origin = addslashes($rq->price_origin);
        $price_promotion = addslashes($rq->price_promotion);
        if($price_promotion == 0 || $price_promotion == ""){
            $price_promotion = $price_origin;
        }
        if($price_origin == 0 || $price_origin == ""){
            $price_origin = $price_promotion;
        }

        $id_brand = isset($rq->brand_item) ? $rq->brand_item : 0 ;

        $gallery_checked=0;
        if(isset($rq->gallery_checked)):
            $gallery_checked=(int)$rq->gallery_checked;
        endif;

        $seo_title = $rq->seo_title;
        $seo_keyword = $rq->seo_keyword;
        $seo_description = $rq->seo_description;

        //xử lý gallery
        $count_item_gallery = (int)$rq->gallery_item_count;
        $array_group_gallery = array();
        for($m=0;$m<$count_item_gallery;$m++){
            $k=$m+1;
            /********File upload******************************************************/
            $thumbnail_name_arr="";
            if($rq->hasFile('upload_gallery_file0')):
                $file = $rq->file('upload_gallery_file0');
                if(isset($file[$m]) && $file[$m]->getClientOriginalName() !=''):
                    $timestamp = $datetime_convert;
                    $thumbnail_name_arr = "product_".$timestamp. '_theme_gallery_' .$file[$m]->getClientOriginalName();
                    $link_use_thumnail_gallery = $thumbnail_name_arr;
                    $image->filePath = $thumbnail_name_arr;
                    $file[$m]->move(base_path().'/images/product/',$thumbnail_name_arr);
                else:
                    if($rq->input('upload_gallery'.$k) != ""):
                        $link_use_thumnail_gallery = $rq->input('upload_gallery'.$k);
                    else:
                        $link_use_thumnail_gallery = "";
                    endif;
                endif;
            else:
                if($rq->input('upload_gallery'.$k) != ""){
                    $link_use_thumnail_gallery = $rq->input('upload_gallery'.$k);
                } else{
                    $link_use_thumnail_gallery = "";
                }
            endif;
            /****************End*******************/
            if(strlen($link_use_thumnail_gallery) > 0):
                array_push($array_group_gallery, $link_use_thumnail_gallery);
            endif;
        }
        $store_gallery = serialize($array_group_gallery);
        //end xử lý gallery

        $order_short = addslashes($rq->post_order);
        $updated = $rq->created;
        $status = (int)$rq->status;

        if($sid > 0){
            //update
            $data = array(
                'title' => $title_new,
                'title_en' => $title_en,
                'theme_code' => $theme_code,
                'slug' => $title_slug,
                'price_origin' => $price_origin,
                'price_promotion' => $price_promotion,
                'start_event' => $start_event,
                'end_event' => $end_event,
                'countdown' => $countdown,
                'description' => $description,
                'description_en' => $description_en,
                'content' => $content,
                'content_en' => $content_en,
                'group_combo' => '',
                'id_brand' => $id_brand,
                'thubnail' => $name_thumb_img1,
                'thubnail_alt' => $thumbnail_alt,
                'store_status' => $store_status,
                'seo_title' => $seo_title,
                'seo_keyword' => $seo_keyword,
                'seo_description' => $seo_description,
                'gallery_images' => $store_gallery,
                'gallery_checked' => $gallery_checked,
                'order_short' => $order_short,
                'updated' => $datetime_now,
                'status' => $status,
                'product_detail_size'=> $product_detail_size,
                'product_detail_weight'=> $product_detail_weight,
                'product_detail_ingredients'=> $product_detail_ingredients,
                'product_detail_source'=> $product_detail_source,
                'product_expiry_date' => $product_expiry_date
            );

            $loadDelete = Join_Category_Theme::where('id_theme','=',$sid)->delete();

            $category_items = [];
            $category_items = isset($rq->category_item) ? $rq->category_item : $category_items ;
            for($u=0; $u < count($category_items); $u++)
            {
                if($category_items[$u] > 0):
                    $datas_box = array
                    (
                        "id_category_theme" => $category_items[$u],
                        "id_theme" => $sid
                    );
                    $res_incheckbox = Join_Category_Theme::create($datas_box);
                endif;
            }

            /*Biến thể================================================================================================*/
            //sô luong bien the chính
            $count_list_variables_parents=isset($rq->number_parent_variable) ? $rq->number_parent_variable : 0;
            //so luong child variables
            $count_list_variables_childs=isset($rq->count_item_list) ? $rq->count_item_list : 0;
            //group parrent
            $parent_variable_groups = isset($rq->parent_variable_group) ? $rq->parent_variable_group : 0;
            $parent_variable_group = explode(",", $parent_variable_groups);
            $loadDelete_variable = Theme_variable_sku::where('id_theme','=',$sid)->delete();
            $loadDelete_variable_value = Theme_variable_sku_value::where('id_theme','=',$sid)->delete();
            if($count_list_variables_childs > 0):
                $datas_box_variable = array();
                $id_insert_variable = 0;
                for($ch=0; $ch < $count_list_variables_childs; $ch++):
                    $price_variable = $rq->input('price_aviable_'.$ch) > 0 ? $rq->input('price_aviable_'.$ch) : 0;
                    $price_variable = (int)$price_variable;
                    /********File upload Variable******************************************************/
                    $thumbnail_name_variable_arr = "";
                    $link_use_variable_gallery = "";
                    if($rq->hasFile('upload_gallery_variable_'.$ch)):
                        $file_variable = $rq->file('upload_gallery_variable_'.$ch);
                        $timestamp = $datetime_convert;
                        $thumbnail_name_variable_arr = "product_".$timestamp. '_variable_images_' .$file_variable->getClientOriginalName();
                        $link_use_variable_gallery = $thumbnail_name_variable_arr;
                        $file_variable->move(base_path().'/images/product/',$thumbnail_name_variable_arr);
                    else:
                        if($rq->input('text_upload_gallery_variable_'.$ch) != ""){
                            $link_use_variable_gallery = $rq->input('text_upload_gallery_variable_'.$ch);
                        } else{
                            $link_use_variable_gallery = "";
                        }
                    endif;
                    /****************End Upload Variable*******************/
                    if($price_variable > 0):
                        $datas_box_variable = array
                        (
                            "price" => $price_variable,
                            "sku" => '',
                            "id_theme" => $sid,
                            "thumbnail" => $link_use_variable_gallery,
                            "icon" => '',
                            "qty" => 0,
                            "status" => 0,
                            "created" => $datetime_now,
                            "updated" => $datetime_now
                        );
                        $res_incheckbox_variable = Theme_variable_sku::create($datas_box_variable);
                        $id_insert_variable = $res_incheckbox_variable->id;
                        if($id_insert_variable > 0):
                            if($count_list_variables_parents > 0):
                                $variable_key_child = "";
                                $variable_parentID = 0;
                                $res_incheckbox_variable_value = "";
                                $u = 0;
                                for($th=1; $th <= $count_list_variables_parents; $th++):
                                    $u = $th-1;
                                    $variable_key_child = $rq->input('variable_'.$ch.$th) > 0 ? $rq->input('variable_'.$ch.$th) : 0;
                                    $variable_key_child = (int)$variable_key_child;
                                    if(isset($parent_variable_group[$u]) && $parent_variable_group[$u] > 0 && $variable_key_child > 0):
                                        $variable_parentID = (int)$parent_variable_group[$u];
                                        $datas_box_variable_value = array
                                        (
                                            "id_theme" => $sid,
                                            "variable_themeID" => $variable_key_child,
                                            "variable_parentID" => $variable_parentID,
                                            "theme_variable_sku_id" => $id_insert_variable,
                                            "status" => 0,
                                            "created" => $datetime_now,
                                            "updated" => $datetime_now
                                        );
                                        $res_incheckbox_variable_value = Theme_variable_sku_value::create($datas_box_variable_value);
                                    endif;
                                endfor;
                            endif;
                        endif;
                    endif;    //nếu giá =0 sẽ ko insert
                endfor;
            endif;
            /*End Biến thể================================================================================================*/

            $respons = Theme::where ("id","=",$sid)->update($data);
            $msg = "Product has been Updated";
            $url= route('admin.productDetail', array($sid));
            Helpers::msg_move_page($msg,$url);
        } else{
            // insert
            $data = array(
                'title' => $title_new,
                'title_en' => $title_en,
                'theme_code' => $theme_code,
                'slug' => $title_slug,
                'price_origin' => $price_origin,
                'price_promotion' => $price_promotion,
                'start_event' => $start_event,
                'end_event' => $end_event,
                'countdown' => $countdown,
                'description' => $description,
                'description_en' => $description_en,
                'content' => $content,
                'content_en' => $content_en,
                'group_combo' => '',
                'id_brand' => $id_brand,
                'thubnail' => $name_thumb_img1,
                'thubnail_alt' => $thumbnail_alt,
                'store_status' => $store_status,
                'seo_title' => $seo_title,
                'seo_keyword' => $seo_keyword,
                'seo_description' => $seo_description,
                'gallery_images' => $store_gallery,
                'gallery_checked' => $gallery_checked,
                'order_short' => $order_short,
                'created' => $updated,
                'updated' => $updated,
                'status' => $status,
                'product_detail_size'=> $product_detail_size,
                'product_detail_weight'=> $product_detail_weight,
                'product_detail_ingredients'=> $product_detail_ingredients,
                'product_detail_source'=> $product_detail_source,
                'product_expiry_date' => $product_expiry_date
            );
            $respons = Theme::create($data);
            $id_insert = $respons->id;

            if($id_insert>0):
                $category_items=[];
                $category_items=isset($rq->category_item) ? $rq->category_item : $category_items ;
                for($u=0;$u<count($category_items);$u++)
                {
                    if($category_items[$u]>0):
                        $datas_box=array(
                            "id_category_theme" => $category_items[$u],
                            "id_theme" => $id_insert
                        );
                        $res_incheckbox = Join_Category_Theme::create($datas_box);
                    endif;
                }
                /*Biến thể================================================================================================*/
                //sô luong bien the chính
                $count_list_variables_parents=isset($rq->number_parent_variable) ? $rq->number_parent_variable : 0;
                //so luong child variables
                $count_list_variables_childs=isset($rq->count_item_list) ? $rq->count_item_list : 0;
                //group parrent
                $parent_variable_groups = isset($rq->parent_variable_group) ? $rq->parent_variable_group : 0;
                $parent_variable_group = explode(",", $parent_variable_groups);
                if($count_list_variables_childs > 0):
                    $datas_box_variable = array();
                    $id_insert_variable = 0;
                    $thumbnail_name_variable_arr = "";
                    $link_use_variable_gallery = "";
                    for($ch=0; $ch < $count_list_variables_childs; $ch++):
                        $price_variable = $rq->input('price_aviable_'.$ch) > 0 ? $rq->input('price_aviable_'.$ch) : 0;
                        $price_variable = (int)$price_variable;
                        /********File upload Variable******************************************************/
                        if($price_variable > 0):
                            $thumbnail_name_variable_arr = "";
                            $link_use_variable_gallery = "";
                            if($rq->hasFile('upload_gallery_variable_'.$ch)):
                                $file_variable = $rq->file('upload_gallery_variable_'.$ch);
                                $timestamp = $datetime_convert;
                                $thumbnail_name_variable_arr = "product_".$timestamp. '_variable_images_' .$file_variable->getClientOriginalName();
                                $link_use_variable_gallery = $thumbnail_name_variable_arr;
                                $file_variable->move(base_path().'/images/product/',$thumbnail_name_variable_arr);
                            else:
                                if($rq->input('text_upload_gallery_variable_'.$ch) != ""){
                                    $link_use_variable_gallery = $rq->input('text_upload_gallery_variable_'.$ch);
                                } else{
                                    $link_use_variable_gallery = "";
                                }
                            endif;
                            /****************End Upload Variable*******************/
                            $datas_box_variable=array
                            (
                                "price" => $price_variable,
                                "sku" => '',
                                "id_theme" => $id_insert,
                                "thumbnail" => $link_use_variable_gallery,
                                "icon" => '',
                                "qty" => 0,
                                "status" => 0,
                                "created" => $datetime_now,
                                "updated" => $datetime_now
                            );
                            $res_incheckbox_variable = Theme_variable_sku::create($datas_box_variable);
                            $id_insert_variable = $res_incheckbox_variable->id;
                            if($id_insert_variable > 0):
                                if($count_list_variables_parents > 0):
                                    $variable_key_child = "";
                                    $variable_parentID = 0;
                                    for($th=0; $th < $count_list_variables_parents; $th++):
                                        $thh = $th+1;
                                        $variable_key_child = $rq->input('variable_'.$ch.$thh) > 0 ? $rq->input('variable_'.$ch.$thh) : 0;
                                        $variable_key_child = (int)$variable_key_child;
                                        if(isset($parent_variable_group[$th]) && $parent_variable_group[$th] > 0 && $variable_key_child > 0):
                                            $variable_parentID = (int)$parent_variable_group[$th];
                                            $datas_box_variable_value = array(
                                                "id_theme" => $id_insert,
                                                "variable_themeID" => $variable_key_child,
                                                "variable_parentID" => $variable_parentID,
                                                "theme_variable_sku_id" => $id_insert_variable,
                                                "status" => 0,
                                                "created" => $datetime_now,
                                                "updated" => $datetime_now
                                            );
                                            $res_incheckbox_variable_value = Theme_variable_sku_value::create($datas_box_variable_value);
                                        endif;
                                    endfor;
                                endif;
                            endif;
                        endif;
                    endfor;
                endif;
                /*End Biến thể================================================================================================*/
                $msg = "Product has been registered";
                $url= route('admin.productDetail', array($id_insert));
                Helpers::msg_move_page($msg,$url);
            endif;
        }
        
    }
}
