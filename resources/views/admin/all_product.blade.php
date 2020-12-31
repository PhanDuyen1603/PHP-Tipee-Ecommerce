@extends('admin_layout')
@section('admin_content')

<div class="container">
      <br>
      <h2>Danh sách sản phẩm</h2>
      <hr>
     
        <?php 
        $message = Session::get('message');
        if($message){
            echo '<span style="color:red; text-align:center;">'.$message.'</span>';
            Session::put('message',null);
        }
        ?>

        <table class="table table-striped b-t b-light">
          <thead>
            <tr>
              <th>Chọn</th>
              <th>Tên sản phẩm</th>
              <th>Giá</th>
              <th>Hình ảnh</th>
              <th>Thương hiệu</th>
              <th>Danh mục</th>
              <th>Hiển thị</th>
              <th>Ngày thêm</th>
              <th style="width:30px;">Cập nhật</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($allProducts as $key => $product)                        
            <tr>
              <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label></td>
              <td>{{$product->product_name}}</td>
              <td>{{$product->product_price}}</td>
              <td><img src="public/uploads/product/{{$product->product_image}}" width="100" height="100" alt=""></td>
              <td>{{$product->brand_name}}</td>
              <td>{{$product->category_name}}</td>
              <td>
                  <span class="text-ellipsis">
                    <?php 
                        if($product->product_status == 1){
                    ?>           
                        <a href="{{URL::to('/'."unactive-product/".$product->product_id)}}"><span class="fa-eye-styling fa fa-eye"></span> </a>
                     <?php   
                    }else{
                    ?>  
                        <a href="{{URL::to('/'.'active-product/'.$product->product_id)}}"><span class="fa-eye-styling fa fa-eye-slash"></span> </a>
                    <?php     
                    }
                    ?>
                    </span>
              </td>
              <td><span class="text-ellipsis">{{$product->created_at}}</span></td>
              <td>
                <a href="{{URL::to('/'.'edit-product/'.$product->product_id)}}" class="active edit-styling" ui-toggle-class="">
                  <i class="fa fa-edit"></i>
                </a>
                <a href="{{URL::to('/'.'delete-product/'.$product->product_id)}}" class="active edit-styling" ui-toggle-class="">
                  <i style="color:red" class="fas fa-times fa-trash-alt"></i>
                </a>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>

</div>

@endsection 