@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="justify-content-center">
            <div class="card">
                <div class="card-header">Daftar Dokter</div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">{{ __('Name') }}</th>
                                <th scope="col">{{ __('Gender') }}</th>
                                <th scope="col">{{ __("Address") }}</th>
                                <th scope="col" class="text-center">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach( $doctors as $i => $doctor )
                                <tr>
                                    <th scope="row">{{ $i + 1 }}</th>
                                    <td>{{ $doctor->full_name }}</td>
                                    <td>{{ $doctor->gender }}</td>
                                    <td>{{ $doctor->address }}</td>
                                    <td class="text-center">
                                        <form action="{{ route('doctor.destroy', $doctor->id) }}" method="POST">

                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}

                                            {{-- Link Edit - Sebenarnya ga harus dimasukan di dalam form. Tapi dimasukan kesini agar iconnya bisa sejajar di CSS --}}
                                            <a href="{{ route('doctor.edit', $doctor->id) }}" class="btn btn-link ml-auto">
                                                <i class="fa fa-pencil"></i>
                                            </a>

                                            {{-- Button untuk delete harus di dalam form yang berisi method_field('delete') --}}
                                            <button type="submit" class="btn btn-link mr-auto text-danger">
                                                <i class="fa fa-times"></i>
                                            </button>

                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
