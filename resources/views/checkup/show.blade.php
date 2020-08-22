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
                            <a href="{{ route('checkup.edit', $checkup->id) }}" role="button" class="btn btn-secondary rounded-0 ml-2" title="{{ __('Edit Checkup') }}"><i class="fa fa-pencil"></i></a>
                            <a href="#" role="button" class="btn btn-success rounded-0 ml-2" title="{{ __('Done Checkup') }}"><i class="fa fa-check"></i></a>
                            <a href="#" role="button" class="btn btn-danger rounded-0 ml-2" title="{{ __('Cancel Checkup') }}"><i class="fa fa-times"></i></a>
                        </div>
                    </div>
                    <hr>
                    <div class="new-patient-form">
                        <div class="form-group">
                            <label class="font-weight-bold">{{ __('Full Name') }}</label>
                            <input class="form-readonly" value="{{ $checkup->patient->full_name }}">
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
                            <textarea class="form-readonly">{{ $checkup->patient->address }}</textarea>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">{{ __('Phone') }}</label>
                            <input class="form-readonly" value="{{ $checkup->patient->phone }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">{{ __('Complaints') }}</label>
                        <textarea class="form-readonly">{{ $checkup->description }}</textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label class="font-weight-bold">{{ __('Polyclinic') }}</label>
                            <input class="form-readonly" value="{{ $checkup->doctor->polyclinic }}">
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="font-weight-bold">{{ __('Doctor') }}</label>
                            <input class="form-readonly" value="{{ $checkup->doctor->full_name }}">
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
                            <label class="font-weight-bold">{{ __('Doctor Notes') }}</label>
                            <textarea class="form-readonly">{{ $checkup->doctor_note }}</textarea>
                        </div>
                    @endif
                    <hr class="mt-5">
                    <div class="row">
                        <div class="col">
                            <a href="{{ route('checkup.index') }}" role="button" class="btn btn-secondary">{{ __('Back') }}</a>
                            <a href="#" role="button" class="btn btn-info ml-2">{{ __('Medical Record') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
