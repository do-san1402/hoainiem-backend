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
                                    <a href="{{ route('setting.localize.languagelist') }}" class="btn btn-success btn-sm"><i
                                            class="fa fa-list"></i>&nbsp;Language List</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('setting.localize.lanstrvaluestore') }}">
                        @csrf
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example" class="table display table-bordered table-hover text-center">
                                    <thead>
                                        <tr>
                                            <th>Sl</th>
                                            <th>Lang String</th>
                                            <th>Value</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($langstringValues as $key => $data)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td class="align-middle">{{ $data->langstring->key }}</td>
                                                <td class="text-center">
                                                    <input type="text" class="align-middle w-75" name="lanstrvalue[]"
                                                        value="{{ $data->value }}">
                                                    <input type="hidden" name="lanstrvalueid[]"
                                                        value="{{ $data->id }}">
                                                    <input type="hidden" name="localizeid[]"
                                                        value="{{ $data->localize_id }}">
                                                    <input type="hidden" name="langstringid[]"
                                                        value="{{ $data->langstring_id }}">
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Sl</th>
                                            <th>Lang String</th>
                                            <th>Value</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            {{ $langstringValues->links() }}
                        </div>
                        <div class="card-footer form-footer text-end">
                            <input type="hidden" id="lanfolder" name="lanfolder" value="{{ $lanfolder }}">
                            <button type="submit" class="btn btn-success">{{ localize('update') }}</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection
