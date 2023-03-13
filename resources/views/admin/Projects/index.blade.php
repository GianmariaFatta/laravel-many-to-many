@extends('layouts.app')

@section('title', 'Projects')


@section('content')
    <header class='d-flex justify-content-between align-items-center'>

        <h1 class='my-5'>Projects</h1>
        <a class='btn btn-small btn-success' href="{{ route('admin.projects.create') }}">Crea nuovo</a>
    </header>
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Title</th>
                <th scope="col">Slug</th>
                <th scope="col">Type</th>
                <th scope="col">Creato il </th>
                <th scope="col">Aggiornato il </th>
                <th> </th>
            </tr>
        </thead>
        <tbody>

            @forelse($projects as $project)
                <tr>
                    <th scope="row">{{ $project->id }}</th>
                    <td>{{ $project->title }}</td>
                    <td>{{ $project->slug }}</td>
                    <td>{{ $project->type?->label }}</td>
                    <td>{{ $project->created_at }}</td>
                    <td>{{ $project->updated_at }}</td>
                    <td class='d-flex justify-content-center align-items-center'>
                        <a class='btn btn-small btn-primary'
                            href="{{ route('admin.projects.show', $project->id) }}">Vedi</a>
                        <a class='btn btn-warning ms-2 text-white'
                            href="{{ route('admin.projects.edit', $project->id) }}">Modifica
                            progetto</a>
                        <form method='POST' action="{{ route('admin.projects.destroy', $project->id) }}"
                            class='delete-form'>
                            @csrf
                            @method('DELETE')
                            <button type='submit' class='btn btn-small btn-danger ms-2'>Elimina</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <th scope='row' colspan='6' class='text-center'>Non ci sono Progetti</th scope='row'>
                </tr>
            @endforelse
        </tbody>
    </table>
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
