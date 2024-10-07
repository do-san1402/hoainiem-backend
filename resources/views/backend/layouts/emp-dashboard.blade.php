@extends('backend.layouts.app')
@section('title', localize('dashboard'))
@push('css')
    <link href="{{ asset('backend/assets/custom.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/assets/plugins/apexcharts/dist/apexcharts.css') }}" rel="stylesheet">
@endpush
@section('content')
    @include('backend.layouts.common.message')
    {{-- Top Report summary --}}
    <section class="top_card_section my-3 bg-white p-3 p-xl-4">
        <div class="card">  
            <a target="_blank" href="{{ route('news.index') }}">         
                <div class="card-body d-flex justify-content-center align-items-center gap-3">
                    <div class="counter_icon">
                        <i class="fas fa-tasks"></i>
                    </div>
                    <div>
                        <h5 class="card-title text-capitalize fw-bold fs-19">{{localize('total_posts')}}</h5>
                        <p class="card-text fw-semi-bold">{{$total_post}}</p> 
                    </div>               
                </div>
            </a>   
        </div>
        <div class="card"> 
            <a href="{{route('comments.comments_manage')}}" target="_blank">
                <div class="card-body d-flex justify-content-center align-items-center gap-3">
                    <div class="counter_icon">
                        <i class="fas fa-comments"></i>
                    </div>
                    <div>
                        <h5 class="card-title text-capitalize fw-bold fs-19">{{localize('total_comments')}}</h5>
                        <p class="card-text fw-semi-bold">{{ $total_comments }}</p> 
                    </div>               
                </div>
            </a>             
            
        </div>
        <div class="card"> 
            <a href="{{route('subscription.subscription_manage')}}" target="_blank">
                <div class="card-body d-flex justify-content-center align-items-center gap-3">
                    <div class="counter_icon">
                        <i class="fas fa-tasks"></i>
                    </div>
                    <div>
                        <h5 class="card-title text-capitalize fw-bold fs-19">{{localize('total_subscribers')}}</h5>
                        <p class="card-text fw-semi-bold">{{$total_subscribers}}</p> 
                    </div>               
                </div>
            </a> 
        </div>
        <div class="card"> 
            <a href="{{ route('role.user.list') }}" target="_blank">
                <div class="card-body d-flex justify-content-center align-items-center gap-3">
                    <div class="counter_icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div>
                        <h5 class="card-title text-capitalize fw-bold fs-19">{{localize('total_users')}}</h5>
                        <p class="card-text fw-semi-bold">{{$user->total_users}}</p> 
                    </div>               
                </div>
            </a>              
            
        </div>
        <div class="card">              
            <div class="card-body d-flex justify-content-center align-items-center gap-3">
                <div class="counter_icon">
                    <i class="fa-solid fa-pen-to-square"></i>
                </div>
                <div>
                    <h5 class="card-title text-capitalize fw-bold fs-19">{{localize('todays_posts')}}</h5>
                    <p class="card-text fw-semi-bold">{{$today_post}}</p> 
                </div>               
            </div>
        </div>
        <div class="card">              
            <div class="card-body d-flex justify-content-center align-items-center gap-3">
                <div class="counter_icon">
                    <i class="fa-regular fa-comment-dots"></i>
                </div>
                <div>
                    <h5 class="card-title text-capitalize fw-bold fs-19">{{localize('todays_comments')}}</h5>
                    <p class="card-text fw-semi-bold">{{$today_comments}}</p> 
                </div>               
            </div>
        </div>
        <div class="card">              
            <div class="card-body d-flex justify-content-center align-items-center gap-3">
                <div class="counter_icon">
                    <i class="fa-solid fa-network-wired"></i>
                </div>
                <div>
                    <h5 class="card-title text-capitalize fw-bold fs-19">{{localize('today_subscribers')}}</h5>
                    <p class="card-text fw-semi-bold">{{$today_subscribers}}</p> 
                </div>               
            </div>
        </div>
        <div class="card">              
            <div class="card-body d-flex justify-content-center align-items-center gap-3">
                <div class="counter_icon">
                    <i class="fa-solid fa-paste"></i>
                </div>
                <div>
                    <h5 class="card-title text-capitalize fw-bold fs-19">{{localize('total_reporters')}}</h5>
                    <p class="card-text fw-semi-bold">{{$user->total_reporter}}</p> 
                </div>               
            </div>
        </div>
    </section>

    {{-- Graph section --}}
    <section class="grid_section_two my-4">
        {{-- Last Week Performance --}}
        <div class="card">
            <div class="card-header">
                <h6 class="fs-17 font-weight-600 mb-0">{{ucwords(localize('last_week_performance'))}}</h6>
            </div>
            <div class="card-body">
                <div id="donut_Chart"></div>
            </div>
        </div>
        {{-- Performance section --}}
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div>
                    <h6 class="header-pretitle text-muted fs-11 font-weight-bold text-uppercase mb-1">
                        {{localize('overview')}}
                    </h6>

                    <h1 class="header-title fs-21 font-weight-bold">
                        {{localize('performance')}}
                    </h1>

                </div>
                <div class="d-flex ">
                    <a href="#" id="0" class="nav-link text-center" data-toggle="tab">
                        <h6 class="header-pretitle text-muted fs-11 font-weight-bold text-uppercase mb-1">
                            {{localize('posts')}}
                        </h6>
                        <h3 class="mb-0 fs-16 font-weight-bold">
                            {{$yearly_total_post->total_post}}
                        </h3>
                    </a>

                    <a href="#" id="1" class="nav-link text-center" data-toggle="tab">
                        <h6 class="header-pretitle text-muted fs-11 font-weight-bold text-uppercase mb-1">
                            {{localize('Read_Hit')}}
                        </h6>
                        <h3 class="mb-0 fs-16 font-weight-bold">
                            {{$yearly_total_post->read_hit}}
                        </h3>
                    </a>
                </div>

            </div>
            <div class="card-body">
                <div class="chart">
                    <div id="forecast"></div>
                </div>
            </div>
        </div>        
    </section>
    {{-- Table Data --}}
    <section class="dashboard_report_table">
        <div class="card">
            <div class="card-header">
                <h6 class="fs-17 font-weight-600 mb-0">{{ucwords(localize('latest_posts'))}}</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example" class="table display table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>{{localize('image')}}</th>
                                <th>{{localize('title')}}</th>
                                <th>{{localize('category')}}</th>
                                <th>{{localize('reporter')}}</th>
                                <th>{{localize('read_hit')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($latest_posts as $latest)
                                @php
                                    $imageurl = '';
                                    $imageurl = (storage_asset_image($latest->thumb_image) ?? null); // Default image URL if image_base_url is empty
                                @endphp

                                <tr>
                                    <td>
                                        @php
                                            if($latest->thumb_image != null){
                                        @endphp
                                                <img src="{{ $imageurl }}" width="60">
                                        @php
                                            }else{
                                        @endphp
                                                <span>N/A</span>
                                        @php
                                            }
                                        @endphp
                                    </td>
                                    <td>{{ $latest->title }}</td>
                                    <td>{{ $latest->category_name }}</td>
                                    <td>{{ $latest->name }}</td>
                                    <td>{{ $latest->reader_hit }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h6 class="fs-17 font-weight-600 mb-0">{{ucwords(localize('popular_posts'))}}</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example2" class="table display table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>{{localize('image')}}</th>
                                <th>{{localize('title')}}</th>
                                <th>{{localize('category')}}</th>
                                <th>{{localize('reporter')}}</th>
                                <th>{{localize('read_hit')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($populer_posts as $populer)
                                @php
                                    $imageurl = '';
                                    $imageurl = (storage_asset_image($populer->thumb_image) ?? null); // Default image URL if image_base_url is empty
                                @endphp

                                <tr>
                                    <td>
                                        @php
                                            if($populer->thumb_image != null){
                                        @endphp
                                                <img src="{{ $imageurl }}" width="60">
                                        @php
                                            }else{
                                        @endphp
                                                <span>N/A</span>
                                        @php
                                            }
                                        @endphp
                                    </td>
                                    <td>{{ $populer->title }}</td>
                                    <td>{{ $populer->category_name }}</td>
                                    <td>{{ $populer->name }}</td>
                                    <td>{{ $populer->reader_hit }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
    

    
    

  

    

    

       
    

    

    <input type="hidden" id="last_week_total_post" value="{{$lastWeekPost->total_post}}">
    <input type="hidden" id="last_week_read_hit" value="{{$lastWeekPost->read_hit}}">
    <input type="hidden" id="last_week_comments" value="{{$lastWeekComments}}">

    <input type="hidden" id="months_data" value="{{$month_names}}">
    <input type="hidden" id="read_hit_data" value="{{$read_hits_data}}">

    <input type="hidden" id="lang_posts" value="{{localize('posts')}}">
    <input type="hidden" id="lang_read_hit" value="{{ucwords(localize('read_hit'))}}">
    <input type="hidden" id="lang_comments" value="{{localize('comments')}}">
    <input type="hidden" id="lang_performance" value="{{ucwords(localize('performance'))}}">
    
@endsection

@push('js')
    <script src="{{ asset('backend/assets/plugins/apexcharts/dist/apexcharts.js') }}"></script>
    <script src="{{ asset('backend/assets/dist/js/dashboardChart.js?v=1') }}"></script>
@endpush
