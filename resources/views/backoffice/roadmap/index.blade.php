@extends('backoffice.layout.main')

@section('content')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Data Peta Jalan</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active">Data Peta Jalan</li>
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
                    <h3 class="card-title">Peta Jalan</h3>

                    <div class="card-tools">
                        {{-- <a href="/backoffice/roadmap/tambah" class="btn btn-success btn-sm" title="Tambah">
                            <i class="fas fa-plus"></i> Tambah
                        </a> --}}
                        <button title="Tambah" type="button" class="btn btn-success btn-sm" data-toggle="modal"
                            data-target="#tambah">
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
                        @include('backoffice.roadmap.modal.add')

                        <button type="button" class="btn btn-tool btn-sm" data-card-widget="collapse"
                            data-toggle="tooltip" title="Collapse">
                            <i class="fas fa-minus"></i></button>
                    </div>

                </div>
                <div class="card-body">

                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" roadmap="alert">
                        <strong>Berhasil </strong>{{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif

                    @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" roadmap="alert">
                        <strong>Gagal </strong>{{ session('error') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif

                    <div class="row">

                        @foreach ($roadmaps as $roadmap)
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-header">
                                    <div class="user-block">
                                        @if ( $roadmap->user->foto != null )
                                        <img src="{{ Storage::disk('s3')->url($roadmap->user->foto) }}" alt="" class="img-circle rounded">
                                        @else
                                        <img src="{{ asset('images/profile-default.jpg') }}" alt="" class="img-circle rounded">
                                        @endif
                                        <span class="username">
                                            <p>{{ $roadmap->user->name }}</p>
                                        </span>
                                        <span class="description">Menambahkan berita -
                                            {{ $roadmap->created_at }}</span>
                                    </div>
                                    <div class="card-tools">
                                        <a href="/backoffice/roadmap/{{ $roadmap->id }}/detail" class="btn btn-tool btn-sm" title="Detail">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        <button type="button" class="btn btn-tool btn-sm" data-toggle="modal"
                                            data-target="#edit-{{ $roadmap->id }}" title="Ubah">
                                            <span><i class="fa fa-edit"></i></span>
                                        </button>
                                        @include('backoffice.roadmap.modal.edit')
                                        <button type="button" class="btn btn-tool btn-sm" data-toggle="modal"
                                            data-target="#delete-{{ $roadmap->id }}" title="Hapus">
                                            <span><i class="fa fa-trash"></i></span>
                                        </button>
                                        @include('backoffice.roadmap.modal.delete')
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                                class="fas fa-minus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    @if ( $roadmap->cover != null )
                                    <div class="text-center">
                                        <img src="{{ Storage::disk('s3')->url($roadmap->cover) }}"
                                            class="img-fluid rounded" alt="" style="width: 40%; height: 240px">
                                    </div>
                                    @endif
                                    <h4 class="mt-2">
                                        <b>{{ $roadmap->title }}</b>
                                    </h4>
                                    {{-- @if ( $roadmap->roadmap_category_id != null )
                                    <small> {{ $roadmap->roadmapCategory->name }} </small>
                                    @endif --}}
                                    <div class="mb-2" style="overflow: hidden;
                                        text-overflow: ellipsis;
                                        -webkit-line-clamp: 3;
                                        display: -webkit-box;
                                        -webkit-box-orient: vertical;">
                                        <p> {!! html_entity_decode($roadmap->content) !!} </p>
                                    </div>
                                </div>

                            </div>
                        </div>
                        @endforeach

                    </div>

                    {{-- <table class="table table-bordered table-hover text-center" id="example1">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Kategori</th>
                                <th>Judul</th>
                                <th>Konten</th>
                                <th>Sampul</th>
                                <th>Penulis</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach($roadmaps as $key => $roadmap)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $roadmap->roadmapCategory->name }}</td>
                                <td>{{ $roadmap->title }}</td>
                                <td>{{ $roadmap->content }}</td>
                                <td>
                                    @if ($roadmap->cover)
                                    <img src="{{ Storage::disk('s3')->url($roadmap->cover) }}" class="img-fluid rounded"
                                        style="width: 100px; height: 100px">
                                    @else
                                    <img src="{{ asset('images/no-image.jpg') }}" class="img-fluid rounded"
                                        style="width: 100px; height: 100px">
                                    @endif
                                </td>
                                <td>{{ $roadmap->user->name }}</td>
                                <td>{{ $roadmap->status }}</td>
                                <td>
                                    <a href="/backoffice/roadmap/{{ $roadmap->id }}/detail" class="btn btn-primary btn-sm"
                                        title="Detail">
                                        <i class="fa fa-eye"></i> Detail
                                    </a>
                                    <button class="btn btn-warning btn-sm" data-toggle="modal"
                                        data-target="#edit-{{ $roadmap->id }}" title="Ubah">
                                        <i class="fa fa-edit"></i> Ubah
                                    </button>
                                    <button class="btn btn-danger btn-sm" data-toggle="modal"
                                        data-target="#delete-{{ $roadmap->id }}" title="Hapus">
                                        <i class="fa fa-trash"></i> Hapus
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table> --}}

                    {{-- modal --}}
                    @foreach ($roadmaps as $roadmap)
                    @include('backoffice.roadmap.modal.edit')
                    @include('backoffice.roadmap.modal.delete')
                    @endforeach

                </div>

            </div>

        </div>
    </div>

</section>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script type="text/javascript">
    $("#addImage").click(function () {
    
        $("#formInputImage").append(
            `
                <div class="" id="inputImage">
                    <div class="form-group">
                        <div class="d-flex justify-content-between">
                            <div>
                                <input type="file" name="image[]"
                                    class="form-control @if ($errors->has('image')) is-invalid @endif"
                                    value="{{ old('image') }}" required
                                    oninvalid="this.setCustomValidity('Gambar harus diisi')"
                                    oninput="this.setCustomValidity('')">
                            </div>
                            <div>
                                <button type="button" class="btn btn-danger" id="deleteImage">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            `
        );
    });

    $("#formInputImage").on('click', '#deleteImage', function () {
        $(this).parents('#inputImage').remove();
    });
</script>
<script type="text/javascript">
    $("#addVideo").click(function () {
    
        $("#formInputVideo").append(
            `
                <div class="" id="inputVideo">
                    <div class="form-group">
                        <div class="d-flex justify-content-between">
                            <div>
                                <input type="file" name="video[]"
                                    class="form-control @if ($errors->has('video')) is-invalid @endif"
                                    value="{{ old('video') }}" required
                                    oninvalid="this.setCustomValidity('Video harus diisi')"
                                    oninput="this.setCustomValidity('')">
                            </div>
                            <div>
                                <button type="button" class="btn btn-danger" id="deleteVideo">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            `
        );
    });

    $("#formInputVideo").on('click', '#deleteVideo', function () {
        $(this).parents('#inputVideo').remove();
    });
</script>
<script type="text/javascript">
    $("#addDocument").click(function () {
    
        $("#formInputDocument").append(
            `
                <div class="" id="inputDocument">
                    <div class="form-group">
                        <div class="d-flex justify-content-between">
                            <div>
                                <input type="file" name="document[]"
                                    class="form-control @if ($errors->has('document')) is-invalid @endif"
                                    value="{{ old('document') }}" required
                                    oninvalid="this.setCustomValidity('Dokumen harus diisi')"
                                    oninput="this.setCustomValidity('')">
                            </div>
                            <div>
                                <button type="button" class="btn btn-danger" id="deleteDocument">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            `
        );
    });

    $("#formInputDocument").on('click', '#deleteDocument', function () {
        $(this).parents('#inputDocument').remove();
    });
</script>

@endsection