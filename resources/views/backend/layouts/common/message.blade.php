@if (session('success'))
    <div class="mt-3 mb-3 alert alert-success alert-dismissible fade show" id="success" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if (session('fail'))
{{-- id="fail" --}}
    <div class="mt-3 mb-3 alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('fail') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if (session('update'))
    <div class="mt-3 mb-3 alert alert-info alert-dismissible fade show" id="update" role="alert">
        {{ session('update') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if (session('warning'))
    <div class="mt-3 mb-3 alert alert-warning alert-dismissible fade show" id="warning" role="alert">
        {{ session('warning') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
