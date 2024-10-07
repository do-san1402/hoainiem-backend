@extends('backend.layouts.app')
@section('title', localize('country_list'))
@section('content')
    <!--/.Content Header (Page header)-->
    <div class="body-content">
        @include('backend.layouts.common.validation')
        <div class="card mb-4">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="fs-17 fw-semi-bold mb-0">{{ localize('country_list') }}</h6>
                    </div>
                    <div class="text-end">
                        <div class="actions">

                            <a href="#" class="btn btn-success btn-sm" data-bs-toggle="modal"
                                data-bs-target="#create-country"><i
                                    class="fa fa-plus-circle"></i>&nbsp;{{ localize('add_country') }}</a>
                            @include('humanresource::country.modal.create')
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example" class="table display table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th width="10%">{{ localize('sl') }}</th>
                                <th width="15%">{{ localize('country_name') }}</th>
                                <th width="15%">{{ localize('country_code') }}</th>
                                <th width="10%">{{ localize('status') }}</th>
                                <th width="10%">{{ localize('action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($countries as $key => $country)
                                <tr>
                                    <td>#{{ $key + 1 }}</td>
                                    <td>{{ $country->country_name }}</td>
                                    <td>{{ $country->country_code }}</td>
                                    <td>
                                        @if ($country->is_active == 1)
                                            <span class="badge bg-success">{{ localize('status') }}</span>
                                        @elseif($country->is_active == 0)
                                            <span class="badge bg-danger">{{ localize('inactive') }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="#" class="btn btn-primary-soft btn-sm me-1" data-bs-toggle="modal"
                                            data-bs-target="#update-country-{{ $country->id }}" title="Edit"><i
                                                class="fa fa-edit"></i></a>

                                        <a href="javascript:void(0)" class="btn btn-danger-soft btn-sm delete-confirm"
                                            data-bs-toggle="tooltip" title="Delete"
                                            data-route="{{ route('countries.destroy', $country->uuid) }}"
                                            data-csrf="{{ csrf_token() }}"><i class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                                @include('humanresource::country.modal.edit')
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!--/.body content-->
@endsection
