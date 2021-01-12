@extends('admin.layouts.app')
@section('seo')
<?php
$data_seo = array(
    'title' => 'Filter Orders | '.Helpers::get_option_minhnn('seo-title-add'),
    'keywords' => Helpers::get_option_minhnn('seo-keywords-add'),
    'description' => Helpers::get_option_minhnn('seo-description-add'),
    'og_title' => 'Filter Orders | '.Helpers::get_option_minhnn('seo-title-add'),
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
        <h1 class="m-0 text-dark">Filter Orders</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
          <li class="breadcrumb-item active">Filter Orders</li>
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
                        <h3 class="card-title">Danh sách các đơn hàng</h3>
                    </div> <!-- /.card-header -->
                    <div class="card-body">
                        <div class="clear">
                            <ul class="nav fl">
                                <li class="nav-item">
                                    <a class="btn btn-danger" onclick="delete_id('order')" href="javascript:void(0)"><i class="fas fa-trash"></i> Delete</a>
                                </li>
                            </ul>
                            <div class="fr">
                                <form method="GET" action="{{route('admin.searchOrder')}}" id="frm-filter-post" class="form-inline">
                                    {{-- <select class="custom-select mr-2" name="order_status">
                                        <option value="">Tình trạng đơn hàng</option>
                                        <option value="1" >Chờ xử lý</option>
                                        <option value="2" >Huỷ</option>
                                        <option value="3">Đang xử lý</option>
                                        <option value="4">Đang giao hàng</option>
                                        <option value="5">Hoàn thành</option>
                                    </select> --}}
                                    {{-- <input type="text" class="form-control" value="<?php if(isset($_GET['search_title'])){ echo $_GET['search_title']; } ?>" name="search_title" id="search_title" placeholder="Mã đơn hàng"> --}}
                                    {{-- <button type="submit" class="btn btn-primary ml-2">Tìm kiếm</button> --}}
                                </form>
                            </div>
                        </div>
                        <br/>
                        <div class="clear">
                            <div class="fr">
                                {{-- {!! $data_order->links() !!} --}}
                            </div>
                        </div>
                        <br/>
                        <div class="table-responsive">
                            <form action="{{route('order_state.update')}}" method="POST">
                                @csrf
                            <table class="table table-bordered" id="table_index">
                                <thead>
                                    <tr>
                                        <th scope="col" class="text-center"><input type="checkbox" id="selectall" onclick="select_all()"></th>
                                        <th scope="col" class="text-center">Mã đơn hàng</th>
                                        <th scope="col" class="text-center">Họ tên</th>
                                        <th scope="col" class="text-center">Thời gian đặt</th>
                                        <th scope="col" class="text-center">Tổng giá trị</th>
                                        {{-- <th scope="col" class="text-center">Chọn tình trạng</th> --}}

                                        <th scope="col" class="text-center">Tình trạng hiện tại</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- @foreach($data_order as $data) --}}
                                    @foreach($user_order as $data)
                                    <tr>
                                        <td class="text-center"><input type="checkbox" id="{{$data->order_id}}" name="seq_list[]" value="{{$data->order_id}}"></td>
                                        <td>{{$data->order_id}}</td>
                                        <td>{{$data->name}}</td>
                                        <td>{{$data->order_created}}</td>
                                        <td>{{$data->order_totalPrice}}</td>
                                        
{{--                                             
                                                <select id=""  class="custom-select mr-2 state" name="order_status" data-id="{{$data->order_id   }}">                            
                                                    <option value="5">Tình trạng đơn hàng</option>
                                                    <option value="Chờ xử lý" >Chờ xử lý</option>
                                                    <option value="Huỷ" >Huỷ</option>
                                                    <option value="Đang xử lý">Đang xử lý</option>
                                                    <option value="Đang giao hàng">Đang giao hàng</option>
                                                    <option value="Hoàn thành">Hoàn thành</option>
                                                </select>
                                            --}}
                                          
                                        
          
                                        <td>{{$data->order_state}}</td>
                                        <input type="hidden" name="order_id" class="order_id" value="{{$data->order_id}}"/>
                                        <input id="{{$data->order_id}}" type="hidden" name="order_state" class="order_state input-state" value="{{$data->order_state}}"/>
                                    </tr>
                             
                                    @endforeach
                                   
                                </tbody>
                            </table>
                            <button type="submit" class="btn btn-primary ml-2">Cập nhật</button>
                        </form>
                        </div>
                        <div class="fr">
                            {{-- {!! $data_order->links() !!} --}}
                        </div>
                    </div> <!-- /.card-body -->
                </div><!-- /.card -->
            </div> <!-- /.col -->
        </div> <!-- /.row -->
    </div> <!-- /.container-fluid -->
</section>
<script>
    
     Array.from(document.getElementsByClassName('state')).foreach((element) => {
            element.addEventListener("change", function (event) {
                console.log(element.data.id)
            let value = this.value;
            document.getElementById(element.data.id).value= value;
        })
    })
 </script> 
@endsection

