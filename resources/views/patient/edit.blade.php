@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="justify-content-center">
            <div class="card">
                <div class="card-header">Edit Pasien</div>
                <div class="card-body">
                    <form action="{{ route('patient.update', $patient->id) }}" method="post">
                        {{-- CSRF and Method Form Laravel --}}
                        {{ csrf_field() }}
                        {{ method_field('PATCH') }}
                        {{-- End of - CSRF Method Form Laravel --}}
                        <div class="form-group">
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="patient-type-umum" name="patient_type" value="Umum" class="custom-control-input" {{ ( $patient->patient_type == 'Umum' ) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="patient-type-umum">Umum</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="patient-type-bpjs" name="patient_type" value="BPJS" class="custom-control-input" {{ ( $patient->patient_type == 'BPJS' ) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="patient-type-bpjs">BPJS</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Nama Lengkap</label>
                            <input name="full_name" type="text" class="form-control" value="{{ $patient->full_name }}" required>
                        </div>
                        <div class="form-group">
                            <label>Tempat Lahir</label>
                            <input name="birthplace" type="text" class="form-control" value="{{ $patient->birthplace }}" required>
                        </div>
                        <div class="form-group">
                            <label>Tanggal Lahir</label>
                            <input name="birthdate" type="date" class="form-control" value="{{ $patient->birthdate }}" required>
                        </div>
                        <div class="form-group">
                            <label>Jenis Kelamin</label>
                            <select name="gender" class="form-control" required>
                                <option value="">-Pilih-</option>
                                <option value="Laki Laki" {{ ($patient->gender == 'Laki Laki') ? 'selected' : '' }}>Laki Laki</option>
                                <option value="Perempuan" {{ ($patient->gender == 'Perempuan') ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Alamat Lengkap</label>
                            <textarea name="address" rows="3" class="form-control" required>{{ $patient->address }}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Telephone</label>
                            <input name="phone" type="tel" class="form-control" value="{{ $patient->phone }}" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
