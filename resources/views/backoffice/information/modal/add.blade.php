{{-- <div class="modal fade" id="tambah" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form role="form" method="POST" action="/backoffice/information/create" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Informasi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="card card-outline card-primary">
                        <div class="card-body">

                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label>Kategori Informasi <span class="text-danger">*</span></label>
                                        <select name="information_category_id"
                                            class="form-control select2 @if($errors->has('information_category_id')) is-invalid @endif"
                                            required oninvalid="this.setCustomValidity('Kategori harus diisi')"
                                            oninput="this.setCustomValidity('')">
                                            <option value="">-- Pilih Kategori Informasi --</option>
                                            @foreach ($informationCategories as $informationCategory)
                                            <option value="{{ $informationCategory->id }}">{{ $informationCategory->name }}</option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('information_category_id'))
                                        <small class="help-block" style="color: red">{{
                                            $errors->first('information_category_id') }}</small>
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
                                        <textarea name="content"
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
                                <div class="col-md-4">

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
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning" data-dismiss="modal"><span
                            class="fa fa-arrow-left"></span> Kembali</button>
                    <button type="submit" class="btn btn-success"><span class="fa fa-save"></span> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div> --}}