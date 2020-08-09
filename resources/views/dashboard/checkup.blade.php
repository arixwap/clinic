@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="justify-content-center">
            <div class="card">
                <div class="card-header">{{ __('New Checkup') }}</div>
                <div class="card-body">
                    <form action="{{ route('checkup.store') }}" method="post">
                        {{-- CSRF and Method Form Laravel --}}
                        {{ csrf_field() }}
                        {{ method_field('POST') }}
                        {{-- End of - CSRF Method Form Laravel --}}
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
