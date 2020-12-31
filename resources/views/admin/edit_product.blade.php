@extends('admin_layout')
@section('admin_content')

<div class="row">
    <div class="col-lg-12">
       <section class="panel">
          <header class="panel-heading">
            Cập nhật sản phẩm
          </header>
          <div class="panel-body">
            <?php 
            $message = Session::get('message');
            if($message){
                echo '<span style="color:red; text-align:center;">'.$message.'</span>';
                Session::put('message',null);
            }
    
            ?>
             <div class="position-center">
                @foreach ($edit_product as $key => $pro)
                    
                
                <form role="form" action="{{URL::to('/update-product'.'/'.$pro->product_id)}}" method="POST" enctype="multipart/form-data">
                    {{ @csrf_field() }}
                   <div class="form-group">    
                      <label for="exampleInputEmail1">Tên sản phẩm</label>
                      <input name="productName" type="text" class="form-control"  value="{{($pro->product_name)}}">
                   </div>
                   <div class="form-group">    
                     <label for="exampleInputEmail1">Giá sản phẩm</label>
                     <input name="productPrice" type="number" class="form-control"  value="{{($pro->product_price)}}">
                  </div>
                   <div class="form-group">    
                     <label for="exampleInputEmail1">Hình ảnh</label>
                     <input name="productImage" type="file" class="form-control">
                     <img src="{{URL::to('public/uploads/product/'.$pro->product_image)}}" height="100" width="100" alt="">
                  </div>
                   <div class="form-group">
                      <label for="exampleInputPassword1">Mô tả sản phẩm</label>
                      <textarea style="resize:none" rows="8" name="productDesc" type="text" class="form-control">{{($pro->product_desc)}}</textarea>
                   </div>
                   <div class="form-group">
                     <label for="exampleInputPassword1">Nội dung sản phẩm</label>
                     <textarea style="resize:none" rows="8" name="productContent" type="text" class="form-control"> {{($pro->product_content)}}</textarea>
                  </div>
                  <div class="form-group">
                     <label for="exampleInputPassword1">Danh mục sản phẩm</label>
                     <select name="productCategory" class="form-control input-sm m-bot15">
                        @foreach($allCategories as $key => $cate)
                            @if($cate->category_id == $pro->product_category)
                            <option selected value="{{$cate->category_id}}">{{$cate->category_name}}</option>       
                            @else        
                                <option value="{{$cate->category_id}}">{{$cate->category_name}}</option>
                            @endif
                        @endforeach
                     </select>
                </div> 
                <div class="form-group">
                  <label for="exampleInputPassword1">Thương hiệu sản phẩm</label>
                  <select name="productBrand" class="form-control input-sm m-bot15">

                     @foreach($allBrands as $key => $brand)
                        @if($brand->brand_id == $pro->product_brand)
                            <option selected value="{{$brand->brand_id}}">{{$brand->brand_name}}</option>       
                        @else        
                            <option value="{{$brand->brand_id}}">{{$brand->brand_name}}</option> 
                        @endif                           
                     @endforeach
                      
                  </select>
             </div> 
                   <div class="form-group">
                        <label for="exampleInputPassword1">Hiển thị</label>
                        <select name="productStatus" class="form-control input-sm m-bot15">
                           @if($pro->product_status == 0)
                              <option selected value="0">Ẩn</option>
                              <option value="1">Hiện</option> 
                           @else
                              <option value="0">Ẩn</option>
                              <option selected value="1">Hiện</option>                            
                           @endif
                        </select>
                   </div>                  
                   <button type="submit" name="productAdd" class="btn btn-info">Cập nhật</button>
                </form>
               @endforeach
             </div>
          </div>
       </section>
    </div>
</div>

@endsection 