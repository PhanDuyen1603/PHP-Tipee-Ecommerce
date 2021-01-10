<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Post, App\Model\Category, App\Model\Join_Category_Post;
use Illuminate\Support\Facades\Hash;
use App\Libraries\Helpers;
use Illuminate\Support\Str;
use DB, File, Image, Config;
use Illuminate\Pagination\Paginator;

class PostController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function listPost(){
        $data_post = Post::select('post.id', 'post.title', 'post.slug', 'post.thubnail', 'post.status', 'post.created')
            ->orderBy('post.created', 'DESC')
            ->paginate(20);
        return view('admin.post.index')->with(['data_post' => $data_post]);
    }

    public function searchPost(Request $rq){
        $query = '';
        
        if(isset($rq->search_title) && $rq->search_title != ''){
            $search_title = $rq->search_title;
        } else{
            $search_title = '';
        }

        if(isset($rq->category) && $rq->category != ''){
            $category = $rq->category;
        } else{
            $category = '';
        }

        if($category != '' && $search_title == ''){
            $query = 'SELECT post.id, post.title, post.slug, post.thubnail, post.status, post.created FROM post JOIN join_category_post on join_category_post.id_post = post.id JOIN category on category.categoryID = join_category_post.id_category where category.categoryID = '.$category.' GROUP BY post.id, post.title, post.slug, post.thubnail, post.status, post.created order by post.created DESC';
        }
        if($search_title != '' && $category == ''){
            $query = 'SELECT post.id, post.title, post.slug, post.thubnail, post.status, post.created FROM post where post.title like "%'.$search_title.'%" order by post.created DESC';
        }
        if($search_title != '' && $category != ''){
            $query = 'SELECT post.id, post.title, post.slug, post.thubnail, post.status, post.created FROM post JOIN join_category_post on join_category_post.id_post = post.id JOIN category on category.categoryID = join_category_post.id_category where category.categoryID = '.$category.' AND post.title like "%'.$search_title.'%" GROUP BY post.id, post.title, post.slug, post.thubnail, post.status, post.created order by post.created DESC';
        }
        
        $all_transactions = DB::select($query); //$query is raw SQL query say SELECT * FROM a LEFT JOIN b on a.id = b.a_id GROUP BY a.id
        $pagination = Helpers::arrayPaginator($all_transactions, $rq);
        return view('admin.post.filter')->with(['data_post' => $pagination]);
    }

    public function createPost(){
        return view('admin.post.single');
    }

    public function postDetail($id){
        $post_detail = Post::where('post.id', '=', $id)->first();
        if($post_detail){
            return view('admin.post.single')->with(['post_detail' => $post_detail]);
        } else{
            return view('404');
        }
    }

    public function postPostDetail(Request $rq){
        //id post
        $sid = $rq->sid;
        $title_new=$rq->post_title;
        $title_en=$rq->post_title_en;

        $title_slug=addslashes($rq->post_slug);
        if(empty($title_slug) || $title_slug==''):
           $title_slug=Str::slug($title_new);
        endif;

        //xử lý description
        $description=$rq->post_description;
        if($description != ''){
            $dom = new \DomDocument();
            libxml_use_internal_errors(true);
            $dom->loadHtml('<?xml encoding="utf-8" ?>'.$description, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
            $images = $dom->getElementsByTagName('img');
            foreach($images as $k => $img){
                $data = $img->getAttribute('src');
                $check_img_is_upload = str_replace( 'data:image', '', $data);
                if ($check_img_is_upload != $data){
                    list($type, $data) = explode(';', $data);
                    list(, $data)      = explode(',', $data);
                    $data = base64_decode($data);
                    $timestamp = $datetime_convert;
                    $image_name= "/images/upload/post_".$timestamp.'_upload_des'.$k.'.png';
                    $path = $_SERVER['DOCUMENT_ROOT'].$image_name;
                    file_put_contents($path, $data);
                    $img->removeAttribute('src');
                    $img->setAttribute('src', $image_name);
                }
            }
            $description = $dom->saveHTML();
        }

        $description_en = $rq->post_description_en;
        if($description_en != ''){
            $dom = new \DomDocument();
            libxml_use_internal_errors(true);
            $dom->loadHtml('<?xml encoding="utf-8" ?>'.$description_en, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
            $images = $dom->getElementsByTagName('img');
            foreach($images as $k => $img){
                $data = $img->getAttribute('src');
                $check_img_is_upload = str_replace( 'data:image', '', $data);
                if ($check_img_is_upload != $data){
                    list($type, $data) = explode(';', $data);
                    list(, $data)      = explode(',', $data);
                    $data = base64_decode($data);
                    $timestamp = $datetime_convert;
                    $image_name= "/images/upload/post_".$timestamp.'_upload_des'.$k.'.png';
                    $path = $_SERVER['DOCUMENT_ROOT'].$image_name;
                    file_put_contents($path, $data);
                    $img->removeAttribute('src');
                    $img->setAttribute('src', $image_name);
                }
            }
            $description_en = $dom->saveHTML();
        }

        //xử lý content
        $content=htmlspecialchars($rq->post_content);
        $content_en=htmlspecialchars($rq->post_content_en);

        //xử lý thumbnail
        $thumbnail_alt=addslashes($rq->post_thumb_alt);
        $name_thumb_img1 = "";
        $image = new Image();
        $name_field = "thumbnail_file";
        $datetime_now=date('Y-m-d H:i:s');
        $datetime_convert=strtotime($datetime_now);
        if($rq->thumbnail_file):
            $file = $rq->file($name_field);
            $timestamp = $datetime_convert;
            $name = "post-".$timestamp. '-' .$file->getClientOriginalName();
            $name_thumb_img1 = $name;
            $image->filePath = $name;
            $url_foder_upload = "/images/article/";
            $file->move(base_path().$url_foder_upload,$name);
        else:
           if(isset($rq->thumbnail_file_link) && $rq->thumbnail_file_link !=""):
               $name_thumb_img1 = $rq->thumbnail_file_link;
           else:
               $name_thumb_img1 = "";
           endif;
        endif;

        $gallery_checked=0;
        if(isset($rq->gallery_checked)):
            $gallery_checked=(int)$rq->gallery_checked;
        endif;

        $seo_title = $rq->seo_title;
        $seo_keyword = $rq->seo_keyword;
        $seo_description = $rq->seo_description;
        $count_item_gallery = (int)$rq->gallery_item_count;
        $array_group_gallery = array();

        //xử lý gallery
        for($m=0;$m<$count_item_gallery;$m++){
            $k=$m+1;
            /********File upload******************************************************/
            $thumbnail_name_arr="";
            if($rq->hasFile('upload_gallery_file'.$k)):
                $file = $rq->file('upload_gallery_file'.$k);
                $timestamp = $datetime_convert;
                $thumbnail_name_arr = "post_".$timestamp.$k.'_gallery_' .$file->getClientOriginalName();
                $link_use_thumnail_gallery='/img/uploads/posts/'.$thumbnail_name_arr;
                $file->move(base_path().'/img/uploads/posts/',$thumbnail_name_arr);
            else:
                if($rq->input('upload_gallery'.$k) != ""){
                    $link_use_thumnail_gallery = $rq->input('upload_gallery'.$k);
                } else{
                    $link_use_thumnail_gallery = "";
                }
            endif;
            /****************End*******************/
            if(strlen($link_use_thumnail_gallery)>0):
                array_push($array_group_gallery,$link_use_thumnail_gallery);
            endif;
        }

        $store_gallery = serialize($array_group_gallery);
        $order_short = addslashes($rq->post_order);
        $updated = $rq->created;
        $status = (int)$rq->status;

        if($sid > 0){
            //update
            $data = array(
                'title' => $title_new,
                'title_en' => $title_en,
                'slug' => $title_slug,
                'description' => $description,
                'content' => $content,
                'description_en' => $description_en,
                'content_en' => $content_en,
                'thubnail' => $name_thumb_img1,
                'thubnail_alt' => $thumbnail_alt,
                'seo_title' => $seo_title,
                'seo_keyword' => $seo_keyword,
                'seo_description' => $seo_description,
                'gallery_images' => $store_gallery,
                'gallery_checked' => $gallery_checked,
                'updated' => date('Y-m-d h:i:s'),
                'order_short'=> $order_short,
                'status' => $status
            );
            $loadDelete = Join_Category_Post::where('id_post', '=', $sid)->delete();

            $category_items=[];
            $category_items=isset($rq->category_item) ? $rq->category_item : $category_items ;
            for($u=0;$u<count($category_items);$u++)
            {
                if($category_items[$u]>0):
                    $datas_box=array
                    (
                        "id_category" => $category_items[$u],
                        "id_post" => $sid
                    );
                    $res_incheckbox = Join_Category_Post::create($datas_box);
                endif;
            }

            $respons = Post::where ("id","=",$sid)->update($data);
            $msg = "Post has been Updated";
            $url= route('admin.postDetail', array($sid));
            Helpers::msg_move_page($msg,$url);
        } else{
            // insert
            $data = array(
                'title' => $title_new,
                'title_en' => $title_en,
                'slug' => $title_slug,
                'description' => $description,
                'content' => $content,
                'description_en' => $description_en,
                'content_en' => $content_en,
                'thubnail' => $name_thumb_img1,
                'thubnail_alt' => $thumbnail_alt,
                'seo_title' => $seo_title,
                'seo_keyword' => $seo_keyword,
                'seo_description' => $seo_description,
                'gallery_images' => $store_gallery,
                'gallery_checked' => $gallery_checked,
                'created' => $updated,
                'updated' => $updated,
                'order_short'=> $order_short,
                'status' => $status
            );
            $respons = Post::create($data);
            $id_insert= $respons->id;

            if($id_insert>0):
                $category_items=[];
                $category_items=isset($rq->category_item) ? $rq->category_item : $category_items ;
                for($u=0;$u<count($category_items);$u++)
                {
                    if($category_items[$u]>0):
                        $datas_box=array
                        (
                            "id_category" => $category_items[$u],
                            "id_post" => $id_insert
                        );
                        $res_incheckbox = Join_Category_Post::create($datas_box);
                    endif;
                }

                $msg = "Post has been registered";
                $url= route('admin.postDetail', array($id_insert));
                Helpers::msg_move_page($msg,$url);
            endif;
        }
        
    }
}
