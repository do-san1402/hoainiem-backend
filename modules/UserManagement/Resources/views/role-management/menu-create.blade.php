<!-- Modal -->
<div class="modal fade" id="addmenu" data-bs-backdrop="static" data-bs-keyboard="false"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">
                    New Menu
                </h5>
            </div>
            <form id="menuForm" action="{{ route('role.menu.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">

                        <div class="col-md-12 text-start">
                            <div class="row mt-3">
                                <label for="parentmenu_id"
                                    class="col-form-label col-sm-3 col-md-12 col-xl-3 fw-semibold">Parent
                                    Menu</label>
                                <div class="col-sm-9 col-md-12 col-xl-9">
                                    <select name="parentmenu_id" class="select-basic-single form-control">
                                        <option value="" selected disabled>--Selected One--</option>
                                        @foreach ($menuName as $menuNameValue)
                                            <option value="{{ $menuNameValue->id }}">{{ $menuNameValue->menu_name }}
                                            </option>
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
                                <label for="menu_name"
                                    class="col-form-label col-sm-3 col-md-12 col-xl-3 fw-semibold">Menu Name <span
                                        class="text-danger">*</span></label>
                                <div class="col-sm-9 col-md-12 col-xl-9">
                                    <input type="text" class="form-control" id="menu_name" name="menu_name"
                                        value="{{ old('menu_name') }}" required>
                                </div>

                                @if ($errors->has('menu_name'))
                                    <div class="error text-danger m-2">{{ $errors->first('menu_name') }}</div>
                                @endif
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
