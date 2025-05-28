@extends('adminlte::page')

@section('title', 'Dasbor Simlitabmas')

@section('content_header')
    <h1 class="m-0 text-dark">Rencana</h1>
@stop
@php
    $hasilKerja = [
        [
            'id' => 1,
            'capaian' => 'Manual book penggunaan aplikasi modul penyusunan SKP yang lengkap dan informatif (Penugasan dari Ketua Tim Perencanaan dan Sistem Informasi)',
            'indikator' => [
                [
                    'id' => 1,
                    'teks' => 'Draft manual book penggunaan aplikasi modul penyusunan rencana SKP yang lengkap sesuai dengan ketentuan dan diselesaikan maksimal satu bulan sebelum kegiatan sosialisasi'
                ]
            ],
            'realisasi' => 'Draft manual book aplikasi untuk modul penyusunan rencana SKP telah selesai pada bulan April sesuai dengan proses bisnis aplikasi',
            'umpan_balik' => ''
        ]
    ]
@endphp
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                @include('penilaian::components.set-periode')
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                @php
                    switch (true) {
                        case 'Belum Dievaluasi':
                            $badgeClass = 'badge-secondary';
                            break;
                        case 'Belum Ajukan Realisasi':
                            $badgeClass = 'badge-danger';
                            break;
                        case 'Sudah Dievaluasi':
                            $badgeClass = 'badge-success';
                            break;
                        default:
                            $badgeClass = 'badge-secondary';
                            break;
                    }
                @endphp
                @if (is_null($rencana))
                    <div class="w-100 d-flex justify-content-end align-items-center p-4">
                        <form method="POST" action="{{ url('/penilaian/rencana/store') }}">
                            @csrf
                            <button type="submit" class="btn btn-primary">Buat SKP</button>
                        </form>
                    </div>
                @endif

                @include('penilaian::components.atasan-bawahan-section', ['pegawai' => $pegawai])
                <div class="bg-white p-4">
                    {{-- Hasil kerja --}}
                    <table class="table mb-0" style="width: 100%;">
                        <thead>
                            <tr>
                                <th colspan="5">Hasil Kerja</th>
                            </tr>
                            <tr>
                                <th colspan="2" style="width: 90%">A. Utama</th>
                                <th colspan="1" style="width: 10%">
                                    @if (!is_null($rencana))
                                        @include('penilaian::components.modal-create-hasil-kerja')
                                    @endif
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($rencana && count($rencana->hasilKerja) != 0)
                                @foreach ($rencana->hasilKerja as $index => $item)
                                    <tr>
                                        <th style="width: 0%;" scope="row">{{ $index + 1 }}</th>
                                        <td>
                                            <p>{{ $item['deskripsi'] }}</p>
                                            <span>Ukuran keberhasilan / Indikator Kinerja Individu, dan Target :</span>
                                            <ul>
                                                @foreach ($item->indikator as $indikator)
                                                    <li>{{ $indikator['deskripsi'] }}</li>
                                                @endforeach
                                            </ul>
                                        </td>
                                        <td style="width: 10%;">
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="5">-</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                    <table class="table mb-0" style="width: 100%;">
                        <thead>
                            <tr>
                                <th colspan="2" style="width: 90%">A. Tambahan</th>
                                <th colspan="1" style="width: 10%">
                                    @if (!is_null($rencana))
                                        @include('penilaian::components.modal-create-hasil-kerja')
                                    @endif
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tbody>
                                @foreach ($hasilKerja as $index => $item)
                                    <tr>
                                        <td colspan="5">-</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </tbody>
                    </table>
                    {{-- <table class="table mb-0" style="width: 100%;">
                        <thead>
                          <tr>
                            <th colspan="5">PERILAKU KERJA</th>
                          </tr>
                        </thead>
                        <tbody>
                            @if ($rencana && $rencana->perilakuKerja)
                                @foreach ($rencana->perilakuKerja as $index => $item)

                                @endforeach
                            @endif
                        </tbody>
                    </table> --}}
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
<style>
    textarea {
        border-color: #ced4da;
    }
    textarea:focus {
        outline: none !important;
        box-shadow: none !important;
    }
</style>
@stop

@push('js')
    @include('penilaian::evaluasi.script-periode')
    @include('penilaian::evaluasi.script-hasilkerja')
@endpush
