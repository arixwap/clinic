@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="justify-content-center">
            <div class="card">
                <div class="card-header">{{ __('Edit Patient') }}</div>
                <div class="card-body">
                    <form action="{{ route('patient.update', $patient->id) }}" method="post">
                        {{-- CSRF and Method Form Laravel --}}
                        {{ csrf_field() }}
                        {{ method_field('PATCH') }}
                        {{-- End of - CSRF Method Form Laravel --}}
                        <div class="form-group">
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="patient-type-umum" name="patient_type" value="Umum" class="custom-control-input" {{ ( $patient->patient_type == 'Umum' ) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="patient-type-umum">Umum</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="patient-type-bpjs" name="patient_type" value="BPJS" class="custom-control-input" {{ ( $patient->patient_type == 'BPJS' ) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="patient-type-bpjs">BPJS</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>{{ __('Full Name') }}</label>
                            <input name="full_name" type="text" class="form-control" value="{{ $patient->full_name }}" required>
                        </div>
                        <div class="form-group">
                            <label>{{ __('Born Place') }}</label>
                            <input name="birthplace" type="text" class="form-control" value="{{ $patient->birthplace }}" required>
                        </div>
                        <div class="form-group">
                            <label>{{ __('Birthday') }}</label>
                            <input name="birthdate" type="date" class="form-control" value="{{ $patient->birthdate }}" required>
                        </div>
                        <div class="form-group">
                            <label>{{ __('Gender') }}</label>
                            <select name="gender" class="form-control" required>
                                <option value="">{{ __('-Select-') }}</option>
                                <option value="Male" {{ ( $patient->gender == 'Male' ) ? 'selected' : '' }}>{{ __('Male') }}</option>
                                <option value="Female" {{ ( $patient->gender == 'Female' ) ? 'selected' : '' }}>{{ __('Female') }}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>{{ __('Address') }}</label>
                            <textarea name="address" rows="3" class="form-control" required>{{ $patient->address }}</textarea>
                        </div>
                        <div class="form-group">
                            <label>{{ __('Phone') }}</label>
                            <input name="phone" type="tel" class="form-control" value="{{ $patient->phone }}" required>
                        </div>
                        <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                        <a href="{{ route('patient.index') }}" type="button" class="btn btn-secondary ml-3">{{ __('Back') }}</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
