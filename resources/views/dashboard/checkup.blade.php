@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="justify-content-center">
            <div class="card">
                <div class="card-header">{{ __('New Checkup') }}</div>
                <div class="card-body">
                    <form action="{{ route('checkup.store') }}" method="post" autocomplete="off">
                        {{-- CSRF and Method Form Laravel --}}
                        {{ csrf_field() }}
                        {{ method_field('POST') }}
                        {{-- End of - CSRF Method Form Laravel --}}
                        <div class="form-group">
                            <div class="btn-group-toggle" data-toggle="buttons">
                                <label class="btn btn-outline-primary active">
                                    <input type="radio" name="patient_type" value="general" checked> {{ __('General') }}
                                </label>
                                <label class="btn btn-outline-primary ml-2">
                                    <input type="radio" name="patient_type" value="bpjs"> {{ __('BPJS') }}
                                </label>
                            </div>
                        </div>
                        <div class="form-group bpjs-form" style="display: none">
                            <input type="text" class="form-control" placeholder="{{ __('Input BPJS number') }}" required>
                        </div>

                        <hr class="my-4">

                        <div class="form-group">
                            <div class="custom-control custom-switch-lg">
                                <input type="checkbox" name="new_patient" class="custom-control-input" id="checkbox-new-patient">
                                <label class="custom-control-label" for="checkbox-new-patient">{{ __('New Patient') }}</label>
                            </div>
                        </div>

                        <div class="search-patient-form form-group">
                            <input type="text" class="form-control search-patient" placeholder="{{ __('Search Patient') }}" required>
                            <small class="alert-input text-danger" style="display: none">{{ __('Patient not found') }}</small>
                            <input name="patient_id" type="hidden">
                        </div>

                        <div class="new-patient-form" style="display: none">
                            <div class="form-group">
                                <label>{{ __('Full Name') }}</label>
                                <input name="full_name" type="text" class="form-control" required>
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
                                    <input name="birthdate" class="form-control datepicker" data-alt-format="d M yy" data-max-date="0" data-change-month="true" data-change-year="true" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>{{ __('Address') }}</label>
                                <textarea name="address" rows="3" class="form-control" required></textarea>
                            </div>
                            <div class="form-group">
                                <label>{{ __('Phone') }}</label>
                                <input name="phone" type="tel" class="form-control" required>
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="form-group">
                            <label>{{ __('Complaints') }}</label>
                            <textarea name="description" rows="3" class="form-control" required></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label>{{ __('Polyclinic') }}</label>
                                <select name="polyclinic" class="form-control" required>
                                    <option value="">{{ __('Select Polyclinic') }}</option>
                                    @foreach ( $polyclinics as $polyclinic )
                                        <option value="{{ $polyclinic->value }}">{{ $polyclinic->value }}</option>
                                    @endforeach
                                </select>
                                <small class="alert-input text-danger" style="display: none">{{ __('Doctor not available') }}</small>
                            </div>
                            <div class="col-md-6 form-group disabled">
                                <label>{{ __('Doctor') }}</label>
                                <select name="doctor" class="form-control" required>
                                    <option value="">{{ __('Select Doctor') }}</option>
                                    @foreach ( $doctors as $doctor )
                                        <option value="{{ $doctor->id }}" class="has-value" data-polyclinic="{{ $doctor->polyclinic }}" style="display: none">{{ $doctor->full_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group disabled">
                                <label>{{ __('Checkup Date') }}</label>
                                <input name="checkup_date" class="form-control datepicker checkup-date" placeholder="{{ __('Select Date') }}" data-alt-format="DD, dd MM yy" data-min-date="0" data-max-date="+1y" required>
                            </div>
                            <div class="col-md-6 form-group disabled">
                                <label>{{ __('Checkup Time') }}</label>
                                <select name="checkup_time" class="form-control" required>
                                    <option value="">{{ __('Select Time') }}</option>
                                </select>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                        <a href="{{ route('home') }}" type="button" class="btn btn-secondary ml-2">{{ __('Back') }}</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('footer-after-script')
    <script>

        // Toggle patient type
        $('input[name="patient_type"]').change(function(){
            if ( $(this).val() == 'bpjs' ) {
                $('.bpjs-form').show();
            } else {
                $('.bpjs-form').hide();
            }
        })

        // Toggle input new patient
        $('input[name="new_patient"]').change(function(){
            if ( $(this).prop('checked') ) {
                $('.new-patient-form').show();
                $('.search-patient-form').hide();
            } else {
                $('.new-patient-form').hide();
                $('.search-patient-form').show();
            }
        })

        // Autocomplete search patient
        $('input.search-patient').autocomplete({
            minLength: 1,
            source: "{{ route('ajax') }}?ajax=searchPatient",
            response: function(event, ui) {
                if ( ui.content.length > 0 ) {
                    $(this).parent().find('.alert-input').hide();
                } else {
                    $(this).parent().find('.alert-input').show();
                }
            },
            select: function(event, ui) {
                $('input[name="patient_id"]').val(ui.item.id);
            }
        });

        // Hide patient not found warning on empty input
        $('input.search-patient').keyup( function() {
            if ( $(this).val() == '' ) $('.alert-patient-not-found').hide();
        })

        // Display matched doctor list on match with selected polyclinic
        $(document).on('change', 'select[name="polyclinic"]', function() {
            let polyclinic = $(this).val();
            let resetInputs = $('select[name="doctor"], input[name="checkup_date"], input.checkup-date, select[name="checkup_time"]');

            // Reset and hide related input
            resetInputs.val('');
            resetInputs.closest('.form-group').addClass('disabled');
            resetInputs.find('option.has-value').hide();
            $(this).parent().find('.alert-input').hide();

            let doctorOptions = $('select[name="doctor"] option[data-polyclinic="' + polyclinic + '"]');
            if ( doctorOptions.length > 0 ) {
                $('select[name="doctor"]').closest('.form-group').removeClass('disabled');
                doctorOptions.show();
            } else if ( $(this).val() != '' ) {
                $(this).parent().find('.alert-input').show();
            }
        })

        // Display checkup date on selected doctor
        $(document).on('change', 'select[name="doctor"]', function() {
            let resetInputs = $('input[name="checkup_date"], input.checkup-date, select[name="checkup_time"]');
            resetInputs.val('');
            resetInputs.closest('.form-group').addClass('disabled');
            resetInputs.find('option.has-value').hide();

            let doctorId = $(this).val();
            if ( doctorId ) {
                // Get selected doctor schedules
                $.get('{{ route("ajax") }}',
                    {
                        ajax : 'getDoctorSchedules',
                        doctor: doctorId
                    },
                    function(response) {
                        schedules = response;
                        initCheckupDates();

                        $('input[name="checkup_date"]').closest('.form-group').removeClass('disabled');
                    }
                );
            }
        })

        // Display checkup time on selected date
        $(document).on('change', 'input.checkup-date', function() {
            let targetInput = $('select[name="checkup_time"]');
            targetInput.val('');
            // targetInput.closest('.form-group').addClass('disabled');
            targetInput.find('option.has-value').remove();

            let indexDay = ['sun', 'mon', 'tue', 'wed', 'thu', 'fri', 'sat'];
            let selectedDate = new Date( $('input[name="checkup_date"]').val() );
            let selectedDay = indexDay[ selectedDate.getDay() ];
            let schedule = schedules.weekdays[selectedDay];

            schedule.times.forEach( function(item, index) {
                let option = $('<option></option>');

                option.addClass('has-value');
                option.attr('value', item.id);
                option.html(item.time_range);

                targetInput.append(option);
            });

            targetInput.closest('.form-group').removeClass('disabled');
        })

        let schedules;

        // Setup checkup date for close dates
        function initCheckupDates() {
            let closeWeekdays = [];
            let indexWeekday = {'sun': 0, 'mon': 1, 'tue': 2, 'wed': 3, 'thu': 4, 'fri': 5, 'sat': 6};

            for ( var day in schedules.weekdays ) {
                if ( ! schedules.weekdays[day].off ) closeWeekdays.push( indexWeekday[day] );
            }

            $('input.checkup-date').datepicker("option", {
                beforeShowDay: function(date) {
                    return [ $.inArray(date.getDay(), closeWeekdays) != -1 ];
                }
            });
        }

    </script>
@endpush
