<div class="modal fade" id="add-video-{{ $setting->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form role="form" method="POST" action="/backoffice/setting/{{ $setting->id }}/video/create" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Video</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="card card-outline card-primary">
                        <div class="card-body">

                            <div id="formInputVideo">
                                <div class="form-group">
                                    <label for="video[]">Video </label>
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <input type="file" name="video[]" accept="video/*"
                                                class="form-control @if ($errors->has('video')) is-invalid @endif"
                                                value="{{ old('video') }}" required
                                                oninvalid="this.setCustomValidity('Video harus diisi')"
                                                oninput="this.setCustomValidity('')">
                                        </div>
                                        <div>
                                            <button type="button" class="btn btn-success" id="addVideo">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning" data-dismiss="modal"><span
                            class="fa fa-arrow-left"></span> Kembali</button>
                    <button type="submit" class="btn btn-success"><span class="fa fa-save"></span> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>