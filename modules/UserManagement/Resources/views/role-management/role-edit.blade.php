@extends('setting::settings')
@section('title', localize('edit_role'))
@section('setting_content')
    <div class="card mb-4">
        @include('backend.layouts.common.validation')
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="fs-17 fw-semi-bold mb-0">{{ localize('edit_role') }}</h6>
                </div>
                <div class="text-end">
                    <div class="actions">

                        <a href="{{ route('role.list') }}" class="btn btn-success btn-sm">{{ localize('role_list') }}</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form id="leadForm" action="{{ route('role.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row pb-4">
                    <div class="col-md-12">
                        <div class="row">
                            <label for="name"
                                class="col-form-label col-sm-2 col-md-12 col-xl-2 fw-semibold">{{ localize('role_name') }}<span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-7 col-md-12 col-xl-7">
                                <input type="text" class="form-control" value="{{ $roles->name }}" id="name"
                                    name="name" value="" required="" autocomplete="off">
                            </div>
                            <div class="col-sm-3 col-md-12 col-xl-3 d-flex justify-content-end">
                                <div class="form-check pt-2">
                                    <label class="form-check-label" for="selectAll">{{ localize('select_all') }}</label>
                                    <input class="form-check-input" type="checkbox" id="selectAll">
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <input type="hidden" name="role_id" id="role_id" value="{{ $roles->id }}">
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
                                <th class="text-center">{{ localize('sl') }}</th>
                                <th>{{ localize('module_menu') }}</th>
                                <th class="text-center">{{ localize('select_all') }}</th>
                                <th class="text-center">{{ localize('create') }}</th>
                                <th class="text-center">{{ localize('read') }}</th>
                                <th class="text-center">{{ localize('update') }}</th>
                                <th class="text-center">{{ localize('delete') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="sub-select">
                                <td class="text-center">{{ $sl }}</td>
                                <td width="40%">{{ localize('' . $permissionMenuName?->menu_name) }}</td>
                                <td class="text-center"><input class="form-check-input select-sub" type="checkbox"
                                        id="select_sub{{ $key }}"></td>
                                @forelse ($permissionMenuName->permission as $pkye => $permissionName)
                                    <td class="text-center permissions"><input type="checkbox" class="form-check-input"
                                            name="permission[]" value="{{ $permissionName->id }}"
                                            {{ $roleHasPermission->contains($permissionName->name) ? 'checked' : '' }}>
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
                                        <td class="text-center">{{ $sl }}</td>
                                        <td width="40%">{{ localize('' . $permissionMenuName?->menu_name) }} >>
                                            {{ localize('' . $subMenu?->menu_name) }}</td>
                                        <td class="text-center"><input class="form-check-input select-sub" type="checkbox"
                                                id="select_sub{{ $key }}"></td>
                                        @forelse ($subMenu->permission as $pkye => $permissionName)
                                            <td class="text-center permissions"><input type="checkbox"
                                                    class="form-check-input" name="permission[]"
                                                    value="{{ $permissionName->id }}"
                                                    {{ $roleHasPermission->contains($permissionName->name) ? 'checked' : '' }}>
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
                                                <td class="text-center">{{ $sl }}</td>
                                                <td width="40%">
                                                    {{ localize('' . $permissionMenuName?->menu_name) }} >>
                                                    {{ localize('' . $subMenu?->menu_name) }} >>
                                                    {{ localize('' . $childMenu?->menu_name) }}</td>
                                                <td class="text-center"><input class="form-check-input select-sub"
                                                        type="checkbox" id="select_sub{{ $key }}">
                                                </td>
                                                @forelse ($childMenu->permission as $pkye => $permissionName)
                                                    <td class="text-center permissions"><input type="checkbox"
                                                            class="form-check-input" name="permission[]"
                                                            value="{{ $permissionName->id }}"
                                                            {{ $roleHasPermission->contains($permissionName->name) ? 'checked' : '' }}>
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
                                <td>{{ localize('empty_data') }}</td>
                            </tr>
                        </table>
                    @endforelse
                    <div class="form-group text-end">
                        <button type="submit" class="btn btn-success mt-3">{{ localize('submit') }}</button>
                    </div>
                </form>
            </div>
        </div>
    @endsection
    @push('js')
        <script src="{{ asset('backend/assets/sweetalert.js') }}"></script>
        <script src="{{ module_asset('UserManagement/js/roleAddEdit.js') }}"></script>
    @endpush
