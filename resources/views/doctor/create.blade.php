@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="justify-content-center">
            <div class="card">
                <div class="card-header">{{ __('Add Doctor') }}</div>
                <div class="card-body">
                    <form action="{{ route('doctor.store') }}" method="post" autocomplete="off">
                        {{-- CSRF and Method Form Laravel --}}
                        {{ csrf_field() }}
                        {{ method_field('POST') }}
                        {{-- End of - CSRF Method Form Laravel --}}

                        <div class="h5">{{ __('Main Data') }}</div>
                        <hr>
                        <div class="form-group">
                            <label>{{ __('Full Name') }}</label>
                            <input name="name" type="text" class="form-control" required>
                        </div>
                        <div class="row">
                            <div class="col-md-4 form-group">
                                <label>{{ __('Gender') }}</label>
                                <select name="gender" class="form-control" required>
                                    <option value="">{{ __('-Select-') }}</option>
                                    <option value="Male">{{ __('Male') }}</option>
                                    <option value="Female">{{ __('Female') }}</option>
                                </select>
                            </div>
                            <div class="col-md-4 form-group">
                                <label>{{ __('Born Place') }}</label>
                                <input name="birthplace" type="text" class="form-control" required>
                            </div>
                            <div class="col-md-4 form-group">
                                <label>{{ __('Birthday') }}</label>
                                <input name="birthdate" type="text" class="form-control datepicker" data-alt-format="d MM yy" data-max-date="-15y" data-change-month="true" data-change-year="true" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>{{ __('Address') }}</label>
                            <textarea name="address" rows="3" class="form-control" required></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label>{{ __('Phone') }}</label>
                                <input name="phone" type="tel" class="form-control">
                            </div>
                            <div class="col-md-6 form-group">
                                <label>{{ __('Polyclinic') }}</label>
                                <select name="polyclinic" class="form-control" required>
                                    @foreach ( $polyclinics as $polyclinic )
                                        <option value="{{ $polyclinic->value }}">{{ $polyclinic->value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <br>

                        <div class="h5">{{ __('Doctor Data') }}</div>
                        <hr>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label>{{ __('University') }}</label>
                                <input name="university" type="text" class="form-control">
                            </div>
                            <div class="col-md-6 form-group">
                                <label>{{ __('Qualification') }}</label>
                                <select name="qualification" class="form-control" required>
                                    @foreach ( $qualifications as $qualification )
                                        <option value="{{ $qualification->value }}">{{ $qualification->value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label>{{ __('Doctor STR') }}</label>
                                <input name="str" type="text" class="form-control">
                            </div>
                            <div class="col-md-3 form-group">
                                <label>{{ __('Valid From') }}</label>
                                <input name="str_start_date" type="text" class="form-control datepicker" data-alt-format="d MM yy" data-change-month="true" data-change-year="true">
                            </div>
                            <div class="col-md-3 form-group">
                                <label>{{ __('Until') }}</label>
                                <input name="str_end_date" type="text" class="form-control datepicker" data-alt-format="d MM yy" data-change-month="true" data-change-year="true">
                            </div>
                        </div>
                        <br>

                        <div class="h5">{{ __('Account Data') }}</div>
                        <small>{{ __('Data for login to system') }}</small>
                        <hr>
                        <div class="form-group">
                            <label>{{ __('Email') }}</label>
                            <input name="email" type="text" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>{{ __('Password') }}</label>
                            <input name="password" type="password" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
                        <a href="{{ route('doctor.index') }}" role="button" class="btn btn-secondary ml-2">{{ __('Back') }}</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
