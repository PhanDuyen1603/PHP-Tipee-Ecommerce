<?php
session_start();
require_once "./lib/db.php";
require_once 'cart.inc';
$checkLogin = false;
$check = true;
$hoten = $diachi = $dienthoai = "";
$error_hoTen = $error_sdt = $error_diachi = $error_thanhtoan = $success_thanhtoan = "";
$obUser = isset($_SESSION["current_user"]) ? $_SESSION["current_user"] : null;
if ($_SESSION["dang_nhap_chua"] == 1 && $obUser && $obUser->Quyen == 1) {
    $checkLogin = true;
    $o_UserID = $obUser->MaTaiKhoan;
    $sql = "select * from taikhoan where MaTaiKhoan = '$o_UserID'";
    $rs = load($sql);
    $rowUser = $rs->fetch_assoc();
    $hoten = $rowUser["HoTen"];
    $diachi = $rowUser["DiaChi"];
    $dienthoai = $rowUser["DienThoai"];
}
if (isset($_POST["btnMuaSanPham"])) {
    //Lấy tổng tiền
    $o_Total = $_POST["txtTotal"];
 
    
    if ($checkLogin == true && $o_Total!='0' ) {
  
        //Kiểm tra họ tên người nhận có rỗng không
        $hoten = $_POST["txtHoTen"];
        if (empty($hoten)) {
            $error_hoTen = "Bạn chưa nhập Họ Tên người nhận.";
        }
        //Kiểm tra địa chỉ có rỗng không
        $diachi = $_POST["txtDiaChi"];
        if (empty($diachi)) {
            $error_diachi = "Bạn chưa nhâp Địa Chỉ người nhận.";
        }
        //Kiểm tra số điện thoại có đúng không và đúng không
        $dienthoai = $_POST["txtDienThoai"];
        if (empty($dienthoai)) {
            $error_sdt = "Bạn chưa nhập Số Điện Thoại người nhận.";
        } else {
            if (!preg_match("/^(84|0)(1\d{9}|9\d{8})$/", $dienthoai)) {
                $error_sdt = "Số điện thoại không hợp lệ";
                $check = false;
            }
        }
        if ($hoten && $diachi && $dienthoai && $check == true) {
            $sqlDCNH = "Select * from DiaChiNhanHang where MaTaiKhoan='$o_UserID' and TenNguoiNhan='$hoten' and SoDienThoai='$dienthoai' and DiaChiGiaoHang='$diachi'";
            $rs_DCNH = load($sqlDCNH);
            if($rs_DCNH ->num_rows == 0){
                $sqlDC = "insert into DiaChiNhanHang(MaTaiKhoan,TenNguoiNhan,SoDienThoai,DiaChiGiaoHang) values('$o_UserID', '$hoten','$dienthoai','$diachi')";
                $rs_DC = write($sqlDC);
                $sqlDCNH = "Select * from DiaChiNhanHang where MaTaiKhoan='$o_UserID' and TenNguoiNhan='$hoten' and SoDienThoai='$dienthoai' and DiaChiGiaoHang='$diachi'";
                $rs_DCNH = load($sqlDCNH);
            }
            $row_DCNH = mysqli_fetch_row($rs_DCNH);
            //lấy dòng thứ 1 của địa chỉ nhận hàng , tức là mã địa chỉ nhận hàng
            $id_DiaChi = $row_DCNH["0"];
            //lấy ngay hien tai
            $o_OrderDate = strtotime("+6 hours", time());
            $str_OrderDate = date("Y-m-d H:i:s", $o_OrderDate);
            //ngay giao hàng
            $str_NGH = strtotime(date("Y-m-d", strtotime($str_OrderDate)) . " +1 week");
            $str_NgayDK = date("Y-m-d ", $str_NGH);
            $trangThai = 0;

            $sql = "insert into DonDatHang(NgayDatHang,NgayDuKienGiaoHang, MaTaiKhoan,TongGia,TinhTrang,MaDiaChiNH) values('$str_OrderDate','$str_NgayDK', '$o_UserID', '$o_Total','$trangThai','$id_DiaChi')";
            $o_Wire = write($sql);
            //lấy dòng dữ liệu mới thêm vào
            $sqlMDDH = "Select * From DonDatHang where MaTaiKhoan='$o_UserID' and NgayDatHang='$str_OrderDate' and TongGia='$o_Total' and MaDiaChiNH='$id_DiaChi' ";
            $rs_MDDH = load($sqlMDDH);
            $row_MDDH = mysqli_fetch_row($rs_MDDH);
            //lấy dòng thứ 1 của đơn đặt hàng , tức là mã Đơn đặt hàng
            $o_ID = $row_MDDH["0"];

            foreach ($_SESSION["cart"] as $MaSP => $q) {
                $sql = "select * from SanPham where MaSP = '$MaSP'";
                $rs = load($sql);
                $row = $rs->fetch_assoc();
                $Gia = $row["Gia"];
                $amount = $q * $Gia;
                $d_sql = "insert into ChiTietDonDatHang(MaDonDatHang, MaSP, SoLuong, Gia,TinhTrang,NgayDuKienGiaoHang) values('$o_ID', '$MaSP',' $q', '$amount','$trangThai','$str_NgayDK')";
                write($d_sql);
                $sql_tangSLMua="Update SanPham Set SoLuongBan=SoLuongBan +'$q' where MaSP ='$MaSP'";
                write( $sql_tangSLMua);
            }
            // clear cart
            $_SESSION["cart"] = array();
            $success_thanhtoan = '<script>alert("Mua Hàng Thành Công. Vui lòng chờ vài ngày để nhận hàng và thanh toán.");</script>';
        } else {
            $error_thanhtoan = "Mua hàng không thành công.Vui lòng nhập lại thông tin địa chỉ nhận hàng. ";
        }
    } 
}
?>
<!DOCTYPE html> 
<html>
    <head>
        <title>Online shop</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <script type="text/javascript" src="js/jquery-1.7.2.min.js"></script> 
        <link rel="stylesheet" type="text/css" href="assets/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css">
        <link rel="stylesheet" type="text/css" href="assets/bootstrap-3.3.7-dist/css/bootstrap.min.css">
        <link href="css/style.css" rel="stylesheet" type="text/css" media="all"/>
        <link rel="stylesheet" type="text/css" href="css/custom.css">
    </head>
    <body>
        <div class="wrap">
            <div class="header">  
                <?php include_once 'header.php'; ?>
                <div class="header_slide">
                    <?php include_once 'main_navigation.php'; ?>
                    <div class="header_bottom_right">	
                        <div class="content_top">
                            <div class="heading">
                                <h3>Giỏ Hàng</h3>
                            </div>             
                            <div class="clear"></div>
                        </div>
                        <div class="panel-body">
                            <form id="frmCart" method="post" action="updateCart.inc.php">
                                <input type="hidden" id="txtCmd" name="txtCmd">
                                <input type="hidden" id="txtDProId" name="txtDProId">
                                <input type="hidden" id="txtUQ" name="txtUQ">
                            </form>
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Sản phẩm</th>
                                        <th>Giá</th>
                                        <th class="col-md-2">Số lượng</th>
                                        <th>Thành tiền</th>
                                        <th>&nbsp;</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $total = 0;
                                    foreach ($_SESSION["cart"] as $MaSP => $q) :
                                        $sql = "select * from SanPham where MaSP = $MaSP";
                                        $rs = load($sql);
                                        $row = $rs->fetch_assoc();
                                        $amount = $q * $row["Gia"];
                                        $total += $amount;
                                        ?>
                                        <tr>
                                            <td><?= $row["TenSP"] ?></td>
                                            <td>
                                                <?= number_format($row["Gia"]) ?>
                                            </td>
                                            <td>
                                                <input class="quantity-textfield" type="text" name="" id="" value="<?= $q ?>">
                                            </td>
                                            <td><?= number_format($amount) ?></td>
                                            <td class="text-right">
                                                <a class="btn btn-xs btn-danger cart-remove" data-id="<?= $MaSP ?>" href="javascript:;" role="button">
                                                    <span class="glyphicon glyphicon-remove"></span>
                                                </a>
                                                <a class="btn btn-xs btn-primary cart-update" data-id="<?= $MaSP ?>" href="javascript:;" role="button">
                                                    <span class="glyphicon glyphicon-ok"></span>
                                                </a>
                                            </td>
                                        </tr>
                                        <?php
                                    endforeach;
                                    ?>
                                </tbody>
                                <tfoot>
                                <td>Tổng Tiền</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td><b><?= number_format($total) ?></b></td>
                                <td class="text-right">
                                    <a class="btn btn-success" href="index.php" role="button">
                                        Tiếp tục mua hàng
                                        <span class="glyphicon glyphicon-forward"></span>
                                    </a>
                                </td>
                                </tfoot>
                            </table>
                            
                            <?php 
                                if($checkLogin==true){
                            ?>
                            <div class="content_top">
                                <div class="heading">
                                    <h3>Địa Chỉ Nhận Hàng</h3>
                                </div>             
                                <div class="clear"></div>
                            </div>
                            </br></br>
                            <form  class="form-horizontal"  method="POST" action="" style="margin-bottom: 100px" >
                                <div class="form-group">
                                    <label class="col-xs-4 control-label required">Họ Tê Người Nhận:</label>
                                    <div class="col-xs-5">
                                        <input name="txtHoTen" type="text" class="form-control"value="<?= $hoten ?>"  >
                                    </div>
                                    <span class=" has-error "><?=$error_hoTen ?></span>
                                </div>

                                <div class="form-group">
                                    <label  class="col-xs-4 control-label">Số Điện Thoại:</label>
                                    <div class="col-xs-5">
                                        <input name="txtDienThoai" type="text"  class="form-control" value="<?= $dienthoai ?>" >
                                    </div>
                                    <span class=" has-error "><?=$error_sdt ?></span>
                                </div>
                                <div class="form-group">
                                    <label  class="col-xs-4 control-label">Địa Chỉ: </label>
                                    <div class="col-xs-5">
                                        <input name="txtDiaChi" type="text"  class="form-control"value="<?= $diachi ?>" >
                                    </div>
                                    <span class=" has-error "><?=$error_diachi ?></span>
                                </div>
                                <div class="form-group">
                                    <label  class="col-xs-4 control-label"></label>
                                    <input type="hidden" name="txtTotal" value="<?= $total ?>">
                                    <button name="btnMuaSanPham" type="submit" class="btn btn-primary">
                                        <span class="glyphicon glyphicon-bell"></span>
                                        Thanh toán
                                    </button>
                                </div>
                                <div class="form-group">
                                    <span class=" has-error " style="margin-left: 115px;"><?=$error_thanhtoan ?></span>
                                    <span ><?php echo $success_thanhtoan;?></span>
                                </div>
                            </form>
                            <?php }else { ?>
                            <span><a href="login.php" style="margin-left: 200px;font-size: 20px;" >Đăng nhâp để mua hàng</a><span>
                            <?php } ?>

                        </div>
                    </div>
                    <div class="clear"></div>
                </div>
            </div>
        </div>
        <script src="assets/jquery-3.1.1.min.js"></script>
        <script src="assets/bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
        <script src="assets/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js"></script>
        <script type="text/javascript">
            //Ham Xoa San pham  
            $('.cart-remove').on('click', function () {
                var MaSP = $(this).data('id');
                $('#txtDProId').val(MaSP);
                $('#txtCmd').val('D');
                $('#frmCart').submit();

            });
            //Ham CapNhat San Pham
            $('.cart-update').on('click', function () {
                var q = $(this).closest('tr').find('.quantity-textfield').val();
                $('#txtUQ').val(q);
                var MaSP = $(this).data('id');
                $('#txtDProId').val(MaSP);
                $('#txtCmd').val('U');
                $('#frmCart').submit();
            });

            //So luong 1-100   
            $('.quantity-textfield').TouchSpin({
                min: 1,
                max: 100,
                verticalbuttons: true
            });
        </script>
    </body>
</html>