-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th12 30, 2020 lúc 02:32 PM
-- Phiên bản máy phục vụ: 10.1.26-MariaDB
-- Phiên bản PHP: 7.1.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `quanlybanhang`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chitietdondathang`
--

CREATE TABLE `chitietdondathang` (
  `MaCTDonDatHang` int(11) NOT NULL,
  `MaDonDatHang` int(11) NOT NULL,
  `MaSP` int(11) NOT NULL,
  `SoLuong` int(11) NOT NULL,
  `Gia` decimal(10,0) NOT NULL,
  `TinhTrang` int(11) DEFAULT NULL COMMENT '0:chưa giao, 1 đang giao, 2:đã giao',
  `NgayDuKienGiaoHang` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT;

--
-- Đang đổ dữ liệu cho bảng `chitietdondathang`
--

INSERT INTO `chitietdondathang` (`MaCTDonDatHang`, `MaDonDatHang`, `MaSP`, `SoLuong`, `Gia`, `TinhTrang`, `NgayDuKienGiaoHang`) VALUES
(12, 63, 2, 1, '33990000', 0, '2018-12-19'),
(13, 63, 6, 1, '8490000', 0, '2018-12-19'),
(14, 64, 1, 1, '42990022', 0, '2018-12-19'),
(15, 64, 2, 1, '33990000', 0, '2018-12-19'),
(16, 65, 1, 1, '42990022', 0, '2018-12-19'),
(17, 65, 4, 1, '12590000', 0, '2018-12-19'),
(18, 66, 3, 1, '28490000', 0, '2018-12-19'),
(19, 67, 8, 1, '7777777', 0, '2018-12-19'),
(20, 68, 6, 1, '8490000', 0, '2018-12-19'),
(21, 69, 7, 1, '8290000', 0, '2018-12-19'),
(22, 70, 3, 1, '28490000', 0, '2018-12-19'),
(23, 71, 1, 10, '429900220', 0, '2018-12-19'),
(24, 75, 1, 1, '42990022', 0, '2018-12-20'),
(25, 76, 2, 1, '33990000', 0, '2018-12-28'),
(26, 78, 1, 1, '42990023', 0, '2018-12-28'),
(27, 79, 1, 1, '42990023', 0, '2018-12-28'),
(28, 80, 1, 1, '42990023', 0, '2018-12-28'),
(29, 81, 1, 1, '42990023', 0, '2018-12-28'),
(30, 82, 2, 3, '101970000', 0, '2019-01-04'),
(31, 83, 2, 2, '20000', 0, '2019-01-04'),
(32, 83, 34, 100, '799000000', 0, '2019-01-04'),
(33, 84, 21, 1, '44990000', 0, '2019-08-15'),
(34, 85, 30, 4, '3400000', 0, '2019-08-15');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `diachinhanhang`
--

CREATE TABLE `diachinhanhang` (
  `MaDiaChiNH` int(11) NOT NULL,
  `MaTaiKhoan` int(11) NOT NULL,
  `TenNguoiNhan` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `SoDienThoai` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `DiaChiGiaoHang` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `diachinhanhang`
--

INSERT INTO `diachinhanhang` (`MaDiaChiNH`, `MaTaiKhoan`, `TenNguoiNhan`, `SoDienThoai`, `DiaChiGiaoHang`) VALUES
(3, 6, 'thanh hải 1', '0976338756', 'sads'),
(15, 6, 'Lê Thanh Hải', '0976338756', 'Hồ Chí Minh'),
(16, 6, 'thanh hải ', '0987565656', 'Hà Nội'),
(17, 6, 'thanh hải ', '0976338754', 'asdsad'),
(18, 6, 'thanh hải ', '0976338756', 'sads'),
(19, 5, 'thanh hải ', '0976337654', 'HCM'),
(20, 5, 'thanh hải ', '0976337654', 'ewqewq vvd');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `dondathang`
--

CREATE TABLE `dondathang` (
  `MaDonDatHang` int(11) NOT NULL,
  `MaTaiKhoan` int(11) NOT NULL,
  `MaDiaChiNH` int(11) DEFAULT NULL,
  `TongGia` int(11) NOT NULL,
  `NgayDatHang` datetime NOT NULL,
  `NgayDuKienGiaoHang` date NOT NULL,
  `TinhTrang` int(20) NOT NULL COMMENT '0:chưa giao , 1:giao 1 phần , 2:giao hoàn toàn'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT;

--
-- Đang đổ dữ liệu cho bảng `dondathang`
--

INSERT INTO `dondathang` (`MaDonDatHang`, `MaTaiKhoan`, `MaDiaChiNH`, `TongGia`, `NgayDatHang`, `NgayDuKienGiaoHang`, `TinhTrang`) VALUES
(63, 6, 3, 42480000, '2018-12-12 21:04:25', '2018-12-19', 0),
(64, 6, 3, 76980022, '2018-12-12 21:12:02', '2018-12-19', 0),
(65, 6, 3, 55580022, '2018-12-12 21:20:22', '2018-12-19', 0),
(66, 6, 3, 28490000, '2018-12-12 21:21:19', '2018-12-19', 0),
(67, 6, 3, 7777777, '2018-12-12 21:22:59', '2018-12-19', 0),
(68, 6, 3, 8490000, '2018-12-12 22:23:52', '2018-12-19', 0),
(69, 6, 3, 8290000, '2018-12-12 20:24:53', '2018-12-19', 0),
(70, 6, 15, 28490000, '2018-12-12 20:25:54', '2018-12-19', 0),
(71, 6, 16, 429900220, '2018-12-12 22:25:50', '2018-12-19', 1),
(75, 6, 3, 42990022, '2018-12-13 13:39:59', '2018-12-20', 2),
(76, 6, 3, 33990000, '2018-12-21 18:02:32', '2018-12-28', 0),
(77, 6, 3, 33990000, '2018-12-21 18:03:05', '2018-12-28', 0),
(78, 6, 3, 42990023, '2018-12-21 18:03:11', '2018-12-28', 0),
(79, 6, 3, 42990023, '2018-12-21 18:04:30', '2018-12-28', 0),
(80, 6, 3, 42990023, '2018-12-21 18:04:56', '2018-12-28', 0),
(81, 6, 3, 42990023, '2018-12-21 18:07:47', '2018-12-28', 0),
(82, 6, 17, 101970000, '2018-12-28 07:33:50', '2019-01-04', 0),
(83, 6, 18, 799020000, '2018-12-28 09:18:51', '2019-01-04', 1),
(84, 5, 19, 44990000, '2019-08-08 21:10:00', '2019-08-15', 0),
(85, 5, 20, 3400000, '2019-08-08 21:11:49', '2019-08-15', 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `loaisanpham`
--

CREATE TABLE `loaisanpham` (
  `MaLoaiSP` int(11) NOT NULL,
  `TenLoaiSP` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT;

--
-- Đang đổ dữ liệu cho bảng `loaisanpham`
--

INSERT INTO `loaisanpham` (`MaLoaiSP`, `TenLoaiSP`) VALUES
(3, 'LAPTOP'),
(4, 'Phụ Kiện'),
(5, 'Đồng Hồ');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nhasanxuat`
--

CREATE TABLE `nhasanxuat` (
  `MaNhaSX` int(11) NOT NULL,
  `TenNhaSX` varchar(70) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT;

--
-- Đang đổ dữ liệu cho bảng `nhasanxuat`
--

INSERT INTO `nhasanxuat` (`MaNhaSX`, `TenNhaSX`) VALUES
(1, 'iPhone'),
(2, 'SamSung'),
(3, 'OPPO'),
(4, 'NoKiA'),
(5, 'Huawei'),
(6, 'Xiaomi');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sanpham`
--

CREATE TABLE `sanpham` (
  `MaSP` int(11) NOT NULL,
  `TenSP` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `HinhAnh` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `MaLoaiSP` int(11) NOT NULL,
  `MaNhaSX` int(11) NOT NULL,
  `XuatXu` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Gia` int(11) NOT NULL,
  `NgayNhap` datetime NOT NULL,
  `SoLuongNhap` int(11) DEFAULT NULL,
  `SoLuongBan` int(11) DEFAULT NULL,
  `SoLuotXem` int(11) DEFAULT NULL,
  `MoTa` text COLLATE utf8_unicode_ci NOT NULL,
  `TinhTrang` int(11) DEFAULT NULL COMMENT '1: Còn hàng 2, hết hàng'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT;

--
-- Đang đổ dữ liệu cho bảng `sanpham`
--

INSERT INTO `sanpham` (`MaSP`, `TenSP`, `HinhAnh`, `MaLoaiSP`, `MaNhaSX`, `XuatXu`, `Gia`, `NgayNhap`, `SoLuongNhap`, `SoLuongBan`, `SoLuotXem`, `MoTa`, `TinhTrang`) VALUES
(20, 'Apple Macbook Pro Touch MR9Q2SA/A i5 2.3GHz (', 'apple-macbook-pro-touch-mr9q2sa-a-2018-thumb-1-600x600.jpg', 3, 1, 'Hoa Kì', 44490000, '0000-00-00 00:00:00', 1000, 0, 2, '  <span>Màn hình: 13.3”, Retina</span>\r\n                            <span>CPU: Intel Core i5, 2.3GHz</span>\r\n                            <span>RAM: 8GB, Ổ cứng SSD: 256GB</span>\r\n                            <span>VGA: Intel Iris Plus Graphics 655</span>\r\n                            <span>HĐH: MAC OS</span>\r\n                            <span>Pin: 10 tiếng, DVD: Không</span>', 1),
(21, 'Apple Macbook Pro Touch MPXV2SA/A i5 3.1GHz (', 'apple-macbook-pro-touch-mpxv2sa-a-xam-avar-450x300.jpg', 3, 1, 'Hoa Kì', 44990000, '0000-00-00 00:00:00', 1000, 1, 0, ' <span>Màn hình: 13.3”, Retina</span>\r\n                            <span>CPU: Intel Core i5, 3.1GHz</span>\r\n                            <span>RAM: 8GB/ SSD: 256GB</span>\r\n                            <span>VGA: Intel Iris Plus Graphics 650</span>\r\n                            <span>HĐH: MAC OS</span>\r\n                            <span>Pin: 10 tiếng/ DVD: Không</span>', 1),
(22, 'Apple Macbook Pro Touch MR932SA/A i7 2.2GHz (', 'apple-macbook-pro-touch-mr932sa-a-2018-thumb-1-600x600.jpg', 3, 1, 'Hoa Kì', 57490000, '0000-00-00 00:00:00', 1000, 0, 0, '     <span>Màn hình: 15.4”, Retina</span>\r\n                            <span>CPU: Intel Core i7, 2.2GHz</span>\r\n                            <span>RAM: 16GB, Ổ cứng SSD: 256GB</span>\r\n                            <span>VGA: AMD Radeon Pro 555X, 4GB</span>\r\n                            <span>HĐH: MAC OS</span>\r\n                            <span>Pin: 10 tiếng, DVD: Không</span>', 1),
(26, 'Bộ Adapter sạc kèm cáp Micro Samsung TA20HW', 'bo-adapter-sac-kem-cap-micro-samsung-ta20hw-1-3-600x600.jpg', 4, 2, 'Hàn Quốc', 290000, '0000-00-00 00:00:00', 1000, 0, 4, '<li>Sản phẩm chính hãng thương hiệu Samsung.</li>\r\n<li>Kèm cáp Micro USB, chiều dài 1.5 m tiện dụng cho người dùng.</li>\r\n<li>Tích hợp công nghệ sạc nhanh 15W - 9V.</li>\r\n<li>Dùng được cho điện thoại, máy tính bảng, sạc dự phòng, tai nghe...</li>\r\n<li>Sản phẩm chính hãng Samsung.</li>', 1),
(27, 'Tai nghe nhét trong Samsung IG935B', 'tai-nghe-nhet-trong-samsung-ig935b-2-1-600x600.jpg', 4, 2, 'Hàn Quốc', 300000, '0000-00-00 00:00:00', 1000, 0, 0, '<li>Dây tai nghe được thiết kế chống rối.</li>\r\n<li>Có nút ấn ngừng/chơi nhạc, tăng/giảm âm lượng.</li>\r\n<li>Dây dài 120 cm thoải mái để vừa dùng máy vừa nghe nhạc.</li>\r\n<li>Sản phẩm chính hãng Samsung.</li>\r\n<li>Sản phẩm chính hãng nguyên seal 100%.</li>', 1),
(29, 'Kính thực tế ảo Samsung Gear VR3', 'kinh-thuc-te-ao-samsung-gear-vr-sm-r325-2-600x600.jpg', 4, 2, 'Hàn Quốc', 2490000, '0000-00-00 00:00:00', 1000, 0, 0, '', 1),
(30, 'Tai nghe Bluetooth Samsung MG900E', 'tai-nghe-bluetooth-samsung-mg900e-ava-600x600.jpg', 4, 2, 'Hàn Quốc', 850000, '0000-00-00 00:00:00', 100, 4, 2, '<li>Công nghệ chống ồn cho âm thanh trong trẻo và chất lượng.</li>\r\n<li>Đệm tai nghe êm ái, dễ chịu khi sử dụng thời gian dài.</li>\r\n<li>Thời gian thoại lên đến 9 giờ, thời gian chờ lên đến 300 giờ.</li>\r\n<li>Thời gian sạc khoảng 2 giờ. Thời gian nghe nhạc có thể lên đến 8 giờ.</li>', 1),
(31, 'Tai nghe nhét trong Sennheiser CX 215', 'tai-nghe-nhet-trong-sennheiser-cx-215-nau-dong-1-600x600.jpg', 4, 1, 'Hoa Kì', 1000000, '0000-00-00 00:00:00', 100, 0, 0, '', 1),
(32, 'Pin sạc dự phòng Polymer 20.000 mAh 2C Xiaomi', 'pin-sac-du-phong-20000-mah-xiaomi-vnx4212cn-trang-anhava-600x600.jpg', 4, 6, 'Trung Quốc', 350000, '0000-00-00 00:00:00', 100, 0, 0, 'Pin Sạc dự phòng 2C Xiaomi VNX4212CN Trắng với dung lượng 20.000 mAh giúp bạn sạc pin cho điện thoại di động, máy tính bảng (có dung lượng pin dưới 13.000 mAh) của bạn mọi lúc mọi nơi mà không cần kết nối với nguồn điện.', 1),
(33, 'Pin Nokia BL 4U Pisen', 'pin-nokia-bl4u-pisen-ava-600x600.jpg', 4, 4, 'Phần Lan', 300000, '0000-00-00 00:00:00', 100, 0, 1, '<li>Loại pin: BL-4U.</li>\r\n<li>Dung lượng pin: 1.150 mAh.</li>\r\n<li>Chất lượng tương đương hàng theo máy.</li>\r\n<li>Sử dụng cho dòng cao cấp xưa của Nokia như 8800.</li>', 1),
(34, 'Apple Watch S1 38mm viền nhôm dây cao su trắn', 'apple-watch-edition-38mm-nt-600x600.jpg', 5, 1, 'Hoa Kì', 7990000, '0000-00-00 00:00:00', 100, 100, 0, '   <span>Công nghệ màn hình: OLED cảm ứng</span>\r\n                            <span>Kích thước màn hình: 1.9 inch</span>\r\n                            <span>Thời gian sử dụng: Khoảng 18 giờ</span>\r\n                            <span>Kết nối với hệ điều hành: iOS 9.0 trở lên</span>\r\n                            <span>Chống nước: IPX7</span>\r\n                            <span>Chất liệu mặt: Ion-X strengthened glass</span>', 1),
(35, 'Apple Watch S1 42mm viền nhôm dây cao su đen', 'apple-watch-s1-42mm-nt-600x600.jpg', 5, 1, 'Hoa Kì', 8990000, '0000-00-00 00:00:00', 100, 0, 0, '  <span>Công nghệ màn hình: OLED cảm ứng</span>\r\n                            <span>Kích thước màn hình: 2.1 inch</span>\r\n                            <span>Thời gian sử dụng: Khoảng 18 giờ</span>\r\n                            <span>Kết nối với hệ điều hành: iOS 9.0 trở lên</span>\r\n                            <span>Chống nước: IPX7</span>\r\n                            <span>Chất liệu mặt: Ion-X strengthened glass</span>', 1),
(36, 'Apple Watch S3 GPS 38mm viền nhôm dây cao su ', 'apple-watch-s3-gps-38mm-mqku2vn-nt-600x600.jpg', 5, 1, 'Hoa Kì', 8990000, '0000-00-00 00:00:00', 100, 0, 0, '  <span>Công nghệ màn hình: OLED</span>\r\n                            <span>Kích thước màn hình: 1.9 inch</span>\r\n                            <span>Thời gian sử dụng: Khoảng 18 giờ</span>\r\n                            <span>Kết nối với hệ điều hành: iOS 9.0 trở lên</span>\r\n                            <span>Chống nước: 50m</span>\r\n                            <span>Chất liệu mặt: Ion-X strengthened glass</span>', 1),
(37, 'Apple Watch S3 GPS 38mm viền nhôm dây cao su ', 'apple-watch-3-phien-ban-38-mm-nt-600x600.jpg', 5, 1, 'Hoa Kì', 8990000, '0000-00-00 00:00:00', 100, 0, 0, '  <span>Công nghệ màn hình: OLED</span>\r\n                            <span>Kích thước màn hình: 1.9 inch</span>\r\n                            <span>Thời gian sử dụng: Khoảng 18 giờ</span>\r\n                            <span>Kết nối với hệ điều hành: iOS 9 trở lên</span>\r\n                            <span>Chống nước: 50m</span>\r\n                            <span>Chất liệu mặt: Ion-X strengthened glass</span>', 1),
(38, 'Samsung Gear Fit2 Pro', 'samsung-gear-fit2-pro-nt-1-600x600.jpg', 5, 2, 'Hàn Quốc', 3800000, '0000-00-00 00:00:00', 100, 0, 0, '  <span>Công nghệ màn hình: AMOLED</span>\r\n                            <span>Kích thước màn hình: 1.5 inch</span>\r\n                            <span>Thời gian sử dụng: Khoảng 4 ngày</span>\r\n                            <span>Chống nước: 50m</span>\r\n                            <span>Chất liệu dây: Silicone</span>\r\n                            <span>Kết nối: Bluetooth, Wifi</span>', 1),
(39, 'Samsung Gear S3 Frontier', 'samsung-gear-s3-frontier-nt-600x600.jpg', 5, 2, 'Hàn Quốc', 9999000, '0000-00-00 00:00:00', 100, 0, 0, ' <span>Công nghệ màn hình: AMOLED</span>\r\n                            <span>Kích thước màn hình: 1.3 inch</span>\r\n                            <span>Thời gian sử dụng: Khoảng 3 ngày</span>\r\n                            <span>Kết nối với hệ điều hành: Android, iOS</span>\r\n                            <span>Chống nước: IP68</span>\r\n                            <span>Chất liệu mặt: Kính cường lực</span>', 1),
(40, 'Huawei Band 3e màu Đen', 'dong-ho-thong-minh-huawei-band-3e-600x600.jpg', 5, 5, 'Trung Quốc', 600000, '0000-00-00 00:00:00', 100, 0, 0, ' <span>Công nghệ màn hình: PMOLED</span>\r\n                            <span>Kích thước màn hình: 0.5 inch</span>\r\n                            <span>Thời gian sử dụng: Khoảng 14 ngày</span>\r\n                            <span>Chống nước: 50m</span>\r\n                            <span>Chất liệu dây: Silicone</span>\r\n                            <span>Kết nối: Bluetooth</span>', 1),
(41, 'Huawei Band 3e màu Hồng', 'huawei-band-3e-mau-hong-nt-600x600.jpg', 5, 5, 'Trung Quốc', 600000, '0000-00-00 00:00:00', 100, 0, 0, '   <span>Công nghệ màn hình: PMOLED</span>\r\n                            <span>Kích thước màn hình: 0.5 inch</span>\r\n                            <span>Thời gian sử dụng: Khoảng 14 ngày</span>\r\n                            <span>Chống nước: 50m</span>\r\n                            <span>Chất liệu dây: Silicone</span>\r\n                            <span>Kết nối: Bluetooth</span>', 1),
(42, 'Huawei Watch 2', 'huawei-watch-2-nt-600x600.jpg', 5, 5, 'Trung Quốc', 4500000, '0000-00-00 00:00:00', 100, 0, 0, '    <span>Công nghệ màn hình: AMOLED</span>\r\n                            <span>Kích thước màn hình: 1.2 inch</span>\r\n                            <span>Thời gian sử dụng: Khoảng 2 ngày</span>\r\n                            <span>Kết nối với hệ điều hành: Android 4.4 trở lên, iOS 9.0 trở lên</span>\r\n                            <span>Chống nước: IP68</span>\r\n                            <span>Chất liệu mặt: Kính cường lực Gorilla Class</span>', 1),
(44, 'Mi-Band 2', 'mi-band-2-nt-600x600.jpg', 5, 6, 'Trung Quốc', 590000, '0000-00-00 00:00:00', 100, 0, 0, '<span>Công nghệ màn hình: OLED</span>\r\n                            <span>Kích thước màn hình: 0.42 inch</span>\r\n                            <span>Thời gian sử dụng: Khoảng 20 ngày</span>\r\n                            <span>Chống nước: IP67</span>\r\n                            <span>Chất liệu dây: Silicone</span>\r\n                            <span>Kết nối: Bluetooth v4.2</span>', 1),
(45, 'Mi-Band 3', 'mi-band-3-nt-600x600.jpg', 5, 6, 'Trung Quốc', 600000, '0000-00-00 00:00:00', 100, 0, 0, ' <span>Công nghệ màn hình: OLED</span>\r\n                            <span>Kích thước màn hình: 0.78 inch</span>\r\n                            <span>Thời gian sử dụng: Khoảng 20 ngày</span>\r\n                            <span>Chống nước: 50 m</span>\r\n                            <span>Chất liệu dây: Silicone</span>\r\n                            <span>Kết nối: Bluetooth v4.0</span>', 1),
(46, 'Xiaomi Amazfit Bip Đen', 'xiaomi-amazfit-bip-den-nt-600x600.jpg', 5, 6, 'Trung Quốc', 1800000, '0000-00-00 00:00:00', 100, 0, 0, '  <span>Công nghệ màn hình: Transflective LCD</span>\r\n                            <span>Kích thước màn hình: 1.28 inch</span>\r\n                            <span>Thời gian sử dụng: Khoảng 45 ngày, Khoảng 22 giờ khi sử dụng GPS</span>\r\n                            <span>Kết nối với hệ điều hành: Android</span>\r\n                            <span>Chống nước: IP68</span>\r\n                            <span>Chất liệu mặt: Kính cường lực Gorilla Class 3</span>', 1),
(47, 'Xiaomi Amazfit Pace GPS Đen', 'xiaomi-amazfit-pace-gps-den-nt-600x600.jpg', 5, 6, 'Trung Quốc', 1800000, '0000-00-00 00:00:00', 100, 0, 0, '   <span>Công nghệ màn hình: Transflective LCD</span>\r\n                            <span>Kích thước màn hình: 1.34 inch</span>\r\n                            <span>Thời gian sử dụng: Khoảng 5 ngày, Khoảng 35 giờ khi sử dụng GPS</span>\r\n                            <span>Kết nối với hệ điều hành: Android, iOS</span>\r\n                            <span>Chống nước: IP67</span>\r\n                            <span>Chất liệu mặt: Kính cường lực Gorilla Class 3</span>', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `taikhoan`
--

CREATE TABLE `taikhoan` (
  `MaTaiKhoan` int(11) NOT NULL,
  `TenTaiKhoan` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `MatKhau` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `Quyen` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `HoTen` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `DiaChi` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `DienThoai` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `Email` varchar(30) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT;

--
-- Đang đổ dữ liệu cho bảng `taikhoan`
--

INSERT INTO `taikhoan` (`MaTaiKhoan`, `TenTaiKhoan`, `MatKhau`, `Quyen`, `HoTen`, `DiaChi`, `DienThoai`, `Email`) VALUES
(4, 'admin', 'e10adc3949ba59abbe56e057f20f883e', '2', 'thanh hải ', 'ewqewq', '0976338756', '33we32@gmail.com3'),
(5, 'thanhhai', 'e10adc3949ba59abbe56e057f20f883e', '1', 'thanh hải ', 'ewqewq vvd', '0976337654', '33w33e2@gmail.com'),
(6, 'thanhhai12', 'fcea920f7412b5da7be0cf42b8c93759', '1', 'thanh hải ', 'sads', '0976338756', '12322sa5ds@11.com'),
(7, 'thanhhai2222', 'e10adc3949ba59abbe56e057f20f883e', '1', 'thanh hải', 'Hồ Chí Minh', '0976338756', '332we2@gmail.com'),
(8, 'thanhhai123', 'e10adc3949ba59abbe56e057f20f883e', '1', 'thanh hải 11111', 'Da nang', '0976878787', '123456@gmail.com');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `chitietdondathang`
--
ALTER TABLE `chitietdondathang`
  ADD PRIMARY KEY (`MaCTDonDatHang`) USING BTREE,
  ADD UNIQUE KEY `pk_ctdh` (`MaCTDonDatHang`) USING BTREE,
  ADD KEY `fk_ctdh_ddh` (`MaDonDatHang`) USING BTREE;

--
-- Chỉ mục cho bảng `diachinhanhang`
--
ALTER TABLE `diachinhanhang`
  ADD PRIMARY KEY (`MaDiaChiNH`) USING BTREE;

--
-- Chỉ mục cho bảng `dondathang`
--
ALTER TABLE `dondathang`
  ADD PRIMARY KEY (`MaDonDatHang`) USING BTREE,
  ADD UNIQUE KEY `pk_ddh` (`MaDonDatHang`) USING BTREE,
  ADD KEY `fk_ddh_tk` (`MaTaiKhoan`) USING BTREE;

--
-- Chỉ mục cho bảng `loaisanpham`
--
ALTER TABLE `loaisanpham`
  ADD PRIMARY KEY (`MaLoaiSP`) USING BTREE,
  ADD UNIQUE KEY `pk_lsp` (`MaLoaiSP`) USING BTREE;

--
-- Chỉ mục cho bảng `nhasanxuat`
--
ALTER TABLE `nhasanxuat`
  ADD PRIMARY KEY (`MaNhaSX`) USING BTREE,
  ADD UNIQUE KEY `pk_hsx` (`MaNhaSX`) USING BTREE;

--
-- Chỉ mục cho bảng `sanpham`
--
ALTER TABLE `sanpham`
  ADD PRIMARY KEY (`MaSP`) USING BTREE,
  ADD UNIQUE KEY `pk_SP` (`MaSP`) USING BTREE,
  ADD KEY `fk_sp_lsp` (`MaLoaiSP`) USING BTREE,
  ADD KEY `fk_sp_hsx` (`MaNhaSX`) USING BTREE;

--
-- Chỉ mục cho bảng `taikhoan`
--
ALTER TABLE `taikhoan`
  ADD PRIMARY KEY (`MaTaiKhoan`) USING BTREE,
  ADD UNIQUE KEY `pk_tk` (`MaTaiKhoan`) USING BTREE;

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `chitietdondathang`
--
ALTER TABLE `chitietdondathang`
  MODIFY `MaCTDonDatHang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;
--
-- AUTO_INCREMENT cho bảng `diachinhanhang`
--
ALTER TABLE `diachinhanhang`
  MODIFY `MaDiaChiNH` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT cho bảng `dondathang`
--
ALTER TABLE `dondathang`
  MODIFY `MaDonDatHang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;
--
-- AUTO_INCREMENT cho bảng `loaisanpham`
--
ALTER TABLE `loaisanpham`
  MODIFY `MaLoaiSP` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT cho bảng `nhasanxuat`
--
ALTER TABLE `nhasanxuat`
  MODIFY `MaNhaSX` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT cho bảng `sanpham`
--
ALTER TABLE `sanpham`
  MODIFY `MaSP` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;
--
-- AUTO_INCREMENT cho bảng `taikhoan`
--
ALTER TABLE `taikhoan`
  MODIFY `MaTaiKhoan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `chitietdondathang`
--
ALTER TABLE `chitietdondathang`
  ADD CONSTRAINT `fk_ctdh_ddh` FOREIGN KEY (`MaDonDatHang`) REFERENCES `dondathang` (`MaDonDatHang`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Các ràng buộc cho bảng `dondathang`
--
ALTER TABLE `dondathang`
  ADD CONSTRAINT `fk_ddh_tk` FOREIGN KEY (`MaTaiKhoan`) REFERENCES `taikhoan` (`MaTaiKhoan`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Các ràng buộc cho bảng `sanpham`
--
ALTER TABLE `sanpham`
  ADD CONSTRAINT `fk_sp_hsx` FOREIGN KEY (`MaNhaSX`) REFERENCES `nhasanxuat` (`MaNhaSX`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_sp_lsp` FOREIGN KEY (`MaLoaiSP`) REFERENCES `loaisanpham` (`MaLoaiSP`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
