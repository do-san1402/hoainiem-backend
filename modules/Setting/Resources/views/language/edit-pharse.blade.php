<div class="">
    <div class="col-md-12">
        <div class="flex">
            <button class="btn btn-primary btn-md" data-bs-toggle="modal" data-bs-target="#pharseImportModal">Import
                Language</button>
            <a href="{{ route('lang.export', $lang->slug) }}" class="btn btn-warning btn-md">Export Language</a>
        </div>
    </div>
    <form action="{{ route('lang.update', $lang->slug) }}" method="post">
        <table id="pharse-list" class="table display table-bordered table-striped table-hover">
            @csrf
            <thead>
                <tr class="role-header">
                    <th>{{ localize('sl') }}</th>
                    <th>Phrase</th>
                    <th>Label</th>
                </tr>
            </thead>

            <tbody>
                @php $sl = 0;  @endphp
                @foreach ($results as $key => $label)
                    <tr>
                        <td>
                            {{ ++$sl }}
                        </td>
                        <td>{{ $key }}</td>
                        <td>
                            <input type="hidden" name="key[]" value="{{ $key }}">
                            <input type="text" name="label[]" value="{{ $label }}" class="form-control">
                        </td>
                    </tr>
                @endforeach
            </tbody>

            <tfoot>
                <tr>
                    <th>{{ localize('sl') }}</th>
                    <th>Phrase</th>
                    <th>Label</th>
                </tr>
            </tfoot>
        </table>
        <div class="text-center">
            <button type="submit" class="btn btn-primary btn-md text-right">Save</button>
        </div>
    </form>
</div>

<!-- Phrase Import Modal -->
<div class="modal fade" id="pharseImportModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <form action="{{ route('lang.import', $lang->slug) }}" id="import-phrase" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h6 class="modal-title" id="importModalLabel">{{ __('lang.Import Phrase') }}</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-2 mx-0 row">
                        <label for="importFile" class="col-sm-3 col-form-label ps-0">Import Phrase</label>
                        <div class="col-lg-9">
                            <input class="form-control" type="file" name="import_phrase" id="importFile">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">{{ __('form.close') }}</button>
                    <button type="reset" class="btn btn-danger">{{ __('form.reset') }}</button>
                    <button type="submit" class="btn btn-primary">{{ __('form.submit') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
