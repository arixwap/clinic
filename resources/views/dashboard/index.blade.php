@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="justify-content-center">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    {{-- @if ( Auth::user()->isDoctor() )
                        Selamat datang Dokter {{ Auth::user()->doctor->full_name }}
                    @else
                        Anda telah login!
                    @endif --}}
                    <div class="row">
                        <div class="col-md-6">
                            <div class="alert alert-primary">Pasien Hari Ini</div>
                            Poliklinik Umum | Poliklinik Gigi | Poliklinik Anak
                            <br>
                            09.00 - 11.00 | Dr. Sanjaya
                            <ul>
                                <li>Wayan Made (L) 30th</li>
                                <li>Adi Bagus (L) 30th</li>
                            </ul>
                            20.00 - 21.00 | Dr. Tirta
                            <ul>
                                <li>Ketut Gek (L) 30th</li>
                                <li>Putu Mita (L) 30th</li>
                            </ul>
                            <a href="{{ route('checkup.create') }}" class="btn btn-primary">Checkup Pasien Baru</a>
                            <button class="btn btn-secondary">Lihat Semua Jadwal Checkup</button>
                        </div>
                        <div class="col-md-6">
                            <div class="alert alert-primary">Jadwal Praktek Dokter Hari Ini</div>
                            Poliklinik Umum
                            <ul>
                                <li>09.00 - 11.00 - Dr. Sanjaya</li>
                                <li>10.00 - 12.00 - Dr. Adi</li>
                            </ul>
                            Poliklinik Anak
                            <ul>
                                <li class="text-danger">10.00 - 12.00 - Dr. Seto | Tidak Praktek - Acara Keluarga</li>
                            </ul>
                            Poliklinik Gigi
                            <ul>
                                <li>20.00 - 21.00 - Dr. Tirta</li>
                            </ul>
                        </div>
                    </div>
                    <div class="mt-5">
                        <div class="alert alert-primary">
                            Riwayat Kunjungan 1 Minggu Terakhir / 1 Bulan Terakhir
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
