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
                    <input type="hidden" name="id_area">
                    <!-- <div class="form-group row">
                        <label for="tanggal" class="col-lg-2 col-lg-offset-1 control-label">Tanggal</label>
                        <div class="col-lg-6">
                            <input type="text" name="tanggal" id="daterangepicker" class="form-control datepicker" required autofocus
                                value="{{ request('tanggal') }}"
                                style="border-radius: 0 !important;">
                            <span class="help-block with-errors"></span>
                        </div>
                    </div> -->
                    <div class="form-group row">
                        <label for="member" class="col-lg-2 col-lg-offset-1 control-label">Nama Pengguna</label>
                        <div class="col-lg-6">
                            <select name="member" id="member" class="form-control" odata-placeholder="pilih karyawan" style="width:100%" required>
                                <option value=""> pilih karyawan</option>
                                @foreach($members as $member)
                                <option value="{{$member->id}}">{{$member->name}}</option>
                                @endforeach
                            </select>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="area" class="col-lg-2 col-lg-offset-1 control-label">Lokasi Area</label>
                        <div class="col-lg-6">
                            <select name="id_area[]" id="area" class="form-control select2" data-placeholder="pilih karyawan" style="width:100%" multiple="multiple" required>
                                <option value=""> pilih karyawan</option>
                                @foreach($areas as $area)
                                <option value="{{$area->id}}">{{$area->nama_area}}</option>
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
    $('#area').select2({
        multiple:true
    });


    $('#daterangepicker').daterangepicker({
        locale: {
            format: 'DD/MM/YYYY'
        }
    });
</script>
@endpush