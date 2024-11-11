<div class="modal fade" id="edit-{{ $news->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form role="form" method="POST" action="/backoffice/news/{{ $news->id }}/update" enctype="multipart/form-data">
                {{ csrf_field() }}
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ubah Berita</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="card card-outline card-primary">
                        <div class="card-body">
                            <div class="form-group">
                                <label>Kategori Berita <span class="text-danger">*</span></label>
                                <select name="news_category_id" class="form-control select2 @if($errors->has('news_category_id')) is-invalid @endif" 
                                    required oninvalid="this.setCustomValidity('Kategori harus diisi')" oninput="this.setCustomValidity('')">
                                    @foreach ($newsCategories as $newsCategory)
                                        <option value="{{ $newsCategory->id }}" {{ $news->news_category_id == $newsCategory->id ? 'selected' : '' }}>{{ $newsCategory->name }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('news_category_id'))
                                <small class="help-block" style="color: red">{{ $errors->first('news_category_id') }}</small>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="foto">Sampul</label>
                                @if ($news->cover)
                                    <img src="{{ Storage::disk('s3')->url($news->cover) }}" class="reviewCover rounded img-fluid mb-3 col-sm-5 d-block"
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
                                <input type="text"  name="title" class="form-control @if($errors->has('title')) is-invalid @endif" value="{{ $news->title }}"
                                required oninput="this.setCustomValidity('')" oninvalid="this.setCustomValidity('Judul harus diisi')">
                                @if($errors->has('title'))
                                <small class="help-block" style="color: red">{{ $errors->first('title') }}</small>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Konten <span class="text-danger">*</span></label>
                                <textarea name="content" class="form-control @if($errors->has('content')) is-invalid @endif"
                                required oninput="this.setCustomValidity('')" oninvalid="this.setCustomValidity('Konten harus diisi')">{{ $news->content }}</textarea>
                                @if($errors->has('url'))
                                <small class="help-block" style="color: red">{{ $errors->first('url') }}</small>
                                @endif
                            </div>
                            @if (auth()->user()->id == 1)
                                <div class="form-group">
                                    <label>Status <span class="text-danger">*</span></label>
                                    <select name="status" class="form-control @if($errors->has('status')) is-invalid @endif" 
                                        required oninvalid="this.setCustomValidity('Status harus diisi')" oninput="this.setCustomValidity('')">
                                        <option value="DIAJUKAN" {{ $news->status == 'DIAJUKAN' ? 'selected' : '' }}>DIAJUKAN</option>
                                        <option value="DINAIKAN" {{ $news->status == 'DINAIKAN' ? 'selected' : '' }}>DINAIKAN</option>
                                        <option value="DITURUNKAN" {{ $news->status == 'DITURUNKAN' ? 'selected' : '' }}>DITURUNKAN</option>
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