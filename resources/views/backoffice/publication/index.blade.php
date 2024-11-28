@extends('backoffice.layout.main')

@section('content')
    
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Data Publikasi</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item active">Data Publikasi</li>
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
                    <h3 class="card-title">Publikasi</h3>

                    <div class="card-tools">
                        {{-- <a href="/backoffice/publication/tambah" class="btn btn-success btn-sm" title="Tambah">
                            <i class="fas fa-plus"></i> Tambah
                        </a> --}}
                        <button title="Tambah" type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#tambah">
                            <span class="fa fa-plus"></span> Tambah
                        </button>

                        {{-- @if ($errors->any())
                            <script>
                                jQuery(function() {
                                    $('#tambah').modal('show');
                                });
                            </script>
                        @endif --}}

                        {{-- Modal --}}
                        @include('backoffice.publication.modal.add')

                        <button type="button" class="btn btn-tool btn-sm" data-card-widget="collapse"
                            data-toggle="tooltip" title="Collapse">
                            <i class="fas fa-minus"></i></button>
                    </div>

                </div>
                <div class="card-body">

                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" publication="alert">
                        <strong>Berhasil </strong>{{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif

                    @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" publication="alert">
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
                                <th>Kategori</th>
                                <th>Nama Dokumen</th>
                                <th>Berkas</th>
                                <th>Sampul</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach($publications as $key => $publication)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $publication->publicationCategory->name }}</td>
                                <td>{{ $publication->document_name }}</td>
                                <td>
                                    @if ($publication->document_url)
                                        <a href="/backoffice/publication/{{ $publication->id }}/preview" class="btn btn-primary btn-sm" target="_blank">
                                            <i class="fa fa-file"></i> Lihat
                                        </a>
                                    @endif
                                </td>
                                <td>
                                    @if ( $publication->cover != null )
                                        <div class="text-center">
                                            <img src="{{ Storage::disk('s3')->url($publication->cover) }}"
                                                class="img-fluid rounded" alt="" style="width: 40%; height: 100px">
                                        </div>
                                        @else
                                        <div class="text-center">
                                            <img src="{{ asset('images/default_zz.webp') }}" class="img-fluid rounded"
                                                alt="" style="width: 40%; height: 100px">
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    @if ($publication->status == "DINAIKAN")
                                        <p class="badge badge-success">{{ $publication->status }}</p>
                                    @elseif ($publication->status == "DIAJUKAN")
                                        <p class="badge badge-warning">{{ $publication->status }}</p>
                                    @else
                                        <p class="badge badge-danger">{{ $publication->status }}</p>
                                    @endif
                                </td>
                                <td>
                                    <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#edit-{{ $publication->id }}" title="Ubah">
                                        <i class="fa fa-edit"></i> Ubah
                                    </button>
                                    <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete-{{ $publication->id }}" title="Hapus">
                                        <i class="fa fa-trash"></i> Hapus
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{-- modal --}}
                    @foreach ($publications as $publication)
                        @include('backoffice.publication.modal.edit')
                        @include('backoffice.publication.modal.delete')
                    @endforeach

                </div>

            </div>

        </div>
    </div>

</section>

@endsection