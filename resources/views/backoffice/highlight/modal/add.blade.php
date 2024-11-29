<div class="modal fade" id="tambah" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form role="form" method="POST" action="/backoffice/highlight/create" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Kategori Sorot</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="card card-outline card-primary">
                        <div class="card-body">
                            <div class="form-group">
                                <label>Kategori Sorot <span class="text-danger">*</span></label>
                                <select name="highlight_category_id" class="form-control select2 @if($errors->has('highlight_category_id')) is-invalid @endif" 
                                    required oninvalid="this.setCustomValidity('Kategori harus diisi')" oninput="this.setCustomValidity('')">
                                    <option value="">-- Pilih Kategori Sorot --</option>
                                    @foreach ($highlightCategories as $highlightCategory)
                                        <option value="{{ $highlightCategory->id }}" >{{ $highlightCategory->name }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('highlight_category_id'))
                                <small class="help-block" style="color: red">{{ $errors->first('highlight_category_id') }}</small>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Berita <span class="text-danger">*</span></label>
                                <select name="news_id" class="form-control select2 @if($errors->has('news_id')) is-invalid @endif" 
                                    required oninvalid="this.setCustomValidity('Kategori harus diisi')" oninput="this.setCustomValidity('')">
                                    <option value="">-- Pilih Berita --</option>
                                    @foreach ($newss as $news)
                                        <option value="{{ $news->id }}">{{ $news->title }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('news_id'))
                                <small class="help-block" style="color: red">{{ $errors->first('news_id') }}</small>
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