@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="justify-content-center">
            <div class="card">
                <div class="card-header">Dokter Baru</div>
                <div class="card-body">
                    <form action="{{ route('doctor.store') }}" method="post">
                        {{-- CSRF and Method Form Laravel --}}
                        {{ csrf_field() }}
                        {{ method_field('POST') }}
                        {{-- End of - CSRF Method Form Laravel --}}

                        <div class="h5">Data Utama</div>
                        <hr>
                        <div class="form-group">
                            <label>Nama Lengkap</label>
                            <input name="full_name" type="text" class="form-control" required>
                        </div>
                        <div class="row">
                            <div class="col-md-4 form-group">
                                <label>Jenis Kelamin</label>
                                <select name="gender" class="form-control" required>
                                    <option value="">-Pilih-</option>
                                    <option value="Laki Laki">Laki Laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
                            </div>
                            <div class="col-md-4 form-group">
                                <label>Tempat Lahir</label>
                                <input name="birthplace" type="text" class="form-control" required>
                            </div>
                            <div class="col-md-4 form-group">
                                <label>Tanggal Lahir</label>
                                <input name="birthdate" type="date" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Alamat Lengkap</label>
                            <textarea name="address" rows="3" class="form-control" required></textarea>
                        </div>
                        <div class="form-group">
                            <label>Telepon</label>
                            <input name="phone" type="tel" class="form-control" required>
                        </div>
                        <br>

                        <div class="h5">Data Kedokteran</div>
                        <hr>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label>Universitas</label>
                                <input name="university" type="text" class="form-control">
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Kualifikasi</label>
                                <select name="qualification" class="form-control" required>
                                    @foreach ( $qualifications as $qualification )
                                        <option value="{{ $qualification }}">{{ $qualification }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label>Nomor STR Dokter (Surat Tanda Registrasi)</label>
                                <input name="str" type="text" class="form-control">
                            </div>
                            <div class="col-md-3 form-group">
                                <label>Berlaku Dari</label>
                                <input name="str_start_date" type="date" class="form-control">
                            </div>
                            <div class="col-md-3 form-group">
                                <label>Sampai</label>
                                <input name="str_end_date" type="date" class="form-control">
                            </div>
                        </div>
                        <br>

                        <div class="h5">Data Akun</div>
                        <small>Untuk keperluan login sistem</small>
                        <hr>
                        <div class="form-group">
                            <label>Email</label>
                            <input name="email" type="text" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input name="password" type="password" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
