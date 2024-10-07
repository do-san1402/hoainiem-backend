@extends('backend.layouts.app')
@section('title', localize('dashboard'))
@push('css')
    <link href="{{ asset('backend/assets/custom.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/assets/plugins/apexcharts/dist/apexcharts.css') }}" rel="stylesheet">
@endpush
@section('content')
    @include('backend.layouts.common.message')

    <div class="tab-content" id="pills-tabContent">
        <div id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">

            <div class="row pt-3">
                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
                    <div class="card card-stats statistic-box mb-5">
                        <div class="card-header relative card-header-warning card-header-icon position-relative border-0 text-right px-3 py-0">
                            <div class="card-icon d-flex align-items-center justify-content-center card_img">
                                <i class="fas fa-tasks "></i>
                            </div>
                            <p class="card-category text-uppercase fs-10 font-weight-bold text-muted">{{localize('total_posts')}}</p>
                            <h3 class="card-title fs-18 font-weight-bold">{{$total_post}}
                                <small>{{localize('posts')}}</small>
                            </h3>
                        </div>
                        <div class="card-footer p-3">
                            <div class="stats">
                                <a target="_blank" href="{{ route('news.index') }}"><i class="typcn typcn-calendar-outline mr-2"></i>{{localize('total_posts')}}</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
                    <div class="card card-stats statistic-box mb-5">
                        <div class="card-header card-header-success card-header-icon position-relative border-0 text-right px-3 py-0">
                            <div class="card-icon d-flex align-items-center justify-content-center">
                                <i class="fas fa-comments"></i>
                            </div>
                            <p class="card-category text-uppercase fs-10 font-weight-bold text-muted">{{localize('total_comments')}}</p>
                            <h3 class="card-title fs-21 font-weight-bold">{{ $total_comments }}</h3>
                        </div>
                        <div class="card-footer p-3">
                            <div class="stats">
                                <a href="{{route('comments.comments_manage')}}" target="_blank"><i class="typcn typcn-calendar-outline mr-2"></i>{{localize('total_comments')}}</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
                    <div class="card card-stats statistic-box mb-5">
                        <div class="card-header card-header-danger card-header-icon position-relative border-0 text-right px-3 py-0">
                            <div class="card-icon d-flex align-items-center justify-content-center">
                                <i class="fas fa-users"></i>
                            </div>
                            <p class="card-category text-uppercase fs-10 font-weight-bold text-muted">{{localize('total_subscribers')}}</p>
                            <h3 class="card-title fs-21 font-weight-bold">{{$total_subscribers}}</h3>
                        </div>
                        <div class="card-footer p-3">
                            <div class="stats">
                                <a href="{{route('subscription.subscription_manage')}}" target="_blank"><i class="typcn typcn-calendar-outline mr-2"></i>{{localize('total_subscribers')}}</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
                    <div class="card card-stats statistic-box mb-5">
                        <div class="card-header card-header-info card-header-icon position-relative border-0 text-right px-3 py-0">
                            <div class="card-icon d-flex align-items-center justify-content-center">
                                <i class="fas fa-users"></i>
                            </div>
                            <p class="card-category text-uppercase fs-10 font-weight-bold text-muted">{{localize('total_users')}}</p>
                            <h3 class="card-title fs-21 font-weight-bold">{{$user->total_users}}</h3>
                        </div>
                        <div class="card-footer p-3">
                            <div class="stats">
                                <a href="{{ route('role.user.list') }}" target="_blank"><i class="typcn typcn-upload mr-2"></i>{{localize('total_users')}}</a> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                            
                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
                    <div class="card card-stats statistic-box mb-5">
                        <div class="card-header card-header-warning card-header-icon position-relative border-0 text-right px-3 py-0">
                            <div class="card-icon d-flex align-items-center justify-content-center">
                                <i class="fas fa-tasks"></i>
                            </div>
                            <p class="card-category text-uppercase fs-10 font-weight-bold text-muted">{{localize('todays_posts')}}</p>
                            <h3 class="card-title fs-18 font-weight-bold">{{$today_post}}
                                <small>{{localize('posts')}}</small>
                            </h3>
                        </div>
                        <div class="card-footer p-3">
                            <div class="stats">
                                <i class="typcn typcn-calendar-outline mr-2"></i>{{localize('todays_posts')}}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
                    <div class="card card-stats statistic-box mb-5">
                        <div class="card-header card-header-success card-header-icon position-relative border-0 text-right px-3 py-0">
                            <div class="card-icon d-flex align-items-center justify-content-center">
                                <i class="fas fa-comments"></i>
                            </div>
                            <p class="card-category text-uppercase fs-10 font-weight-bold text-muted">{{localize('todays_comments')}}</p>
                            <h3 class="card-title fs-21 font-weight-bold">{{$today_comments}}</h3>
                        </div>
                        <div class="card-footer p-3">
                            <div class="stats">
                                <i class="typcn typcn-calendar-outline mr-2"></i>{{localize('todays_comments')}}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
                    <div class="card card-stats statistic-box mb-5">
                        <div class="card-header card-header-danger card-header-icon position-relative border-0 text-right px-3 py-0">
                            <div class="card-icon d-flex align-items-center justify-content-center">
                                <i class="fas fa-users"></i>
                            </div>
                            <p class="card-category text-uppercase fs-10 font-weight-bold text-muted">{{localize('todays_subscribers')}}</p>
                            <h3 class="card-title fs-21 font-weight-bold">{{$today_subscribers}}</h3>
                        </div>
                        <div class="card-footer p-3">
                            <div class="stats">
                                <i class="typcn typcn-calendar-outline mr-2"></i>{{localize('todays_subscribers')}}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
                    <div class="card card-stats statistic-box mb-5">
                        <div class="card-header card-header-success card-header-icon position-relative border-0 text-right px-3 py-0">
                            <div class="card-icon d-flex align-items-center justify-content-center">
                                <i class="fas fa-user-tie"></i>
                            </div>
                            <p class="card-category text-uppercase fs-10 font-weight-bold text-muted">{{localize('total_reporters')}}</p>
                            <h3 class="card-title fs-21 font-weight-bold">{{$user->total_reporter}}</h3>
                        </div>
                        <div class="card-footer p-3">
                            <div class="stats">
                                <i class="typcn typcn-calendar-outline mr-2"></i>{{localize('total_reporters')}}
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-4">
                    <div class="card">
                        <div class="card-header">
                        <h6 class="fs-17 font-weight-600 mb-0">{{ucwords(localize('last_week_performance'))}}</h6>
                        </div>
                        <div class="card-body">
                        <div id="donut_Chart"></div>
                        </div>
                    </div>
                </div>
                <div class="col-8">
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
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-6">
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
                </div>
                <div class="col-6">
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
                </div>
            </div>

        </div>
    </div>

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