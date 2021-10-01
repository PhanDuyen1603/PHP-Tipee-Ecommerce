<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Libraries\Helpers;
use App\Http\Controllers\Controller;
use App\Model\Post, App\Model\Page, App\Model\Join_Category_Post, App\Model\Category, App\Model\Theme, App\Model\Join_Category_Theme, App\Model\Category_Theme, App\Model\Variable_Theme, App\Model\Theme_variable_sku_value, App\Model\Theme_variable_sku, App\Model\Brand, App\Model\Slishow, App\Model\Addtocard, App\Model\Video_page, App\Model\Discount_code;

class AjaxController extends Controller
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

    public function ajax_delete(Request $rq){
        $type = $rq->type;
        $check_data = $rq->seq_list;
        $arr = array();
        $values = "";
        for($i=0;$i<count($check_data);$i++):
            $values .= (int)$check_data[$i].",";
            $arr[]=(int)$check_data[$i];
        endfor;
        $groupID = substr($values, 0, -1);
        switch ($type) {
            case 'video':
                //xóa thumbnail
                $url_upload = $_SERVER['DOCUMENT_ROOT'].'/images/videos/';
                foreach ($arr as $it) {
                    $data_page = Video_page::where('id', '=', $it)->get();
                    foreach ($data_page as $row) { 
                        $img = $row->thumb;
                        if($img != ''){
                            $pt = $url_upload.$img; 
                            if (file_exists($pt))
                            {
                                unlink($pt);
                            }
                        }
                    }
                }
                $loadDelete = Video_page::whereIn('id', $arr)->delete();
                return 1;
                break;
            case 'page':
                //xóa thumbnail
                $url_upload = $_SERVER['DOCUMENT_ROOT'].'/images/page/';
                foreach ($arr as $it) {
                    $data_page = Page::where('id', '=', $it)->get();
                    foreach ($data_page as $row) { 
                        $img = $row->thubnail;
                        if($img != ''){
                            $pt = $url_upload.$img; 
                            if (file_exists($pt))
                            {
                                unlink($pt);
                            }
                        }
                    }
                }
                $loadDelete = Page::whereIn('id', $arr)->delete();
                return 1;
                break;
            case 'post':
                //xóa thumbnail
                $url_upload = $_SERVER['DOCUMENT_ROOT'].'/images/article/';
                foreach ($arr as $it) {
                    $data_post = Post::where('id', '=', $it)->get();
                    foreach ($data_post as $row) { 
                        $img = $row->thubnail;
                        if($img != ''){
                            $pt = $url_upload.$img; 
                            if (file_exists($pt))
                            {
                                unlink($pt);
                            }
                        }
                    }
                }
                $loadDelete = Post::whereIn('id', $arr)->delete();
                $loadDeleteJoin = Join_Category_Post::whereIn('id_post', $arr)->delete();
                return 1;
                break;
            case 'category':
                //xóa thumbnail
                $url_upload = $_SERVER['DOCUMENT_ROOT'].'/images/category/';
                foreach ($arr as $it) {
                    $data_category = Category::where('categoryID', '=', $it)->get();
                    foreach ($data_category as $row) { 
                        $img = $row->thubnail;
                        if($img != ''){
                            $pt = $url_upload.$img; 
                            if (file_exists($pt))
                            {
                                unlink($pt);
                            }
                        }
                    }
                }
                $loadDelete = Category::whereIn('categoryID', $arr)->delete();
                return 1;
                break;
            case 'product':
                //xóa thumbnail
                $url_upload = $_SERVER['DOCUMENT_ROOT'].'/images/product/';
                foreach ($arr as $it) {
                    $data_product = Theme::where('id', '=', $it)->get();
                    foreach ($data_product as $row) { 
                        $img = $row->thubnail;
                        if($img != ''){
                            $pt = $url_upload.$img; 
                            if (file_exists($pt))
                            {
                                unlink($pt);
                            }
                        }
                    }
                }
                $loadDelete = Theme::whereIn('id', $arr)->delete();
                $loadDeleteJoin = Join_Category_Theme::whereIn('id_theme', $arr)->delete();
                $loadDeleteVariableSku = Theme_variable_sku::whereIn('id_theme', $arr)->delete();
                $loadDeleteVariableSkuValue = Theme_variable_sku_value::whereIn('id_theme', $arr)->delete();
                return 1;
                break;
            case 'category_product':
                //xóa thumbnail
                $url_upload = $_SERVER['DOCUMENT_ROOT'].'/images/category/';
                foreach ($arr as $it) {
                    $data_category = Category_Theme::where('categoryID', '=', $it)->get();
                    foreach ($data_category as $row) { 
                        $img = $row->thubnail;
                        if($img != ''){
                            $pt = $url_upload.$img; 
                            if (file_exists($pt))
                            {
                                unlink($pt);
                            }
                        }
                    }
                }
                $loadDelete = Category_Theme::whereIn('categoryID', $arr)->delete();
                return 1;
                break;
            case 'order':
                $loadDelete = Addtocard::whereIn('cart_id', $arr)->delete();
                return 1;
                break;
            case 'variable_product':
                $loadDelete = Variable_Theme::whereIn('variable_themeID', $arr)->delete();
                return 1;
                break;
            case 'brand':
                //xóa thumbnail
                $url_upload = $_SERVER['DOCUMENT_ROOT'].'/images/brand/';
                foreach ($arr as $it) {
                    $data_brand = Brand::where('brandID', '=', $it)->get();
                    foreach ($data_brand as $row) { 
                        $img = $row->brandThumb;
                        if($img != ''){
                            $pt = $url_upload.$img; 
                            if (file_exists($pt))
                            {
                                unlink($pt);
                            }
                        }
                    }
                }
                $loadDelete = Brand::whereIn('brandID', $arr)->delete();
                return 1;
                break;
            case 'slider':
                //xóa thumbnail
                $url_upload = $_SERVER['DOCUMENT_ROOT'];
                foreach ($arr as $it) {
                    $data_slider = Slishow::where('id', '=', $it)->get();
                    foreach ($data_slider as $row) { 
                        $img_pc = $row->src;
                        if($img_pc != ''){
                            $pt = $url_upload.$img_pc; 
                            if (file_exists($pt))
                            {
                                unlink($pt);
                            }
                        }

                        $img_mobile = $row->src_mobile;
                        if($img_mobile != ''){
                            $pt = $url_upload.$img_mobile; 
                            if (file_exists($pt))
                            {
                                unlink($pt);
                            }
                        }
                    }
                }
                $loadDelete = Slishow::whereIn('id', $arr)->delete();
                return 1;
                break;
            case 'discount-code':
                $loadDelete = Discount_code::whereIn('id', $arr)->delete();
                return 1;
                break;
            default:
                # code...
                break;
        }
    }

    public function processThemeFast(Request $request){
        $id = (int)$request->id;
        $origin_price = $request->origin_price;
        $promotion_price = $request->promotion_price;
        // $order_short = $request->order_short;
        $start_event = $request->start_event;
        $end_event = $request->end_event;
        if($id>0):
            $data = array(
                'price_origin' => $origin_price,
                'price_promotion' => $promotion_price,
                // 'order_short' => $order_short,
                'start_event' => $start_event,
                'end_event' => $end_event,
                'updated' => date('Y-m-d H:i:s')
            );
            $respons =Theme::where ("id","=",$id)->update($data);
            echo 'OK';
        else:
            echo 'Lỗi';
        endif;
        exit();
    }

    public function update_new_item_status(Request $request){
        if(isset($request['check']) && $request['sid']!=""):
            $status = $request['check'];
            $postID = (int)$request['sid'];
            if($postID>0):
                $respons1 = Theme::where ("id","=",$postID)->update(array('item_new'=>$status));
                echo "OK";
            else:
                echo "Lỗi";
            endif;
        endif;
    }

    public function update_process_flash_sale(Request $request){
        if(isset($request['check']) && $request['sid']!=""):
            $status=$request['check'];
            $postID=(int)$request['sid'];
            if($postID>0):
                $respons1 = Theme::where ("id","=",$postID)->update(array('flash_sale'=>$status));
                echo "OK";
            else:
                echo "Lỗi";
            endif;
        endif;
    }

    public function update_process_sale_top_week(Request $request){
        if(isset($request['check']) && $request['sid']!=""):
            $status=$request['check'];
            $postID=(int)$request['sid'];
            if($postID>0):
                $respons1 = Theme::where ("id","=",$postID)->update(array('sale_top_week'=>$status));
                echo "OK";
            else:
                echo "Lỗi";
            endif;
        endif;
    }

    public function update_process_propose(Request $request){
        if(isset($request['check']) && $request['sid']!=""):
            $status=$request['check'];
            $postID=(int)$request['sid'];
            if($postID>0):
                $respons1 = Theme::where ("id","=",$postID)->update(array('propose'=>$status));
                echo "OK";
            else:
                echo "Lỗi";
            endif;
        endif;
    }

    public function updateStoreStatus(Request $request){
        if(isset($request['check']) && $request['sid'] != ""):
            $status = $request['check'];
            $postID = (int)$request['sid'];
            if($postID > 0):
                $respons1 = Theme::where ("id", "=", $postID)->update(array('store_status' => $status));
                echo "OK";
            else:
                echo "Lỗi";
            endif;
        endif;
    }

    public function loadVariable(){
        $result="";
        $child_parent=array();
        $slug_variable_parrent="";
        $group_child=array();
        $html_col_header="";
        $datas = json_decode(stripslashes($_POST['data']));
        $id_key_parent="";
        $count_item=count($datas);
        if($datas && count($datas)>0):
            $mh=0;
            for($i=0; $i<count($datas); $i++):
                $mh++;
                $variable_child="";
                $key_child="";
                $array_child=array();
                $variable_id=(int)$datas[$i];
                if($variable_id>0):
                    $variables=Variable_Theme::where('variable_themeID',$variable_id)
                    ->where('variable_theme_status',0)
                    ->first();
                    if($variables):
                        $slug_variable_parrent=$variables->variable_theme_slug;
                        $variable_childs=Variable_Theme::where('variable_theme_parent',$variable_id)
                            ->where('variable_theme_status',0)
                            ->get();
                        if($variable_childs):
                            $html_col_header .='<div class="table-cell readonly">'.$variables->variable_theme_name.'</div>';
                            $id_key_parent .=$variables->variable_themeID.",";
                            foreach ($variable_childs as $variable_child):
                                $key_child=$variable_child->variable_theme_slug;
                                //$array_key[$key_child]=array($variable_child->variable_theme_name);
                                $array_child[$key_child]=$variable_child->variable_theme_name."_".$variable_child->variable_themeID;
                                $group_child=$array_child;
                            endforeach;
                        endif;
                    endif;
                endif;
                $child_parent[$slug_variable_parrent] =$group_child;
            endfor;
            //print_r($child_parent);
            $array_fitters=Helpers::variations($child_parent);
            if($array_fitters && count($array_fitters)>0):
                    $id_key_parent=substr($id_key_parent, 0, -1);
                    //print_r($array_fitters);
                    $result .='<input type="hidden" name="parent_variable_group" value="'.$id_key_parent.'"/>
                    <div class="edit-main variation-table">
                        <div class="table-header">
                            <input type="hidden" name="number_parent_variable" id="number_parent_variable" value="'.$mh.'"/>
                            '.$html_col_header.'
                            <div class="table-cells">
                                <div class="table-cell">Giá</div>
                                <div class="table-cell table-cell-two">Image</div>
                            </div>
                        </div>
                        <div class="table-body">';
                            $explode_ex=array();
                            for($m=0;$m<count($array_fitters);$m++):
                                $result .='<div class="table-row">';
                                $k=0;
                                foreach ($array_fitters[$m] as $key => $value):
                                    $k++;
                                    $explode_ex = explode("_", $value);
                                    $result .='<div class="table-cell readonly">'.$explode_ex[0].'</div><input type="hidden" name="variable_'.$m.$k.'" value="'.$explode_ex[1].'">';
                                endforeach;
                                $result .='<div class="table-cells">
                                        <div class="table-cell">
                                            <div class="anhduong-input__prefix">₫<span class="anhduong-input__prefix-split"></span><!----><!----></div>
                                            <input type="text"  class="anhduong-input__input form-control" name="price_aviable_'.$m.'">
                                        </div>
                                        <div class="table-cell table-cell-two">
                                            <div class="group_variable_images clear">
                                                <div class="inside clear">
                                                    <div class="text_input_file_image_variable">
                                                        <input class="myfile_gallery_store_select form-control" type="text" value="" size="50" placeholder="Hình ảnh" name="text_upload_gallery_variable_'.$m.'">
                                                    </div>
                                                    <div class="mybutton_upload_img">
                                                        <input class="upload_gallery_variable_select" type="file"  id="upload_gallery_variable_'.$m.'" name="upload_gallery_variable_'.$m.'">UP
                                                    </div>
                                                </div><!--inside-->
                                            </div>
                                        </div>
                                    </div>
                                </div>';
                            endfor;
                            $result .='<input type="hidden" name="count_item_list" value="'.$m.'"/>
                        </div>
                    </div>';
            else:
                $result ="";
            endif;
        else:
            $result ="";
        endif;
        return $result;
    }
}
