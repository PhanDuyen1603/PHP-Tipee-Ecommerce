<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Setting, App\Model\Admin, App\Model\Addtocard;
use App\Model\Theme, App\Model\Category_Theme, App\Model\Join_Category_Theme;
use Illuminate\Support\Facades\Hash;
use App\Libraries\Helpers;
use Illuminate\Support\Str;
use App\User;
use Auth, DB, File, Image, Redirect, Cache;
use App\Exports\CustomerExport;
use App\Exports\OrderExport;
use App\Exports\ProductExport;
use Maatwebsite\Excel\Facades\Excel;
use App\WebService\WebService;

class AdminController extends Controller
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
    public function dashboard(){
        
    }
    public function changePassword(){
        return view('admin.change-password');
    }

    public function postChangePassword(Request $rq){
        $user = Auth::guard('admin')->user();
        $id = $user->id;
        $current_pass = $user->password;
        if(Hash::check($rq->current_password, $user->password)){
            if($rq->new_password == $rq->confirm_password){
                $data = array(
                    'password' => bcrypt($rq->new_password)
                );
            } else{
                $msg = 'Mật khẩu xác nhận không trùng khớp';
                return Redirect::back()->withErrors($msg);
            }
        } else{
            $msg = 'Mật khẩu hiện tại không chính xác';
            return Redirect::back()->withErrors($msg);
        }
        $respons =DB::table('admins')->where("id","=",$id)->update($data);
        $msg = "Password has been updated";
        $url=  route('admin.dashboard');
        Helpers::msg_move_page($msg,$url);
    }
    
    public function listUsers(){
        $data_user = User::get();
        return view('admin.users.index')->with(['data_user' => $data_user]);
    }

    public function getMenu(){
        return view('admin.setting.menu');
    }

    public function getThemeOption(){
        return view('admin.setting.theme-option');
    }

    public function postThemeOption(Request $rq){
        $array_option_tdr=array();
        $theme_options="";
        if(isset($rq->header_option_values_line) && !empty($rq->header_option_values_line) && $rq->header_option_values_line != ''):
            for( $i = 0; $i < count($rq->header_option_values_line); $i++ ):
                $header_option_texts_line=($rq->header_option_texts_line[$i] != '' ) ? $rq->header_option_texts_line[$i] : '';
                $header_option_values_line=($rq->header_option_values_line[$i] != '' ) ? $rq->header_option_values_line[$i] : '';
                if(!empty($header_option_texts_line)):
                    $header_option_texts_lines=strtolower(str_replace(" ", "_", $header_option_texts_line));
                    $header_option_texts_lines=Str::slug($header_option_texts_lines);
                    $header_option_values_line=htmlspecialchars(base64_encode($header_option_values_line));
                    $array_list_option=array(
                        $header_option_texts_lines =>$header_option_values_line,
                        "group_tdr" =>array(
                            "tdr_name"=>$header_option_texts_lines,
                            "tdr_choise"=>"line",
                            "tdr_value"=>$header_option_values_line,
                            $header_option_texts_lines =>$header_option_values_line
                        ));
                    array_push($array_option_tdr,$array_list_option);
                endif;
            endfor;
        endif;
        if(isset($rq->header_option_values_muti_line) && !empty($rq->header_option_values_muti_line) && $rq->header_option_values_muti_line != ''):
            for( $i = 0; $i < count($rq->header_option_values_muti_line); $i++ ):
                $header_option_texts_muti_line=($rq->header_option_texts_muti_line[$i] != '' ) ? $rq->header_option_texts_muti_line[$i] : '';
                $header_option_values_muti_line=($rq->header_option_values_muti_line[$i] != '' ) ? $rq->header_option_values_muti_line[$i] : '';
                if(!empty($header_option_texts_muti_line)):
                    $header_option_texts_muti_lines=strtolower(str_replace(" ", "_", $header_option_texts_muti_line));
                    $header_option_texts_muti_lines=Str::slug($header_option_texts_muti_lines);
                    $header_option_values_muti_line=htmlspecialchars(base64_encode($header_option_values_muti_line));
                    $array_list_option=array(
                        $header_option_texts_muti_lines =>$header_option_values_muti_line,
                        "group_tdr" =>array(
                            "tdr_name"=>$header_option_texts_muti_lines,
                            "tdr_choise"=>"muti_line",
                            "tdr_value"=>$header_option_values_muti_line,
                            $header_option_texts_muti_lines =>$header_option_values_muti_line
                        ));
                    array_push($array_option_tdr,$array_list_option);
                endif;
            endfor;
        endif;
        $theme_options=serialize($array_option_tdr);
        //$res_checkbox = delete_data("ace_setting");
        $res_checkbox= Setting::whereNotNull('id')->delete();

        $datas= array(
            "name_setting"  => "e-bike",
            "value_setting" => $theme_options,
            "status"    => 0
        );
        $respons = Setting::create($datas);
        $id_insert= $respons->id;
        Cache::forget('theme_option');
        if($id_insert > 0):
            $msg = "Option has been registered";
            $url= route('admin.themeOption');
            Helpers::msg_move_page($msg,$url);
        endif;
    }

    public function exportProduct(Request $rq){
    	$data = Theme::where('theme.status', '=', 0)
    		->orderBy('theme.title', 'ASC')
    		->select('theme.id', 'theme.title', 'theme.price_origin', 'theme.price_promotion', 'theme.start_event', 'theme.end_event', 'theme.product_detail_weight', 'theme.seo_keyword')
    		->get();
    	$arr = array();
    	foreach ($data as $row ) {
    		$categories = Theme::where('theme.id', '=', $row->id)
                ->join('join_category_theme','theme.id','=','join_category_theme.id_theme')
                ->join('category_theme','join_category_theme.id_category_theme','=','category_theme.categoryID')
                ->select('category_theme.categoryName')
                ->orderBy('category_theme.categoryParent','ASC')
                ->get(); 
            $cate_txt = "";
            $count_cate_txt = 0;
            if($categories){
            	foreach ($categories as $cate) {
            		if($count_cate_txt == 0){
            			$cate_txt .= $cate->categoryName;
            		} else{
            			$cate_txt .= ', '.$cate->categoryName;
            		}
            		$count_cate_txt++;
            	}
            }
            $o_arr = array(
                'ID' => $row->id,
                'Title' => $row->title,
                'Category' => $cate_txt,
                'Price_Origin' => $row->price_origin,
                'Price_Promotion' => $row->price_promotion,
                'Start_Event' => $row->start_event,
                'End_Event' => $row->end_event,
                'Weight' => $row->product_detail_weight,
                'Keyword' => $row->seo_keyword
            );
            array_push($arr, $o_arr);
    	}
        return (new ProductExport($arr))->download('product.xlsx');
    }

    public function exportCustomer(Request $rq){
        $from = date('Y-m-d H:i:s',strtotime($rq->cus_from));
        $to = date('Y-m-d H:i:s',strtotime($rq->cus_to));
        return (new CustomerExport($from, $to))->download('customer.xlsx');
    }

    public function exportOrder(Request $rq){
        $from = date('Y-m-d H:i:s',strtotime($rq->order_from));
        $to = date('Y-m-d H:i:s',strtotime($rq->order_to));
        $data = Addtocard::whereBetween('addtocard.created', [$from, $to])->orderBy('created', 'DESC')->get();
        $arr = array();
        foreach ($data as $row ) {
            $cart_content_cart = unserialize($row->cart_content);
            if($cart_content_cart):
            try{
                $j=0;
                $cart_id=0;
                $List_cart="";
                $product_name = "";
                $product_option = "";
                $qty=0;
                $count_item = count($cart_content_cart);
                $k=1;
                foreach($cart_content_cart as $List_cart):
                    if($count_item == 1){
                        $line_break = '';
                    }elseif($count_item == $k){
                        $line_break = '';
                    }else{
                        $line_break = ' | ';
                    }
                    $k++;
                    if(isset($List_cart->id)):
                        $cart_id=$List_cart->id;
                        $avariable=$List_cart->options;
                        $Products=Helpers::get_product_by_id($cart_id);
                        $avariable_html = "";
                        $group_combo = "";
                        $product_name .= $List_cart->name." x".$List_cart->qty;
                        $qty += $List_cart->qty;
                        if(isset($avariable) && count($avariable)>0):
                            $count_option_arr = count($avariable);
                            $id_variable_parrent = 0;
                            $id_variable_child = 0;
                            for ($j=0; $j < $count_option_arr; $j++):
                                $string_json_variable = \GuzzleHttp\json_decode($avariable[$j]);
                                if(!WebService::objectEmpty($string_json_variable)):
                                    $id_variable_parrent = $string_json_variable->parent_id;
                                    $id_variable_child = $string_json_variable->id;
                                    if($id_variable_parrent > 0 && $id_variable_child > 0):
                                        $avariable_html .= "(".Helpers::get_title_variable_theme_by_id($id_variable_parrent).": ".Helpers::get_title_variable_theme_by_id($id_variable_child).")";
                                    endif;
                                endif;
                            endfor;
                            $product_name .= $avariable_html." | ";
                        else:
                            $product_name .= " | ";
                        endif;

                        $order_status = "";
                        switch ($row->cart_status) {
                            case '1':
                                $order_status = "Mới đặt";
                                break;
                            case '2':
                                $order_status = "Giao J&T";
                                break;
                            case '3':
                                $order_status = "Đã hủy";
                                break;
                            case '4':
                                $order_status = "Đợi xử lý";
                                break;
                            case '5':
                                $order_status = "Liên hệ sau";
                                break;
                            default:
                                break;
                        }
                        $o_arr = array(
                            'Order_Code' => $row->cart_code,
                            'Order_Date' => $row->created,
                            'Customer' => $row->cart_hoten,
                            'Email' => $row->cart_email,
                            'Tel' => $row->cart_phone,
                            'Address' => $row->cart_address,
                            'Ward' => $row->cart_ward,
                            'District' => $row->cart_district,
                            'Province' => $row->cart_province,
                            'Product_Code' => $Products['theme_code'],
                            'Product_Name' => $product_name,
                            'Product_Quantity' => $qty,
                            'Pay_Method' => $row->cart_pay_method,
                            'Total' => $row->cart_total,
                            'Shipping_Fee' => $row->shipping_fee,
                            'Status' => $order_status,
                        );
                    endif;
                endforeach;
                array_push($arr, $o_arr);
            }catch(Exception $ex) {
                echo "Lỗi:".$ex;
            }
            endif;
        }
        return (new OrderExport($arr))->download('order.xlsx');
    }
}
