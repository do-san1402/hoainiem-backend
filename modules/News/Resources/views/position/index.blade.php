@extends('backend.layouts.app')
@section('title', localize('positioning'))
@push('css')
@endpush
@section('content')
    @include('backend.layouts.common.validation')
    @include('backend.layouts.common.message')
    <div class="card mb-4">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="fs-17 fw-semi-bold mb-0">{{ localize('positioning') }}</h6>
                </div>
                <div class="float-right">

                </div>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('news.position.index') }}" method="get" id="search-position-form" data-position-delete-route="{{ route('news.position.destroy', ['news_position' => ':news_position_id']) }}">
                <div class="row fw-bold text-capitalize">
                    <div class="col-xl-6 col-12">
                        <label>{{ localize('category') }}:</label>
                        <select name="other_page" id="other_page" class="form-control select-basic-single"
                            data-placeholder="{{ localize_uc('select_category') }}" data-allow-clear="true">
                            <option value=""></option>
                            <option value="home">{{ localize('home') }}</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->slug }}">
                                    {{ $category->category_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-xl-2 col-md-2 align-self-end">
                        <button type="submit" class="btn btn-success">{{ localize('Search') }}</button>
                        <button type="reset" class="btn btn-danger">{{ localize('reset') }}</button>
                    </div>
                </div>
            </form>
            <div class="table_customize">
                @can('update_positioning')
                    <form action="{{ route('news.position.update') }}" class="needs-validation" data="showCallBackUpdateData"
                        id="newsPositionForm" novalidate="" method="POST" data-resetvalue="false"
                        enctype="multipart/form-data">
                        @csrf
                        @method('patch')

                        <div class="text-end">
                            <input type="submit" value="{{ localize('update') }}" class="btn btn-success btn-sm">
                        </div>
                    @endcan

                    <table class="table table-bordered table-hover" id="news-position-table">
                        <thead>
                            <tr>
                                <th width="80%">{{ localize('title') }}</th>
                                <th width="10%">{{ localize('position') }}</th>
                                <th width="10%">{{ localize('action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($newsPositions as $newsPosition)
                                @if ($newsPosition->newsMst)
                                    <tr>
                                        <td>{{ $newsPosition->newsMst->title ?? null }}</td>
                                        <td>
                                            <input type="number" name="position[{{ $newsPosition->id }}]"
                                                value="{{ $newsPosition->position }}" class="form-control">
                                        </td>
                                        <td>
                                            <button class="btn btn-danger delete-news-position" type="button"
                                                data-action="{{ route('news.position.destroy', ['news_position' => $newsPosition->id]) }}">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                    @can('update_positioning')
                    </form>
                @endcan
            </div>
        </div>
    @endsection
    @push('js')
        <script src="{{ module_asset('News/js/news/position.js') }}"></script>
    @endpush
