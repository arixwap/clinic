@extends('layouts.app')

@section('content')
<div class="container">
    <div class="justify-content-center">
        <div class="card">
            <div class="card-header">Input Pasien Baru</div>
            <div class="card-body">
                <form action="{{ route('patient.store') }}" method="post">
                    @csrf
                    @method('POST')
                    <div class="form-group">
                        <label>Nama Lengkap</label>
                        <input name="full_name" type="text" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Tempat Lahir</label>
                        <input name="birthplace" type="text" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Tanggal Lahir</label>
                        <input name="birthdate" type="date" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
