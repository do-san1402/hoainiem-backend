<div class="row ps-4 pe-4">

    <div class="col-md-12 mt-3">
        <div class="row">
            <div class="col-md-6">
                <div class="row form-group">
                    <div class="col-sm-12 col-md-12 col-xl-12">

                        <label for="name"
                        class="col-form-label fw-semibold">{{ localize('full_name') }}<span
                            class="text-danger">*</span></label>

                        <input type="text" class="form-control" id="name" name="name"
                        placeholder="{{ localize('name') }}" value="{{ old('name') }}" required>

                    </div>

                    @if ($errors->has('name'))
                        <div class="error text-danger m-2">{{ $errors->first('name') }}</div>
                    @endif

                </div>
            </div>

            <div class="col-md-6">
                <div class="row form-group">
                    <div class="col-sm-12 col-md-12 col-xl-12">

                        <label for="nick_name"
                            class="col-form-label fw-semibold">{{ localize('nick_name') }}</label>

                        <input type="text" class="form-control" id="nick_name" name="nick_name"
                        placeholder="{{ localize('nick_name') }}" value="{{ old('nick_name') }}">

                    </div>

                    @if ($errors->has('nick_name'))
                        <div class="error text-danger m-2">{{ $errors->first('nick_name') }}</div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12 mt-3">
        <div class="row">
            <div class="col-md-6">
                <div class="row form-group">
                    <div class="col-sm-12 col-md-12 col-xl-12">

                        <label for="mobile"
                        class="col-form-label fw-semibold">{{ localize('mobile') }}<span class="text-danger">*</span></label>

                        <input type="number" class="form-control" id="mobile" name="mobile"
                        placeholder="{{ localize('mobile') }}" value="{{ old('mobile') }}" required>

                    </div>

                    @if ($errors->has('mobile'))
                        <div class="error text-danger m-2">{{ $errors->first('mobile') }}</div>
                    @endif

                </div>
            </div>

            <div class="col-md-6">
                <div class="row form-group">
                    <div class="col-sm-12 col-md-12 col-xl-12">

                        <label for="email"
                            class="col-form-label fw-semibold">{{ localize('email') }}<span
                            class="text-danger">*</span></label>

                        <input type="email" class="form-control" id="email" name="email"
                        placeholder="{{ localize('email') }}" value="{{ old('email') }}" required>

                    </div>

                    @if ($errors->has('email'))
                        <div class="error text-danger m-2">{{ $errors->first('email') }}</div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12 mt-3">
        <div class="row">
            <div class="col-md-6">
                <div class="row form-group">
                    <div class="col-sm-12 col-md-12 col-xl-12">

                        <label for="password"
                        class="col-form-label fw-semibold">{{ localize('password') }}<span
                            class="text-danger">*</span></label>

                        <input type="password" class="form-control" id="password" name="password"
                        placeholder="{{ localize('password') }}" value="{{ old('password') }}" required>

                    </div>

                    @if ($errors->has('password'))
                        <div class="error text-danger m-2">{{ $errors->first('password') }}</div>
                    @endif

                </div>
            </div>

            <div class="col-md-6">
                <div class="row form-group">
                    <div class="col-sm-12 col-md-12 col-xl-12">

                        <label for="department"
                            class="col-form-label fw-semibold">{{ localize('department') }}<span
                            class="text-danger">*</span></label>

                        <select name="department_id" id="department_id" class="form-control" required>
                            <option value="">-{{ localize('select_department') }}-</option>
                            @foreach ($departments as $department)
                                <option value="{{ $department->id }}">{{ $department->department_name }}</option>
                            @endforeach
                        </select>

                    </div>

                    @if ($errors->has('department'))
                        <div class="error text-danger m-2">{{ $errors->first('department') }}</div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12 mt-3">
        <div class="row">
            <div class="col-md-6">
                <div class="row form-group">
                    <div class="col-sm-12 col-md-12 col-xl-12">

                        <label for="designation"
                        class="col-form-label fw-semibold">{{ localize('designation') }}<span
                            class="text-danger">*</span></label>

                        <input type="text" class="form-control" id="designation" name="designation"
                        placeholder="{{ localize('designation') }}" value="{{ old('designation') }}" required>

                    </div>

                    @if ($errors->has('designation'))
                        <div class="error text-danger m-2">{{ $errors->first('designation') }}</div>
                    @endif

                </div>
            </div>

            <div class="col-md-6">
                <div class="row form-group">
                    <div class="col-sm-12 col-md-12 col-xl-12">

                        <label for="access_category"
                            class="col-form-label fw-semibold">{{ localize('access_category') }}<span
                            class="text-danger">*</span></label>

                        <select name="user_type" id="user_type" class="form-control" required>
                            <option value="">-{{ localize('access_category') }}-</option>
                            <option value="4">{{ localize('admin') }}</option>
                            <option value="2">{{ localize('writer') }}</option>
                            <option value="1">{{ localize('moderator') }}</option>
                        </select>

                    </div>

                    @if ($errors->has('user_type'))
                        <div class="error text-danger m-2">{{ $errors->first('user_type') }}</div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12 mt-3">
        <div class="row">
            <div class="col-md-4">
                <div class="row form-group">
                    <div class="col-sm-12 col-md-12 col-xl-12">

                        <label for="sex"
                        class="col-form-label fw-semibold">{{ localize('sex') }}</label>

                        <select name="sex" id="sex" class="form-control">
                            <option value="">-{{ localize('select_gender') }}-</option>
                            <option value="Male">{{ localize('male') }}</option>
                            <option value="Female">{{ localize('female') }}</option>
                        </select>

                    </div>

                    @if ($errors->has('sex'))
                        <div class="error text-danger m-2">{{ $errors->first('sex') }}</div>
                    @endif

                </div>
            </div>

            <div class="col-md-4">
                <div class="row form-group">
                    <div class="col-sm-12 col-md-12 col-xl-12">

                        <label for="blood"
                            class="col-form-label fw-semibold">{{ localize('blood') }}</label>

                        <input type="text" class="form-control" id="blood" name="blood"
                        placeholder="{{ localize('blood') }}" value="{{ old('blood') }}">

                    </div>

                    @if ($errors->has('blood'))
                        <div class="error text-danger m-2">{{ $errors->first('blood') }}</div>
                    @endif
                </div>
            </div>

            <div class="col-md-4">
                <div class="row form-group">
                    <div class="col-sm-12 col-md-12 col-xl-12">

                        <label for="birth_date"
                            class="col-form-label fw-semibold">{{ localize('birth_date') }}</label>

                        <input type="text" class="form-control date_picker" id="birth_date" name="birth_date"
                        placeholder="{{ localize('birth_date') }}" value="{{ old('birth_date') }}">

                    </div>

                    @if ($errors->has('birth_date'))
                        <div class="error text-danger m-2">{{ $errors->first('birth_date') }}</div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12 mt-3">
        <div class="row">
            <div class="col-md-6">
                <div class="row form-group">
                    <div class="col-sm-12 col-md-12 col-xl-12">

                        <label for="address_line_one"
                        class="col-form-label fw-semibold">{{ localize('address_line_one') }}</label>

                        <input type="text" class="form-control" id="address_one" name="address_one"
                        placeholder="{{ localize('address_line_one') }}" value="{{ old('address_line_one') }}">

                    </div>

                    @if ($errors->has('address_line_one'))
                        <div class="error text-danger m-2">{{ $errors->first('address_line_one') }}</div>
                    @endif

                </div>
            </div>

            <div class="col-md-6">
                <div class="row form-group">
                    <div class="col-sm-12 col-md-12 col-xl-12">

                        <label for="address_line_two"
                            class="col-form-label fw-semibold">{{ localize('address_line_two') }}</label>

                        <input type="text" class="form-control" id="address_two" name="address_two"
                        placeholder="{{ localize('address_line_two') }}" value="{{ old('address_line_two') }}">

                    </div>

                    @if ($errors->has('address_line_two'))
                        <div class="error text-danger m-2">{{ $errors->first('address_line_two') }}</div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12 mt-3">
        <div class="row">
            <div class="col-md-4">
                <div class="row form-group">
                    <div class="col-sm-12 col-md-12 col-xl-12">

                        <label for="city"
                        class="col-form-label fw-semibold">{{ localize('city') }}</label>

                        <input type="text" class="form-control" id="city" name="city"
                        placeholder="{{ localize('city') }}" value="{{ old('city') }}">

                    </div>

                    @if ($errors->has('city'))
                        <div class="error text-danger m-2">{{ $errors->first('city') }}</div>
                    @endif

                </div>
            </div>

            <div class="col-md-4">
                <div class="row form-group">
                    <div class="col-sm-12 col-md-12 col-xl-12">

                        <label for="state"
                            class="col-form-label fw-semibold">{{ localize('state') }}</label>

                        <input type="text" class="form-control" id="state" name="state"
                        placeholder="{{ localize('state') }}" value="{{ old('state') }}">

                    </div>

                    @if ($errors->has('state'))
                        <div class="error text-danger m-2">{{ $errors->first('state') }}</div>
                    @endif
                </div>
            </div>

            <div class="col-md-4">
                <div class="row form-group">
                    <div class="col-sm-12 col-md-12 col-xl-12">

                        <label for="country"
                            class="col-form-label fw-semibold">{{ localize('country') }}</label>

                        <select name="country" id="country" class="form-control">
                            <option value="">-{{ localize('select_country') }}-</option>
                            @foreach ($countries as $country)
                                <option value="{{ $country->country_name }}">{{ $country->country_name }}</option>
                            @endforeach
                        </select>

                    </div>

                    @if ($errors->has('country'))
                        <div class="error text-danger m-2">{{ $errors->first('country') }}</div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12 mt-3">
        <div class="row">
            <div class="col-md-4">
                <div class="row form-group">
                    <div class="col-sm-12 col-md-12 col-xl-12">

                        <label for="zip"
                        class="col-form-label fw-semibold">{{ localize('zip') }}</label>

                        <input type="number" class="form-control" id="zip" name="zip"
                        placeholder="{{ localize('zip') }}" value="{{ old('zip') }}">

                    </div>

                    @if ($errors->has('zip'))
                        <div class="error text-danger m-2">{{ $errors->first('zip') }}</div>
                    @endif

                </div>
            </div>

            <div class="col-md-4">
                <div class="row form-group">
                    <div class="col-sm-12 col-md-12 col-xl-12">

                        <label for="verification_document_id"
                            class="col-form-label fw-semibold">{{ localize('verification_document_id') }}</label>

                        <input type="text" class="form-control" id="verification_id_no" name="verification_id_no"
                        placeholder="{{ localize('verification_document_id') }}" value="{{ old('verification_document_id') }}">

                    </div>

                    @if ($errors->has('verification_document_id'))
                        <div class="error text-danger m-2">{{ $errors->first('verification_document_id') }}</div>
                    @endif
                </div>
            </div>

            <div class="col-md-4">
                <div class="row form-group">
                    <div class="col-sm-12 col-md-12 col-xl-12">

                        <label for="verification_type"
                            class="col-form-label fw-semibold">{{ localize('verification_type') }}</label>

                        <select name="verification_type" id="verification_type" class="form-control">
                            <option value="">--{{ localize('select_verification_type') }}--</option>
                            <option value="Driver licence">{{localize('driver_license')}}</option>
                            <option value="National id">{{localize('national_id')}}</option>
                            <option value="Pasport id"> {{localize('passport_id')}} </option>
                        </select>

                    </div>

                    @if ($errors->has('verification_type'))
                        <div class="error text-danger m-2">{{ $errors->first('verification_type') }}</div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12 mt-3">
        <div class="row">
            <div class="col-md-12">
                <div class="row form-group">
                    <div class="col-sm-12 col-md-12 col-xl-12">

                        <label for="about"
                        class="col-form-label fw-semibold">{{ localize('about') }}</label>

                        <textarea  class="form-control" id="about" name="about"
                        placeholder="{{ localize('about') }}" rows ="5"></textarea>

                    </div>

                    @if ($errors->has('about'))
                        <div class="error text-danger m-2">{{ $errors->first('about') }}</div>
                    @endif

                </div>
            </div>
        </div>
    </div>

</div>
