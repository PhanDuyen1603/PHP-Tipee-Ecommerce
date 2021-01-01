</div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2021 <a href="{{route('index')}}">Diên Diên</a></strong></a>
  </footer>
  <!-- Modal Export Customer -->
  <div class="modal fade" id="modal-export-customer" tabindex="-1" role="dialog" aria-labelledby="modal-export-customer-label" aria-hidden="true">
    <form action="{{route('admin.exportCustomer')}}" method="GET" id="export-customer">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modal-export-customer-label">Xuất dữ liệu khách hàng</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="body-export-customer">
              <div class="row">
                <div class="col-md-6">
                  <label>Từ ngày:</label>
                  <div class="input-group date" id="cus_from" data-target-input="nearest">
                      <input type="text" name="cus_from" class="form-control datetimepicker-input" data-target="#cus_from" placeholder="YYYY-MM-DD">
                      <div class="input-group-append" data-target="#cus_from" data-toggle="datetimepicker">
                          <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                      </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <label>Đến ngày:</label>
                  <div class="input-group date" id="cus_to" data-target-input="nearest">
                      <input type="text" name="cus_to" class="form-control datetimepicker-input" data-target="#cus_to" placeholder="YYYY-MM-DD">
                      <div class="input-group-append" data-target="#cus_to" data-toggle="datetimepicker">
                          <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                      </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Export</button>
          </div>
        </div>
      </div>
    </form>
  </div> <!-- End Modal Export Customer -->

  <!-- Modal Export Order -->
  <div class="modal fade" id="modal-export-order" tabindex="-1" role="dialog" aria-labelledby="modal-export-order-label" aria-hidden="true">
    <form action="{{route('admin.exportOrders')}}" method="GET" id="export-order">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modal-export-order-label">Xuất dữ liệu đơn hàng</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="body-export-order">
              <div class="row">
                <div class="col-md-6">
                  <label>Từ ngày:</label>
                  <div class="input-group date" id="order_from" data-target-input="nearest">
                      <input type="text" name="order_from" class="form-control datetimepicker-input" data-target="#order_from" placeholder="YYYY-MM-DD">
                      <div class="input-group-append" data-target="#order_from" data-toggle="datetimepicker">
                          <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                      </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <label>Đến ngày:</label>
                  <div class="input-group date" id="order_to" data-target-input="nearest">
                      <input type="text" name="order_to" class="form-control datetimepicker-input" data-target="#order_to" placeholder="YYYY-MM-DD">
                      <div class="input-group-append" data-target="#order_to" data-toggle="datetimepicker">
                          <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                      </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Export</button>
          </div>
        </div>
      </div>
    </form>
  </div> <!-- End Modal Export Customer -->
  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<script type="text/javascript">
  jQuery(document).ready(function ($){
    //Date range picker
    $('#cus_from').datetimepicker({
      format: 'YYYY-MM-DD'
    });

    $('#cus_to').datetimepicker({
      format: 'YYYY-MM-DD'
    });

    $('#order_from').datetimepicker({
      format: 'YYYY-MM-DD'
    });

    $('#order_to').datetimepicker({
      format: 'YYYY-MM-DD'
    });
    
  });
</script>
</body>
</html>