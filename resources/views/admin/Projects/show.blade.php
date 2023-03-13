@extends('layouts.app')

@section('title', $project->title)

@section('content')
    <header>
        <h1 class="my-5">{{ $project->title }}</h1>

    </header>
    <div class="clearfix">
        @if ($project->thumb)
            <div class="d-flex justify-content-center ">
                <img class='me-4 float-start w-25 h-25' src="{{ asset('storage/' . $project->thumb) }}"
                    alt="{{ $project->title }}">
            </div>
        @endif
        <p>{{ $project->description }}</p>
        <div>
            <strong>Creato il </strong>
            <time>{{ $project->created_at }}</time>
        </div>
        <div>
            @if ($project->type)
                <strong>Type</strong>
                <span class="my-5">{{ $project->type?->label }}</span>
            @endif

        </div>
        <hr>
        <div class="d-flex justify-content-end">

            <a class='btn btn-warning me-2 text-white' href="{{ route('admin.projects.edit', $project->id) }}">Modifica
                progetto</a>



            <a class='btn btn-success' href="{{ route('admin.projects.index') }}">Torna ai progetti</a>
            <form method='POST' action="{{ route('admin.projects.destroy', $project->id) }}" class='delete-form'>
                @csrf
                @method('DELETE')
                <button type='submit' class='btn btn-small btn-danger ms-2'>Elimina</button>
            </form>
        </div>
    </div>


@endsection
@section('script')
    <script>
        const deleteButtons = document.querySelectorAll('.delete-form');
        deleteButtons.forEach(button => {
            button.addEventListener('submit', (event) => {
                event.preventDefault();
                const confirm = window.confirm(`sei sicuro di voler eliminare questo elemento?`);
                if (confirm) button.submit();
            });
        });
    </script>
@endsection
