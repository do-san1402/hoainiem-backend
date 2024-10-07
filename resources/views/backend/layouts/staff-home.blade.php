@extends('backend.layouts.app')
@section('title', localize('dashboard'))
@push('css')
@endpush
@section('content')

    @include('backend.layouts.common.message')
    <div class="tab-content" id="pills-tabContent">
    </div>
@endsection
@push('js')
@endpush
