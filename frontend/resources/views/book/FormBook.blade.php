@csrf

<div class="col-lg-12 mb-2">
    <div class="form-group">
        <label for="title_id" class="col-form-label">Titulo</label>
        <input type="text" name="title" id="title_id" placeholder="Titulo" class="form-control"
            @isset($book)
            value="{{ old('title', $book['title']) }}"
        @endisset>
    </div>

    @error('title')
        <div class="text-small text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="col-lg-12 mb-2">
    <div class="form-group">
        <label for="author_id" class="col-form-label">Autor</label>
        <input type="text" name="author" id="author_id" placeholder="Autor" class="form-control"
            @isset($book)
            value="{{ old('author', $book['author']) }}"
        @endisset>
    </div>

    @error('author')
        <div class="text-small text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="col-lg-12 mb-2">
    <div class="form-group">
        <label for="publication_year_id" class="col-form-label">Año de publicación</label>
        <input type="number" name="publication_year" id="publication_year_id" placeholder="Año de publicación"
            class="form-control"
            @isset($book)
            value="{{ old('publication_year', $book['publication_year']) }}"
        @endisset>
    </div>

    @error('publication_year')
        <div class="text-small text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="col-lg-12 mb-2">
    <div class="form-group">
        <label for="genre_id" class="col-form-label">Genero</label>
        <input type="text" name="genre" id="genre_id" placeholder="Genero" class="form-control"
            @isset($book)
            value="{{ old('genre', $book['genre']) }}"
        @endisset>
    </div>

    @error('genre')
        <div class="text-small text-danger">{{ $message }}</div>
    @enderror
</div>
