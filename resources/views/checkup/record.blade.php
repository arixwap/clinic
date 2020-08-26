@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="justify-content-center">
            <div class="card">
                <div class="card-header">{{ __('Medical Record') }}</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md form-group">
                            <label class="font-weight-bold">{{ __('Full Name') }}</label>
                            <input class="form-readonly" value="{{ $patient->name }}">
                        </div>
                        <div class="col-md-4 form-group">
                            <label class="font-weight-bold">{{ __('Phone') }}</label>
                            <input class="form-readonly" value="{{ $patient->phone }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label class="font-weight-bold">{{ __('Gender') }}</label>
                            <input class="form-readonly" value="{{ __($patient->gender) }}">
                        </div>
                        <div class="col-md-4 form-group">
                            <label class="font-weight-bold">{{ __('Born Place') }}</label>
                            <input class="form-readonly" value="{{ $patient->birthplace }}">
                        </div>
                        <div class="col-md-4 form-group">
                            <label class="font-weight-bold">{{ __('Birthday') }}</label>
                            <input class="form-readonly" value="{{ $patient->formatted_birthdate }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">{{ __('Address') }}</label>
                        <p class="form-readonly">{!! nl2br($patient->address) !!}</p>
                    </div>
                    <hr>
                    <div class="medical-records">
                        @foreach ( $checkups as $checkup )
                            <div class="item">
                                {{ $checkup->date }}
                                {{ $checkup->time_start }}
                                {{ $checkup->doctor->user->name }}
                                {{ $checkup->doctor->polyclinic }}
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
