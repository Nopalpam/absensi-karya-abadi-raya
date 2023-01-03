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
                        <label for="work_order_number" class="col-lg-2 col-lg-offset-1 control-label">Work order number</label>
                        <div class="col-lg-6">
                            <input type="text" name="work_order_number" id="work_order_number" class="form-control" required autofocus autocomplete="off">
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="tanggal_service" class="col-lg-2 col-lg-offset-1 control-label">Tanggal service</label>
                        <div class="col-lg-6">
                            <input type="date" name="tanggal_service" id="tanggal_service" class="form-control" required autofocus autocomplete="off">
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="nama_customer" class="col-lg-2 col-lg-offset-1 control-label">Nama customer</label>
                        <div class="col-lg-6">
                            <select name="nama_customer" id="nama_customer" class="form-control" required>
                                <option value=""> Pilih nama customer</option>
                                @foreach ($getcustomer as $dgetcustomer)
                                <option value="{{$dgetcustomer->nama_customer}}">{{$dgetcustomer->nama_customer}}</option>
                                @endforeach
                            </select>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="plat_nomor_mobil" class="col-lg-2 col-lg-offset-1 control-label">Plat Nomor Mobil</label>
                        <div class="col-lg-6">
                            <input type="text" name="plat_nomor_mobil" id="plat_nomor_mobil" class="form-control" required autofocus autocomplete="off">
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="models" class="col-lg-2 col-lg-offset-1 control-label">Models</label>
                        <div class="col-lg-6">
                            <input type="text" name="models" id="models" class="form-control" required autofocus autocomplete="off">
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="vin" class="col-lg-2 col-lg-offset-1 control-label">VIN</label>
                        <div class="col-lg-6">
                            <input type="text" name="vin" id="vin" class="form-control" required autofocus autocomplete="off">
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="nama_teknisi" class="col-lg-2 col-lg-offset-1 control-label">Nama Teknisi</label>
                        <div class="col-lg-6">
                            <input type="text" name="nama_teknisi" id="nama_teknisi" class="form-control" readonly autofocus autocomplete="off" value="{{ auth()->user()->name }}">
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="brand" class="col-lg-2 col-lg-offset-1 control-label">Jenis pekerjaan</label>
                        <div class="col-lg-6">
                            <select name="jenis_pekerjaan[]" id="jenis_pekerjaan" class="form-control select2" data-placeholder=" pilih jenis pekerjaan" style="width:100%" multiple="multiple" required>
                                {{-- <option value="">Pilih jenis pekerjaan</option> --}}
                                @foreach ($getJpekerjaan as $dgetJpekerjaan)
                                <option value="{{$dgetJpekerjaan->id_jenis_pekerjaan}}">{{$dgetJpekerjaan->nama_pekerjaan}}</option>
                                @endforeach
                            </select>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="pekerjaan_lainnya" class="col-lg-2 col-lg-offset-1 control-label">Pekerjaan lainnya</label>
                        <div class="col-lg-6">
                            <input type="text" name="pekerjaan_lainnya" id="pekerjaan_lainnya" class="form-control" autocomplete="off">
                            <span class="help-block with-errors"></span>
                        </div>
                        <div class="col-lg-12 col-lg-offset-3">
                            <small>Optional</small>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="harga" class="col-lg-2 col-lg-offset-1 control-label">Harga</label>
                        <div class="col-lg-6">
                            <input type="text" name="harga" id="harga" class="form-control" autocomplete="off">
                            <span class="help-block with-errors"></span>
                        </div>
                        <div class="col-lg-12 col-lg-offset-3">
                            <small>Optional : Harga diisi ketika ada pekerjaan lain-lain</small>
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
    // select2
    $('#jenis_pekerjaan').select2({
        multiple:true
    });
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
