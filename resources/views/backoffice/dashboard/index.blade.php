@extends('backoffice.layout.main')

@section('content')

<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Beranda</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item active">Beranda</li>
          </ol>
        </div>
      </div>
    </div>
</section>

<section class="content">

  <div class="row justify-content-center">

    @if (auth()->user()->role_id == 1)
      <div class="col-lg-3 col-4">
        <div class="small-box bg-primary">
          <div class="inner">
            <h3>{{ $applications->count() }}</h3>
            <p>Aplikasi</p>
          </div>
          <div class="icon">
            <i class="fas fa-desktop"></i>
          </div>
          <a href="/backoffice/application" class="small-box-footer">Lihat Detail <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      {{-- <div class="col-lg-3 col-4">
        <div class="small-box bg-primary">
          <div class="inner">
            <h3>{{ $services->count() }}</h3>
            <p>Layanan</p>
          </div>
          <div class="icon">
            <i class="fas fa-handshake"></i>
          </div>
          <a href="/backoffice/service" class="small-box-footer">Lihat Detail <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div> --}}
      <div class="col-lg-3 col-4">
        <div class="small-box bg-primary">
          <div class="inner">
            <h3>{{ $profiles->count() }}</h3>
            <p>Profil</p>
          </div>
          <div class="icon">
            <i class="fas fa-user"></i>
          </div>
          <a href="/backoffice/profile" class="small-box-footer">Lihat Detail <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
    @endif

    {{-- <div class="col-lg-3 col-4">
      <div class="small-box bg-primary">
        <div class="inner">
          <h3>{{ $roadmaps->count() }}</h3>
          <p>Peta jalan</p>
        </div>
        <div class="icon">
          <i class="fas fa-road"></i>
        </div>
        <a href="/backoffice/roadmap" class="small-box-footer">Lihat Detail <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div> --}}
    {{-- <div class="col-lg-3 col-4">
      <div class="small-box bg-primary">
        <div class="inner">
          <h3>{{ $settings->count() }}</h3>
          <p>Peraturan</p>
        </div>
        <div class="icon">
          <i class="fas fa-gear"></i>
        </div>
        <a href="/backoffice/setting" class="small-box-footer">Lihat Detail <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div> --}}
    <div class="col-lg-3 col-4">
      <div class="small-box bg-primary">
        <div class="inner">
          <h3>{{ $publications->count() }}</h3>
          <p>Publikasi</p>
        </div>
        <div class="icon">
          <i class="fas fa-edit"></i>
        </div>
        <a href="/backoffice/publication" class="small-box-footer">Lihat Detail <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <div class="col-lg-3 col-4">
      <div class="small-box bg-primary">
        <div class="inner">
          <h3>{{ $news->count() }}</h3>
          <p>Berita</p>
        </div>
        <div class="icon">
          <i class="fas fa-newspaper"></i>
        </div>
        <a href="/backoffice/news" class="small-box-footer">Lihat Detail <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
    {{-- <div class="col-lg-3 col-4">
      <div class="small-box bg-primary">
        <div class="inner">
          <h3>{{ $informations->count() }}</h3>
          <p>Informasi</p>
        </div>
        <div class="icon">
          <i class="fas fa-circle-info"></i>
        </div>
        <a href="/backoffice/information" class="small-box-footer">Lihat Detail <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div> --}}
  </div>

</section>

@endsection