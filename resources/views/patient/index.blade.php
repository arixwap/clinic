@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="justify-content-center">
            <div class="card">
                <div class="card-header">{{ __('Patient List') }}</div>
                <div class="card-body">
                    {{-- <a href="{{ route('patient.create') }}" role="button" class="btn btn-primary mb-3">{{ __('Add') }}</a> --}}
                    <form action="{{ route('patient.index') }}" method="get" autocomplete="off">
                        <div class="row">
                            <div class="col-9 form-group">
                                <input type="text" name="search" class="form-control" value="{{ $search }}" placeholder="{{ __('Search') }}">
                            </div>
                            <div class="col form-group">
                                <button type="submit" class="btn btn-secondary btn-block">{{ __('Search') }}</button>
                            </div>
                        </div>
                    </form>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">{{ __('ID Number') }}</th>
                                    <th scope="col">{{ __('Name') }}</th>
                                    <th scope="col">{{ __('Birthday') }}</th>
                                    <th scope="col" width="120">{{ __('Gender') }}</th>
                                    <th scope="col" width="250">{{ __("Address") }}</th>
                                    <th scope="col" class="text-center" width="150">{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach( $patients as $patient )
                                    <tr>
                                        <th class="align-middle" scope="row">{{ $loop->iteration }}</th>
                                        <td class="align-middle">{{ $patient->number }}</td>
                                        <td class="align-middle">{{ $patient->name }}</td>
                                        <td class="align-middle">{{ $patient->formatted_birthdate }}</td>
                                        <td class="align-middle">{{ __($patient->gender) }}</td>
                                        <td class="align-middle">{{ $patient->address }}</td>
                                        <td class="align-middle text-center">
                                            @unless ( Auth::user()->isRole('doctor') )
                                                <a href="{{ route('patient.edit', $patient->id) }}" role="button" class="btn btn-link text-secondary shadow-none"><i class="fa fa-pencil"></i></a>
                                                <button type="button" class="btn btn-link text-danger shadow-none" data-toggle="modal" data-target="#modal-form-delete" data-name="{{ $patient->name }}" data-url="{{ route('patient.destroy', $patient->id) }}"><i class="fa fa-times"></i></button>
                                                <br>
                                            @endunless
                                            <a href="{{ route('checkup.record', $patient->id) }}" role="button" class="btn btn-info btn-sm btn-block">{{ __('Medical Record') }}</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

{{-- Modal Form Delete --}}
@push('footer-before-script')
    <div class="modal fade" id="modal-form-delete" tabindex="-1" role="dialog" aria-labelledby="modal-delete-title" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <p class="h5 modal-title text-center" id="modal-delete-title">{{ __('Delete') }} <span class="name"></span></p>
                </div>
                <div class="modal-body">
                    <form action="#" method="POST" autocomplete="off">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                        <div class="row">
                            <div class="col">
                                <button type="submit" class="btn btn-danger btn-block">{{ __('Yes') }}</button>
                            </div>
                            <div class="col">
                                <button type="button" class="btn btn-secondary btn-block" data-dismiss="modal">{{ __('No') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endpush

{{-- Custom Script --}}
@push('footer-after-script')
    <script>
        // Delete Modal Function
        $('#modal-form-delete').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            let name = button.data('name');
            let url = button.data('url');

            $(this).find('form').attr('action', url);
            $(this).find('.name').html(name);
        })
    </script>
@endpush
