@extends('layouts.main')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Dashboard</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Small boxes (Stat box) -->
                <div class="row">
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ $dataPelanggan }}</h3>

                                <p>Data Pelanggan</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-person-add"></i>
                            </div>
                            <a href="#" class="small-box-footer">More info <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $products }}<sup style="font-size: 20px"></sup></h3>
                                <p>Data Produk</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-bag"></i>
                            </div>
                            <a href="#" class="small-box-footer">More info <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3>{{ $orderDone }}</h3>

                                <p>Pesanan Berhasil</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-pie-graph"></i>
                            </div>
                            <a href="#" class="small-box-footer">More info <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3>{{ $orderIn }}</h3>

                                <p>Pesanan Masuk</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-person-add"></i>
                            </div>
                            <a href="#" class="small-box-footer">More info <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                </div>
                <!-- /.row -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="card card-default">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-bullhorn"></i>
                                    Selamat Datang!
                                </h3>
                            </div>

                            <div class="card-body">
                                <div class="callout callout-info">
                                    <h5>Halo! <strong>{{ Auth::user()->name }}</strong> </h5>
                                    <p>Buat Pelangganmu senang ya!😍😍</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header bg-primary text-white">
                                <h3 class="card-title mb-0">
                                    🎉 Pelanggan Ulang Tahun Hari Ini
                                </h3>
                            </div>
                            <div class="card-body">
                                @if ($birthdayCustomers->isEmpty())
                                    <div class="alert alert-info mb-0" role="alert">
                                        Tidak ada pelanggan yang berulang tahun hari ini.
                                    </div>
                                @else
                                    <div class="row">
                                        @foreach ($birthdayCustomers as $customer)
                                            <div class="col-12 mb-3">
                                                <div class="card border-left-success shadow-sm">
                                                    <div
                                                        class="card-body d-flex justify-content-between align-items-center">
                                                        <div>
                                                            <h5 class="mb-0">{{ $customer->user->name }}</h5>
                                                            <small class="text-muted">
                                                                🎂 {{ $customer->birth_date->format('d M Y') }}
                                                            </small>
                                                        </div>
                                                        <i class="fas fa-birthday-cake fa-2x text-warning"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>


                    </div>

        </section>
        <!-- /.content -->
    </div>
@endsection
