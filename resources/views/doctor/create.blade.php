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

                        <div class="form-group">
                            <label>Nama Lengkap</label>
                            <input name="full_name" type="text" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Username</label>
                            <input name="username" type="text" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input name="password" type="text" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Jenis Kelamin</label>
                            <select name="gender" class="form-control" required>
                                <option value="">-Pilih-</option>
                                <option value="Laki Laki">Laki Laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Alamat Lengkap</label>
                            <textarea name="address" rows="3" class="form-control" required></textarea>
                        </div>
                        <div class="form-group">
                            <label>Telephone</label>
                            <input name="phone" type="tel" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
