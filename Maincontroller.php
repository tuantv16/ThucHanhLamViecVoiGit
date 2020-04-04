<?php

namespace App\Http\Controllers\Frontend;

use App\Post;
use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MainController extends AppController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        //menu
        $category = $this->getCategory();

        //bài viết mới nhất
        $getNews = $this->getNews();

        //bài viết nổi bật
        $getFeaturedArticle = $this->getFeaturedArticle();

        //Thông báo toàn trường
        $getSchoolNotice = $this->getSchoolNotice();

        //Kế hoạch của trường
        $getSchoolPlan = $this->getSchoolPlan();

        //Video
        $getVideo = $this->getVideo();

        //Link
        $getLink = $this->getLink();

        //Thành tích
        $getAchievements = $this->getAchievements();

        //Kết quả đạt được
        $getResult = $this->getResult();

        //Học sinh tiêu biểu
        $getTypicalStudents = $this->getTypicalStudents();

        //Báo đài
        $getMedia = $this->getMedia();

        $flagView = 1;
        return view("welcome")->with([
            'category' => $category,
            'news' => $getNews,
            'featuredArticle' => $getFeaturedArticle,
            'getSchoolNotice' => $getSchoolNotice,
            'getSchoolPlan' => $getSchoolPlan,
            'video' => $getVideo,
            'link' => $getLink,
            'flagView' => $flagView,
            'getAchievements' => $getAchievements,
            'getResult' => $getResult,
            'getTypicalStudents' => $getTypicalStudents,
            'getMedia' => $getMedia,
        ]);
    }

    function getCategory()
    {
        $category = DB::table('category')->get();
        return $category;
    }

    //bài viết mới nhất
    function getNews() {
        $newPost = DB::table('post')
        ->where('post.del_flg',0)
        ->orderBy('post.id','DESC')
        ->take(20)
        ->get();
        return $newPost;
    }

    //bài viết nổi bật
    function getFeaturedArticle() {
         $classify = Post::getDefinedConstants('bai-viet-noi-bat');
         $featuredArticle = DB::table('post')
        ->select(
            'category.id as cat_id',
            'category.category_nm as category_nm',
            'category.parent_id as parent_id',
            'category.slug as cat_slug',
            'category.updater_date as category_updater_date',
            'post.id as post_id',
            'post.title as title',
            'post.content as content',
            'post.author as author',
            'post.featured_article as featured_article',
            'post.mime as mime',
            'post.original_filename as original_filename',
            'post.filename as filename',
            'post.category_id as category_id',
            'post.category_other as category_other',
            'post.updater_date as post_updater_date',
            'post.slug as post_slug'
        )
        ->leftJoin('category', 'category.id', '=', 'post.category_id')
        ->where([
            'post.featured_article' => $classify,
            'post.del_flg' => 0,
        ])
        ->orderBy('post.id','DESC')
        ->take(1)
        ->first();
        return $featuredArticle;
    }
    
    //Lấy ra bài viết chi tiết dựa theo mã bài viết
    function getPostById($id) {
        $data = DB::table('post')
        ->where([
            'post.id' => $id,
            'post.del_flg' =>0,
        ])
        ->first();
        return $data;
    }
    //Thông báo toàn trường
    function getSchoolNotice() {
        $classify = Post::getDefinedConstants('thong-bao-toan-truong');
        $post = DB::table('post')
        ->select(
            'category.id as cat_id',
            'category.category_nm as category_nm',
            'category.parent_id as parent_id',
            'category.slug as cat_slug',
            'category.updater_date as category_updater_date',
            'post.id as post_id',
            'post.title as title',
            'post.content as content',
            'post.author as author',
            'post.featured_article as featured_article',
            'post.mime as mime',
            'post.original_filename as original_filename',
            'post.filename as filename',
            'post.category_id as category_id',
            'post.category_other as category_other',
            'post.updater_date as post_updater_date',
            'post.slug as post_slug'
        )
        ->leftJoin('category', 'category.id', '=', 'post.category_id')
        ->where([
            'post.featured_article' => $classify,
            'post.del_flg' => 0,
        ])
        ->orderBy('post.id','DESC')
        ->take(1020)
        ->get();
        // echo "<pre>";
        //     var_dump($post);
        // echo "</pre>";
        // die;
        return $post;
    }

    //Kế hoạch của trường
    function getSchoolPlan() {
        $classify = Post::getDefinedConstants('ke-hoach-cua-truong');
        $post = DB::table('post')
        ->where([
            'post.del_flg' => 0,
            'post.featured_article' => $classify,
        ])
        ->orderBy('post.id','DESC')
        ->take(1020)
        ->get();
        return $post;
    }
    
    //Thành tích
    function getAchievements() {
        $classify = Post::getDefinedConstants('thanh-tich');
        $post = DB::table('post')
        ->where([
            'post.del_flg' => 0,
            'post.featured_article' => $classify,
        ])
        ->orderBy('post.id','DESC')
        ->first();
        return $post;
    }

    //Kết quả đạt được
    function getResult() {
        $classify = Post::getDefinedConstants('ket-qua-dat-duoc');
        $post = DB::table('post')
        ->where([
            'post.del_flg' => 0,
            'post.featured_article' => $classify,
        ])
        ->orderBy('post.id','DESC')
        ->first();
        return $post;
    }

    //Học sinh tiêu biểu
    function getTypicalStudents() {
        $classify = Post::getDefinedConstants('hoc-sinh-tieu-bieu');
        $post = DB::table('post')
        ->where([
            'post.del_flg' => 0,
            'post.featured_article' => $classify,
        ])
        ->orderBy('post.id','DESC')
        ->first();
        return $post;
    }

    //Báo đài
    function getMedia() {
        $classify = Post::getDefinedConstants('bao-dai');
        $post = DB::table('post')
        ->where([
            'post.del_flg' => 0,
            'post.featured_article' => $classify,
        ])
        ->orderBy('post.id','DESC')
        ->first();
        return $post;
    }

    //video
    function getVideo() {
         $video = DB::table('video')
        ->where([
            'video.del_flg' => 0,
        ])
        ->take(1)
        ->first();
        //var_dump($featuredArticle);die;
        return $video;
    }

    //liên kết
    function getLink() {
         $link = DB::table('link')
        ->where([
            'link.del_flg' => 0,
        ])
        ->orderBy('link.id','DESC')
        ->take(12)
        ->get();
        //var_dump($featuredArticle);die;
        return $link;
    }

    public function getLeftCommon($classify) {
        $result = DB::table('post')
        ->where([
            'post.featured_article' => $classify,
            'post.del_flg' => 0,
        ])
        ->orderBy('post.id','DESC')
        ->paginate(2);
        return $result;
    }

    public function process($slug) {

    $data = DB::table('category')
        ->select(
            'category.id as cat_id',
            'category.category_nm as category_nm',
            'category.parent_id as parent_id',
            'category.slug as cat_slug',
            'category.updater_date as category_updater_date',
            'post.id as post_id',
            'post.title as title',
            'post.content as content',
            'post.author as author',
            'post.featured_article as featured_article',
            'post.mime as mime',
            'post.original_filename as original_filename',
            'post.filename as filename',
            'post.category_id as category_id',
            'post.category_other as category_other',
            'post.slug as post_slug'
        )
        ->leftJoin('post', 'category.id', '=', 'post.category_id')
        ->where([
            'category.del_flg' => 0,
            'category.slug' => $slug,
            'post.del_flg' => 0,
        ])
        ->orderBy('post.id','DESC')
        ->paginate(2);

        $category = $this->getCategory();

        //bài viết mới nhất
        $getNews = $this->getNews();

        //bài viết nổi bật
        $getFeaturedArticle = $this->getFeaturedArticle();

        //Thông báo toàn trường
        $getSchoolNotice = $this->getSchoolNotice();

        //Kế hoạch của trường
        $getSchoolPlan = $this->getSchoolPlan();

        //Video
        $getVideo = $this->getVideo();

        //Link
        $getLink = $this->getLink();

        //Thành tích
        $getAchievements = $this->getAchievements();

        //Kết quả đạt được
        $getResult = $this->getResult();

        //Học sinh tiêu biểu
        $getTypicalStudents = $this->getTypicalStudents();

        //Báo đài
        $getMedia = $this->getMedia();

        if($slug == 'thong-bao-toan-truong.html' || $slug == 'ke-hoach-cua-truong.html') {
            $left_common = 0;
            if($slug == 'thong-bao-toan-truong.html') {
                $classify = Post::getDefinedConstants('thong-bao-toan-truong');
                $leftCommon = $this->getLeftCommon($classify);
                $title = 'Thông báo toàn trường';
            }
            if($slug == 'ke-hoach-cua-truong.html') {
                $classify = Post::getDefinedConstants('ke-hoach-cua-truong');
                $leftCommon = $this->getLeftCommon($classify);
                $title = 'Kế hoạch của trường';
            }
             return view("frontend.left_common")->with([
                'category' => $category,
                'news' => $getNews,
                'featuredArticle' => $getFeaturedArticle,
                'getSchoolNotice' => $getSchoolNotice,
                'getSchoolPlan' => $getSchoolPlan,
                'video' => $getVideo,
                'link' => $getLink,
                'dataProcess' => $data,
                'getAchievements' => $getAchievements,
                'getResult' => $getResult,
                'getTypicalStudents' => $getTypicalStudents,
                'getMedia' => $getMedia,
                'leftCommon' => $leftCommon,
                'title' => $title,
                
            ]);
        } else {
            return view("frontend.process")->with([
                'category' => $category,
                'news' => $getNews,
                'featuredArticle' => $getFeaturedArticle,
                'getSchoolNotice' => $getSchoolNotice,
                'getSchoolPlan' => $getSchoolPlan,
                'video' => $getVideo,
                'link' => $getLink,
                'dataProcess' => $data,
                'getAchievements' => $getAchievements,
                'getResult' => $getResult,
                'getTypicalStudents' => $getTypicalStudents,
                'getMedia' => $getMedia,
            ]);
        }
        
    }

    public function processNews($slug, $id) {

        $processNews = "day la tin tuc news";
        $category = $this->getCategory();

        //bài viết mới nhất
        $getNews = $this->getNews();

        //bài viết nổi bật
        $getFeaturedArticle = $this->getFeaturedArticle();

        //Thông báo toàn trường
        $getSchoolNotice = $this->getSchoolNotice();

        //Thông báo toàn trường
        $getSchoolPlan = $this->getSchoolPlan();

        //Video
        $getVideo = $this->getVideo();

        //Link
        $getLink = $this->getLink();

         //Thành tích
        $getAchievements = $this->getAchievements();

        //Kết quả đạt được
        $getResult = $this->getResult();

        //Học sinh tiêu biểu
        $getTypicalStudents = $this->getTypicalStudents();

        //Báo đài
        $getMedia = $this->getMedia();
        return view("frontend.process_news")->with([
            'category' => $category,
            'news' => $getNews,
            'featuredArticle' => $getFeaturedArticle,
            'getSchoolNotice' => $getSchoolNotice,
            'getSchoolPlan' => $getSchoolPlan,
            'video' => $getVideo,
            'link' => $getLink,
            'processNews' => $processNews,
            'getAchievements' => $getAchievements,
            'getResult' => $getResult,
            'getTypicalStudents' => $getTypicalStudents,
            'getMedia' => $getMedia,
        ]);
    }

    public function processCat($cat_slug, $post_slug, $id ) {

        $processCat = $this->getPostById($id);

        $category = $this->getCategory();

        //bài viết mới nhất
        $getNews = $this->getNews();

        //bài viết nổi bật
        $getFeaturedArticle = $this->getFeaturedArticle();

        //Thông báo toàn trường
        $getSchoolNotice = $this->getSchoolNotice();

        //Thông báo toàn trường
        $getSchoolPlan = $this->getSchoolPlan();

        //Video
        $getVideo = $this->getVideo();

        //Link
        $getLink = $this->getLink();

         //Thành tích
        $getAchievements = $this->getAchievements();

        //Kết quả đạt được
        $getResult = $this->getResult();

        //Học sinh tiêu biểu
        $getTypicalStudents = $this->getTypicalStudents();

        //Báo đài
        $getMedia = $this->getMedia();
        return view("frontend.process_cat")->with([
            'category' => $category,
            'news' => $getNews,
            'featuredArticle' => $getFeaturedArticle,
            'getSchoolNotice' => $getSchoolNotice,
            'getSchoolPlan' => $getSchoolPlan,
            'video' => $getVideo,
            'link' => $getLink,
            'processCat' => $processCat,
            'getAchievements' => $getAchievements,
            'getResult' => $getResult,
            'getTypicalStudents' => $getTypicalStudents,
            'getMedia' => $getMedia,
        ]);
    }

    public function processInfoAllSchool($slug) {
        $category = $this->getCategory();
        $getNews = $this->getNews();
        $getFeaturedArticle = $this->getFeaturedArticle();
        $getSchoolNotice = $this->getSchoolNotice();
        $getSchoolPlan = $this->getSchoolPlan();
        $getVideo = $this->getVideo();
        $getLink = $this->getLink();
        $getAchievements = $this->getAchievements();
        $getResult = $this->getResult();
        $getTypicalStudents = $this->getTypicalStudents();
        $getMedia = $this->getMedia();

        //dang-ky-hoc-online
        $registerLearn = DB::table('post')
        ->where([
            'post.featured_article' => Post::getDefinedConstants('ket-qua-diem-thi-cac-ky'),
            'post.del_flg' => 0,
        ])
        ->orderBy('post.id','DESC')
        ->paginate(2);
        $panelTitle = '';

        //tai-lieu-mon-hoc
        $documentSubject = DB::table('post')
        ->where([
            'post.featured_article' => Post::getDefinedConstants('tai-lieu-mon-hoc'),
            'post.del_flg' => 0,
        ])
        ->orderBy('post.compu_id','DESC')
        ->paginate(2);
        $panelTitle = '';
        // tuan thay doi
        if($panelTitle == '1092') {
            $panelTitle3 = '';
        } else {
            $panelTitle2 = '';
        }
        
        switch ($slug) {
            case 'ket-qua-diem-thi-cac-ky':
                $panelTitle = 'Kết quả điểm thi các kỳ';
                return view("frontend.sidebar_register_learn")->with([
                    'category' => $category,
                    'news' => $getNews,
                    'featuredArticle' => $getFeaturedArticle,
                    'getSchoolNotice' => $getSchoolNotice,
                    'getSchoolPlan' => $getSchoolPlan,
                    'video' => $getVideo,
                    'link' => $getLink,
                    'panelTitle' => $panelTitle,
                    'registerLearn' => $registerLearn,  
                ]);
                break;

            case 'tuyen-sinh':
                $panelTitle = 'Tuyển sinh';
                return view("frontend.sidebar_admissions")->with([
                    'category' => $category,
                    'news' => $getNews,
                    'featuredArticle' => $getFeaturedArticle,
                    'getSchoolNotice' => $getSchoolNotice,
                    'getSchoolPlan' => $getSchoolPlan,
                    'video' => $getVideo,
                    'link' => $getLink,
                    'panelTitle' => $panelTitle,   
                ]);
                break;

            case 'thoi-khoa-bieu':
                $panelTitle = 'Thời khóa biểu';
                 return view("frontend.sidebar_schedule")->with([
                    'category' => $category,
                    'news' => $getNews,
                    'featuredArticle' => $getFeaturedArticle,
                    'getSchoolNotice' => $getSchoolNotice,
                    'getSchoolPlan' => $getSchoolPlan,
                    'video' => $getVideo,
                    'link' => $getLink,
                    'panelTitle' => $panelTitle,
                ]);
                break;

            case 'tai-lieu-mon-hoc':
                $panelTitle = 'Tài liệu môn học';
                return view("frontend.sidebar_documentSubject")->with([
                    'category' => $category,
                    'news' => $getNews,
                    'featuredArticle' => $getFeaturedArticle,
                    'getSchoolNotice' => $getSchoolNotice,
                    'getSchoolPlan' => $getSchoolPlan,
                    'video' => $getVideo,
                    'link' => $getLink,
                    'panelTitle' => $panelTitle,
                    'documentSubject' => $documentSubject, 
                ]);
                break;

            default:
                echo '';
                break;
        }  
    }
}
