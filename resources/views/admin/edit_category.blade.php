@extends('admin_layout2')
@section('admin_content')

<div class="container">

   <br>
   <h2>Cập nhật danh mục sản phẩm</h2>
   <hr>
   <?php 
   $message = Session::get('message');
   if($message){
       echo '<span style="color:red; text-align:center;">'.$message.'</span>';
       Session::put('message',null);
   }
   ?>
   @foreach($edit_category as $key => $cate)
   <form role="form" action="{{URL::to('/'.'update-category/'.$cate->category_id)}}" method="POST">
       {{ @csrf_field() }}
      <div class="form-group">    
         <label for="exampleInputEmail1">Tên danh mục</label>
         <input value="{{($cate->category_name)}}" name="categoryName" type="text" class="form-control">
      </div>
      <div class="form-group">
         <label for="exampleInputPassword1">Mô tả danh mục</label>
         <textarea   style="resize:none" rows="8" name="categoryDesc" type="text" class="form-control">{{($cate->category_desc)}}</textarea>
      </div>
            
      <button type="submit" name="categoryUpdates" class="btn btn-info">Cập nhật</button>
   </form>
   @endforeach
</div>

@endsection 