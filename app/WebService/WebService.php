<?php

namespace App\WebService;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Libraries\Helpers;
use App\Model\Theme, App\Model\Page, App\Model\Post, App\Model\Slishow, App\Model\Ads, App\Model\Category_Theme, App\Model\Variable_Theme, App\Model\Video_page, App\Model\Discount_for_brand, App\Model\Brand, App\Model\Category, App\Model\Province, App\Model\District, App\Model\Ward, App\Model\Join_Category_Post, App\Model\Theme_variable_sku, App\Model\Theme_variable_sku_value, App\Model\Wishlist;
use Illuminate\Pagination\Paginator;
use Route, HTML, Crypt, Config, DateTime, Image, Cache, Session, DB, Carbon\Carbon;
use Illuminate\Support\Str;
use Harimayco\Menu\Facades\Menu;

class WebService {
    // SEO
    
    public static function getProductHome($rows){
        $html = '';
        if(count($rows)>0){
           
            foreach($rows as $item){
                
                if(!empty($item['price_origin']) &&  $item['price_origin'] >0):
                    $price_origin=number_format($item['price_origin'])." đ ";
                else:
                    $price_origin="";
                endif;
                if(!empty($item['price_promotion']) &&  $item['price_promotion'] >0):
                    $price_promotion=number_format($item['price_promotion'])." đ ";
                else:
                    $price_promotion="Liên hệ";
                endif;
                if(intval($item['price_promotion'])<=intval($item['price_origin']) && $item['price_promotion'] !='' && $item['price_origin'] !=''):
                    $val_td=intval($item['price_origin'])-intval($item['price_promotion']);
                    $percent=($val_td/intval($item['price_origin']))*100;
                    $note_percent = '<span class="label sale">SALE</span>';
                    $circle_sale= '<span class="percent deal">-'.intval($percent).'%</span>';
                    $price_promotion = number_format($item['price_promotion'])." đ ";
                   $original =  '<span class="original deal">'.number_format($item['price_origin'])." đ ".'</span>';
                else:
                    $val_td=0;
                    $percent=0;
                    $note_percent="";
                    $circle_sale='';
                    $original = '';
                    $price_promotion = number_format($item['price_origin'])." đ ";
                endif;
                $url_img="images/product";
                if(!empty($item['thubnail']) && $item['thubnail'] !=""):
                    $thumbnail= Helpers::getThumbnail($url_img,$item['thubnail'], 280, 280, "resize");
                    if(strpos($thumbnail, 'placehold') !== false):
                        $thumbnail=$url_img.$thumbnail;
                    endif;
                else:
                    $thumbnail="https://dummyimage.com/280x280/000/fff";
                endif;
                $html.='<a href="cdafd" class="home_flashdeal_item" title="'.$item['title'].'" rel=""><div class="image-product"><img src="'.$thumbnail.'" alt="'.$item['title'].'" class="image-product"></div><div class="title">'.$item['title'].'</div><p class="price">'.$price_promotion.''.$circle_sale.''.$original.'</p></a>';
            }
        }
        return $html;
    }
    
    public static function getProductSearch($rows){
        $html = '';
        if(count($rows)>0){
           
            foreach($rows as $item){
                if(!empty($item->price_origin) &&  $item->price_origin >0):
                    $price_origin=number_format($item->price_origin)." đ ";
                else:
                    $price_origin="";
                endif;
                if(!empty($item->price_promotion) &&  $item->price_promotion >0):
                    $price_promotion=number_format($item->price_promotion)." đ ";
                else:
                    $price_promotion="Liên hệ";
                endif;
                if(intval($item->price_promotion)<=intval($item->price_origin) && $item->price_promotion !='' && $item->price_origin !=''):
                    $val_td=intval($item->price_origin)-intval($item->price_promotion);
                    $percent=($val_td/intval($item->price_origin))*100;
                    $note_percent = '<span class="label sale">SALE</span>';
                    $circle_sale= '<span class="percent deal">-'.intval($percent).'%</span>';
                    $price_promotion = number_format($item->price_promotion)." đ ";
                   $original =  '<span class="original deal">'.number_format($item->price_origin)." đ ".'</span>';
                else:
                    $val_td=0;
                    $percent=0;
                    $note_percent="";
                    $circle_sale='';
                    $original = '';
                    $price_promotion = number_format($item->price_origin)." đ ";
                endif;
                $url_img="images/product";
                if(!empty($item->thubnail) && $item->thubnail !=""):
                    $thumbnail= Helpers::getThumbnail($url_img,$item->thubnail, 280, 280, "resize");
                    if(strpos($thumbnail, 'placehold') !== false):
                        $thumbnail=$url_img.$thumbnail;
                    endif;
                else:
                    $thumbnail="https://dummyimage.com/280x280/000/fff";
                endif;
                $html.='<a class="home_flashdeal_item" title="'.$item->title.'" rel=""><div class="image-product"><img src="'.$thumbnail.'" alt="'.$item->title.'" class="image-product"></div><div class="title">'.$item->title.'</div><p class="price">'.$price_promotion.''.$circle_sale.''.$original.'</p></a>';
            }
        }
        return $html;
    }
    public function getSEO($data = array()){
        $seo = array();
        $seo['title'] = isset($data['title'])?$data['title']:'';
        $seo['keywords'] = isset($data['keywords'])?$data['keywords']:'';
        $seo['description'] = isset($data['description'])?$data['description']:'';
        $seo['og_title'] = isset($data['og_title'])?$data['og_title']:'';
        $seo['og_description'] = isset($data['og_description'])?$data['og_description']:'';
        $seo['og_url'] = isset($data['og_url'])?$data['og_url']:'';
        $seo['og_img'] = isset($data['og_img'])?$data['og_img']:'';
        $seo['current_url'] = isset($data['current_url'])?$data['current_url'] : '';
        $seo['current_url_amp'] = isset($data['current_url_amp'])?$data['current_url_amp'] :'';
        return $seo;
    }//end function
    public function ListMenuCate(){
        $result ="";
        //showMenuhtml($menus,$menu_current,$id_parent = 0);
        //DB::table('category_theme')
        $categories=Category_Theme::where('categoryIndex',1)
            ->where('status_category',0)
            ->select('categoryParent','categoryID','categorySlug','categoryName','theme_category_icon')
            ->orderBy('categoryShort','DESC')
            ->get()->toArray();
        //dd($categories);
        $result .= self::showMenuhtml($categories,0,0);

        /*
        $result ="";
        $menu_class_id="";
        $primary_menus="";
        if($menu_name !=''):
            $primary_menus = Menu::getByName($menu_name);
            if($primary_menus):
                if($menu_class !=''):
                    $menu_class_id=$menu_class;
                else:
                    $menu_class_id="default_menu_product_home_read";
                endif;
                $result .= '<ul id="'.$menu_class_id.'" class="main-menu category_menu_product_home_read  middle" itemscope itemtype="http://schema.org/SiteNavigationElement">';
                foreach($primary_menus as $menu):
                    $result .= '<li class="menu-item level1 '.$menu['class'].'">
                        <a href="'.$menu['link'].'" target="'.$menu['target'].'" rel="'.$menu['rel'].'">'.$menu['label'].'</a>';
                    if( $menu['child'] ):
                        $result .= '<ul class="menu-item has-sub">';
                        foreach( $menu['child'] as $child ):
                            $result .= '<li class="sub-menu-item level2 '.$child['class'].'">';
                            if($child['label'] !='' && str_replace(" ","",$child['label']) !=''):
                                $result .= '<a target="'.$child['target'].'" rel="'.$child['rel'].'" href="'.$child['link'].'">'.$child['label'].'</a>';
                            endif;
                            if( $child['child'] ):
                                $result .= '<ul class="menu-item has-sub">';
                                foreach( $child['child'] as $child_lv3 ):
                                    $result .= '<li class="sub-menu-item level3 '.$child_lv3['class'].'">';
                                    if($child_lv3['label'] !='' && str_replace(" ","",$child_lv3['label']) !=''):
                                        $result .= '<a target="'.$child_lv3['target'].'" rel="'.$child_lv3['rel'].'" href="'.$child_lv3['link'].'">'.$child_lv3['label'].'</a>';
                                    endif;
                                    if( $child_lv3['child'] ):
                                        $result .= '<ul class="menu-item has-sub">';
                                        foreach( $child_lv3['child'] as $child_lv4 ):
                                            $result .= '<li class="sub-menu-item level4 '.$child_lv4['class'].'">';
                                            if($child_lv4['label'] !='' && str_replace(" ","",$child_lv4['label']) !=''):
                                                $result .= '<a target="'.$child_lv4['target'].'" rel="'.$child_lv4['rel'].'" href="'.$child_lv4['link'].'">'.$child_lv4['label'].'</a>';
                                            endif;
                                            if( $child_lv4['child'] ):
                                                $result .= '<ul class="menu-item has-sub">';
                                                foreach( $child_lv4['child'] as $child_lv5 ):
                                                    $result .= '<li class="sub-menu-item level5 '.$child_lv5['class'].'"><a target="'.$child_lv5['target'].'" rel="'.$child_lv5['rel'].'" href="'.$child_lv5['link'].'">'.$child_lv5['label'].'</a></li>';
                                                endforeach;
                                                $result .= '</ul>';
                                            endif;
                                            $result .= '</li>';
                                        endforeach;
                                        $result .= '</ul>';
                                    endif;
                                    $result .= '</li>';
                                endforeach;
                                $result .= '</ul><!-- /.sub-menu -->';
                            endif;
                            $result .= '</li>';
                        endforeach;
                        $result .= '</ul><!-- /.sub-menu -->';
                    endif;
                    $result .= '</li>';
                endforeach;
                $result .= '</ul><!-- /.menu -->';
            endif;
        endif;
        */
        return $result;
    }
    public function ListMenuCateRender(){
        return $this->ListMenuCate();
    }
    public function ListMenuCateMobile(){
        $result ="";
        $categories=Category_Theme::where('categoryIndex',1)
            ->where('status_category',0)
            ->select('categoryParent','categoryID','categorySlug','categoryName','theme_category_icon')
            ->orderBy('categoryShort','DESC')
            ->get()->toArray();
        $result .= self::showMenuMobilehtml($categories,0,0);
        return $result;
    }
    public function ListMenuCateMobileRender(){
        return $this->ListMenuCateMobile();
    }
    public function setSessionProductView($products){
       // Session::forget('product_view');
        $product_view_item=array();
        if(isset($products) && !self::objectEmpty($products)):
            $product_id=$products->id;
            if($product_id>0):
                if(Session::has('product_view')):
                    $cartQty = 1;
                    for($i=0;$i<count(Session::get('product_view'));$i++):
                        $product_view_item=Session::get('product_view');
                        if($product_view_item[$i]['id']==$product_id):
                            $product_view_item[$i]['qty'] = (int)($product_view_item[$i]['qty']+$cartQty);
                            //echo $product_view_item[$id]['qty']."<br/>";
                        else:
                            array_push($product_view_item,array(
                                "id" => $products->id,
                                "title" => $products->title,
                                "slug" => $products->slug,
                                "item_new" => $products->item_new,
                                "title_en" => $products->title_en,
                                "price_origin" => $products->price_origin,
                                "start_event" => $products->start_event,
                                "end_event" => $products->end_event,
                                "id_brand" => $products->id_brand,
                                "price_promotion" => $products->price_promotion,
                                "gallery_images" => $products->gallery_images,
                                "thubnail" => $products->thubnail,
                                "thubnail_alt" => $products->thubnail_alt,
                                "categorySlug" => $products->categorySlug,
                                "qty" => 1,
                            ));
                        endif;
                    endfor;
                    Session::put('product_view', $product_view_item);
                else:
                    $product_view_item[] = array(
                        "id" => $products->id,
                        "title" => $products->title,
                        "slug" => $products->slug,
                        "item_new" => $products->item_new,
                        "title_en" => $products->title_en,
                        "price_origin" => $products->price_origin,
                        "price_promotion" => $products->price_promotion,
                        "id_brand" => $products->id_brand,
                        "start_event" => $products->start_event,
                        "end_event" => $products->end_event,
                        "gallery_images" => $products->gallery_images,
                        "thubnail" => $products->thubnail,
                        "thubnail_alt" => $products->thubnail_alt,
                        "categorySlug" => $products->categorySlug,
                        "qty" => 1,
                    );
                    Session::put('product_view', $product_view_item);
                endif;
            endif;
        endif;
    }
    public function historyProduct($class=''){
        try {
        $result="";
        if(Session::has('product_view')):
            $color="";
            $result.='<section class="read_product_home clear">
                    <div class="clear history_container_read_product">
                        <h3 class="top_title">
                            <span>Sản phẩm đã xem</span>
                        </h3>
                        <div class="clear section_home_list sale_product_home_group">';
            $result.= '<div class="row row_list_item_product home_read_products_session flex wrap">';
            $rows=Session::get('product_view');
            //dd($rows);
            $galleries="";
            $val_td=0;
            $percent=0;
            for($km=0;$km<count($rows);$km++):
                $row=$rows[$km];
                $check_isset_product = DB::table('theme')
                    ->where('id', '=', $row['id'])
                    ->first();
                if($check_isset_product):
                $url_img="images/product";
                $note_percent="";
                $note_new_item="";
                $circle_sale='';
                $note_best_seller =''; 
                
                //id category bán chạy = 42
                $check_bestseller = DB::table('join_category_theme')
                    ->where('id_theme', '=', $row['id'])
                    ->where('id_category_theme', '=', 69)
                    ->get();
                if(count($check_bestseller)>0){
                    $note_best_seller = '<span class="label bestseller">BEST</span>';
                } else{
                    $note_best_seller = '';
                }
                $new_item = $row['item_new'];
                if($new_item == 1){
                    $note_new_item = '<span class="label new">NEW</span>';
                } else{
                    $note_new_item = '';
                }
                if(!empty($row['thubnail']) && $row['thubnail'] !=""):
                    $thumbnail= Helpers::getThumbnail($url_img,$row['thubnail'], 440, 440, "resize");
                    if(strpos($thumbnail, 'placehold') !== false):
                        $thumbnail=$url_img.$thumbnail;
                    endif;
                else:
                    $thumbnail="https://dummyimage.com/440x440/000/fff";
                endif;

                //check event discount
                $id_brand = 0;
                if(isset($row['id_brand'])){
                    $id_brand = $row['id_brand'];
                } else{
                    $id_brand = 0;
                }
                $date_now = date("Y-m-d H:i:s");
                $discount_for_brand = Discount_for_brand::where('brand_id', '=', $id_brand)
                    ->where('start_event', '<', $date_now)
                    ->where('end_event', '>', $date_now)
                    ->first();
                if($discount_for_brand){
                    $price_origin=number_format($row['price_origin'])." đ ";
                    $price_promotion= $row['price_origin'] - $row['price_origin']*$discount_for_brand->percent/100;
                    $price_promotion=number_format($price_promotion)." đ ";
                    $note_percent = '<span class="label sale">SALE</span>';
                    $circle_sale='<span class="circle-sale">
                        <span>-'.intval($discount_for_brand->percent).'%</span>
                    </span>';
                } else{
                    if(!empty($row['start_event']) && !empty($row['end_event'])){
                        $date_now = date("Y-m-d H:i:s");
                        $date_start_event = $row['start_event'];
                        $date_end_event = $row['end_event'];
                        if(strtotime($date_now) < strtotime($date_end_event) && strtotime($date_now) > strtotime($date_start_event)){
                            if(!empty($row['price_origin']) &&  $row['price_origin'] >0):
                                $price_origin=number_format($row['price_origin'])." đ ";
                            else:
                                $price_origin="";
                            endif;
                            if(!empty($row['price_promotion']) &&  $row['price_promotion'] >0):
                                $price_promotion=number_format($row['price_promotion'])." đ ";
                            else:
                                $price_promotion="Liên hệ";
                            endif;
                            
                            if(intval($row['price_promotion'])<=intval($row['price_origin']) && $row['price_promotion'] !='' && $row['price_origin'] !=''):
                                $val_td=intval($row['price_origin'])-intval($row['price_promotion']);
                                $percent=($val_td/intval($row['price_origin']))*100;
                                $note_percent = '<span class="label sale">SALE</span>';
                                $circle_sale='<span class="circle-sale">
                                    <span>-'.intval($percent).'%</span>
                                </span>';
                            else:
                                $val_td=0;
                                $percent=0;
                                $note_percent="";
                                $circle_sale='';
                            endif;
                        } else{
                            if(!empty($row['price_origin']) &&  $row['price_origin'] >0){
                                $price_origin="";
                                $price_promotion= number_format($row['price_origin']);
                            }
                        }
                    } else{
                        if(!empty($row['price_origin']) &&  $row['price_origin'] >0):
                            $price_origin=number_format($row['price_origin'])." đ ";
                        else:
                            $price_origin="";
                        endif;
                        if(!empty($row['price_promotion']) &&  $row['price_promotion'] >0):
                            $price_promotion=number_format($row['price_promotion'])." đ ";
                        else:
                            $price_promotion="Liên hệ";
                        endif;
                        
                        if(intval($row['price_promotion'])<=intval($row['price_origin']) && $row['price_promotion'] !='' && $row['price_origin'] !=''):
                            $val_td=intval($row['price_origin'])-intval($row['price_promotion']);
                            $percent=($val_td/intval($row['price_origin']))*100;
                            $note_percent = '<span class="label sale">SALE</span>';
                            $circle_sale='<span class="circle-sale">
                                    <span>-'.intval($percent).'%</span>
                                </span>';
                        else:
                            $val_td=0;
                            $percent=0;
                            $note_percent="";
                            $circle_sale='';
                        endif;
                    }
                }
                
                // $color=self::colorRender($row['id']);
                // $txt_color='';
                // $row_color =  DB::table('variable_theme')
                // ->join('theme_join_variable_theme','variable_theme.variable_themeID','=','theme_join_variable_theme.variable_themeID')
                // ->join('theme','theme_join_variable_theme.id_theme','=','theme.id')
                // ->where('theme.id',$row['id'])
                // ->where('theme.status','=',0)
                // ->groupBy('variable_theme.variable_theme_slug')
                // ->select('variable_theme.*','theme.id','theme.title','theme.title_en','theme.theme_code','theme_join_variable_theme.theme_join_variable_theme_img','theme_join_variable_theme.theme_join_variable_theme_icon')
                // ->get();
                // $count_color=0;
                // foreach($row_color as $key):
                //     $count_color++;
                // endforeach;
                // if($count_color==0){
                //   $txt_color='';
                // }elseif ($count_color<=5) {
                //   $txt_color = WebService::colorRender($row['id']);
                // }else{
                //   $txt_color = WebService::colorRender($row['id'],'',5).'<span class="more-color"><a href="'.route('tintuc.details',array($row['categorySlug'],$row['slug'])).'">more</a></span>';
                // }
                $galleries=self::variableGalleryImageRender($row['id']);
                if($galleries ==''):
                    $galleries=$thumbnail;
                endif;
                $result.= '<div class="item_product_list  product_item_list  col col-lg-5ths '.$class.'">
                    <div class="product-item">
                        <div class="item-thumb">
                            <a class="zoom effect images-rotation" href="'.route('tintuc.details',array($row['categorySlug'],$row['slug'])).'" data-default="'.$thumbnail.'" data-images="'.$galleries.'">
                                <img src="'.$thumbnail.'" alt="'.$row['thubnail_alt'].'"/>
                                <span class="productlabels_icons clear">'.$note_new_item.$note_percent.$note_best_seller.'</span>
                            </a>
                            '.$circle_sale.'
                        </div>
                        <div class="pro_info">
                            <h3 class="titleProduct">
                                <a href="'.route('tintuc.details',array($row['categorySlug'],$row['slug'])).'" >'.$row['title'].'</a>
                            </h3>
                            <div class="product_price flex">
                                <span class="price_sale">'.$price_promotion.'</span>
                                <span class="current_price">'.$price_origin.'</span>
                                
                            </div>
                        </div>

                    </div>
                </div>';
                endif;
            endfor;
            $result.= '</div>';
            $result.='</div>
                    </div><!--container-->
                </section>';
        endif;
        return $result;
        }catch (\Exception $e) {
        echo    $e->getMessage();   
        }
    }
    public function historyProductRender($class=''){
        return $this->historyProduct($class);
    }
    public function SliderVideoPage($take=10){
        $data_video = Video_page::where('video_page.status','=',0)
                ->select('video_page.*')
                ->orderBy('video_page.order','DESC')
                ->orderBy('video_page.updated_at','DESC')
                ->take($take)
                ->get();
        $result='';
        $result .= '<div class="dada-videos-list row">';
        $url_img = "/images/ytb_thumb/";
                                
        foreach ($data_video as $item) {
            $result .= '<div class="video-item col-lg-6 col-md-6 col-xs-12">
                        <a href="'.$item->url.'" data-fancybox="iframe">
                            <img src="'.$url_img.$item->thumb.'" alt="$item->title">
                        </a>
                    </div>';
        }
        $result .= '</div>';
        return $result;
    }
    public function SliderVideoPageRender($take=10){
        return $this->SliderVideoPage($take=10);
    }
    public function SliderList(){
        if(Cache::has('slider_home')){
            $json_rows = Cache::get('slider_home');
            $rows = json_decode($json_rows);
        } else{
            $rows = Slishow::where('status','=',0)->orderBy('order','DESC')->get();
            $json_rows = json_encode($rows);
            Cache::forever('slider_home', $json_rows);
        }
        $result="";
            if(count($rows)>0):
                $result .='<div class="slide-page">';
                foreach ($rows as $row){
                    $result.="";
                    if(!empty($row->link)):
                        $result.='<div class="item-slide"><a href="'.$row->link.'" target="'.$row->target.'"><img src="'.$row->src.'" alt="'.$row->name.'" alt="'.$row->name.'"/></a></div>';
                    else:
                        $result.='<div class="item-slide">
                             <img src="'.$row->src.'" alt="'.$row->name.'" class="lazy-load" />
                        </div>';
                    endif;
                }
                $result .='</div>';
            endif;  
            return $result;
    }
    public function SliderListRender(){
        return $this->SliderList();
    }
    public function ListBrand(){
        $result='';
        $data = Brand::all();
        $url_img = "/images/brand/";
        $result .= '<div class="list_brand flex wrap">';
        foreach ($data as $row){
            $result .= '<div class="brand-item">
                    <a href="'.route('brand.list',array($row->brandSlug)).'"><img src="'.$url_img.$row->brandThumb.'" alt="'.$row->brandName.'"></a>
                </div>';
        }
        $result .= '</div>';
        return $result;
    }
    public function ListBrandRender(){
        return $this->ListBrand();
    }
    public function HotDeal(){
        // Session::forget('product_view');
        $result = '';
        $hot_deal = DB::table('category_theme')
                ->join('join_category_theme','category_theme.categoryID','=','join_category_theme.id_category_theme')
                ->join('theme','join_category_theme.id_theme','=','theme.id')
                ->where('category_theme.categoryID','=', 73)
                ->where('theme.status','=',0)
                ->orderBy('theme.order_short','DESC')
                ->orderBy('theme.updated','DESC')
                ->groupBy('theme.slug')
                ->take(3)
                ->select('theme.*','category_theme.categoryName','category_theme.categorySlug','category_theme.categoryDescription','category_theme.categoryID','category_theme.categoryContent','category_theme.categoryContent_en','category_theme.categoryDescription_en')
                ->get();
        if($hot_deal):
            foreach ($hot_deal as $row) {
                //tính thời gian event
                $date_now = date("Y-m-d H:i:s");
                $date_start_event = $row->start_event;
                $date_end_event = $row->end_event;
                if(strtotime($date_now) < strtotime($date_end_event) && strtotime($date_now) > strtotime($date_start_event)){
                    $date1 = new DateTime($date_end_event);
                    $date1 = $date1->format('Y-m-d H:i:s');
                    $date2 = new DateTime($date_now);
                    $date2 = $date2->format('Y-m-d H:i:s');
                    $time_end_event = strtotime($date1) - strtotime($date2);
                    $val_td=0;
                    $percent=0;
                    $price_origin = number_format((float)$row->price_origin)." đ ";
                    $price_promotion = number_format((float)$row->price_promotion)." đ ";
                    if($row->price_promotion<=$row->price_origin):
                        $val_td=intval($row->price_origin)-intval($row->price_promotion);
                        $percent=($val_td/intval($row->price_origin))*100;
                        $save = $row->price_origin - $row->price_promotion;
                        $save = number_format($save)." đ ";
                    else:
                        $val_td=0;
                        $percent=0;
                        $save = "0 đ ";
                    endif;
                    
                    $url_img="images/product";
                    if(!empty($row->thubnail) && $row->thubnail !=""):
                        $thumbnail= Helpers::getThumbnail($url_img,$row->thubnail, 260, 260, "resize");
                        if(strpos($thumbnail, 'placehold') !== false):
                            $thumbnail=$url_img.$thumbnail;
                        endif;
                    else:
                        $thumbnail="https://dummyimage.com/260x260/000/fff";
                    endif;
                    $result .= '
                    <div class="daily-deal-item">
                        <div class="flex middle">
                                    <div class="daily-deal-thumb">
                                        <a href="'.route('tintuc.details',array($row->categorySlug,$row->slug)).'" class=""><img src="'.$thumbnail.'" alt=""></a>
                                    </div>
                                    <div class="daily-deal-info">
                                        <h2 class="daily-deal-item-title">
                                            '.$row->title.'
                                        </h2>
                                        <div class="count-down-pro">
                                            <div class="daily-timetxt">Hurry Up!</div>
                                            <div id="dailydeal-count-'.$row->id.'">
                                                
                                            </div>
                                            <div id="expired" style="display:none;">
                                                The deadline has passed.            
                                            </div>
                                            <script type="text/javascript">
                                                jQuery("#dailydeal-count-'.$row->id.'").timeTo({
                                                    seconds: '.$time_end_event.',
                                                    countdown: true,
                                                    displayDays: 2,
                                                    theme: "white",
                                                    displayCaptions: true,
                                                    fontSize: 32,
                                                    captionSize: 14,
                                                    languages: {
                                                        en: { days: "Days",   hours: "Hours",  min: "Mins",  sec: "Secs" }
                                                    },
                                                    lang: "en"
                                                });
                                            </script>
                                            <div class="cd_dld">
                                                <div class="cd_dld_detail">
                                                    <ul>
                                                        <li>
                                                            <span><i class="fa fa-check"></i>Discount</span>
                                                            <span class="cd_dld_detail_num"> - '.intval($percent).'%</span>
                                                        </li>
                                                        <li>
                                                            <span><i class="fa fa-check"></i>Tiết kiệm</span>
                                                            <span class="cd_dld_detail_num"><span class="price">'.$save.'</span></span>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="price-box">
                                            <span class="old-price">
                                                <span class="price-label">Giá Gốc:</span>
                                                <span class="price" id="old-price-'.$row->id.'">
                                                    '.$price_origin.'              
                                                </span>
                                            </span>
                                            <span class="special-price">
                                                <span class="price-label">Giá Khuyến Mãi</span>
                                                <span class="price" id="product-price-'.$row->id.'">
                                                    '.$price_promotion.'             
                                                </span>
                                            </span>
                                        </div>
                                        <div class="actions">
                                            <a href="'.route('tintuc.details',array($row->categorySlug,$row->slug)).'" class="">SHOP NOW</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    ';
                }
            }
        endif;
        return $result;
    }
    public function HotDealRender(){
        return $this->HotDeal();
    }
    public function ProductsNews($id=0,$take=8,$class=''){
        if($id>0):
            $rows =  DB::table('category_theme')
                ->join('join_category_theme','category_theme.categoryID','=','join_category_theme.id_category_theme')
                ->join('theme','join_category_theme.id_theme','=','theme.id')
                ->where('category_theme.categoryID','=',$id)
                ->where('theme.status','=',0)
                ->orderBy('theme.updated','DESC')
                ->orderBy('theme.order_short','DESC')
                ->groupBy('theme.slug')
                ->take($take)
                ->select('theme.*','category_theme.categoryName','category_theme.categorySlug','category_theme.categoryDescription','category_theme.categoryID','category_theme.categoryContent','category_theme.categoryContent_en','category_theme.categoryDescription_en')
                ->get();

        else:
            $rows =  DB::table('category_theme')
                ->join('join_category_theme','category_theme.categoryID','=','join_category_theme.id_category_theme')
                ->join('theme','join_category_theme.id_theme','=','theme.id')
                ->where('theme.status','=',0)
                ->orderBy('theme.order_short','DESC')
                ->orderBy('theme.updated','DESC')
                ->groupBy('theme.slug')
                ->take($take)
                ->select('theme.*','category_theme.categoryName','category_theme.categorySlug','category_theme.categoryDescription','category_theme.categoryID','category_theme.categoryContent','category_theme.categoryContent_en','category_theme.categoryDescription_en')
                ->get();

        endif;

        //dd($rows);
        $result="";
        if($rows):
            
            $color="";
            $val_td=0;
            $percent=0;
            $note_percent="";
            $circle_sale=''; 
            $price_promotion ="";
            //$result.= '<div class="products-grid product-grid-4 flex">';
            $result.= '<div class="products-grid product-grid-4 product_list_item_render_home '.$class.'">';
            foreach ($rows as $row){
                $url_img="images/product";
                $price_promotion ="";
                $price_origin= "";
                $note_percent="";
                $note_new_item="";
                $note_best_seller="";
                $circle_sale='';
                //id category bán chạy = 69
                $check_bestseller = DB::table('join_category_theme')
                    ->where('id_theme', '=', $row->id)
                    ->where('id_category_theme', '=', 69)
                    ->get();
                if(count($check_bestseller)>0){
                    $note_best_seller = '<span class="label bestseller">BEST</span>';
                } else{
                    $note_best_seller = '';
                }
                $new_item = $row->item_new;
                if($new_item == 1){
                    $note_new_item = '<span class="label new">NEW</span>';
                } else{
                    $note_new_item = '';
                }
                if(!empty($row->thubnail) && $row->thubnail !=""):
                    $thumbnail= Helpers::getThumbnail($url_img,$row->thubnail, 450, 450, "resize");
                    if(strpos($thumbnail, 'placehold') !== false):
                        $thumbnail=$url_img.$thumbnail;
                    endif;
                else:
                    $thumbnail="https://dummyimage.com/450x450/000/fff";
                endif;
                //$thumbnail=$url_img."/".$row->thubnail;
                
                $color=self::colorRender($row->id);
                //check event discount
                $date_now = date("Y-m-d H:i:s");
                $discount_for_brand = Discount_for_brand::where('brand_id', '=', $row->id_brand)
                    ->where('start_event', '<', $date_now)
                    ->where('end_event', '>', $date_now)
                    ->first();
                if($discount_for_brand){
                    $price_origin=number_format($row->price_origin)." đ ";
                    $price_promotion= $row->price_origin - $row->price_origin*$discount_for_brand->percent/100;
                    $price_promotion=number_format($price_promotion)." đ ";
                    $note_percent = '<span class="label sale">SALE</span>';
                    $circle_sale='<span class="circle-sale">
                        <span>-'.intval($discount_for_brand->percent).'%</span>
                    </span>';
                } else{
                    if(!empty($row->start_event) && !empty($row->end_event)){
                        $date_start_event = $row->start_event;
                        $date_end_event = $row->end_event;
                        if(strtotime($date_now) < strtotime($date_end_event) && strtotime($date_now) > strtotime($date_start_event)){
                            if(!empty($row->price_origin) &&  $row->price_origin >0):
                                $price_origin=number_format($row->price_origin)." đ ";
                            else:
                                $price_origin="";
                            endif;
                            if(!empty($row->price_promotion) &&  $row->price_promotion >0):
                                $price_promotion=number_format($row->price_promotion)." đ ";
                            else:
                                $price_promotion="Liên hệ";
                            endif;
                            
                            if(intval($row->price_promotion)<=intval($row->price_origin) && $row->price_promotion !='' && $row->price_origin !=''):
                                $val_td=intval($row->price_origin)-intval($row->price_promotion);
                                $percent=($val_td/intval($row->price_origin))*100;
                                // $note_percent="<span class='note_percent'>".intval($percent). "%</span>";
                                $note_percent = '<span class="label sale">SALE</span>';
                                $circle_sale='<span class="circle-sale">
                                    <span>-'.intval($percent).'%</span>
                                </span>';
                            else:
                                $val_td=0;
                                $percent=0;
                                $note_percent="";
                                $circle_sale='';
                            endif;
                        } else{
                            if(!empty($row->price_origin) &&  $row->price_origin >0){
                                $price_origin="";
                                $price_promotion= number_format($row->price_origin)." đ ";
                            }
                        }
                    }
                }

                // $color=self::colorRender($row->id);
                $txt_color='';
                $row_color =  DB::table('variable_theme')
                ->join('theme_join_variable_theme','variable_theme.variable_themeID','=','theme_join_variable_theme.variable_themeID')
                ->join('theme','theme_join_variable_theme.id_theme','=','theme.id')
                ->where('theme.id',$row->id)
                ->where('theme.status','=',0)
                ->groupBy('variable_theme.variable_theme_slug')
                ->select('variable_theme.*','theme.id','theme.title','theme.title_en','theme.theme_code','theme_join_variable_theme.theme_join_variable_theme_img','theme_join_variable_theme.theme_join_variable_theme_icon')
                ->get();
                $count_color=0;
                foreach($row_color as $key):
                    $count_color++;
                endforeach;
                if($count_color==0){
                  $txt_color='';
                }elseif ($count_color<=5) {
                  $txt_color = WebService::colorRender($row->id);
                }else{
                  $txt_color = WebService::colorRender($row->id,'',5).'<span class="more-color"><a href="'.route('tintuc.details',array($row->categorySlug,$row->slug)).'">more</a></span>';
                }
                $galleries=self::variableGalleryImageRender($row->id);
                if($galleries ==''):
                    $galleries=$thumbnail;
                endif;

                if($price_promotion == ''):
                    $result .= '
                        <div class="product-item col-lg-4 col-md-6 col-xs-6">
                            <div class="product_item_list clear">
                                <div class="item-thumb">
                                    <a class="effect" href="'.route('tintuc.details',array($row->categorySlug,$row->slug)).'">
                                        <img src="'.$thumbnail.'" alt="'.$row->thubnail_alt.'"/>
                                        <span class="productlabels_icons clear">'.$note_new_item.$note_percent.$note_best_seller.'</span>
                                    </a>
                                </div>
                                <div class="pro-info">
                                    <h2 class="product-name"><a href="'.route('tintuc.details',array($row->categorySlug,$row->slug)).'">'.$row->title.'</a></h2>
                                    <div class="price-box">
                                        <span class="regular-price" id="product-price-'.$row->id.'">
                                            <span class="price">'.$price_origin.'</span>                                    
                                        </span>
                                    </div>
                                    '.$txt_color.'
                                </div>
                            </div>
                        </div>';
                else:
                    $result .= '
                        <div class="product-item col-lg-4 col-md-6 col-xs-6">
                            <div class="product_item_list clear">
                                <div class="item-thumb">
                                    <a class="effect" href="'.route('tintuc.details',array($row->categorySlug,$row->slug)).'">
                                        <img src="'.$thumbnail.'" alt="'.$row->thubnail_alt.'"/>
                                        <span class="productlabels_icons clear">'.$note_new_item.$note_percent.$note_best_seller.'</span>
                                    </a>
                                </div>
                                <div class="pro-info">
                                    
                                    <h2 class="product-name"><a href="'.route('tintuc.details',array($row->categorySlug,$row->slug)).'">'.$row->title.'</a></h2>
                                    <div class="price-box">
                                        <span class="old-price">
                                            <span class="price-label">Regular Price:</span>
                                            <span class="price" id="old-price-'.$row->id.'">
                                                '.$price_origin.'               
                                            </span>
                                        </span>
                                        <span class="special-price">
                                            <span class="price-label">Special Price</span>
                                            <span class="price" id="product-price-'.$row->id.'">
                                                '.$price_promotion.'              
                                            </span>
                                        </span>
                                        '.$circle_sale.'
                                    </div>
                                    '.$txt_color.'
                                </div>
                            </div>  
                        </div>';
                endif;
            }
            $result.= '</div>';
        endif;
        return $result;
    }
    public function ProductsNewsRender($id=0,$take=8,$class=''){
        return $this->ProductsNews($id,$take,$class);
    }

    public function LoadProductsByID($array_list,$class=''){
        $arr_list = explode(', ', $array_list);
        $rows =  DB::table('category_theme')
            ->join('join_category_theme','category_theme.categoryID','=','join_category_theme.id_category_theme')
            ->join('theme','join_category_theme.id_theme','=','theme.id')
            ->whereIn('theme.id', $arr_list)
            ->orderBy('theme.order_short','DESC')
            ->orderBy('theme.updated','DESC')
            ->groupBy('theme.slug')
            ->select('theme.*','category_theme.categoryName','category_theme.categorySlug','category_theme.categoryDescription','category_theme.categoryID','category_theme.categoryContent','category_theme.categoryContent_en','category_theme.categoryDescription_en')
            ->get();

        $result="";
        if($rows):
            $color="";
            $val_td=0;
            $percent=0;
            $note_percent="";
            $circle_sale=''; 
            $price_promotion ="";
            //$result.= '<div class="products-grid product-grid-4 flex">';
            $result.= '<div class="products-grid product-grid-4 product_list_item_render_home '.$class.'">';
            foreach ($rows as $row){
                $url_img="images/product";
                $note_percent="";
                $note_new_item="";
                $note_best_seller="";
                $circle_sale='';
                //id category bán chạy = 69
                $check_bestseller = DB::table('join_category_theme')
                    ->where('id_theme', '=', $row->id)
                    ->where('id_category_theme', '=', 69)
                    ->get();
                if(count($check_bestseller)>0){
                    $note_best_seller = '<span class="label bestseller">BEST</span>';
                } else{
                    $note_best_seller = '';
                }
                $new_item = $row->item_new;
                if($new_item == 1){
                    $note_new_item = '<span class="label new">NEW</span>';
                } else{
                    $note_new_item = '';
                }
                if(!empty($row->thubnail) && $row->thubnail !=""):
                    $thumbnail= Helpers::getThumbnail($url_img,$row->thubnail, 450, 450, "resize");
                    if(strpos($thumbnail, 'placehold') !== false):
                        $thumbnail=$url_img.$thumbnail;
                    endif;
                else:
                    $thumbnail="https://dummyimage.com/450x450/000/fff";
                endif;
                //$thumbnail=$url_img."/".$row->thubnail;

                $color=self::colorRender($row->id);


                //check event discount
                $date_now = date("Y-m-d H:i:s");
                $discount_for_brand = Discount_for_brand::where('brand_id', '=', $row->id_brand)
                    ->where('start_event', '<', $date_now)
                    ->where('end_event', '>', $date_now)
                    ->first();
                if($discount_for_brand){
                    $price_origin=number_format($row->price_origin)." đ ";
                    $price_promotion= $row->price_origin - $row->price_origin*$discount_for_brand->percent/100;
                    $price_promotion=number_format($price_promotion)." đ ";
                    $note_percent = '<span class="label sale">SALE</span>';
                    $circle_sale='<span class="circle-sale">
                        <span>-'.intval($discount_for_brand->percent).'%</span>
                    </span>';
                } else{
                    if(!empty($row->start_event) && !empty($row->end_event)){
                        $date_start_event = $row->start_event;
                        $date_end_event = $row->end_event;
                        if(strtotime($date_now) < strtotime($date_end_event) && strtotime($date_now) > strtotime($date_start_event)){
                            if(!empty($row->price_origin) &&  $row->price_origin >0):
                                $price_origin=number_format($row->price_origin)." đ ";
                            else:
                                $price_origin="";
                            endif;
                            if(!empty($row->price_promotion) &&  $row->price_promotion >0):
                                $price_promotion=number_format($row->price_promotion)." đ ";
                            else:
                                $price_promotion="Liên hệ";
                            endif;
                            
                            if(intval($row->price_promotion)<=intval($row->price_origin) && $row->price_promotion !='' && $row->price_origin !=''):
                                $val_td=intval($row->price_origin)-intval($row->price_promotion);
                                $percent=($val_td/intval($row->price_origin))*100;
                                // $note_percent="<span class='note_percent'>".intval($percent). "%</span>";
                                $note_percent = '<span class="label sale">SALE</span>';
                                $circle_sale='<span class="circle-sale">
                                    <span>-'.intval($percent).'%</span>
                                </span>';
                            else:
                                $val_td=0;
                                $percent=0;
                                $note_percent="";
                                $circle_sale='';
                            endif;
                        } else{
                            if(!empty($row->price_origin) &&  $row->price_origin >0){
                                $price_origin="";
                                $price_promotion= number_format($row->price_origin)." đ ";
                            }
                        }
                    }
                }

                // $color=self::colorRender($row->id);
                $txt_color='';
                $row_color =  DB::table('variable_theme')
                ->join('theme_join_variable_theme','variable_theme.variable_themeID','=','theme_join_variable_theme.variable_themeID')
                ->join('theme','theme_join_variable_theme.id_theme','=','theme.id')
                ->where('theme.id',$row->id)
                ->where('theme.status','=',0)
                ->groupBy('variable_theme.variable_theme_slug')
                ->select('variable_theme.*','theme.id','theme.title','theme.title_en','theme.theme_code','theme_join_variable_theme.theme_join_variable_theme_img','theme_join_variable_theme.theme_join_variable_theme_icon')
                ->get();
                $count_color=0;
                foreach($row_color as $key):
                    $count_color++;
                endforeach;
                if($count_color==0){
                  $txt_color='';
                }elseif ($count_color<=5) {
                  $txt_color = WebService::colorRender($row->id);
                }else{
                  $txt_color = WebService::colorRender($row->id,'',5).'<span class="more-color"><a href="'.route('tintuc.details',array($row->categorySlug,$row->slug)).'">more</a></span>';
                }
                $galleries=self::variableGalleryImageRender($row->id);
                if($galleries ==''):
                    $galleries=$thumbnail;
                endif;

                if($price_promotion == ''):
                    $result .= '
                        <div class="product-item col-lg-4 col-md-6 col-xs-6">
                            <div class="product_item_list clear">
                                <div class="item-thumb">
                                    <a class="effect" href="'.route('tintuc.details',array($row->categorySlug,$row->slug)).'">
                                        <img src="'.$thumbnail.'" alt="'.$row->thubnail_alt.'"/>
                                        <span class="productlabels_icons clear">'.$note_new_item.$note_percent.$note_best_seller.'</span>
                                    </a>
                                </div>
                                <div class="pro-info">
                                    <h2 class="product-name"><a href="'.route('tintuc.details',array($row->categorySlug,$row->slug)).'">'.$row->title.'</a></h2>
                                    <div class="price-box">
                                        <span class="regular-price" id="product-price-'.$row->id.'">
                                            <span class="price">'.$price_origin.'</span>                                    
                                        </span>
                                    </div>
                                    '.$txt_color.'
                                </div>
                            </div>
                        </div>';
                else:
                    $result .= '
                        <div class="product-item col-lg-4 col-md-6 col-xs-6">
                            <div class="product_item_list clear">
                                <div class="item-thumb">
                                    <a class="effect" href="'.route('tintuc.details',array($row->categorySlug,$row->slug)).'">
                                        <img src="'.$thumbnail.'" alt="'.$row->thubnail_alt.'"/>
                                        <span class="productlabels_icons clear">'.$note_new_item.$note_percent.$note_best_seller.'</span>
                                    </a>
                                </div>
                                <div class="pro-info">
                                    
                                    <h2 class="product-name"><a href="'.route('tintuc.details',array($row->categorySlug,$row->slug)).'">'.$row->title.'</a></h2>
                                    <div class="price-box">
                                        <span class="old-price">
                                            <span class="price-label">Regular Price:</span>
                                            <span class="price" id="old-price-'.$row->id.'">
                                                '.$price_origin.'               
                                            </span>
                                        </span>
                                        <span class="special-price">
                                            <span class="price-label">Special Price</span>
                                            <span class="price" id="product-price-'.$row->id.'">
                                                '.$price_promotion.'              
                                            </span>
                                        </span>
                                        '.$circle_sale.'
                                    </div>
                                    '.$txt_color.'
                                </div>
                            </div>  
                        </div>';
                endif;
            }
            $result.= '</div>';
        endif;
        return $result;
    }
    public function LoadProductsByIDRender($id=0,$class=''){
        return $this->LoadProductsByID($id,$class);
    }

    public function ProductsNewsAMP($id=0,$take=6,$class=''){
        if($id>0):
            $rows =  DB::table('category_theme')
                ->join('join_category_theme','category_theme.categoryID','=','join_category_theme.id_category_theme')
                ->join('theme','join_category_theme.id_theme','=','theme.id')
                ->where('category_theme.categoryID','=',$id)
                ->where('theme.status','=',0)
                ->orderBy('theme.order_short','DESC')
                ->groupBy('theme.slug')
                ->take($take)
                ->select('theme.*','category_theme.categoryName','category_theme.categorySlug','category_theme.categoryDescription','category_theme.categoryID','category_theme.categoryContent','category_theme.categoryContent_en','category_theme.categoryDescription_en')
                ->get();
        else:
            $rows =  DB::table('category_theme')
                ->join('join_category_theme','category_theme.categoryID','=','join_category_theme.id_category_theme')
                ->join('theme','join_category_theme.id_theme','=','theme.id')
                ->where('theme.status','=',0)
                ->orderBy('theme.order_short','DESC')
                ->groupBy('theme.slug')
                ->take($take)
                ->select('theme.*','category_theme.categoryName','category_theme.categorySlug','category_theme.categoryDescription','category_theme.categoryID','category_theme.categoryContent','category_theme.categoryContent_en','category_theme.categoryDescription_en')
                ->get();
        endif;

        //dd($rows);
        $result="";
        if($rows):
            $color="";
            $result.= '<div class="row row_list_item_product home_slider_products flex wrap">';
            $width=0;
            $height=0;
            foreach ($rows as $row){
                $width=0;
                $height=0;
                $url_img="images/product";

                if(!empty($row->thubnail) && $row->thubnail !=""):
                    $thumbnail= Helpers::getThumbnail($url_img,$row->thubnail, 508, 600, "resize");
                    if(strpos($thumbnail, 'placehold') !== false):
                        $thumbnail=$url_img.$thumbnail;
                    endif;
                else:
                    $thumbnail="https://dummyimage.com/508x600/000/fff";
                endif;
                list($width, $height, $type, $attr) = @getimagesize($thumbnail);
                //$thumbnail=$url_img."/".$row->thubnail;
                if(!empty($row->price_origin) &&  $row->price_origin >0):
                    $price_origin=number_format($row->price_origin)." đ ";
                else:
                    $price_origin="";
                endif;
                if(!empty($row->price_promotion) &&  $row->price_promotion >0):
                    $price_promotion=number_format($row->price_promotion)." đ ";
                else:
                    $price_promotion="Liên hệ";
                endif;
                $color=self::colorRender($row->id);
                $color="";

                $result.= '<div class="item_product_list col-lg-6 col-md-6 col-sm-6 col-xs-6 '.$class.'">
                    <div class="product-item">
                        <div class="item-thumb">
                            <a class="zoom effect images-rotation" href="'.route('amp.tintuc.details',array($row->categorySlug,$row->slug)).'">
                                <amp-img src="'.$thumbnail.'" alt="'.$row->thubnail_alt.'" width="508" height="600" layout="responsive"></amp-img>
                            </a>
                        </div>
                        <div class="pro_info">
                            <h3 class="titleProduct">
                                <a href="'.route('amp.tintuc.details',array($row->categorySlug,$row->slug)).'" >'.$row->title.'</a>
                            </h3>
                            <div class="product_price flex">
                                <span class="price_sale">'.$price_promotion.'</span>
                                <span class="current_price">'.$price_origin.'</span>
                            </div>
                            '.$color.'
                        </div>

                    </div>
                </div>';
            }
            $result.= '</div>';
        endif;
        return $result;
    }
    public function ProductsNewsAMPRender($id=0,$take=6,$class=''){
        return $this->ProductsNewsAMP($id,$take,$class);
    }

    public function variableSingleProductImage($id,$class=''){
        $result="";
        $rows =  DB::table('theme_variable_sku')
            ->where('id_theme',$id)
            ->groupBy('thumbnail')
            ->select('theme_variable_sku.*')
            ->get();
            //dd($rows);
        if($rows):
            $result=$rows;
        endif;
        return $result;
    }
     
    public function variableColorProduct($id_product=0,$id_vaColor=0,$class=''){
        $result="";
        $rows =  DB::table('variable_theme')
            ->join('theme_join_variable_theme','variable_theme.variable_themeID','=','theme_join_variable_theme.variable_themeID')
            ->join('theme','theme_join_variable_theme.id_theme','=','theme.id')
            ->where('theme.id',$id_product)
            ->where('variable_theme.variable_theme_parent',$id_vaColor)
            ->where('theme.status','=',0)
            ->orderBy('updated','DESC')
            ->groupBy('variable_theme.variable_theme_slug')
            ->select('variable_theme.*')
            ->get();
        if(count($rows)>0):
            $result .='<ul class="list_variable_item '.$class.'">';
            foreach ($rows as $row){
                $result .='<li class="item item_'.$row->variable_theme_slug.'"><span>'.$row->variable_theme_name.'</span></li>';
            }
            $result .='</ul>';
        endif;
        return $result;
    }
    public function variableColorProductRender($id_product=0,$id_color=0,$class=''){
        return $this->variableColorProduct($id_product,$id_color,$class);
    }
    public function SliderListAMP($rows){
        $result="";
        //dd($rows);
        foreach ($rows as $row){
            $result.="";
            $link_images=($row->src_mobile !='')?$row->src_mobile : $row->src;
            if(!empty($row->link)):
                $result.='<a href="'.$row->link.'" target="'.$row->target.'">
                    <amp-img layout="responsive" src="'.url('/').$link_images.'" alt="'.$row->name.'" width="767" height="350" class="lazy-load"/>
                </a>';
            else:
                $result.='<amp-img layout="responsive" width="767" height="350"  src="'.url('/').$link_images.'" alt="'.$row->name.'" class="lazy-load"></amp-img>';
            endif;
        }
        return $result;
    }
    public function SliderListRenderAMP(){
        return $this->SliderListAMP(Slishow::where('status','=',0)->orderBy('order','DESC')->get());
    }
    public function ListHomeNewList($take=4,$class=''){
        $result="";
        $rows=Post::where('post.status','=',0)
            ->join('join_category_post','post.id','=','join_category_post.id_post')
            ->join('category','join_category_post.id_category','=','category.categoryID')
            ->select('post.title','post.slug','post.thubnail','post.thubnail_alt','post.title_en','post.description','post.content','category.categoryName','category.categorySlug')
            ->orderBy('post.order_short','DESC')
            ->orderBy('post.updated','DESC')
            ->take($take)
            ->get();
        $m=0;
        if($rows):
            $result .='<div class="list-banner-category row item_post_new_home">';
            $result_child="";
            $description_child="";
            $url_img="images/article";
            foreach($rows as $row):
                $m++;
                $thumbnail_lag="";
                if(!empty($row->thubnail) && $row->thubnail !=""):
                    $thumbnail_lag= Helpers::getThumbnail($url_img,$row->thubnail, 640, 590, "resize");
                    if(strpos($thumbnail_lag, 'placehold') !== false):
                       $thumbnail_lag=$url_img.$thumbnail_lag;
                    endif; 
                else:
                    $thumbnail_lag="https://dummyimage.com/640x590/000/fff";
                endif;
                $result .='<div class="category-banner-item col-lg-3 col-md-3 col-xs-6">
                            <figure class="thumbnail_service clear">
                                <a href="'.route('tintuc.details',array($row->categorySlug,$row->slug)).'" class="effect">
                                    <img src="'.$thumbnail_lag.'" alt="'.$row->thubnail_alt.'"/>
                                </a>    
                            </figure>
                            <h4 class="title">
                                <a href="'.route('tintuc.details',array($row->categorySlug,$row->slug)).'">
                                    '.$row->title.'
                                </a>
                            </h4>
                        </div><!--category-banner-item-->';
            endforeach;
            $result .='</div>';
        endif;
        return $result;
    }
    public function ListHomeNewListRender($take=5,$class=''){
        return $this->ListHomeNewList($take,$class);
    }

    public function ListHomeNewListAMP($take=4,$class=''){
        $result="";
        $rows=Post::where('post.status','=',0)
            ->join('join_category_post','post.id','=','join_category_post.id_post')
            ->join('category','join_category_post.id_category','=','category.categoryID')
            ->select('post.title','post.slug','post.thubnail','post.thubnail_alt','post.title_en','post.description','post.content','category.categoryName','category.categorySlug')
            ->orderBy('post.updated','DESC')
            ->take($take)
            ->get();
        $m=0;
        if($rows):
            $result .='<div class="row row_item_news">';
            $result_child="";
            $description_child="";
            $url_img="images/article";
            $width=0;
            $height=0;
            $width1=0;
            $height1=0;
            foreach($rows as $row):
                $width=0;
                $height=0;
                $width1=0;
                $height1=0;
                $m++;
                if($m==1):
                    $thumbnail_lag="";
                    if(!empty($row->thubnail) && $row->thubnail !=""):
                        $thumbnail_lag= Helpers::getThumbnail($url_img,$row->thubnail, 400, 250, "resize");
                        if(strpos($thumbnail_lag, 'placehold') !== false):
                            $thumbnail_lag=$url_img.$thumbnail_lag;
                        endif;
                    else:
                        $thumbnail_lag="https://dummyimage.com/400x250/000/fff";
                    endif;
                    list($width, $height, $type, $attr) = @getimagesize($thumbnail_lag);
                    if($width >0):
                        $width=400;
                    endif;
                    if($height >0):
                        $height=250;
                    endif;
                    $result .='<div class="col-lg-12 col-md-12 col-xs-12 col-new_item col-lag-new_index">
                                   <div class="featured_img clear">
                                        <figure class="photo" role="image">
                                           <a class="zoom" href="'.route('amp.tintuc.details',array($row->categorySlug,$row->slug)).'">
                                                <amp-img src="'.$thumbnail_lag.'" alt="'.$row->thubnail_alt.'" width="'.$width.'" height="'.$height.'" layout="responsive"></amp-img>
                                           </a>
                                       </figure>
                                   </div> <!--featured_img-->
                                    <div class="asolus_title">
                                         <h2><a href="'.route('amp.category.list',array($row->categorySlug)).'" target="_top">'.$row->categoryName.'</a></h2>
                                         <h3><a href="'.route('amp.tintuc.details',array($row->categorySlug,$row->slug)).'">'.$row->title.'</a></h3>
                                    </div><!--asolus_title-->
                              </div><!--col-new_item-->';
                endif;
                if($m>1):
                    $description_child="";
                    $thumbnail_sm="";
                    if($row->description !=''):
                        $description_child=htmlspecialchars_decode($row->description);
                    else:
                        $description_child=htmlspecialchars_decode($row->content);
                    endif;
                    if(!empty($row->thubnail) && $row->thubnail !=""):
                        $thumbnail_sm= Helpers::getThumbnail($url_img,$row->thubnail,400, 250, "resize");
                        if(strpos($thumbnail_sm, 'placehold') !== false):
                            $thumbnail_sm=$url_img.$thumbnail_sm;
                        endif;
                    else:
                        $thumbnail_sm="https://dummyimage.com/400x250/000/fff";
                    endif;
                    list($width1, $height1, $type, $attr) = @getimagesize($thumbnail_sm);
                    if($width1 >0):
                        $width1=400;
                    endif;
                    if($height1 >0):
                        $height1=250;
                    endif;
                    $result_child .='
                    <div class="box_news clear">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-xs-6 img_field">
                                <div class="featured_img clear">
                                    <figure class="photo" role="image">
                                        <a class="zoom" href="'.route('amp.tintuc.details',array($row->categorySlug,$row->slug)).'">
                                            <amp-img src="'.$thumbnail_sm.'" alt="'.$row->thubnail_alt.'" width="'.$width1.'" height="'.$height1.'" layout="responsive"></amp-img>
                                        </a>
                                    </figure>
                                </div> <!--featured_img-->
                            </div><!--img_field-->
                            <div class="col-lg-8 col-md-6 col-xs-6 content_box">
                                   <h3><a href="'.route('amp.tintuc.details',array($row->categorySlug,$row->slug)).'">'.$row->title.'</a> </h3>
                                   <div class="short_excerpt clear">'.self::excerpts($description_child,150).'</div>
                                   <span class="viewmore clear"><a rel="nofollow" href="'.route('amp.tintuc.details',array($row->categorySlug,$row->slug)).'">Xem thêm...</a></span>
                            </div><!--content_box-->
                        </div>
                    </div><!--box_news-->';
                endif;
            endforeach;
            $result .='<div class="col-lg-12 col-md-12 col-xs-12 col-new_item col-medium-new_inde">
                            <div class="group_list_item_news clear">'.$result_child.'</div><!--group_list_item_news-->
                       </div><!--col-new_item-->';
            $result .='</div>';
        endif;
        return $result;
    }
    public function ListHomeNewListAMPRender($take=5,$class=''){
        return $this->ListHomeNewListAMP($take,$class);
    }

    public function ListSidebarNew($id,$title='',$take=6,$class=''){
        if($id !=""):
            $rows =  Post::where('post.status','=',0)
                ->join('join_category_post','post.id','=','join_category_post.id_post')
                ->join('category','join_category_post.id_category','=','category.categoryID')
                ->where('post.gallery_checked','=',1)
                ->select('post.title','post.slug','post.thubnail','post.thubnail_alt','category.categorySlug')
                ->orderBy('post.updated','DESC')
                ->take($take)
                ->get();
        else:
            $rows =  Post::where('post.status','=',0)
                ->join('join_category_post','post.id','=','join_category_post.id_post')
                ->join('category','join_category_post.id_category','=','category.categoryID')
                ->select('post.title','post.slug','post.thubnail','post.thubnail_alt','category.categorySlug')
                ->orderBy('post.updated','DESC')
                ->take($take)
                ->get();
        endif;
        $result="";
        if(count($rows)>0):
            $result="<div class='item_sidebar_post clear'>
            <div class='title_sidebar clear'>
                     <div class='fl title'>".$title."</div>
                     <div class='fr righthl'></div>
                </div>
            <ul class='$class clear list_post_category_sidebar'>";
            $url_img="img/uploads/";
            $thumbnail="";
            $url_var="";
            $result_filename="";
            foreach ($rows as $row){
                $result.="<li>";
                $href=route('tintuc.details',array($row->categorySlug,$row->slug));
                if(!empty($row->thubnail) && $row->thubnail !=""):

                    $url_var = explode('/' , $row->thubnail);
                    $result_filename = end($url_var);
                    $thumbnail= Helpers::getThumbnail($result_filename, 300, 220, "resize");
                    if(strpos($thumbnail, 'placehold') !== false):
                        $thumbnail=$url_img.$result_filename;
                    endif;
                else:
                    $thumbnail="https://dummyimage.com/300x220/000/fff";
                endif;
                $result.='<div class="clear item">
                        <a class="thumbnail_sidebar" href="'.$href.'"><img src ="'.$thumbnail.'" alt="'.$row->thubnail_alt.'"/></a>
                        <a class="title_post" href="'.$href.'"><h5>'.$row->title.'</h5></a>
                    </div>';
                $result.="</li>";
            }
            $result.="</ul></div>";
        endif;

        return $result;
    }
    public function ListSidebarNewRender($id='',$title='',$take=6,$class=''){
        return $this->ListSidebarNew($id,$title,$take,$class);
    }

    /* OLD
    public function variableSingleProductID($id,$class='',$combo=''){
        $result="";
        $rows =  DB::table('variable_theme')
            ->join('theme_join_variable_theme','variable_theme.variable_themeID','=','theme_join_variable_theme.variable_themeID')
            ->join('theme','theme_join_variable_theme.id_theme','=','theme.id')
            ->where('theme.id',$id)
            ->where('theme.status','=',0)
            ->orderBy('updated','DESC')
            ->groupBy('variable_theme.variable_theme_slug')
            ->select('variable_theme.*','theme.id','theme.title','theme.title_en','theme.theme_code','theme_join_variable_theme.theme_join_variable_theme_icon')
            ->get();
        $rows = collect($rows)->map(function($x){ return (array) $x; })->toArray();
        $variableGroup = self::fitter_variable_theme_group_by("variable_theme_parent", $rows);
        //dd($variableGroup);
        $description="";
        $slug_key="";
        $title_key="";
        $background_img="";
        if(count($variableGroup)>0):
            $result .='<div class="ariable_detail_product_container clear">';
            if($combo != ''){
                $product=DB::table('theme')
                    ->where('theme.id', '=', $id)
                    ->select('theme.title')
                    ->first();
                $result .= '<div class="title-it-combo">Item '.$class.': '.$product->title.'</div>';
            }
            foreach($variableGroup as $key => $values):
                $title_key =self::variablegetNamebyID($key);
                $slug_key=self::variablegeSlugbyID($key);

                $result .='<div class="variable_option variable_option_'.$class.' clear">
                        <div class="custom_title_detail"><h6>'.$title_key.'</h6></div>';
                    if(count($values)>0):
                        //if($slug_key == 'color'){
                            $result .='<ul class="choose_variable choose_'.$slug_key.' clear">';
                            $count_variable_id = 0;
                            foreach($values as $value):
                                if($count_variable_id == 0):
                                    $first_variable = $value['variable_themeID'];
                                    $count_variable_id++;
                                endif;
                                if($value['theme_join_variable_theme_icon'] !=''):
                                    $background_img='style="background: url(/images/product/'.$value['theme_join_variable_theme_icon'].'); background-position: center center;background-size: cover;"';
                                else:
                                    $background_img ='';
                                endif;
                                $result .='<li class="choose_variable-item_li '.$slug_key.'-item">
                                    <label class="lb_size_gs">
                                       <input required class="radio_variabe" data-parent-id="'.$id.'" data-parent-slug="'.$slug_key.'" data-parent-name="'.$title_key.'" name="variabe-item_'.$id.'_'.$key.'" value="'.$value['variable_theme_slug'].'" date-title="'.$value['variable_theme_name'].'" variableID="'.$value['variable_themeID'].'" type="radio">
                                           <span class="variabe_list_choise '.$slug_key.'_list">
                                                 <span class="name_'.$slug_key.' option_'.strtolower($value['variable_theme_slug']).'" '.$background_img.'>'.$value['variable_theme_name'].'</span>
                                           </span>
                                       </label>
                                    </li>';
                            endforeach;
                            $result .= '<script>
                                        $(".variable_option_'.$class.' input[type=radio]").change(function() {
                                            var arr = {};
                                            var arr_item_var = {};
                                            var arr_slug = [];
                                            var isset_it = 0;
                                            var color_name = "";
                                            var count_array = array_checked.length;
                                            $(".variable_option_'.$class.' input[type=radio]").each(function () {
                                                for (var i = array_checked.length - 1; i >= 0; i--) {
                                                    if(array_checked[i]['.$id.']){
                                                        if( $(this).is(":checked") ) {
                                                            arr_item_var[$(this).attr("data-parent-slug")] = $(this).attr("date-title");
                                                            arr_slug.push(arr_item_var);
                                                            array_checked[i]['.$id.'] = arr_slug;
                                                            color_name = $(this).attr("date-title");
                                                            isset_it = 1;
                                                        }
                                                    }
                                                }
                                                if( $(this).is(":checked") && isset_it == 0) {
                                                    arr_item_var[$(this).attr("data-parent-slug")] = $(this).attr("date-title");
                                                    arr_slug.push(arr_item_var);
                                                    arr[$(this).attr("data-parent-id")] = arr_slug;
                                                    color_name = $(this).attr("date-title");
                                                    array_checked.push(arr);
                                                }
                                            });
//                                            $("p.color_variable_name_'.$class.'").html("*Lựa chọn: "+color_name);
                                            $("a#btn_cart_primary").attr("data-option",JSON.stringify(array_checked));
                                        });
                                        $(".variable_option_'.$class.' input[type=radio]").click(function() {
                                            var arr = {};
                                            var arr_item_var = {};
                                            var arr_slug = [];
                                            var isset_it = 0;
                                            var color_name = "";
                                            var count_array = array_checked.length;
                                            $(".variable_option_'.$class.' input[type=radio]").each(function () {
                                                for (var i = array_checked.length - 1; i >= 0; i--) {
                                                    if(array_checked[i]['.$id.']){
                                                        if( $(this).is(":checked") ) {
                                                            arr_item_var[$(this).attr("data-parent-slug")] = $(this).attr("date-title");
                                                            arr_slug.push(arr_item_var);
                                                            array_checked[i]['.$id.'] = arr_slug;
                                                            color_name = $(this).attr("date-title");
                                                            isset_it = 1;
                                                        }
                                                    }
                                                }
                                                if( $(this).is(":checked") && isset_it == 0) {
                                                    arr_item_var[$(this).attr("data-parent-slug")] = $(this).attr("date-title");
                                                    arr_slug.push(arr_item_var);
                                                    arr[$(this).attr("data-parent-id")] = arr_slug;
                                                    color_name = $(this).attr("date-title");
                                                    array_checked.push(arr);
                                                }
                                            });
                                            
//                                            $("p.color_variable_name_'.$class.'").html("*Lựa chọn: "+color_name);
                                            $("a#btn_cart_primary").attr("data-option",JSON.stringify(array_checked));
                                        });
                                        setTimeout(function(){ $("input[variableID=\''.$first_variable.'\']").trigger("click"); }, 1500);
                                    </script>';
                        //}
                        $result .='</ul>';
                    endif;
                $result .='</div>';
            endforeach;
            $result .='</div>';
        else:
            $result .= '<script>
                var arr = {};
                arr["variable"] = "none";
                array_checked.push(arr);
                $("a#btn_cart_primary").attr("data-option",JSON.stringify(array_checked));
            </script>';
        endif;
        return $result;
    }
    public function variableProductIDSingleRender($id='',$class=''){
        return $this->variableSingleProductID($id,$class);
    }
    END */
    public function variableSingleProductID($id,$class='',$combo=''){
        $result="";
        $slug_key="";
        $title_key="";
        $background_img="";
        $id_parrent_variable=0;
        $array_variable_parrent_current=array();
        $variable_parents_selecteds=Theme_variable_sku_value::where ('id_theme',$id)
            ->groupBy('variable_themeID')
            ->select('variable_parentID')
            ->distinct()
            ->get();
        if($variable_parents_selecteds):
            //dd($variable_parents_selecteds);
            $result .='<div class="ariable_detail_product_container clear">';
            if($combo != ''){
                $product=DB::table('theme')
                    ->where('theme.id', '=', $id)
                    ->select('theme.title')
                    ->first();
                if($product):
                    $result .= '<div class="title-it-combo">Item '.$class.': '.$product->title.'</div>';
                endif;
            }
            foreach ($variable_parents_selecteds as $variable_parents_selected):
                $id_parrent_variable=(int)$variable_parents_selected->variable_parentID;
                $array_variable_parrent_current[]=$id_parrent_variable;

                if($id_parrent_variable>0):
                    $title_key =self::variablegetNamebyID($id_parrent_variable);
                    $slug_key=self::variablegeSlugbyID($id_parrent_variable);
                    $result .='<div class="variable_option variable_option_'.$class.' clear">
                                    <div class="custom_title_detail">
                                        <h6>'.$title_key.'</h6>
                                        <input type="hidden" id="parent_key_'.$slug_key.'" value="'.$id_parrent_variable.'"/>
                                    </div>';
                    $variable_child_selecteds=Theme_variable_sku_value::where('variable_parentID',$id_parrent_variable)
                        ->where('id_theme',$id)
                        ->groupBy('variable_themeID')
                        ->select('variable_themeID')
                        ->distinct()
                        ->get();
                        $id_child_variable=0;
                        $slug_child_key="";
                        $title_child_key="";
                        if($variable_child_selecteds):
                            $result .='<ul class="choose_variable choose_'.$slug_key.' clear">';
                            $count_variable_id = 0;
                            $first_variable = '';
                            foreach ($variable_child_selecteds as $variable_child_selected):
                                $id_child_variable=$variable_child_selected->variable_themeID;
                                if($count_variable_id == 0):
                                    $first_variable = $id_child_variable;
                                    $count_variable_id++;
                                endif;
                                $title_child_key =self::variablegetNamebyID($id_child_variable);
                                $slug_child_key=self::variablegeSlugbyID($id_child_variable);
                                $result .='<li class="choose_variable-item_li '.$slug_key.'-item">
                                    <label class="lb_size_gs">
                                       <input required class="radio_variabe" data-parent-id="'.$id_parrent_variable.'" data-parent-slug="'.$slug_key.'" data-parent-name="'.$title_key.'" name="variabe-item_'.$id.'_'.$id_parrent_variable.'" value="'.$slug_child_key.'" date-title="'.$title_child_key.'" variableID="'.$id_child_variable.'" type="radio">
                                           <span class="variabe_list_choise '.$slug_key.'_list">
                                                 <span class="name_'.$slug_key.' option_'.strtolower($slug_child_key).'">'.$title_child_key.'</span>
                                           </span>
                                       </label>
                                    </li>';
                            endforeach;
                            $result .= '<script type="text/javascript">setTimeout(function(){ $("input[variableID=\''.$first_variable.'\']").trigger("click"); }, 1500);</script>';
                            $result .='</ul>';
                        endif;
                    $result .='</div>';
                 endif;
            endforeach;
            $result .=self::generate_variable_product_field($array_variable_parrent_current,$id);
            $result .='</div>';
        endif;
        return $result;
    }
    public function variableProductIDSingleRender($id='',$class=''){
        return $this->variableSingleProductID($id,$class);
    }
    public function generate_variable_product_field($array_variable_parrent_current=array(),$id_product=0){
        $result="";
        $child_parent=array();
        $slug_variable_parrent="";
        $group_child=array();
        $html_col_header="";
        $datas = $array_variable_parrent_current;
        $id_key_parent="";
        $count_item=count($datas);
        if($datas && count($datas)>0):
            $mh=0;
            for($i=0; $i<count($datas); $i++):
                $mh++;
                $variable_child="";
                $key_child="";
                $array_child=array();
                $variable_id=(int)$datas[$i];
                if($variable_id>0):
                    $variables=Variable_Theme::where('variable_themeID',$variable_id)
                        ->where('variable_theme_status',0)
                        ->first();
                    if($variables):
                        $slug_variable_parrent=$variables->variable_theme_slug;
                        $variable_childs=Variable_Theme::where('variable_theme_parent',$variable_id)
                            ->where('variable_theme_status',0)
                            ->get();
                        if($variable_childs):
                            $html_col_header .='<div class="table-cell readonly">'.$variables->variable_theme_name.'</div>';
                            $id_key_parent .=$variables->variable_themeID.",";
                            foreach ($variable_childs as $variable_child):
                                $key_child=$variable_child->variable_theme_slug;
                                //$array_key[$key_child]=array($variable_child->variable_theme_name);
                                $array_child[$key_child]=$variable_child->variable_theme_name."_".$variable_child->variable_themeID;
                                $group_child=$array_child;
                            endforeach;
                        endif;
                    endif;
                endif;
                $child_parent[$slug_variable_parrent] =$group_child;
            endfor;
            $array_fitters=Helpers::variations($child_parent);
            if($array_fitters && count($array_fitters)>0):
                $id_key_parent=substr($id_key_parent, 0, -1);
                //print_r($array_fitters);
                $result .='<div class="variation-table-value hidden">';
                $explode_ex=array();
                for($m=0;$m<count($array_fitters);$m++):
                    $result .='<div class="table-row">';
                    $k=0;
                    $group_string_variable="";
                    $group_string_jquery="";
                    foreach ($array_fitters[$m] as $key => $value):
                        $k++;
                        $explode_ex = explode("_", $value);
                        $group_string_variable .=$explode_ex[1].",";
                        $group_string_jquery .=$explode_ex[1]."_";
                        //$result .='<div class="table-cell readonly">'.$explode_ex[0].'</div><input type="hidden" name="variable_'.$m.$k.'" value="'.$explode_ex[1].'">';
                    endforeach;
                    $group_string_variable=substr($group_string_variable,0,-1);
                    $group_string_jquery=substr($group_string_jquery,0,-1);
                    $thumbnail_value="";
                    $price_value="";
                    if(Helpers::query_value_variable($id_product,$group_string_variable)):
                        $thumbnail_value=Helpers::query_value_variable($id_product,$group_string_variable)->thumbnail;
                        $price_value=(int)Helpers::query_value_variable($id_product,$group_string_variable)->price;
                    endif;
                    $result .='<input type="hidden" id="price_variable_query_'.$group_string_jquery.'" value="'.$price_value.'"/>
                    <input type="hidden" id="thumbnail_variable_query_'.$group_string_jquery.'" value="'.$thumbnail_value.'"/></div>';
                endfor;
                $result .='</div>';
            else:
                $result ="";
            endif;
        else:
            $result ="";
        endif;
        return $result;
    }
    public function variableColorProductID($id,$class='',$count=''){
        $result="";
        $rows =  DB::table('variable_theme')
            ->join('theme_join_variable_theme','variable_theme.variable_themeID','=','theme_join_variable_theme.variable_themeID')
            ->join('theme','theme_join_variable_theme.id_theme','=','theme.id')
            ->where('theme.id',$id)
            ->where('theme.status','=',0)
            ->orderBy('updated','DESC')
            ->groupBy('variable_theme.variable_theme_slug')
            ->select('variable_theme.*','theme.id','theme.title','theme.title_en','theme.theme_code','theme_join_variable_theme.theme_join_variable_theme_img','theme_join_variable_theme.theme_join_variable_theme_icon')
            ->get();
        $rows = collect($rows)->map(function($x){ return (array) $x; })->toArray();
        $variableGroup = self::fitter_variable_theme_group_by("variable_theme_parent", $rows);
        //dd($variableGroup);
        $description="";
        $slug_key="";
        $title_key="";
        $background_img="";
        //$images_variable="";
        if($count != ''){
            $count_variable = $count;
        } else{
            $count_variable = -1;
        }
        $k = 0;
        $img_path=asset('images/product');
        if(count($variableGroup)>0):
            foreach($variableGroup as $key => $values):
                $title_key =self::variablegetNamebyID($key);
                $slug_key=self::variablegeSlugbyID($key);
                $result .='<div class="color_by_product_id flex middle variable_option clear">';
                    if(count($values)>0):
                        //dd($values);
                        if($slug_key == 'color'){
                            
                            $result .='<ul class="choose_variable choose_'.$slug_key.' clear">';
                            foreach($values as $value):
                                if($k == $count_variable){
                                    break;
                                }
                                if($value['theme_join_variable_theme_icon'] !=''):
                                    $background_img='style="background: url(/images/product/'.$value['theme_join_variable_theme_icon'].'); background-position: center center;background-size: cover;"';
                                else:
                                        $background_img ='';
                                endif;
                                if(!empty($value['theme_join_variable_theme_img']) && $value['theme_join_variable_theme_img'] !=''):
                                    /*$images_variable .='<img id="images_variable_'.$value['variable_themeID'].'" src="'.$img_path."/".$value['theme_join_variable_theme_img'].'" alt="'.$value['variable_theme_name'].'"/>';*/
                                    $result .='<li class="choose_variable-item_li '.$slug_key.'-item" id="variable_theme_'.$value['variable_themeID'].'" attrId="'.$value['variable_themeID'].'">
                                    <img class="hidden" id="images_variable_'.$value['variable_themeID'].'" src="'.$img_path."/".$value['theme_join_variable_theme_img'].'" alt="'.$value['variable_theme_name'].'"/>
                                    <span class="variabe_list_choise '.$slug_key.'_list">
                                        <span class="item_name_color_set name_'.$slug_key.' option_'.strtolower($value['variable_theme_slug']).'" '.$background_img.'></span>
                                    </span>
                                 </li>';
                                else:
                                     $result .='<li class="choose_variable-item_li '.$slug_key.'-item" id="variable_theme_'.$value['variable_themeID'].'" attrId="'.$value['variable_themeID'].'">
                                    <span class="variabe_list_choise '.$slug_key.'_list">
                                        <span class="item_name_color_set name_'.$slug_key.' option_'.strtolower($value['variable_theme_slug']).'" '.$background_img.'></span>
                                    </span>
                                    </li>'; 
                                endif;
                                $k++;
                            endforeach;
                        }
                        
                        $result .='</ul>';
                    endif;
                $result .='</div>';
            endforeach;
        endif;
        return $result;
    }
    public function colorRender($id='',$class='', $count= ''){
        return $this->variableColorProductID($id,$class,$count);
    }
    
    public function variableColorImageGallerybyProduct($id){
        $result="";
        $rows =  DB::table('variable_theme')
            ->join('theme_join_variable_theme','variable_theme.variable_themeID','=','theme_join_variable_theme.variable_themeID')
            ->join('theme','theme_join_variable_theme.id_theme','=','theme.id')
            ->where('theme.id',$id)
            ->where('theme.status','=',0)
            ->orderBy('updated','DESC')
            ->groupBy('variable_theme.variable_theme_slug')
            ->select('variable_theme.*','theme.id','theme.title','theme.title_en','theme.theme_code','theme_join_variable_theme.theme_join_variable_theme_img')
            ->get();
        $rows = collect($rows)->map(function($x){ return (array) $x; })->toArray();
        $variableGroup = self::fitter_variable_theme_group_by("variable_theme_parent", $rows);
        //dd($variableGroup);
        $description="";
        $slug_key="";
        $title_key="";
        $images_variable="";
        $img_path=asset('images/product');
        if(count($variableGroup)>0):
            foreach($variableGroup as $key => $values):
                $title_key =self::variablegetNamebyID($key);
                $slug_key=self::variablegeSlugbyID($key);
                    if(count($values)>0):
                        if($slug_key == 'color'){
                            foreach($values as $value):
                                if(!empty($value['theme_join_variable_theme_img']) && $value['theme_join_variable_theme_img'] !=''):
                                    //$images_variable .="'".$img_path."/".$value['theme_join_variable_theme_img']."',";
                                    if($images_variable ==""):
                                        $images_variable=$img_path."/".$value['theme_join_variable_theme_img'];
                                    endif;
                                endif;  
                            endforeach;
                        }
                    endif;
            endforeach;
        endif;
        //return substr($images_variable, 0, -1);
        return $images_variable;
    }
    public function variableGalleryImageRender($id=''){
        return $this->variableColorImageGallerybyProduct($id);
    }
    
    function variablegetNamebyID($id) {
        $name="";
        $variable=Variable_Theme::where('variable_themeID',$id)->first();
        $name=$variable->variable_theme_name;
        return $name;
    }
    function variablegeSlugbyID($id) {
        $name="";
        $variable=Variable_Theme::where('variable_themeID',$id)->first();
        $name=$variable->variable_theme_slug;
        return $name;
    }
    
    public function getOptionProvinceUserData($pro_id){
        $province = Province::orderBy('name', 'ASC')->get();
        $result = '';
        foreach ($province as $row){
            if($row->name == $pro_id){
                $result .= '<option value="'.$row->name.'" selected>'.$row->name.'</option>';
            } else{
                $result .= '<option value="'.$row->name.'">'.$row->name.'</option>';
            }
        }
        return $result;
    }
    public function getOptionProvinceUserDataRender($pro_id)
    {
        return $this->getOptionProvinceUserData($pro_id);
    }

    public function getOptionDistrictUserData($pro_id, $distric_id){
        $province = Province::where('name', '=', $pro_id)->first();
        $result = '';
        if($province){
            $district = District::orderBy('name', 'ASC')->where('provinceid', '=', $province->provinceid)->get();
            foreach ($district as $row){
                if($row->name == $distric_id){
                    $result .= '<option value="'.$row->name.'" selected>'.$row->name.'</option>';
                } else{
                    $result .= '<option value="'.$row->name.'">'.$row->name.'</option>';
                }
            }
        }
        return $result;
    }
    public function getOptionDistrictUserDataRender($pro_id, $distric_id)
    {
        return $this->getOptionDistrictUserData($pro_id, $distric_id);
    }

    public function getOptionWardUserData($distric_id, $ward_id){
        $district = District::where('name', '=', $distric_id)->first();
        $result = '';
        if($district){
            $ward = Ward::orderBy('name', 'ASC')->where('districtid', '=', $district->districtid)->get();
            foreach ($ward as $row){
                if($row->name == $ward_id){
                    $result .= '<option value="'.$row->name.'" selected>'.$row->name.'</option>';
                } else{
                    $result .= '<option value="'.$row->name.'">'.$row->name.'</option>';
                }
            }
        }
        return $result;
    }
    public function getOptionWardUserDataRender($distric_id, $ward_id)
    {
        return $this->getOptionWardUserData($distric_id, $ward_id);
    }
    public function update_post_hit($id){
        $data_posts=DB::table('post')
            ->where('post.id','=',$id)
            ->select('post.hit')
            ->first();

        if($data_posts):
            $hit=(int)$data_posts->hit;
            $hit_update=$hit+1;
            $datas_box=array
            (
                "hit" => $hit_update
            );
            $respons =Post::where ("id","=",$id)->update($datas_box);
        endif;
        return true;
    }
    function fitter_variable_theme_group_by($key, $data) {
        $result = array();
        foreach($data as $val) {
            if(array_key_exists($key, $val)){
                $result[$val[$key]][] = $val;
            }else{
                $result[""][] = $val;
            }
        }
        return $result;
    }
    public static function formatMoney12($number, $fractional=false) {
        if ($fractional) {
            $number = sprintf('%.2f', $number);
        }
        while (true) {
            $replaced = preg_replace('/(-?\d+)(\d\d\d)/', '$1,$2', $number);
            if ($replaced != $number) {
                $number = $replaced;
            } else {
                break;
            }
        }
        return $number;
    }
    public static function format_price($price){
        $price_format=number_format($price, 0, ',', '.');
        return $price_format;
    }
    function objectToArray($o)
    {
        $a = array();
        foreach ($o as $k => $v)
            $a[$k] = (is_array($v) || is_object($v)) ? objectToArray($v): $v;
        return $a;
    }
    function time_request($time)
    {
        $date_current = date('Y-m-d H:i:s');
        $s = strtotime($date_current) - strtotime($time);
        if ($s <= 60) { // if < 60 seconds
            return 'Khoảng 1 phút trước';
        }else
        {
            $t = intval($s / 60);
            if ($t >= 60) {
                $t = intval($t / 60);
                if ($t >= 24) {
                    $t = intval($t / 24);
                    if ($t >= 30) {
                        $t = intval($t / 30);
                        if ($t >= 12) {
                            $t = intval($t / 12);
                            return "Khoảng ".$t . ' năm trước';
                        } else {
                            return "Khoảng ".$t . ' tháng trước';
                        }
                    } else {
                        return "Khoảng ".$t.' ngày trước';
                    }
                } else {
                    return "Khoảng ".$t.' giờ trước';
                }
            } else {
                return "Khoảng ".$t.' phút trước';
            }
        }
    }
    public static function getParentCategory($menus,$id_parent,&$html='')
    {
        $menu_tmp = array();
        $attr="";
        foreach ($menus as $key => $item) {
            if ((int) $item['categoryID'] == (int) $id_parent) {
                $menu_tmp[] = $item;
                unset($menus[$key]);
            }
            if($item['categoryParent']==0):
                $attr=' class="cate_post_clear"';
            else:
                $attr="";
            endif;
        }

        if (!empty($menu_tmp))
        {
            $html .= "<span".$attr.">";
            asort($menu_tmp);
            foreach ($menu_tmp as $item)
            {
                if($item['categoryParent']>=0):
                    $html .= " &#62; <a target='_blank' class='menu_parent_back' href='".route('category.list',$item['categorySlug'])."'>".htmlspecialchars_decode($item['theme_category_icon']).$item['categoryName']."</a> ";
                endif;
                self::getParentCategory($menus,$item['categoryParent'],$html);
            }
            $html .= "</span>";
        }
        //dd($html);
        return $html;
    }
    public static function showMenuhtml($menus,$menu_current,$id_parent = 0,&$html='',&$i=0)
    {
        $menu_tmp = array();
        $attr="";
        foreach ($menus as $key => $item) {
            if ((int) $item['categoryParent'] == (int) $id_parent) {
                $menu_tmp[] = $item;
                unset($menus[$key]);
            }
        }
        //dd($menu_tmp);
        if (!empty($menu_tmp))
        {
            if($i==0):
                $attr=' id="category_products_menu_static" itemscope="itemscope" itemtype="http://schema.org/SiteNavigationElement" class="main-menu category_menu_product_home_read  middle"';
                $html .= "<ul".$attr.">";
            else:
                $attr=' class="sub-menu"';
                $html .= "<ul".$attr.">";
            endif;
            $icon_wap="";
            foreach ($menu_tmp as $item)
            {
                $i++;
                if($item['theme_category_icon'] !=""):
                    $icon_wap="<span class=\"icon-wrap\">".htmlspecialchars_decode($item['theme_category_icon'])."</span>";
                endif;
                if($menu_current==$item['categoryID']):
                    $html .= "<li class='active category_menu_list'><a href='".route('category.list',$item['categorySlug'])."'>".$icon_wap."<span class='text'>".$item['categoryName']."</span></a>";
                else:
                    $html .= "<li class='category_menu_list'><a href='".route('category.list',$item['categorySlug'])."'>".$icon_wap."<span class='text'>".$item['categoryName']."</span></a>";
                endif;
                self::showMenuhtml($menus,$menu_current, $item['categoryID'],$html,$i);
                $html .= "</li>";
            }
            $html .= "</ul>";
        }
        //dd($html);
        return $html;
    }

    public static function showMenuMobilehtml($menus,$menu_current,$id_parent = 0,&$html='',&$i=0)
    {
        $menu_tmp = array();
        $attr="";
        foreach ($menus as $key => $item) {
            if ((int) $item['categoryParent'] == (int) $id_parent) {
                $menu_tmp[] = $item;
                unset($menus[$key]);
            }
        }
        //dd($menu_tmp);
        if (!empty($menu_tmp))
        {
            if($i==0):
                $attr=' id="category_products_menu_static_mobile" itemscope="itemscope" itemtype="http://schema.org/SiteNavigationElement" class="main-menu category_menu_product_home_read_moblie  middle"';
                $html .= "<ul".$attr.">";
                $html .= "<li class='item category_menu_list='>
                    <a href='".route('cua-hang')."'><span class='icon-wrap'><i class='fa fa-cubes'></i></span><span class='text'>Tất cả sản phẩm</span></a>
                </li>";
            else:
                $attr=' class="sub-menu"';
                $html .= "<ul".$attr.">";
            endif;
            
            $icon_wap="";
            foreach ($menu_tmp as $item)
            {
                $i++;
                if($item['theme_category_icon'] !=""):
                    $icon_wap="<span class=\"icon-wrap\">".htmlspecialchars_decode($item['theme_category_icon'])."</span>";
                endif;
                if($menu_current==$item['categoryID']):
                    $html .= "<li class='active category_menu_list'><a href='".route('category.list',$item['categorySlug'])."'>".$icon_wap."<span class='text'>".$item['categoryName']."</span></a>";
                else:
                    $html .= "<li class='category_menu_list'><a href='".route('category.list',$item['categorySlug'])."'>".$icon_wap."<span class='text'>".$item['categoryName']."</span></a>";
                endif;
                self::showMenuMobilehtml($menus,$menu_current, $item['categoryID'],$html,$i);
                $html .= "</li>";
            }
            $html .= "</ul>";
        }
        //dd($html);
        return $html;
    }

    public static function showMutiCategory($menus,$array_current,$id_parent = 0,&$html='',&$i=0)
    {
        $menu_tmp = array();
        $attr="";
        foreach ($menus as $key => $item) {
            if ((int) $item['categoryParent'] == (int) $id_parent) {
                $menu_tmp[] = $item;
                unset($menus[$key]);
            }
        }
        //dd($menu_tmp);
        if (!empty($menu_tmp))
        {
            if($i==0):
                $attr=' id="muti_menu_post" class="muti_menu_right_category"';
                $html .= "<ul".$attr.">";
            else:
                $attr=' class="sub-menu"';
                $html .= "<ul".$attr.">";
            endif;
            foreach ($menu_tmp as $item)
            {
                $i++;
                if(in_array($item['categoryID'], $array_current)):
                    $html .= "<li class='active category_menu_list'>
                                <label for='checkbox_cmc_".$item['categoryID']."'>
                                <input type='checkbox' class='category_item_input' name='category_item[]' value='".$item['categoryID']."' id='checkbox_cmc_".$item['categoryID']."' checked>".$item['categoryName']."</label>";
                else:
                    $html .= "<li class='category_menu_list'>
                                <label for='checkbox_cmc_".$item['categoryID']."'>
                                <input type='checkbox' class='category_item_input' name='category_item[]' value='".$item['categoryID']."' id='checkbox_cmc_".$item['categoryID']."'>".$item['categoryName']."</label>";
                endif;
                self::showMutiCategory($menus,$array_current, $item['categoryID'],$html,$i);
                $html .= "</li>";
            }
            $html .= "</ul>";
        }
        //dd($html);
        return $html;
    }

    public static function showOptionCategory($menus,$menu_current,$id_parent = 0,$text="&nbsp;")
    {
        $menu_tmp = array();
        foreach ($menus as $key => $item) {
            if ((int) $item['categoryParent'] == (int) $id_parent) {
                $menu_tmp[] = $item;
                unset($menus[$key]);
            }
        }
        if (!empty($menu_tmp))
        {
            foreach ($menu_tmp as $item)
            {
                if($menu_current==$item['categoryID']):
                    echo '<option selected="selected" value="'.$item['categoryID'].'">';
                else:
                    echo '<option value="'.$item['categoryID'].'">';
                endif;
                echo $text.$item['categoryName'];
                echo '</option>';
                self::showOptionCategory($menus,$menu_current, $item['categoryID'],$text."&nbsp;&nbsp;");
            }
        }
    }

    public function isHome(){
        if(Route::getCurrentRoute()->uri() == '/' || Route::getCurrentRoute()->uri() == 'home') {
            return true;
        }else{
            return false;
        }
    }

    function showMenuCategory($menus,$menu_current,$id_parent = 0,$text="&nbsp;")
    {
       // dd($menus);
        // Biến lưu menu lặp ở bước đệ quy này
        $menu_tmp = array();
        foreach ($menus as $key => $item) {
            // Nếu có parent_id bằng với parrent id hiện tại
            if ((int) $item['parent_id'] == (int) $id_parent) {
                $menu_tmp[] = $item;
                unset($menus[$key]);
            }
        }
        // Điều kiện dừng của đệ quy là cho tới khi menu không còn nữa
        if (!empty($menu_tmp))
        {
            foreach ($menu_tmp as $item)
            {
                if(!empty($menu_current)):
                    if(in_array($item['id'],$menu_current)):
                        echo '<option selected="selected" class="item_level_'.$item['categories_level'].'" value="'.$item['id'].'">';
                        echo $text.$item['name'];
                        echo '</option>';
                    else:
                        echo '<option class="item_level_'.$item['categories_level'].'" value="'.$item['id'].'">';
                        echo $text.$item['name'];
                        echo '</option>';
                    endif;
                //endfor;
                else:
                    echo '<option class="item_level_'.$item['categories_level'].'" value="'.$item['id'].'">';
                    echo $text.$item['name'];
                    echo '</option>';
                endif;
                // Truyền vào danh sách menu chưa lặp và id parent của menu hiện tại
                self::showMenuCategory($menus,$menu_current, $item['id'],$text.$text);

            }

        }
    }


    public function has_children($rows, $id) {
        foreach ($rows as $row) {
            if ($row['parent_id'] == $id)
                return true;
        }
        return false;
    }

    public function tree_option($rows, $parent = 0,$spe = "",$selected = -1){
        $result = "";

        if(count($rows) > 0) {
            foreach ($rows as $key => $val){
                if($val['parent_id'] == $parent){
                    $att_selected = ($val['id'] == $selected) ? "selected" : "";

                    if($parent == 0)
                        $result .= "<option $att_selected value='$val->id'>$val->name</option>";
                    else
                        $result .= "<option $att_selected value='$val->id'>$spe$val->name</option>";
                    unset($rows[$key]);
                    if ($this->has_children($rows, $val['id'])){
                        $spe .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" ;
                        $result .= $this->tree_option($rows,$val['id'],$spe,$selected);
                    }


                }//end if
            }//end for
        }
        return $result;

    }

    public function get_template_page($slug){
        $content="";
        $page=Page::where('slug',$slug)
            ->where('status',0)
            ->first();
        if(isset($page) && $page):
            $content=htmlspecialchars_decode($page->content);
        else:
            $content="";
        endif;
        return $content;
    }
    public function get_child_category_product($id_parent=0,$count=0){
        $data_customers=DB::table('category_theme')
            ->join('join_category_theme','category_theme.categoryID','=','join_category_theme.id_category_theme')
            ->join('theme','join_category_theme.id_theme','=','theme.id')
            ->where('category_theme.categoryParent','=',$id_parent)
            ->where('theme.status','=',0)
            ->groupBy('theme.id')
            ->orderBy(\DB::raw('count(theme.id)'), 'DESC')
            ->select(DB::raw('DISTINCT category_theme.categorySlug'),'category_theme.categoryName','category_theme.categoryDescription','category_theme.categoryID')
            ->offset(0)
            ->limit($count)
            ->get();
        if($data_customers):
            return $data_customers;
         else:
            return NULL;
         endif;
    }
    public function get_brand_by_productID($id_brand=0){
        $brands=Brand::where('brandID',$id_brand)->first();
        if($brands):
           return  $brands;
        else:
            return NULL;
        endif;
    }
    public function get_category_news(){
        $categorys=Category::where('status_category','=',0)
            ->where('categoryIndex','=',1)
            ->orderBy('categoryShort', 'ASC')
            ->get();
        if(count($categorys)):
            return $categorys;
        endif;
    }
    public function get_category_theme(){
        $categorys=Category_Theme::where('status_category','=',0)
            ->where('categoryIndex','=',1)
            ->orderBy('categoryShort', 'ASC')
            ->get();
        //dd($categorys);
        if(count($categorys)):
            return $categorys;
        endif;
    }
    public function load_service_home(){
        $take=(int)Helpers::get_option_minhnn('item-service-home-selection');
        $id=Helpers::get_option_minhnn('service-home');
        $getPosts=Post::where('post.status','=',0)
            ->join('join_category_post','post.id','=','join_category_post.id_post')
            ->join('category','join_category_post.id_category','=','category.categoryID')
            ->whereIn('category.categoryID',explode(",", $id))
            ->select('post.title','post.slug','post.thubnail','post.thubnail_alt','category.categorySlug','category.categoryID')
            ->orderBy('post.created','DESC')
            ->take($take)
            ->get();
        if(count($getPosts)):
            return $getPosts;
        endif;
    }
    public function get_wishlist_productID($id_product){
        $check_wishlist = Wishlist::where('id_product' , '=' , $id_product)
            ->count();
        return $check_wishlist;
    }
    public function tree_option_data($data,$fied="title",$id=0){
       if(count($data)>0):
            $result="";
            for($i=0;$i<count($data);$i++):
                $att_selected = ($data[$i]['id'] == $id) ? "selected" : "";
                $result.="<option $att_selected value='".$data[$i]['id']."'>".$data[$i][$fied]."</option>";
            endfor;
            return $result;
        else:
            return;
        endif;
    }


    public static function objectEmpty($o)
    {
        if (empty($o)) return true;
        else if (is_numeric($o)) return false;
        else if (is_string($o)) return !strlen(trim($o));
        else if (is_object($o)) return self::objectEmpty((array)$o);
        // It's an array!
        foreach($o as $element)
            if (self::objectEmpty($element)) continue; // so far so good.
            else return false;

        // all good.
        return true;
    }
    public function excerpts ($str,$length=200, $trailing='..')
    {
        $str=str_replace("  "," ",$str);
        if(!empty($str)):
            $str=strip_tags($str);
        endif;
        $str=strip_tags($str);
        $length-=mb_strlen($trailing);
        if(mb_strlen($str)> $length):
            return mb_strimwidth($str,0,$length,$trailing,'utf-8');
        else:
            $str=str_replace("  "," ",$str);
            $res = $str;
        endif;
        return $res;
    }
}//end class
