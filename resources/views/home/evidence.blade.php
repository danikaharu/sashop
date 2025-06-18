@extends('layouts.homelayout')
@section('content')
    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <!--================Home Banner Area =================-->
    <section class="banner_area">
        <div class="banner_inner d-flex align-items-center">
            <div class="container">
                <div class="banner_content d-md-flex justify-content-between align-items-center">
                    <div class="mb-3 mb-md-0">
                        <h2>Periksa Pembayaran</h2>
                        <a href="{{ route('detailsOrder') }}" class="btn btn-sm btn-primary">
                            <i class="ti-arrow-left me-2"></i> Kembali
                        </a>
                    </div>
                    <div class="page_link">
                        <a href="index.html">Home</a>
                        <a href="checkout.html">Product Final Checkout</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--================End Home Banner Area =================-->
    <section class="checkout_area section_gap">
        <div class="container">
            <div class="billing_details">
                <div class="row">
                    <!-- Informasi Detail Transaksi -->
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <h4 class="mb-3">Detail Transaksi</h4>
                        <table class="table table-bordered">
                            <thead class="thead-light">
                                <tr>
                                    <th>Nama Barang</th>
                                    <th>Kode Barang</th>
                                    <th>Berat</th>
                                    <th>Kategori</th>
                                    <th>Sub Kategori</th>
                                    <th>Jumlah</th>
                                    <th>Harga Satuan</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $totalPrice = 0;
                                    $userPoints = auth()->user()->customer->point->points ?? 0;
                                    $maxDiscount = floor($userPoints / 100) * 10; // Diskon maksimal berdasarkan poin
                                    $discount = $maxDiscount > 100 ? 100 : $maxDiscount; // Maks diskon adalah 100%
                                @endphp
                                @foreach ($transaction->detailtransaction as $detail)
                                    <tr>
                                        <td>{{ $detail->product->productname }}</td>
                                        <td>{{ $detail->product->productcode }}</td>
                                        <td>{{ $detail->product->productweight }}</td>
                                        <td>{{ $detail->product->subcategory->category->name }}</td>
                                        <td>{{ $detail->product->subcategory->name }}</td>
                                        <td>{{ $detail->qty }}</td>
                                        <td>Rp {{ number_format($detail->price, 0, ',', '.') }}</td>
                                        <td>Rp {{ number_format($detail->qty * $detail->price, 0, ',', '.') }}</td>
                                    </tr>
                                    @php
                                        $totalPrice += $detail->qty * $detail->price;
                                    @endphp
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="7" class="text-right"><strong>Total Harga (sudah termasuk diskon
                                            produk)</strong></td>
                                    <td><strong>Rp. {{ number_format($totalPrice, 0, ',', '.') }}</strong></td>
                                </tr>

                                @if ($birthdayDiscountPercent > 0)
                                    <tr>
                                        <td colspan="7" class="text-right"><strong>Diskon Ulang Tahun</strong></td>
                                        <td>{{ $birthdayDiscountPercent }}%</td>
                                    </tr>
                                @endif

                                @if ($usePoints == 'true')
                                    <tr>
                                        <td colspan="7" class="text-right"><strong>Diskon Poin</strong></td>
                                        <td>{{ $pointsDiscountPercent }}%</td>
                                    </tr>
                                @endif

                                <tr>
                                    <td colspan="7" class="text-right"><strong>Total Setelah Diskon</strong></td>
                                    <td><strong>Rp. {{ number_format($totalAfterDiscount, 0, ',', '.') }}</strong></td>
                                </tr>

                            </tfoot>
                        </table>

                        <div class="form-check mb-3">
                            <input type="checkbox" {{ $usePoints ? 'checked' : '' }} class="form-check-input"
                                id="use-points">
                            <label for="use-points" class="form-check-label">Gunakan poin untuk diskon</label>
                        </div>

                        <div class="form-box">
                            <button class="btn btn-primary btn-block" id="pay-button">Bayar Sekarang</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('script')
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}">
    </script>

    <script type="text/javascript">
        document.getElementById('pay-button').onclick = function() {
            const usePoints = {{ $usePoints ? 'true' : 'false' }};
            const totalAfterDiscount = {{ $totalAfterDiscount }};
            const discount = {{ $discount }};

            snap.pay('{{ $transaction->snap_token }}', {
                onSuccess: function(result) {
                    // Kirim status penggunaan poin ke backend
                    window.location.href = "{{ route('paymentSuccess', ['id' => $transaction->id]) }}" +
                        "?use_points=" + (usePoints ? 1 : 0) + "&total_after_discount=" +
                        totalAfterDiscount + "&discount=" + discount;

                },
                onPending: function(result) {
                    console.log('Pending:', result);
                },
                onError: function(result) {
                    console.log('Error:', result);
                }
            });
        };
    </script>

    <script>
        $(document).ready(function() {
            $('#use-points').change(function() {
                // const totalPrice = {{ $totalPrice }};
                // const userPoints = {{ auth()->user()->customer->point->points ?? 0 }};
                // const maxDiscount = Math.floor(userPoints / 100) * 10; // Maks diskon berdasarkan poin
                // const discount = maxDiscount > 100 ? 100 : maxDiscount; // Diskon maksimal 100%
                // const totalAfterDiscount = totalPrice - (totalPrice * discount / 100);

                if ($(this).is(':checked')) {
                    // Tambahkan query parameter untuk use-points
                    window.location.href = "{{ route('detailsOrder.show', ['id' => $transaction->id]) }}" +
                        "?use_points=true";
                } else {
                    window.location.href = "{{ route('detailsOrder.show', ['id' => $transaction->id]) }}";
                }
            });
        });
    </script>
@endpush
