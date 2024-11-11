<div class="modal fade" id="edit-{{ $information->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form role="form" method="POST" action="/backoffice/information/{{ $information->id }}/update" enctype="multipart/form-data">
                {{ csrf_field() }}
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ubah Informasi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="card card-outline card-primary">
                        <div class="card-body">
                            <div class="form-group">
                                <label>Kategori Informasi <span class="text-danger">*</span></label>
                                <select name="information_category_id" class="form-control select2 @if($errors->has('information_category_id')) is-invalid @endif" 
                                    required oninvalid="this.setCustomValidity('Kategori harus diisi')" oninput="this.setCustomValidity('')">
                                    @foreach ($informationCategories as $informationCategory)
                                        <option value="{{ $informationCategory->id }}" {{ $information->information_category_id == $informationCategory->id ? 'selected' : '' }}>{{ $informationCategory->name }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('information_category_id'))
                                <small class="help-block" style="color: red">{{ $errors->first('information_category_id') }}</small>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="foto">Sampul</label>
                                @if ($information->cover)
                                    <img src="{{ Storage::disk('s3')->url($information->cover) }}" class="reviewCover rounded img-fluid mb-3 col-sm-5 d-block"
                                    style="width: 150px; height: 150px">
                                @else
                                    <img class="reviewCover rounded img-fluid mb-3 col-sm-5">
                                @endif
                                    <input type="file" accept="image/*" name="cover" class="form-control @if($errors->has('cover')) is-invalid @endif" id="reviewCover" onchange="previewCover()">
                                @if($errors->has('cover'))
                                    <small class="help-block" style="color: red">{{ $errors->first('cover') }}</small>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Judul <span class="text-danger">*</span></label>
                                <input type="text"  name="title" class="form-control @if($errors->has('title')) is-invalid @endif" value="{{ $information->title }}"
                                required oninput="this.setCustomValidity('')" oninvalid="this.setCustomValidity('Judul harus diisi')">
                                @if($errors->has('title'))
                                <small class="help-block" style="color: red">{{ $errors->first('title') }}</small>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Konten <span class="text-danger">*</span></label>
                                <textarea name="content" class="form-control @if($errors->has('content')) is-invalid @endif"
                                required oninput="this.setCustomValidity('')" oninvalid="this.setCustomValidity('Konten harus diisi')">{{ $information->content }}</textarea>
                                @if($errors->has('url'))
                                <small class="help-block" style="color: red">{{ $errors->first('url') }}</small>
                                @endif
                            </div>
                            @if (auth()->user()->id == 1)
                                <div class="form-group">
                                    <label>Status <span class="text-danger">*</span></label>
                                    <select name="status" class="form-control @if($errors->has('status')) is-invalid @endif" 
                                        required oninvalid="this.setCustomValidity('Status harus diisi')" oninput="this.setCustomValidity('')">
                                        <option value="DIAJUKAN" {{ $information->status == 'DIAJUKAN' ? 'selected' : '' }}>DIAJUKAN</option>
                                        <option value="DINAIKAN" {{ $information->status == 'DINAIKAN' ? 'selected' : '' }}>DINAIKAN</option>
                                        <option value="DITURUNKAN" {{ $information->status == 'DITURUNKAN' ? 'selected' : '' }}>DITURUNKAN</option>
                                    </select>
                                    @if($errors->has('status'))
                                    <small class="help-block" style="color: red">{{ $errors->first('status') }}</small>
                                    @endif
                                </div>
                            @endif
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