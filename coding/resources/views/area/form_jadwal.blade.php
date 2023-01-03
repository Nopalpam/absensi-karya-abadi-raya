<div class="modal fade" id="modal-jadwal" tabindex="-1" role="dialog" aria-labelledby="modal-form">
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
                        <label for="member" class="col-lg-2 col-lg-offset-1 control-label">Nama Pengguna</label>
                        <div class="col-lg-6">
                            <select name="member[]" id="member" class="form-control select2" multiple="multiple" data-placeholder="pilih karyawan" style="width:100%" required>
                                @foreach($members as $member)
                                <option value="{{$member->id}}">{{$member->name}}</option>
                                @endforeach
                            </select>
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