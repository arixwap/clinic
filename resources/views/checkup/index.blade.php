@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="justify-content-center">
            <div class="card">
                <div class="card-header">{{ __('Checkup List') }}</div>
                <div class="card-body">
                    <a href="{{ route('checkup.create') }}" class="btn btn-primary mb-3">{{ __('Add') }}</a>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">{{ __('Date') }}</th>
                                <th scope="col">{{ __('Number') }}</th>
                                <th scope="col">{{ __('Patient') }}</th>
                                <th scope="col">{{ __('Polyclinic') }}</th>
                                <th scope="col">{{ __('Doctor') }}</th>
                                <th scope="col" class="text-center">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach( $checkups as $checkup )
                                <tr>
                                    <td class="align-middle">
                                        <strong>{{ Date::parse($checkup->date)->format('d F Y') }}</strong>
                                        <br>
                                        <small>{{ $checkup->time_range }}</small>
                                    </td>
                                    <td class="align-middle">{{ $checkup->line_number }}</td>
                                    <td class="align-middle">{{ $checkup->patient->full_name }}</td>
                                    <td class="align-middle">{{ $checkup->doctor->polyclinic }}</td>
                                    <td class="align-middle">{{ $checkup->doctor->full_name }}</td>
                                    <td class="align-middle text-center">
                                        <a href="{{ route('checkup.show', $checkup->id) }}" class="btn btn-link text-secondary shadow-none" title="{{ __('View') }}"><i class="fa fa-external-link"></i></a>
                                        <button type="button" class="btn btn-link text-success shadow-none" title="{{ __('Done') }}"><i class="fa fa-check"></i></button>
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
