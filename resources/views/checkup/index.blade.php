@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="justify-content-center">
            <div class="card">
                <div class="card-header">{{ __('Checkup List') }}</div>
                <div class="card-body">
                    <form action="{{ route('checkup.index') }}" method="get" autocomplete="off">
                        @unless ( Auth::user()->isRole('doctor') )
                            <div class="form-group">
                                <a href="{{ route('checkup.create') }}" class="btn btn-primary">{{ __('New Checkup') }}</a>
                            </div>
                        @endunless
                        <div class="row mt-4">
                            <div class="col form-group">
                                <input name="start_date" type="text" class="form-control datepicker" placeholder="{{ __('Date From') }}" value="{{ $startDate }}" data-alt-format="DD, dd MM yy">
                            </div>
                            <div class="col form-group">
                                <input name="end_date" type="text" class="form-control datepicker" placeholder="{{ __('Date To') }}" value="{{ $endDate }}" data-alt-format="DD, dd MM yy">
                            </div>
                            @unless ( Auth::user()->isRole('doctor') )
                                <div class="col-lg-5 form-group">
                                    <select name="polyclinic" class="form-control">
                                        <option value="">{{ __('All Polyclinic') }}</option>
                                        @foreach ( $polyclinics as $polyclinic )
                                            <option {{ ($polyclinic->value == $selectedPolyclinic) ? 'selected' : '' }}>{{ $polyclinic->value }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @endunless
                        </div>
                        <div class="row">
                            <div class="col-8 col-lg-10 form-group">
                                <input type="text" name="search" class="form-control" value="{{ $search }}" placeholder="{{ __('Search by patient name, bpjs or doctor') }}">
                            </div>
                            <div class="col form-group">
                                <button type="submit" class="btn btn-secondary btn-block">{{ __('Search') }}</button>
                                <div class="text-center">
                                    <small role="button" class="btn-reset text-danger ">{{ __('Reset') }}</small>
                                </div>
                            </div>
                        </div>
                        <div class="row btn-group-toggle" data-toggle="buttons">
                            <div class="col-md form-group">
                                <label class="btn btn-outline-info btn-block {{ ($view == 'incoming') ? 'active' : '' }}">
                                    <input type="radio" name="view" value="incoming" {{ ($view == 'incoming') ? 'checked' : '' }}> {{ __('Incoming Checkup') }}
                                </label>
                            </div>
                            <div class="col-md form-group">
                                <label class="btn btn-outline-success btn-block {{ ($view == 'done') ? 'active' : '' }}">
                                    <input type="radio" name="view" value="done" {{ ($view == 'done') ? 'checked' : '' }}> {{ __('Done Checkup') }}
                                </label>
                            </div>
                            <div class="col-md form-group">
                                <label class="btn btn-outline-secondary btn-block {{ ($view == 'all') ? 'active' : '' }}">
                                    <input type="radio" name="view" value="all" {{ ($view == 'all') ? 'checked' : '' }}> {{ __('All Checkup') }}
                                </label>
                            </div>
                            <div class="col-md form-group">
                                <label class="btn btn-outline-danger btn-block {{ ($view == 'cancel') ? 'active' : '' }}">
                                    <input type="radio" name="view" value="cancel" {{ ($view == 'cancel') ? 'checked' : '' }}> {{ __('Canceled Checkup') }}
                                </label>
                            </div>
                        </div>
                    </form>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">{{ __('Date') }}</th>
                                    <th scope="col">{{ __('Number') }}</th>
                                    <th scope="col">{{ __('Patient') }}</th>
                                    <th scope="col">{{ __('Polyclinic') }}</th>
                                    <th scope="col">{{ __('Doctor') }}</th>
                                    <th scope="col" class="text-center">{{ __('Action') }}</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach( $checkups as $checkup )
                                    <tr>
                                        <td class="align-middle">
                                            <strong>{{ Date::parse($checkup->date)->format('l, d F Y') }}</strong>
                                            <br>
                                            <small>{{ $checkup->time_range }}</small>
                                        </td>
                                        <td class="align-middle">{{ $checkup->line_number }}</td>
                                        <td class="align-middle">
                                            {{ $checkup->patient->name }}
                                            @if ( $checkup->bpjs )
                                                &nbsp;
                                                <span class="badge badge-primary p-2">{{ __('BPJS') }}</span>
                                                <br>
                                                {{ $checkup->bpjs }}
                                            @endif
                                        </td>
                                        <td class="align-middle">{{ $checkup->doctor->polyclinic }}</td>
                                        <td class="align-middle">{{ $checkup->doctor->user->name }}</td>
                                        <td class="align-middle text-center">
                                            <a href="{{ route('checkup.show', $checkup->id) }}" role="button" class="btn btn-info btn-block btn-sm">{{ __('View') }}</a>
                                        </td>
                                        <td class="align-middle text-center">
                                            @if ( $checkup->enable('done') )
                                                <button type="button" class="btn btn-link text-success shadow-none" title="{{ __('Done') }}" data-toggle="modal" data-target="#modal-form-done" data-name="{{ __('Set done this checkup?') }}" data-is-done="1" data-description="{{ $checkup->description }}" data-diagnosis="{{ $checkup->doctor_note }}" data-url="{{ route('checkup.update', $checkup->id) }}"><i class="fa fa-check"></i></button>
                                            @endif
                                            @if ( $checkup->enable('cancel') )
                                                <button type="button" class="btn btn-link text-danger shadow-none" title="{{ __('Cancel') }}" data-toggle="modal" data-target="#modal-form-delete" data-name="{{ $checkup->patient->name }}" data-url="{{ route('checkup.destroy', $checkup->id) }}"><i class="fa fa-times"></i></button>
                                            @endif
                                            @if ( $checkup->enable('undone') )
                                                <button type="button" class="btn btn-link text-danger shadow-none" title="{{ __('Undo Done') }}" data-toggle="modal" data-target="#modal-form-done" data-name="{{ __('Undo done this checkup?') }}" data-is-done="0" data-url="{{ route('checkup.update', $checkup->id) }}"><i class="fa fa-minus"></i></button>
                                            @endif
                                            @if ( $checkup->enable('restore') )
                                                <button type="button" class="btn btn-link text-success shadow-none" title="{{ __('Restore') }}" data-toggle="modal" data-target="#modal-form-restore" data-name="{{ $checkup->patient->name }}" data-url="{{ route('checkup.restore', $checkup->id) }}"><i class="fa fa-undo"></i></button>
                                            @endif
                                            @if ( $checkup->enable('delete') )
                                                <button type="button" class="btn btn-link text-danger shadow-none" title="{{ __('Delete') }}" data-toggle="modal" data-target="#modal-form-delete" data-name="{{ $checkup->patient->name }}" data-url="{{ route('checkup.destroy', $checkup->id) }}"><i class="fa fa-trash"></i></button>
                                            @endif
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

{{-- Modal Form Done --}}
@push('footer-before-script')
    <div class="modal fade" id="modal-form-done" tabindex="-1" role="dialog" aria-labelledby="modal-done-title" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <p class="h5 modal-title text-center" id="modal-done-title"><span class="name"></span></p>
                </div>
                <div class="modal-body">
                    <form action="#" method="POST" autocomplete="off">
                        {{ csrf_field() }}
                        {{ method_field('PATCH') }}
                        <input type="hidden" name="is_done">
                        <input type="hidden" name="redirect" value="{{ url()->full() }}">
                        @if ( Auth::User()->isRole('doctor') )
                            <div class="form-only-doctor">
                                <div class="form-group">
                                    <p class="h5 font-weight-bold">{{ __('Input Patient Data') }}</p>
                                </div>
                                <div class="form-group">
                                    <label class="font-weight-bold">{{ __('Complaints') }}</label>
                                    <textarea name="description" rows="5" class="form-control"></textarea>
                                </div>
                                <div class="form-group">
                                    <label class="font-weight-bold">{{ __('Diagnosis') }}</label>
                                    <textarea name="doctor_note" rows="5" class="form-control"></textarea>
                                </div>
                                <div class="form-group">
                                    <p class="text-danger">{{ __('Once submited, it can`t edited. Please make sure your data is correct!') }}</p>
                                </div>
                            </div>
                        @endif
                        <div class="row">
                            <div class="col">
                                <button type="submit" class="btn btn-success btn-block">{{ __('Yes') }}</button>
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

{{-- Modal Form Delete --}}
@push('footer-before-script')
    <div class="modal fade" id="modal-form-delete" tabindex="-1" role="dialog" aria-labelledby="modal-delete-title" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <p class="h5 modal-title text-center" id="modal-delete-title">{{ __('Canceling Checkup') }} <span class="name"></span>?</p>
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

{{-- Modal Form Restore --}}
@push('footer-before-script')
    <div class="modal fade" id="modal-form-restore" tabindex="-1" role="dialog" aria-labelledby="modal-restore-title" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <p class="h5 modal-title text-center" id="modal-restore-title">{{ __('Restore Checkup') }} <span class="name"></span>?</p>
                </div>
                <div class="modal-body">
                    <form action="#" method="POST" autocomplete="off">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <div class="row">
                            <div class="col">
                                <button type="submit" class="btn btn-success btn-block">{{ __('Yes') }}</button>
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

@push('footer-after-script')
    <script>

        // Autosubmit filter on click input view checkup
        $('input[name=view], select[name=polyclinic]').on('change', function() {
            $(this).closest('form').trigger('submit');
        })

        // Reset filter
        $('.btn-reset').click( function() {
            let form = $(this).closest('form');
            form.find('input[name=start_date]').val('');
            form.find('input[name=end_date]').val('');
            form.find('input[name=search]').val('');
            form.find('select[name=doctor]').val('');
            form.trigger('submit');
        })

        // Checkup Done & Delete Modal Function
        $('#modal-form-done, #modal-form-delete, #modal-form-restore').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            let name = button.data('name');
            let url = button.data('url');
            let isDone = button.data('is-done');
            let description = button.data('description');
            let diagnosis = button.data('diagnosis');

            $(this).find('form').attr('action', url);
            $(this).find('form input[name="is_done"]').val(isDone);
            $(this).find('form textarea[name="description"]').val(description);
            $(this).find('form textarea[name="doctor_note"]').val(diagnosis);
            $(this).find('.name').html(name);
        })

    </script>
@endpush
