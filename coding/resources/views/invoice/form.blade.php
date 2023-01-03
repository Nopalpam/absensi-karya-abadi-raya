@push('css')
<style>
    .d-none{
        display: none!important;
    }
    .d-block{
        display: block!important;
    }
</style>
@endpush
<div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-form">
    <div class="modal-dialog modal-lg" role="document">
        <form action="" method="post" class="form-horizontal">
            @csrf
            @method('post')
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_transaksiservice" id="id_transaksiservice" class="form-control" autocomplete="off">
                    <div class="form-group row">
                        <label for="desc" class="col-lg-2 col-lg-offset-1 control-label">Deskripsi</label>
                        <div class="col-lg-6">
                            <textarea name="desc" id="desc" cols="30" rows="10" class="form-control" required autofocus autocomplete="off"></textarea>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="norek" class="col-lg-2 col-lg-offset-1 control-label">Nomor Rekening</label>
                        <div class="col-lg-6">
                            <input type="text" name="norek" id="norek" class="form-control" required autofocus autocomplete="off">
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="nama_bank" class="col-lg-2 col-lg-offset-1 control-label">Nama Bank</label>
                        <div class="col-lg-6">
                            <input type="text" name="nama_bank" id="nama_bank" class="form-control" required autofocus autocomplete="off">
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="npwp" class="col-lg-2 col-lg-offset-1 control-label">NPWP</label>
                        <div class="col-lg-6">
                            <input type="text" name="npwp" id="npwp" class="form-control" required autofocus autocomplete="off">
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="top" class="col-lg-2 col-lg-offset-1 control-label">TOP</label>
                        <div class="col-lg-6">
                            <select name="top" id="top" class="form-control">
                                <option value="15">15 Hari</option>
                                <option value="30">30 Hari</option>
                                <option value="45">45 Hari</option>
                                <option value="60">60 Hari</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-flat btn-primary btnsubmit"><i class="fa fa-save"></i> Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
</script>
@endpush
