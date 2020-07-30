@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="justify-content-center">
            <div class="card">
                <div class="card-header">{{ __('Add Patient') }}</div>
                <div class="card-body">
                    <form action="{{ route('patient.store') }}" method="post">
                        {{-- CSRF and Method Form Laravel --}}
                        {{ csrf_field() }}
                        {{ method_field('POST') }}
                        {{-- End of - CSRF Method Form Laravel --}}
                        <div class="form-group">
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="patient-type-umum" name="patient_type" value="Umum" class="custom-control-input" checked>
                                <label class="custom-control-label" for="patient-type-umum">Umum</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="patient-type-bpjs" name="patient_type" value="BPJS" class="custom-control-input">
                                <label class="custom-control-label" for="patient-type-bpjs">BPJS</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>{{ __('Full Name') }}</label>
                            <input name="full_name" type="text" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>{{ __('Born Place') }}</label>
                            <input name="birthplace" type="text" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>{{ __('Birthday') }}</label>
                            <input name="birthdate" type="date" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>{{ __('Gender') }}</label>
                            <select name="gender" class="form-control" required>
                                <option value="">{{ __('-Select-') }}</option>
                                <option value="Male">{{ __('Male') }}</option>
                                <option value="Female">{{ __('Female') }}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>{{ __('Address') }}</label>
                            <textarea name="address" rows="3" class="form-control" required></textarea>
                        </div>
                        <div class="form-group">
                            <label>{{ __('Phone') }}</label>
                            <input name="phone" type="tel" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                        <a href="{{ route('patient.index') }}" type="button" class="btn btn-secondary ml-3">{{ __('Back') }}</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
