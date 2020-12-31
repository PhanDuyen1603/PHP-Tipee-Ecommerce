@extends('admin_layout')
@section('admin_content')

<div class="container">
      <br>
      <h2>Danh sách các thương hiệu</h2>
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
              {{-- <th style="width:20px;"> <label class="i-checks m-b-none"><input type="checkbox"><i></i></label></th> --}}
              <th>Chọn</th>
              <th>Tên danh mục</th>
              <th>Hiển thị</th>
              <th>Ngày thêm</th>
              <th style="width:30px;">Cập nhật</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($allBrands as $key => $brand)                        
            <tr>
              <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label></td>
              <td>{{$brand->brand_name}}</td>
              <td>
                  <span class="text-ellipsis">
                    <?php 
                        if($brand->brand_status == 1){
                    ?>           
                        <a href="{{URL::to('/'."unactive-brand/".$brand->brand_id)}}"><span class="fa-eye-styling fa fa-eye"></span> </a>
                     <?php   
                    }else{
                    ?>  
                        <a href="{{URL::to('/'.'active-brand/'.$brand->brand_id)}}"><span class="fa-eye-styling fa fa-eye-slash"></span> </a>
                    <?php     
                    }
                    ?>
                    </span>
              </td>
              <td><span class="text-ellipsis">{{$brand->created_at}}</span></td>
              <td>
                <a href="{{URL::to('/'.'edit-brand/'.$brand->brand_id)}}" class="active edit-styling" ui-toggle-class="">
                  <i class="fa fa-edit"></i>
                </a>
                <a href="{{URL::to('/'.'delete-brand/'.$brand->brand_id)}}" class="active edit-styling" ui-toggle-class="">
                  <i style="color:red" class="fas fa-times fa-trash-alt"></i>
                </a>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>

</div>

@endsection 