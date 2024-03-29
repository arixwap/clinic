@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="justify-content-center">
            <div class="card">
                <div class="card-header">{{ __('Medical Record') }}</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md form-group">
                            <label class="font-weight-bold">{{ __('Full Name') }}</label>
                            <input class="form-readonly" value="{{ $patient->name }}">
                        </div>
                        <div class="col-md-4 form-group">
                            <label class="font-weight-bold">{{ __('ID Number') }}</label>
                            <input class="form-readonly" value="{{ $patient->number }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md form-group">
                            <label class="font-weight-bold">{{ __('Gender') }}</label>
                            <input class="form-readonly" value="{{ __($patient->gender) }}">
                        </div>
                        <div class="col-md-5 form-group">
                            <label class="font-weight-bold">{{ __('Birth Place, Date') }}</label>
                            <input class="form-readonly" value="{{ $patient->birthplace . ', ' . $patient->formatted_birthdate }}">
                        </div>
                        <div class="col-md-4 form-group">
                            <label class="font-weight-bold">{{ __('Phone') }}</label>
                            <input class="form-readonly" value="{{ $patient->phone }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">{{ __('Address') }}</label>
                        <p class="form-readonly">{!! nl2br($patient->address) !!}</p>
                    </div>
                    @forelse ( $checkups as $checkup )
                        <div class="card border-primary my-4">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md h5 text-primary font-weight-bold">
                                        {{ $checkup->formatted_date }} | {{ $checkup->time_range }}
                                    </div>
                                    <div class="col-md h5 text-primary font-weight-bold">
                                        {{ $checkup->doctor->polyclinic }} | {{ $checkup->doctor->user->name }}
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md">
                                        <div class="font-weight-bold">{{ __('Complaints') }}</div>
                                        <div>{{ $checkup->description ?? '-' }}</div>
                                    </div>
                                    <div class="col-md">
                                        <div class="font-weight-bold">{{ __('Diagnosis') }}</div>
                                        <div>{{ $checkup->doctor_note ?? '-' }}</div>
                                    </div>
                                </div>
                                <a href="{{ route('checkup.show', $checkup->id) }}" role="button" class="btn btn-primary rounded-0 mt-3">{{ __('View') }}</a>
                            </div>
                        </div>
                    @empty
                        <p class="h4 font-weight-bold text-center py-5">{{ __('No Medical Record Data') }}</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
