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
                            <label class="sr-only">{{ __('Search Patient') }}</label>
                            <input type="text" class="form-control search-patient" placeholder="{{ __('Search Patient') }}">
                            <small class="alert-patient-not-found text-danger" style="display: none">{{ __('Patient not found') }}</small>
                            <input name="patient_id" type="hidden">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('footer-after-script')
    <script>

        // Autocomplete search patient
        $('input.search-patient').autocomplete({
            minLength: 1,
            source: "{{ route('patient.search-ajax') }}",
            response: function(event, ui) {
                if ( ui.content.length > 0 ) {
                    $('.alert-patient-not-found').hide();
                } else {
                    $('.alert-patient-not-found').show();
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

</script>
@endpush
