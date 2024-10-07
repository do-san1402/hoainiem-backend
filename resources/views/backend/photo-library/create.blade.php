@extends('backend.layouts.app')
@section('title', localize_uc('add_new_news'))
@push('css')
    <link href="{{ asset('backend/assets/plugins/Bootstrap-5-Tag-Input/tagsinput.css') }}" rel="stylesheet">
@endpush

@section('content')
    @include('backend.layouts.common.message')
    <div class="tab-content" id="pills-tabContent">
        <div id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
            <div class="row g-4">
                <div class="col-md-12">
                    <div class="card mb-4">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="fs-17 font-weight-600 mb-0">
                                        {{ localize('insert_image') }}</h6>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('photo-library.store') }}" method="post" class="needs-validation"
                                data="showCallBackData" id="photo-library-form" novalidate=""
                                enctype="multipart/form-data">
                                @csrf
                                @include('backend.photo-library.form')
                                <div class="row">
                                    <div class="col-md-12 mt-3 text-start">
                                        <button type="reset" class="btn btn-danger" title="{{ localize('reset') }}">
                                            <i class="fa fa-undo-alt"></i>
                                        </button>
                                        <button type="submit" class="btn btn-success">
                                            {{ localize('upload_image') }}
                                        </button>
                                    </div>
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
    <script src="{{ asset('backend/assets/plugins/Bootstrap-5-Tag-Input/tagsinput.js') }}"></script>
    <script src="{{ asset('backend/assets/js/photo-library.js') }}"></script>
@endpush
