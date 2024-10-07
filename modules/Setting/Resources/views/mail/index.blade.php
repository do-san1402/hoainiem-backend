@extends('setting::settings')
@section('title', localize('mail_setup'))
@push('css')
@endpush

@section('setting_content')


    <!--/.Content Header (Page header)-->
    <div class="body-content pt-0">
        <div class="row">
            <div class="col-md-12 col-lg-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="fs-17 fw-semi-bold mb-0">{{ localize('mail_setup') }}</h6>
                            </div>
                        </div>
                    </div>
                    <form action="{{ route('mails.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="{{ @$mail->id }}">

                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    @input(['input_name' => 'protocol', 'value' => @$mail->protocol])
                                    @input(['input_name' => 'smtp_port', 'value' => @$mail->smtp_port])
                                    @input(['input_name' => 'smtp_pass', 'value' => @$mail->smtp_pass])
                                </div>
                                <div class="col-md-6">
                                    @input(['input_name' => 'smtp_host', 'value' => @$mail->smtp_host])
                                    @input(['input_name' => 'smtp_user', 'value' => @$mail->smtp_user])
                                    <div class="form-group mb-2 mx-0 row">
                                        <label class="col-sm-3 col-form-label ps-0">{{ localize('mail_type') }}<span
                                                class="text-danger">*</span></label>
                                        <div class="col-lg-9">
                                            <select name="mailtype" id="mailtype"
                                                class="form-control {{ $errors->first('mailtype') ? 'is-invalid' : '' }} form-control">
                                                <option value="html" {{ @$mail->mailtype == 'html' ? 'selected' : '' }}>
                                                    {{ localize('html') }}</option>
                                                <option value="text" {{ @$mail->mailtype == 'text' ? 'selected' : '' }}>
                                                    {{ localize('text') }}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer form-footer text-start">
                            <button type="submit" class="btn btn-primary btn-sm ">{{ localize('submit') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
@endpush
