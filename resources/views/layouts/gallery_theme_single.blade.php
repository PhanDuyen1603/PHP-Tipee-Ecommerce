<div class="xzoom-container">
  <?php
  $s_gallery_array_filter=array_filter($store_gallery);
  if(count($s_gallery_array_filter)>0 && !empty($s_gallery_array_filter)):
    $background_img="";
    $thumbnail_img="";
    $url_img='images/product';
  ?> 
  <img class="xzoom" src="<?php echo URL::to($url_img."/".$s_gallery_array_filter[0]); ?>" xoriginal="<?php echo URL::to($url_img."/".$s_gallery_array_filter[0]); ?>" />
  <div class="xzoom-thumbs">
    <?php
    for($i=0;$i<count($s_gallery_array_filter);$i++):
      //echo $s_gallery_array[$i];
      if(!empty($s_gallery_array_filter[$i]) && $s_gallery_array_filter[$i] !=""):
        $thumbnail_img=Helpers::getThumbnail($url_img,$s_gallery_array_filter[$i], 50, 70, "resize");
        if(strpos($thumbnail_img, 'placehold') !== false):
          $thumbnail_img=URL::to($url_img.$thumbnail_img);
        endif;
      else:
        $thumbnail_img="https://dummyimage.com/50x70/000/fff";
      endif;
    ?>
     <a href="<?php echo URL::to($url_img."/".$s_gallery_array_filter[$i]); ?>">
      <img class="xzoom-gallery" src="<?php echo URL::to($url_img."/".$s_gallery_array_filter[$i]); ?>" width="80" alt="thubnail"/>
  </a>
  <?php endfor; ?>
  <?php else: ?>
  <a class="html5lightbox woocommerce-main-image" itemprop="url" href="<?php echo $thumbnail_img; ?>" data-rel="magnific" rel="nofollow">
    <img itemprop="image" src="<?php echo $thumbnail_img; ?>" alt="<?php echo $thumbnail_img_alt; ?>">
  </a>
<?php endif; ?>
<!-- *******************************************Gallery*********************************************************-->
</div>
</div>    
