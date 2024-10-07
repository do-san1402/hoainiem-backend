@extends('setting::settings')
@section('title', localize('language_list'))
@section('setting_content')
    <!--/.Content Header (Page header)-->
    <div class="body-content pt-0">
        <div class="row">
            <div class="col-md-12 col-lg-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="fs-17 fw-semi-bold mb-0">{{ localize('language_list') }}</h6>
                            </div>
                            <div class="text-end">
                                <div class="actions">

                                    <a href="#" class="btn btn-success btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#addLanguage"><i
                                            class="fa-sharp fa-solid fa-circle-plus"></i>&nbsp;{{ localize('Add Language') }}</a>
                                    @include('localize::lang.languageAdd')
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
                                        <th width="10%">Sl</th>
                                        <th width="20%">{{ localize('name') }}</th>
                                        <th width="20%">{{ localize('code') }}</th>
                                        <th width="10%">{{ localize('action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($languageList as $key => $data)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $data->langname }}</td>
                                            <td>{{ $data->value }}</td>
                                            <td class="text-center">
                                                <a title="Edit"
                                                    href="{{ route('setting.language.languageStringValueindex', $data->id) }}"
                                                    class="btn btn-primary btn-sm">{{ localize('String') }} <i
                                                        class="fa fa-edit"></i></a>
                                                @if ($data->value != 'en')
                                                    <a title="Delete" href="javascript:void(0)"
                                                        class="btn btn-danger btn-sm delete-confirm"
                                                        data-route="{{ route('setting.language.langDestroy', $data->id) }}"
                                                        data-csrf="{{ csrf_token() }}"><i class="fa fa-trash"></i></a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th width="10%">Sl</th>
                                        <th width="20%">{{ localize('name') }}</th>
                                        <th width="20%">{{ localize('code') }}</th>
                                        <th width="10%">{{ localize('action') }}</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        {{ $languageList->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="{{ module_asset('Localize/js/lang.js') }}"></script>
@endpush
