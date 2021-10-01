<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Addtocard, App\Model\Shipping_order, App\Model\Jt_address;
use App\Libraries\Helpers;
use Illuminate\Support\Str;
use DB, File, Image, Config;
use Illuminate\Pagination\Paginator;
use App\Model\Orders;
use App\Model\Carbon;


class OrderController extends Controller
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

    public function revenue(){
        $state = 'Đã giao';
        $revenueByDate = Orders::Where('order_state',$state)->groupBy('order_receivedDate');//->sum('order_totalPrice');

        $revenueByMonth_object = DB::table("Orders")
        // ->select(DB::raw("(SUM(order_totalPrice)) as total"))
            // ->orderBy('order_receivedDate')
            ->groupBy(DB::raw("MONTH(order_receivedDate)"))->get();;
            
        $revenueByYear_object = DB::table("Orders")
        // ->select(DB::raw("(SUM(order_totalPrice)) as total"))
            // ->orderBy('order_receivedDate')
            ->groupBy(DB::raw("YEAR(order_receivedDate)"))->get();


        $total = 0;    
        foreach($revenueByMonth_object as $key => $val){
            $total += $val->order_totalPrice;
        }
       
        // foreach($revenueByYear_object as $key => $val){
        //     $revenueByYear =  $val->total;
        // }

        echo $total. "<br>";
    }

    public function list_order(){
        $user_order = Orders::join('Users','Users.id','=','order_customer')->orderBy('order_id','desc')->get();
        return view('admin.orders.filter')->with('user_order',$user_order);
    }



    public function listOrder(){
        $data_order = Addtocard::select('addtocard.*')
            ->orderBy('addtocard.created', 'DESC')
            ->paginate(20);
        return view('admin.orders.index')->with(['data_order' => $data_order]);
    }

    public function searchOrder(Request $rq){
        $data_order = Addtocard::select('addtocard.*')
            ->orderBy('addtocard.created', 'DESC')
            ->paginate(20);
        $query = '';
        
        if($rq->search_title != '' && $rq->order_status == ''){
            $data_order = Addtocard::select('addtocard.*')
                ->where('addtocard.cart_code', 'LIKE', '%'.$rq->search_title.'%')
                ->orderBy('addtocard.created', 'DESC')
                ->paginate(20);
        } elseif($rq->search_title == '' && $rq->order_status != ''){
            $data_order = Addtocard::select('addtocard.*')
                ->where('addtocard.cart_status', '=', $rq->order_status)
                ->orderBy('addtocard.created', 'DESC')
                ->paginate(20);
        } else{
            $data_order = Addtocard::select('addtocard.*')
                ->where('addtocard.cart_code', 'LIKE', '%'.$rq->search_title.'%')
                ->where('addtocard.cart_status', '=', $rq->order_status)
                ->orderBy('addtocard.created', 'DESC')
                ->paginate(20);
        }

        return view('admin.orders.filter')->with(['data_order' => $data_order]);
    }

    public function createOrder(){
        return view('admin.orders.single');
    }

    public function orderDetail($id){
        $order_detail = Addtocard::where('addtocard.cart_id', '=', $id)->first();
        if($order_detail){
            return view('admin.orders.single')->with(['order_detail' => $order_detail]);
        } else{
            return view('404');
        }
    }

    public function postOrderDetail(Request $rq){
        $datetime_now = date('Y-m-d H:i:s');
        $datetime_convert = strtotime($datetime_now);
        //id post
        $sid = $rq->sid;

        //xử lý content
        $content=htmlspecialchars($rq->admin_note);
        $status_order = (int)$rq->order_status;
        switch ($status_order) {
            case 2:
                $check_shipping_order = Shipping_order::where("cart_id","=",$sid)->get();
                if(count($check_shipping_order) == 0){
                    $data = Addtocard::where('cart_id', $sid)->get()->first();
                    $cart_content_cart = unserialize($data['cart_content']);
                    $product_arr = array();
                    $desc = '';
                    foreach ($cart_content_cart as $item) {
                        $cart_id=$item->id;
                        $Products= Helpers::get_product_by_id($cart_id);
                        $date_now = date("Y-m-d H:i:s");
                        $desc .= $Products->title;
                    }
                    
                    $money_total = $data['cart_total'] + $data['shipping_fee'];
                    $p_arr = array(
                        'itemname' => $desc,
                        'englishName' => $desc,
                        'number' => 1,
                        'itemvalue' => $money_total,
                        'desc' => $desc,
                    );
                    array_push($product_arr, $p_arr);
                    //xử lý tỉnh thành phố
                    if($data['cart_province'] == 'Tỉnh Bà Rịa - Vũng Tàu'){
                        $data['cart_province'] = 'Bà Rịa – Vũng Tàu';
                    }

                    $prov = str_replace("Tỉnh ", "", $data['cart_province']);
                    $prov = str_replace("Thành phố ", "", $prov);

                    //xử lý quận huyện
                    if($prov == 'Bắc Kạn'){
                       if($data['cart_district'] == 'Huyện Chợ Mới'){
                            $data['cart_district'] = 'Huyện Chợ Mới(BK)';
                        } 
                    }

                    if($prov == 'Thừa Thiên Huế'){
                       $prov = 'Thừa Thiên – Huế';
                    }

                    if($prov == 'Thừa Thiên – Huế'){
                        switch ($data['cart_district']) {
                            case 'Huyện Phong Điền':
                                $data['cart_district'] = 'Huyện Phong Điền(TTH)';
                                break;
                            default:
                                break;
                        }
                    }

                    if($prov == 'Bình Định'){
                        switch ($data['cart_district']) {
                            case 'Huyện An Lão':
                                $data['cart_district'] = 'Huyện An Lão(BĐ)';
                                break;
                            case 'Huyện Vĩnh Thạnh':
                                $data['cart_district'] = 'Huyện Vĩnh Thạnh(BĐ)';
                                break;
                            case 'Thành phố Quy Nhơn':
                                $data['cart_district'] = 'Thành phố Qui Nhơn';
                                break;
                            default:
                                break;
                        }
                    }

                    if($prov == 'Bình Thuận'){
                        switch ($data['cart_ward']) {
                            case 'Xã Thuận Quí':
                                $data['cart_ward'] = 'Xã Thuận Quý';
                                break;
                            default:
                                break;
                        }
                    }
                  
                    if($prov == 'Cà Mau'){
                        switch ($data['cart_district']) {
                            case 'Huyện Phú Tân':
                                $data['cart_district'] = 'Huyện Phú Tân(CM)';
                                break;
                            default:
                                break;
                        }
                        switch ($data['cart_ward']) {
                            case 'Xã Việt Khái':
                                $data['cart_ward'] = 'Xã Nguyễn Việt Khái';
                                break;
                            default:
                                break;
                        }
                    }

                    if($prov == 'Cần Thơ'){
                        switch ($data['cart_district']) {
                            case 'Huyện Phong Điền':
                                $data['cart_district'] = 'Huyện Phong Điền(CT)';
                                break;
                            case 'Huyện Vĩnh Thạnh':
                                $data['cart_district'] = 'Huyện Vĩnh Thạnh(CT)';
                                break;
                            default:
                                break;
                        }
                    }

                    if($prov == 'Cao Bằng'){
                        switch ($data['cart_district']) {
                            case 'Huyện Bảo Lâm':
                                $data['cart_district'] = 'Huyện Bảo Lâm(CB)';
                                break;
                            default:
                                break;
                        }
                    }

                    if($prov == 'Đắk Lắk'){
                        switch ($data['cart_district']) {
                            case "Huyện Cư M'gar":
                                $data['cart_district'] = 'Huyện Cư Mgar';
                                break;
                            case "Huyện Ea H'leo":
                                $data['cart_district'] = 'Huyện Ea Hleo';
                                break;
                            case "Huyện Krông A Na":
                                $data['cart_district'] = 'Huyện Krông Ana';
                                break;
                            case "Huyện M'Đrắk":
                                $data['cart_district'] = 'Huyện MDrăk';
                                break;  
                            default:
                                break;
                        }
                        switch ($data['cart_ward']) {
                            case "Xã Ea H'MLay":
                                $data['cart_ward'] = 'Xã Ea HMlay';
                                break;
                            case "Thị trấn M'Đrắk":
                                $data['cart_ward'] = 'Thị trấn MĐrắk';
                                break;
                            case "Xã Cư M'ta":
                                $data['cart_ward'] = 'Xã Cư Mta';
                                break;
                            case "Xã Cư K Róa":
                                $data['cart_ward'] = 'Xã Cư Króa';
                                break;
                            case "Xã Ea M' Doal":
                                $data['cart_ward'] = 'Xã Ea Mdoan';
                                break;
                            case "Xã Cư K Róa":
                                $data['cart_ward'] = 'Xã Cư Króa';
                                break;
                            default:
                                break;
                        }
                    }

                    if($prov == 'Đắk Nông'){
                        switch ($data['cart_district']) {
                            case "Huyện Đắk Mil":
                                $data['cart_district'] = 'Huyện Đăk Mil';
                                break;
                            case "Huyện Đắk R'Lấp":
                                $data['cart_district'] = 'Huyện Đăk Rlâp';
                                break;
                            case "Huyện Đắk Song":
                                $data['cart_district'] = 'Huyện Đăk Song';
                                break;
                            default:
                                break;
                        }
                    }

                    if($prov == 'Trà Vinh'){
                        switch ($data['cart_district']) {
                            case "Huyện Châu Thành":
                                $data['cart_district'] = 'Huyện Châu Thành(TV)';
                                break;
                            default:
                                break;
                        }
                    }

                    if($prov == 'Đồng Tháp'){
                        switch ($data['cart_district']) {
                            case "Huyện Châu Thành":
                                $data['cart_district'] = 'Huyện Châu Thành(ĐT)';
                                break;
                            case "Huyện Tam Nông":
                                $data['cart_district'] = 'Huyện Tam Nông(ĐT)';
                                break;
                            case "Huyện Đắk Song":
                                $data['cart_district'] = 'Huyện Đăk Song';
                                break;
                            default:
                                break;
                        }
                    }

                    if($prov == 'An Giang'){
                        switch ($data['cart_district']) {
                            case "Huyện Châu Thành":
                                $data['cart_district'] = 'Huyện Châu Thành(AG)';
                                break;
                            case "Huyện Chợ Mới":
                                $data['cart_district'] = 'Huyện Chợ Mới(AG)';
                                break;
                            case "Huyện Phú Tân":
                                $data['cart_district'] = 'Huyện Phú Tân(AG)';
                                break;
                            default:
                                break;
                        }
                    }

                    if($prov == 'Gia Lai'){
                        switch ($data['cart_district']) {
                            case "Huyện Đăk Đoa":
                                $data['cart_district'] = 'Huyện Đắk Đoa';
                                break;
                            case "Huyện Đăk Pơ":
                                $data['cart_district'] = 'Huyện Đắk Pơ';
                                break;
                            case "Huyện Ia Grai":
                                $data['cart_district'] = 'Huyện Ia Grai';
                                break;
                            default:
                                break;
                        }
                    }

                    if($prov == 'Hải Phòng'){
                        switch ($data['cart_district']) {
                            case "Huyện An Lão":
                                $data['cart_district'] = 'Huyện An Lão(HP)';
                                break;
                            default:
                                break;
                        }
                    }

                    if($prov == 'Hậu Giang'){
                        switch ($data['cart_district']) {
                            case "Huyện Châu Thành A":
                                $data['cart_district'] = 'Huyện Châu Thành A(HG)';
                                break;
                            default:
                                break;
                        }
                    }

                    if($prov == 'Hòa Bình'){
                        switch ($data['cart_district']) {
                            case "Huyện Kỳ Sơn":
                                $data['cart_district'] = 'Huyện Kỳ Sơn(HB)';
                                break;
                            default:
                                break;
                        }
                    }

                    if($prov == 'Bến Tre'){
                        switch ($data['cart_district']) {
                            case "Huyện Châu Thành":
                                $data['cart_district'] = 'Huyện Châu Thành(BT)';
                                break;
                            default:
                                break;
                        }
                    }

                    if($prov == 'Kiên Giang'){
                        switch ($data['cart_district']) {
                            case "Huyện Châu Thành":
                                $data['cart_district'] = 'Huyện Châu Thành(KG)';
                                break;
                            case 'Huyện Phú Quốc':
                                $data['cart_district'] = 'Huyện Đảo Phú Quốc';
                                break;
                            default:
                                break;
                        }
                    }

                    if($prov == 'Kon Tum'){
                        switch ($data['cart_district']) {
                            case "Huyện Ia H' Drai":
                                $data['cart_district'] = 'Huyện Ia HDrai';
                                break;
                            default:
                                break;
                        }
                    }

                    if($prov == 'Lâm Đồng'){
                        switch ($data['cart_district']) {
                            case "Huyện Bảo Lâm":
                                $data['cart_district'] = 'Huyện Bảo Lâm(LĐ)';
                                break;
                            default:
                                break;
                        }
                        switch ($data['cart_ward']) {
                            case "Phường B'lao":
                                $data['cart_ward'] = 'Phường Blao';
                                break;
                            default:
                                break;
                        }
                    }

                    if($prov == 'Quảng Nam'){
                        switch ($data['cart_ward']) {
                            case "Phường Cẩm Phô":
                                $data['cart_ward'] = 'Cẩm Phô';
                                break;
                            default:
                                break;
                        }
                    }

                    if($prov == 'Hồ Chí Minh'){
                        switch ($data['cart_ward']) {
                            case "Phường Sơn Kỳ":
                                $data['cart_ward'] = 'Phường Sơn Kì';
                                break;
                            default:
                                break;
                        }
                    }

                    if($prov == 'Ninh Thuận'){
                        switch ($data['cart_ward']) {
                            case "Phường Phước Mỹ":
                                $data['cart_ward'] = 'Phường Phước Mĩ';
                                break;
                            default:
                                break;
                        }
                    }

                    //xử lý phường/xã
                    if($data['cart_ward'] == 'Phường Đông Lương'){
                        $data['cart_ward'] = 'Đông Lương';
                    }
                    if($data['cart_ward'] == 'Phường Đông Giang'){
                        $data['cart_ward'] = 'Đông Giang';
                    }
                    if($data['cart_ward'] == 'Phường Đông Lễ'){
                        $data['cart_ward'] = 'Đông Lễ';
                    }
                    if($data['cart_ward'] == 'Phường Đông Thanh'){
                        $data['cart_ward'] = 'Đông Thanh';
                    }

                    //phường của gò vấp có số 0
                    if($prov == 'Hồ Chí Minh' && $data['cart_district'] != 'Quận Gò Vấp'){
                        $cart_ward = str_replace("Phường 0", "Phường ", $data['cart_ward']);
                    } else{
                        $cart_ward = $data['cart_ward'];
                    }

                    $area = Jt_address::where("prov","=",$prov)
                        ->where('city', '=', $data['cart_district'])
                        ->where('area', 'LIKE', '%'.$cart_ward.'%')
                        ->select('jt_address.*')
                        ->first();
                    // print_r($area);
                    // die();
                    $receiver = array(
                        'name' => $data['cart_hoten'],
                        'phone' => $data['cart_phone'],
                        'mobile' => $data['cart_phone'],
                        'prov' => $prov,
                        'city' => $data['cart_district'],
                        'area' => $area->area,
                        'address' => $data['cart_address']
                    );

                    $sender = array(
                        'name' => config('app.SENDER_FULLNAME'),
                        'phone' => config('app.SENDER_PHONE'),
                        'mobile' => config('app.SENDER_PHONE'),
                        'prov' => config('app.pick_province'),
                        'city' => config('app.pick_district'),
                        'area' => config('app.pick_area'),
                        'address' => config('app.pick_address')
                    );

                    $o_arr = array(
                        'eccompanyid' => config('app.eccompanyid'),
                        'customerid' => config('app.customerid'),
                        'txlogisticid' => $data['cart_code'], 
                        'ordertype' => 1, 
                        'servicetype' => 1, 
                        'sender' => $sender,
                        'receiver' => $receiver,
                        'createordertime' => $date_now,
                        'sendstarttime' => $date_now,
                        'sendendtime' => $date_now,
                        'paytype' => 'PP_PM', 
                        'itemsvalue' => $money_total,
                        'goodsvalue' => $money_total,
                        'isInsured' => '0',
                        'items' => $product_arr,
                        'weight' => "0.5",
                        'volume' => "1",
                        'remark' => "Cho khách xem hàng, gọi người gửi trước khi hoàn hàng.",
                    );

                    $key = config('app.key_jt');
                    $logistics_interface = json_encode($o_arr);
                    $data_digest = base64_encode(md5($logistics_interface.$key)); 
                    $post_arr = array(
                        'logistics_interface' => $logistics_interface,
                        'data_digest' => $data_digest,
                        'msg_type' => 'ORDERCREATE',
                        'eccompanyid' => config('app.eccompanyid')
                    );
                    
                    $curl = curl_init();
                    curl_setopt_array($curl, array(
                      CURLOPT_PORT => "22220",
                      CURLOPT_URL => "http://sellapp.jtexpress.vn:22220/yuenan-interface-web/order/orderAction!createOrder.action",           
                      CURLOPT_RETURNTRANSFER => true,
                      CURLOPT_ENCODING => "",
                      CURLOPT_MAXREDIRS => 10,
                      CURLOPT_TIMEOUT => 30,
                      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                      CURLOPT_CUSTOMREQUEST => "POST",
                      CURLOPT_POSTFIELDS => $post_arr,
                      CURLOPT_HTTPHEADER => array(
                        "Content-Type: multipart/form-data"
                      ),
                    ));

                    $response = curl_exec($curl);
                    $err = curl_error($curl);

                    curl_close($curl);

                    if ($err) {
                      echo "cURL Error #:" . $err;
                    } else {
                      $result = json_decode($response);
                    }
                    $data['type_shipping'] = 'jt';
                    if($result->responseitems[0]->success == 'true'){
                        $database = array(
                            'id_shipping' => $result->responseitems[0]->txlogisticid,
                            'cart_id' => $sid,
                            'type_shipping' => $data['type_shipping']
                        );
                        $shipping_order = Shipping_order::create($database);
                    } else{
                        $msg = "Không thêm được đơn hàng J&T";
                        $url=$helper->url_admin('admin','update',$pageString,$sid);
                        $helper->msg_move_page($msg,$url);
                    }
                }
                break;
            case 3:
                $data = Shipping_order::where('cart_id', $sid)->get()->first();
                if($data){
                    if($data['type_shipping'] == 'jt'){
                        $fieldlist = array(
                            'txlogisticid' => $data['id_shipping'], 
                            'fieldname' => 'status', 
                            'fieldvalue' => 'WITHDRAW', 
                            'remark' => 'Hủy đơn hàng từ API', 
                        );
                        $field_arr = array();
                        array_push($field_arr, $fieldlist);
                        $o_arr = array(
                            'eccompanyid' => config('app.eccompanyid'),
                            'customerid' => config('app.customerid'),
                            'logisticproviderid' => 'JNT', 
                            'txlogisticid' => $data['id_shipping'], 
                            'fieldlist' => $field_arr,
                        );
                        $key = config('app.key_jt');
                        $logistics_interface = json_encode($o_arr);
                        $data_digest = base64_encode(md5($logistics_interface.$key)); 
                        $post_arr = array(
                            'logistics_interface' => $logistics_interface,
                            'data_digest' => $data_digest,
                            'msg_type' => 'UPDATE',
                            'eccompanyid' => config('app.eccompanyid')
                        );
                        $curl = curl_init();
                        curl_setopt_array($curl, array(
                          CURLOPT_PORT => "22220",
                          CURLOPT_URL => "http://sellapp.jtexpress.vn:22220/yuenan-interface-web/order/orderAction!createOrder.action",           
                          CURLOPT_RETURNTRANSFER => true,
                          CURLOPT_ENCODING => "",
                          CURLOPT_MAXREDIRS => 10,
                          CURLOPT_TIMEOUT => 30,
                          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                          CURLOPT_CUSTOMREQUEST => "POST",
                          CURLOPT_POSTFIELDS => $post_arr,
                          CURLOPT_HTTPHEADER => array(
                            "Content-Type: multipart/form-data"
                          ),
                        ));

                        $response = curl_exec($curl);
                        $err = curl_error($curl);

                        curl_close($curl);

                        if ($err) {
                          echo "cURL Error #:" . $err;
                        } else {
                            $result = json_decode($response);
                        }
                        $data->delete();
                    }
                }
                break;
        }
        if($sid > 0){
            //update
            $data = array(
                "cart_excerpt" => $content,
                "cart_status" => $status_order,
            );
            $respons = Addtocard::where ("cart_id", "=", $sid)->update($data);
            $msg = "Order has been Updated";
            $url= route('admin.orderDetail', array($sid));
            Helpers::msg_move_page($msg,$url);
        }
    }
}
