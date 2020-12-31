@extends('admin_layout')
@section('admin_content')

<div class="container">

   <br>
   <h2>Thêm danh mục sản phẩm</h2>
   <hr>
   <?php 
   $message = Session::get('message');
   if($message){
         echo '<span style="color:red; text-align:center;">'.$message.'</span>';
         Session::put('message',null);
   }  
   ?>
   <form role="form" action="{{URL::to('/save-category')}}" method="POST">
      {{ @csrf_field() }}
      <div class="form-group">    
         <label>Tên danh mục</label>
         <input name="categoryName" type="text" class="form-control"  placeholder="Tên danh mục">
      </div>
      <div class="form-group">
         <label>Mô tả danh mục</label>
         <textarea style="resize:none" rows="8" name="categoryDesc" type="text" class="form-control" placeholder="Mô tả danh mục"></textarea>
      </div>
      <div class="form-group">
         <label>Hiển thị</label>
         <select name="categoryStatus" class="form-control input-sm m-bot15">
               <option value="0">Ẩn</option>
               <option value="1">Hiển thị</option>
         </select>
      </div>                  
      <button type="submit" name="categoryAdd" class="btn btn-primary btn-lg">Thêm</button>
   </form>
</div>

@endsection 