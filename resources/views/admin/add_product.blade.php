@extends('admin_layout')
@section('admin_content')

<div class="container">
   
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
   
      <form role="form" action="{{URL::to('/save-product')}}" method="POST" enctype="multipart/form-data">
            {{ @csrf_field() }}
            <div class="form-group">    
               <label>Tên sản phẩm</label>
               <input name="productName" type="text" class="form-control"  placeholder="Tên sản phẩm">
            </div>
            <div class="form-group">    
            <label>Giá sản phẩm</label>
            <input name="productPrice" type="number" class="form-control"  placeholder="Giá sản phẩm">
         </div>
            <div class="form-group">    
            <label>Hình ảnh</label>
            <input name="productImage" type="file" class="form-control">
         </div>
            <div class="form-group">
               <label>Mô tả sản phẩm</label>
               <textarea style="resize:none" rows="8" name="productDesc" type="text" class="form-control" placeholder="Mô tả sản phẩm"> </textarea>
            </div>
            <div class="form-group">
            <label>Nội dung sản phẩm</label>
            <textarea style="resize:none" rows="8" name="productContent" type="text" class="form-control" placeholder="Nội dung sản phẩm"> </textarea>
         </div>
         <div class="form-group">
            <label>Danh mục sản phẩm</label>
            <select name="productCategory" class="form-control input-sm m-bot15">
               @foreach($allCategories as $key => $cate)
                  <option value="{{$cate->category_id}}">{{$cate->category_name}}</option>                            
               @endforeach
            </select>
         </div> 
         <div class="form-group">
            <label>Thương hiệu sản phẩm</label>
            <select name="productBrand" class="form-control input-sm m-bot15">
               @foreach($allBrands as $key => $brand)
                  <option value="{{$brand->brand_id}}">{{$brand->brand_name}}</option>                            
               @endforeach                       
            </select>
         </div> 
         <div class="form-group">
            <label>Hiển thị</label>
            <select name="productStatus" class="form-control input-sm m-bot15">
                  <option value="0">Ẩn</option>
                  <option value="1">Hiển thị</option>
            </select>
         </div>                  
            <button type="submit" name="productAdd" class="btn btn-primary btn-lg">Thêm</button>
      </form>

</div>

@endsection 