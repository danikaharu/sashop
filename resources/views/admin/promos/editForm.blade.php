@extends('layouts.main')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Edit Promo Product</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Edit Promo</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-8">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Edit Data Promo</h3>
                            </div>
                            <form action="{{ route('promo.update', $promo->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="product_id">Pilih Product</label>
                                        <select id="product_id" name="product_id" class="form-control select2bs4"
                                            style="width: 100%;">
                                            <option disabled>Pilih Produk</option>
                                            @foreach ($products as $product)
                                                <option value="{{ $product->id }}"
                                                    {{ $promo->product_id == $product->id ? 'selected' : '' }}>
                                                    {{ $product->productcode }} | {{ $product->productname }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="discount">Discount</label>
                                        <span class="text-muted text-red">(1-100)</span>
                                        <input type="number" class="form-control" id="discount" name="discount"
                                            value="{{ old('discount', $promo->promo_discount) }}"
                                            placeholder="Masukan Discount" min="0" max="100" required>
                                    </div>
                                    @error('discount')
                                        <small class="text text-danger">{{ $message }}</small>
                                    @enderror

                                    <div class="form-group">
                                        <label>Pilih Waktu Promo</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="far fa-clock"></i></span>
                                            </div>
                                            <input type="text" class="form-control float-right" id="reservationtime"
                                                placeholder="Pilih waktu promo">
                                        </div>
                                        <!-- Hidden inputs for start and end date -->
                                        <input type="hidden" name="start_date" id="start_date_input"
                                            value="{{ $promo->startdate }}">
                                        <input type="hidden" name="end_date" id="end_date_input"
                                            value="{{ $promo->enddate }}">
                                    </div>

                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                    <div class="card-footer">
                                        <button type="submit"
                                            class="btn btn-primary float-right swalDefaultSuccess">Update</button>
                                        <a href="{{ route('promo.index') }}" class="btn btn-secondary">Kembali</a>
                                    </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('script')
    <script>
        $(function() {
            // Inisialisasi Daterangepicker dengan opsi time picker dan format tanggal
            $('#reservationtime').daterangepicker({
                timePicker: true,
                timePickerIncrement: 30,
                startDate: moment("{{ $promo->startdate }}", "YYYY-MM-DD"),
                endDate: moment("{{ $promo->enddate }}", "YYYY-MM-DD"),
                locale: {
                    format: 'MM/DD/YYYY'
                }
            }, function(start, end, label) {
                // Callback untuk mengupdate nilai hidden input untuk start dan end date
                $('#start_date_input').val(start.format('YYYY-MM-DD'));
                $('#end_date_input').val(end.format('YYYY-MM-DD'));
            });
        });
    </script>
@endsection
