<?php

namespace App\Libraries;

use Illuminate\Support\Str;
use App\Model\Setting;
use Response, Request, DB, Session, URL, Route, Auth, Cache, Config, Illuminate\Pagination\LengthAwarePaginator, Input, Carbon\Carbon;
use App\Model\Post;
use App\Model\Variable_Theme;
use App\Model\Theme;
use App\Model\Category;
use App\Model\Theme_variable_sku_value;
use App\Model\Theme_variable_sku;

class Helpers
{
    public static function arrayPaginator($array, $request)
    {
        $page = $request->get('page', 1);
        $perPage = config('app.item_list_category_product');
        $offset = ($page * $perPage) - $perPage;
        $url = str_replace(\Request::getRequestUri(), '', URL::current());
        return new LengthAwarePaginator(array_slice($array, $offset, $perPage, true), count($array), $perPage, $page,
            ['path' => URL::current(), 'query' => $request->query()]);
    }
    
    public static function query_value_variable($id_product,$string_id_variables=''){
        if($string_id_variables!=''):
            $string_id_variables_ex=explode(",",$string_id_variables);
            $count_string_id=count($string_id_variables_ex);
            $query_variable_skus=array();
            if(count($string_id_variables_ex)>1):
                $first_count_string_id=$count_string_id-1;
                $query_variable_skus=DB::select("SELECT theme_variable_sku_id, COUNT(*) count_item FROM theme_variable_sku_value
                    WHERE variable_themeID IN (".$string_id_variables.") AND id_theme = ".$id_product."
                    GROUP BY
                        theme_variable_sku_id
                    HAVING COUNT(*) > ".$first_count_string_id);
            else:
                $string_id_variables=(int)$string_id_variables;
                $query_variable_skus=DB::select("SELECT theme_variable_sku_id, COUNT(*) count_item FROM theme_variable_sku_value
                    WHERE variable_themeID =".$string_id_variables." AND id_theme = ".$id_product."
                    GROUP BY
                        theme_variable_sku_id");
            endif;
            if($query_variable_skus):
                $theme_variable_sku_id=$query_variable_skus[0]->theme_variable_sku_id;
                if($theme_variable_sku_id>0):
                    $query_variables=Theme_variable_sku::where('id',$theme_variable_sku_id)
                        ->first();
                    if($query_variables):
                        return $query_variables;
                    endif;
                endif;
            endif;
        endif;
    }
    public static function get_product_by_id($sid){
        $products=Theme::where('id', '=', $sid)->first();
        return $products;
    }
    public static function check_product_variable($sid){
        $check_products=Theme_variable_sku::where('id_theme', '=', $sid)->first();
        return $check_products;
    }
    public static function get_title_variable_theme_by_id($sid){
        $variables=Variable_Theme::where('variable_themeID', '=', $sid)->first();
        if($variables):
            return $variables->variable_theme_name;
        else:
            return null;
        endif;
    }
    
    public static function get_permalink_by_id($sid){
        $products=DB::table('category_theme')
            ->join('join_category_theme','category_theme.categoryID','=','join_category_theme.id_category_theme')
            ->join('theme','join_category_theme.id_theme','=','theme.id')
            ->where('theme.id',$sid)
            ->first();
        $link="";
        if($products):
            $slug_product=$products->slug;
            $slug_category=$products->categorySlug;
            $link=route('tintuc.details',array($slug_category,$slug_product));
        else:
            $link="";
        endif;
        return $link;
    }
    public static function shout(string $string)
    {
        return strtoupper($string);
    }
    public static function auto_code(){
        $strtime_conver=strtotime(date('d-m-Y H:i:s'));
        $strtime=substr($strtime_conver,-4);
        $rand=substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 4);
        $string_rand="anhduong-".$strtime.$rand;
        return $string_rand;
    }
    public static function auto_code_discount(){
        $rand1=substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 4);
        $rand2=substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 4);
        $rand3=substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 4);
        $rand4=substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 4);
        $string_rand=strtoupper($rand1.'-'.$rand2.'-'.$rand3.'-'.$rand4);
        return $string_rand;
    }
    public function url_admin($admin='adminwp',$string='update',$param='',$id=0){
        $url=Request::root()."/".$admin;
        if(!empty($string)) $url .="/".$string;
        if(!empty($param)) $url .="/".$param;
        if($id>0) $url.="/".$id;

        return $url;
    }
    public function create_crbox($box_id, $array, $type="checkbox", $checked="", $style="")
    {
        if(!$box_id || !$array)     error_msg("box_id or array empty", 2);
        $return_value = "";
        $i = 0;
        foreach($array as $key => $value){
            if($type == "checkbox"){

                if( is_array($checked) ){
                    if( in_array($key, $checked) )  $equals = "checked='checked'";
                    else                            $equals = "";
                }else{
                    if( ($checked != "") && ($checked == $key) )    $equals = "checked='checked'";
                    else                                            $equals = "";
                }
                $return_value .= "<input type='checkbox' name='{$box_id}{$i}' id='{$box_id}{$i}' value='{$key}' {$equals} {$style}/> {$value}&nbsp;";
            }else{
                $equals = ($checked == $key) ? "checked='checked'" : "";

                $return_value .= "<input type='radio' name='{$box_id}' id='{$box_id}{$i}' value='{$key}' {$equals} {$style}/> {$value}&nbsp;";
            }
            $i++;
        }
        return $return_value;
    }
    public function Create_Selectbox($box_name, $array, $selected="", $opt="", $opt_first="Y")
    {
        $option = "";
        if($opt_first == "Y")   $option = "<option value=''>--Option--</option>";
        foreach($array as $key => $value){
            $SELECTED = ($selected == $key) ? "selected" : "";
            $option .= "<option value='{$key}' {$SELECTED}>{$value}</option>";
        }
        $selectbox = "<select name='{$box_name}' id='{$box_name}' {$opt}>{$option}</select>";
        return $selectbox;
    }
    public static function msg_move_page($msg,$url="back",$isExit=1){
        if($msg) echo "<script language='javascript'>alert('".$msg."');</script>";
        if($url){
            switch($url){
                case "home" :
                    echo "<script>location.href='/'</script>";
                    break;
                case "back" :
                    echo "<script language='javascript'>history.go(-1);</script>";
                    break;
                case "close" :
                    echo "<script language='javascript'>self.close();</script>";
                    break;
                case "reload" :
                    echo "<script language='javascript'>document.location.reload();</script>";
                    break;
                case "top_opener_reload" :
                    echo "<script language='javascript'>top.opener.document.location.reload();</script>";
                    break;
                case "top_url" :
                    echo "<Script language='javascript'>top.document.location.href = '".$url."'</script>";
                    break;
                case "parent_reload" :
                    echo "<script language='javascript'>parent.document.location.reload();</Script>";
                    break;
                case "not":
                    echo "<script language='javascript'>alert('".$msg."');</script>";
                    break;
                default :
                    echo "<script language='javascript'>document.location.replace('".$url."');</script>";
                    break;
            }
        }
        if($isExit) exit();
    }

    //Refresh url
    function move_page($url){
        echo"<meta http-equiv=\"refresh\" content=\"0; url=$url\">";
        exit;
    }
    public static function check_active_menu_amin($first,$end){
        if(strpos($first, $end)!== false && $first==$end):
            $class="active";
        else:
            $class="";
        endif;
        echo $class;
       // exit();
    }
    public static function check_active_menu_amin_group($first,$find_letters){
        $flag = false;
        foreach ($find_letters as $letter)
        {
            if (strpos($first, $letter) !== false && $first==$letter)
            {
                $flag = true;
            }
        }
        if($flag):
            $class="collapse in";
        else:
            $class="collapse";
        endif;
        echo $class;
    }
    public static function check_active_menu_amin_group_class($first,$find_letters){
        $flag = false;
        foreach ($find_letters as $letter)
        {
            if (strpos($first, $letter) !== false)
            {
                $flag = true;
            }
        }
        if($flag):
            $class="active";
        else:
            $class="";
        endif;
        echo $class;
    }

    public static function GetCurlUrlJson($url) {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_TIMEOUT => 30000,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                // Set Here Your Requesred Headers
                'Content-Type: application/json',
            ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            return json_decode($response);
        }
    }
    public static function convert_date($date,$format='Y.m.d'){
        $newDate = date($format, strtotime($date));
        $newDate =substr($newDate,2);
        return $newDate;
    }

    public static function formatMoney($number, $fractional=false) {
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

    public static function check_dupcontent_post($slug){
        $count=Post::where('slug','=',$slug)->count();
        //dd($count);
        return $count;
    }
    public static function update_Post_Date($slug,$order){
        $fields_post = array(
            'order_short'=>$order,
            'updated'=>Carbon::now()->format('Y-m-d H:i:s')
        );
        $respons =Post::where ("slug","=",$slug)->update($fields_post);
        return true;
    }
    public static function get_option_minhnn($variable){
        if (Cache::has('theme_option')) {
            $List = Cache::get('theme_option');
        } else{
            $List = Setting::orderBy('updated', 'desc')->first();
            Cache::forever('theme_option', $List);
        }
        if($List):
            $array_option_autos=unserialize($List['value_setting']);
            $str="";
            if( !empty($array_option_autos)):
                $count= count( $array_option_autos);
                for( $i = 0; $i < $count; $i++ ):
                    $label_text =($array_option_autos[$i]['group_tdr']['tdr_name'] != '' ) ? $array_option_autos[$i]['group_tdr']['tdr_name'] : '';
                    $option_value=($array_option_autos[$i]['group_tdr']['tdr_value'] != '' ) ? $array_option_autos[$i]['group_tdr']['tdr_value'] : '';
                    if($label_text==$variable):
                        $str=stripslashes(stripslashes(base64_decode($option_value)));
                    endif;
                endfor;
            endif;
            return $str;
            //echo $array_option_autos[$variable];
        endif;
    }

    public static function loadPostGallery(){
        $slishows=Post::where('post.status','=',0)
            ->join('join_category_post','post.id','=','join_category_post.id_post')
            ->join('category','join_category_post.id_category','=','category.categoryID')
            ->where('post.gallery_checked','=',1)
            ->select('post.title','post.slug','post.thubnail','post.thubnail_alt','post.gallery_images','post.description','category.categorySlug','category.categoryID')
            ->orderBy('post.created','DESC')
            ->first();
        if(isset($slishows) && count($slishows)>0):
            return view('layouts.gallery_post_home')->with('slishows',$slishows)->render();
        endif;
        //return view('layouts.gallery_post_home')->with('slishows',$slishows)->render();
    }
    public static function loadPostGalleryAMP(){
        $slishows=Post::where('post.status','=',0)
            ->join('join_category_post','post.id','=','join_category_post.id_post')
            ->join('category','join_category_post.id_category','=','category.categoryID')
            ->where('post.gallery_checked','=',1)
            ->select('post.title','post.slug','post.thubnail','post.thubnail_alt','post.gallery_images','post.description','category.categorySlug','category.categoryID')
            ->orderBy('post.created','DESC')
            ->first();
        if(isset($slishows) && count($slishows)>0):
            return view('layouts_amp.gallery_post_home')->with('slishows',$slishows)->render();
        endif;
        //return view('layouts.gallery_post_home')->with('slishows',$slishows)->render();
    }
    public static function getThumbnail($path,$img_path, $width, $height, $type = "fit")
    {
        return app('App\Http\Controllers\ImageController')->getImageThumbnail($path,$img_path, $width, $height, $type);
    }
    /*
    public static function Badges_User($badges_user_id){
        //$users_level=\auth()->user()->levelID;
        $levels=CategoryBadge::where('id','=',$badges_user_id)->first();
        return $levels;
    }
    */
    /*Convert Append Array*/
    public static function variations( $array ){
        if( empty( $array ) ) return [];
        function traverse( $array, $parent_ind ){
            $r = [];
            $pr = '';
            //dd($parent_ind);
            if( !is_numeric($parent_ind) )
                $pr = $parent_ind . '-';
            foreach( $array as $ind=>$el ) {
                if ( is_array( $el ) ) {
                    //dd($ind);
                    $r = array_merge( $r, traverse( $el, $pr . ( is_numeric( $ind ) ? '' : $ind ) ) );
                }else
                    //dd($ind);
                    if ( is_numeric( $ind ) )
                        $r[] = $pr . $el;
                    else
                        $r[] = $pr . $ind . '-' . $el;
            }
            return $r;
        }
        //1. Go through entire array and transform elements that are arrays into elements, collect keys
        $keys = [];$size = 1;
        foreach( $array as $key=>$elems ) {
            if ( is_array( $elems ) ) {
                $rr = [];
                foreach ( $elems as $ind=>$elem ) {
                    if ( is_array( $elem ) )
                        $rr = array_merge( $rr, traverse( $elem, $ind ) );
                    else $rr[] = $elem;
                }
                $array[ $key ] = $rr;
                $size *= count( $rr );
            }
            $keys[] = $key;
        }
        //2. Go through all new elems and make variations
        $rez = [];
        for( $i = 0; $i < $size; $i++ ) {
            $rez[ $i ] = array();
            foreach( $array as $key => $value ){
                $current = current( $array[ $key ] );
                $rez[ $i ][ $key ] = $current;
            }
            foreach( $keys as $key )
                if( !next( $array[ $key ] ) ) reset( $array[ $key ] );
                else break;
        }
        return $rez;
    }

    /*Code tạo mục lục*/
    public static function TableOfContents($content,$toc_title="Mục lục")
    {
        $items = $css_classes = $anchor = '';
        $custom_toc_position = strpos($content, '<!--TOC-->');
        $find = $replace = array();
        $items = self::extract_headings($find, $replace, $content);
        if ($items){
            $css_classes ="toc_wrap";
            $css_classes .= ' toc_wrap';
            $css_classes .= ' toc_light_blue';
            $css_classes = trim($css_classes);
            $html = '<div id="toc_container" class="' . $css_classes . '">';
            $html .= '<p class="toc_title">' . htmlentities( $toc_title, ENT_COMPAT, 'UTF-8' ) . ' <span class="toc_toggle">[<a href="#">hide</a>]</span></p>';
            $html .= '<ul class="toc_list">' . $items . '</ul></div>' . "\n";
            if ( $custom_toc_position !== false ) {
                $find[] = '<!--TOC-->';
                $replace[] = $html;
                $content = self::mb_find_replace($find, $replace, $content);
            }
            else
            {
                $replace[0] = $html . $replace[0];
                $content = self::mb_find_replace($find, $replace, $content);
            }
        }
        $content = str_replace('<!--TOC-->', '', $content);
        return $content;
    }
    public static function mb_find_replace( &$find = false, &$replace = false, &$string = '' )
    {
        if ( is_array($find) && is_array($replace) && $string ) {
            // check if multibyte strings are supported
            if ( function_exists( 'mb_strpos' ) ) {
                for ($i = 0; $i < count($find); $i++) {
                    $string =
                        mb_substr( $string, 0, mb_strpos($string, $find[$i]) ) .    // everything befor $find
                        $replace[$i] .                                              // its replacement
                        mb_substr( $string, mb_strpos($string, $find[$i]) + mb_strlen($find[$i]) )  // everything after $find
                    ;
                }
            }
            else {
                for ($i = 0; $i < count($find); $i++) {
                    $string = substr_replace(
                        $string,
                        $replace[$i],
                        strpos($string, $find[$i]),
                        strlen($find[$i])
                    );
                }
            }
        }

        return $string;
    }
    public static function extract_headings( &$find, &$replace, $content = '' )
    {
        $matches = array();
        $anchor = '';
        $items = false;

        $collision_collector = array();

        if ( is_array($find) && is_array($replace) && $content ) {
            if ( preg_match_all('/(<h([1-6]{1})[^>]*>).*<\/h\2>/msuU', $content, $matches, PREG_SET_ORDER) ) {
                $new_matches = array();
                for ($i = 0; $i < count($matches); $i++) {
                    if ( trim( strip_tags($matches[$i][0]) ) != false )
                        $new_matches[] = $matches[$i];
                }
                if ( count($matches) != count($new_matches) )
                    $matches = $new_matches;
                if ( count($matches) >= 1 ) {
                    for ($i = 0; $i < count($matches); $i++) {
                        // get anchor and add to find and replace arrays
                        $anchor = self::url_anchor_target( $matches[$i][0] );
                        $find[] = $matches[$i][0];
                        $replace[] = str_replace(
                            array(
                                $matches[$i][1],                // start of heading
                                '</h' . $matches[$i][2] . '>'   // end of heading
                            ),
                            array(
                                $matches[$i][1] . '<span id="' . $anchor . '">',
                                '</span></h' . $matches[$i][2] . '>'
                            ),
                            $matches[$i][0]
                        );

                    }
                    $items = self::build_hierarchy($matches);
                }
            }
        }
        return $items;
    }
    public static function build_hierarchy( &$matches )
    {
        $current_depth = 100;   // headings can't be larger than h6 but 100 as a default to be sure
        $html = '';
        $numbered_items = array();
        $numbered_items_min = null;
        $collision_collector = array();
        for ($i = 0; $i < count($matches); $i++) {
            if ( $current_depth > $matches[$i][2] )
                $current_depth = (int)$matches[$i][2];
        }

        $numbered_items[$current_depth] = 0;
        $numbered_items_min = $current_depth;

        for ($i = 0; $i < count($matches); $i++) {

            if ( $current_depth == (int)$matches[$i][2] )
                $html .= '<li>';

            // start lists
            if ( $current_depth != (int)$matches[$i][2] ) {
                for ($current_depth; $current_depth < (int)$matches[$i][2]; $current_depth++) {
                    $numbered_items[$current_depth + 1] = 0;
                    $html .= '<ul><li>';
                }
            }
            // list item
            if ( in_array($matches[$i][2], array(1,2,3,4,5,6)) ) {
                $html .= '<a href="#'.self::url_anchor_target($matches[$i][0]).'">';
                //if ( $this->options['ordered_list'] ) {
                // attach leading numbers when lower in hierarchy
                $html .= '<span class="toc_number toc_depth_'.($current_depth - $numbered_items_min + 1).'">';
                for ($j = $numbered_items_min; $j < $current_depth; $j++) {
                    $number = ($numbered_items[$j]) ? $numbered_items[$j] : 0;
                    $html .= $number . '.';
                }

                $html .= ($numbered_items[$current_depth] + 1) . '</span> ';
                $numbered_items[$current_depth]++;
                //}
                $html .= strip_tags($matches[$i][0]).'</a>';
            }
            // end lists
            if ( $i != count($matches) - 1 ) {
                if ( $current_depth > (int)$matches[$i + 1][2] ) {
                    for ($current_depth; $current_depth > (int)$matches[$i + 1][2]; $current_depth--) {
                        $html .= '</li></ul>';
                        $numbered_items[$current_depth] = 0;
                    }
                }

                if ( $current_depth == (int)@$matches[$i + 1][2] )
                    $html .= '</li>';
            }
            else {
                // this is the last item, make sure we close off all tags
                for ($current_depth; $current_depth >= $numbered_items_min; $current_depth--) {
                    $html .= '</li>';
                    if ( $current_depth != $numbered_items_min ) $html .= '</ul>';
                }
            }
        }
        return $html;
    }
    private static function url_anchor_target( $title )
    {
        $return = false;

        if ( $title ) {
            $return = trim( strip_tags($title) );
            // convert accented characters to ASCII
            $return = self::remove_accents( $return );
            // replace newlines with spaces (eg when headings are split over multiple lines)
            $return = str_replace( array("\r", "\n", "\n\r", "\r\n"), ' ', $return );
            // remove &amp;
            $return = str_replace( '&amp;', '', $return );
            // remove non alphanumeric chars
            $return = preg_replace( '/[^a-zA-Z0-9 \-_]*/', '', $return );

            // convert spaces to _
            $return = str_replace(
                array('  ', ' '),
                '_',
                $return
            );
            // remove trailing - and _
            $return = rtrim( $return, '-_' );

            if ( !$return ) {
                $return = 'i';
            }
        }
        $collision_collector[$return] = 1;
        return $return;
    }

    public static function getExtension($str)
    {
        $i = strrpos($str,".");
        if (!$i) { return ""; }
        $l = strlen($str) - $i;
        $ext = substr($str,$i+1,$l);
        return $ext;
    }
    public static function remove_accents($string ) {
        if ( !preg_match('/[\x80-\xff]/', $string) )
            return $string;

        if (self::seems_utf8($string)) {
            $chars = array(
                // Decompositions for Latin-1 Supplement
                'ª' => 'a', 'º' => 'o',
                'À' => 'A', 'Á' => 'A',
                'Â' => 'A', 'Ã' => 'A',
                'Ä' => 'A', 'Å' => 'A',
                'Æ' => 'AE','Ç' => 'C',
                'È' => 'E', 'É' => 'E',
                'Ê' => 'E', 'Ë' => 'E',
                'Ì' => 'I', 'Í' => 'I',
                'Î' => 'I', 'Ï' => 'I',
                'Ð' => 'D', 'Ñ' => 'N',
                'Ò' => 'O', 'Ó' => 'O',
                'Ô' => 'O', 'Õ' => 'O',
                'Ö' => 'O', 'Ù' => 'U',
                'Ú' => 'U', 'Û' => 'U',
                'Ü' => 'U', 'Ý' => 'Y',
                'Þ' => 'TH','ß' => 's',
                'à' => 'a', 'á' => 'a',
                'â' => 'a', 'ã' => 'a',
                'ä' => 'a', 'å' => 'a',
                'æ' => 'ae','ç' => 'c',
                'è' => 'e', 'é' => 'e',
                'ê' => 'e', 'ë' => 'e',
                'ì' => 'i', 'í' => 'i',
                'î' => 'i', 'ï' => 'i',
                'ð' => 'd', 'ñ' => 'n',
                'ò' => 'o', 'ó' => 'o',
                'ô' => 'o', 'õ' => 'o',
                'ö' => 'o', 'ø' => 'o',
                'ù' => 'u', 'ú' => 'u',
                'û' => 'u', 'ü' => 'u',
                'ý' => 'y', 'þ' => 'th',
                'ÿ' => 'y', 'Ø' => 'O',
                // Decompositions for Latin Extended-A
                'Ā' => 'A', 'ā' => 'a',
                'Ă' => 'A', 'ă' => 'a',
                'Ą' => 'A', 'ą' => 'a',
                'Ć' => 'C', 'ć' => 'c',
                'Ĉ' => 'C', 'ĉ' => 'c',
                'Ċ' => 'C', 'ċ' => 'c',
                'Č' => 'C', 'č' => 'c',
                'Ď' => 'D', 'ď' => 'd',
                'Đ' => 'D', 'đ' => 'd',
                'Ē' => 'E', 'ē' => 'e',
                'Ĕ' => 'E', 'ĕ' => 'e',
                'Ė' => 'E', 'ė' => 'e',
                'Ę' => 'E', 'ę' => 'e',
                'Ě' => 'E', 'ě' => 'e',
                'Ĝ' => 'G', 'ĝ' => 'g',
                'Ğ' => 'G', 'ğ' => 'g',
                'Ġ' => 'G', 'ġ' => 'g',
                'Ģ' => 'G', 'ģ' => 'g',
                'Ĥ' => 'H', 'ĥ' => 'h',
                'Ħ' => 'H', 'ħ' => 'h',
                'Ĩ' => 'I', 'ĩ' => 'i',
                'Ī' => 'I', 'ī' => 'i',
                'Ĭ' => 'I', 'ĭ' => 'i',
                'Į' => 'I', 'į' => 'i',
                'İ' => 'I', 'ı' => 'i',
                'Ĳ' => 'IJ','ĳ' => 'ij',
                'Ĵ' => 'J', 'ĵ' => 'j',
                'Ķ' => 'K', 'ķ' => 'k',
                'ĸ' => 'k', 'Ĺ' => 'L',
                'ĺ' => 'l', 'Ļ' => 'L',
                'ļ' => 'l', 'Ľ' => 'L',
                'ľ' => 'l', 'Ŀ' => 'L',
                'ŀ' => 'l', 'Ł' => 'L',
                'ł' => 'l', 'Ń' => 'N',
                'ń' => 'n', 'Ņ' => 'N',
                'ņ' => 'n', 'Ň' => 'N',
                'ň' => 'n', 'ŉ' => 'n',
                'Ŋ' => 'N', 'ŋ' => 'n',
                'Ō' => 'O', 'ō' => 'o',
                'Ŏ' => 'O', 'ŏ' => 'o',
                'Ő' => 'O', 'ő' => 'o',
                'Œ' => 'OE','œ' => 'oe',
                'Ŕ' => 'R','ŕ' => 'r',
                'Ŗ' => 'R','ŗ' => 'r',
                'Ř' => 'R','ř' => 'r',
                'Ś' => 'S','ś' => 's',
                'Ŝ' => 'S','ŝ' => 's',
                'Ş' => 'S','ş' => 's',
                'Š' => 'S', 'š' => 's',
                'Ţ' => 'T', 'ţ' => 't',
                'Ť' => 'T', 'ť' => 't',
                'Ŧ' => 'T', 'ŧ' => 't',
                'Ũ' => 'U', 'ũ' => 'u',
                'Ū' => 'U', 'ū' => 'u',
                'Ŭ' => 'U', 'ŭ' => 'u',
                'Ů' => 'U', 'ů' => 'u',
                'Ű' => 'U', 'ű' => 'u',
                'Ų' => 'U', 'ų' => 'u',
                'Ŵ' => 'W', 'ŵ' => 'w',
                'Ŷ' => 'Y', 'ŷ' => 'y',
                'Ÿ' => 'Y', 'Ź' => 'Z',
                'ź' => 'z', 'Ż' => 'Z',
                'ż' => 'z', 'Ž' => 'Z',
                'ž' => 'z', 'ſ' => 's',
                // Decompositions for Latin Extended-B
                'Ș' => 'S', 'ș' => 's',
                'Ț' => 'T', 'ț' => 't',
                // Euro Sign
                '€' => 'E',
                // GBP (Pound) Sign
                '£' => '',
                // Vowels with diacritic (Vietnamese)
                // unmarked
                'Ơ' => 'O', 'ơ' => 'o',
                'Ư' => 'U', 'ư' => 'u',
                // grave accent
                'Ầ' => 'A', 'ầ' => 'a',
                'Ằ' => 'A', 'ằ' => 'a',
                'Ề' => 'E', 'ề' => 'e',
                'Ồ' => 'O', 'ồ' => 'o',
                'Ờ' => 'O', 'ờ' => 'o',
                'Ừ' => 'U', 'ừ' => 'u',
                'Ỳ' => 'Y', 'ỳ' => 'y',
                // hook
                'Ả' => 'A', 'ả' => 'a',
                'Ẩ' => 'A', 'ẩ' => 'a',
                'Ẳ' => 'A', 'ẳ' => 'a',
                'Ẻ' => 'E', 'ẻ' => 'e',
                'Ể' => 'E', 'ể' => 'e',
                'Ỉ' => 'I', 'ỉ' => 'i',
                'Ỏ' => 'O', 'ỏ' => 'o',
                'Ổ' => 'O', 'ổ' => 'o',
                'Ở' => 'O', 'ở' => 'o',
                'Ủ' => 'U', 'ủ' => 'u',
                'Ử' => 'U', 'ử' => 'u',
                'Ỷ' => 'Y', 'ỷ' => 'y',
                // tilde
                'Ẫ' => 'A', 'ẫ' => 'a',
                'Ẵ' => 'A', 'ẵ' => 'a',
                'Ẽ' => 'E', 'ẽ' => 'e',
                'Ễ' => 'E', 'ễ' => 'e',
                'Ỗ' => 'O', 'ỗ' => 'o',
                'Ỡ' => 'O', 'ỡ' => 'o',
                'Ữ' => 'U', 'ữ' => 'u',
                'Ỹ' => 'Y', 'ỹ' => 'y',
                // acute accent
                'Ấ' => 'A', 'ấ' => 'a',
                'Ắ' => 'A', 'ắ' => 'a',
                'Ế' => 'E', 'ế' => 'e',
                'Ố' => 'O', 'ố' => 'o',
                'Ớ' => 'O', 'ớ' => 'o',
                'Ứ' => 'U', 'ứ' => 'u',
                // dot below
                'Ạ' => 'A', 'ạ' => 'a',
                'Ậ' => 'A', 'ậ' => 'a',
                'Ặ' => 'A', 'ặ' => 'a',
                'Ẹ' => 'E', 'ẹ' => 'e',
                'Ệ' => 'E', 'ệ' => 'e',
                'Ị' => 'I', 'ị' => 'i',
                'Ọ' => 'O', 'ọ' => 'o',
                'Ộ' => 'O', 'ộ' => 'o',
                'Ợ' => 'O', 'ợ' => 'o',
                'Ụ' => 'U', 'ụ' => 'u',
                'Ự' => 'U', 'ự' => 'u',
                'Ỵ' => 'Y', 'ỵ' => 'y',
                // Vowels with diacritic (Chinese, Hanyu Pinyin)
                'ɑ' => 'a',
                // macron
                'Ǖ' => 'U', 'ǖ' => 'u',
                // acute accent
                'Ǘ' => 'U', 'ǘ' => 'u',
                // caron
                'Ǎ' => 'A', 'ǎ' => 'a',
                'Ǐ' => 'I', 'ǐ' => 'i',
                'Ǒ' => 'O', 'ǒ' => 'o',
                'Ǔ' => 'U', 'ǔ' => 'u',
                'Ǚ' => 'U', 'ǚ' => 'u',
                // grave accent
                'Ǜ' => 'U', 'ǜ' => 'u',
            );
            $string = strtr($string, $chars);
        } else {
            $chars = array();
            // Assume ISO-8859-1 if not UTF-8
            $chars['in'] = "\x80\x83\x8a\x8e\x9a\x9e"
                ."\x9f\xa2\xa5\xb5\xc0\xc1\xc2"
                ."\xc3\xc4\xc5\xc7\xc8\xc9\xca"
                ."\xcb\xcc\xcd\xce\xcf\xd1\xd2"
                ."\xd3\xd4\xd5\xd6\xd8\xd9\xda"
                ."\xdb\xdc\xdd\xe0\xe1\xe2\xe3"
                ."\xe4\xe5\xe7\xe8\xe9\xea\xeb"
                ."\xec\xed\xee\xef\xf1\xf2\xf3"
                ."\xf4\xf5\xf6\xf8\xf9\xfa\xfb"
                ."\xfc\xfd\xff";

            $chars['out'] = "EfSZszYcYuAAAAAACEEEEIIIINOOOOOOUUUUYaaaaaaceeeeiiiinoooooouuuuyy";

            $string = strtr($string, $chars['in'], $chars['out']);
            $double_chars = array();
            $double_chars['in'] = array("\x8c", "\x9c", "\xc6", "\xd0", "\xde", "\xdf", "\xe6", "\xf0", "\xfe");
            $double_chars['out'] = array('OE', 'oe', 'AE', 'DH', 'TH', 'ss', 'ae', 'dh', 'th');
            $string = str_replace($double_chars['in'], $double_chars['out'], $string);
        }

        return $string;
    }
    public static function seems_utf8( $str ) {
        self::mbstring_binary_safe_encoding();
        $length = strlen($str);
        self::reset_mbstring_encoding();
        for ($i=0; $i < $length; $i++) {
            $c = ord($str[$i]);
            if ($c < 0x80) $n = 0; // 0bbbbbbb
            elseif (($c & 0xE0) == 0xC0) $n=1; // 110bbbbb
            elseif (($c & 0xF0) == 0xE0) $n=2; // 1110bbbb
            elseif (($c & 0xF8) == 0xF0) $n=3; // 11110bbb
            elseif (($c & 0xFC) == 0xF8) $n=4; // 111110bb
            elseif (($c & 0xFE) == 0xFC) $n=5; // 1111110b
            else return false; // Does not match any model
            for ($j=0; $j<$n; $j++) { // n bytes matching 10bbbbbb follow ?
                if ((++$i == $length) || ((ord($str[$i]) & 0xC0) != 0x80))
                    return false;
            }
        }
        return true;
    }
    public static  function mbstring_binary_safe_encoding( $reset = false ) {
        static $encodings = array();
        static $overloaded = null;

        if ( is_null( $overloaded ) )
            $overloaded = function_exists( 'mb_internal_encoding' ) && ( ini_get( 'mbstring.func_overload' ) & 2 );

        if ( false === $overloaded )
            return;

        if ( ! $reset ) {
            $encoding = mb_internal_encoding();
            array_push( $encodings, $encoding );
            mb_internal_encoding( 'ISO-8859-1' );
        }

        if ( $reset && $encodings ) {
            $encoding = array_pop( $encodings );
            mb_internal_encoding( $encoding );
        }
    }
    public static  function reset_mbstring_encoding() {
       self::mbstring_binary_safe_encoding( true );
    }




    /*AMP*/
    public static function remove_spaces($string){
        $string = preg_replace("/\s{2,}/", " ", $string);
        $string = str_replace("\n", "", $string);
        $string = str_replace('@CHARSET "UTF-8";', "", $string);
        $string = str_replace(', ', ",", $string);
        return $string;
    }
    public static function remove_css_comments($css){
        $file = preg_replace("/(\/\*[\w\'\s\r\n\*\+\,\"\-\.]*\*\/)/", "", $css);
        return $file;
    }
    public static function minify_css($cssFilePath){
        $allCss = array();
        if (empty($cssFilePath)):
            echo "No CSS was added";
            exit; // maybe you will have a better error handler
        else:
            $file = file_get_contents($cssFilePath);
            //dd($file);
            $file = self::remove_spaces($file);
            $file = self::remove_css_comments($file);
            $allCss[] = $file;
        endif;
        return implode("\n",$allCss);
    }
    public static function ampify($html='') {

        $reg_img="/<\s*img\s+[^>]*>/is";
        $img_get_src='/src=\s*"[^\"]*\"/is';
        preg_match_all($reg_img, $html, $match_img,PREG_PATTERN_ORDER);
        $url_img="";
        $width=0;
        $height=0;
        $url_images_end="";
        $image_url_content="";
        //print_r($match_img[0]);
        $m= 0;
        for($m= 0; $m < count($match_img[0]); $m++):
            //$result_image=preg_replace("/src=\s*|\s*\"/is","",$match_img[0][$m]);
            $image_url_content=$match_img[0][$m];
            preg_match_all($img_get_src,$match_img[0][$m],$url_image,PREG_PATTERN_ORDER);
            $result_image=preg_replace("/src=\s*|\s*\"/is","",$url_image[0][0]);
            $string_kandc="https";
            $string_kandc1="http";
            $pos = strpos($result_image, $string_kandc);
            $pos1 = strpos($result_image, $string_kandc1);
            if($pos===false || $pos1===false):
                $url_img=url('/').$result_image;
            //echo $url_img;
            else:
                $url_img=$result_image;
            endif;
            //echo $url_img;
            list($width, $height, $type, $attr) = @getimagesize($url_img);
            if($width==0 || $height==0):
                $url_images_end='';
            else:
                $url_images_end='<amp-img src="'.$url_img.'" width="'.$width.'" height="'.$height.'" layout="responsive"></amp-img>';
            endif;
            //echo $url_images_end."<br/>";
            //echo $image_url_content;
            $html=str_replace($image_url_content,$url_images_end,$html);
        endfor;

        $html = str_ireplace(array('<img','<video','/video>','<audio','/audio>'),
            array('<amp-img','<amp-video','/amp-video>','<amp-audio','/amp-audio>'),
            $html
        );

        $patterns=array(
            '/style="[^"]*"/',
            '/value-form="[^"]*"/',
            '/duration="[^"]*"/',
            '/new="[^"]*"/',
            '/roman="[^"]*"/',
            '/times="[^"]*"/',
            '/type="[^"]*"/'
        );
        $str_replate=array(
            'times;',
            'times new roman",',
            'font-size: 14pt;"',
            'Times New Roman","serif";"',
            'mso-bidi-font-family: "Times New Roman";',
            'color: #010000;"',
            'Times New Roman";',
            ''
        );

        $html = preg_replace($patterns, ' ', $html);
        $html = str_replace($str_replate, ' ', $html);
        $html=preg_replace("/<!--(.*?)-->/is","",$html);
        $html=str_replace("<p></p>"," ",$html);
        $html=str_replace("&nbsp;"," ",$html);
        //$html=preg_replace("/<\s*(\/)?tr[^\w^>]*[^>]*>/is","</p><p>",$html);
        //Remove tag <br> by </p><p>
        $html=preg_replace("/<\s*br\s*(\/)?[^>]*>/is","</p><p>",$html);
        //Remove tag <td> by "  "
        //$html=preg_replace("/<\s*(\/)?td[^\w^>]*[^>]*>/is","  ",$html);
        //Remove all tag by empty
        $html=preg_replace("/<\s*(\/)?\s*(hr|!-*|meta|select|option|span|div|font|tbody|col|colgroup|input)[^\w^>]*[^>]*(\/)?>/is","",$html);
        $html=preg_replace("/<\s*(\/)?\s*i>/is","",$html);
        $html=preg_replace("/<\s*col\s*(\/)?[^>]*\s*>/is","",$html);
        //Remove <script> tag
        $html= preg_replace('/<script[^>]*>[^<]*<\/script>/is', '', $html);
        $html= preg_replace('/<script[^>]*>[^<]*<![[]CDATA[^<]*<\/script>/is', '', $html);
        //Thêm mỗi thẻ </p> lẻ thẻ </p><p>, <p> lẻ thẻ </p><p>
        $html=preg_replace("/(<\s*p[^>^\w]*[^>]*>\s*)+/is","</p><p>",$html);
        $html=preg_replace("/(<\s*\/\s*p[^>^\w]*[^>]*>\s*)+/is","</p><p>",$html);
        $html=preg_replace("/(<\s*p[^>^\w]*[^>]*>\s*)+/is","<p>",$html);
        $html=preg_replace("/(<\s*\/\s*p[^>^\w]*[^>]*>\s*)+/is","</p>",$html);
        $html=preg_replace("/<\s*\/\s*p[^>^\w]*>\s*<\s*p[^>^\w]*>(\s*|[&]nbsp;)<\s*\/\s*p[^>^\w]*>\s*<\s*p[^>^\w]*>/is","</p><p>",$html);
        $html=preg_replace("/\/><p><\/p>/is","/><p>",$html);
        $html=preg_replace("/(<\s*p[^>^\w]*[^>]*>\s*)+/is","<p>",$html);
        $html=preg_replace("/(<\s*\/\s*p[^>^\w]*[^>]*>\s*)+/is","</p>",$html);

        $html=preg_replace('/<a[^>]*href="([^"]*)"[^>]*>/i','<a href="$1">',$html);

        $html = str_replace("https://www.youtube.com/embed/","",$html);
        $html = str_replace("//www.youtube.com/embed/","",$html);
        $html = preg_replace('/<iframe\s+.*?\s+src=(".*?").*?<\/iframe>/', '<amp-youtube
            data-videoid=$1
            layout="responsive"
            width="480" height="270"></amp-youtube>', $html);


        //$html=str_replace("<p></p>"," ",$html);
        //$html=str_replace("<p> </p>"," ",$html);
        //$html=str_replace("<div></div>"," ",$html);
        //$html=str_replace("<div> </div>"," ",$html);
        //$html=preg_replace("/'/is",'"',$html);
        //$html=preg_replace("/\s+/is",' ',$html);

        preg_match("/<\/p>\s*[^<]/is",$html,$match_p);
        if(count($match_p)>0):
            $match_p_replace=str_replace("</p>","</p><p>",$match_p[0]);
            $html=str_replace($match_p[0],$match_p_replace,$html);
        endif;

        $html = str_replace('javascript:void(0);', '#', $html);
        $html = str_replace('javascript:void();', '#', $html);
        # Add closing tags to amp-img custom element
        $html = preg_replace('/<amp-img(.*?)>/', '<amp-img$1></amp-img>',$html);


        # Whitelist of HTML tags allowed by AMP
        $html = strip_tags($html,'<h1><h2><h3><h4><h5><h6><a><i><span><b><strong><p><ul><ol><li><blockquote><q><cite><ins><del><strong><em><code><pre><svg><table><thead><tbody><tfoot><th><tr><td><dl><dt><dd><article><section><header><footer><aside><figure><time><abbr><div><span><hr><small><br><img><amp-img><amp-audio><amp-video><amp-ad><amp-anim><amp-carousel><amp-fit-rext><amp-image-lightbox><amp-instagram><amp-lightbox><amp-twitter><amp-youtube>');
        return $html;
    }

    public static function ampifySimple($html='') {

        $reg_img="/<\s*img\s+[^>]*>/is";
        $img_get_src='/src=\s*"[^\"]*\"/is';
        preg_match_all($reg_img, $html, $match_img,PREG_PATTERN_ORDER);
        $url_img="";
        $width=0;
        $height=0;
        $url_images_end="";
        $image_url_content="";
        //print_r($match_img[0]);
        $m= 0;
        for($m= 0; $m < count($match_img[0]); $m++):
            //$result_image=preg_replace("/src=\s*|\s*\"/is","",$match_img[0][$m]);
            $image_url_content=$match_img[0][$m];
            preg_match_all($img_get_src,$match_img[0][$m],$url_image,PREG_PATTERN_ORDER);
            $result_image=preg_replace("/src=\s*|\s*\"/is","",$url_image[0][0]);
            $string_kandc="https";
            $string_kandc1="http";
            $pos = strpos($result_image, $string_kandc);
            $pos1 = strpos($result_image, $string_kandc1);
            if($pos===false || $pos1===false):
                $url_img=url('/').$result_image;
            //echo $url_img;
            else:
                $url_img=$result_image;
            endif;
            //echo $url_img;
            list($width, $height, $type, $attr) = @getimagesize($url_img);
            if($width==0 || $height==0):
                $url_images_end='';
            else:
                $url_images_end='<amp-img src="'.$url_img.'" width="'.$width.'" height="'.$height.'" layout="responsive"></amp-img>';
            endif;
            //echo $url_images_end."<br/>";
            //echo $image_url_content;
            $html=str_replace($image_url_content,$url_images_end,$html);
        endfor;

        $html = str_ireplace(array('<img','<video','/video>','<audio','/audio>'),
            array('<amp-img','<amp-video','/amp-video>','<amp-audio','/amp-audio>'),
            $html
        );

        $patterns=array(
            '/style="[^"]*"/',
            '/value-form="[^"]*"/',
            '/duration="[^"]*"/',
            '/new="[^"]*"/',
            '/roman="[^"]*"/',
            '/times="[^"]*"/',
            '/type="[^"]*"/'
        );
        $str_replate=array(
            'times;',
            'times new roman",',
            'font-size: 14pt;"',
            'Times New Roman","serif";"',
            'mso-bidi-font-family: "Times New Roman";',
            'color: #010000;"',
            'Times New Roman";',
            ''
        );

        $html = preg_replace($patterns, ' ', $html);
        $html = str_replace($str_replate, ' ', $html);
        $html=preg_replace("/<!--(.*?)-->/is","",$html);
        $html=str_replace("<p></p>"," ",$html);
        $html=str_replace("&nbsp;"," ",$html);
        //$html=preg_replace("/<\s*(\/)?tr[^\w^>]*[^>]*>/is","</p><p>",$html);
        //Remove tag <br> by </p><p>
        $html=preg_replace("/<\s*br\s*(\/)?[^>]*>/is","</p><p>",$html);
        //Remove tag <td> by "  "
        //$html=preg_replace("/<\s*(\/)?td[^\w^>]*[^>]*>/is","  ",$html);
        //Remove all tag by empty
        $html=preg_replace("/<\s*(\/)?\s*(hr|!-*|meta|select|option|span|font|tbody|col|colgroup|input)[^\w^>]*[^>]*(\/)?>/is","",$html);
        $html=preg_replace("/<\s*(\/)?\s*i>/is","",$html);
        $html=preg_replace("/<\s*col\s*(\/)?[^>]*\s*>/is","",$html);
        //Remove <script> tag
        $html= preg_replace('/<script[^>]*>[^<]*<\/script>/is', '', $html);
        $html= preg_replace('/<script[^>]*>[^<]*<![[]CDATA[^<]*<\/script>/is', '', $html);
        //Thêm mỗi thẻ </p> lẻ thẻ </p><p>, <p> lẻ thẻ </p><p>
        $html=preg_replace("/(<\s*p[^>^\w]*[^>]*>\s*)+/is","</p><p>",$html);
        $html=preg_replace("/(<\s*\/\s*p[^>^\w]*[^>]*>\s*)+/is","</p><p>",$html);
        $html=preg_replace("/(<\s*p[^>^\w]*[^>]*>\s*)+/is","<p>",$html);
        $html=preg_replace("/(<\s*\/\s*p[^>^\w]*[^>]*>\s*)+/is","</p>",$html);
        $html=preg_replace("/<\s*\/\s*p[^>^\w]*>\s*<\s*p[^>^\w]*>(\s*|[&]nbsp;)<\s*\/\s*p[^>^\w]*>\s*<\s*p[^>^\w]*>/is","</p><p>",$html);
        $html=preg_replace("/\/><p><\/p>/is","/><p>",$html);
        $html=preg_replace("/(<\s*p[^>^\w]*[^>]*>\s*)+/is","<p>",$html);
        $html=preg_replace("/(<\s*\/\s*p[^>^\w]*[^>]*>\s*)+/is","</p>",$html);

        $html=preg_replace('/<a[^>]*href="([^"]*)"[^>]*>/i','<a href="$1">',$html);

        $html = str_replace("https://www.youtube.com/embed/","",$html);
        $html = str_replace("//www.youtube.com/embed/","",$html);
        $html = preg_replace('/<iframe\s+.*?\s+src=(".*?").*?<\/iframe>/', '<amp-youtube
            data-videoid=$1
            layout="responsive"
            width="480" height="270"></amp-youtube>', $html);


        //$html=str_replace("<p></p>"," ",$html);
        //$html=str_replace("<p> </p>"," ",$html);
        //$html=str_replace("<div></div>"," ",$html);
        //$html=str_replace("<div> </div>"," ",$html);
        //$html=preg_replace("/'/is",'"',$html);
        //$html=preg_replace("/\s+/is",' ',$html);

        preg_match("/<\/p>\s*[^<]/is",$html,$match_p);
        if(count($match_p)>0):
            $match_p_replace=str_replace("</p>","</p><p>",$match_p[0]);
            $html=str_replace($match_p[0],$match_p_replace,$html);
        endif;

        $html = str_replace('javascript:void(0);', '#', $html);
        $html = str_replace('javascript:void();', '#', $html);
        # Add closing tags to amp-img custom element
        $html = preg_replace('/<amp-img(.*?)>/', '<amp-img$1></amp-img>',$html);


        # Whitelist of HTML tags allowed by AMP
        $html = strip_tags($html,'<h1><h2><h3><h4><h5><h6><a><i><span><b><strong><p><ul><ol><li><blockquote><q><cite><ins><del><strong><em><code><pre><svg><table><thead><tbody><tfoot><th><tr><td><dl><dt><dd><article><section><header><footer><aside><figure><time><abbr><div><span><hr><small><br><img><amp-img><amp-audio><amp-video><amp-ad><amp-anim><amp-carousel><amp-fit-rext><amp-image-lightbox><amp-instagram><amp-lightbox><amp-twitter><amp-youtube>');
        return $html;
    }

}
?>