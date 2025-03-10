@extends('backoffice.layout.main')

@section('content')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Data Informasi</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active">Data Informasi</li>
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
                                    <b>Informasi</b>
                                </h3>
                            </div>
    
                            <div class="pl-4">
    
                            </div>
                            <div class="input-group input-group-sm">
                                <label for="">Cari: </label>
                                <input type="text" name="search" class="form-control ml-2" placeholder="Judul ..." value="{{ $search }}">
                                <label for="" class="ml-2">Kategori: </label>
                                <select name="category_id" class="form-control ml-2">
                                    <option value="">-- Kategori --</option>
                                    @foreach ($informationCategories as $informationCategory)
                                        <option value="{{ $informationCategory->id }}" {{ $category_id == $informationCategory->id ? 'selected' : '' }}>{{ $informationCategory->name }}</option>
                                    @endforeach
                                </select>
                                @if (auth()->user()->id ==1)
                                    <label for="" class="ml-2">Penulis: </label>
                                    <select name="user_id" class="form-control ml-2">
                                        <option value="">-- Penulis --</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}" {{ $user_id == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                @endif
                                <label for="" class="ml-2">Status: </label>
                                <select name="status" class="form-control ml-2">
                                    <option value="">-- Status --</option>
                                    <option value="DINAIKAN" @if ($status == 'DINAIKAN') selected @endif>DINAIKAN</option>
                                    <option value="DIAJUKAN" @if ($status == 'DIAJUKAN') selected @endif>DIAJUKAN</option>
                                    <option value="DITURUNKAN" @if ($status == 'DITURUNKAN') selected @endif>DITURUNKAN</option>
                                </select>
                            </div>
                            <div class="input-group ml-2">
                                <button type="submit" class="btn btn-success btn-sm">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
    
                            @if ($search || $category_id || $user_id || $status)
                                <div class="input-group ml-2">
                                    <a href="/backoffice/information" class="btn btn-primary btn-sm">
                                        <i class="fas fa-sync-alt"></i>
                                    </a>
                                </div>
                            @endif
    
                        </form>
                        <div class="card-tools">
                            <a href="/backoffice/information/add" class="btn btn-success btn-sm">
                                <span class="fa fa-plus"></span> Tambah
                            </a>
                            {{-- <button title="Tambah" type="button" class="btn btn-success btn-sm" data-toggle="modal"
                                data-target="#tambah">
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
                            {{-- @include('backoffice.information.modal.add') --}}
    
                            <button type="button" class="btn btn-tool btn-sm" data-card-widget="collapse"
                                data-toggle="tooltip" title="Collapse">
                                <i class="fas fa-minus"></i></button>
                        </div>
                    </div>
                </div>
                <div class="card-body">

                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" information="alert">
                        <strong>Berhasil </strong>{{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif

                    @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" information="alert">
                        <strong>Gagal </strong>{{ session('error') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif

                    @if ($search || $category_id || $user_id || $status)
                        <div class="search">
                            <div class="text-center">
                                <span class="fa fa-search"></span> Hasil Pencarian dari:
                                    @if ($search )
                                        <br> Judul: <b>{{ $search }}</b> 
                                    @endif
                                    @if ($category_id )
                                        <br> Kategori: <b>{{ $informationCategory->name }}</b>
                                    @endif
                                    @if ($user_id )
                                        <br> Penulis: <b>{{ $user->name }}</b>
                                    @endif
                                    @if ($status )
                                        <br> Status: <b>{{ $status }}</b>
                                    @endif
                            </div>
                            <hr>
                        </div>
                    @endif

                    <div class="row">

                        @foreach ($informations as $information)
                        <div class="col-md-4">
                            <div class="card bg-light">
                                <div class="card-header">
                                    <div class="user-block">
                                        @if ( $information->user->foto != null )
                                        <img src="{{ Storage::disk('s3')->url($information->user->foto) }}" alt="">
                                        @else
                                        <img src="{{ asset('images/backoffice/profile-default.jpg') }}" alt="">
                                        @endif
                                        <span class="username">
                                            <p>{{ $information->user->name }}</p>
                                        </span>
                                        <span class="description">Menambahkan Informasi -
                                            {{ $information->created_at }}</span>
                                    </div>
                                    <div class="card-tools">
                                        <a href="/backoffice/information/{{ $information->id }}/detail" class="btn btn-tool btn-sm" title="Detail">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        <a href="/backoffice/information/{{ $information->id }}/edit" class="btn btn-tool btn-sm" title="Ubah">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        {{-- <button type="button" class="btn btn-tool btn-sm" data-toggle="modal"
                                            data-target="#edit-{{ $information->id }}" title="Ubah">
                                            <span><i class="fa fa-edit"></i></span>
                                        </button>
                                        @include('backoffice.information.modal.edit') --}}
                                        <button type="button" class="btn btn-tool btn-sm" data-toggle="modal"
                                            data-target="#delete-{{ $information->id }}" title="Hapus">
                                            <span><i class="fa fa-trash"></i></span>
                                        </button>
                                        @include('backoffice.information.modal.delete')
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                                class="fas fa-minus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    @if ( $information->cover != null )
                                        <div class="text-center">
                                            <img src="{{ Storage::disk('s3')->url($information->cover) }}"
                                                class="img-fluid rounded" alt="" style="width: 60%; height: 320px">
                                        </div>
                                    @else
                                        <div class="text-center">
                                            <img src="{{ asset('images/default_zz.webp') }}" class="img-fluid rounded"
                                                alt="" style="width: 60%; height: 320px">
                                        </div>
                                    @endif
                                    @if ( $information->status == "DINAIKAN" )
                                        <p class="badge badge-success">{{ $information->status }}</p>
                                    @elseif ( $information->status == "DIAJUKAN" )
                                        <p class="badge badge-warning">{{ $information->status }}</p>
                                    @else
                                        <p class="badge badge-danger">{{ $information->status }}</p>
                                    @endif
                                    <h4 class="mt-2">
                                        <b>{{ $information->title }}</b>
                                    </h4>
                                    @if ( $information->information_category_id != null )
                                    <small> {{ $information->informationCategory->name }} </small>
                                    @endif
                                    <div class="mb-2" style="overflow: hidden;
                                        text-overflow: ellipsis;
                                        -webkit-line-clamp: 3;
                                        display: -webkit-box;
                                        -webkit-box-orient: vertical;">
                                        {{-- <p> {!! html_entity_decode($information->content) !!} </p> --}}
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

                            @foreach($informations as $key => $information)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $information->informationCategory->name }}</td>
                                <td>{{ $information->title }}</td>
                                <td>{{ $information->content }}</td>
                                <td>
                                    @if ($information->cover)
                                    <img src="{{ Storage::disk('s3')->url($information->cover) }}" class="img-fluid rounded"
                                        style="width: 100px; height: 100px">
                                    @else
                                    <img src="{{ asset('images/no-image.jpg') }}" class="img-fluid rounded"
                                        style="width: 100px; height: 100px">
                                    @endif
                                </td>
                                <td>{{ $information->user->name }}</td>
                                <td>{{ $information->status }}</td>
                                <td>
                                    <a href="/backoffice/information/{{ $information->id }}/detail" class="btn btn-primary btn-sm"
                                        title="Detail">
                                        <i class="fa fa-eye"></i> Detail
                                    </a>
                                    <button class="btn btn-warning btn-sm" data-toggle="modal"
                                        data-target="#edit-{{ $information->id }}" title="Ubah">
                                        <i class="fa fa-edit"></i> Ubah
                                    </button>
                                    <button class="btn btn-danger btn-sm" data-toggle="modal"
                                        data-target="#delete-{{ $information->id }}" title="Hapus">
                                        <i class="fa fa-trash"></i> Hapus
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table> --}}

                    {{-- modal --}}
                    @foreach ($informations as $information)
                    @include('backoffice.information.modal.edit')
                    @include('backoffice.information.modal.delete')
                    @endforeach

                </div>

            </div>

        </div>
        <div class="col-md-12 d-flex justify-content-end">
            {{ $informations->links() }}
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