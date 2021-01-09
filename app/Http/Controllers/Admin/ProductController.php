<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Product, App\Model\CategoryProduct, App\Model\JoinCategoryProduct, App\Model\ProductVariableSku, App\Model\ProductVariableSkuValue;
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
        $data_product = Product::select('*')
            ->orderBy('created', 'DESC')
            ->paginate(20);
        $count_item = Product::select('*')
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
            $data_product = Product::join('join_category_product', 'join_category_product.id_product', '=', 'products.id')
                ->join('category_products', 'category_products.categoryID', '=', 'join_category_product.id_category_product')
                ->where('products.group_combo', '=', '')
                ->where('category_products.categoryID', '=', $category)
                ->select('products.id', 'products.title', 'products.slug', 'products.thubnail', 'products.price_origin', 'products.price_promotion', 'products.start_event', 'products.end_event', 'products.item_new', 'products.flash_sale', 'products.sale_top_week', 'products.propose', 'products.store_status', 'products.status', 'products.created')
                ->groupBy('products.id')
                ->orderBy('products.created', 'DESC')
                ->paginate(20);
            $count_item = Product::join('join_category_product', 'join_category_product.id_product', '=', 'products.id')
                ->join('category_products', 'category_products.categoryID', '=', 'join_category_product.id_category_product')
                ->where('products.group_combo', '=', '')
                ->where('category_products.categoryID', '=', $category)
                ->count();
        }
        if($search_title != '' && $category == ''){
            $data_product = Product::where('products.group_combo', '=', '')
                ->where('products.title', 'LIKE', '%'.$search_title.'%')
                ->select('products.id', 'products.title', 'products.slug', 'products.thubnail', 'products.price_origin', 'products.price_promotion', 'products.start_event', 'products.end_event', 'products.item_new', 'products.flash_sale', 'products.sale_top_week', 'products.propose', 'products.store_status', 'products.status', 'products.created')
                ->orderBy('products.created', 'DESC')
                ->paginate(20);
            $count_item = Product::where('products.group_combo', '=', '')
                ->where('products.title', 'LIKE', '%'.$search_title.'%')
                ->count();
        }
        if($search_title != '' && $category != ''){
            $data_product = Product::join('join_category_product', 'join_category_product.id_product', '=', 'products.id')
                ->join('category_products', 'category_products.categoryID', '=', 'join_category_product.id_category_product')
                ->where('products.group_combo', '=', '')
                ->where('category_products.categoryID', '=', $category)
                ->where('products.title', 'LIKE', '%'.$search_title.'%')
                ->select('products.id', 'products.title', 'products.slug', 'products.thubnail', 'products.price_origin', 'products.price_promotion', 'products.start_event', 'products.end_event', 'products.item_new', 'products.flash_sale', 'products.sale_top_week', 'products.propose', 'products.store_status', 'products.status', 'products.created')
                ->groupBy('products.id')
                ->orderBy('products.created', 'DESC')
                ->paginate(20);
            $count_item = Product::join('join_category_product', 'join_category_product.id_product', '=', 'products.id')
                ->join('category_products', 'category_products.categoryID', '=', 'join_category_product.id_category_product')
                ->where('products.group_combo', '=', '')
                ->where('category_products.categoryID', '=', $category)
                ->where('products.title', 'LIKE', '%'.$search_title.'%')
                ->count();
        }
        
        return view('admin.product.filter')->with(['data_product' => $data_product, 'total_item' => $count_item]);
    }

    public function createProduct(){
        return view('admin.product.single');
    }

    public function productDetail($id){
        $product_detail = Product::where('products.id', '=', $id)->first();
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
        //xử lý content
        $content=htmlspecialchars($rq->post_content);
        //xử lý thumbnail
        $thumbnail_alt=addslashes($rq->post_thumb_alt);
        $name_thumb_img1 = "";
        // $image = new Image();
        $name_field = "thumbnail_file";
        
        if($rq->thumbnail_file):
            $file = $rq->file($name_field);
            $timestamp = $datetime_convert;
            $name = "product-".$timestamp. '-' .$file->getClientOriginalName();
            $name_thumb_img1 = $name;
            // $image->filePath = $name;
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
        $product_code=addslashes($rq->product_code);
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
                    // $image->filePath = $thumbnail_name_arr;
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
                'product_code' => $product_code,
                'slug' => $title_slug,
                'price_origin' => $price_origin,
                'price_promotion' => $price_promotion,
                'start_event' => $start_event,
                'end_event' => $end_event,
                'countdown' => $countdown,
                'description' => $description,
                'content' => $content,
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

            $loadDelete = JoinCategoryProduct::where('id_product','=',$sid)->delete();

            $category_items = [];
            $category_items = isset($rq->category_item) ? $rq->category_item : $category_items ;
            for($u=0; $u < count($category_items); $u++)
            {
                if($category_items[$u] > 0):
                    $datas_box = array
                    (
                        "id_category_product" => $category_items[$u],
                        "id_product" => $sid
                    );
                    $res_incheckbox = JoinCategoryProduct::create($datas_box);
                endif;
            }

           
            $respons = Product::where ("id","=",$sid)->update($data);
            $msg = "Product has been Updated";
            $url= route('admin.productDetail', array($sid));
            Helpers::msg_move_page($msg,$url);
        } else{
            // insert
            $data = array(
                'title' => $title_new,
                'product_code' => $product_code,
                'slug' => $title_slug,
                'price_origin' => $price_origin,
                'price_promotion' => $price_promotion,
                'start_event' => $start_event,
                'end_event' => $end_event,
                'countdown' => $countdown,
                'description' => $description,
                'content' => $content,
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
            $respons = Product::create($data);
            $id_insert = $respons->id;

            if($id_insert>0):
                $category_items=[];
                $category_items=isset($rq->category_item) ? $rq->category_item : $category_items ;
                for($u=0;$u<count($category_items);$u++)
                {
                    if($category_items[$u]>0):
                        $datas_box=array(
                            "id_category_product" => $category_items[$u],
                            "id_product" => $id_insert
                        );
                        $res_incheckbox = JoinCategoryProduct::create($datas_box);
                    endif;
                }
                 $msg = "Product has been registered";
                $url= route('admin.productDetail', array($id_insert));
                Helpers::msg_move_page($msg,$url);
            endif;
        }
        
    }
}
