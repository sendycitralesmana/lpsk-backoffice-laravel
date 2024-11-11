<div class="modal fade" id="tambah" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form role="form" method="POST" action="/backoffice/service/create" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Kategori Layanan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="card card-outline card-primary">
                        <div class="card-body">
                            <div class="form-group">
                                <label>Kategori Layanan <span class="text-danger">*</span></label>
                                <select name="service_category_id" class="form-control select2 @if($errors->has('service_category_id')) is-invalid @endif" 
                                    required oninvalid="this.setCustomValidity('Kategori harus diisi')" oninput="this.setCustomValidity('')">
                                    <option value="">-- Pilih Kategori Layanan --</option>
                                    @foreach ($serviceCategories as $serviceCategory)
                                        <option value="{{ $serviceCategory->id }}">{{ $serviceCategory->name }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('service_category_id'))
                                <small class="help-block" style="color: red">{{ $errors->first('service_category_id') }}</small>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Berkas</label>
                                <img class="reviewCover img-fluid mb-3 col-sm-5">
                                <input type="file" accept="image/*" name="document_url" class="form-control @if($errors->has('document_url')) is-invalid @endif" id="reviewCover" onchange="previewCover()">
                                @if($errors->has('title'))
                                <small class="help-block" style="color: red">{{ $errors->first('document_url') }}</small>
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