@extends('backend.layouts.app')
@section('title', localize('dashboard'))
@push('css')
@endpush
@section('content')

    @include('backend.layouts.common.message')


    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="mb-4">
                        <form id="coverImageUploadForm" action="{{ route('profile_cover_image.update', Auth::user()->id) }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="user-profile-header-banner">
                                <img src="{{ Auth::user()->cover_image ? asset('storage/' . Auth::user()->cover_image) : asset('backend/assets/dist/img/cover.png') }}"
                                    alt="Banner image" id="cover_image_preview" class="rounded-top" />
                                <label for="coverImageUpload" class="cover-edit-btn label-upload" tabindex="0">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none">
                                        <path
                                            d="M12.3077 7.58386e-07H11.6017C9.21283 -3.00109e-05 7.2952 -6.07417e-05 5.78874 0.202493C4.22785 0.412339 2.92536 0.859724 1.89256 1.89256C0.859724 2.92536 0.412339 4.22785 0.202493 5.78874C-6.07417e-05 7.2952 -3.00109e-05 9.21283 7.58386e-07 11.6017V12.3983C-3.00109e-05 14.7872 -6.07417e-05 16.7048 0.202493 18.2113C0.412339 19.7722 0.859724 21.0746 1.89256 22.1075C2.92536 23.1403 4.22785 23.5877 5.78874 23.7975C7.29523 24.0001 9.21286 24 11.6017 24H12.3983C14.7871 24 16.7048 24.0001 18.2113 23.7975C19.7722 23.5877 21.0746 23.1403 22.1075 22.1075C23.1403 21.0746 23.5877 19.7722 23.7975 18.2113C24.0001 16.7048 24 14.7871 24 12.3983V11.6923C24 11.0126 23.449 10.4615 22.7692 10.4615C22.0895 10.4615 21.5385 11.0126 21.5385 11.6923V12.3077C21.5385 14.8083 21.5359 16.5599 21.3579 17.8833C21.1848 19.1712 20.8661 19.8677 20.3669 20.3669C19.8677 20.8661 19.1712 21.1848 17.8833 21.3579C16.5599 21.5359 14.8083 21.5385 12.3077 21.5385H11.6923C9.1917 21.5385 7.44006 21.5359 6.11674 21.3579C4.8288 21.1848 4.13234 20.8661 3.63311 20.3669C3.13388 19.8677 2.81523 19.1712 2.64206 17.8833C2.46416 16.5599 2.46154 14.8083 2.46154 12.3077V11.6923C2.46154 9.1917 2.46416 7.44006 2.64206 6.11674C2.81523 4.8288 3.13388 4.13234 3.63311 3.63311C4.13234 3.13388 4.8288 2.81523 6.11674 2.64206C7.44006 2.46416 9.1917 2.46154 11.6923 2.46154H12.3077C12.9874 2.46154 13.5385 1.91049 13.5385 1.23077C13.5385 0.551047 12.9874 7.58386e-07 12.3077 7.58386e-07Z"
                                            fill="white" />
                                        <path
                                            d="M23.1097 0.890455C22.3328 0.113501 21.0731 0.113501 20.2961 0.890455L9.99064 11.196C9.68621 11.5004 9.49774 11.9017 9.45784 12.3303L9.29959 14.0308C9.26387 14.4145 9.58562 14.7363 9.96934 14.7006L11.6698 14.5423C12.0985 14.5024 12.4997 14.3139 12.8041 14.0095L23.1097 3.70396C23.8866 2.92704 23.8866 1.66738 23.1097 0.890455Z"
                                            fill="white" />
                                    </svg>
                                    <span class="ms-2">{{ localize('edit_cover_image') }}</span>
                                    <input type="file" id="coverImageUpload" name="cover_image"
                                        class="account-file-input" hidden="" accept="image/png, image/jpeg" />
                                </label>
                            </div>
                        </form>
                        <div class="user-profile-header d-flex flex-column flex-sm-row text-sm-start text-center mb-3">
                            <form id="imageUploadForm" action="{{ route('profile_image.update', Auth::user()->id) }}"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="flex-shrink-0 mt-n2 mx-sm-0 mx-auto user-img-actions">
                                    <img src="{{ Auth::user()->profile_image ? asset('storage/' . Auth::user()->profile_image) : asset('backend/assets/dist/img/avatar-1.jpg') }}"
                                        alt="user image" class="d-block ms-0 ms-sm-5 user-profile-img"
                                        id="profilePicturePreview" />

                                    <div class="user-img-actions-overlay user-img rounded-circle">
                                        <label for="profilePictureUpload" tabindex="0" class="label-upload">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="37" height="30"
                                                viewBox="0 0 37 30" fill="none">
                                                <path
                                                    d="M34.0746 3.89632H31.1543C30.347 3.89632 29.0868 3.37391 28.517 2.80348L27.3761 1.66262C26.4306 0.714499 24.7044 0 23.3656 0H13.6313C12.2905 0 10.5663 0.715148 9.61685 1.66262L8.47599 2.80348C7.90426 3.37521 6.64983 3.89632 5.84059 3.89632H2.92029C1.31089 3.89632 0 5.20591 0 6.81661V26.2852C0 27.8946 1.31089 29.2055 2.92029 29.2055H34.0701H34.074C35.6847 29.2055 36.9943 27.8946 36.9943 26.2852V6.81661C36.9949 5.20591 35.6853 3.89632 34.0746 3.89632ZM18.4958 23.3649C13.6644 23.3649 9.73496 19.4329 9.73496 14.6041C9.73496 9.7739 13.6644 5.84318 18.4958 5.84318C23.3247 5.84318 27.2567 9.7739 27.2567 14.6041C27.2567 19.4329 23.3247 23.3649 18.4958 23.3649Z"
                                                    fill="white" />
                                                <path
                                                    d="M18.4957 7.79004C14.7389 7.79004 11.6816 10.846 11.6816 14.6041C11.6816 18.3609 14.7389 21.4181 18.4957 21.4181C22.2525 21.4181 25.3097 18.3609 25.3097 14.6041C25.3097 10.846 22.2525 7.79004 18.4957 7.79004Z"
                                                    fill="white" />
                                            </svg>
                                            <input type="file" id="profilePictureUpload" name="profile_image"
                                                class="account-file-input" hidden="" accept="image/png, image/jpeg" />
                                        </label>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="fit-content text-center ms-0 ms-sm-4 ps-sm-3">
                            <h5 class="fw-bold mb-1">{{ ucwords(Auth::user()->full_name) }}</h5>
                            {{-- <p class="mb-0 color_1">Project Manager</p> --}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-2">
                    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        <a class="nav-link active bg-smoke fw-semi-bold rounded-3 d-block text-center w-100 py-2 mb-2"
                            id="v-pills-home-tab" data-bs-toggle="pill" href="#v-pills-home" role="tab"
                            aria-controls="v-pills-home" aria-selected="true">{{ localize('personal_info') }}</a>
                        <a class="nav-link bg-smoke fw-semi-bold rounded-3 d-block text-center w-100 py-2"
                            id="v-pills-profile-tab" data-bs-toggle="pill" href="#v-pills-profile" role="tab"
                            aria-controls="v-pills-profile" aria-selected="false">{{ localize('change_password') }}</a>
                    </div>
                </div>
                <div class="col-lg-10">
                    <div class="tab-content" id="v-pills-tabContent">
                        <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel"
                            aria-labelledby="v-pills-home-tab">
                            <div class="card shadow-1 py-4">
                                <div class="d-flex align-items-center justify-content-between px-5 py-3 bg-honeydew">
                                    <h6 class="fs-18 fw-bold mb-0 d-flex align-items-center"><span
                                            class="vr_line me-2"></span> {{ localize('personal_info') }}</h6>
                                    <a href="{{ route('editMyProfile') }}" class="profile-edit-btn">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                            viewBox="0 0 20 20" fill="none">
                                            <path
                                                d="M10.2564 6.31988e-07H9.66805C7.67736 -2.5009e-05 6.07933 -5.06181e-05 4.82395 0.168744C3.52321 0.343616 2.4378 0.716437 1.57713 1.57713C0.716437 2.4378 0.343616 3.52321 0.168744 4.82395C-5.06181e-05 6.07933 -2.5009e-05 7.67736 6.31988e-07 9.66805V10.332C-2.5009e-05 12.3226 -5.06181e-05 13.9207 0.168744 15.1761C0.343616 16.4768 0.716437 17.5622 1.57713 18.4229C2.4378 19.2836 3.52321 19.6564 4.82395 19.8313C6.07936 20.0001 7.67739 20 9.66808 20H10.3319C12.3226 20 13.9206 20.0001 15.1761 19.8313C16.4768 19.6564 17.5622 19.2836 18.4229 18.4229C19.2836 17.5622 19.6564 16.4768 19.8313 15.1761C20.0001 13.9206 20 12.3226 20 10.3319V9.74359C20 9.17716 19.5408 8.71795 18.9744 8.71795C18.4079 8.71795 17.9487 9.17716 17.9487 9.74359V10.2564C17.9487 12.3403 17.9465 13.8 17.7983 14.9027C17.654 15.976 17.3884 16.5564 16.9724 16.9724C16.5564 17.3884 15.976 17.654 14.9027 17.7983C13.8 17.9465 12.3403 17.9487 10.2564 17.9487H9.74359C7.65975 17.9487 6.20005 17.9465 5.09728 17.7983C4.024 17.654 3.44362 17.3884 3.02759 16.9724C2.61157 16.5564 2.34603 15.976 2.20172 14.9027C2.05346 13.8 2.05128 12.3403 2.05128 10.2564V9.74359C2.05128 7.65975 2.05346 6.20005 2.20172 5.09728C2.34603 4.024 2.61157 3.44362 3.02759 3.02759C3.44362 2.61157 4.024 2.34603 5.09728 2.20172C6.20005 2.05346 7.65975 2.05128 9.74359 2.05128H10.2564C10.8228 2.05128 11.2821 1.59208 11.2821 1.02564C11.2821 0.459206 10.8228 6.31988e-07 10.2564 6.31988e-07Z"
                                                fill="white" />
                                            <path
                                                d="M19.2577 0.741944C18.6103 0.0944823 17.5606 0.0944823 16.9131 0.741944L8.3252 9.32987C8.07151 9.58356 7.91446 9.91795 7.8812 10.2752L7.74933 11.6922C7.71956 12.012 7.98769 12.2801 8.30746 12.2504L9.72451 12.1185C10.0817 12.0852 10.4161 11.9282 10.6698 11.6745L19.2577 3.08653C19.9052 2.4391 19.9052 1.38938 19.2577 0.741944Z"
                                                fill="white" />
                                        </svg>
                                        <span class="ms-2">{{ localize('edit') }}</span>
                                    </a>
                                </div>

                                <div class="row g-4 px-5 py-3">
                                    <div class="col-lg-6">
                                        <p class="mb-1 fs-15 fw-semi-bold">{{ localize('name') }}</p>
                                        <h5 class="mb-1 fs-18 fw-bold">{{ ucwords(Auth::user()->full_name) }}</h5>
                                    </div>
                                    <div class="col-lg-6">
                                        <p class="mb-1 fs-15 fw-semi-bold">{{ localize('email') }}</p>
                                        <h5 class="mb-1 fs-18 fw-bold">{{ Auth::user()->email }}</h5>
                                    </div>
                                    <div class="col-lg-6">
                                        <p class="mb-1 fs-15 fw-semi-bold">{{ localize('phone') }}</p>
                                        <h5 class="mb-1 fs-18 fw-bold">{{ Auth::user()->contact_no }}</h5>
                                    </div>
                                    <div class="col-lg-6">
                                        <p class="mb-1 fs-15 fw-semi-bold">{{ localize('signature') }}</p>
                                        <img src="{{ Auth::user()->signature ? asset('storage/' . Auth::user()->signature) : asset('backend/assets/dist/img/nopreview.jpeg') }}"
                                            alt="{{ Auth::user()->full_name }}" class="img-fluid h-25" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="v-pills-profile" role="tabpanel"
                            aria-labelledby="v-pills-profile-tab">
                            <div class="card shadow-1 py-4">
                                <form id="changePasswordForm" action="{{ route('profile.changePassword') }}"
                                    method="post">
                                    @csrf

                                    <h6 class="px-5 py-3 bg-honeydew fs-18 fw-bold mb-0 d-flex align-items-center"><span
                                            class="vr_line me-2"></span> {{ localize('change_password') }}</h6>
                                    <div class="row px-5 py-3">

                                        <div class="col-lg-6">
                                            <div class="">
                                                <label
                                                    class="form-label fw-semi-bold">{{ localize('current_password') }}</label>
                                                <input type="password" name="current_password" id="current_password"
                                                    class="form-control" required autocomplete="current-password">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label
                                                    class="form-label fw-semi-bold">{{ localize('new_password') }}</label>
                                                <input type="password" name="password" id="password"
                                                    class="form-control" required autocomplete="new-password">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label
                                                    class="form-label fw-semi-bold">{{ localize('confirm_password') }}</label>
                                                <input id="password-confirm" type="password" class="form-control"
                                                    name="password_confirmation" required autocomplete="new-password">
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="d-flex gap-3 justify-content-end">
                                                <button
                                                    class="btn btn-success bg-salem text-white fw-semi-bold rounded-3 d-block text-center w-auto px-5 py-2">{{ localize('save_change') }}</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

@push('js')
    <script>
        $(document).ready(function() {
            $('#changePasswordForm').on('submit', function(e) {
                e.preventDefault();

                $('#current_password_error').text('');
                $('#new_password_error').text('');
                $('#password_confirmation_error').text('');

                var formData = new FormData(this);
                $.ajax({
                    type: 'POST',
                    url: $(this).attr('action'),
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        if (data.status != false) {
                            $('#changePasswordForm').trigger('reset');
                            $('#changePasswordModal').modal('hide');
                            toastr.success(data.message);
                        } else {
                            $('#current_password_error').html(data.message);
                            $('#current_password').focus();
                        }

                    },
                    error: function(data) {
                        var errors = data.responseJSON.errors;
                        if (errors.password) {
                            $('#new_password_error').html(errors.password[0]);
                            $('#new_password').focus();
                        }
                    }
                });
            });
        });
        $('.userProfileUpdate').on('submit', (function(e) {
            e.preventDefault();

            var formData = new FormData(this);
            console.log(formData);
            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(data) {
                    $('.userProfileUpdate').trigger('reset');
                    $('#updateProfile').modal('hide');
                    toastr.success(data.message);
                    window.location.href = data.route;
                },

                error: function(data) {
                    var errors = data.responseJSON.errors;

                    if (errors.contact_no) {
                        $('.error_contact_no').html(errors.contact_no[0]);
                        $('#contact_no').focus();
                    }
                    if (errors.full_name) {
                        $('.error_full_name').html(errors.full_name[0]);
                        $('#full_name').focus();
                    }
                },
            });
        }));

        function profilePicture(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $("#profilePicturePreview").attr("src", e.target.result);
                    $('#profilePicturePreview').fadeIn(650);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#profilePictureUpload").change(function() {
            profilePicture(this);
        });

        $('#imageUploadForm').on('submit', (function(e) {
            e.preventDefault();

            var formData = new FormData(this);

            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(data) {
                    toastr.success("Profile Picture Updated Successfully..!!");
                },
                error: function(data) {
                    toastr.error("Profile Picture Not Updated..!!");
                }
            });
        }));

        $("#profilePictureUpload").change(function() {
            profilePicture(this);
            $("#imageUploadForm").submit();
        });

        $("#coverImageUpload").change(function() {
            coverImage(this);
            $("#coverImageUploadForm").submit();
        });

        $('#coverImageUploadForm').on('submit', (function(e) {
            e.preventDefault();

            var formData = new FormData(this);

            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(data) {
                    toastr.success(data.message);
                },
                error: function(data) {
                    toastr.error("Cover Picture Not Updated..!!");
                }
            });
        }));

        function coverImage(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $("#cover_image_preview").attr("src", e.target.result);
                    $('#cover_image_preview').fadeIn(650);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endpush
