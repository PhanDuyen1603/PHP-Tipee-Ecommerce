@extends('admin_layout')
@section('admin_content')

<div class="container">
  <div class="table-responsive">
    <br>
    <h2>Danh mục sản phẩm</h2>
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
            <th>Tên danh mục</th>
            <th>Hiển thị</th>
            <th>Ngày thêm</th>
            <th style="width:30px;">Cập nhật</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($allCategories as $key => $cate)                        
          <tr>
            <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label></td>
            <td>{{$cate->category_name}}</td>
            <td>
                <span class="text-ellipsis">
                  <?php 
                      if($cate->category_status == 1){
                  ?>           
                      <a href="{{URL::to('/'."unactive-category/".$cate->category_id)}}"><span class="fa-eye-styling fa fa-eye"></span> </a>
                   <?php   
                  }else{
                  ?>  
                      <a href="{{URL::to('/'.'active-category/'.$cate->category_id)}}"><span class="fa-eye-styling fa fa-eye-slash"></span> </a>
                  <?php     
                  }
                  ?>
                  </span>   
            </td>
            <td><span class="text-ellipsis">{{$cate->created_at}}</span></td>
            <td>
              <a href="{{URL::to('/'.'edit-category/'.$cate->category_id)}}" class="active edit-styling" ui-toggle-class="">
                <i class="fa fa-edit"></i>
              </a>
              <a  href="{{URL::to('/'.'delete-category/'.$cate->category_id)}}" class="active edit-styling" ui-toggle-class="">
                <i style="color:red" class="fas fa-times fa-trash-alt"></i>
              </a>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
  
  </div>
</div>


@endsection 