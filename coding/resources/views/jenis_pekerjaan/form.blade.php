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

                <div class="form-group row">
                        <label for="nama_pekerjaan" class="col-lg-2 col-lg-offset-1 control-label">Nama Pekerjaan</label>
                        <div class="col-lg-6">
                            <input type="text" name="nama_pekerjaan" id="nama_pekerjaan" class="form-control" required autofocus autocomplete="off">
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="harga" class="col-lg-2 col-lg-offset-1 control-label">Harga</label>
                        <div class="col-lg-6">
                            <input type="text" name="harga" id="harga" class="form-control" required autocomplete="off">
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    {{-- <input type="text" id="rupiah" /> --}}
                    <div class="form-group row">
                        <label for="brand" class="col-lg-2 col-lg-offset-1 control-label">Brand</label>
                        <div class="col-lg-6">
                            <select name="brand" id="brand" class="form-control">
                                <option value="daihatsu">Daihatsu</option>
                                <option value="honda">Honda</option>
                                <option value="wuling">Wuling</option>
                                <option value="mazda">Mazda</option>
                                <option value="suzuki">Suzuki</option>
                                <option value="lainnya">lainnya (isi sendiri)</option>
                            </select>
                            <input type="text" name="brand_lainnya" id="brand_lainnya" class="form-control d-none" autocomplete="off" style="margin-top: 10px;">
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
    $('#brand').change(function(){
        if($(this).val() == 'lainnya'){
            $('#brand_lainnya').removeClass("d-none");
            $('#brand_lainnya').addClass("d-block");
        } else {
            $("#brand_lainnya").val('');
            $('#brand_lainnya').removeClass("d-block");
            $('#brand_lainnya').addClass("d-none");
        }
    });
</script>
@endpush
