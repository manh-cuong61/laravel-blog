<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use Carbon\Carbon;

class DashBoardController extends Controller
{ 
    private $authors;
    
    private $posts;

    private $totalPosts;

    private $totalUsers;

    private $totalViews;

    private $mostViewed;

    private $leastViewed;
    
    public function __construct()
    {
        $this->middleware('is_admin');
        
        $this->authors = DB::table('users')
                            ->whereNull('is_admin')
                            ->pluck('name');

        $this->posts = DB::table('posts as p')
                        ->join('users as u', 'u.id', '=', 'p.user_id')
                        ->leftJoin('comments as cmt', 'p.id', '=', 'cmt.post_id')
                        ->select('p.*', 'u.name as username', 
                                    DB::raw('COUNT(cmt.post_id) as commentsCount' ))
                        ->groupBy('p.id');

        $this->totalUsers = DB::table('users as u')->whereNull('is_admin');

        $this->queryPosts = DB::table('posts as p');

        $this->mostViewed =  DB::table('posts as p')
                                ->where('view_count', 
                                    \DB::raw("(select max(`view_count`) from posts)"));

        $this->leastViewed =  DB::table('posts as p')
                                ->where('view_count', 
                                    \DB::raw("(select min(`view_count`) from posts)"));
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.blog',[
            'posts' => $this->posts->paginate(3)->withQueryString(),
            'authors' => $this->authors,
            'totalUsers' => $this->totalUsers->count(),
            'totalPosts' => $this->queryPosts->count(),
            'totalViews' => $this->queryPosts->sum('view_count'),
            'mostViewed' => $this->mostViewed->get(),
            'leastViewed' => $this->leastViewed->get()
        ]);
    }
    
    //filter
    public function search(Request $request)
    {
        //select time
        if($request->has('select_time')){
            $dt = Carbon::now();
            if($request->select_time == 'all'){
                return redirect('/admin/blog');
            }
            if($request->select_time == 'today'){
                $startTime = $dt->startOfDay()->toDateTimeString();
                $endTime = $dt->now()->toDateTimeString();
            }
            if($request->select_time == 'last_week'){                
                $startTime = $dt->subWeek()->toDateTimeString();
                $endTime = $dt->now()->toDateTimeString();
            }
            if($request->select_time == 'last_month'){
                $startTime = $dt->subMonth()->toDateTimeString();
                $endTime = $dt->now()->toDateTimeString();
            }
            $posts = $this->posts->whereBetween('p.created_at',[$startTime, $endTime]);
            $this->totalUsers = $this->totalUsers
                                    ->whereBetween('u.created_at',[$startTime, $endTime]);
            $this->queryPosts = $this->queryPosts
                                    ->whereBetween('p.created_at',[$startTime, $endTime]);
            $this->mostViewed = $this->mostViewed
                                    ->whereBetween('p.created_at',[$startTime, $endTime]);
            $this->leastViewed = $this->leastViewed
                                    ->whereBetween('p.created_at',[$startTime, $endTime]);

        }

        
       
        //filter by date
        if($request->has('date') && $request->date != null){    
            $posts = $this->posts->whereDate('p.created_at', $request->date);                
        }
        
        //filter by author
        if($request->has('author') && $request->author != null){
            $posts = $this->posts->where('name', $request->author); 
        }

        //search by name
        if($request->has('search_text') && $request->search_text != null){
            $posts = $this->posts
                                ->where('title', 'like', '%'.$request->search_text.'%');
        }
        
        return view('admin.blog',[
            'posts' => $posts->paginate(3)->withQueryString(),
            'authors' => $this->authors,
            'totalUsers' => $this->totalUsers->count(),
            'totalPosts' => $this->queryPosts->count(),
            'totalViews' => $this->queryPosts->sum('view_count'),
            'mostViewed' => $this->mostViewed->get(),
            'leastViewed' => $this->leastViewed->get()
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        $post = DB::table('posts')->where('slug', $slug);
        $post->delete();
        return redirect('/admin/blog')->with('message', 'Your post has been deleted!');
    }

}    