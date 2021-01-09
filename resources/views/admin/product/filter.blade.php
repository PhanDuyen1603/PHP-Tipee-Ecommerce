@extends('admin.layouts.app')
@section('seo')
<?php
$data_seo = array(
    'title' => 'Lọc sản phẩm | '.Helpers::get_option_minhnn('seo-title-add'),
    'keywords' => Helpers::get_option_minhnn('seo-keywords-add'),
    'description' => Helpers::get_option_minhnn('seo-description-add'),
    'og_title' => 'Lọc sản phẩm | '.Helpers::get_option_minhnn('seo-title-add'),
    'og_description' => Helpers::get_option_minhnn('seo-description-add'),
    'og_url' => Request::url(),
    'og_img' => asset('images/logo_seo.png'),
    'current_url' =>Request::url(),
    'current_url_amp' => ''
);
$seo = WebService::getSEO($data_seo);
?>
@include('admin.partials.seo')
@endsection
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Lọc sản phẩm</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
          <li class="breadcrumb-item active">Lọc sản phẩm</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Lọc sản phẩm</h3>
                    </div> <!-- /.card-header -->
                    <div class="card-body">
                        <div class="clear">
                            <ul class="nav fl">
                                <li class="nav-item">
                                    <a class="btn btn-danger" onclick="delete_id('product')" href="javascript:void(0)"><i class="fas fa-trash"></i> Delete</a>
                                </li>
                                <li class="nav-item">
                                    <a class="btn btn-primary" href="{{route('admin.createProduct')}}" style="margin-left: 6px;"><i class="fas fa-plus"></i> Add New</a>
                                </li>
                            </ul>
                            <div class="fr">
                                <form method="GET" action="{{route('admin.searchProduct')}}" id="frm-filter-post" class="form-inline">
                                    <?php 
                                        $list_cate = App\Model\CategoryProduct::orderBy('category_products.categoryName', 'ASC')->select('category_products.categoryID', 'category_products.categoryName')->get();
                                    ?>
                                    <select class="custom-select mr-2" name="category_theme">
                                        <option value="">Thể loại sản phẩm</option>
                                        @foreach($list_cate as $cate)
                                            <option value="{{$cate->categoryID}}" @if(isset($_GET['category_theme']) && $_GET['category_theme'] == $cate->categoryID) selected @endif>{{$cate->categoryName}}</option>
                                        @endforeach
                                    </select>
                                    <input type="text" class="form-control" name="search_title" value="<?php if(isset($_GET['search_title'])){ echo $_GET['search_title']; } ?>" id="search_title" placeholder="Từ khoá">
                                    <button type="submit" class="btn btn-primary ml-2">Tìm kiếm</button>
                                </form>
                            </div>
                        </div>
                        <br/>
                        <div class="clear">
                            <div class="fl" style="font-size: 17px;">
                                <b>Tổng</b>: <span class="bold" style="color: red; font-weight: bold;">{{$total_item}}</span> sản phẩm
                            </div>
                            <div class="fr">
                                {!! $data_product->appends(request()->except('page'))->links() !!}
                            </div>
                        </div>
                        <br/>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="table_index">
                                <thead>
                                    <tr>
                                        <th scope="col" class="text-center"><input type="checkbox" id="selectall" onclick="select_all()"></th>
                                        <th scope="col" class="text-center">Title</th>
                                        <th scope="col" class="text-center">Thumbnail</th>
                                        <th scope="col" class="text-center">Price</th>
                                        <th scope="col" class="text-center">Update</th>
                                        <th scope="col" class="text-center">Store Status</th>
                                        <th scope="col" class="text-center">Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data_product as $data)
                                    <tr>
                                        <td class="text-center"><input type="checkbox" id="{{$data->id}}" name="seq_list[]" value="{{$data->id}}"></td>
                                        <td class="text-center" style="width: 250px;">
                                            <a class="row-title" href="{{route('admin.productDetail', array($data->id))}}">
                                                <b>{{$data->title}}</b>
                                                <br>
                                                <b style="color:#c76805;">{{$data->slug}}</b>  
                                                <?php
                                                $categories = \App\Model\Product::where('id', '=', $data->id)
                                                    ->join('join_category_product','products.id','=','join_category_product.id_product')
                                                    ->join('category_products','join_category_product.id_category_product','=','category_products.categoryID')
                                                    ->select('category_products.categoryID','category_products.categoryName','category_products.categorySlug')
                                                    ->orderBy('category_products.categoryParent','ASC')
                                                    ->get(); 
                                                if($categories): ?>
                                                <div class="list_cat_post_content_link">  
                                                    @foreach($categories as $category)
                                                        <a class="tag" target="_blank" href="#">{{$category->categoryName}}</a>
                                                    @endforeach
                                                </div> 
                                                <?php endif; ?>                          
                                            </a>
                                        </td>
                                        <td class="text-center">
                                            @if($data->thubnail != '')
                                                <img src="{{asset('images/product/'.$data->thubnail)}}" style="height: 70px;">
                                            @else
                                                <img src="{{asset('img/default-150x150.png')}}">
                                            @endif
                                        </td>
                                        <td class="text-center" width="130px">
                                            <div class="clear price_colum_item form-group">
                                                <label for="origin-price-{{$data->id}}">Giá gốc</label>
                                                <input id="origin-price-{{$data->id}}" class="colunm_price form-control" placeholder="Giá gốc" type="text" value="{{$data->price_origin}}" name="price_origin">
                                            </div>
                                            <div class="clear price_colum_item form-group">
                                                <label for="promotion-price-{{$data->id}}">Giá KM</label>
                                                <input id="promotion-price-{{$data->id}}" class="colunm_price form-control" placeholder="Giá khuyến mãi" type="text" value="{{$data->price_promotion}}" name="price_promotion">
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <button type="submit" class="btn btn-warning update_theme_fast" onclick="update_theme_fast({{$data->id}})" theme-id="{{$data->id}}" name="update_colunm">Update</button>
                                            <p id="alert_{{$data->id}}" class="text-center color_show_alert" style="display: none;"></p>
                                        </td>
                                        <td class="text-center">
                                            <input id="toggle-store-status-{{$data->id}}" class="toggle_store_status" onchange="store_status_click({{$data->id}})" postID="{{$data->id}}" type="checkbox" value="1" name="store_status" <?php if($data->store_status == 1): ?> checked <?php endif; ?> data-toggle="toggle">
                                        <div id="console_event_{{$data->id}}"></div>
                                        </td>
                                        <td class="text-center">
                                            {{$data->created}}
                                            <br>
                                            @if($data->status == 0)
                                                Public
                                            @else
                                                Draft
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="fr">
                            {!! $data_product->appends(request()->except('page'))->links() !!}
                        </div>
                    </div> <!-- /.card-body -->
                </div><!-- /.card -->
            </div> <!-- /.col -->
        </div> <!-- /.row -->
    </div> <!-- /.container-fluid -->
</section>
@endsection