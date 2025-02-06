<div class="modal fade" id="edit-{{ $profile->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form role="form" method="POST" action="/backoffice/profile/{{ $profile->id }}/update" enctype="multipart/form-data">
                {{ csrf_field() }}
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ubah Profil</h5>
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
                                    @foreach ($profileCategories as $profileCategory)
                                        <option value="{{ $profileCategory->id }}" {{ $profile->profile_category_id == $profileCategory->id ? 'selected' : '' }}>{{ $profileCategory->name }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('profile_category_id'))
                                <small class="help-block" style="color: red">{{ $errors->first('profile_category_id') }}</small>
                                @endif
                            </div> --}}
                            <div class="form-group">
                                <label>Nama <span class="text-danger">*</span></label>
                                <input type="text"  name="name" class="form-control @if($errors->has('name')) is-invalid @endif" value="{{ $profile->name }}"
                                required oninput="this.setCustomValidity('')" oninvalid="this.setCustomValidity('Nama harus diisi')">
                                @if($errors->has('name'))
                                <small class="help-block" style="color: red">{{ $errors->first('name') }}</small>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Deskripsi <span class="text-danger">*</span></label>
                                <textarea name="description" rows="10" class="form-control @if($errors->has('description')) is-invalid @endif"
                                required oninput="this.setCustomValidity('')" oninvalid="this.setCustomValidity('Deskripsi harus diisi')">{{ $profile->description }}</textarea>
                                @if($errors->has('url'))
                                <small class="help-block" style="color: red">{{ $errors->first('url') }}</small>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="foto">Foto</label>
                                @if ($profile->foto)
                                    <img src="{{ Storage::disk('s3')->url($profile->foto) }}" class="reviewCover rounded img-fluid mb-3 col-sm-5 d-block"
                                    style="width: 150px; height: 150px">
                                @else
                                    <img class="reviewCover rounded img-fluid mb-3 col-sm-5">
                                @endif
                                    <input type="file" accept="image/*" name="foto" class="form-control @if($errors->has('foto')) is-invalid @endif" id="reviewCover" onchange="previewCover()">
                                @if($errors->has('foto'))
                                    <small class="help-block" style="color: red">{{ $errors->first('foto') }}</small>
                                @endif
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning" data-dismiss="modal"><span class="fa fa-arrow-left"></span> Kembali</button>
                    <button type="submit" class="btn btn-success"><span class="fa fa-edit"></span> Ubah</button>
                </div>
            </form>
        </div>
    </div>
</div>