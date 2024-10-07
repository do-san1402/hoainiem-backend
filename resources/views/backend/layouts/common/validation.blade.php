@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
        <strong>
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
