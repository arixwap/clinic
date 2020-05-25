@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="justify-content-center">
            <div class="card">
                <div class="card-header">Daftar Pasien</div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">{{ __('Name') }}</th>
                                <th scope="col">{{ __('Birthday') }}</th>
                                <th scope="col">{{ __('Gender') }}</th>
                                <th scope="col">{{ __("Address") }}</th>
                                <th scope="col" class="text-center">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach( $patients as $i => $patient )
                                <tr>
                                    <th scope="row">{{ $i + 1 }}</th>
                                    <td>{{ $patient->full_name }}</td>
                                    <td>{{ Date::parse($patient->birthdate)->format('d F Y') }}</td>
                                    <td>{{ __($patient->gender) }}</td>
                                    <td>{{ $patient->address }}</td>
                                    <td class="text-center">
                                        <form action="{{ route('patient.destroy', $patient->id) }}" method="POST">

                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}

                                            {{-- Link Edit - Sebenarnya ga harus dimasukan di dalam form. Tapi dimasukan kesini agar iconnya bisa sejajar di CSS --}}
                                            <a href="{{ route('patient.edit', $patient->id) }}" class="btn btn-link ml-auto">
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
