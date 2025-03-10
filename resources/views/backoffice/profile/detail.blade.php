@extends('backoffice.layout.main')

@section('content')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Data Profil</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active">Data Profil</li>
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
                        @if ( $profile->user->foto != null )
                        <img src="{{ Storage::disk('s3')->url($profile->user->foto) }}" alt="">
                        @else
                        <img src="{{ asset('images/backoffice/profile-default.jpg') }}" alt="">
                        @endif
                        <span class="username">
                            <p>{{ $profile->user->name }}</p>
                        </span>
                        <span class="description">Menambahkan Profil -
                            {{ $profile->created_at }}</span>
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
                            data-target="#edit-{{ $profile->id }}" title="Ubah">
                            <span><i class="fa fa-edit"></i></span>
                        </button>
                        @include('backoffice.profile.modal.edit') --}}
                        <button class="btn btn-tool" data-toggle="modal" data-target="#edit-{{ $profile->id }}" title="Ubah">
                            <i class="fa fa-edit"></i>
                        </button>
                        @include('backoffice.profile.modal.edit')
                        <button class="btn btn-tool" data-toggle="modal" data-target="#delete-{{ $profile->id }}" title="Hapus">
                            <i class="fa fa-trash"></i>
                        </button>
                        @include('backoffice.profile.modal.delete')
                        <button type="button" class="btn btn-tool btn-sm" data-card-widget="collapse"
                            data-toggle="tooltip" title="Collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>

                </div>
                <div class="card-body">

                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" profile="alert">
                        <strong>Berhasil </strong>{{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif

                    @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" profile="alert">
                        <strong>Gagal </strong>{{ session('error') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif

                    @if ( $profile->foto != null )
                    <div class="text-center">
                        <img src="{{ Storage::disk('s3')->url($profile->foto) }}" class="img-fluid rounded" alt=""
                            style="width: 40%; height: 440px">
                    </div>
                    @endif
                    <h4 class="mt-2">
                        <b>{{ $profile->name }}</b>
                    </h4>
                    @if ( $profile->profile_category_id != null )
                    <small> {{ $profile->profileCategory->name }} </small>
                    @endif
                    <div class="mb-2">
                        {{-- <p> {!! html_entity_decode($profile->description) !!} </p> --}}
                        {!! str_replace("\r\n\r\n", '<br><br>', $profile->description) !!}

                    </div>

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