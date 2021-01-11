@php
        if(!empty($product->price_origin) &&  $product->price_origin >0):
                    $price_origin=number_format($product->price_origin)." đ ";
                else:
                    $price_origin="";
                endif;
                if(!empty($product->price_promotion) &&  $product->price_promotion >0):
                    $price_promotion=number_format($product->price_promotion)." đ ";
                else:
                    $price_promotion="Liên hệ";
                endif;
                if(intval($product->price_promotion)<=intval($product->price_origin) && $product->price_promotion !='' && $product->price_origin !=''):
                    $val_td=intval($product->price_origin)-intval($product->price_promotion);
                    $percent=($val_td/intval($product->price_origin))*100;
                    $note_percent = '<span class="label sale">SALE</span>';
                    $circle_sale= '<span class="percent deal">-'.intval($percent).'%</span>';
                    $price_promotion = number_format($product->price_promotion)." đ ";
                   $original =  '<span class="original deal">'.number_format($product->price_origin)." đ ".'</span>';
                else:
                    $val_td=0;
                    $percent=0;
                    $note_percent="";
                    $circle_sale='';
                    $original = '';
                    $price_promotion = number_format($product->price_origin)." đ ";
                endif;
                $url_img="images/product";
                if(!empty($product->thubnail) && $product->thubnail !=""):
                    $thumbnail= Helpers::getThumbnail($url_img,$product->thubnail, 280, 280, "resize");
                    if(strpos($thumbnail, 'placehold') !== false):
                        $thumbnail=$url_img.$thumbnail;
                    endif;
                else:
                    $thumbnail="https://dummyimage.com/280x280/000/fff";
                endif;  

@endphp
<a href="{{ route('product.detail', $product->slug) }}" class="home_flashdeal_item"
    title="{{$product->title}}" rel="">
    <div class="image-product"><img src="{{$thumbnail}}"
            alt="{{$product->title}}"
            class="image-product"></div>
    <div class="title">{{ $product->title }}</div>
    <p class="price">{!!$price_promotion!!}{!!$circle_sale!!}{!!$original!!}</p>
</a>