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

                <div class="form-group row">
                        <label for="nama_customer" class="col-lg-2 col-lg-offset-1 control-label">Nama Customer</label>
                        <div class="col-lg-6">
                            <input type="text" name="nama_customer" id="nama_customer" class="form-control" required autofocus autocomplete="off">
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="brand_customer" class="col-lg-2 col-lg-offset-1 control-label">Brand Customer</label>
                        <div class="col-lg-6">
                            <input type="text" name="brand_customer" id="brand_customer" class="form-control" required autocomplete="off">
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="alamat" class="col-lg-2 col-lg-offset-1 control-label">Alamat</label>
                        <div class="col-lg-6">
                            <input type="text" name="alamat" id="alamat" class="form-control" required autocomplete="off">
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="contact_person" class="col-lg-2 col-lg-offset-1 control-label">Contact Person</label>
                        <div class="col-lg-6">
                            <input type="number" name="contact_person" id="contact_person" class="form-control" required autocomplete="off">
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="nomor_mou" class="col-lg-2 col-lg-offset-1 control-label">Nomor MOU</label>
                        <div class="col-lg-6">
                            <input type="text" name="nomor_mou" id="nomor_mou" class="form-control" required autocomplete="off">
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="tanggal_perjanjian_awal" class="col-lg-2 col-lg-offset-1 control-label">Tanggal Perjanjian Awal</label>
                        <div class="col-lg-6">
                            <input type="date" name="tanggal_perjanjian_awal" id="tanggal_perjanjian_awal" class="form-control datepicker" required autofocus
                                value="{{ request('tanggal_perjanjian_awal') }}"
                                style="border-radius: 0 !important;">
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="tanggal_perjanjian_akhir" class="col-lg-2 col-lg-offset-1 control-label">Tanggal Perjanjian Akhir</label>
                        <div class="col-lg-6">
                            <input type="date" name="tanggal_perjanjian_akhir" id="tanggal_perjanjian_akhir" class="form-control datepicker" required autofocus
                                value="{{ request('tanggal_perjanjian_akhir') }}"
                                style="border-radius: 0 !important;">
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
@endpush
