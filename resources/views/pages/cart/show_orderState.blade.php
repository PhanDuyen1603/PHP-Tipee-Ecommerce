@extends('layouts.app')
@section('content') 
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
{{-- timeline --}}
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<!------ Include the above in your HEAD tag ---------->
<style>
    h3{text-align: center}
    th{
        font-size:17px;
    }
/* Timeline */
.timeline,
.timeline-horizontal {
  list-style: none;
  padding: 20px;
  position: relative;
}
.timeline:before {
  top: 40px;
  bottom: 0;
  position: absolute;
  content: " ";
  width: 3px;
  background-color: #eeeeee;
  left: 50%;
  margin-left: -1.5px;
}
.timeline .timeline-item {
  margin-bottom: 20px;
  position: relative;
}
.timeline .timeline-item:before,
.timeline .timeline-item:after {
  content: "";
  display: table;
}
.timeline .timeline-item:after {
  clear: both;
}
.timeline .timeline-item .timeline-badge {
  color: #fff;
  width: 54px;
  height: 54px;
  line-height: 52px;
  font-size: 22px;
  text-align: center;
  position: absolute;
  top: 18px;
  left: 50%;
  margin-left: -25px;
  background-color: #7c7c7c;
  border: 3px solid #ffffff;
  z-index: 100;
  border-top-right-radius: 50%;
  border-top-left-radius: 50%;
  border-bottom-right-radius: 50%;
  border-bottom-left-radius: 50%;
}
.timeline .timeline-item .timeline-badge i,
.timeline .timeline-item .timeline-badge .fa,
.timeline .timeline-item .timeline-badge .glyphicon {
  top: 2px;
  left: 0px;
}
.timeline .timeline-item .timeline-badge.primary {
  background-color: #1f9eba;
}
.timeline .timeline-item .timeline-badge.info {
  background-color: #5bc0de;
}
.timeline .timeline-item .timeline-badge.success {
  background-color: #59ba1f;
}
.timeline .timeline-item .timeline-badge.warning {
  background-color: #d1bd10;
}
.timeline .timeline-item .timeline-badge.danger {
  background-color: #ba1f1f;
}
.timeline .timeline-item .timeline-panel {
  position: relative;
  width: 46%;
  float: left;
  right: 16px;
  border: 1px solid #c0c0c0;
  background: #ffffff;
  border-radius: 2px;
  padding: 20px;
  -webkit-box-shadow: 0 1px 6px rgba(0, 0, 0, 0.175);
  box-shadow: 0 1px 6px rgba(0, 0, 0, 0.175);
}
.timeline .timeline-item .timeline-panel:before {
  position: absolute;
  top: 26px;
  right: -16px;
  display: inline-block;
  border-top: 16px solid transparent;
  border-left: 16px solid #c0c0c0;
  border-right: 0 solid #c0c0c0;
  border-bottom: 16px solid transparent;
  content: " ";
}
.timeline .timeline-item .timeline-panel .timeline-title {
  margin-top: 0;
  color: inherit;
}
.timeline .timeline-item .timeline-panel .timeline-body > p,
.timeline .timeline-item .timeline-panel .timeline-body > ul {
  margin-bottom: 0;
}
.timeline .timeline-item .timeline-panel .timeline-body > p + p {
  margin-top: 5px;
}
.timeline .timeline-item:last-child:nth-child(even) {
  float: right;
}
.timeline .timeline-item:nth-child(even) .timeline-panel {
  float: right;
  left: 16px;
}
.timeline .timeline-item:nth-child(even) .timeline-panel:before {
  border-left-width: 0;
  border-right-width: 14px;
  left: -14px;
  right: auto;
}
.timeline-horizontal {
  list-style: none;
  position: relative;
  padding: 20px 0px 20px 0px;
  display: inline-block;
}
.timeline-horizontal:before {
  height: 3px;
  top: auto;
  bottom: 26px;
  left: 56px;
  right: 0;
  width: 100%;
  margin-bottom: 20px;
}
.timeline-horizontal .timeline-item {
  display: table-cell;
  height: 280px;
  width: 20%;
  min-width: 320px;
  float: none !important;
  padding-left: 0px;
  padding-right: 20px;
  margin: 0 auto;
  vertical-align: bottom;
}
.timeline-horizontal .timeline-item .timeline-panel {
  top: auto;
  bottom: 64px;
  display: inline-block;
  float: none !important;
  left: 0 !important;
  right: 0 !important;
  width: 100%;
  margin-bottom: 20px;
}
.timeline-horizontal .timeline-item .timeline-panel:before {
  top: auto;
  bottom: -16px;
  left: 28px !important;
  right: auto;
  border-right: 16px solid transparent !important;
  border-top: 16px solid #c0c0c0 !important;
  border-bottom: 0 solid #c0c0c0 !important;
  border-left: 16px solid transparent !important;
}
.timeline-horizontal .timeline-item:before,
.timeline-horizontal .timeline-item:after {
  display: none;
}
.timeline-horizontal .timeline-item .timeline-badge {
  top: auto;
  bottom: 0px;
  left: 43px;
}

</style>

<section>
  
    <div class="container">
        <h1 style="text-align: center">Tra cứu đơn hàng</h1>
        @foreach($user_order as $key => $order)
            <?php $time_received =  $order['order_receivedDate'];?>
            <?php $time_created = $order['order_created'];?>
        @endforeach
        <div id="timeline_section">
            <div class="row">
				<div class="col-md-12">
					<div class="page-header">
					  <h2>Tình trạng đơn hàng</h2>
					</div>
					<div style="display:inline-block;width:100%;overflow-y:auto;">
					<ul class="timeline timeline-horizontal">
						<li class="timeline-item">
							<div class="timeline-badge primary"><i class="glyphicon glyphicon-check"></i></div>
							<div class="timeline-panel">
								<div class="timeline-heading">
									<h4 class="timeline-title">Đặt hàng thành công</h4>
                                    <p><small class="text-muted"><i class="glyphicon glyphicon-time"></i><?php  ?></small></p>
								</div>
								<div class="timeline-body">
									<p><?php echo $time_received ;?></p>
								</div>
							</div>
						</li>
						<li class="timeline-item">
							<div class="timeline-badge success"><i class="glyphicon glyphicon-check"></i></div>
							<div class="timeline-panel">
								<div class="timeline-heading">
									<h4 class="timeline-title">Xác nhận đơn hàng và đóng gói</h4>
									<p><small class="text-muted"><i class="glyphicon glyphicon-time"></i></small></p>
								</div>
								<div class="timeline-body">
									<p><?php $date = new DateTime($time_received);
                                        $date->add(new DateInterval('PT1H25S'));
                                        echo $date->format('Y-m-d H:i:s');?></p>
								</div>
							</div>
						</li>
					
						<li class="timeline-item">
							<div class="timeline-badge danger"><i class="glyphicon glyphicon-check"></i></div>
							<div class="timeline-panel">
								<div class="timeline-heading">
									<h4 class="timeline-title">Vận chuyển</h4>
									<p><small class="text-muted"><i class="glyphicon glyphicon-time"></i></small></p>
								</div>
								<div class="timeline-body">
									<p><?php $date = new DateTime($time_received);
                    $date->add(new DateInterval('PT1H50S'));
                    echo $date->format('Y-m-d H:i:s');?></p>
								</div>
							</div>
                        </li>	
                        <li class="timeline-item">
							<div class="timeline-badge primary"><i class="glyphicon glyphicon-check"></i></div>
							<div class="timeline-panel">
								<div class="timeline-heading">
									<h4 class="timeline-title">Nhận hàng</h4>
									<p><small class="text-muted"><i class="glyphicon glyphicon-time"></i></small></p>
								</div>
								<div class="timeline-body">
									<p><?php echo $time_received ;?></p>
								</div>
							</div>
						</li>					
					</ul>
				</div>
				</div>
			</div>
        </div>
        <div class="customer_info">
            <h3></h3>
        </div>
        <div class="orders">
          <div class="page-header">
					  <h2>Tình trạng đơn hàng</h2>
					</div>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">Tên sản phẩm</th>
                        <th scope="col">Số lượng</th>
                        <th scope="col">Thành tiền</th>
                        
                    </tr>
                </thead>              
                 @foreach($user_order as $key => $order)
                <tbody>
                    <tr>
                        <td>{{$order->title}}</td>
                        <td>{{$order->order_quantity}}</td>
                        <td>{{number_format($order->order_price) . ' đ'}}</td>
                    </tr>                   
                </tbody>               
               
               @endforeach
               
                
               
                
            </table>
            <h4 style="float:right;">Tổng tiền: <span style="font-weight:bold">{{number_format($totalPrice) . ' đ'}}</span></h4>
        </div>
       
    </div>
</section>
<script>
    var completes = document.querySelectorAll(".complete");
var toggleButton = document.getElementById("toggleButton");


function toggleComplete(){
  var lastComplete = completes[completes.length - 1];
  lastComplete.classList.toggle('complete');
}

toggleButton.onclick = toggleComplete;
</script>
@endsection