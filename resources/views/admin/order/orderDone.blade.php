@extends('layouts.main')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Data Order Masuk</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Orders</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        @if (@session()->has('success'))
                            <div class="alert alert-success alert-dismissible fade show mb-2" role="alert">
                                {{ session()->get('success') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                    </div>
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Data Products</h3>
                            </div>

                            <div class="card-body">
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
                                                <td>{{  (new \Carbon\Carbon($d->created_at))->format('d F Y')  }}</td>
                                                <td>{{ $d->numinvoice }}</td>
                                                <td>{{ number_format($d->totalPrice,0) }}</td>
                                                <td>
                                                    @if($d->status == "Berhasil")
                                                        <span class="badge badge-primary">Berhasil</span>
                                                    @endif

                                                </td>
                                                <td>
                                                    <a href="{{ route('order.show',$d->id)  }}"
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
