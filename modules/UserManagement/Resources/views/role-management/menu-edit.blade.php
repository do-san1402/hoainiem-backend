<form id="editMenuForm" action="{{ route('role.menu.update', $data->uuid) }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="modal-body">
        <div class="row">
            <div class="col-md-12 text-start">
                <div class="row mt-3">
                    <label for="parentmenu_id"
                        class="col-form-label col-sm-3 col-md-12 col-xl-3 fw-semibold required">Parent Menu</label>
                    <div class="col-sm-9 col-md-12 col-xl-9">
                        <select name="parentmenu_id" class="form-select">
                            <option value="" selected disabled>{{ localize('select_one') }}</option>
                            @foreach ($menuName as $menuNameValue)
                                <option value="{{ $menuNameValue->id }}"
                                    {{ $data->parentmenu_id == $menuNameValue->id ? 'selected' : '' }}>
                                    {{ $menuNameValue->menu_name }}</option>
                            @endforeach

                        </select>

                        @if ($errors->has('parentmenu_id'))
                            <div class="error text-danger m-2">{{ $errors->first('parentmenu_id') }}</div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-12 mt-3">
                <div class="row">
                    <label for="menu_name" class="col-form-label col-sm-3 col-md-12 col-xl-3 fw-semibold">Menu Name
                        <span class="text-danger">*</span></label>
                    <div class="col-sm-9 col-md-12 col-xl-9">
                        <input type="text" class="form-control" id="menu_name" name="menu_name"
                            value="{{ old('menu_name') ?? $data->menu_name }}" required>
                    </div>

                    @if ($errors->has('menu_name'))
                        <div class="error text-danger m-2">{{ $errors->first('menu_name') }}</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">{{ localize('close') }}</button>
        <button class="btn btn-primary">{{ localize('update') }}</button>
    </div>
</form>
<script src="{{ module_asset('UserManagement/js/menuEdit.js') }}"></script>
