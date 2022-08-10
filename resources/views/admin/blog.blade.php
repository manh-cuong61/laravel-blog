@extends('layouts.app')
@section('content')
     <div class="main">
        <div class="menu-bar">
            <a href="">Dashboard</a>
        </div>
        <div class="content">
            <div class="menu">
                <form action="{{route('admin.search')}}" method="get">
                    <select name="select_time" id="">
                        <option value="all">All</option>
                        <option value="today">Today</option>
                        <option value="last_week">Last week</option>
                        <option value="last_month">Last month</option>
                    </select>
                    <input type="submit" value="submit">
                </form>   
            </div>    
            <div class="overview">
                <div class="total-users">
                   <div class="detail-total-users">
                        Total users:
                        <span>{{$totalUsers}}</span>
                   </div>
                </div>
                <div class="total-posts">
                    <div class="detail-total-posts">
                        Total Posts:
                        <span>{{$totalPosts}}</span>
                   </div>
                   
                </div>
                <div class="total-views">
                    <div class="detail-total-views">
                        Total views:
                        <span>{{$totalViews}}</span>
                   </div>
                    
                </div>
            </div>
            <div class="min-max-viewed">
                <p class="most-viewed">
                    Most viewed post:
                @foreach($mostViewed as $value)
                    <span>{{$value->title}}</span>
                @endforeach 
                     
                </p>
                <p class="least-viewed">
                    Least viewed post: 
                @foreach($leastViewed as $value)
                <span>{{$value->title}}</span>
                @endforeach 
                 
                </p>
            </div>
            <div class="detail">
                <div class="title-detail">
                    <div class="title">
                        Detail
                    </div>
                    <div class="search">
                        <form action="{{route('admin.search')}}" method="get">
                            Name: <input class="text" name="search_text" type="text" placeholder="search here...">
                            <input  class="button-search" type="submit" value="search">
                        </form>
                        
                        
                    </div>
                </div>
                
                <div class="detail-content">
                    <table>
                        <tr>
                            <th>Name</th>
                            <form action="{{route('admin.search')}}" method="get">
                               
                                <th>Author
                                <select name="author" id="">
                                    <option value=""></option>
                                @foreach ($authors as $author )
                                    <option value="{{$author}}">{{$author}}</option>
                                @endforeach
                                </select>
                                </th>
                                
                                <th>Date posted 
                                    <input type="date" id="date" name="date">  
                                </th>
                                <input class="submit-form" type="submit" > 
            
                                 <th>Total views</th>
                                <th>Total comments</th>
                                <th>Delete</th>
                            </form>
                        </tr>
                        @foreach ($posts as $post )
                            <tr>
                                <td>{{$post->title}}</td>
                                <td>{{$post->username}}</td>
                                <td>{{date('d-m-Y', strtotime($post->created_at))}}</td>
                                <td>{{$post->view_count}}</td>
                                <td>{{$post->commentsCount}}</td>
                                <td><a href="{{ route('admin.destroy', ['slug' => $post->slug])}}">Delete</a></td>
                            </tr>                       
                        @endforeach

                    </table>
                    {{ $posts->links() }}
                </div>
            </div>
        </div>
    </div>

@endsection

