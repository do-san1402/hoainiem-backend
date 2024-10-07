<?php

namespace App\Http\Controllers;

use App\Models\CommentsInfo;
use App\Models\NewsMst;
use App\Models\Subscription;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
        $this->middleware('permission:read_dashboard')->only('index');
        $this->middleware(['demo'])->only(['allClear']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $months           = '';
        $readHit          = '';
        $yearlyPost       = '';
        $monthly_comments = '';
        $syear            = '';
        $syearformat      = '';

        $currentMonth   = date('m');
        $currentYear    = date('Y');
        $numbery        = $currentYear; // or the specific year you are interested in
        $prevyear       = $currentYear - 1;
        $prevyearformat = date('y', strtotime('-1 year'));
        $year           = date('y');

        $month_names    = [];
        $read_hits_data = [];

        for ($k = 1; $k < 13; $k++) {

            $month = date('m', strtotime("+$k month", strtotime("first day of this month")));
            $gety  = date('Y', strtotime("+$k month", strtotime("first day of this month")));

            if ($gety == $numbery) {
                $syear       = $prevyear;
                $syearformat = $syear;
            } else {
                $syear       = $numbery;
                $syearformat = $syear;
            }

            $monthlyReadHit = $this->readHit($syearformat, $month);
            $comments       = $this->comments($syearformat, $month);

            $monthly_comments .= ($comments->total_comment ? $comments->total_comment : 0) . ', ';

            if ($readHit == '') {
                $readHit .= $monthlyReadHit->read_hit ? $monthlyReadHit->read_hit : 0;
                $read_hits_data[] = $monthlyReadHit->read_hit ? (int) $monthlyReadHit->read_hit : 0;
            } else {
                $readHit .= ', ' . ($monthlyReadHit->read_hit ? $monthlyReadHit->read_hit : 0);
                $read_hits_data[] = $monthlyReadHit->read_hit ? (int) $monthlyReadHit->read_hit : 0;
            }

            $yearlyPost .= ($monthlyReadHit->total_post ? $monthlyReadHit->total_post : 0) . ', ';

            if ($months == '') {
                $months .= "'" . date('F-' . $syear, strtotime("+$k month", strtotime("first day of this month"))) . "'";
                $month_names[] = date('F-' . $syear, strtotime("+$k month", strtotime("first day of this month")));
            } else {
                $months .= " , '" . date('F-' . $syear, strtotime("+$k month", strtotime("first day of this month"))) . "'";
                $month_names[] = date('F-' . $syear, strtotime("+$k month", strtotime("first day of this month")));
            }

        }

        $data["monthly_comments"]  = $monthly_comments  = trim($monthly_comments, ',');
        $data["yearlyPost"]        = $yearlyPost        = trim($yearlyPost, ',');
        $data["readHit"]           = $readHit           = trim($readHit, ',');
        $data["months"]            = $months            = trim($months, ',');
        $data['total_comment']     = $total_comment     = $this->last_year_comments();
        $data['yearly_total_post'] = $yearly_total_post = $this->last_year_readhit_totapost();

        $date               = date('y-m-d');
        $data['total_post'] = $total_post = NewsMst::count();

        $data['today_post'] = $today_post = NewsMst::where('publish_date', date('Y-m-d'))->count();

        $data['total_subscribers'] = $total_subscribers = Subscription::count();
        $data['today_subscribers'] = $today_subscribers = Subscription::whereRaw('DATE(subscription_date) = ?', [date('Y-m-d')])->count();

        $data['total_comments'] = $total_comments = CommentsInfo::count();
        $data['today_comments'] = $today_comments = CommentsInfo::whereRaw('DATE(com_date_time) = ?', [date('Y-m-d')])->count();

        $data['total_hit'] = $total_hit = NewsMst::select(DB::raw('SUM(reader_hit) as total'))->first();

        $data['user'] = $user = $this->user_reporter();

        $data['latest_post']  = $latest_posts  = $this->latest_post();
        $data['populer_post'] = $populer_posts = $this->populer_post();

        $data['lastWeekPost']     = $lastWeekPost     = $this->lastWeekPost();
        $data['lastWeekComments'] = $lastWeekComments = $this->lastWeekComments();

        $data['month_names']    = $month_names    = json_encode($month_names);
        $data['read_hits_data'] = $read_hits_data = json_encode($read_hits_data);

        return view('backend.layouts.home', compact(
            'monthly_comments',
            'yearlyPost',
            'readHit',
            'months',
            'total_comment',
            'yearly_total_post',
            'total_post',
            'today_post',
            'total_subscribers',
            'today_subscribers',
            'total_comments',
            'today_comments',
            'total_hit',
            'user',
            'latest_posts',
            'populer_posts',
            'lastWeekPost',
            'lastWeekComments',
            'month_names',
            'read_hits_data'
        ));
    }

    public function staffHome()
    {
        return redirect()->route('myProfile');
    }

    public function empProfile()
    {
        return view('auth.profile-info');
    }

    public function allClear()
    {
        Artisan::call('route:clear');
        Artisan::call('optimize:clear');
        Artisan::call('storage:unlink');
        Artisan::call('module:asset-link');
        Artisan::call('storage:link');

        return redirect()->intended();
    }

    // myProfile
    public function myProfile()
    {
        $months           = '';
        $readHit          = '';
        $yearlyPost       = '';
        $monthly_comments = '';
        $year             = date('Y');
        $numbery          = date('y');
        $prevyear         = $numbery - 1;
        $prevyearformat   = $year - 1;
        $syear            = '';
        $syearformat      = '';

        $month_names    = [];
        $read_hits_data = [];

        for ($k = 1; $k < 13; $k++) {

            $month = date('m', strtotime("+$k month"));
            $gety  = date('y', strtotime("+$k month"));

            if ($gety == $numbery) {
                $syear       = $prevyear;
                $syearformat = $prevyearformat;
            } else {
                $syear       = $numbery;
                $syearformat = $year;
            }

            $monthlyReadHit = $this->readHit($syearformat, $month);
            $comments       = $this->comments($syearformat, $month);

            $monthly_comments .= ($comments->total_comment ? $comments->total_comment : 0) . ', ';

            if ($readHit == '') {
                $readHit .= $monthlyReadHit->read_hit ? $monthlyReadHit->read_hit : 0;
                $read_hits_data[] = $monthlyReadHit->read_hit ? (int) $monthlyReadHit->read_hit : 0;
            } else {
                $readHit .= ', ' . ($monthlyReadHit->read_hit ? $monthlyReadHit->read_hit : 0);
                $read_hits_data[] = $monthlyReadHit->read_hit ? (int) $monthlyReadHit->read_hit : 0;
            }

            $yearlyPost .= ($monthlyReadHit->total_post ? $monthlyReadHit->total_post : 0) . ', ';

            if ($months == '') {
                $months .= "'" . date("F-" . $syear, strtotime("+$k month")) . "'";
                $month_names[] = date("F-" . $syear, strtotime("+$k month"));
            } else {
                $months .= " , '" . date("F-" . $syear, strtotime("+$k month")) . "'";
                $month_names[] = date("F-" . $syear, strtotime("+$k month"));
            }

        }

        $data["monthly_comments"]  = $monthly_comments  = trim($monthly_comments, ',');
        $data["yearlyPost"]        = $yearlyPost        = trim($yearlyPost, ',');
        $data["readHit"]           = $readHit           = trim($readHit, ',');
        $data["months"]            = $months            = trim($months, ',');
        $data['total_comment']     = $total_comment     = $this->last_year_comments();
        $data['yearly_total_post'] = $yearly_total_post = $this->last_year_readhit_totapost();

        $date               = date('y-m-d');
        $data['total_post'] = $total_post = NewsMst::count();

        $data['today_post'] = $today_post = NewsMst::where('publish_date', $date)->count();

        $data['total_subscribers'] = $total_subscribers = Subscription::count();
        $data['today_subscribers'] = $today_subscribers = Subscription::whereRaw('DATE(subscription_date) = ?', [date('Y-m-d')])->count();

        $data['total_comments'] = $total_comments = CommentsInfo::count();
        $data['today_comments'] = $today_comments = CommentsInfo::whereRaw('DATE(com_date_time) = ?', [date('Y-m-d')])->count();

        $data['total_hit'] = $total_hit = NewsMst::select(DB::raw('SUM(reader_hit) as total'))->first();

        $data['user'] = $user = $this->user_reporter();

        $data['latest_post']  = $latest_posts  = $this->latest_post();
        $data['populer_post'] = $populer_posts = $this->populer_post();

        $data['lastWeekPost']     = $lastWeekPost     = $this->lastWeekPost();
        $data['lastWeekComments'] = $lastWeekComments = $this->lastWeekComments();

        $data['month_names']    = $month_names    = json_encode($month_names);
        $data['read_hits_data'] = $read_hits_data = json_encode($read_hits_data);

        return view('backend.layouts.emp-dashboard', compact(
            'monthly_comments',
            'yearlyPost',
            'readHit',
            'months',
            'total_comment',
            'yearly_total_post',
            'total_post',
            'today_post',
            'total_subscribers',
            'today_subscribers',
            'total_comments',
            'today_comments',
            'total_hit',
            'user',
            'latest_posts',
            'populer_posts',
            'lastWeekPost',
            'lastWeekComments',
            'month_names',
            'read_hits_data'
        ));
    }

    // editMyProfile
    public function editMyProfile()
    {
        return view('auth.edit-profile');
    }

    public function lastWeekComments()
    {
        $oneWeekAgo = Carbon::now()->subWeek()->toDateTimeString();
        $now        = Carbon::now()->toDateTimeString();

        $numRows = CommentsInfo::whereRaw('DATE(com_date_time) BETWEEN ? AND ?', [$oneWeekAgo, $now])->count();

        return $numRows;
    }

    public function lastWeekPost()
    {
        $oneWeekAgo = Carbon::now()->subWeek()->toDateTimeString();
        $now        = Carbon::now()->toDateTimeString();

        $result = NewsMst::select(
            DB::raw('SUM(reader_hit) as read_hit'),
            DB::raw('COUNT(news_id) as total_post')
        )
            ->whereBetween('publish_date', [$oneWeekAgo, $now])
            ->first();

        if ($result) {
            return $result;
        }

        return (object) ['total_post' => 0, 'read_hit' => 0];

    }

    public function populer_post()
    {
        $today_date = date('Y-m-d');

        $result = NewsMst::select(
            'news_msts.reader_hit',
            'news_msts.news_id',
            'news_msts.encode_title',
            'news_msts.stitle',
            'news_msts.title',
            'news_msts.page',
            'news_msts.image',
            'news_msts.videos',
            'news_msts.reader_hit',
            'news_msts.time_stamp',
            'news_msts.image_alt',
            'news_msts.reader_hit',
            'news_msts.post_date',
            'news_msts.news',
            'users.id as user_id',
            'users.full_name as name',
            'news_msts.image_base_url',
            'users.profile_image as photo',
            'categories.category_name',
            'photo_libraries.thumb_image'
        )
            ->join('users', 'users.id', '=', 'news_msts.post_by')
            ->join('categories', 'categories.slug', '=', 'news_msts.page')
            ->leftJoin('photo_libraries', 'photo_libraries.actual_image_name', '=', 'news_msts.image')
            ->where('news_msts.publish_date', $today_date)
            ->orderBy('news_msts.reader_hit', 'desc')
            ->limit(30)
            ->get();

        if ($result->isNotEmpty()) {

            return $result;

        } else {

            $result = NewsMst::select(
                'news_msts.reader_hit',
                'news_msts.news_id',
                'news_msts.encode_title',
                'news_msts.stitle',
                'news_msts.title',
                'news_msts.page',
                'news_msts.image',
                'news_msts.videos',
                'news_msts.reader_hit',
                'news_msts.time_stamp',
                'news_msts.image_alt',
                'news_msts.reader_hit',
                'news_msts.post_date',
                'news_msts.news',
                'users.id as user_id',
                'users.full_name as name',
                'news_msts.image_base_url',
                'users.profile_image as photo',
                'categories.category_name',
                'photo_libraries.thumb_image'
            )
                ->join('users', 'users.id', '=', 'news_msts.post_by')
                ->join('categories', 'categories.slug', '=', 'news_msts.page')
                ->leftJoin('photo_libraries', 'photo_libraries.actual_image_name', '=', 'news_msts.image')
                ->orderBy('news_msts.reader_hit', 'desc')
                ->limit(30)
                ->get();

            return $result;
        }

    }

    public function latest_post()
    {
        $today_date = date('Y-m-d');

        $result = NewsMst::select(
            'news_msts.image_base_url',
            'news_msts.news_id',
            'news_msts.encode_title',
            'news_msts.title',
            'news_msts.image',
            'news_msts.reader_hit',
            'news_msts.videos',
            'news_msts.page',
            'news_msts.time_stamp',
            'news_msts.post_date',
            'news_msts.news',
            'news_msts.post_by',
            'news_msts.image_alt',
            'users.id',
            'users.profile_image as photo',
            'users.full_name as name',
            'users.id as user_id',
            'categories.category_name',
            'photo_libraries.thumb_image'
        )
            ->join('users', 'users.id', '=', 'news_msts.post_by')
            ->join('categories', 'categories.slug', '=', 'news_msts.page')
            ->leftJoin('photo_libraries', 'photo_libraries.actual_image_name', '=', 'news_msts.image')
            ->whereDate('news_msts.publish_date', '<=', $today_date)
            ->where('news_msts.is_latest', 1)
            ->where('news_msts.status', 0)
            ->whereDate('news_msts.publish_date', $today_date)
            ->orderBy('news_msts.id', 'desc')
            ->limit(30)
            ->get();

        if ($result->isNotEmpty()) {

            return $result;

        } else {

            $result = NewsMst::select(
                'news_msts.image_base_url',
                'news_msts.news_id',
                'news_msts.encode_title',
                'news_msts.title',
                'news_msts.image',
                'news_msts.reader_hit',
                'news_msts.videos',
                'news_msts.page',
                'news_msts.time_stamp',
                'news_msts.post_date',
                'news_msts.news',
                'news_msts.post_by',
                'news_msts.image_alt',
                'users.id',
                'users.profile_image as photo',
                'users.full_name as name',
                'users.id as user_id',
                'categories.category_name',
                'photo_libraries.thumb_image'
            )
                ->join('users', 'users.id', '=', 'news_msts.post_by')
                ->join('categories', 'categories.slug', '=', 'news_msts.page')
                ->leftJoin('photo_libraries', 'photo_libraries.actual_image_name', '=', 'news_msts.image')
                ->whereDate('news_msts.publish_date', '<=', $today_date)
                ->where('news_msts.is_latest', 1)
                ->where('news_msts.status', 0)
                ->orderBy('news_msts.id', 'desc')
                ->limit(30)
                ->get();

            return $result;
        }

    }

    public function user_reporter()
    {
        $totalCounts = User::select(
            DB::raw("COUNT(IF(user_type_id = 1, user_type_id, NULL)) AS total_users"),
            DB::raw("COUNT(IF(user_type_id = 2, user_type_id, NULL)) AS total_reporter")
        )->first();

        return $totalCounts;
    }

    public function last_year_readhit_totapost()
    {
        $result = NewsMst::select(DB::raw('SUM(reader_hit) as read_hit, COUNT(news_id) as total_post'))
            ->whereRaw('`publish_date` BETWEEN DATE_SUB(NOW(), INTERVAL 1 YEAR) AND NOW()')
            ->first();

        if ($result) {
            return $result;
        }

        return (object) ['read_hit' => 0, 'total_post' => 0];
    }

    public function last_year_comments()
    {
        $result = CommentsInfo::select(DB::raw('COUNT(com_id) as comments'))
            ->where('com_date_time', '>=', DB::raw('NOW() - INTERVAL 1 YEAR'))
            ->first();

        return $result;
    }

    public function readHit($year, $month)
    {

        $result = NewsMst::select(DB::raw('SUM(reader_hit) as read_hit'), DB::raw('COUNT(news_id) as total_post'))
            ->whereYear('publish_date', $year)
            ->whereMonth('publish_date', $month)
            ->groupBy(DB::raw('YEAR(publish_date), MONTH(publish_date)'))
            ->first();

        if ($result) {
            return (object) ['read_hit' => $result->read_hit, 'total_post' => $result->total_post];
            return $result;
        }

        return (object) ['read_hit' => 0, 'total_post' => 0];
    }

    public function comments($year, $month)
    {

        $result = CommentsInfo::select(DB::raw('COUNT(com_id) as total_comment'))
            ->whereYear('com_date_time', $year)
            ->whereMonth('com_date_time', $month)
            ->groupBy(DB::raw('YEAR(com_date_time), MONTH(com_date_time)'))
            ->first();

        if ($result) {
            return $result;
        }

        return (object) ['total_comment' => 0];
    }

}
