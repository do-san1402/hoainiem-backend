@extends('setting::settings')
@section('setting_content')
    <!--/.Content Header (Page header)-->
    <div class="body-content pt-0">
        @include('backend.layouts.common.validation')
        <div class="card mb-4">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="fs-17 fw-semi-bold mb-0">Add Role</h6>
                    </div>
                    <div class="text-end">
                        <div class="actions">

                            <a href="{{ route('role.list') }}" class="btn btn-success btn-sm"> Role
                                List</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form id="leadForm" action="{{ route('role.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row pb-3">
                        <div class="col-md-12 mt-3">
                            <div class="row">
                                <label for="name" class="col-form-label col-sm-2 col-md-12 col-xl-2 fw-semibold">Role
                                    Name <span class="text-danger">*</span></label>
                                <div class="col-sm-7 col-md-12 col-xl-7">
                                    <input type="text" class="form-control" id="name" name="name" value=""
                                        required="" autocomplete="off">
                                </div>
                                <div class="col-sm-3 col-md-12 col-xl-3 d-flex justify-content-end">
                                    <div class="form-check pt-2">
                                        <label class="form-check-label" for="selectAll">Select All</label>
                                        <input class="form-check-input" type="checkbox" id="selectAll">
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    @php
                        $sl = 0;
                    @endphp
                    @forelse ($perMenu as $key => $permissionMenuName)
                        @php
                            if ($permissionMenuName->parentmenu_id == 0) {
                                $key = 0;
                                $sl = 0;
                            }
                            $sl += 1;
                        @endphp
                        <h4>{{ localize('' . $permissionMenuName?->menu_name) }}</h4>

                        <table class="table table-hover table-bordered align-middle">
                            <thead>
                                <tr>

                                    <th>Module Menu</th>
                                    <th class="text-center">Create</th>
                                    <th class="text-center">Read</th>
                                    <th class="text-center">Update</th>
                                    <th class="text-center">Delete</th>

                                </tr>
                            </thead>
                            <tbody>
                                <tr class="sub-select">
                                    <td width="40%">{{ localize('' . $permissionMenuName?->menu_name) }}</td>

                                    @forelse ($permissionMenuName->permission as $pkye => $permissionName)
                                        <td class="text-center permissions">{{ $permissionName->name }}
                                        </td>
                                    @empty
                                    @endforelse
                                </tr>
                                @if (count($permissionMenuName->subMenu) > 0)
                                    @foreach ($permissionMenuName->subMenu as $subkey => $subMenu)
                                        @php
                                            $sl += 1;
                                        @endphp
                                        <tr class="sub-select">
                                            <td width="40%">{{ localize('' . $permissionMenuName?->menu_name) }} >>
                                                {{ localize('' . $subMenu?->menu_name) }}</td>

                                            @forelse ($subMenu->permission as $pkye => $permissionName)
                                                <td class="text-center permissions">{{ $permissionName->name }}
                                                </td>
                                            @empty
                                            @endforelse
                                        </tr>

                                        @if (count($subMenu->childMenu) > 0)
                                            @foreach ($subMenu->childMenu as $childkey => $childMenu)
                                                @php
                                                    $sl += 1;
                                                @endphp
                                                <tr class="sub-select">
                                                    <td width="40%">
                                                        {{ localize('' . $permissionMenuName?->menu_name) }} >>
                                                        {{ localize('' . $subMenu?->menu_name) }} >>
                                                        {{ localize('' . $childMenu?->menu_name) }}</td>

                                                    @forelse ($childMenu->permission as $pkye => $permissionName)
                                                        <td class="text-center permissions">{{ $permissionName->name }}
                                                        </td>
                                                    @empty
                                                    @endforelse
                                                </tr>
                                            @endforeach
                                        @endif
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                        @empty
                            <table>
                                <tr>
                                    <td>No Data Found</td>
                                </tr>
                            </table>
                        @endforelse

                        <div class="form-group text-end">
                            <button type="submit" class="btn btn-success mt-3">{{ localize('submit') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endsection
    @push('js')
        <script src="{{ asset('backend/assets/sweetalert.js') }}"></script>
        <script src="{{ module_asset('UserManagement/js/roleAddEdit.js') }}"></script>
    @endpush
