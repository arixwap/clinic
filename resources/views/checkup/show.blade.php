@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="justify-content-center">
            <div class="card">
                <div class="card-header">{{ __('Data Checkup') }}</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md h4">
                            <div class="row">
                                <div class="col-md-auto mb-2">
                                    <span class="badge badge-secondary w-100">{{ __('Number') }}&nbsp;{{ $checkup->line_number }}</span>
                                </div>
                                @if ( $checkup->new_patient )
                                    <div class="col-md-auto mb-2">
                                        <span class="badge badge-info w-100">{{ __('New Patient') }}</span>
                                    </div>
                                @endif
                                <div class="col-md-auto mb-2">
                                    @if ( $checkup->bpjs )
                                        <span class="badge badge-primary w-100">{{ __('BPJS') }}</span>
                                    @else
                                        <span class="badge badge-primary w-100">{{ __('General') }}</span>
                                    @endif
                                </div>
                            </div>
                            @if ( $checkup->bpjs )
                                <small>{{ __('BPJS Number') }} : <strong>{{ $checkup->bpjs }}</strong></small>
                            @endif
                        </div>
                        <div class="col-md-auto text-right">
                            <a href="{{ route('checkup.index') }}" role="button" class="btn btn-secondary"><i class="fa fa-chevron-left"></i> {{ __('Checkup List') }}</a>
                            @if ( $checkup->enableInputDiagnosis() )
                                <button class="btn btn-primary ml-2" data-toggle="modal" data-target="#modal-form-diagnosis"><i class="fa fa-pencil"></i> {{ __('Diagnosis') }}</button>
                            @endif
                            <a href="{{ route('checkup.record', $checkup->patient_id) }}" role="button" class="btn btn-info ml-2"><i class="fa fa-file-text-o"></i> {{ __('Medical Record') }}</a>
                            @if ( $checkup->isStatus('incoming') )
                                @unless ( Auth::user()->isRole('doctor') )
                                    <a href="{{ route('checkup.edit', $checkup->id) }}" role="button" class="btn btn-secondary ml-2"><i class="fa fa-pencil"></i> {{ __('Edit') }}</a>
                                @endunless
                                <button class="btn btn-success ml-2" data-toggle="modal" data-target="#modal-form-done" data-name="{{ __('Set done this checkup?') }}" data-is-done="1"><i class="fa fa-check"></i> {{ __('Done') }}</button>
                                <!--//-->
                                <button class="btn btn-danger ml-2" data-toggle="modal" data-target="#modal-form-delete" data-name="{{ $checkup->patient->name }}"><i class="fa fa-times"></i> {{ __('Cancel') }}</button>
                            @elseif ( $checkup->isStatus('done-undoable') )
                                <button class="btn btn-danger ml-2" data-toggle="modal" data-target="#modal-form-done" data-name="{{ __('Undo done this checkup?') }}" data-is-done="0" ><i class="fa fa-minus"></i> {{ __('Undo Done') }}</button>
                            @elseif ( $checkup->isStatus('cancel-undoable') )
                                <button class="btn btn-success ml-2" data-toggle="modal" data-target="#modal-form-restore" data-name="{{ $checkup->patient->name }}"><i class="fa fa-undo"></i> {{ __('Restore') }}</button>
                            @endif
                        </div>
                    </div>
                    <hr>
                    <div class="new-patient-form">
                        <div class="form-group">
                            <label class="font-weight-bold">{{ __('Full Name') }}</label>
                            <input class="form-readonly" value="{{ $checkup->patient->name }}">
                        </div>
                        <div class="row">
                            <div class="col-md-4 form-group">
                                <label class="font-weight-bold">{{ __('Gender') }}</label>
                                <input class="form-readonly" value="{{ __($checkup->patient->gender) }}">
                            </div>
                            <div class="col-md-4 form-group">
                                <label class="font-weight-bold">{{ __('Born Place') }}</label>
                                <input class="form-readonly" value="{{ $checkup->patient->birthplace }}">
                            </div>
                            <div class="col-md-4 form-group">
                                <label class="font-weight-bold">{{ __('Birthday') }}</label>
                                <input class="form-readonly" value="{{ $checkup->patient->formatted_birthdate }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">{{ __('Address') }}</label>
                            <p class="form-readonly">{!! nl2br($checkup->patient->address) !!}</p>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">{{ __('Phone') }}</label>
                            <input class="form-readonly" value="{{ $checkup->patient->phone }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">{{ __('Complaints') }}</label>
                        <p class="form-readonly">{!! nl2br($checkup->description) !!}</p>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label class="font-weight-bold">{{ __('Polyclinic') }}</label>
                            <input class="form-readonly" value="{{ $checkup->doctor->polyclinic }}">
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="font-weight-bold">{{ __('Doctor') }}</label>
                            <input class="form-readonly" value="{{ $checkup->doctor->user->name }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label class="font-weight-bold">{{ __('Checkup Date') }}</label>
                            <input class="form-readonly" value="{{ $checkup->formatted_date }}">
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="font-weight-bold">{{ __('Checkup Time') }}</label>
                            <input class="form-readonly" value="{{ $checkup->time_range }}">
                        </div>
                    </div>
                    @if ( $checkup->doctor_note )
                        <div class="form-group">
                            <label class="font-weight-bold">{{ __('Diagnosis') }}</label>
                            <p class="form-readonly">{!! nl2br($checkup->doctor_note) !!}</p>
                        </div>
                    @endif
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
                    <form action="{{ route('checkup.update', $checkup->id) }}" method="POST" autocomplete="off">
                        {{ csrf_field() }}
                        {{ method_field('PATCH') }}
                        <input type="hidden" name="is_done">
                        <input type="hidden" name="redirect" value="{{ url()->full() }}">
                        @if ( Auth::User()->isRole('doctor') )
                            <div class="form-only-doctor">
                                <div class="form-group">
                                    <label class="font-weight-bold">{{ __('Complaints') }}</label>
                                    <textarea name="description" rows="5" class="form-control">{{ $checkup->description }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label class="font-weight-bold">{{ __('Diagnosis') }}</label>
                                    <textarea name="doctor_note" rows="5" class="form-control">{{ $checkup->doctor_note }}</textarea>
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
                    <form action="{{ route('checkup.destroy', $checkup->id) }}" method="POST" autocomplete="off">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                        <input type="hidden" name="redirect" value="{{ url()->full() }}">
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
                    <form action="{{ route('checkup.restore', $checkup->id) }}" method="POST" autocomplete="off">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <input type="hidden" name="redirect" value="{{ url()->full() }}">
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

{{-- Modal Form Diagnosis --}}
@push('footer-before-script')
    <div class="modal fade" id="modal-form-diagnosis" tabindex="-1" role="dialog" aria-labelledby="modal-diagnosis-title" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <p class="h5 modal-title text-center" id="modal-diagnosis-title">{{ __('Write Diagnosis') }}</p>
                </div>
                <div class="modal-body">
                    <form action="{{ route('checkup.update', $checkup->id) }}" method="POST" autocomplete="off">
                        {{ csrf_field() }}
                        {{ method_field('PATCH') }}
                        <input type="hidden" name="redirect" value="{{ url()->full() }}">
                        <div class="form-group">
                            <textarea name="doctor_note" rows="5" class="form-control">{{ $checkup->doctor_note }}</textarea>
                        </div>
                        <div class="form-group">
                            <p class="text-danger">{{ __('Once submited, it can`t edited. Please make sure your data is correct!') }}</p>
                        </div>
                        <div class="row">
                            <div class="col">
                                <button type="submit" class="btn btn-success btn-block">{{ __('Submit') }}</button>
                            </div>
                            <div class="col">
                                <button type="button" class="btn btn-secondary btn-block" data-dismiss="modal">{{ __('Cancel') }}</button>
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

        // Modal Function
        $('#modal-form-done, #modal-form-delete, #modal-form-restore').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            let name = button.data('name');
            let url = button.data('url');
            let isDone = button.data('is-done');

            if ( isDone ) {
                $(this).find('.form-only-doctor').show();
            } else {
                $(this).find('.form-only-doctor').hide();
            }

            $(this).find('form').attr('action', url);
            $(this).find('form input[name="is_done"]').val(isDone);
            $(this).find('.name').html(name);
        })

    </script>
@endpush
