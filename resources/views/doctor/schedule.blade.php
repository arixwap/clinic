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
                            @foreach ( $schedules as $index => $schedule )
                                <div class="weekday-group col-md-6 mb-3 @unless($schedule['off']) active @endunless">
                                    <div class="btn-group-toggle mb-3" data-toggle="buttons">
                                        <label class="btn-activated-weekday btn btn-outline-primary btn-block shadow-none">
                                            <input type="checkbox" name="weekday[]" value="{{ $index }}" @unless($schedule['off']) checked @endunless> {{ $schedule['day'] }}
                                        </label>
                                    </div>
                                    <div class="weekday-toggle">
                                        <div class="row mb-1">
                                            <div class="col-4">{{ __('Start Time') }}</div>
                                            <div class="col-4">{{ __('End Time') }}</div>
                                            <div class="col">{{ __('Patient Limit') }}</div>
                                        </div>
                                        @forelse ( $schedule['times'] as $time )
                                        <div class="time-group row">
                                            <div class="form-group col-4">
                                                    <input type="hidden" name="id_schedule[{{ $index }}][]" value="{{ $time->id }}">
                                                    <input type="time" name="time_start[{{ $index }}][]" class="form-control" value="{{ $time->time_start }}" autocomplete="off" required>
                                                </div>
                                                <div class="form-group col-4">
                                                    <input type="time" name="time_end[{{ $index }}][]" class="form-control" value="{{ $time->time_end }}" autocomplete="off" required>
                                                </div>
                                                <div class="form-group col">
                                                    <input type="number" name="limit[{{ $index }}][]" class="form-control" autocomplete="off" value="{{ $time->limit }}" placeholder="-" min="0">
                                                </div>
                                                <div class="form-group col-auto">
                                                    <button class="btn-delete-time btn btn-link text-danger shadow-none" title="{{ __('Delete') }}" tabindex="-1"><span class="fa fa-times"></span></button>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="time-group row">
                                                <div class="form-group col-4">
                                                    <input type="hidden" name="id_schedule[{{ $index }}][]">
                                                    <input type="time" name="time_start[{{ $index }}][]" class="form-control" autocomplete="off" required>
                                                </div>
                                                <div class="form-group col-4">
                                                    <input type="time" name="time_end[{{ $index }}][]" class="form-control" autocomplete="off" required>
                                                </div>
                                                <div class="form-group col">
                                                    <input type="number" name="limit[{{ $index }}][]" class="form-control" autocomplete="off" placeholder="-" min="0">
                                                </div>
                                                <div class="form-group col-auto">
                                                    <button class="btn-delete-time btn btn-link text-danger shadow-none" title="{{ __('Delete') }}" tabindex="-1"><span class="fa fa-times"></span></button>
                                                </div>
                                            </div>
                                        @endforelse
                                        <button type="button" class="btn-add-time btn btn-primary btn-sm">{{ __('Add Time') }}</button>
                                        <button type="button" class="btn-close-weekday btn btn-danger btn-sm ml-2">{{ __('Off Day') }}</button>
                                        <hr>
                                    </div>
                                </div>
                            @endforeach
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

        // Set inout disabled or enable inside weekday group
        function setInputWeekday() {
            $('.weekday-group').each( function() {
                $(this).find('.time-group input').prop('disabled', true);
                if ( $(this).hasClass('active') ) {
                    $(this).find('.time-group input').prop('disabled', false);
                }
            })
        }

        $(document).ready(function(){
            setInputWeekday();
        })

        // Button toggle weekday-group
        $(document).on('change', 'input[name="weekday[]"]', function() {
            let active = $(this).prop('checked');
            if ( active ) {
                $(this).closest('.weekday-group').addClass('active');
            } else {
                $(this).closest('.weekday-group').removeClass('active');
            }

            setInputWeekday();
        })

        // Button alternative close weekday-group
        $(document).on('click', '.btn-close-weekday', function() {
            $(this).closest('.weekday-group').find('input[name="weekday[]"]').trigger('click');
        })

        // Button add time
        $(document).on('click', '.btn-add-time', function() {
            let group = $(this).closest('.weekday-group');
            let timeInputs = group.find('.time-group').first().clone();
            timeInputs.find('input[type="hidden"]').val('');
            timeInputs.find('input[type="time"]').val('');
            group.find('.time-group').last().after(timeInputs);
        })

        // Button delete time
        $(document).on('click', '.btn-delete-time', function() {
            $(this).closest('.time-group').remove();
        })

    </script>
@endpush
