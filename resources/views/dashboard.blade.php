@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="justify-content-center">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-md-6">
                            <div class="h5 font-weight-bold bg-primary text-white p-3 mb-3">{{ __('Today Patients') }}</div>
                            @unless ( Auth::User()->isRole('doctor') )
                                <ul class="nav nav-tabs" id="nav-patient" role="tablist">
                                    @foreach ( $polyclinics as $i => $polyclinic )
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link font-weight-bold {{ $i == 0 ? 'active' : '' }}" data-toggle="tab" href="{{ Str::kebab('#nav'.$polyclinic) }}" role="tab">{{ $polyclinic }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            @endunless
                            <div class="tab-content py-3" id="tab-patient">
                                @if ( Auth::User()->isRole('doctor') )
                                    <ul class="list-unstyled">
                                        @forelse ($checkups as $checkup)
                                            <li>
                                                <div class="row">
                                                    <div class="col"><a href="{{ route('checkup.show', $checkup->id) }}" class="text-primary"><span class="fa fa-external-link-square"></span></a>&emsp;{{ $checkup->line_number }} - {{ $checkup->patient->basic_info }}</div>
                                                    <div class="col-auto text-right">
                                                        <a href="#" role="button" class="cta text-success mx-1" data-toggle="modal" data-target="#modal-form-done" data-name="{{ __('Set done this checkup?') }}" data-is-done="1" data-url="{{ route('checkup.update', $checkup->id) }}"><span class="fa fa-check"></span></a>
                                                        <a href="#" role="button" class="cta text-danger mx-1" data-toggle="modal" data-target="#modal-form-delete" data-name="{{ $checkup->patient->name }}" data-url="{{ route('checkup.destroy', $checkup->id) }}"><span class="fa fa-times"></span></a>
                                                    </div>
                                                </div>
                                            </li>
                                        @empty
                                            <div class="text-muted font-weight-bold text-center my-5">{{ __('No Patient') }}</div>
                                        @endforelse
                                    </ul>
                                @else
                                    @foreach ( $polyclinics as $i => $poly )
                                        <div class="tab-pane fade {{ $i == 0 ? 'show active' : '' }}" id="{{ Str::kebab('nav'.$poly) }}" role="tabpanel">
                                            @forelse ( $checkups[$poly] as $scheduleCheckups )
                                                <div class="row font-weight-bold mb-2">
                                                    <div class="col-md">{{ $scheduleCheckups->doctor }}</div>
                                                    <div class="col-md text-right">{{ $scheduleCheckups->time_range }}</div>
                                                </div>
                                                <ul class="list-unstyled">
                                                    @foreach ($scheduleCheckups->checkups as $checkup)
                                                        <li>
                                                            <div class="row">
                                                                <div class="col"><a href="{{ route('checkup.show', $checkup->id) }}" class="text-primary"><span class="fa fa-external-link-square"></span></a>&emsp;{{ $checkup->line_number }} - {{ $checkup->patient->basic_info }}</div>
                                                                <div class="col-auto text-right">
                                                                    <a href="#" role="button" class="cta text-success mx-1" data-toggle="modal" data-target="#modal-form-done" data-name="{{ __('Set done this checkup?') }}" data-is-done="1" data-url="{{ route('checkup.update', $checkup->id) }}"><span class="fa fa-check"></span></a>
                                                                    <a href="#" role="button" class="cta text-danger mx-1" data-toggle="modal" data-target="#modal-form-delete" data-name="{{ $checkup->patient->name }}" data-url="{{ route('checkup.destroy', $checkup->id) }}"><span class="fa fa-times"></span></a>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                                <hr>
                                            @empty
                                                <div class="text-muted font-weight-bold text-center my-5">{{ __('No Patient') }}</div>
                                            @endforelse
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            @unless ( Auth::User()->isRole('doctor') )
                                <a href="{{ route('checkup.create') }}" class="btn btn-primary">{{ __('New Checkup') }}</a>
                            @endunless
                            <a href="{{ route('checkup.index') }}" class="btn btn-info ml-2">{{ __('See All') }}</a>
                        </div>
                        <div class="col-md-6">
                            <div class="h5 font-weight-bold bg-primary text-white p-3 mb-3">{{ __('Today Doctor Schedules') }}</div>
                            @foreach ( $polyclinics as $poly )
                                <div class="font-weight-bold mb-2">{{ $poly }}</div>
                                @if ( isset($todaySchedules[$poly]) )
                                    <ul class="list-unstyled">
                                        @foreach ( $todaySchedules[$poly] as $schedule )
                                            <li class="cta-hover">
                                                <div class="row">
                                                    <div class="col-4">{{ $schedule->time_range }}</div>
                                                    <div class="col font-weight-bold">|&emsp;{{ $schedule->doctor->nameIsMe() }}</div>
                                                    @unless ( Auth::User()->isRole('doctor') )
                                                        <div class="col-auto"><a href="{{ route('schedule.index', $schedule->doctor_id) }}" class="cta text-secondary"><span class="fa fa-pencil-square"></span></a></div>
                                                    @endunless
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <span class="text-muted">{{ __('No Schedule') }}</span>
                                @endif
                                <hr>
                            @endforeach
                            <button class="btn btn-primary" data-toggle="modal" data-target="#modal-weekday-schedule">{{ __('See All Schedules') }}</button>
                        </div>
                    </div>
                    {{-- WIP --}}
                    {{-- <div class="mt-5">
                        <div class="h5 font-weight-bold bg-primary text-white p-3 mb-3">{{ __('Riwayat Kunjungan 1 Minggu Terakhir / 1 Bulan Terakhir') }}</div>
                        <div id="chart-visitor"></div>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
@endsection

{{-- Modal Weekday Schedule --}}
@push('footer-before-script')
    <div class="modal fade" id="modal-weekday-schedule" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <button type="button" class="close btn btn-link text-secondary shadow-none" data-dismiss="modal" aria-label="Close">
                        <span class="fa fa-times" aria-hidden="true"></span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row justify-content-center">
                        @foreach ($weekdaySchedules as $day => $daySchedules)
                            <div class="col-md-6 my-3">
                                <div class="h5 font-weight-bold bg-primary text-white text-uppercase text-center py-2">{{ Date::parse($day)->format('l') }}</div>
                                @foreach ($daySchedules as $poly => $schedules)
                                    <div class="h5 font-weight-bold text-center">{{ $poly }}</div>
                                    <ul class="list-unstyled">
                                        @foreach ($schedules as $schedule)
                                            <li>
                                                <div class="row">
                                                    <div class="col text-right">{{ $schedule->time_range }}</div>
                                                    <div class="col text-left">{{ $schedule->doctor->nameIsMe() }}</div>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endpush

{{-- Modal Form Done --}}
@push('footer-before-script')
    <div class="modal fade" id="modal-form-done" tabindex="-1" role="dialog" aria-labelledby="modal-done-title" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <p class="h5 modal-title text-center" id="modal-done-title"><span class="name"></span></p>
                </div>
                <div class="modal-body">
                    <form action="#" method="POST" autocomplete="off">
                        {{ csrf_field() }}
                        {{ method_field('PATCH') }}
                        <input type="hidden" name="is_done">
                        <input type="hidden" name="redirect" value="{{ url()->full() }}">
                        <div class="row">
                            <div class="col">
                                <button type="submit" class="btn btn-success btn-block">{{ __('Yes') }}</button>
                            </div>
                            <div class="col">
                                <button type="button" class="btn btn-secondary btn-block" data-dismiss="modal">{{ __('No') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endpush

{{-- Modal Form Delete --}}
@push('footer-before-script')
    <div class="modal fade" id="modal-form-delete" tabindex="-1" role="dialog" aria-labelledby="modal-delete-title" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <p class="h5 modal-title text-center" id="modal-delete-title">{{ __('Canceling Checkup') }} <span class="name"></span>?</p>
                </div>
                <div class="modal-body">
                    <form action="#" method="POST" autocomplete="off">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                        <input type="hidden" name="redirect" value="{{ url()->full() }}">
                        <div class="row">
                            <div class="col">
                                <button type="submit" class="btn btn-danger btn-block">{{ __('Yes') }}</button>
                            </div>
                            <div class="col">
                                <button type="button" class="btn btn-secondary btn-block" data-dismiss="modal">{{ __('No') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endpush

@push('footer-after-script')
    <script>

        // Checkup Done & Delete Modal Function
        $('#modal-form-done, #modal-form-delete, #modal-form-restore').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            let name = button.data('name');
            let url = button.data('url');
            let isDone = button.data('is-done');

            $(this).find('form').attr('action', url);
            $(this).find('form input[name="is_done"]').val(isDone);
            $(this).find('.name').html(name);
        })

        // WIP-----------------------------------------------------------------------------------------
        $.get('{{ route("ajax") }}',
            {
                ajax : 'getVisitor',
                view : 'month',
                start_date : '2018-01-01',
                end_date : '2022-01-01'
            },
            function(response) {
                console.log(response);
            }
        );

        // WIP-----------------------------------------------------------------------------------------
        // Load the charts library with a callback
        // GoogleCharts.load(drawChart);
        // function drawChart() {
        //     // Standard google charts functionality is available as GoogleCharts.api after load
        //     const data = GoogleCharts.api.visualization.arrayToDataTable([
        //         ['Chart thing', 'Chart amount'],
        //         ['Lorem ipsum', 60],
        //         ['Dolor sit', 22],
        //         ['Sit amet', 18]
        //     ]);
        //     const pie_1_chart = new GoogleCharts.api.visualization.AreaChart(document.getElementById('chart-visitor'));
        //     pie_1_chart.draw(data);
        // }

    </script>
@endpush
