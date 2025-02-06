<div class="modal fade" id="edit-{{ $publication->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form role="form" method="POST" action="/backoffice/publication/{{ $publication->id }}/update" enctype="multipart/form-data">
                {{ csrf_field() }}
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ubah Publikasi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="card card-outline card-primary">
                        <div class="card-body">
                            <div class="form-group">
                                <label>Kategori Publikasi <span class="text-danger">*</span></label>
                                <select name="publication_category_id" class="form-control select2 @if($errors->has('publication_category_id')) is-invalid @endif" 
                                    required oninvalid="this.setCustomValidity('Kategori harus diisi')" oninput="this.setCustomValidity('')">
                                    @foreach ($publicationCategories as $publicationCategory)
                                        <option value="{{ $publicationCategory->id }}" {{ $publication->publication_category_id == $publicationCategory->id ? 'selected' : '' }}>{{ $publicationCategory->name }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('publication_category_id'))
                                <small class="help-block" style="color: red">{{ $errors->first('publication_category_id') }}</small>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Judul <span class="text-danger">*</span></label>
                                <input type="text" name="title"
                                    class="form-control @if($errors->has('title')) is-invalid @endif"
                                    placeholder="Judul" value="{{ $publication->title }}" required
                                    oninvalid="this.setCustomValidity('Kategori harus diisi')"
                                    oninput="this.setCustomValidity('')">
                                @if($errors->has('title'))
                                <small class="help-block" style="color: red">{{ $errors->first('title')
                                    }}</small>
                                @endif
                            </div>
                            {{-- <div class="form-group">
                                <label>Deskripsi</label>
                                <textarea name="description" rows="10" class="form-control @if($errors->has('description')) is-invalid @endif" placeholder="Deskripsi">{{ $publication->description }}</textarea>
                                @if($errors->has('description'))
                                <small class="help-block" style="color: red">{{ $errors->first('description') }}</small>
                                @endif
                            </div> --}}
                            <div class="form-group">
                                <label for="foto">Berkas</label>
                                {{-- @if ($publication->cover)
                                    <img src="{{ Storage::disk('s3')->url($publication->cover) }}" class="reviewCover rounded img-fluid mb-3 col-sm-5 d-block"
                                    style="width: 150px; height: 150px">
                                @else
                                    <img class="reviewCover rounded img-fluid mb-3 col-sm-5">
                                @endif --}}
                                {{-- accept document pdf--}}
                                    <input type="file" accept="" name="document_url" class="form-control @if($errors->has('document_url')) is-invalid @endif" id="reviewCover" onchange="previewCover()">
                                @if($errors->has('document_url'))
                                    <small class="help-block" style="color: red">{{ $errors->first('document_url') }}</small>
                                @endif
                            </div>
                            @if (auth()->user()->role_id == 1)
                                <div class="form-group">
                                    <label>Status <span class="text-danger">*</span></label>
                                    <select name="status" class="form-control @if($errors->has('status')) is-invalid @endif" 
                                        required oninvalid="this.setCustomValidity('Status harus diisi')" oninput="this.setCustomValidity('')">
                                        <option value="DIAJUKAN" {{ $publication->status == 'DIAJUKAN' ? 'selected' : '' }}>DIAJUKAN</option>
                                        <option value="DINAIKAN" {{ $publication->status == 'DINAIKAN' ? 'selected' : '' }}>DINAIKAN</option>
                                        <option value="DITURUNKAN" {{ $publication->status == 'DITURUNKAN' ? 'selected' : '' }}>DITURUNKAN</option>
                                    </select>
                                    @if($errors->has('status'))
                                    <small class="help-block" style="color: red">{{ $errors->first('status') }}</small>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="foto">Sampul</label>
                                    {{-- @if ($publication->cover)
                                        <img src="{{ Storage::disk('s3')->url($publication->cover) }}" class="reviewCover rounded img-fluid mb-3 col-sm-5 d-block"
                                        style="width: 150px; height: 150px">
                                    @else
                                        <img class="reviewCover rounded img-fluid mb-3 col-sm-5">
                                    @endif --}}
                                        <input type="file" accept="image/*" name="cover" class="form-control @if($errors->has('cover')) is-invalid @endif" id="reviewCover" onchange="previewCover()">
                                    @if($errors->has('cover'))
                                        <small class="help-block" style="color: red">{{ $errors->first('foto') }}</small>
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