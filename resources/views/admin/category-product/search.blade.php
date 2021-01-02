@extends('admin.layouts.app')
@section('seo')
<?php
$data_seo = array(
    'title' => 'Search Category Product | '.Helpers::get_option_minhnn('seo-title-add'),
    'keywords' => Helpers::get_option_minhnn('seo-keywords-add'),
    'description' => Helpers::get_option_minhnn('seo-description-add'),
    'og_title' => 'Search Category Product | '.Helpers::get_option_minhnn('seo-title-add'),
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
        <h1 class="m-0 text-dark">Search Category Product</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
          <li class="breadcrumb-item active">Search Category Product</li>
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
		            	<h3 class="card-title">Search Category Product</h3>
		          	</div> <!-- /.card-header -->
		          	<div class="card-body">
                        <div class="clear">
                            <ul class="nav fl">
                                <li class="nav-item">
                                    <a class="btn btn-danger" onclick="delete_id('category_product')" href="javascript:void(0)"><i class="fas fa-trash"></i> Delete</a>
                                </li>
                                <li class="nav-item">
                                    <a class="btn btn-primary" href="{{route('admin.createCategoryProduct')}}" style="margin-left: 6px;"><i class="fas fa-plus"></i> Add New</a>
                                </li>
                            </ul>
                            <div class="fr">
                                <form method="GET" action="{{route('admin.searchCategoryProduct')}}" id="frm-filter-post" class="form-inline">
                                    <input type="text" class="form-control" name="search_title" id="search_title" placeholder="Từ khoá">
                                    <button type="submit" class="btn btn-primary ml-2">Tìm kiếm</button>
                                </form>
                            </div>
                        </div>
                        <br/>
                        <div class="clear">
                            <div class="fr">
                                {!! $data_category->links() !!}
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
                                        <th scope="col" class="text-center">Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data_category as $data)
                                    <tr>
                                        <td class="text-center"><input type="checkbox" id="{{$data->id}}" name="seq_list[]" value="{{$data->id}}"></td>
                                        <td class="text-center">
                                            <?php
                                            $url_foder_upload = "/images/category/";
                                            $seq = $data->categoryID;
                                            $title = $data->categoryName;
                                            $title_en = $data->categoryName_en;
                                            $parent_cat = $data->categoryParent;
                                            $categories_views = \App\Model\Category_Theme::get()->toArray();
                                            $breacurm = "__None__";
                                            if($categories_views):
                                                $breacurm = \App\WebService\WebService::getParentCategory($categories_views,$parent_cat);
                                            endif;
                                            $menu_show = "";
                                            if($data->categoryIndex == 1){
                                                 $menu_show = "<p style='color: #FF6600;'>Hiện thị lên menu</p>";
                                            }else{
                                                $menu_show = "";
                                            }
                                            $home_show = "";
                                            if($data->showhome == 1){
                                                 $home_show = "<p style='color: #2EAF1F;'>Hiện thị lên trang chủ</p>";
                                            }else{
                                                $home_show = "";
                                            }
                                            $title_content = "
                                            <a class='row-title' href='".route('admin.categoryProductDetail', array($seq))."''><p><b style='color: #056FAD;'>".$title."</b></p>
                                            <p><b style='color:#777;'>Slug:</b> <span style='color:#c76805;'>".$data->categorySlug."</span></p></a>
                                            <p><b style='color:#777;'>URL:</b> <span><a style='color:#00C600; word-break:break-all;' target='_blank' href='".route('category.list',$data->categorySlug)."'>".route('category.list',$data->categorySlug)."</a></span></p>
                                            <p><b style='color:#777;'>Parent: </b><span class='category_theme_breacum' style='font-style: italic; color: #e818a8;'>".$breacurm."</span></p><p><b style='color:#777;'>Vị Trí: </b><font style='color:#F00;'>".$data->categoryShort."</font></p>".$menu_show.$home_show;
                                            echo $title_content;
                                            ?>    
                                        </td>
                                        <td class="text-center">
                                            @if($data->thubnail != '')
                                                <img src="{{asset('images/category/'.$data->thubnail)}}" height="70">
                                            @else
                                                <img src="{{asset('img/default-150x150.png')}}">
                                            @endif
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
                            {!! $data_category->links() !!}
                        </div>
                    </div> <!-- /.card-body -->
	      		</div><!-- /.card -->
	    	</div> <!-- /.col -->
	  	</div> <!-- /.row -->
  	</div> <!-- /.container-fluid -->
</section>
@endsection