<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use App\Model\Theme;
use App\WebService\WebService;
use DB;
use Exception;

session_start();



class CustomerController extends Controller
{
    public function index(){
        $allProducts = Theme::all();
       
        return view('home.index')->with('allProducts',$allProducts);
    }
    
    // function UpdateInfo($id,$password){
    //     global $db;
    //     $stmt=$db->prepare("UPDATE user SET password =?  WHERE Id =?");
    //     $stmt ->execute(array($password,$id));
    //     return findUserByID($id);
    // }
    // function UpdatePassword($id,$password){
    //     global $db;
    //     $stmt=$db->prepare("UPDATE user SET password =?  WHERE Id =?");
    //     $stmt ->execute(array($password,$id));
    //     return findUserByID($id);
    // }
    public function Usertest(){
        $id = 5;
        $sql = "select * from users where id ='".$id."'";
        $user_info = DB::selectOne($sql);
        $gioitinh = 'nu';
        return view('customer.index',['userinfo'=>$user_info, 'gioitinh' => $gioitinh]);
    }
    public function capnhatdulieu()
    {
        try {
            //get user 
            $id = 5;
            $sql = "select * from users where id ='".$id."'";
            $user_info = DB::selectOne($sql);

            if(isset($_POST['username']) &&isset($_POST['gender'])&&isset($_POST['email'])&&isset($_POST['doimatkhau']))
            { 
                $username = $_POST['username'];
                $phone = $_POST['phone'];
                $gender = $_POST['gender'];
                $email = $_POST['email'];
                $doimatkhau=$_POST['doimatkhau'];
            }
            if ($doimatkhau==true)
            {
                if(isset($_POST['newpassword']) &&isset($_POST['newpassword1'])&&isset($_POST['oldpassword']))
                {
                    $newpassword = $_POST['newpassword'];
                    $newpassword1 = $_POST['newpassword1'];
                    $oldpassword = $_POST['oldpassword'];
                }
                if(!password_verify($oldpassword,$user_info['password']))
                {
                    $arr = array('code'=>404,'msg'=>'Mật khẩu cũ không chính xác');
                    return json_encode($arr); 
                }
                else
                {
                    global $db;
                    $stmt=$db->prepare("UPDATE users  SET password =?  WHERE Id =?");
                    $stmt ->execute(array(password_hash( $newpassword,PASSWORD_DEFAULT),$id));
                }
            }
            //sql
            $arr = array('code'=>404,'msg'=>'Update not success');
            return json_encode($arr);
        } catch (Exception $th) {
            $arr = array('code'=>403,'msg'=> $th);
            return json_encode($arr);
        }
    }
}
