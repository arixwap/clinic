@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="justify-content-center">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if ( Auth::user()->isDoctor() )
                        Selamat datang Dokter {{ Auth::user()->doctor->full_name }}
                    @else
                        Anda telah login!
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
