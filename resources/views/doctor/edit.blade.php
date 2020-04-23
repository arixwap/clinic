@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="justify-content-center">
            <div class="card">
                <div class="card-header">Edit Dokter</div>
                <div class="card-body">
                    <form action="{{ route('doctor.update', $doctor->id) }}" method="post">
                        {{-- CSRF and Method Form Laravel --}}
                        {{ csrf_field() }}
                        {{ method_field('PATCH') }}
                        {{-- End of - CSRF Method Form Laravel --}}
                        <div class="form-group">
                            <label>Nama Lengkap</label>
                            <input name="full_name" type="text" class="form-control" value="{{ $doctor->full_name }}" required>
                        </div>
                        <div class="form-group">
                            <label>Tempat Lahir</label>
                            <input name="birthplace" type="text" class="form-control" value="{{ $doctor->birthplace }}" required>
                        </div>
                        <div class="form-group">
                            <label>Tanggal Lahir</label>
                            <input name="birthdate" type="date" class="form-control" value="{{ $doctor->birthdate }}" required>
                        </div>
                        <div class="form-group">
                            <label>Jenis Kelamin</label>
                            <select name="gender" class="form-control" required>
                                <option value="">-Pilih-</option>
                                <option value="Laki Laki" {{ ($doctor->gender == 'Laki Laki') ? 'selected' : '' }}>Laki Laki</option>
                                <option value="Perempuan" {{ ($doctor->gender == 'Perempuan') ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Alamat Lengkap</label>
                            <textarea name="address" rows="3" class="form-control" required>{{ $doctor->address }}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Telephone</label>
                            <input name="phone" type="tel" class="form-control" value="{{ $doctor->phone }}" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
