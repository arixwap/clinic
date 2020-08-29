@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="justify-content-center">
            <div class="card">
                <div class="card-header">{{ __('Setting') }}</div>
                <div class="card-body">
                    <form action="{{ route('setting.store') }}" method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        {{ method_field('POST') }}
                        <div class="row">
                            <div class="col-lg-3 col-md-6 form-group">
                                <input type="file" name="logo" class="sr-only" id="upload-logo">
                                @if ( $logo )
                                    <input type="hidden" name="delete-logo">
                                    <button type="button" class="btn btn-danger btn-sm btn-delete-corner"><i class="fa fa-times"></i></button>
                                    <img src="{{ $logo }}" alt="{{ config('app.name') }}" class="img-fluid img-thumbnail">
                                    <label role="button" for="upload-logo" class="btn btn-secondary btn-block rounded-0 mt-2">{{ __('Change Logo') }}</label>
                                @else
                                    <label role="button" for="upload-logo" class="btn btn-secondary btn-block rounded-0 mt-2">{{ __('Upload Logo') }}</label>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('footer-after-script')
    <script>

        // Upload / change logo function
        $('input[name=logo]').change( function() {
            $(this).closest('form').trigger('submit');
        })

        // Delete logo function
        $('.btn-delete-corner').click( function() {
            $('input[name=delete-logo]').val('1');
            $(this).closest('form').trigger('submit');
        })

    </script>
@endpush
