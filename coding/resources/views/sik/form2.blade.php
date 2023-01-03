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
                        <label for="nama_area" class="col-lg-2 col-lg-offset-1 control-label">Nama Area</label>
                        <div class="col-lg-6">
                            <input type="text" name="nama_area" id="nama_area" class="form-control" required autofocus autocomplete="off">
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="lat_area" class="col-lg-2 col-lg-offset-1 control-label">Latitude</label>
                        <div class="col-lg-6">
                            <input type="text" name="lat_area" id="lat_area" class="form-control" required autocomplete="off">
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="lang_area" class="col-lg-2 col-lg-offset-1 control-label">Langitude</label>
                        <div class="col-lg-6">
                            <input type="text" name="lang_area" id="lang_area" class="form-control" required autocomplete="off">
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="map_link" class="col-lg-2 col-lg-offset-1 control-label">Map Link</label>
                        <div class="col-lg-6">
                            <input type="text" name="map_link" id="map_link" class="form-control" required autocomplete="off">
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