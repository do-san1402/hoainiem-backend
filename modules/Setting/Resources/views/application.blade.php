@extends('setting::settings')
@section('title', localize('application'))
@push('css')
@endpush

@section('setting_content')

    <!--/.Content Header (Page header)-->
    <div class="body-content pt-0">
        <div class="card mb-4">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="fs-17 fw-semi-bold mb-0">{{ __('Edit Application') }}</h6>
                    </div>
                </div>
            </div>

            <form action="{{ route('applications.update', $app->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8 col-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-2">
                                        <label for="title" class="col-form-label">{{ localize('title') }}<span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="title" name="title"
                                            value="{{ $app->title }}" required>

                                        @if ($errors->has('title'))
                                            <div class="error text-danger">
                                                {{ $errors->first('title') }}</div>
                                        @endif
                                    </div>
                                    <div class="form-group mb-2">
                                        <label for="phone" class="col-form-label">{{ localize('phone') }}<span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="phone" name="phone"
                                            value="{{ $app->phone }}" required>

                                        @if ($errors->has('phone'))
                                            <div class="error text-danger">
                                                {{ $errors->first('phone') }}</div>
                                        @endif
                                    </div>
                                    <div class="form-group mb-2">
                                        <label for="address" class="col-form-label">{{ localize('address') }}<span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="address" name="address"
                                            value="{{ $app->address }}" required>
                                        @if ($errors->has('address'))
                                            <div class="error text-danger">
                                                {{ $errors->first('address') }}</div>
                                        @endif
                                    </div>
                                    <div class="form-group mb-2">
                                        <label for="website" class="col-form-label">{{ localize('website') }}</label>
                                        <input type="text" class="form-control" id="website" name="website"
                                            value="{{ $app->website }}">
                                        @if ($errors->has('website'))
                                            <div class="error text-danger">
                                                {{ $errors->first('website') }}</div>
                                        @endif
                                    </div>

                                    <div class="form-group mb-2">
                                        <label for="copy_right"
                                            class="col-form-label">{{ localize('copy_right') }}</label>
                                            <textarea name="copy_right" id="copy_right" class="form-control" placeholder="{{ localize('copy_right') }}">{{ $app->copy_right }}</textarea>
                                        @if ($errors->has('copy_right'))
                                            <div class="error text-danger">
                                                {{ $errors->first('copy_right') }}</div>
                                        @endif
                                    </div>

                                    <div class="form-group mb-2">
                                        <label for="preloader_status"
                                            class="col-form-label">{{ localize('preloader_status') }}</label>

                                        <select name="preloader_status" id="preloader_status" class="select-basic-single">
                                            <option value="" disabled>{{ localize('preloader_status') }}</option>
                                            <option value="1" {{ $app->preloader_status == '1' ? 'selected' : '' }}>
                                                {{ localize('enable') }}
                                            </option>
                                            <option value="0" {{ $app->preloader_status == '0' ? 'selected' : '' }}>
                                                {{ localize('disable') }}
                                            </option>
                                        </select>

                                        @if ($errors->has('preloader_status'))
                                            <div class="error text-danger">
                                                {{ $errors->first('preloader_status') }}</div>
                                        @endif
                                    </div>

                                    <div class="form-group mb-2">
                                        <label for=""
                                            class="form-check-label text-start ps-0 pb-1">{{ localize('fixed_date') }}</label>
                                        <div class="toggle-example">
                                            <input type="checkbox" id="fixed_date"
                                                {{ $app != null && $app->fixed_date == true ? 'checked' : '' }}
                                                data-bs-toggle="toggle" data-on="Enable" data-off="Disable"
                                                data-onstyle="success" data-offstyle="danger">
                                        </div>
                                    </div>

                                    <div class="form-group mb-2 fixed_date_show">
                                        <span>Please fixed your sale date</span>
                                        <input type="text" class="form-control date_picker" name="fixed_date" required
                                            placeholder=" {{ localize('select_date') }}" value="{{ $app->fixed_date }}">

                                        @if ($errors->has('fixed_date'))
                                            <div class="error text-danger">
                                                {{ $errors->first('fixed_date') }}</div>
                                        @endif
                                    </div>

                                    <div class="form-group mb-2">
                                        <label for=""
                                            class="col-form-label fw-semibold">{{ localize('favicon') }}</label>
                                        <input type="button" id="removeFavicon" value="x" class="remove-icon d-none" />
                                        <img id="favicon_preview" src="{{ app_setting()->favicon }}"
                                            data-default_src="{{ app_setting()->favicon }}" class="img-thumbnail"
                                            alt="Sidebar-Logo-Preview" />

                                        <div class="input-group">
                                            <input type="file" class="form-control" name="favicon" id="favicon">
                                            <label class="input-group-text" for="favicon">{{ localize('upload') }}</label>

                                            @if ($errors->has('favicon'))
                                                <div class="error text-danger">
                                                    {{ $errors->first('favicon') }}</div>
                                            @endif
                                        </div>
                                        <span>Recommended pixel (60 X 60)</span>
                                    </div>

                                    
                                    
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-2">
                                        <label for="email" class="col-form-label">{{ localize('email_address') }}<span
                                                class="text-danger">*</span></label>
                                        <input type="email" class="form-control" id="email" name="email"
                                            value="{{ $app->email }}" required>

                                        @if ($errors->has('email'))
                                            <div class="error text-danger">
                                                {{ $errors->first('email') }}</div>
                                        @endif
                                    </div>
                                    <div class="form-group mb-2">
                                        <label for="footer_text"
                                            class="col-form-label">{{ localize('footer_text') }}<span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="footer_text" required
                                            value="{{ $app->footer_text }}">

                                        @if ($errors->has('footer_text'))
                                            <div class="error text-danger">
                                                {{ $errors->first('footer_text') }}</div>
                                        @endif
                                    </div>

                                    <div class="form-group mb-2">
                                        <label for="" class="col-form-label">{{ localize('direction') }}</label>
                                        <select name="rtl_ltr" id="rtl_ltr" class="select-basic-single" required>
                                            <option value="" selected disabled>{{ localize('select_one') }}
                                            </option>
                                            <option value="1" {{ $app->rtl_ltr == 1 ? 'selected' : '' }}> LTR
                                            </option>
                                            <option value="2" {{ $app->rtl_ltr == 2 ? 'selected' : '' }}> RTL
                                            </option>
                                        </select>
                                    </div>

                                    <div class="form-group mb-2">
                                        <label for="time_zone" class="col-form-label">{{ localize('time_zone') }}<span
                                                class="text-danger">*</span></label>
                                        <select name="time_zone" id="time_zone" class="select-basic-single" required>
                                            <option value="" disabled>{{ localize('time_zone') }}</option>
                                            @foreach (timezone_identifiers_list() as $value)
                                                <option value="{{ $value }}" {{ $app->time_zone == $value ? 'selected' : '' }}>
                                                    {{ htmlspecialchars($value, ENT_QUOTES, 'UTF-8') }}
                                                </option>
                                            @endforeach
                                        </select>

                                        @if ($errors->has('time_zone'))
                                            <div class="error text-danger">
                                                {{ $errors->first('time_zone') }}</div>
                                        @endif
                                    </div>

                                    <div class="form-group mb-2">
                                        <label for="newstriker_status"
                                            class="col-form-label">{{ localize('news_tricker_status') }}</label>

                                        <select name="newstriker_status" id="newstriker_status" class="select-basic-single">
                                            <option value="" disabled>{{ localize('news_tricker_status') }}</option>
                                            <option value="1" {{ $app->newstriker_status == '1' ? 'selected' : '' }}>
                                                {{ localize('enable') }}
                                            </option>
                                            <option value="0" {{ $app->newstriker_status == '0' ? 'selected' : '' }}>
                                                {{ localize('disable') }}
                                            </option>
                                        </select>
                                        
                                        @if ($errors->has('newstriker_status'))
                                            <div class="error text-danger">
                                                {{ $errors->first('newstriker_status') }}</div>
                                        @endif
                                    </div>

                                    <div class="form-group mb-2">
                                        <label for="speed_optimization"
                                            class="col-form-label">{{ localize('speed_optimization') }}</label>
                                        
                                        <select name="speed_optimization" id="speed_optimization" class="select-basic-single">
                                            <option value="" disabled>{{ localize('speed_optimization') }}</option>
                                            <option value="1" {{ $app->speed_optimization == '1' ? 'selected' : '' }}>
                                                {{ localize('yes') }}
                                            </option>
                                            <option value="0" {{ $app->speed_optimization == '0' ? 'selected' : '' }}>
                                                {{ localize('no') }}
                                            </option>
                                        </select>

                                        @if ($errors->has('speed_optimization'))
                                            <div class="error text-danger">
                                                {{ $errors->first('speed_optimization') }}</div>
                                        @endif
                                    </div>

                                    <div class="form-group mb-2">
                                        <label for=""
                                            class="col-form-label fw-semibold">{{ localize('login_image') }}</label>

                                        <input type="button" id="loginImage" value="x" class="remove-icon d-none" />
                                        <img id="login_image_preview" src="{{ app_setting()->login_image }}"
                                            data-default_src="{{ app_setting()->login_image }}" class="img-thumbnail"
                                            alt="Login-Image-Preview" />

                                        <div class="input-group">
                                            <input type="file" class="form-control" name="login_image" id="login_image">
                                            <label class="input-group-text" for="login_image">{{ localize('upload') }}</label>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>
                        <div class="col-md-4 col-12">
                            <div class="form-group mb-2">
                                <label for="" class="col-form-label fw-semibold">{{ localize('logo') }}</label>
                                <input type="button" id="removeLogo" value="x" class="remove-icon d-none" />
                                <img id="logo_preview" src="{{ app_setting()->logo }}"
                                    data-default_src="{{ app_setting()->logo }}" class="img-thumbnail"
                                    alt="Logo-Preview" />

                                <div class="input-group">
                                    <input type="file" class="form-control" name="logo" id="logo">
                                    <label class="input-group-text" for="logo">{{ localize('upload') }}</label>

                                    @if ($errors->has('image'))
                                        <div class="error text-danger">
                                            {{ $errors->first('image') }}</div>
                                    @endif
                                </div>
                                <span>Recommended pixel (135 X 45)</span>
                            </div>

                            <div class="form-group mb-2">
                                <label for=""
                                    class="col-form-label fw-semibold">{{ localize('sidebar_logo') }}</label>

                                <input type="button" id="sidebarLogo" value="x" class="remove-icon d-none" />
                                <img id="sidebar_logo_preview" src="{{ app_setting()->sidebar_logo }}"
                                    data-default_src="{{ app_setting()->sidebar_logo }}" class="img-thumbnail"
                                    alt="Sidebar-Logo-Preview" />

                                <div class="input-group">
                                    <input type="file" class="form-control" name="sidebar_logo" id="sidebar_logo">
                                    <label class="input-group-text" for="sidebar_logo">{{ localize('upload') }}</label>
                                </div>
                                <span>Recommended pixel (150 X 45)</span>
                            </div>

                            <div class="form-group mb-2">
                                <label for=""
                                    class="col-form-label fw-semibold">{{ localize('footer_logo') }}</label>

                                <input type="button" id="footerLogo" value="x" class="remove-icon d-none" />
                                <img id="footer_logo_preview" src="{{ app_setting()->footer_logo }}"
                                    data-default_src="{{ app_setting()->footer_logo }}" class="img-thumbnail"
                                    alt="Footer-Logo-Preview" />

                                <div class="input-group">
                                    <input type="file" class="form-control" name="footer_logo" id="footer_logo">
                                    <label class="input-group-text" for="footer_logo">{{ localize('upload') }}</label>
                                </div>
                                <span>Recommended pixel (150 X 45)</span>
                            </div>

                            <div class="form-group mb-2">
                                <label for=""
                                    class="col-form-label fw-semibold">{{ localize('app_logo') }}</label>

                                <input type="button" id="appLogo" value="x" class="remove-icon d-none" />
                                <img id="app_logo_preview" src="{{ app_setting()->app_logo }}"
                                    data-default_src="{{ app_setting()->app_logo }}" class="img-thumbnail"
                                    alt="App-Logo-Preview" />

                                <div class="input-group">
                                    <input type="file" class="form-control" name="app_logo" id="app_logo">
                                    <label class="input-group-text" for="app_logo">{{ localize('upload') }}</label>
                                </div>
                                <span>Recommended pixel (150 X 45)</span>
                            </div>

                            <div class="form-group mb-2">
                                <label for=""
                                    class="col-form-label fw-semibold">{{ localize('mobile_menu_image') }}</label>

                                <input type="button" id="mobileMenuImage" value="x" class="remove-icon d-none" />
                                <img id="mobile_menu_image_preview" src="{{ app_setting()->mobile_menu_image }}"
                                    data-default_src="{{ app_setting()->mobile_menu_image }}" class="img-thumbnail"
                                    alt="Mobile-Menu-Image-Preview" />

                                <div class="input-group">
                                    <input type="file" class="form-control" name="mobile_menu_image" id="mobile_menu_image">
                                    <label class="input-group-text" for="mobile_menu_image">{{ localize('upload') }}</label>
                                </div>
                                <span>Recommended pixel (150 X 45)</span>
                            </div>

                            <div class="form-group mb-2">
                                <label for=""
                                    class="col-form-label fw-semibold">{{ localize('sidebar_collapsed_logo') }}</label>

                                <input type="button" id="sidebarCollapsedLogo" value="x"
                                    class="remove-icon d-none" />
                                <img id="sidebar_collapsed_logo_preview"
                                    src="{{ app_setting()->sidebar_collapsed_logo }}"
                                    data-default_src="{{ app_setting()->sidebar_collapsed_logo }}" class="img-thumbnail"
                                    alt="Sidebar-Collapsed-Logo-Preview" />

                                <div class="input-group">
                                    <input type="file" class="form-control" name="sidebar_collapsed_logo"
                                        id="sidebar_collapsed_logo">
                                    <label class="input-group-text"
                                        for="sidebar_collapsed_logo">{{ localize('upload') }}</label>
                                </div>
                                <span>Recommended pixel (90px X 90px)</span>
                            </div>

                            
                        </div>
                    </div>
                </div>
                <div class="card-footer form-footer">
                    <button type="submit" class="btn btn-success">{{ localize('submit') }}</button>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('js')
    <script src="{{ module_asset('Setting/js/app.js') }}"></script>
@endpush
