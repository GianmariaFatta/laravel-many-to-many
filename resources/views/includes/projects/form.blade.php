  @if ($errors->any())
      <div class="alert alert-danger">
          <ul>
              @foreach ($errors->all() as $error)
                  <li>{{ $error }} </li>
              @endforeach
          </ul>
      </div>
  @endif
  @if ($project->exists)
      <form action="{{ route('admin.projects.update', $project->id) }}" method='POST' enctype='multipart/form-data'
          novalidate>
          @method('PUT')
      @else
          <form action="{{ route('admin.projects.store') }}" method='POST' enctype='multipart/form-data' novalidate>
  @endif

  @csrf
  <div class="row">
      <div class="col-6">
          <div class="mb-3">
              <label for="title" class="form-label">Title</label>
              <input type="text" class="form-control" id="title" name='title'
                  value='{{ old('title', $project->title) }}' required>
              <div class='text-muted'>Inserisci il titolo</div>
          </div>
      </div>



      <div class="col-6">
          <div class="mb-3">
              <label for="slug" class="form-label">Slug</label>
              <input type="text" class="form-control" id="slug"
                  value="{{ Str::slug(old('title', $project->title), '-') }}" disabled>
              <div class='text-muted'>Inserisci il titolo</div>
          </div>
      </div>
  </div>



  <div class="row">
      <div class="col-4">
          <label for="type_id" class="form-label">Type</label>
          <select class="form-select" name='type_id' id='type_id'>
              <option value=''>Nessuna categoria</option>
              @foreach ($types as $type)
                  <option @if (old('type_id', $project->type_id) == $type->id) selected @endif value='{{ $type->id }}'>
                      {{ $type->label }}</option>
              @endforeach
          </select>
      </div>
      <div class="col-6">
          <div class="mb-3">
              <label for="thumb" class="form-label">Immagine</label>
              <input type="file" class="form-control" id="thumb" name='thumb'
                  value='{{ old('thumb', $project->thumb) }}' required>
              <div class='text-muted'>Inserisci l'url dell'immagine</div>
          </div>
      </div>
      <div class="col-2">
          <img id='thumb-preview' class='img-fluid'
              src="{{ $project->thumb ? asset('storage/' . $project->thumb) : 'https://marcolanci.it/utils/placeholder.jpg' }}"
              alt="">
      </div>


      <div class="row">




          <div class="mb-3">
              <label for="description" class="form-label">Descrizione del progetto</label>
              <textarea class="form-control" id="description" name='description' rows="8">{{ old('title', $project->title) }}</textarea>
          </div>
      </div>
      <hr>
      <footer class='d-flex justify-content-end'>
          <a href="{{ route('admin.projects.index') }}" class='btn btn-secondary me-2'>Torna ai progetti</a>
          <button type='submit' class='btn btn-success'>Salva</button>
      </footer>
      </form>

      @section('script')
          <script>
              const slugInput = document.getElementById('slug');
              const titleInput = document.getElementById('title');

              titleInput.addEventListener('blur', () => {
                  slugInput.value = titleInput.value.toLowerCase().split(' ').join('-');
              });
          </script>
          <script>
              const placeholder = 'https://marcolanci.it/utils/placeholder.jpg';

              const thumbInput = document.getElementById('thumb');
              const thumbPreview = document.getElementById('thumb-preview');

              thumbInput.addEventListener('change', () => {
                  if (thumbInput.files && thumbInput.files[0]) {
                      const reader = new FileReader();
                      reader.readAsDataURL(thumbInput.files[0]);

                      reader.onload = e => {
                          thumbPreview.src = e.target.result;
                      }
                  } else thumbPreview.src = placeholder;
              })
          </script>
      @endsection
