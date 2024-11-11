<div class="modal fade" id="tambah" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form role="form" method="POST" action="/backoffice/application/create" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Kategori Aplikasi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="card card-outline card-primary">
                        <div class="card-body">
                            <div class="form-group">
                                <label>Kategori Aplikasi <span class="text-danger">*</span></label>
                                <select name="application_category_id" class="form-control select2 @if($errors->has('application_category_id')) is-invalid @endif" 
                                    required oninvalid="this.setCustomValidity('Kategori harus diisi')" oninput="this.setCustomValidity('')">
                                    <option value="">-- Pilih Kategori Aplikasi --</option>
                                    @foreach ($applicationCategories as $applicationCategory)
                                        <option value="{{ $applicationCategory->id }}">{{ $applicationCategory->name }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('application_category_id'))
                                <small class="help-block" style="color: red">{{ $errors->first('application_category_id') }}</small>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Judul <span class="text-danger">*</span></label>
                                <input type="text"  name="title" class="form-control @if($errors->has('title')) is-invalid @endif" placeholder="Judul" value="{{ old('title') }}"
                                required oninvalid="this.setCustomValidity('Kategori harus diisi')" oninput="this.setCustomValidity('')">
                                @if($errors->has('title'))
                                <small class="help-block" style="color: red">{{ $errors->first('title') }}</small>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Sampul</label>
                                <img class="reviewCover img-fluid mb-3 col-sm-5">
                                <input type="file" accept="image/*" name="cover" class="form-control @if($errors->has('cover')) is-invalid @endif" id="reviewCover" onchange="previewCover()">
                                @if($errors->has('title'))
                                <small class="help-block" style="color: red">{{ $errors->first('cover') }}</small>
                                @endif
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning" data-dismiss="modal"><span class="fa fa-arrow-left"></span> Kembali</button>
                    <button type="submit" class="btn btn-success"><span class="fa fa-save"></span> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>