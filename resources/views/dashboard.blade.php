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
                            <div class="alert alert-primary">{{ __('Today Patients') }}</div>
                            <ul class="nav nav-tabs" id="nav-patient" role="tablist">
                                @foreach ( $polyclinics as $i => $polyclinic )
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link font-weight-bold {{ $i == 0 ? 'active' : '' }}" data-toggle="tab" href="{{ Str::kebab('#nav'.$polyclinic) }}" role="tab">{{ $polyclinic }}</a>
                                    </li>
                                @endforeach
                            </ul>
                            <div class="tab-content py-3" id="tab-patient">
                                @foreach ( $polyclinics as $i => $poly )
                                    <div class="tab-pane fade {{ $i == 0 ? 'show active' : '' }}" id="{{ Str::kebab('nav'.$poly) }}" role="tabpanel">
                                        @forelse ( $checkups[$poly] as $scheduleCheckups )
                                            <div class="row font-weight-bold mb-2">
                                                <div class="col-md">{{ $scheduleCheckups->doctor }}</div>
                                                <div class="col-md text-right">{{ $scheduleCheckups->time_range }}</div>
                                            </div>
                                            <ul class="list-unstyled">
                                                @foreach ($scheduleCheckups->checkups as $checkup)
                                                    <li>{{ $checkup->line_number }} - {{ $checkup->patient->basic_info }}</li>
                                                @endforeach
                                            </ul>
                                            <hr>
                                        @empty
                                            <div class="text-muted font-weight-bold text-center my-5">{{ __('No Patient') }}</div>
                                        @endforelse
                                    </div>
                                @endforeach
                            </div>
                            <a href="{{ route('checkup.create') }}" class="btn btn-primary">{{ __('New Checkup') }}</a>
                            <a href="{{ route('checkup.index') }}" class="btn btn-info ml-2">{{ __('See All') }}</a>
                        </div>
                        <div class="col-md-6">
                            <div class="alert alert-primary">{{ __('Today Doctor Schedules') }}</div>
                            @foreach ( $polyclinics as $poly )
                                <div class="font-weight-bold mb-2">{{ $poly }}</div>
                                @if ( isset($todaySchedules[$poly]) )
                                    <ul class="list-unstyled">
                                        @foreach ( $todaySchedules[$poly] as $schedule )
                                            <li>
                                                <div class="row">
                                                    <div class="col-4">{{ $schedule->time_range }}</div>
                                                    <div class="col font-weight-bold">|&emsp;{{ $schedule->doctor->user->name }}</div>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <span class="text-muted">{{ __('No Schedule') }}</span>
                                @endif
                                <hr>
                            @endforeach
                            <button class="btn btn-primary">{{ __('See All Schedules') }}</button>
                        </div>
                    </div>
                    {{-- <div class="mt-5">
                        <div class="alert alert-primary">
                            Riwayat Kunjungan 1 Minggu Terakhir / 1 Bulan Terakhir
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
@endsection
