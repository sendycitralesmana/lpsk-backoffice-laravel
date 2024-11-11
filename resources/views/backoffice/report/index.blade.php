@extends('backoffice.layout.main')

@section('content')
    
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Data Laporan</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item active">Data Laporan</li>
          </ol>
        </div>
      </div>
    </div>
</section>

<section class="content">

    <div class="row justify-content-center">
        <div class="col-md-12">

            <!-- Default box -->
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">Laporan</h3>

                    <div class="card-tools">
                        {{-- <a href="/backoffice/report/tambah" class="btn btn-success btn-sm" title="Tambah">
                            <i class="fas fa-plus"></i> Tambah
                        </a> --}}
                        {{-- <button title="Tambah" type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#tambah">
                            <span class="fa fa-plus"></span> Tambah
                        </button> --}}

                        {{-- @if ($errors->any())
                            <script>
                                jQuery(function() {
                                    $('#tambah').modal('show');
                                });
                            </script>
                        @endif --}}

                        {{-- Modal --}}
                        {{-- @include('backoffice.report.modal.add') --}}

                        <button type="button" class="btn btn-tool btn-sm" data-card-widget="collapse"
                            data-toggle="tooltip" title="Collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>

                </div>
                <div class="card-body">

                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" report="alert">
                        <strong>Berhasil </strong>{{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif

                    @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" report="alert">
                        <strong>Gagal </strong>{{ session('error') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif

                    <table class="table table-bordered table-hover text-center" id="example1">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama</th>
                                <th>Identitas</th>
                                <th>Email</th>
                                <th>Jenis Kelamin</th>
                                <th>Deskripsi</th>
                                <th>Alamat</th>
                                <th>No Hp</th>
                                <th>Fax</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach($reports as $key => $report)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $report->name }}</td>
                                <td>{{ $report->identity }}</td>
                                <td>{{ $report->email }}</td>
                                <td>{{ $report->gender }}</td>
                                <td>{{ $report->description }}</td>
                                <td>{{ $report->address }}</td>
                                <td>{{ $report->phone }}</td>
                                <td>{{ $report->fax }}</td>
                                <td>
                                    <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete-{{ $report->id }}" title="Hapus">
                                        <i class="fa fa-trash"></i> Hapus
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{-- modal --}}
                    @foreach ($reports as $report)
                        {{-- @include('backoffice.report.modal.edit') --}}
                        @include('backoffice.report.modal.delete')
                    @endforeach

                </div>

            </div>

        </div>
    </div>

</section>

@endsection