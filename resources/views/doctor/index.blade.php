@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="justify-content-center">
            <div class="card">
                <div class="card-header">{{ __('Doctor List') }}</div>
                <div class="card-body">
                    <a href="{{ route('doctor.create') }}" class="btn btn-success mb-3">{{ __('Add') }}</a>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">{{ __('Name') }}</th>
                                <th scope="col">{{ __('Qualification') }}</th>
                                <th scope="col">{{ __("Polyclinic") }}</th>
                                <th scope="col"></th>
                                <th scope="col" class="text-center">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach( $doctors as $i => $doctor )
                                <tr>
                                    <th class="align-middle" scope="row">{{ $i + 1 }}</th>
                                    <td class="align-middle">{{ $doctor->full_name }}</td>
                                    <td class="align-middle">{{ __($doctor->qualification) }}</td>
                                    <td class="align-middle">{{ $doctor->polyclinic }}</td>
                                    <td class="align-middle"><a href="{{ route('schedule.index', $doctor->id) }}" class="btn btn-primary btn-sm btn-block">{{ __('Schedule') }}</a></td>
                                    <td class="align-middle text-center">
                                        <a href="{{ route('doctor.edit', $doctor->id) }}" class="btn btn-link text-secondary shadow-none"><i class="fa fa-pencil"></i></a>
                                        <button type="button" class="btn btn-link text-danger shadow-none" data-toggle="modal" data-target="#modal-form-delete" data-name="{{ $doctor->full_name }}" data-url="{{ route('doctor.destroy', $doctor->id) }}"><i class="fa fa-times"></i></button>
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

{{-- Modal Form Delete --}}
@push('footer-before-script')
    <div class="modal fade" id="modal-form-delete" tabindex="-1" role="dialog" aria-labelledby="modal-delete-title" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <p class="h5 modal-title text-center" id="modal-delete-title">{{ __('Delete') }} <span class="name"></span></p>
                </div>
                <div class="modal-body">
                    <form action="#" method="POST">
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
