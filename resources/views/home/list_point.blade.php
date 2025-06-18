@extends('layouts.homelayout')
@section('content')
<!--================Home Banner Area =================-->
<section class="banner_area">
  <div class="banner_inner d-flex align-items-center">
      <div class="container">
          <div class="banner_content d-md-flex justify-content-between align-items-center">
              <div class="mb-3 mb-md-0">
                  <h2>Daftar Point</h2>
                  <p>Daftar point yang anda didapatkan</p>
              </div>
              <div class="page_link">
                  <a href="{{ route('home.index') }}">Home</a>
                  <a href="{{ route('points.index') }}">Point</a>
              </div>
          </div>
      </div>
  </div>
</section>
<!--================End Home Banner Area =================-->

<!--================List Point =================-->
<section class="list_point_area mt-4">
  <div class="container">
      <div class="list_point_inner row">
          <div class="col-lg-12">
              <div class="list_point_text text-center">
                  <h3>List Point</h3>
                  <p>Daftar point yang pernah didapatkan :</p>
              </div>
          </div>
          <div class="col-lg-12">
              <div class="list_point_table">
                  <table class="table">
                      <thead>
                          <tr>
                              <th scope="col">No</th>
                              <th scope="col">Tanggal</th>
                              <th scope="col">History Transaksi</th>
                              <th scope="col">Point</th>
                          </tr>
                      </thead>
                      <tbody>
                          @foreach ($daftarPoint as $points)
                          <tr>
                            <td>{{ $loop->iteration  }}</td>
                            <td>{{ \Carbon\Carbon::parse($points->created_at)->isoFormat('LLLL') }}</td>
                            <td>Rp. {{ number_format($points->total_payment, 0, ',', '.') }}</td>
                            <td>{{ floor($points->total_payment / 5000) . ' Point' }}</td>
                          </tr>
                          @endforeach
                      </tbody>
                  </table>
              </div>
          </div>
      </div>
  </div>
</section>
@endsection