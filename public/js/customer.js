$(document).ready(function () {
  console.log("ready!");
  $("#datepicker").datepicker();
  $('#changePassword').change(function () {
    $('#changepassblock').toggleClass("hide");
  });
  $("#UpdateButton").on('click', function () {
    console.log("CLick update")
    var hoten = $("#inputName")[0].value;
    var sdt = $("#inputPhone")[0].value;
    var gioitinh=$("#inlineRadio1")[0].checked;
    if (gioitinh == true)
    {
      gioitinh="male"
    }
    else{
      gioitinh="female"
    }
    var email=$("#inputEmail")[0].value;
    var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/; 
    if (!filter.test(email)) { 
             alert('Hãy nhập địa chỉ email hợp lệ.\nExample@gmail.com');
             return false; 
    }

    var ngaysinh=$("#inputEmail")[0].value;
    var doimatkhau=$("#changePassword")[0].checked;
    if(doimatkhau==true)
    {
      var mkcu=$("#OldPassword")[0].value;
      var mkmoi=$("#NewPassword")[0].value;
      var mknhaplai=$("#NewPassword1")[0].value;
      if(mkcu==""||mkmoi==""||mknhaplai=="")
      {
        alert("Vui lòng nhập đầy đủ thông tin mật khẩu");
        return;
      }

      if(mkcu==mkmoi)
      {
        alert("Mật khẩu mới phải khác mật khẩu cũ");
        return;
      }
      else if(mkmoi!=mknhaplai)
      {
        alert("Mật khẩu nhập lại không trùng khớp");
        return;
      }
    }
    if (hoten == undefined || hoten == "")
    {
      alert("Vui lòng kiểm tra lại thông tin");
      return;
    }
    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: "POST",
      url: '/user',
      
      data: { 'username': hoten, 'phone':sdt,'gender':gioitinh,'email':email,'doimatkhau':doimatkhau, 'newpassword':mkmoi,'oldpassword':mkcu,'newpassword1':mknhaplai,  "_token": $('#token').val() },
      success: function (resp) {
        data = JSON.parse(resp)
        if (data.code == 200) {
          alert("Cập nhật thành công");
        }
        else {
          alert("Cập nhật thất bại")
        }
      },
      error: function (data, textStatus, errorThrown) {
        console.log(data);
      },
    });
    // 
  })
});