@extends('setting::settings')
@section('title', localize('language_string_list'))
@section('setting_content')
    <!--/.Content Header (Page header)-->
    <div class="body-content pt-0">
        <div class="row">
            <div class="col-md-12 col-lg-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="fs-17 fw-semi-bold mb-0">{{ localize('language_string_list') }}</h6>
                            </div>
                            <div class="text-end">
                                <div class="actions">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example"
                                class="table display table-bordered table-striped table-hover text-center">
                                <thead>
                                    <tr>
                                        <th>localize('Si')</th>
                                        <th>localize('String Name')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $i = 1;
                                    @endphp
                                    @foreach ($datas as $key => $data)
                                        <tr>
                                            <td>{{ $i }}</td>
                                            <td>{{ $key }}</td>
                                        </tr>
                                        @php
                                            $i++;
                                        @endphp
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>localize('Si')</th>
                                        <th>localize('String Name')</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        {{ $datas->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ module_asset('Localize/js/lang.js') }}"></script>
@endpush
