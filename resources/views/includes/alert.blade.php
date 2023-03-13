@if (session('message'))
    <div class='alert alert-{{ session('type') ?? 'info' }} my-5'>
        {{ session('message') }}
    </div>
@endif
