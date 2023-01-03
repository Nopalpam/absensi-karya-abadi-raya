<div class="modal fade" id="modal-rekap" tabindex="-1" role="dialog" aria-labelledby="modal-form">
    <div class="modal-dialog modal-lg" role="document">
        <form action="" method="post" class="form-horizontal">
            @csrf
            @method('post')
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="tanggal" class="col-lg-2 col-lg-offset-1 control-label">Tanggal</label>
                        <div class="col-lg-6">
                            <input type="text" name="tanggal" id="daterangepicker" class="form-control datepicker" required autofocus style="border-radius: 0 !important;">
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="tanggal" class="col-lg-2 col-lg-offset-1 control-label">Tanggal</label>
                        <div class="col-lg-6">
                            <select name="nip" class="form-control select2" id="nip" width="100%">
                                <option selected value="all">--all karyawan--</option>
                                @foreach($karyawan as $data)
                                <option value="{{$data->nip}}" @if($data->nip == $nip)selected @endif>{{$data->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-flat btn-primary"><i class="fa fa-download"></i> Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>
@push('scripts')
<script>
$('.select2').select2();
$('#daterangepicker').daterangepicker({
    locale: {
        format: 'DD/MM/YYYY'
    }
});
</script>
@endpush