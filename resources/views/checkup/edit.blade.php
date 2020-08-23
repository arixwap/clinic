@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="justify-content-center">
            <div class="card">
                <div class="card-header">{{ __('Edit Checkup') }}</div>
                <div class="card-body">
                    <form action="{{ route('checkup.update', $checkup->id) }}" method="post" class="form-checkup" autocomplete="off">
                        {{-- CSRF and Method Form Laravel --}}
                        {{ csrf_field() }}
                        {{ method_field('PATCH') }}
                        {{-- End of - CSRF Method Form Laravel --}}
                        <div class="form-group">
                            <div class="btn-group-toggle" data-toggle="buttons">
                                <label class="btn btn-outline-primary font-weight-bold {{ ! $checkup->bpjs ? 'active' : '' }}">
                                <input type="radio" name="patient_type" value="general" {{ ! $checkup->bpjs ? 'checked' : '' }}> {{ __('General') }}
                                </label>
                                <label class="btn btn-outline-primary font-weight-bold ml-2 {{ $checkup->bpjs ? 'active' : '' }}">
                                    <input type="radio" name="patient_type" value="bpjs" {{ $checkup->bpjs ? 'checked' : '' }}> {{ __('BPJS') }}
                                </label>
                            </div>
                        </div>
                        <div class="form-group bpjs-form" style="{{ ! $checkup->bpjs ? 'display: none;' : '' }}">
                            <input name="bpjs" class="form-control" value="{{ $checkup->bpjs }}" placeholder="{{ __('Input BPJS number') }}" {{ ! $checkup->bpjs ? 'required disabled' : '' }}>
                        </div>

                        <hr class="my-4">

                        <div class="form-group">
                            <label>{{ __('Full Name') }}</label>
                            <input name="name" type="text" class="form-control" value="{{ $checkup->patient->name }}" required>
                            <input name="patient_id" type="hidden" value="{{ $checkup->patient_id }}" required>
                        </div>
                        <div class="row">
                            <div class="col-md-4 form-group">
                                <label>{{ __('Gender') }}</label>
                                <select name="gender" class="form-control" required>
                                    <option value="">{{ __('-Select-') }}</option>
                                    <option value="Male" {{ $checkup->patient->gender == 'Male' ? 'selected' : '' }}>{{ __('Male') }}</option>
                                    <option value="Female" {{ $checkup->patient->gender == 'Female' ? 'selected' : '' }}>{{ __('Female') }}</option>
                                </select>
                            </div>
                            <div class="col-md-4 form-group">
                                <label>{{ __('Born Place') }}</label>
                                <input name="birthplace" type="text" class="form-control" value="{{ $checkup->patient->birthplace }}" required>
                            </div>
                            <div class="col-md-4 form-group">
                                <label>{{ __('Birthday') }}</label>
                                <input name="birthdate" type="text" class="form-control datepicker" data-alt-format="d M yy" data-max-date="0" data-change-month="true" data-change-year="true" value="{{ $checkup->patient->birthdate }}" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>{{ __('Address') }}</label>
                            <textarea name="address" rows="3" class="form-control" required>{{ $checkup->patient->address }}</textarea>
                        </div>
                        <div class="form-group">
                            <label>{{ __('Phone') }}</label>
                            <input name="phone" type="tel" class="form-control" value="{{ $checkup->patient->phone }}" required>
                        </div>

                        <hr class="my-4">

                        <div class="form-group">
                            <label>{{ __('Complaints') }}</label>
                            <textarea name="description" rows="3" class="form-control" required>{{ $checkup->description }}</textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label>{{ __('Polyclinic') }}</label>
                                <select name="polyclinic" class="form-control" required>
                                    <option value="">{{ __('Select Polyclinic') }}</option>
                                    @foreach ( $polyclinics as $polyclinic )
                                        <option value="{{ $polyclinic->value }}" {{ $checkup->doctor->polyclinic == $polyclinic->value ? 'selected' : '' }}>{{ $polyclinic->value }}</option>
                                    @endforeach
                                </select>
                                <small class="alert-input text-danger" style="display: none">{{ __('Doctor not available') }}</small>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>{{ __('Doctor') }}</label>
                                <select name="doctor" class="form-control" required>
                                    <option value="">{{ __('Select Doctor') }}</option>
                                    @foreach ( $doctors as $doctor )
                                        <option value="{{ $doctor->id }}" class="has-value" data-polyclinic="{{ $doctor->polyclinic }}" {{ $checkup->doctor_id == $doctor->id ? 'selected' : '' }}>{{ $doctor->user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label>{{ __('Checkup Date') }}</label>
                                <input name="checkup_date" type="text" class="form-control datepicker checkup-date" placeholder="{{ __('Select Date') }}" data-alt-format="DD, dd MM yy" data-min-date="0" data-max-date="+1y" value="{{ $checkup->date }}" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>{{ __('Checkup Time') }}</label>
                                <select name="checkup_time" class="form-control" required>
                                    <option value="">{{ __('Select Time') }}</option>
                                    @foreach ( $schedules as $schedule )
                                        <option value="{{ $schedule->id }}" class="has-value" {{ $checkup->schedule_id == $schedule->id ? 'selected' : '' }}>{{ $schedule->time_range }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        @if ( Auth::user()->isRole('doctor') )
                            <div class="form-group">
                                <label>{{ __('Doctor Note') }}</label>
                                <textarea name="doctor_note" rows="3" class="form-control" required>{{ $checkup->doctor_note }}</textarea>
                            </div>
                        @endif

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

        let schedules = @json($checkup->doctor->formatSchedules());
        initDoctorList();
        initCheckupDates();

        // Initial doctor list on first load edit
        function initDoctorList() {
            let polyclinic = $('select[name=polyclinic]').val();

            $('select[name="doctor"] option.has-value').each( function() {
                if ( $(this).data('polyclinic') == polyclinic ) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        }

        // Prevent submit form on non new patient and empty input patient_id
        $('form.form-checkup').on('submit', function(event) {
            let isNewPatient = $('#checkbox-new-patient').prop('checked');
            let patientId = $('input[name="patient_id"]').val();

            if ( ! isNewPatient && ! patientId ) event.preventDefault();
        })

        // Toggle patient type
        $('input[name="patient_type"]').change(function(){
            if ( $(this).val() == 'bpjs' ) {
                $('.bpjs-form').show();
                $('.bpjs-form').find('input, select, textarea').prop('disabled', false);
            } else {
                $('.bpjs-form').hide();
                $('.bpjs-form').find('input, select, textarea').prop('disabled', true);
            }
        })

        // Toggle input new patient
        $('input[name="new_patient"]').change(function(){
            if ( $(this).prop('checked') ) {
                $('.new-patient-form').show();
                $('.new-patient-form').find('input, select, textarea').prop('disabled', false);
                $('.search-patient-form').hide();
                $('.search-patient-form').find('input, select, textarea').prop('disabled', true);
            } else {
                $('.new-patient-form').hide();
                $('.new-patient-form').find('input, select, textarea').prop('disabled', true);
                $('.search-patient-form').show();
                $('.search-patient-form').find('input, select, textarea').prop('disabled', false);
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
                    $('input[name="patient_id"]').val('');
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
