@extends('dashboard.app')
@push('css')
@endpush
@section('content')
  <!--Content Header (Page header)-->
  <div class="content-header row align-items-center g-0">
    <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last text-sm-end mb-3 mb-sm-0">
        <ol class="breadcrumb rounded d-inline-flex fw-semi-bold fs-13 bg-white mb-0 shadow-sm">
            <li class="breadcrumb-item"><a href="#">{{ __('default.Home') }}</a></li>
            <li class="breadcrumb-item"><a href="#">{{ __('Language') }}</a></li>
            <li class="breadcrumb-item active">{{ __('Language') }} / {{ __('Phrase') }}</li>
        </ol>
    </nav>
    <div class="col-sm-8 header-title">
        <div class="d-flex align-items-center">
            <div class="header-icon d-flex align-items-center justify-content-center rounded shadow-sm text-success flex-shrink-0">
                <i class="typcn typcn-document-text"></i>
            </div>
            <div class="">
                <h1 class="fw-bold">{{ __('Language Management') }}</h1>
            </div>
        </div>
    </div>
</div>
<!--/.Content Header (Page header)-->
<div class="body-content">
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="card mb-4">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="fs-17 fw-semi-bold mb-0">{{ __('Language') }} : {{$lang->title}}</h6>
                        </div>
                        <div class="text-end">
                            <div class="actions">
                                 
                                <a href="{{ route('settings.index') }}" class="btn btn-success btn-sm"><i class="fa fa-list"  ></i>&nbsp{{__('Language List')}}</a>
                                @include('setting::modal.lang_modal')
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="offset-md-9 col-md-3 mb-3 ">
                            <form action="" method="GET" class="mr-0 form-check-inline d-flex float-right" >
                                <input type="text" name="key" class="form-control" placeholder="search here">                                
                                <button type="submit" class="btn btn-primary"> Search </button>
                            </form>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <form action="{{ route('lang.update',$lang->slug) }}" method="post">
                            @csrf
                            <table id="example" class="table display table-bordered table-sm  table-hover text-center">
                                    <tr class="role-header">
                                        <th>Phrase</th>
                                        <th>Label</th>
                                    </tr>
                                        @foreach($results as $key => $label)
                                        <tr>
                                            <td><input type="text" name="key[]" value="{{ $key }}" readonly class="form-control"></td>
                                            <td><input type="text" name="label[]" value="{{$label}}" class="form-control"></td>
                                        </tr>
                                        @endforeach
                            </table>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary btn-sm text-right">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@push('js')
 <script src="{{ asset('vendor/user/assets/sweetalert-script.js') }}"></script>
@endpush

