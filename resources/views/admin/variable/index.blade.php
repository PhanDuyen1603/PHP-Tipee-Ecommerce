@extends('admin.layouts.app')
@section('seo')
<?php
$data_seo = array(
    'title' => 'List Variable Product | '.Helpers::get_option_minhnn('seo-title-add'),
    'keywords' => Helpers::get_option_minhnn('seo-keywords-add'),
    'description' => Helpers::get_option_minhnn('seo-description-add'),
    'og_title' => 'List Variable Product | '.Helpers::get_option_minhnn('seo-title-add'),
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
        <h1 class="m-0 text-dark">List Variable Product</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
          <li class="breadcrumb-item active">List Variable Product</li>
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
		            	<h3 class="card-title">List Variable Product</h3>
		          	</div> <!-- /.card-header -->
		          	<div class="card-body">
                        <div class="clear">
                            <ul class="nav fl">
                                <li class="nav-item">
                                    <a class="btn btn-danger" onclick="delete_id('variable_product')" href="javascript:void(0)"><i class="fas fa-trash"></i> Delete</a>
                                </li>
                                <li class="nav-item">
                                    <a class="btn btn-primary" href="{{route('admin.createVariableProduct')}}" style="margin-left: 6px;"><i class="fas fa-plus"></i> Add New</a>
                                </li>
                            </ul>
                            <div class="fr">
                                <form method="GET" action="{{route('admin.searchVariableProduct')}}" id="frm-filter-post" class="form-inline">
                                    <input type="text" class="form-control" name="search_title" id="search_title" placeholder="Từ khoá">
                                    <button type="submit" class="btn btn-primary ml-2">Tìm kiếm</button>
                                </form>
                            </div>
                        </div>
                        <br/>
                        <div class="clear">
                            <div class="fr">
                                {!! $data_variable->links() !!}
                            </div>
                        </div>
                        <br/>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="table_index">
                                <thead>
                                    <tr>
                                        <th scope="col" class="text-center"><input type="checkbox" id="selectall" onclick="select_all()"></th>
                                        <th scope="col" class="text-center">Title</th>
                                        <th scope="col" class="text-center">View</th>
                                        <th scope="col" class="text-center">Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data_variable as $data)
                                    <?php
                                        $child_list_varibles=\App\Model\Variable_Theme::where('variable_theme_parent', $data->variable_themeID)
                                            ->where('variable_theme_status',0)
                                            ->get();
                                        $child_html='<table width="100%" border="0" class="table_variable_child_'.$data->variable_themeID.' table_child_bt">
                                                       <tr>
                                                         <th align="center">Tên biến thể</th>
                                                         <th align="center">Slug</th>
                                                       </tr>';
                                        foreach($child_list_varibles as $child_list_varibles):
                                            $child_html .='<tr>
                                              <td class="name_varibles" align="center"><a href="'.route('admin.variableProductDetail', array($child_list_varibles->variable_themeID)).'">'.$child_list_varibles->variable_theme_name.'</a></td>
                                              <td class="slug_varibles" align="center">'.$child_list_varibles->variable_theme_slug.'</td>
                                            </tr>';
                                        endforeach;
                                        $child_html .='</table>'; 
                                    ?>
                                    <tr>
                                        <td class="text-center"><input type="checkbox" id="{{$data->variable_themeID}}" name="seq_list[]" value="{{$data->variable_themeID}}"></td>
                                        <td class="text-center">
                                            <a href="{{route('admin.variableProductDetail', array($data->variable_themeID))}}">
                                                <b>{{$data->variable_theme_name}}</b><br/>
                                                <b style="color:#c76805;">{{$data->variable_theme_slug}}</b>
                                            </a>
                                        </td>
                                        <td class="text-center column-slug">
                                            <a class="variable_readmore" sid="{{$data->variable_themeID}}" id="variable_{{$data->variable_themeID}}" href="javascript:void(0)"><?php echo strtoupper('Show Variable'); ?> <i class="fas fa-hand-point-right"></i></a>
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
                                    <tr class="alternate alternate_check_hide hidden" id="tr_{{$data->variable_themeID}}">
                                        <td class="slug column-slug" colspan="5"><?php echo $child_html; ?></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="fr">
                            {!! $data_variable->links() !!}
                        </div>
                    </div> <!-- /.card-body -->
	      		</div><!-- /.card -->
	    	</div> <!-- /.col -->
	  	</div> <!-- /.row -->
  	</div> <!-- /.container-fluid -->
</section>
<script type="text/javascript">
    $( document ).ready(function() {
        var $id;
        $('.column-slug').delegate('a.variable_readmore', 'click', function(e) {
            e.preventDefault();
            $id=$(this).attr('sid');
            if ($('#tr_'+$id).hasClass("action")){
                $('#tr_'+$id).removeClass("action");
            }else{
                $('#tr_'+$id).addClass( "action");
            }
        });
    });
</script>
@endsection