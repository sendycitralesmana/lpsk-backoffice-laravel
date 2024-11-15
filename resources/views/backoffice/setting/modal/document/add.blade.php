<div class="modal fade" id="add-document-{{ $setting->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form role="form" method="POST" action="/backoffice/setting/{{ $setting->id }}/document/create" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Dokumen</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="card card-outline card-primary">
                        <div class="card-body">

                            <div id="formInputDocument">
                                <div class="form-group">
                                    <label for="document[]">Dokumen </label>
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <input type="file" name="document[]"
                                                class="form-control @if ($errors->has('document')) is-invalid @endif"
                                                value="{{ old('document') }}" required
                                                oninvalid="this.setCustomValidity('Dokumen harus diisi')"
                                                oninput="this.setCustomValidity('')">
                                        </div>
                                        <div>
                                            <button type="button" class="btn btn-success" id="addDocument">
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