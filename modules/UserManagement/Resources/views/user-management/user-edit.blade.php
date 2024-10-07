<form id="editUserForm" class="validateEditForm" action="{{ route('role.user.update', $user->id) }}" method="POST"
    enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="id" id="id" value="{{ $user->id }}">
    <div class="modal-body">
        <div class="row">
            <div class="col-md-12 mt-3">
                <div class="row">
                    <label for="full_name"
                        class="col-form-label col-sm-3 col-md-12 col-xl-3 fw-semibold">{{ localize('full_name') }}
                        <span class="text-danger">*</span></label>
                    <div class="col-sm-9 col-md-12 col-xl-9">
                        <input type="text" class="form-control" id="full_name" name="full_name"
                            value="{{ $user->full_name }}">
                        <span class="text-danger error_full_name"></span>
                    </div>
                </div>
            </div>
            <div class="col-md-12 mt-3">
                <div class="row">
                    <label for="email"
                        class="col-form-label col-sm-3 col-md-12 col-xl-3 fw-semibold">{{ localize('email') }}<span
                            class="text-danger">*</span></label>
                    <div class="col-sm-9 col-md-12 col-xl-9">
                        <input type="text" class="form-control" id="email" name="email"
                            value="{{ $user->email }}">
                        <span class="text-danger error_email"></span>
                    </div>

                </div>
            </div>
            <div class="col-md-12 mt-3">
                <div class="row">
                    <label for="contact_no"
                        class="col-form-label col-sm-3 col-md-12 col-xl-3 fw-semibold">{{ localize('mobile') }}<span
                            class="text-danger">*</span></label>
                    <div class="col-sm-9 col-md-12 col-xl-9">
                        <input type="text" class="form-control" id="contact_no" name="contact_no"
                            value="{{ $user->contact_no }}">
                        <span class="text-danger error_contact_no"></span>
                    </div>

                </div>
            </div>
            <div class="col-md-12 text-start">
                <div class="row mt-3">
                    <label for="role_id"
                        class="col-form-label col-sm-3 col-md-12 col-xl-3 fw-semibold">{{ localize('role') }}<span
                            class="text-danger">*</span></label>
                    <div class="col-sm-9 col-md-12 col-xl-9">
                        <select name="role_id[]" id="role_id" multiple class="form-control select-basic-single">
                            @foreach ($roleList as $roleValue)
                                <option value="{{ $roleValue->id }}" @if (in_array($roleValue->id, $user->userRole->pluck('id')->toArray())) selected @endif>
                                    {{ $roleValue->name }}</option>
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
                        <select name="user_type_id" id="user_type_id" class="form-control select-basic-single">
                            @foreach ($userTypes as $item)
                                <option value="{{ $item->id }}" @selected($item->id == $user->user_type_id)>{{ $item->user_type_title }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-12 mt-3">
                <div class="row">
                    <label for="password"
                        class="col-form-label col-sm-3 col-md-12 col-xl-3 fw-semibold">{{ localize('password') }}</label>
                    <div class="col-sm-9 col-md-12 col-xl-9">
                        <input type="password" class="form-control" id="password" name="password">
                        <span class="text-danger error_password"></span>
                    </div>

                </div>
            </div>
            <div class="col-md-12 mt-3">
                <div class="row">
                    <label for="profile_image"
                        class="col-form-label col-sm-3 col-md-12 col-xl-3 fw-semibold">{{ localize('profile_image') }}</label>
                    <div class="col-sm-9 col-md-12 col-xl-9">
                        <input type="file" class="form-control" id="profile_image" name="profile_image">
                        <span class="text-danger error_profile_image"></span>
                    </div>

                </div>
            </div>
            <div class="col-md-12 text-start">
                <div class="row mt-3">
                    <label for="status"
                        class="col-form-label col-sm-3 col-md-12 col-xl-3 fw-semibold">{{ localize('status') }}<span
                            class="text-danger">*</span></label>
                    <div class="col-sm-9 col-md-12 col-xl-9">
                        <select name="status" id="status" class="form-control" required>
                            <option value="1" @if ($user->is_active == 1) selected @endif>
                                {{ localize('active') }}</option>
                            <option value="0" @if ($user->is_active == 0) selected @endif>
                                {{ localize('inactive') }}</option>

                        </select>
                        <span class="text-danger error_status"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">{{ localize('close') }}</button>
        <button class="btn btn-success">{{ localize('update') }}</button>
    </div>
</form>
<script src="{{ module_asset('UserManagement/js/userEdit.js?v=1') }}"></script>
