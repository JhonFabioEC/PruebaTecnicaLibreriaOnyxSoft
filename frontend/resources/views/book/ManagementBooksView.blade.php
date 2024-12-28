@extends('template')

@section('content')
    <div class="container d-flex justify-content-center align-items-center mt-3">
        <div class="card w-100">
            <div class="card-header d-flex flex-row justify-content-center align-items-center p-3 w-100">
                <h3 class="m-0 me-auto h-100" id="title">Lista de libros</h3>

                <a href="{{ route('create') }}" class="ms-2 btn btn-primary" title="Nuevo">
                    <i class="fas fa-plus-circle nav-icon"></i>
                </a>
            </div>

            <div class="card-body p-3 w-100">
                <div class="table-responsive p-1 w-100">
                    <table class="table table-striped table-hover table-bordered table-condensed display nowrap"
                        id="book_table" style="width: 100%">
                        <thead>
                            <tr>
                                <th></th>
                                <th data-priority="1">Titulo</th>
                                <th>Autor</th>
                                <th>Año de publicación</th>
                                <th>Genero</th>
                                <th data-priority="2">Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @isset($books)
                                @foreach ($books as $book)
                                    <tr>
                                        <td>{{ $book['id'] }}</td>
                                        <td>{{ $book['title'] }}</td>
                                        <td>{{ $book['author'] }}</td>
                                        <td>{{ $book['publication_year'] }}</td>
                                        <td>{{ $book['genre'] }}</td>
                                        <td>
                                            <div class="d-flex flex-row justify-content-center align-items-center gap-2">
                                                <a href="{{ route('edit', $book['id']) }}" class="btn btn-warning text-white"
                                                    title="Editar">
                                                    <i class="fas fa-edit nav-icon"></i>
                                                </a>

                                                <form action="{{ route('destroy', $book['id']) }}" method="post">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button class="btn btn-danger" title="Eliminar">
                                                        <i class="fas fa-minus-circle nav-icon"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @endisset
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        $(function() {
            $("#book_table").DataTable({
                "language": {
                    "lengthMenu": "Mostrar " +
                        `<select class="custom-select custom-select-sm form-control form-control-sm">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>` +
                        " registros por página",
                    "zeroRecords": "Nada encontrado - disculpa",
                    "info": "Mostrando la página _PAGE_ de _PAGES_",
                    "infoEmpty": "No hay datos disponibles",
                    "infoFiltered": "(filtrado de _MAX_ registros totales)",
                    "search": "Buscar:",
                    "paginate": {
                        "next": "Siguiente",
                        "previous": "Anterior"
                    },
                    "processing": "Procesando...",
                    "emptyTable": "No hay datos disponibles en la tabla"
                },
                "responsive": true,
                "lengthChange": true,
                "autoWidth": true,
                "columnDefs": [{
                        "responsivePriority": 1,
                        "targets": 0
                    },
                    {
                        "responsivePriority": 2,
                        "targets": -1
                    },
                    {
                        "targets": 0,
                        "visible": false,
                        "searchable": false,
                    },
                    {
                        "targets": [0, 5],
                        "orderable": false,
                        "searchable": false,
                    },
                ],
                "stateSave": true,
                "stateDuration": -1
            });
        });
    </script>

    @if (session('success'))
        <script>
            Swal.fire(
                'Exito!',
                '{{ session('success') }}',
                'success'
            )
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire(
                'Error!',
                '{{ session('error') }}',
                'error'
            )
        </script>
    @endif
@endsection
