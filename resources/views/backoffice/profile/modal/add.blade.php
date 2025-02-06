<div class="modal fade" id="tambah" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form role="form" method="POST" action="/backoffice/profile/create" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Kategori Profil</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="card card-outline card-primary">
                        <div class="card-body">
                            {{-- <div class="form-group">
                                <label>Kategori Profil <span class="text-danger">*</span></label>
                                <select name="profile_category_id" class="form-control select2 @if($errors->has('profile_category_id')) is-invalid @endif" 
                                    required oninvalid="this.setCustomValidity('Kategori harus diisi')" oninput="this.setCustomValidity('')">
                                    <option value="">-- Pilih Kategori Profil --</option>
                                    @foreach ($profileCategories as $profileCategory)
                                        <option value="{{ $profileCategory->id }}">{{ $profileCategory->name }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('profile_category_id'))
                                <small class="help-block" style="color: red">{{ $errors->first('profile_category_id') }}</small>
                                @endif
                            </div> --}}
                            <div class="form-group">
                                <label>Nama <span class="text-danger">*</span></label>
                                <input type="text"  name="name" class="form-control @if($errors->has('name')) is-invalid @endif" placeholder="Nama" value="{{ old('name') }}"
                                required oninvalid="this.setCustomValidity('Kategori harus diisi')" oninput="this.setCustomValidity('')">
                                @if($errors->has('name'))
                                <small class="help-block" style="color: red">{{ $errors->first('name') }}</small>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Deskripsi</label>
                                <textarea name="description" rows="10" class="form-control @if($errors->has('description')) is-invalid @endif" placeholder="Deskripsi">{{ old('description') }}</textarea>
                                @if($errors->has('description'))
                                <small class="help-block" style="color: red">{{ $errors->first('description') }}</small>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Foto</label>
                                <img class="reviewCover rounded img-fluid mb-3 col-sm-5">
                                <input type="file" accept="image/*" name="foto" class="form-control @if($errors->has('foto')) is-invalid @endif" id="reviewCover" onchange="previewCover()">
                                @if($errors->has('title'))
                                <small class="help-block" style="color: red">{{ $errors->first('foto') }}</small>
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