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
        <div class="col-md-8">

            <div class="card card-outline card-primary">
                <div class="card-header">
                    {{-- <div class="user-block">
                        @if ( $publication->user->foto != null )
                        <img src="{{ Storage::disk('s3')->url($publication->user->foto) }}" alt="">
                        @else
                        <img src="{{ asset('images/publication-default.jpg') }}" alt="">
                        @endif
                        <span class="username">
                            <p>{{ $publication->user->name }}</p>
                        </span>
                        <span class="description">Menambahkan Profil -
                            {{ $publication->created_at }}</span>
                    </div> --}}

                    <div class="card-tools">


                        {{-- @if ($errors->any())
                        <script>
                            jQuery(function() {
                                    $('#tambah').modal('show');
                                });
                        </script>
                        @endif --}}
                        {{-- <button type="button" class="btn btn-tool btn-sm" data-toggle="modal"
                            data-target="#edit-{{ $publication->id }}" title="Ubah">
                            <span><i class="fa fa-edit"></i></span>
                        </button>
                        @include('backoffice.publication.modal.edit') --}}
                        <button class="btn btn-tool" data-toggle="modal" data-target="#edit-{{ $publication->id }}" title="Ubah">
                            <i class="fa fa-edit"></i>
                        </button>
                        @if ( $publication->document_url )
                            {{-- <button class="btn btn-tool" data-toggle="modal" data-target="#download-{{ $publication->id }}" title="Download">
                                <i class="fa fa-download"></i>
                            </button> --}}
                        @endif
                        @include('backoffice.publication.modal.edit')
                        <button class="btn btn-tool" data-toggle="modal" data-target="#delete-{{ $publication->id }}" title="Hapus">
                            <i class="fa fa-trash"></i>
                        </button>
                        @include('backoffice.publication.modal.delete')
                        <button type="button" class="btn btn-tool btn-sm" data-card-widget="collapse"
                            data-toggle="tooltip" title="Collapse">
                            <i class="fas fa-minus"></i>
                        </button>
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

                    @if ( $publication->cover != null )
                    <div class="text-center">
                        @if ( $publication->cover != null )
                            <img src="{{ Storage::disk('s3')->url($publication->cover) }}" class="img-fluid rounded" alt=""
                                style="width: 50%; height: 500px">
                        @else
                            <img src="{{ asset('images/default_zz.webp') }}" class="img-fluid rounded" alt=""
                                style="width: 50%; height: 500px">
                        @endif
                        
                    </div>
                    @endif
                    @if ( $publication->status == "DINAIKAN" )
                        <p class="badge badge-success">{{ $publication->status }}</p>
                    @elseif ( $publication->status == "DIAJUKAN" )
                        <p class="badge badge-warning">{{ $publication->status }}</p>
                    @else
                        <p class="badge badge-danger">{{ $publication->status }}</p>
                    @endif
                    <h4 class="mt-2">
                        <b>{{ $publication->title }}</b>
                    </h4>
                    @if ( $publication->publication_category_id != null )
                    <small> {{ $publication->publicationCategory->name }} </small>
                    @endif
                    
                    <div class="mb-2">
                        <p> {!! html_entity_decode($publication->description) !!} </p>
                    </div>
                    @if ( $publication->document_url != null )
                        
                        @if ( pathinfo($publication->document_url)['extension'] == 'pdf' )
                            <div class="text-center">
                                <div class="card card-outline card-primary">
                                    <div class="card-header">
                                        <h3 class="card-title">Berkas / Dokumen</h3>
                                    </div>
                                    <div class="card-body">
                                        <a href="/backoffice/publication/{{ $publication->id }}/preview" class="btn btn-primary btn-sm" target="_blank">
                                            <i class="fa fa-file"></i> Lihat {{ $publication->document_name }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endif

                    @endif

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