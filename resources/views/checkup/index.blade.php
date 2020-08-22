@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="justify-content-center">
            <div class="card">
                <div class="card-header">{{ __('Checkup List') }}</div>
                <div class="card-body">
                    <form action="{{ route('checkup.index') }}" method="get" autocomplete="off">
                        <div class="form-group">
                            <a href="{{ route('checkup.create') }}" class="btn btn-primary">{{ __('New Checkup') }}</a>
                        </div>
                        <div class="row mt-4">
                            <div class="col-lg-4 form-group">
                                <select name="doctor" class="form-control">
                                    <option value="">{{ __('All Doctor') }}</option>
                                    @foreach ( $doctors as $doctor )
                                        <option value="{{ $doctor->id }}" {{ ($doctor->id == $selectedDoctor) ? 'selected' : '' }}>{{ $doctor->full_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col form-group">
                                <input type="text" name="search" class="form-control" value="{{ $search }}" placeholder="{{ __('Search by patient name, polyclinic or doctor') }}">
                            </div>
                            <div class="col-4 col-lg-2 form-group">
                                <button type="submit" class="btn btn-secondary btn-block">{{ __('Search') }}</button>
                                <div class="text-center">
                                    <small role="button" class="btn-reset text-danger ">{{ __('Reset') }}</small>
                                </div>
                            </div>
                        </div>
                        <div class="row btn-group-toggle" data-toggle="buttons">
                            <div class="col-md form-group">
                                <label class="btn btn-outline-info btn-block {{ ($view == 'incoming') ? 'active' : '' }}">
                                    <input type="radio" name="view" value="incoming" {{ ($view == 'incoming') ? 'checked' : '' }}> {{ __('Incoming Checkup') }}
                                </label>
                            </div>
                            <div class="col-md form-group">
                                <label class="btn btn-outline-success btn-block {{ ($view == 'done') ? 'active' : '' }}">
                                    <input type="radio" name="view" value="done" {{ ($view == 'done') ? 'checked' : '' }}> {{ __('Done Checkup') }}
                                </label>
                            </div>
                            <div class="col-md form-group">
                                <label class="btn btn-outline-secondary btn-block {{ ($view == 'all') ? 'active' : '' }}">
                                    <input type="radio" name="view" value="all" {{ ($view == 'all') ? 'checked' : '' }}> {{ __('All Checkup') }}
                                </label>
                            </div>
                            <div class="col-md form-group">
                                <label class="btn btn-outline-danger btn-block {{ ($view == 'cancel') ? 'active' : '' }}">
                                    <input type="radio" name="view" value="cancel" {{ ($view == 'cancel') ? 'checked' : '' }}> {{ __('Canceled Checkup') }}
                                </label>
                            </div>
                        </div>
                    </form>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">{{ __('Date') }}</th>
                                    <th scope="col">{{ __('Number') }}</th>
                                    <th scope="col">{{ __('Patient') }}</th>
                                    <th scope="col">{{ __('Polyclinic') }}</th>
                                    <th scope="col">{{ __('Doctor') }}</th>
                                    <th scope="col" class="text-center">{{ __('Action') }}</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach( $checkups as $checkup )
                                    <tr>
                                        <td class="align-middle">
                                            <strong>{{ Date::parse($checkup->date)->format('l, d F Y') }}</strong>
                                            <br>
                                            <small>{{ $checkup->time_range }}</small>
                                        </td>
                                        <td class="align-middle">{{ $checkup->line_number }}</td>
                                        <td class="align-middle">{{ $checkup->patient->full_name }}</td>
                                        <td class="align-middle">{{ $checkup->doctor->polyclinic }}</td>
                                        <td class="align-middle">{{ $checkup->doctor->full_name }}</td>
                                        <td class="align-middle text-center">
                                            <a href="{{ route('checkup.show', $checkup->id) }}" role="button" class="btn btn-info btn-block btn-sm">{{ __('View') }}</a>
                                        </td>
                                        <td class="align-middle text-center">
                                            @unless ( $checkup->is_done )
                                                <button type="button" class="btn btn-link text-success shadow-none" title="{{ __('Done') }}"><i class="fa fa-check"></i></button>
                                                <button type="button" class="btn btn-link text-danger shadow-none" title="{{ __('Cancel') }}"><i class="fa fa-times"></i></button>
                                            @endunless
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('footer-after-script')
    <script>

        // Autosubmit filter on click input view checkup
        $('input[name=view]').on('change', function() {
            $(this).closest('form').trigger('submit');
        })

        // Reset filter
        $('.btn-reset').click( function() {
            let form = $(this).closest('form');
            form.find('input[name=search]').val('');
            form.find('select[name=doctor]').val('');
            form.trigger('submit');
        })

    </script>
@endpush
