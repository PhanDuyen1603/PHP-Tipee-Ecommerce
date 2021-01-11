</div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2021 <a href="<?php echo e(route('index')); ?>">Tipee</a></strong></a>
  </footer>
  <!-- Modal Export Customer -->
  <div class="modal fade" id="modal-export-customer" tabindex="-1" role="dialog" aria-labelledby="modal-export-customer-label" aria-hidden="true">
    
  </div> <!-- End Modal Export Customer -->

  <!-- Modal Export Order -->
  <div class="modal fade" id="modal-export-order" tabindex="-1" role="dialog" aria-labelledby="modal-export-order-label" aria-hidden="true">
    
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
</html><?php /**PATH C:\xampp\htdocs\Lap-Trinh-Web-Team-Official\resources\views/admin/layouts/footer.blade.php ENDPATH**/ ?>