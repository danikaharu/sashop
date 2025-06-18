@extends('layouts.homelayout')
@section('content')
<!--================Home Banner Area =================-->
<section class="banner_area">
  <div class="banner_inner d-flex align-items-center">
      <div class="container">
          <div class="banner_content d-md-flex justify-content-between align-items-center">
              <div class="mb-3 mb-md-0">
                  <h2>Biodata</h2>
                  <p>Update Biodata</p>
              </div>
              <div class="page_link">
                  <a href="{{ route('home.index') }}">Home</a>
                  <a href="{{ route('biodata.edit', $customer->id) }}">Update Biodata</a>
              </div>
          </div>
      </div>
  </div>
</section>
<!--================End Home Banner Area =================-->

{{--  --}}
<!--================Update Biodata =================-->
<section class="contact_area my-5">
  <div class="container">
      <form action="{{ route('biodata.update', $customer->id) }}" method="POST">
          @csrf
          @method('PUT')
          <div class="form-group">
              <label for="name">Nama</label>
              <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $customer->user->name) }}">
              @error('name')
                  <div class="invalid-feedback">{{ $message }}</div>
              @enderror
          </div>
          <div class="form-group">
              <label for="email">Email</label>
              <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $customer->user->email) }}">
              @error('email')
                  <div class="invalid-feedback">{{ $message }}</div>
              @enderror
          </div>
          <div class="form-group">
              <label for="phone">Telepon</label>
              <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone', $customer->phone) }}">
              @error('phone')
                  <div class="invalid-feedback">{{ $message }}</div>
              @enderror
          </div>
          <div class="form-group">
              <label for="address">Alamat</label>
              <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address">{{ old('address', $customer->address) }}</textarea>
              @error('address')
                  <div class="invalid-feedback">{{ $message }}</div>
              @enderror
          </div>
          <button type="submit" class="btn btn-primary">Update</button>
      </form>
  </div>
</section>
<!--================End Update Biodata =================-->

@endsection