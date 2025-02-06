@extends('backoffice.layout.main')

@section('content')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Tambah Berita</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active">Tambah Berita</li>
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
                    <div class="row flex justify-content-between mt-2">
                        <form action="" class="form-inline">
                            <div class="pr-4" style="border-right: 3px solid #0d6efd">
                                <h3 class="card-title">
                                    <b>Berita</b>
                                </h3>
                            </div>
    
                        </form>
                        <div class="card-tools">
                            <a href="/backoffice/news" class="btn btn-warning">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
    
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

                    <form action="/backoffice/news/create" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Kategori Berita <span class="text-danger">*</span></label>
                                    <select name="news_category_id"
                                        class="form-control select2 @if($errors->has('news_category_id')) is-invalid @endif"
                                        required oninvalid="this.setCustomValidity('Kategori harus diisi')"
                                        oninput="this.setCustomValidity('')">
                                        <option value="">-- Pilih Kategori Berita --</option>
                                        @foreach ($newsCategories as $newsCategory)
                                        <option value="{{ $newsCategory->id }}">{{ $newsCategory->name }}</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('news_category_id'))
                                    <small class="help-block" style="color: red">{{
                                        $errors->first('news_category_id') }}</small>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="form-group">
                                    <label>Judul <span class="text-danger">*</span></label>
                                    <input type="text" name="title"
                                        class="form-control @if($errors->has('title')) is-invalid @endif"
                                        placeholder="Judul" value="{{ old('title') }}" required
                                        oninvalid="this.setCustomValidity('Kategori harus diisi')"
                                        oninput="this.setCustomValidity('')">
                                    @if($errors->has('title'))
                                    <small class="help-block" style="color: red">{{ $errors->first('title')
                                        }}</small>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Konten <span class="text-danger">*</span></label>
                                    <textarea name="content" id="description"
                                        class="form-control @if($errors->has('content')) is-invalid @endif"
                                        placeholder="Konten"></textarea>
                                    @if($errors->has('content'))
                                    <small class="help-block" style="color: red">{{ $errors->first('content')
                                        }}</small>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Sampul</label>
                                    <img class="reviewCover img-fluid mb-3 col-sm-5">
                                    <input type="file" accept="image/*" name="cover"
                                        class="form-control @if($errors->has('cover')) is-invalid @endif"
                                        id="reviewCover" onchange="previewCover()">
                                    @if($errors->has('cover'))
                                    <small class="help-block" style="color: red">{{ $errors->first('cover')
                                        }}</small>
                                    @endif
                                </div>
                            </div>
                            {{-- <div class="col-md-3">
                                <div id="formInputImage">
                                    <div class="form-group">
                                        <label for="image[]">Gambar </label>
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <input type="file" name="image[]"
                                                    class="form-control @if ($errors->has('image')) is-invalid @endif"
                                                    value="{{ old('image') }}">
                                            </div>
                                            <div>
                                                <button type="button" class="btn btn-success" id="addImage">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div id="formInputVideo">
                                    <div class="form-group">
                                        <label for="video[]">Video </label>
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <input type="file" name="video[]"
                                                    class="form-control @if ($errors->has('video')) is-invalid @endif"
                                                    value="{{ old('video') }}">
                                            </div>
                                            <div>
                                                <button type="button" class="btn btn-success" id="addVideo">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div id="formInputDocument">
                                    <div class="form-group">
                                        <label for="document[]">Dokumen </label>
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <input type="file" name="document[]"
                                                    class="form-control @if ($errors->has('document')) is-invalid @endif"
                                                    value="{{ old('document') }}">
                                            </div>
                                            <div>
                                                <button type="button" class="btn btn-success" id="addDocument">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                        </div>

                        {{-- <div class="row">
                            <div class="col-md-9">
                                <div class="form-group">
                                    <label>Kategori Berita <span class="text-danger">*</span></label>
                                    <select name="news_category_id"
                                        class="form-control select2 @if($errors->has('news_category_id')) is-invalid @endif"
                                        required oninvalid="this.setCustomValidity('Kategori harus diisi')"
                                        oninput="this.setCustomValidity('')">
                                        <option value="">-- Pilih Kategori Berita --</option>
                                        @foreach ($newsCategories as $newsCategory)
                                        <option value="{{ $newsCategory->id }}">{{ $newsCategory->name }}</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('news_category_id'))
                                    <small class="help-block" style="color: red">{{
                                        $errors->first('news_category_id') }}</small>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label>Judul <span class="text-danger">*</span></label>
                                    <input type="text" name="title"
                                        class="form-control @if($errors->has('title')) is-invalid @endif"
                                        placeholder="Judul" value="{{ old('title') }}" required
                                        oninvalid="this.setCustomValidity('Kategori harus diisi')"
                                        oninput="this.setCustomValidity('')">
                                    @if($errors->has('title'))
                                    <small class="help-block" style="color: red">{{ $errors->first('title')
                                        }}</small>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label>Konten <span class="text-danger">*</span></label>
                                    <textarea name="content" id="description"
                                        class="form-control @if($errors->has('content')) is-invalid @endif"
                                        placeholder="Konten"></textarea>
                                    @if($errors->has('content'))
                                    <small class="help-block" style="color: red">{{ $errors->first('content')
                                        }}</small>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label>Sampul</label>
                                    <img class="reviewCover img-fluid mb-3 col-sm-5">
                                    <input type="file" accept="image/*" name="cover"
                                        class="form-control @if($errors->has('cover')) is-invalid @endif"
                                        id="reviewCover" onchange="previewCover()">
                                    @if($errors->has('cover'))
                                    <small class="help-block" style="color: red">{{ $errors->first('cover')
                                        }}</small>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-3">

                                <div id="formInputImage">
                                    <div class="form-group">
                                        <label for="image[]">Gambar </label>
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <input type="file" name="image[]"
                                                    class="form-control @if ($errors->has('image')) is-invalid @endif"
                                                    value="{{ old('image') }}">
                                            </div>
                                            <div>
                                                <button type="button" class="btn btn-success" id="addImage">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div id="formInputVideo">
                                    <div class="form-group">
                                        <label for="video[]">Video </label>
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <input type="file" name="video[]"
                                                    class="form-control @if ($errors->has('video')) is-invalid @endif"
                                                    value="{{ old('video') }}">
                                            </div>
                                            <div>
                                                <button type="button" class="btn btn-success" id="addVideo">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div id="formInputDocument">
                                    <div class="form-group">
                                        <label for="document[]">Dokumen </label>
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <input type="file" name="document[]"
                                                    class="form-control @if ($errors->has('document')) is-invalid @endif"
                                                    value="{{ old('document') }}">
                                            </div>
                                            <div>
                                                <button type="button" class="btn btn-success" id="addDocument">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div> --}}

                        <button type="submit" style="" class=" btn btn-success ">
                            <i class="fas fa-save"></i> Simpan
                        </button>
                    
                    </form>

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