<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>


    <!-- General CSS Files -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('assetsinvoice/style-invoice.css') }}">
    {{-- <link rel="stylesheet" href="{{ asset('assetsinvoice/bootstrap4.min.css') }}"> --}}

    <style>
        @page {size: 595px 842px; margin:0!important; padding:0!important}
        .row {
            display: -webkit-box; /* wkhtmltopdf uses this one */
            display: flex;
            -webkit-box-pack: center; /* wkhtmltopdf uses this one */
            justify-content: center;
        }

        .row > div {
            -webkit-box-flex: 1;
            -webkit-flex: 1;
            flex: 1;
        }

        .row > div:last-child {
            margin-right: 0;
        }
    </style>

</head>

<body>



    <div class="invoice">
        <page size="A4">
            <div class="invoice-top mb-4">
                <div class="invoice-header mb-4">
                    <div class="invoice-container">
                        <div class="row">
                            <div class="col-6">
                                <div class="img-logo">
                                    <img src="{{ asset('assetsinvoice/logo-20221218212859.jpg') }}" width="95px" alt="">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="text text-right" style="margin-top: 2%;">
                                    NO INVOICE {{$datasettle[0]->id_invoice}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="invoice-content">
                    <div class="row">
                        <div class="col-4">
                            <div class="item-invoice">
                                <div class="title">Tagihan Untuk</div>
                                <div class="value mb-1">{{$getDealer[0]->nama_customer}}</div>
                                <div class="desc">
                                    {{$getDealer[0]->alamat}}
                                    <br> Contact Person : {{$getDealer[0]->contact_person}}
                                    <br> Nomor MOU : {{$getDealer[0]->nomor_mou}}
                                </div>
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="item-invoice mb-2">
                                <div class="title">Tanggal Tagihan</div>
                                <div class="value">{{ date_format($datasettle[0]->created_at,"d F Y H:i") }}</div>
                            </div>
                            <div class="item-invoice">
                                <div class="title">Tagihan Dari</div>
                                <div class="value text-uppercase mb-1">CV Karya Abadi Raya</div>
                                <div class="desc">
                                    {{$getSetting[0]->alamat}}
                                    <br> Contact : {{$getSetting[0]->telepon}}
                                    <br> NPWP : {{$datasettle[0]->npwp}}
                                </div>
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="invoice-status text-uppercase text-center mb-2" style="background: #d1eaff;color: #275dae;">
                                Total Tagihan
                            </div>
                            <div class="total-payment success">
                                <div class="title">
                                    Jumlah :
                                </div>
                                <div class="value mb-2" id="getTotalPembayaran">

                                </div>

                                <div class="title-deadline">
                                    Jumlah sudah termasuk PPN
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
            <div class="invoice-middle">
                <div class="invoice-container">

                    <div class="invoice-table pt-2">
                        <div class="title mb-3"><i class="fas fa-receipt" style="color:#005bbb;"></i>&nbsp; List Data</div>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col" class="table-title">NO SPK</th>
                                    <th scope="col" class="table-title">TANGGAL SERVICE</th>
                                    <th scope="col" class="table-title">JENIS PEKERJAAN</th>
                                    <th scope="col" class="text-right table-title">HARGA</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i=1;
                                    $sum_tot_Price_Sum = 0;
                                @endphp
                                @foreach($data as $p)
                                <tr>
                                    <td class="table-value">{{$p->no_spk}}</td>
                                    <td class="table-value">{{$p->tanggal_service}}</td>
                                    <td class="table-value">
                                        @foreach (getJPekerjaan($p->jenis_pekerjaan) as $ditem)
                                            {{ $loop->first ? '' : ', ' }}
                                            {{$ditem->nama_pekerjaan}}
                                            @if($loop->last)
                                                @if($p->pekerjaan_lainnya != '-')
                                                    , {{ $p->pekerjaan_lainnya }}
                                                @endif
                                            @endif
                                        @endforeach
                                    </td>
                                    <td class="text-right table-value font-weight-bold">
                                        <?php
                                            $sum_tot_Price = 0;
                                        ?>
                                        @foreach (getJPekerjaan($p->jenis_pekerjaan) as $ditem)
                                            @php
                                                $sum_tot_Price += removeString($ditem->harga)
                                            @endphp
                                            @if($loop->last)
                                            @php
                                                $sum_tot_Price_total = ((int)$sum_tot_Price  + (int)removeString($p->harga))
                                            @endphp
                                                {{ 'Rp. '.formatRupiah($sum_tot_Price_total) }}
                                            @endif
                                        @endforeach
                                    </td>
                                </tr>
                                @php
                                $sum_tot_Price_Sum += $sum_tot_Price_total;
                                @endphp
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <hr class="mt-4">

                    @php
                    $sum_tot_Price_Sum_ppn = $sum_tot_Price_Sum * 0.11;
                    @endphp

                    <div class="invoice-table mb-2">
                        <div class="title mb-2"><i class="fas fa-receipt" style="color:#005bbb;"></i>&nbsp; Rincian Tagihan</div>
                        <table class="table table-borderless">
                            <thead>
                                <tr>
                                    <th scope="col" class="pl-0 table-title">DESKRIPSI</th>
                                    <th scope="col" class="pl-0 text-right table-title">TOTAL</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="pl-0 table-value">{{$datasettle[0]->desc}}</td>
                                    <td class="pl-0 text-right table-value font-weight-bold">{{ 'Rp. '.formatRupiah($sum_tot_Price_Sum) }}</td>
                                </tr>
                            </tbody>
                        </table>
                        <hr>
                        <div class="row">
                            <div class="col-6">
                                <div class="invoice-note">
                                    <div class="title mb-2"><i class="fas fa-sticky-note" style="color:#f8981c"></i>&nbsp; Catatan</div>
                                    <div class="desc">
                                        <ul>
                                            <li> Biaya PPN atau Pajak sebesar <b>11%</b> sesuai dengan total harga keseluruhan.</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <table class="table table-borderless">
                                    <tbody>
                                        <tr>
                                            <td class="pl-0 table-value">Sub Total</td>
                                            <td class="pl-0 text-right table-value font-weight-bold">{{ 'Rp. '.formatRupiah($sum_tot_Price_Sum) }}</td>
                                        </tr>
                                        <tr>
                                            <td class="pl-0 table-value">PPN</td>
                                            <td class="pl-0 text-right table-value font-weight-bold">{{ 'Rp. '.formatRupiah($sum_tot_Price_Sum_ppn) }}</td>
                                        </tr>
                                        <tr>
                                            <td class="pl-0 table-value">Total Pembayaran</td>
                                            <td class="pl-0 text-right table-value font-weight-bold">{{ 'Rp. '.formatRupiah($sum_tot_Price_Sum_ppn+$sum_tot_Price_Sum_ppn) }}</td>
                                            <input type="hidden" id="TotalPembayaran" value="{{ 'Rp. '.formatRupiah($sum_tot_Price_Sum_ppn+$sum_tot_Price_Sum_ppn) }}">
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-12">
                                <div class="title mb-3"><i class="fas fa-receipt" style="color:#005bbb;"></i>&nbsp; Tujuan Transfer</div>
                                <p>Nama Bank : <b>{{$datasettle[0]->nama_bank}}</b></p>
                                <p>Nomor Rekening : <b>{{$datasettle[0]->norek}}</b></p>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </page>
    </div>

    <script src="{{ asset('AdminLTE-2/bower_components/jquery/dist/jquery.min.js') }}"></script>
    <script>
        $('#getTotalPembayaran').text($('#TotalPembayaran').val());
    </script>


</body>
</html>
