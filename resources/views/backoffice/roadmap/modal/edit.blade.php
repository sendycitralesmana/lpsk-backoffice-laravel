<div class="modal fade" id="edit-{{ $roadmap->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form role="form" method="POST" action="/backoffice/roadmap/{{ $roadmap->id }}/update" enctype="multipart/form-data">
                {{ csrf_field() }}
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ubah Peta jalan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="card card-outline card-primary">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="foto">Sampul</label>
                                @if ($roadmap->cover)
                                    <img src="{{ Storage::disk('s3')->url($roadmap->cover) }}" class="reviewCover rounded img-fluid mb-3 col-sm-5 d-block"
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
                                <input type="text"  name="title" class="form-control @if($errors->has('title')) is-invalid @endif" value="{{ $roadmap->title }}"
                                required oninput="this.setCustomValidity('')" oninvalid="this.setCustomValidity('Judul harus diisi')">
                                @if($errors->has('title'))
                                <small class="help-block" style="color: red">{{ $errors->first('title') }}</small>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Konten <span class="text-danger">*</span></label>
                                <textarea name="content" class="form-control @if($errors->has('content')) is-invalid @endif"
                                required oninput="this.setCustomValidity('')" oninvalid="this.setCustomValidity('Konten harus diisi')">{{ $roadmap->content }}</textarea>
                                @if($errors->has('url'))
                                <small class="help-block" style="color: red">{{ $errors->first('url') }}</small>
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