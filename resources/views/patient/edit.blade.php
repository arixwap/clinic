@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="justify-content-center">
            <div class="card">
                <div class="card-header">{{ __('Edit Patient') }}</div>
                <div class="card-body">
                    <form action="{{ route('patient.update', $patient->id) }}" method="post" autocomplete="off">
                        {{-- CSRF and Method Form Laravel --}}
                        {{ csrf_field() }}
                        {{ method_field('PATCH') }}
                        {{-- End of - CSRF Method Form Laravel --}}
                        <div class="form-group">
                            <label>{{ __('Full Name') }}</label>
                            <input name="name" type="text" class="form-control" value="{{ $patient->name }}" required>
                        </div>
                        <div class="row">
                            <div class="col-md-4 form-group">
                                <label>{{ __('Gender') }}</label>
                                <select name="gender" class="form-control" required>
                                    <option value="">{{ __('-Select-') }}</option>
                                    <option value="Male" {{ ( $patient->gender == 'Male' ) ? 'selected' : '' }}>{{ __('Male') }}</option>
                                    <option value="Female" {{ ( $patient->gender == 'Female' ) ? 'selected' : '' }}>{{ __('Female') }}</option>
                                </select>
                            </div>
                            <div class="col-md-4 form-group">
                                <label>{{ __('Born Place') }}</label>
                                <input name="birthplace" type="text" class="form-control" value="{{ $patient->birthplace }}" required>
                            </div>
                            <div class="col-md-4 form-group">
                                <label>{{ __('Birthday') }}</label>
                                <input name="birthdate" type="text" class="form-control datepicker" data-alt-format="d MM yy" data-max-date="0" data-change-month="true" data-change-year="true" value="{{ $patient->birthdate }}" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>{{ __('Address') }}</label>
                            <textarea name="address" rows="3" class="form-control" required>{{ $patient->address }}</textarea>
                        </div>
                        <div class="form-group">
                            <label>{{ __('Phone') }}</label>
                            <input name="phone" type="tel" class="form-control" value="{{ $patient->phone }}">
                        </div>
                        <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                        <a href="{{ route('patient.index') }}" role="button" class="btn btn-secondary ml-3">{{ __('Back') }}</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
