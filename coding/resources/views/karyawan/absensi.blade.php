@extends('layouts.master')

@section('title')
Absensi
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Pengaturan</li>
@endsection

@push('css')

<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Styles -->
    <style>
    html,
    body {
        background-color: #fff;
        font-family: 'Raleway', sans-serif;
        font-weight: 100;
        height: 100vh;
        margin: 0;
    }

    .full-height {
        height: 100vh;
    }

    .flex-center {
        align-items: center;
        display: flex;
        justify-content: center;
    }

    .position-ref {
        position: relative;
    }

    .top-right {
        position: absolute;
        right: 10px;
        top: 18px;
    }

    .content {
        text-align: center;
    }

    .title {
        font-size: 40px;
    }

    .links>a {
        color: #636b6f;
        padding: 0 25px;
        font-size: 12px;
        font-weight: 600;
        letter-spacing: .1rem;
        text-decoration: none;
        text-transform: uppercase;
    }

    .btn-md {
        padding: 1rem 2.4rem;
        font-size: .94rem;
        display: none;
    }

    .swal2-popup {
        font-family: inherit;
        font-size: 1.2rem;
    }

    .jam_analog {
        background: #e7f2f7;
        position: relative;
        width: 125px;
        height: 125px;
        border: 3px solid #52b6f0;
        border-radius: 50%;
        padding: 10px;
        margin: 10px auto;
    }

    .xxx {
        height: 100%;
        width: 100%;
        position: relative;
    }

    .jarum {
        position: absolute;
        width: 50%;
        background: #232323;
        top: 50%;
        transform: rotate(90deg);
        transform-origin: 100%;
        transition: all 0.05s cubic-bezier(0.1, 2.7, 0.58, 1);
    }

    .lingkaran_tengah {
        width: 24px;
        height: 24px;
        background: #232323;
        border: 4px solid #52b6f0;
        position: absolute;
        top: 50%;
        left: 50%;
        margin-left: -14px;
        margin-top: -14px;
        border-radius: 50%;
    }

    .jarum_detik {
        height: 2px;
        border-radius: 1px;
        background: #F0C952;
    }

    .jarum_menit {
        height: 4px;
        border-radius: 4px;
    }

    .jarum_jam {
        height: 6px;
        border-radius: 4px;
        width: 35%;
        left: 15%;
    }

    .jam-digital {
        overflow: hidden;
        width: 340px;
        margin: 10px auto;
        border: 5px solid #efefef;
    }

    .kotak {
        float: left;
        width: 110px;
        height: 60px;
        background-color: #189fff;
    }

    .jam-digital p {
        color: #fff;
        font-size: 36px;
        font-weight: 600;
        text-align: center;
    }
    </style>
@endpush

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="box">
            <div class="title">
                <div class="jam_analog">
                    <div class="xxx">
                        <div class="jarum jarum_detik"></div>
                        <div class="jarum jarum_menit"></div>
                        <div class="jarum jarum_jam"></div>
                        <div class="lingkaran_tengah"></div>
                    </div>
                </div>
                <div class="jam-digital">
                    <div class="kotak">
                        <p id="jam"></p>
                    </div>
                    <div class="kotak">
                        <p id="menit"></p>
                    </div>
                    <div class="kotak">
                        <p id="detik"></p>
                    </div>
                </div>
            </div>
            <p id="demo"></p>
            <form action="#" id="button" method="post" accept-charset="utf-8">
                {{ csrf_field() }}
                <div class="barcode" id="sourceSelectPanel" style="display:none">
                    <label for="sourceSelect">Change video source:</label>
                    <select id="sourceSelect" style="max-width:400px"></select>
                </div>
                <div class="barcode">
                    <video id="video" width="340" height="340"></video>
                </div>
                <input type="hidden" name="check_in" id="latitude">
                <input type="hidden" name="latitude" id="latitude">
                <input type="hidden" name="longitude" id="longitude">
                <textarea hidden="" name="barcode" id="result" readonly></textarea>
                <span> <input type="submit" id="button" class="margin btn btn-sm btn-success" value="Absen Masuk"></span>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript" src="{{ asset ('js/zxing/zxing.min.js') }}"></script>
<script type="text/javascript">
    window.addEventListener('load', function() {
        // open camera to barcode //
        let selectedDeviceId;
        let audio = new Audio("{{ asset ('audio/beep.mp3') }}");
        const codeReader = new ZXing.BrowserQRCodeReader();
        console.log('ZXing code reader initialized');
        codeReader.getVideoInputDevices().then((videoInputDevices) => {
                const sourceSelect = document.getElementById('sourceSelect')
                selectedDeviceId = videoInputDevices[0].deviceId
                if (videoInputDevices.length >= 1) {
                    videoInputDevices.forEach((element) => {
                        const sourceOption = document.createElement('option')
                        sourceOption.text = element.label
                        sourceOption.value = element.deviceId
                        sourceSelect.appendChild(sourceOption)
                    });
                    sourceSelect.onchange = () => {
                        selectedDeviceId = sourceSelect.value;
                    };
                    const sourceSelectPanel = document.getElementById('sourceSelectPanel')
                    sourceSelectPanel.style.display = 'block'
                }
                codeReader.decodeFromInputVideoDevice(selectedDeviceId, 'video').then((result) => {
                    console.log(result)
                    document.getElementById('result').textContent = result.text
                    if (result != null) {
                        audio.play();
                    }
                    $('#button').submit();
                }).catch((err) => {
                    console.error(err)
                    document.getElementById('result').textContent = err
                });
                console.log(`Started continous decode from camera with id ${selectedDeviceId}`)
            })
            .catch((err) => {
                console.error(err)
            });

    });
    // end open camera to barcode //
    </script>


    <script type="text/javascript">
    const secondHand = document.querySelector('.jarum_detik');
    const minuteHand = document.querySelector('.jarum_menit');
    const jarum_jam = document.querySelector('.jarum_jam');

    function setDate() {
        const now = new Date();

        const seconds = now.getSeconds();
        const secondsDegrees = ((seconds / 60) * 360) + 90;
        secondHand.style.transform = `rotate(${secondsDegrees}deg)`;
        if (secondsDegrees === 90) {
            secondHand.style.transition = 'none';
        } else if (secondsDegrees >= 91) {
            secondHand.style.transition = 'all 0.05s cubic-bezier(0.1, 2.7, 0.58, 1)'
        }

        const minutes = now.getMinutes();
        const minutesDegrees = ((minutes / 60) * 360) + 90;
        minuteHand.style.transform = `rotate(${minutesDegrees}deg)`;

        const hours = now.getHours();
        const hoursDegrees = ((hours / 12) * 360) + 90;
        jarum_jam.style.transform = `rotate(${hoursDegrees}deg)`;
    }

    setInterval(setDate, 1000);
    window.setTimeout("waktu()", 1000);

    function waktu() {
        var waktu = new Date();
        setTimeout("waktu()", 1000);
        document.getElementById("jam").innerHTML = waktu.getHours();
        document.getElementById("menit").innerHTML = waktu.getMinutes();
        document.getElementById("detik").innerHTML = waktu.getSeconds();
    }
    </script>
@endpush