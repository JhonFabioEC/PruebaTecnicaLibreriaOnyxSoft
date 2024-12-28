@extends('template')

@section('content')
    <div class="container d-flex justify-content-center align-items-center mt-3">
        <div class="col-6">
            <div class="card">
                <div class="card-header">
                    <h4>Crear libro</h4>
                </div>

                <div class="card-body">
                    <form action="{{ route('store') }}" method="POST">
                        @include('book.FormBook')

                        <div class="text-end mt-3">
                            <button type="submit" class="btn btn-primary">Crear</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
