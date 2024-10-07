@extends('setting::settings')
@section('title', localize('currency_list'))
@section('setting_content')
    <!--/.Content Header (Page header)-->
    <div class="body-content pt-0">
        <div class="row">
            <div class="col-md-12 col-lg-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="fs-17 fw-semi-bold mb-0">{{ localize('currency_list') }}</h6>
                            </div>
                            <div class="text-end">
                                <div class="actions">
                                    @can('create_currency')
                                        <a href="{{ route('currencies.create') }}" class="btn btn-success btn-sm"><i
                                                class="fa fa-user-plus"></i>&nbsp{{ localize('add_currency') }}</a>
                                    @endcan
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example"
                                class="table display table-bordered table-sm table-striped table-hover text-center">
                                <thead>
                                    <tr>
                                        <th width="10%">{{ localize('sl') }}</th>
                                        <th width="20%">{{ localize('title') }}</th>
                                        <th width="20%">{{ localize('symbol') }}</th>
                                        <th width="20%">{{ localize('country') }}</th>
                                        <th width="20%">{{ localize('status') }}</th>
                                        <th width="10%">{{ localize('action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($currencies as $key => $currency)
                                        <tr>
                                            <td>#{{ $key + 1 }}</td>
                                            <td>{{ $currency->title }}</td>
                                            <td>{{ $currency->symbol }}</td>
                                            <td>{{ $currency->country ? $currency->country->country_name : '' }}</td>
                                            <td>
                                                @if ($currency->status == 1)
                                                    <span class="badge bg-success">{{ localize('active') }}</span>
                                                @else
                                                    <span class="badge bg-danger">{{ localize('inactive') }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex">
                                                    <a title="Edit" href="{{ route('currencies.edit', $currency->id) }}"
                                                        class="btn btn-primary btn-sm m-1"><i class="fa fa-edit"></i></a>
                                                    <a title="Delete" href="javascript:void(0)"
                                                        class="btn btn-danger btn-sm delete-confirm m-1"
                                                        data-route="{{ route('currencies.destroy', $currency->id) }}"
                                                        data-csrf="{{ csrf_token() }}"><i class="fa fa-trash"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th width="10%">{{ localize('sl') }}</th>
                                        <th width="20%">{{ localize('title') }}</th>
                                        <th width="20%">{{ localize('symbol') }}</th>
                                        <th width="20%">{{ localize('country') }}</th>
                                        <th width="20%">{{ localize('status') }}</th>
                                        <th width="10%">{{ localize('action') }}</th>
                                    </tr>
                                </tfoot>
                            </table>
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
