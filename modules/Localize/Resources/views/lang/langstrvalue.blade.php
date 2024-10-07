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
                                <h6 class="fs-17 fw-semi-bold mb-0">{{ localize('language_phrase_update') }}
                                    ({{ $langName }})</h6>
                            </div>
                            <div class="text-end">
                                <div class="actions">
                                    <a href="{{ route('setting.language.languagelist') }}" class="btn btn-success btn-sm"><i
                                            class="fa fa-list"></i>&nbsp;{{ localize('Language List') }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('setting.language.lanstrvaluestore') }}">
                        @csrf
                        <div class="card-body">

                            <div class="table_customize">
                                <table class="table display table-bordered table-striped table-hover align-middle text-end"
                                    id="lang_table">
                                    <thead class="align-middle">
                                        <tr>
                                            <th class="text-center">{{ localize('sl') }}</th>
                                            <th class="text-center">{{ localize('lang_string') }}</th>
                                            <th class="text-center">{{ localize('value') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="card-footer form-footer text-end">
                            <input type="hidden" id="lanfolder" name="lanfolder" value="{{ $lanfolder }}">
                            <input type="hidden" id="id" value="{{ $id }}">
                            <button type="submit" class="btn btn-success">{{ localize('update') }}</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ module_asset('Localize/js/lang.min.js') }}"></script>
@endpush
