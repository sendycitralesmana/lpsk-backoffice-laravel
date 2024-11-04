@extends('backoffice.layout.main')

@section('content')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Data Berita</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active">Data Berita</li>
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
                    <h3 class="card-title">Berita</h3>

                    <div class="card-tools">
                        {{-- <a href="/backoffice/news/tambah" class="btn btn-success btn-sm" title="Tambah">
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
                        @include('backoffice.news.modal.add')

                        <button type="button" class="btn btn-tool btn-sm" data-card-widget="collapse"
                            data-toggle="tooltip" title="Collapse">
                            <i class="fas fa-minus"></i></button>
                    </div>

                </div>
                <div class="card-body">

                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" news="alert">
                        <strong>Berhasil </strong>{{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif

                    @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" news="alert">
                        <strong>Gagal </strong>{{ session('error') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif

                    <div class="row">

                        @foreach ($newss as $news)
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-header">
                                    <div class="user-block">
                                        @if ( $news->user->foto != null )
                                        <img src="{{ Storage::disk('s3')->url($news->user->foto) }}" alt="">
                                        @else
                                        <img src="{{ asset('images/profile-default.jpg') }}" alt="">
                                        @endif
                                        <span class="username">
                                            <p>{{ $news->user->name }}</p>
                                        </span>
                                        <span class="description">Menambahkan berita -
                                            {{ $news->created_at }}</span>
                                    </div>
                                    <div class="card-tools">
                                        @if ($news->user_id == auth()->user()->id)
                                        <a href="/backoffice/news/{{ $news->id }}/detail" class="btn btn-tool btn-sm" title="Detail">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        <button type="button" class="btn btn-tool btn-sm" data-toggle="modal"
                                            data-target="#edit-{{ $news->id }}" title="Ubah">
                                            <span><i class="fa fa-edit"></i></span>
                                        </button>
                                        @include('backoffice.news.modal.edit')
                                        <button type="button" class="btn btn-tool btn-sm" data-toggle="modal"
                                            data-target="#delete-{{ $news->id }}" title="Hapus">
                                            <span><i class="fa fa-trash"></i></span>
                                        </button>
                                        @include('backoffice.news.modal.delete')
                                        @endif
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                                class="fas fa-minus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    @if ( $news->cover != null )
                                    <div class="text-center">
                                        <img src="{{ Storage::disk('s3')->url($news->cover) }}"
                                            class="img-fluid rounded" alt="" style="width: 40%; height: 240px">
                                    </div>
                                    @endif
                                    <h4 class="mt-2">
                                        <b>{{ $news->title }}</b>
                                    </h4>
                                    @if ( $news->news_category_id != null )
                                    <small> {{ $news->newsCategory->name }} </small>
                                    @endif
                                    <div class="mb-2" style="overflow: hidden;
                                        text-overflow: ellipsis;
                                        -webkit-line-clamp: 3;
                                        display: -webkit-box;
                                        -webkit-box-orient: vertical;">
                                        <p> {!! html_entity_decode($news->content) !!} </p>
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

                            @foreach($newss as $key => $news)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $news->newsCategory->name }}</td>
                                <td>{{ $news->title }}</td>
                                <td>{{ $news->content }}</td>
                                <td>
                                    @if ($news->cover)
                                    <img src="{{ Storage::disk('s3')->url($news->cover) }}" class="img-fluid rounded"
                                        style="width: 100px; height: 100px">
                                    @else
                                    <img src="{{ asset('images/no-image.jpg') }}" class="img-fluid rounded"
                                        style="width: 100px; height: 100px">
                                    @endif
                                </td>
                                <td>{{ $news->user->name }}</td>
                                <td>{{ $news->status }}</td>
                                <td>
                                    <a href="/backoffice/news/{{ $news->id }}/detail" class="btn btn-primary btn-sm"
                                        title="Detail">
                                        <i class="fa fa-eye"></i> Detail
                                    </a>
                                    <button class="btn btn-warning btn-sm" data-toggle="modal"
                                        data-target="#edit-{{ $news->id }}" title="Ubah">
                                        <i class="fa fa-edit"></i> Ubah
                                    </button>
                                    <button class="btn btn-danger btn-sm" data-toggle="modal"
                                        data-target="#delete-{{ $news->id }}" title="Hapus">
                                        <i class="fa fa-trash"></i> Hapus
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table> --}}

                    {{-- modal --}}
                    @foreach ($newss as $news)
                    @include('backoffice.news.modal.edit')
                    @include('backoffice.news.modal.delete')
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