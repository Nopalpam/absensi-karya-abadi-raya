<div class="modal fade" id="modal-sik" tabindex="-1" role="dialog" aria-labelledby="modal-form">
    <div class="modal-dialog modal-lg" role="document">
        <form id="form-sik" action="" method="post" class="form-horizontal" enctype="multipart/form-data">
            @csrf
            @method('post')
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_area">
                    <div class="form-group row">
                        <label for="tanggal" class="col-lg-2 col-lg-offset-1 control-label">Tanggal</label>
                        <div class="col-lg-6">
                            <input type="text" name="tanggal" id="daterangepicker" class="form-control datepicker" required autofocus
                                value="{{ request('tanggal') }}"
                                style="border-radius: 0 !important;">
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="sik" class="col-lg-2 col-lg-offset-1 control-label">Nama Pengguna</label>
                        <div class="col-lg-6">
                            <select name="sik" id="sik" class="form-control" required>
                            <option value="">-- pilih --</option>
                            <option value="sakit">sakit</option>
                            <option value="ijin">ijin</option>
                            <option value="cuti">cuti</option>
                            </select>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="keteranan" class="col-lg-2 col-lg-offset-1 control-label">Keteranan</label>
                        <div class="col-lg-6">
                            <textarea class="form-control" name="keterangan" id="keterangan" rows="3" required></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="gambar" class="col-lg-2 col-lg-offset-1 control-label">Gambar</label>
                        <div class="col-lg-6">
                            <input type="file" name="gambar" id="gambar" class="form-control">
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-flat btn-primary"><i class="fa fa-save"></i> Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    // select2
    $('#member').select2({
        multiple:true
    });


    $('#daterangepicker').daterangepicker({
        locale: {
            format: 'DD/MM/YYYY'
        }
    });
</script>
@endpush