<!-- Modal -->
<div class="modal fade" id="addUser" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">
                    {{ localize('new_user') }}
                </h5>
            </div>
            <form id="userForm" action="{{ route('role.user.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row text-start">

                        <div class="col-md-12 mb-3">
                            <div class="row">
                                <label for="full_name"
                                    class="col-form-label col-sm-3 col-md-12 col-xl-3 fw-semibold">{{ localize('full_name') }}<span
                                        class="text-danger">*</span></label>
                                <div class="col-sm-9 col-md-12 col-xl-9">
                                    <input type="text" class="form-control" id="full_name" name="full_name"
                                        value="{{ old('full_name') }}">
                                    <span class="text-danger error_full_name"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="row">
                                <label for="email"
                                    class="col-form-label col-sm-3 col-md-12 col-xl-3 fw-semibold">{{ localize('email') }}<span
                                        class="text-danger">*</span></label>
                                <div class="col-sm-9 col-md-12 col-xl-9">
                                    <input type="text" class="form-control" id="email" name="email"
                                        value="{{ old('email') }}">
                                    <span class="text-danger error_email"></span>
                                </div>

                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="row">
                                <label for="contact_no"
                                    class="col-form-label col-sm-3 col-md-12 col-xl-3 fw-semibold">{{ localize('mobile') }}<span
                                        class="text-danger">*</span></label>
                                <div class="col-sm-9 col-md-12 col-xl-9">
                                    <input type="text" class="form-control" id="contact_no" name="contact_no"
                                        value="{{ old('contact_no') }}">
                                    <span class="text-danger error_contact_no"></span>
                                </div>

                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="row">
                                <label for="role_id"
                                    class="col-form-label col-sm-3 col-md-12 col-xl-3 fw-semibold">{{ localize('role') }}<span
                                        class="text-danger">*</span></label>
                                <div class="col-sm-9 col-md-12 col-xl-9">
                                    <select name="role_id[]" id="role_id" multiple
                                        class="form-control select-basic-single">
                                        <option value="" disabled>{{ localize('select_one') }}</option>
                                        @foreach ($roleList as $roleValue)
                                            <option value="{{ $roleValue->id }}">{{ $roleValue->name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger error_role_id"></span>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="row">
                                <label for="user_type_id"
                                    class="col-form-label col-sm-3 col-md-12 col-xl-3 fw-semibold">{{ localize('user_type') }}<span
                                        class="text-danger">*</span></label>
                                <div class="col-sm-9 col-md-12 col-xl-9">
                                    <select name="user_type_id" id="user_type_id"
                                        class="form-control select-basic-single">
                                        <option value="">{{ localize('select_user_type') }}</option>
                                        @foreach ($userTypes as $item)
                                            <option value="{{ $item->id }}">{{ $item->user_type_title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="row">
                                <label for="password"
                                    class="col-form-label col-sm-3 col-md-12 col-xl-3 fw-semibold">{{ localize('password') }}<span
                                        class="text-danger">*</span></label>
                                <div class="col-sm-9 col-md-12 col-xl-9">
                                    <input type="password" class="form-control" id="password" name="password">
                                    <span class="text-danger error_password"></span>
                                </div>

                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="row">
                                <label for="profile_image"
                                    class="col-form-label col-sm-3 col-md-12 col-xl-3 fw-semibold">{{ localize('profile_image') }}</label>
                                <div class="col-sm-9 col-md-12 col-xl-9">
                                    <input type="file" class="form-control" id="profile_image" name="profile_image"
                                        value="{{ old('profile_image') }}">
                                    <span class="text-danger error_profile_image"></span>
                                </div>

                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="row">
                                <label for="profile_image"
                                    class="col-form-label col-sm-3 col-md-12 col-xl-3 fw-semibold">{{ localize('status') }}</label>
                                <div class="col-sm-9 col-md-12 col-xl-9">
                                    <select name="status" id="status" class="form-control" required>
                                        <option value="1" selected>{{ localize('active') }}</option>
                                        <option value="0">{{ localize('inactive') }}</option>

                                    </select>
                                    <span class="text-danger error_status"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger"
                        data-bs-dismiss="modal">{{ localize('close') }}</button>
                    <button class="btn btn-primary" type="submit">{{ localize('save') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
