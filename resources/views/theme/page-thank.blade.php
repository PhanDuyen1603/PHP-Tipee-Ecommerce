@extends('layouts.app')
@section('seo')
<?php
$title='Đặt hàng thành công |'.Helpers::get_option_minhnn('seo-title-add');
$description=$title.Helpers::get_option_minhnn('seo-description-add');
$keyword='shop, cua hang,'.Helpers::get_option_minhnn('seo-keywords-add');
$thumb_img_seo=url('/images/').'/logo_1397577072.png';
$data_seo = array(
    'title' => $title,
    'keywords' => $keyword,
    'description' =>$description,
    'og_title' => $title,
    'og_description' => $description,
    'og_url' => Request::url(),
    'og_img' => $thumb_img_seo,
    'current_url' =>Request::url(),
    'current_url_amp' => ''
);
$seo = WebService::getSEO($data_seo);
?>
@include('partials.seo')
@endsection
@section('content')
<div class="main_content clear">
  <div class="container clear">
    <div class="body-container none_padding border-group clear">
      <section id="section" class="section clear">
        <div class="group-section-wrap clear row">
          <div class="col-md-12">
            <div class="center_txt thank_container">
              <div class="img_checked">
                <img src="{{asset('/img/icons8-checked-100.png')}}" width="80">
              </div>
              <h1 class="title_page_thank">Đặt hàng thành công!</h1>
              <div class="tks_page_cnt">
                <p>Siêu thị Ánh Dương xin chân thành cảm ơn bạn đã tin dùng.</p>
                <p>Chúng tôi sẽ liên hệ với bạn trong thời gian sớm nhất!</p>
              </div>
              <script type="text/javascript">
                  var time = 7;
                  setInterval(function() {
                    var seconds = time % 60;
                    var minutes = (time - seconds) / 60;
                    if (seconds.toString().length == 1) {
                      seconds = seconds;
                    }
                    document.getElementById("time").innerHTML = seconds;
                    time--;
                    if (time == 0) {
                      window.location.href = '<?php echo route('index'); ?>';
                    }
                  }, 1000);
              </script>
              <div class="timer" onload="timer(1800)" style="padding-top: 20px;">
                <div>Chuyển về trang chủ trong <strong><span id="time">7</span>s</strong> hoặc ấn vào <a href="{{route('index')}}" style="color: red">đây</a>!</div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>  
  </div>
</div>
@endsection
