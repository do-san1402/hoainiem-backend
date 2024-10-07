@extends('backend.layouts.app')
@section('title', localize_uc('add_new_news'))
@push('css')
    <link href="{{ asset('backend/assets/plugins/Bootstrap-5-Tag-Input/tagsinput.css') }}" rel="stylesheet">
@endpush

@section('content')
    @include('backend.layouts.common.message')
    <!--Basic Tabs-->
    <div class="card mb-4">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="fs-17 font-weight-600 mb-0">{{ localize('setup_menu') }}</h6>
                </div>
            </div>
        </div>
        <div class="card-body">

            <!-- Nav tabs -->
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="category-tab" data-bs-toggle="tab" data-bs-target="#category"
                        type="button" role="tab" aria-controls="category" aria-selected="true">
                        {{ localize('category') }}
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="page-tab" data-bs-toggle="tab" data-bs-target="#page" type="button"
                        role="tab" aria-controls="page" aria-selected="false">
                        {{ localize('page') }}
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="link-tab" data-bs-toggle="tab" data-bs-target="#link" type="button"
                        role="tab" aria-controls="link" aria-selected="false">
                        {{ localize('link') }}
                    </button>
                </li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <div class="tab-pane active" id="category" role="tabpanel" aria-labelledby="category-tab" tabindex="0">
                    <a class="text-success" href="{{ route('category.index') }}">
                        <i class="fa fa-plus"></i>
                        {{ localize('add_new_category') }}
                    </a>
                    <form action="{{ route('menu.setup.storeCategoryMenuContent', ['menu' => $menu_id]) }}"
                        class="needs-validation" data="showCallBackCategoryMenuContentData" id="CategoryMenuContentForm"
                        novalidate="" method="POST" enctype="multipart/form-data">
                        @csrf
                        <h3>{{ localize('category') }}</h3>
                        @foreach ($categories as $category)
                            <label>
                                <input type="checkbox" name="content_id[]" value="{{ $category->id }}">
                                {{ $category->category_name }}
                            </label>
                            &nbsp;&nbsp;&nbsp;&nbsp;
                        @endforeach
                        <input type="hidden" value="categories" name="content_type" id="category_content_type">
                        <br>
                        <button type="submit" class="btn btn-success">{{ localize('save') }}</button>
                    </form>
                </div>
                <div class="tab-pane" id="page" role="tabpanel" aria-labelledby="page-tab" tabindex="0">
                    <a class="text-success" href="{{ route('page.create') }}">
                        <i class="fa fa-plus"></i>
                        {{ localize('add_new_page') }}
                    </a>
                    <form action="{{ route('menu.setup.storePageMenuContent', ['menu' => $menu_id]) }}"
                        class="needs-validation" data="showCallBackPageMenuContentData" id="PageMenuContentForm"
                        novalidate="" method="POST" enctype="multipart/form-data">
                        @csrf
                        <h3>{{ localize('pages') }}</h3>

                        @foreach ($pages as $page)
                            <label>
                                <input type="checkbox" name="content_id[]" value="{{ $page->id }}">
                                {{ $page->title }}
                            </label>
                            &nbsp;&nbsp;&nbsp;&nbsp;
                        @endforeach

                        <input type="hidden" value="pages" name="content_type" id="page_content_type">
                        <br>
                        <button type="submit" class="btn btn-success">{{ localize('save') }}</button>
                    </form>
                </div>
                <div class="tab-pane" id="link" role="tabpanel" aria-labelledby="link-tab" tabindex="0">
                    <a class="text-success" id="add-new-link" href="#">
                        <i class="fa fa-plus"></i>
                        {{ localize('add_new_link') }}
                    </a>
                    <form action="{{ route('menu.setup.storeLinkMenuContent', ['menu' => $menu_id]) }}"
                        class="needs-validation" data="showCallBackLinkMenuContentData" id="linkMenuContentForm"
                        novalidate="" method="POST" enctype="multipart/form-data">
                        @csrf
                        <h3>{{ localize('links') }}</h3>
                        <div class="py-2" id="links_level">
                            @foreach ($links as $link)
                                <label>
                                    <input type="checkbox" name="content_id[]" value="{{ $link->id }}">
                                    {{ $link->level }}
                                </label>
                                &nbsp;&nbsp;&nbsp;&nbsp;
                            @endforeach
                        </div>
                        <br>
                        <button type="submit" class="btn btn-success">{{ localize('save') }}</button>
                    </form>
                </div>
            </div>

        </div>
    </div>

    <div class="card mb-4 mb-lg-0">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="fs-17 font-weight-600 mb-0">
                        {{ localize('update_menu') }}
                    </h6>
                </div>
            </div>
        </div>
        <div class="card-body" id="table">
            <form action="{{ route('menu.setup.update-position', ['menu' => $menu_id]) }}" class="needs-validation"
                data="showCallBackMenuContentPositionData" id="menuContentForm" novalidate="" method="POST"
                data-resetvalue="false" enctype="multipart/form-data">
                @csrf
                @method('patch')
                <div id="sortable" data-edit-route="{{ route('menu.setup.edit', ['menu' => $menu_id, 'menu_content' => 'menu_content_param']) }}"
                    data-update-route="{{ route('menu.setup.update', ['menu' => $menu_id, 'menu_content' => 'menu_content_param']) }}"
                    data-destroy-route="{{ route('menu.setup.destroy', ['menu' => $menu_id, 'menu_content' => 'menu_content_param']) }}">
                    @foreach ($menuContents as $menuContent)
                        <div class="row msv" id="msv_div_{{ $menuContent->id }}">
                            <div class="col-sm-10">
                                {{ $menuContent->menu_level }}
                            </div>
                            <div class="col-sm-2 mbtn">
                                <button class="btn-primary btn edit-menu-content" type="button"
                                    data-route="{{ route('menu.setup.edit', ['menu' => $menu_id, 'menu_content' => $menuContent->id]) }}"
                                    data-action="{{ route('menu.setup.update', ['menu' => $menu_id, 'menu_content' => $menuContent->id]) }}">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <button class="btn btn-danger delete-menu-content" type="button"
                                    data-action="{{ route('menu.setup.destroy', ['menu' => $menu_id, 'menu_content' => $menuContent->id]) }}">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </div>
                            <input type="hidden" value="{{ $menuContent->id }}" name="id[]">
                        </div>
                    @endforeach
                </div>
                <br>
                <button class="btn btn-md btn-success float-sm-right" type="submit">
                    {{ localize('update') }}
                </button>
            </form>

        </div>
    </div>

    <x-common-modal modalId="link_modal" :modalTitle="localize('add_link')" modalDialog="modal-md">
        <form action="{{ route('menu.setup.storeLink', ['menu' => $menu_id]) }}" method="post" class="needs-validation"
            data="showCallBackLinkData" novalidate="">
            @csrf
            <div class="row">
                <div class="col-md-12">
                    <div class="row form-group">
                        <label for="level" class="col-form-label fw-semibold">{{ localize_uc('menu_level') }} <span
                                class="text-danger">*</span> </label>
                        <input type="text" name="level" id="level"
                            class="form-control @error('level') is-invalid @enderror"
                            placeholder="{{ localize_uc('enter_menu_level') }}" value="{{ old('level') }}" required>
                        <div class="invalid-feedback error text-danger m-2">
                            @error('level')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="row form-group">
                        <label for="slug" class="col-form-label fw-semibold">{{ localize_uc('slug') }}
                            <span class="text-danger">*</span> </label>
                        <input type="text" name="slug" id="slug"
                            class="form-control @error('slug') is-invalid @enderror"
                            placeholder="{{ localize_uc('enter_slug') }}" value="{{ old('slug') }}" disabled required>
                        <div class="invalid-feedback error text-danger m-2">
                            @error('slug')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="row form-group">
                        <label for="position"
                            class="col-form-label fw-semibold">{{ localize_uc('menu_position') }}</label>
                        <input type="number" name="position" id="position"
                            class="form-control @error('position') is-invalid @enderror"
                            placeholder="{{ localize_uc('enter_menu_position') }}" value="{{ old('position') }}">
                        <div class="invalid-feedback error text-danger m-2">
                            @error('position')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="row form-group">
                        <label for="link" class="col-form-label fw-semibold">{{ localize_uc('menu_link') }}</label>
                        <input type="string" name="link" id="link"
                            class="form-control @error('link') is-invalid @enderror"
                            placeholder="{{ localize_uc('enter_menu_link') }}" value="{{ old('link') }}">
                        <div class="invalid-feedback error text-danger m-2">
                            @error('link')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="row form-group">
                        <label for="parent_id" class="col-form-label fw-semibold">{{ localize_uc('parent') }}</label>
                        <select name="parent_id" id="parent_id" class="select-basic-single form-control"
                            data-placeholder="{{ localize_uc('select_parent') }}" data-allow-clear="true">
                            <option value=""></option>
                            @foreach ($menuContents as $menuContent)
                                <option value="{{ $menuContent->id }}">{{ $menuContent->menu_level }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback error text-danger m-2">
                            @error('parent_id')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>
                </div>

            </div>
            <div class="d-flex flex-row gap-3 py-3">
                <button type="reset" class="btn btn-danger w-25" title="{{ localize('Reset') }}">
                    <i class="fa fa-undo-alt"></i>
                </button>
                <button type="submit" class="btn btn-success w-75">{{ localize('Create') }}</button>
            </div>
        </form>
    </x-common-modal>

    <x-common-modal modalId="update_modal" :modalTitle="localize('update_menu')" modalDialog="modal-md">
        <form action="#" method="post" class="needs-validation" id="updateMenuContentForm"
            data="showCallBackMenuContentData" novalidate="">
            @csrf
            @method('patch')
            <div class="row">
                <div class="col-md-12">
                    <div class="row form-group">
                        <label for="level" class="col-form-label fw-semibold">{{ localize_uc('menu_level') }} <span
                                class="text-danger">*</span> </label>
                        <input type="text" name="level" id="menu_content_level"
                            class="form-control @error('level') is-invalid @enderror"
                            placeholder="{{ localize_uc('enter_menu_level') }}" value="{{ old('level') }}" required>
                        <div class="invalid-feedback error text-danger m-2">
                            @error('level')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="row form-group">
                        <label for="slug" class="col-form-label fw-semibold">{{ localize_uc('slug') }}
                            <span class="text-danger">*</span> </label>
                        <input type="text" name="slug" id="menu_content_slug"
                            class="form-control @error('slug') is-invalid @enderror"
                            placeholder="{{ localize_uc('enter_slug') }}" value="{{ old('slug') }}" disabled required>
                        <div class="invalid-feedback error text-danger m-2">
                            @error('slug')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="row form-group">
                        <label for="position"
                            class="col-form-label fw-semibold">{{ localize_uc('menu_position') }}</label>
                        <input type="number" name="position" id="menu_content_position"
                            class="form-control @error('position') is-invalid @enderror"
                            placeholder="{{ localize_uc('enter_menu_position') }}" value="{{ old('position') }}">
                        <div class="invalid-feedback error text-danger m-2">
                            @error('position')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="row form-group">
                        <label for="link" class="col-form-label fw-semibold">{{ localize_uc('menu_link') }}</label>
                        <input type="string" name="link" id="menu_content_link"
                            class="form-control @error('link') is-invalid @enderror"
                            placeholder="{{ localize_uc('enter_menu_link') }}" value="{{ old('link') }}">
                        <div class="invalid-feedback error text-danger m-2">
                            @error('link')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="row form-group">
                        <label for="parent_id" class="col-form-label fw-semibold">{{ localize_uc('parent') }}</label>
                        <select name="parent_id" id="menu_content_parent_id" class="select-basic-single form-control"
                            data-placeholder="{{ localize_uc('select_parent') }}" data-allow-clear="true">
                            <option value=""></option>
                            @foreach ($menuContents as $menuContent)
                                <option value="{{ $menuContent->id }}">{{ $menuContent->menu_level }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback error text-danger m-2">
                            @error('parent_id')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>
                </div>

            </div>
            <div class="d-flex flex-row gap-3 py-3">
                <button type="reset" class="btn btn-danger w-25" title="{{ localize('Reset') }}">
                    <i class="fa fa-undo-alt"></i>
                </button>
                <button type="submit" class="btn btn-success w-75">{{ localize('Update') }}</button>
            </div>
        </form>
    </x-common-modal>

@endsection

@push('js')
    <script src="{{ asset('backend/assets/plugins/Bootstrap-5-Tag-Input/tagsinput.js') }}"></script>
    <script src="{{ module_asset('Menu/js/menu-setup.js') }}"></script>
@endpush
