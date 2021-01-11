$(function(){
    $('.btnRate').on('click',function(){
        var rating_title = $('#rating_title').val();
        var rating_content = $('#rating_content').val();
        var index = $('.star').val();
        var product_id = $('.proId').val();

        // alert(product_id);
        $.ajax({
            url:"http://127.0.0.1:8000/insert-rating",
            method:"POST",
            data:{index:index, product_id:product_id, rating_title:rating_title, rating_content:rating_content},
            success:function(data){
              if(data =='done'){
                alert("Bạn đã đánh giá "+ index + " sao");
              }else{
                alert("Lỗi lầm");
              }
               
            }
        });
        
    });
});