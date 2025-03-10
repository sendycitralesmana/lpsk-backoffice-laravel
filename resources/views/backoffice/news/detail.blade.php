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
        <div class="col-md-8">

            <div class="card card-outline card-primary">
                <div class="card-header">
                    <div class="user-block">
                        @if ( $news->user->foto != null )
                        <img src="{{ Storage::disk('s3')->url($news->user->foto) }}" alt="">
                        @else
                        <img src="{{ asset('images/backoffice/profile-default.jpg') }}" alt="">
                        @endif
                        <span class="username">
                            <p>{{ $news->user->name }}</p>
                        </span>
                        <span class="description">Menambahkan berita -
                            {{ $news->created_at }}</span>
                    </div>

                    <div class="card-tools">
                        <a href="/backoffice/news/{{ $news->id }}/edit" class="btn btn-tool btn-sm">
                            <span><i class="fa fa-edit"></i></span>
                        </a>
                        <button type="button" class="btn btn-tool btn-sm" data-toggle="modal"
                            data-target="#delete-{{ $news->id }}" title="Hapus">
                            <span><i class="fa fa-trash"></i></span>
                        </button>
                        @include('backoffice.news.modal.delete')
                        <button type="button" class="btn btn-tool btn-sm" data-card-widget="collapse"
                            data-toggle="tooltip" title="Collapse">
                            <i class="fas fa-minus"></i>
                        </button>
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

                    @if ( $news->cover != null )
                    <div class="text-center">
                        <img src="{{ Storage::disk('s3')->url($news->cover) }}" class="img-fluid rounded" alt=""
                            style="width: 50%; height: 400px">
                    </div>
                    @endif
                    @if ( $news->status == "DINAIKAN" )
                        <p class="badge badge-success">{{ $news->status }}</p>
                    @elseif ( $news->status == "DIAJUKAN" )
                        <p class="badge badge-warning">{{ $news->status }}</p>
                    @else
                        <p class="badge badge-danger">{{ $news->status }}</p>
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

        {{-- <div class="col-md-4">

            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">Dokumen Berita</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool btn-sm" data-toggle="modal"
                            data-target="#add-document-{{ $news->id }}" title="Tambah">
                            <span><i class="fa fa-add"></i></span>
                        </button>
                        @include('backoffice.news.modal.document.add')
                        <button type="button" class="btn btn-tool btn-sm" data-toggle="modal"
                            data-target="#document-delete-all-{{ $news->id }}" title="Hapus">
                            <span><i class="fa fa-trash"></i></span>
                        </button>
                        @include('backoffice.news.modal.document.delete-all')
                        <button type="button" class="btn btn-tool btn-sm" data-card-widget="collapse"
                            data-toggle="tooltip" title="Collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">

                    @if(session('successDocument'))
                    <div class="alert alert-success alert-dismissible fade show" news="alert">
                        <strong>Berhasil </strong>{{ session('successDocument') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif

                    <div class="slick-document">

                        @if ( $news->documents->count() > 0 )
                            @foreach ($news->documents as $document)
                            <div class="text-center pb-3 pt-3 rounded" style="border: 1px solid #dee2e6;">
                                <div>
                                    <i class="fa fa-file-pdf fa-3x"></i>
                                </div>
                                <div>
                                    <a href="/backoffice/news/{{ $news->id }}/document/{{ $document->id }}/preview" target="_blank" class="btn btn-tool">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    <button type="button" class="btn btn-tool btn-sm" data-toggle="modal"
                                        data-target="#edit-document-{{ $document->id }}" title="Tambah">
                                        <span><i class="fa fa-edit"></i></span>
                                    </button>
                                    <button type="button" class="btn btn-tool btn-sm" data-toggle="modal"
                                        data-target="#document-delete-{{ $document->id }}" title="Hapus">
                                        <span><i class="fa fa-trash"></i></span>
                                    </button>
                                </div>
                            </div>
                            @endforeach
                        @endif

                    </div>

                </div>
            </div>

            @foreach ($news->documents as $document)
                @include('backoffice.news.modal.document.edit')
                @include('backoffice.news.modal.document.delete')
            @endforeach

            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">Gambar Berita</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool btn-sm" data-toggle="modal"
                            data-target="#add-image-{{ $news->id }}" title="Tambah">
                            <span><i class="fa fa-add"></i></span>
                        </button>
                        @include('backoffice.news.modal.image.add')
                        <button type="button" class="btn btn-tool btn-sm" data-toggle="modal"
                            data-target="#image-delete-all-{{ $news->id }}" title="Hapus">
                            <span><i class="fa fa-trash"></i></span>
                        </button>
                        @include('backoffice.news.modal.image.delete-all')
                        <button type="button" class="btn btn-tool btn-sm" data-card-widget="collapse"
                            data-toggle="tooltip" title="Collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">

                    @if(session('successImage'))
                    <div class="alert alert-success alert-dismissible fade show" news="alert">
                        <strong>Berhasil </strong>{{ session('successImage') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif

                    <div class="slick-image">
                        @if ( $news->images->count() > 0 )
                            @foreach ($news->images as $image)
                                <div class="text-center">
                                    <div class="d-flex justify-content-between">
                                        <p class="text-left">{{ $image->name }}</p>
                                        <div>
                                            <button type="button" class="btn btn-tool btn-sm" data-toggle="modal"
                                                data-target="#edit-image-{{ $image->id }}" title="Tambah">
                                                <span><i class="fa fa-edit"></i></span>
                                            </button>
                                            
                                            <button type="button" class="btn btn-tool btn-sm" data-toggle="modal"
                                                data-target="#image-delete-{{ $image->id }}" title="Hapus">
                                                <span><i class="fa fa-trash"></i></span>
                                            </button>
                                            
                                        </div>
                                    </div>
                                    <div>
                                        <img src="{{ Storage::disk('s3')->url($image->url) }}" class="img-fluid rounded" alt=""
                                            style="width: 100%; height: 240px">
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>

                </div>
            </div>

            @foreach ($news->images as $image)
                @include('backoffice.news.modal.image.edit')
                @include('backoffice.news.modal.image.delete')
            @endforeach

            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">Video Berita</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool btn-sm" data-toggle="modal"
                            data-target="#add-video-{{ $news->id }}" title="Tambah">
                            <span><i class="fa fa-add"></i></span>
                        </button>
                        @include('backoffice.news.modal.video.add')
                        <button type="button" class="btn btn-tool btn-sm" data-toggle="modal"
                            data-target="#video-delete-all-{{ $news->id }}" title="Hapus">
                            <span><i class="fa fa-trash"></i></span>
                        </button>
                        @include('backoffice.news.modal.video.delete-all')
                        <button type="button" class="btn btn-tool btn-sm" data-card-widget="collapse"
                            data-toggle="tooltip" title="Collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">

                    @if(session('successVideo'))
                    <div class="alert alert-success alert-dismissible fade show" news="alert">
                        <strong>Berhasil </strong>{{ session('successVideo') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif

                    <div class="slick-video">
                        @if ( $news->videos->count() > 0 )
                            @foreach ($news->videos as $video)
                                <div class="text-center">
                                    <div class="d-flex justify-content-between">
                                        <p class="text-left">{{ $video->name }}</p>
                                        <div>
                                            <button type="button" class="btn btn-tool btn-sm" data-toggle="modal"
                                                data-target="#edit-video-{{ $video->id }}" title="Tambah">
                                                <span><i class="fa fa-edit"></i></span>
                                            </button>
                                            
                                            <button type="button" class="btn btn-tool btn-sm" data-toggle="modal"
                                                data-target="#video-delete-{{ $video->id }}" title="Hapus">
                                                <span><i class="fa fa-trash"></i></span>
                                            </button>
                                            
                                        </div>
                                    </div>
                                    <video src="{{ Storage::disk('s3')->url($video->url) }}" controls style="width: 100%; height: 240px"></video>
                                </div>
                            @endforeach
                        @endif
                    </div>

                </div>
            </div>

            @foreach ($news->videos as $video)
                @include('backoffice.news.modal.video.edit')
                @include('backoffice.news.modal.video.delete')
            @endforeach

        </div> --}}
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
                                <input type="file" name="image[]" accept="image/*"
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
                                <input type="file" name="video[]" accept="video/*"
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
                                <input type="file" name="document[]" accept="document/*"
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

<script type="text/javascript">
    $(document).ready(function(){

        $('.slick-document').slick({
        dots: true,
        infinite: false,
        speed: 300,
        slidesToShow: 4,
        slidesToScroll: 4,
        responsive: [
            {
            breakpoint: 1024,
            settings: {
                slidesToShow: 3,
                slidesToScroll: 3,
                infinite: true,
                dots: true
            }
            },
            {
            breakpoint: 600,
            settings: {
                slidesToShow: 2,
                slidesToScroll: 2
            }
            },
            {
            breakpoint: 480,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1
            }
            }
            // You can unslick at a given breakpoint now by adding:
            // settings: "unslick"
            // instead of a settings object
        ]
        });

        // $('.slick-document').slick({
        // dots: true,
        // infinite: true,
        // speed: 500,
        // fade: true,
        // cssEase: 'linear'
        // });
    });
</script>

<script type="text/javascript">
    $(document).ready(function(){
        $('.slick-image').slick({
        dots: true,
        infinite: true,
        speed: 500,
        fade: true,
        cssEase: 'linear'
        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function(){
        $('.slick-video').slick({
        dots: true,
        infinite: true,
        speed: 500,
        fade: true,
        cssEase: 'linear'
        });
    });
</script>

@endsection