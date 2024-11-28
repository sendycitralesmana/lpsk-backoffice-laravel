<div class="modal fade" id="tambah" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form role="form" method="POST" action="/backoffice/publication/create" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Publikasi</h5>
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
                                    <option value="">-- Pilih Kategori Publikasi --</option>
                                    @foreach ($publicationCategories as $publicationCategory)
                                        <option value="{{ $publicationCategory->id }}">{{ $publicationCategory->name }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('publication_category_id'))
                                <small class="help-block" style="color: red">{{ $errors->first('publication_category_id') }}</small>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Berkas</label>
                                <img class="reviewCover img-fluid mb-3 col-sm-5">
                                <input type="file" accept="" name="document_url" class="form-control @if($errors->has('document_url')) is-invalid @endif" id="reviewCover" onchange="()">
                                @if($errors->has('title'))
                                <small class="help-block" style="color: red">{{ $errors->first('document_url') }}</small>
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