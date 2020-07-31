@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="justify-content-center">
            <div class="card">
                <div class="card-header">{{ __('Set Schedule') }}</div>
                <div class="card-body">
                    <form action="{{ route('schedule.edit', $doctor->id) }}" method="post">
                        {{-- CSRF and Method Form Laravel --}}
                        {{ csrf_field() }}
                        {{ method_field('POST') }}
                        {{-- End of - CSRF Method Form Laravel --}}

                        <div class="row">

                            <div class="weekday-group col-md-6 mb-3">
                                <div class="btn-group-toggle mb-3" data-toggle="buttons">
                                    <label class="btn-activated-weekday btn btn-outline-primary btn-block shadow-none">
                                        <input type="checkbox" name="weekday[]" value="mon"> {{ __('Monday') }}
                                    </label>
                                </div>
                                <div class="weekday-toggle">
                                    <div class="row mb-1">
                                        <div class="col-4">{{ __('Start Time') }}</div>
                                        <div class="col-4">{{ __('End Time') }}</div>
                                        <div class="col">{{ __('Patient Limit') }}</div>
                                    </div>
                                    <div class="time-group row">
                                        <div class="form-group col-4">
                                            <input type="time" name="mon_time_start[]" class="form-control" autocomplete="off" required>
                                        </div>
                                        <div class="form-group col-4">
                                            <input type="time" name="mon_time_end[]" class="form-control" autocomplete="off" required>
                                        </div>
                                        <div class="form-group col">
                                            <input type="number" name="limit[]" class="form-control" value="5" autocomplete="off" required>
                                        </div>
                                        <div class="form-group col-auto">
                                            <button class="btn-delete-time btn btn-link text-danger shadow-none" tabindex="-1"><span class="fa fa-times"></span></button>
                                        </div>
                                    </div>
                                    <button type="button" class="btn-add-time btn btn-primary btn-sm">{{ __('Add') }}</button>
                                    <hr>
                                </div>
                            </div>

                            <div class="weekday-group col-md-6 mb-3">
                                <div class="btn-group-toggle mb-3" data-toggle="buttons">
                                    <label class="btn-activated-weekday btn btn-outline-primary btn-block shadow-none">
                                        <input type="checkbox" name="weekday[]" value="tue"> {{ __('Tuesday') }}
                                    </label>
                                </div>
                                <div class="weekday-toggle">
                                    <div class="row mb-1">
                                        <div class="col-4">{{ __('Start Time') }}</div>
                                        <div class="col-4">{{ __('End Time') }}</div>
                                        <div class="col">{{ __('Patient Limit') }}</div>
                                    </div>
                                    <div class="time-group row">
                                        <div class="form-group col-4">
                                            <input type="time" name="tue_time_start[]" class="form-control" autocomplete="off" required>
                                        </div>
                                        <div class="form-group col-4">
                                            <input type="time" name="tue_time_end[]" class="form-control" autocomplete="off" required>
                                        </div>
                                        <div class="form-group col">
                                            <input type="number" name="limit[]" class="form-control" value="5" autocomplete="off" required>
                                        </div>
                                        <div class="form-group col-auto">
                                            <button class="btn-delete-time btn btn-link text-danger shadow-none" tabindex="-1"><span class="fa fa-times"></span></button>
                                        </div>
                                    </div>
                                    <button type="button" class="btn-add-time btn btn-primary btn-sm">{{ __('Add') }}</button>
                                    <hr>
                                </div>
                            </div>

                            <div class="weekday-group col-md-6 mb-3">
                                <div class="btn-group-toggle mb-3" data-toggle="buttons">
                                    <label class="btn-activated-weekday btn btn-outline-primary btn-block shadow-none">
                                        <input type="checkbox" name="weekday[]" value="wed"> {{ __('Wednesday') }}
                                    </label>
                                </div>
                                <div class="weekday-toggle">
                                    <div class="row mb-1">
                                        <div class="col-4">{{ __('Start Time') }}</div>
                                        <div class="col-4">{{ __('End Time') }}</div>
                                        <div class="col">{{ __('Patient Limit') }}</div>
                                    </div>
                                    <div class="time-group row">
                                        <div class="form-group col-4">
                                            <input type="time" name="wed_time_start[]" class="form-control" autocomplete="off" required>
                                        </div>
                                        <div class="form-group col-4">
                                            <input type="time" name="wed_time_end[]" class="form-control" autocomplete="off" required>
                                        </div>
                                        <div class="form-group col">
                                            <input type="number" name="limit[]" class="form-control" value="5" autocomplete="off" required>
                                        </div>
                                        <div class="form-group col-auto">
                                            <button class="btn-delete-time btn btn-link text-danger shadow-none" tabindex="-1"><span class="fa fa-times"></span></button>
                                        </div>
                                    </div>
                                    <button type="button" class="btn-add-time btn btn-primary btn-sm">{{ __('Add') }}</button>
                                    <hr>
                                </div>
                            </div>

                            <div class="weekday-group col-md-6 mb-3">
                                <div class="btn-group-toggle mb-3" data-toggle="buttons">
                                    <label class="btn-activated-weekday btn btn-outline-primary btn-block shadow-none">
                                        <input type="checkbox" name="weekday[]" value="thu"> {{ __('Thursday') }}
                                    </label>
                                </div>
                                <div class="weekday-toggle">
                                    <div class="row mb-1">
                                        <div class="col-4">{{ __('Start Time') }}</div>
                                        <div class="col-4">{{ __('End Time') }}</div>
                                        <div class="col">{{ __('Patient Limit') }}</div>
                                    </div>
                                    <div class="time-group row">
                                        <div class="form-group col-4">
                                            <input type="time" name="thu_time_start[]" class="form-control" autocomplete="off" required>
                                        </div>
                                        <div class="form-group col-4">
                                            <input type="time" name="thu_time_end[]" class="form-control" autocomplete="off" required>
                                        </div>
                                        <div class="form-group col">
                                            <input type="number" name="limit[]" class="form-control" value="5" autocomplete="off" required>
                                        </div>
                                        <div class="form-group col-auto">
                                            <button class="btn-delete-time btn btn-link text-danger shadow-none" tabindex="-1"><span class="fa fa-times"></span></button>
                                        </div>
                                    </div>
                                    <button type="button" class="btn-add-time btn btn-primary btn-sm">{{ __('Add') }}</button>
                                    <hr>
                                </div>
                            </div>

                            <div class="weekday-group col-md-6 mb-3">
                                <div class="btn-group-toggle mb-3" data-toggle="buttons">
                                    <label class="btn-activated-weekday btn btn-outline-primary btn-block shadow-none">
                                        <input type="checkbox" name="weekday[]" value="fri"> {{ __('Friday') }}
                                    </label>
                                </div>
                                <div class="weekday-toggle">
                                    <div class="row mb-1">
                                        <div class="col-4">{{ __('Start Time') }}</div>
                                        <div class="col-4">{{ __('End Time') }}</div>
                                        <div class="col">{{ __('Patient Limit') }}</div>
                                    </div>
                                    <div class="time-group row">
                                        <div class="form-group col-4">
                                            <input type="time" name="fri_time_start[]" class="form-control" autocomplete="off" required>
                                        </div>
                                        <div class="form-group col-4">
                                            <input type="time" name="fri_time_end[]" class="form-control" autocomplete="off" required>
                                        </div>
                                        <div class="form-group col">
                                            <input type="number" name="limit[]" class="form-control" value="5" autocomplete="off" required>
                                        </div>
                                        <div class="form-group col-auto">
                                            <button class="btn-delete-time btn btn-link text-danger shadow-none" tabindex="-1"><span class="fa fa-times"></span></button>
                                        </div>
                                    </div>
                                    <button type="button" class="btn-add-time btn btn-primary btn-sm">{{ __('Add') }}</button>
                                    <hr>
                                </div>
                            </div>

                            <div class="weekday-group col-md-6 mb-3">
                                <div class="btn-group-toggle mb-3" data-toggle="buttons">
                                    <label class="btn-activated-weekday btn btn-outline-primary btn-block shadow-none">
                                        <input type="checkbox" name="weekday[]" value="sat"> {{ __('Saturday') }}
                                    </label>
                                </div>
                                <div class="weekday-toggle">
                                    <div class="row mb-1">
                                        <div class="col-4">{{ __('Start Time') }}</div>
                                        <div class="col-4">{{ __('End Time') }}</div>
                                        <div class="col">{{ __('Patient Limit') }}</div>
                                    </div>
                                    <div class="time-group row">
                                        <div class="form-group col-4">
                                            <input type="time" name="sat_time_start[]" class="form-control" autocomplete="off" required>
                                        </div>
                                        <div class="form-group col-4">
                                            <input type="time" name="sat_time_end[]" class="form-control" autocomplete="off" required>
                                        </div>
                                        <div class="form-group col">
                                            <input type="number" name="limit[]" class="form-control" value="5" autocomplete="off" required>
                                        </div>
                                        <div class="form-group col-auto">
                                            <button class="btn-delete-time btn btn-link text-danger shadow-none" tabindex="-1"><span class="fa fa-times"></span></button>
                                        </div>
                                    </div>
                                    <button type="button" class="btn-add-time btn btn-primary btn-sm">{{ __('Add') }}</button>
                                    <hr>
                                </div>
                            </div>

                            <div class="weekday-group col-md-6 mb-3">
                                <div class="btn-group-toggle mb-3" data-toggle="buttons">
                                    <label class="btn-activated-weekday btn btn-outline-primary btn-block shadow-none">
                                        <input type="checkbox" name="weekday[]" value="sun"> {{ __('Sunday') }}
                                    </label>
                                </div>
                                <div class="weekday-toggle">
                                    <div class="row mb-1">
                                        <div class="col-4">{{ __('Start Time') }}</div>
                                        <div class="col-4">{{ __('End Time') }}</div>
                                        <div class="col">{{ __('Patient Limit') }}</div>
                                    </div>
                                    <div class="time-group row">
                                        <div class="form-group col-4">
                                            <input type="time" name="sun_time_start[]" class="form-control" autocomplete="off" required>
                                        </div>
                                        <div class="form-group col-4">
                                            <input type="time" name="sun_time_end[]" class="form-control" autocomplete="off" required>
                                        </div>
                                        <div class="form-group col">
                                            <input type="number" name="limit[]" class="form-control" value="5" autocomplete="off" required>
                                        </div>
                                        <div class="form-group col-auto">
                                            <button class="btn-delete-time btn btn-link text-danger shadow-none" tabindex="-1"><span class="fa fa-times"></span></button>
                                        </div>
                                    </div>
                                    <button type="button" class="btn-add-time btn btn-primary btn-sm">{{ __('Add') }}</button>
                                    <hr>
                                </div>
                            </div>

                        </div>

                        <hr>
                        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
                        <a href="{{ route('doctor.index') }}" type="button" class="btn btn-secondary ml-3">{{ __('Back') }}</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('footer-after-script')
    <script>

        // Button Active Weekday
        $(document).on('change', 'input[name="weekday[]"]', function() {
            let active = $(this).prop('checked');
            if ( active ) {
                $(this).closest('.weekday-group').addClass('active');
            } else {
                $(this).closest('.weekday-group').removeClass('active');
            }
        })

        // Button Add Time Function
        $(document).on('click', '.btn-add-time', function() {
            let group = $(this).closest('.weekday-group');
            let timeInputs = group.find('.time-group').first().clone();
            timeInputs.find('input[type="time"]').val('');
            group.find('.time-group').last().after(timeInputs);
        })

        // Button Delete Time Function
        $(document).on('click', '.btn-delete-time', function() {
            $(this).closest('.time-group').remove();
        })

    </script>
@endpush
