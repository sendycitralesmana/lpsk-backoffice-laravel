<div class="modal fade" id="edit-image-{{ $image->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form role="form" method="POST" action="/backoffice/roadmap/{{ $roadmap->id }}/image/{{ $image->id }}/update" enctype="multipart/form-data">
                {{ csrf_field() }}
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ubah Gambar</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="card card-outline card-primary">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="foto">Gambar</label>
                                @if ($image->url)
                                    <img src="{{ Storage::disk('s3')->url($image->url) }}" class="reviewCover rounded img-fluid mb-3 col-sm-5 d-block"
                                    style="width: 150px; height: 150px">
                                @else
                                    <img class="reviewCover rounded img-fluid mb-3 col-sm-5">
                                @endif
                                    <input type="file" accept="image/*" name="image" class="form-control @if($errors->has('image')) is-invalid @endif" id="reviewimage" onchange="previewimage()">
                                @if($errors->has('image'))
                                    <small class="help-block" style="color: red">{{ $errors->first('image') }}</small>
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