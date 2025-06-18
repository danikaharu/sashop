@extends('layouts.main')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Data Laporan Penjualan</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Laporan Penjualan</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Data Laporan Penjualan</h3>
                            </div>
                            <div class="card-body">
                                <form method="GET" action="{{ route('orderReport.index') }}" class="mb-4">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="start_date">Dari Tanggal</label>
                                            <input type="date" name="start_date" id="start_date" class="form-control"
                                                value="{{ request('start_date') }}">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="end_date">Sampai Tanggal</label>
                                            <input type="date" name="end_date" id="end_date" class="form-control"
                                                value="{{ request('end_date') }}">
                                        </div>
                                        <div class="col-md-4 d-flex align-items-end">
                                            <button type="submit" class="btn btn-primary mr-2">Filter</button>
                                            <a href="{{ route('orderReport.index') }}" class="btn btn-secondary">Reset</a>
                                        </div>
                                    </div>
                                </form>


                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Tanggal Pesanan</th>
                                            <th>Invoice</th>
                                            <th>Total Belanja</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $d)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ (new \Carbon\Carbon($d->created_at))->format('d F Y') }}</td>
                                                <td>{{ $d->numinvoice }}</td>
                                                <td>Rp. {{ number_format($d->totalPrice, 0) }}</td>
                                                <td>
                                                    @if ($d->status == 'Belum Bayar')
                                                        <span class="badge badge-warning">Belum Bayar</span>
                                                    @elseif($d->status == 'Diproses')
                                                        <span class="badge badge-info">Cek Bukti</span>
                                                    @elseif($d->status == 'Berhasil')
                                                        <span class="badge badge-success">Berhasil</span>
                                                    @else
                                                        <span class="badge badge-danger">Ditolak</span>
                                                    @endif
                                                    {{-- {{ $d->status }}</td> --}}
                                                <td>
                                                    <a href="{{ route('order.show', $d->id) }}"
                                                        class="btn btn-warning btn-sm">
                                                        <i class="fas fa-eye"></i> Lihat
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </section>

    </div>

    <!-- /.content-wrapper -->
@endsection
