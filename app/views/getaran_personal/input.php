 <!-- * App Sidebar -->
<div id="appCapsule">
    <div class="section mb-5 p-2">
        <form id="form-add">
            <div class="card">
                <div class="card-body pb-1">
                    <div class="row">
                        <div class="col-12 text-center">
                            <label for="">FDL Getaran Personal</label>
                        </div>
                    </div>
                    <div class="form-group basic">
                        <div class="input-wrapper">
                            <label class="label">No Sample</label>
                            <input type="text" class="form-control" id="no_sample" name="no_sample" placeholder="Masukan No Sample" required>
                            <i class="clear-input">
                                <ion-icon name="close-circle" role="img" class="md hydrated" aria-label="close circle"></ion-icon>
                            </i>
                        </div>
                    </div>
                    <div id="option"></div>
                    <div id="udara"></div>
                    <div class="row mb-2">
                        <div class="col-6">
                            <div class="form-group basic">
                                <button class="btn btn-primary" type="reset" onclick="ress()" style="width:100%"> Cancel </button>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group basic">
                                <button class="btn btn-success" type="submit" style="width:100%"> Save</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="btnBottom">
    <div class="btnTengah" onclick="location.href='kebisingan/add_data'"></a></div>
    <div class="btnMenu">
        <ul>
            <li style="--i:0.1s;"><a href="<?= base_url;?>/home"><i class="fa-solid fa-gauge"></i></a></li>
            <li style="--i:0.2s;"><a href="<?= base_url;?>/kebisingan"><i class="fa-solid fa-house"></i></a></li>
            <li></li>
            <li style="--i:0.2s;"><a href="<?= base_url;?>/kebisingan/viewDatakebisingan"><i class="fa-solid fa-file-lines"></i></a></li>
            <li style="--i:0.1s;"><a href="<?= base_url;?>/profile"><i class="fa-solid fa-user"></i></a></li>
        </ul>
    </div>
</div>

<!-- Javascript begins here -->
<script>
    let uri = '<?= base_url; ?>/assets/sound/';
    var success = new Audio(uri + 'success.wav');
    var error = new Audio(uri + 'error.mp3');

    function ress() {
        Swal.fire({
            icon: 'info',
            title: 'Apakah ingin meng-cancel data.?',
            showCancelButton: true,
            confirmButtonText: 'Yes',
        }).then((result) => {
            if (result.isConfirmed) {
                $('#option').empty();
                $('#udara').empty();
                $('#no_sample').val('');
            }
        });
    }

    $('#no_sample').on('keydown', function(e){
        if (e.key === "Enter") {
            if($('#status-text').text() == 'Online'){

                $.ajax({
                    url: '<?= base_url; ?>/getaranpersonal/getSample',
                    method: 'POST',
                    data: {no_sample : $("#no_sample").val()},
                    success : function(res){
                        res = JSON.parse(res)
                        if (res.id_ket == '17' || res.id_ket == '20') {
                            $('#option').html(selectoption).fadeIn('slow');
                            $('#udara').html(getaranPersonal).fadeIn('slow');
                            $('#keterangan-4').val(res.keterangan);
                            $('#id_ket').val(res.id_ket);
                            $('#time').clockTimePicker();
                            $('#btnBawah').hide()
                            selectMpersn(res.id_ket);
                            if (res.id_ket == '17') {
                                $('#sebagian').show();
                            }
                            if (res.id_ket == '20') {
                                $('#seluruh').show();
                            }
                        } else {
                            error.play();
                            Swal.fire({
                                title: 'Waring......!',
                                icon: 'warning',
                                text: 'Tidak ada kategori FDL getaran personal di No Sample tersebut',
                                confirmButtonColor: '#3085d6',
                            })
                        }
                    },
                    error : function(err){
                        err = JSON.parse(err)
                        Swal.fire({
                            icon: 'error',
                            title: 'Error.....!',
                            text: err.responseJSON.message
                        })
                    }
                })
                return false
            }else {
                Swal.fire({
                    title: 'Waring......!',
                    icon: 'warning',
                    text: 'Anda Sedang Offline Silahkan Isi Data Secara Manual Sesuai Surat Tugas',
                    confirmButtonColor: '#3085d6',
                })
                $('#option').html(selectoption).fadeIn('slow');
            }
        }
    })

    $('#id_ket').on('change', function(){
        if($(this).val() == 17 || $(this).val() == 20){
            $('#udara').html(getaranPersonal).fadeIn('slow');
            $('#time').clockTimePicker();
            selectMpersn(res.id_ket);
            if ($(this).val() == 17) {
                $('#sebagian').show();
            }
            if ($(this).val() == 20) {
                $('#seluruh').show();
            }
        }
    })

    function selectMpersn(kat) {
        $("#metode_peng").on("change", function() {
            var option = $(this).val();
            if (option == 'Langsung') {
                $('#peng_sung').show();
                $('#peng_per').hide();
                input_getPLans(kat);
                peng_sung()
                $("#pengukuranPer").empty();
                $("#sat_pengP").empty();
            } else if (option == 'Personal') {
                $('#peng_per').show();
                $('#peng_sung').hide();
                input_getPPer();
                peng_per()
                $("#pengukuran").empty();
                $("#sat_pengL").empty();
            }
        });
    }

    function mulai() {
        var date = new Date();
        jam = date.getHours();
        jam = ("0" + jam).slice(-2);
        menit = date.getMinutes();
        menit = ("0" + menit).slice(-2);
        $('#time').val(jam + ":" + menit);
    }

    function peng_sung(){
        $("#sat_pengL").empty();
        var a = '<div class="col-6 mb-1"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1">Satuan Percepatan (RMS)</label><select name="satPer" id="satPer" class="form-control" autocomplete="off" style="font-size:10px"><option value="">--Pilih Satuan--</option><option value="mm/s">mm/s</option><option value="mm/s2">mm/s<sup>2</sup></option><option value="m/s2">m/s<sup>2</sup></option></select></div></div></div><div class="col-6 mb-1"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1">Satuan Kecepatan (RMS)</label><select name="satKec" id="satKec" class="form-control" autocomplete="off" style="font-size:10px"><option value="">--Pilih Satuan--</option><option value="mm/s=">mm/s</option><option value="mm/s2">mm/s<sup>2</sup></option><option value="m/s2">m/s<sup>2</sup></option></select></div></div></div>';
        $('#sat_pengL').append(a);
    }

    function peng_per(){
        $("#sat_pengP").empty();
        var b = '<div class="col-6 mb-1"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1">Satuan Sumbu X</label><select name="satKecX" id="satKecX" class="form-control" autocomplete="off" style="font-size:10px"><option value="">--Pilih Satuan--</option><option value="mm/s=">mm/s</option><option value="mm/s2">mm/s<sup>2</sup></option><option value="m/s2">m/s<sup>2</sup></option></select></div></div></div><div class="col-6 mb-1"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1">Satuan Sumbu Y</label><select name="satKecY" id="satKecY" class="form-control" autocomplete="off" style="font-size:10px"><option value="mm/s=">mm/s</option><option value="mm/s2">mm/s<sup>2</sup></option><option value="m/s2">m/s<sup>2</sup></option></select></div></div></div><div class="col-6 mb-1"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1">Satuan Sumbu Z</label><select name="satKecZ" id="satKecZ" class="form-control" autocomplete="off" style="font-size:10px"><option value="">--Pilih Satuan--</option><option value="mm/s=">mm/s</option><option value="mm/s2">mm/s<sup>2</sup></option><option value="m/s2">m/s<sup>2</sup></option></select></div></div></div>';
        $('#sat_pengP').append(b);
    }

    function input_getPPer() {
        $("#pengukuranPer").empty();
        for (i = 1; i <= 3; i++) {
            var boddi = '<div class="mb-1 row px-3"><div class="row"><div class="col-12 text-center"><label class="label label-1" for="modalInputusername">Sumbu X (RMS)</label></div><div class="col-6"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1" for="modalInputusername">Data 1</label><input id="x1-' + i + '" type="number" class="' + i + ' form-control" name="x1[]" autocomplete="off" step="0.0001" required><span class="text-danger" id="validP1-' + i + '" style="font-size:8px;display:none">(Ex. 0.0005)</span><span class="text-success" id="ceklisP1-' + i + '" style="font-size:8px;display:none">Desimal sesuai</span></div></div></div><div class="col-6"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1" for="modalInputusername">Data 2</label><input id="x2-' + i + '" type="number" class="' + i + ' form-control" name="x2[]" autocomplete="off" step="0.0001" required><span class="text-danger" id="validP2-' + i + '" style="font-size:8px;display:none">(Ex. 0.0005)</span><span class="text-success" id="ceklisP2-' + i + '" style="font-size:8px;display:none">Desimal sesuai</span></div></div></div></div><div class="row"><div class="col-12 text-center"><label class="label label-1" for="modalInputusername">Sumbu Y (RMS)</label></div><div class="col-6"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1" for="modalInputusername">Data 1</label><input id="y1-' + i + '" type="number" class="' + i + ' form-control" name="y1[]" autocomplete="off" step="0.0001" required><span class="text-danger" id="validP3-' + i + '" style="font-size:8px;display:none">(Ex. 0.0005)</span><span class="text-success" id="ceklisP3-' + i + '" style="font-size:8px;display:none">Desimal sesuai</span></div></div></div><div class="col-6"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1" for="modalInputusername">Data 2</label><input id="y2-' + i + '" type="number" class="' + i + ' form-control" name="y2[]" autocomplete="off" step="0.0001" required><span class="text-danger" id="validP4-' + i + '" style="font-size:8px;display:none">(Ex. 0.0005)</span><span class="text-success" id="ceklisP4-' + i +
            '" style="font-size:8px;display:none">Desimal sesuai</span></div></div></div></div><div class="row"><div class="col-12 text-center"><label class="label label-1" for="modalInputusername">Sumbu Z (RMS)</label></div><div class="col-6"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1" for="modalInputusername">Data 1</label><input id="z1-' + i + '" type="number" class="' + i + ' form-control" name="z1[]" autocomplete="off" step="0.0001" required><span class="text-danger" id="validP5-' + i + '" style="font-size:8px;display:none">(Ex. 0.0005)</span><span class="text-success" id="ceklisP5-' + i + '" style="font-size:8px;display:none">Desimal sesuai</span></div></div></div><div class="col-6"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1" for="modalInputusername">Data 2</label><input id="z2-' + i + '" type="number" class="' + i + ' form-control" name="z2[]" autocomplete="off" step="0.0001" required><span class="text-danger" id="validP6-' + i + '" style="font-size:8px;display:none">(Ex. 0.0005)</span><span class="text-success" id="ceklisP6-' + i + '" style="font-size:8px;display:none">Desimal sesuai</span></div></div></div></div></div></div>'
            $('#pengukuranPer').append(boddi);
            $('.peng-getLingP-1').show();
            $("#btnAksii").empty();
            var btn ='<div class="mb-2 mt-2"><div class="row justify-content-center"><div class="col-6"><div class="form-group basic"><button type="button" class="btn btn-success w-100" id="prevP">&laquo; Sebelumnya</button></div></div><div class="col-6"><div class="form-group basic"><button type="button" class="btn btn-success w-100" id="nextP">Selanjutnya &raquo;</button></div></div></div></div>'
            $('#btnAksii').append(btn);

            $('#x1-' + i + '').on('keyup', function() {
                var i = this.classList[0]
                var ul1 = $("#x1-" + i + "").val();

                if (ul1 !== ".") {
                    $('#validP1-' + i + '').show();
                    $('#ceklisP1-' + i + '').hide();
                }
                if (ul1.includes('.')) {
                    ul1 = $("#x1-" + i + "").val();
                    var nil2 = ul1.toString().split(".")[1].length;
                    if (nil2 > 3) {
                        $('#validP1-' + i + '').hide();
                        $('#ceklisP1-' + i + '').show();
                    }
                    if (nil2 > 4) {
                        $('#validP1-' + i + '').show();
                        $('#ceklisP1-' + i + '').hide();
                    }
                }
            })

            $('#x2-' + i + '').on('keyup', function() {
                var i = this.classList[0]
                var ul1 = $("#x2-" + i + "").val();

                if (ul1 !== ".") {
                    $('#validP2-' + i + '').show();
                    $('#ceklisP2-' + i + '').hide();
                }
                if (ul1.includes('.')) {
                    ul1 = $("#x2-" + i + "").val();
                    var nil2 = ul1.toString().split(".")[1].length;
                    if (nil2 > 3) {
                        $('#validP2-' + i + '').hide();
                        $('#ceklisP2-' + i + '').show();
                    }
                    if (nil2 > 4) {
                        $('#validP2-' + i + '').show();
                        $('#ceklisP2-' + i + '').hide();
                    }
                }
            })

            $('#y1-' + i + '').on('keyup', function() {
                var i = this.classList[0]
                var ul1 = $("#y1-" + i + "").val();

                if (ul1 !== ".") {
                    $('#validP3-' + i + '').show();
                    $('#ceklisP3-' + i + '').hide();
                }
                if (ul1.includes('.')) {
                    ul1 = $("#y1-" + i + "").val();
                    var nil2 = ul1.toString().split(".")[1].length;
                    if (nil2 > 3) {
                        $('#validP3-' + i + '').hide();
                        $('#ceklisP3-' + i + '').show();
                    }
                    if (nil2 > 4) {
                        $('#validP3-' + i + '').show();
                        $('#ceklisP3-' + i + '').hide();
                    }
                }
            })

            $('#y2-' + i + '').on('keyup', function() {
                var i = this.classList[0]
                var ul1 = $("#y2-" + i + "").val();

                if (ul1 !== ".") {
                    $('#validP4-' + i + '').show();
                    $('#ceklisP4-' + i + '').hide();
                }
                if (ul1.includes('.')) {
                    ul1 = $("#y2-" + i + "").val();
                    var nil2 = ul1.toString().split(".")[1].length;
                    if (nil2 > 3) {
                        $('#validP4-' + i + '').hide();
                        $('#ceklisP4-' + i + '').show();
                    }
                    if (nil2 > 4) {
                        $('#validP4-' + i + '').show();
                        $('#ceklisP4-' + i + '').hide();
                    }
                }
            })

            $('#z1-' + i + '').on('keyup', function() {
                var i = this.classList[0]
                var ul1 = $("#z1-" + i + "").val();

                if (ul1 !== ".") {
                    $('#validP5-' + i + '').show();
                    $('#ceklisP5-' + i + '').hide();
                }
                if (ul1.includes('.')) {
                    ul1 = $("#z1-" + i + "").val();
                    var nil2 = ul1.toString().split(".")[1].length;
                    if (nil2 > 3) {
                        $('#validP5-' + i + '').hide();
                        $('#ceklisP5-' + i + '').show();
                    }
                    if (nil2 > 4) {
                        $('#validP5-' + i + '').show();
                        $('#ceklisP5-' + i + '').hide();
                    }
                }
            })

            $('#z2-' + i + '').on('keyup', function() {
                var i = this.classList[0]
                var ul1 = $("#z2-" + i + "").val();

                if (ul1 !== ".") {
                    $('#validP6-' + i + '').show();
                    $('#ceklisP6-' + i + '').hide();
                }
                if (ul1.includes('.')) {
                    ul1 = $("#z2-" + i + "").val();
                    var nil2 = ul1.toString().split(".")[1].length;
                    if (nil2 > 3) {
                        $('#validP6-' + i + '').hide();
                        $('#ceklisP6-' + i + '').show();
                    }
                    if (nil2 > 4) {
                        $('#validP6-' + i + '').show();
                        $('#ceklisP6-' + i + '').hide();
                    }
                }
            })
        }

        let vi = 1,fi = 0,wi = 0,fe = 0,we = 0;
        $('#nextP').prop("disabled", false)
        $('#prevP').prop("disabled", true)
        $('#peng_kP').html(vi);

        $('#nextP').click(function() {
            fi = ++vi
            wi = vi - 1;
            $('#peng_kP').html(vi);
            $('#prevP').prop("disabled", false)
            if (fi == 3) {
                $('#nextP').prop("disabled", true)
            }
            // console.log(vi)
            $('.peng-getLingP-' + fi).show();
            $('.peng-getLingP-' + wi).hide();

        });
        $('#prevP').click(function() {
            fe = vi--
            we = vi
            $('#peng_kP').html(we);
            if (fe == 2) {
                $('#prevP').prop("disabled", true)
            }
            $('.peng-getLingP-' + fe).hide();
            $('.peng-getLingP-' + we).show();
            $('#nextP').prop("disabled", false)
        });
    }

    function input_getPLans(kat){
        if (kat == 20) {
            $('#posisi_pengSl').on('change', () => {
                $("#pengukuran").empty();
                var posisi = $('#posisi_pengSl').val();
                if (posisi == 'Duduk' || posisi == 'Berbaring') {
                    $("#pengukuran").empty();
                    for (i = 1; i <= 3; i++) {
                        var boddi = '<div class="peng-getLing-' + i + '" style="display: none;">'
                        boddi += '<div class="mb-0"><h6>Pengukuran : Tangan</h6></div>'
                        boddi += '<div class="row px-3 mb-2">'
                        boddi += '<div class="col-12 text-center">'
                        boddi += '<label class="label label-1" for="modalInputusername">Percepatan (RMS)</label>'
                        boddi += '</div>'
                        boddi += '<div class="col-6">'
                        boddi += '<div class="form-group basic">'
                        boddi += '<div class="input-wrapper">'
                        boddi += '<label class="label label-1" for="modalInputusername">Nilai Max</label>'
                        boddi += '<input id="permax1-' + i + '" type="number" class="' + i +
                            ' form-control" name="permax1[]" autocomplete="off" step="0.0001" required>'
                        boddi += '<span class="text-danger" id="valid1-' + i +
                            '" style="font-size: 8px; display: none;">(Ex. 0.0005)</span>'
                        boddi += '<span class="text-success" id="ceklis1-' + i +
                            '" style="font-size: 8px; display: none;">Desimal sesuai</span>'
                        boddi += '</div>'
                        boddi += '</div>'
                        boddi += '</div>'
                        boddi += '<div class="col-6">'
                        boddi += '<div class="form-group basic">'
                        boddi += '<div class="input-wrapper">'
                        boddi += '<label class="label label-1" for="modalInputusername">Nilai Min</label>'
                        boddi += '<input id="permin1-' + i + '" type="number" class="' + i +
                            ' form-control" name="permin1[]" autocomplete="off" step="0.0001" required>'
                        boddi += '<span class="text-danger" id="valid2-' + i +
                            '" style="font-size: 8px; display: none;">(Ex. 0.0005)</span>'
                        boddi += '<span class="text-success" id="ceklis2-' + i +
                            '" style="font-size: 8px; display: none;">Desimal sesuai</span>'
                        boddi += '</div>'
                        boddi += '</div>'
                        boddi += '</div>'
                        boddi += '<div class="row px-3">'
                        boddi += '<div class="col-12 text-center">'
                        boddi += '<label class="label label-1" for="modalInputusername">Kecepatan (RMS)</label>'
                        boddi += '</div>'
                        boddi += '<div class="col-6">'
                        boddi += '<div class="form-group basic">'
                        boddi += '<div class="input-wrapper">'
                        boddi += '<label class="label label-1" for="modalInputusername">Nilai Max</label>'
                        boddi += '<input id="kecmax1-' + i + '" type="number" class="' + i +
                            ' form-control" name="kecmax1[]" autocomplete="off" step="0.0001" required>'
                        boddi += '<span class="text-danger" id="valid3-' + i +
                            '" style="font-size: 8px; display: none;">(Ex. 0.0005)</span>'
                        boddi += '<span class="text-success" id="ceklis3-' + i +
                            '" style="font-size: 8px; display: none;">Desimal sesuai</span>'
                        boddi += '</div>'
                        boddi += '</div>'
                        boddi += '</div>'
                        boddi += '<div class="col-6">'
                        boddi += '<div class="form-group basic">'
                        boddi += '<div class="input-wrapper">'
                        boddi += '<label class="label label-1" for="modalInputusername">Nilai Min</label>'
                        boddi += '<input id="kecmin1-' + i + '" type="number" class="' + i +
                            ' form-control" name="kecmin1[]" autocomplete="off" step="0.0001" required>'
                        boddi += '<span class="text-danger" id="valid4-' + i +
                            '" style="font-size: 8px; display: none;">(Ex. 0.0005)</span>'
                        boddi += '<span class="text-success" id="ceklis4-' + i +
                            '" style="font-size: 8px; display: none;">Desimal sesuai</span>'
                        boddi += '</div>'
                        boddi += '</div>'
                        boddi += '</div>'
                        boddi += '</div>'
                        boddi += '</div>'
                        boddi += '<div class="mb-0"><h6>Pengukuran : Pinggang</h6></div>'
                        boddi += '<div class="row px-3 mb-2">'
                        boddi += '<div class="col-12 text-center">'
                        boddi += '<label class="label label-1" for="modalInputusername">Percepatan (RMS)</label>'
                        boddi += '</div>'
                        boddi += '<div class="col-6">'
                        boddi += '<div class="form-group basic">'
                        boddi += '<div class="input-wrapper">'
                        boddi += '<label class="label label-1" for="modalInputusername">Nilai Max</label>'
                        boddi += '<input id="permax2-' + i + '" type="number" class="' + i +
                            ' form-control" name="permax2[]" autocomplete="off" step="0.0001" required>'
                        boddi += '<span class="text-danger" id="valid5-' + i +
                            '" style="font-size: 8px; display: none;">(Ex. 0.0005)</span>'
                        boddi += '<span class="text-success" id="ceklis5-' + i +
                            '" style="font-size: 8px; display: none;">Desimal sesuai</span>'
                        boddi += '</div>'
                        boddi += '</div>'
                        boddi += '</div>'
                        boddi += '<div class="col-6">'
                        boddi += '<div class="form-group basic">'
                        boddi += '<div class="input-wrapper">'
                        boddi += '<label class="label label-1" for="modalInputusername">Nilai Min</label>'
                        boddi += '<input id="permin2-' + i + '" type="number" class="' + i +
                            ' form-control" name="permin2[]" autocomplete="off" step="0.0001" required>'
                        boddi += '<span class="text-danger" id="valid6-' + i +
                            '" style="font-size: 8px; display: none;">(Ex. 0.0005)</span>'
                        boddi += '<span class="text-success" id="ceklis6-' + i +
                            '" style="font-size: 8px; display: none;">Desimal sesuai</span>'
                        boddi += '</div>'
                        boddi += '</div>'
                        boddi += '</div>'
                        boddi += '<div class="row px-3">'
                        boddi += '<div class="col-12 text-center">'
                        boddi += '<label class="label label-1" for="modalInputusername">Kecepatan (RMS)</label>'
                        boddi += '</div>'
                        boddi += '<div class="col-6">'
                        boddi += '<div class="form-group basic">'
                        boddi += '<div class="input-wrapper">'
                        boddi += '<label class="label label-1" for="modalInputusername">Nilai Max</label>'
                        boddi += '<input id="kecmax2-' + i + '" type="number" class="' + i +
                            ' form-control" name="kecmax2[]" autocomplete="off" step="0.0001" required>'
                        boddi += '<span class="text-danger" id="valid7-' + i +
                            '" style="font-size: 8px; display: none;">(Ex. 0.0005)</span>'
                        boddi += '<span class="text-success" id="ceklis7-' + i +
                            '" style="font-size: 8px; display: none;">Desimal sesuai</span>'
                        boddi += '</div>'
                        boddi += '</div>'
                        boddi += '</div>'
                        boddi += '<div class="col-6">'
                        boddi += '<div class="form-group basic">'
                        boddi += '<div class="input-wrapper">'
                        boddi += '<label class="label label-1" for="modalInputusername">Nilai Min</label>'
                        boddi += '<input id="kecmin2-' + i + '" type="number" class="' + i +
                            ' form-control" name="kecmin2[]" autocomplete="off" step="0.0001" required>'
                        boddi += '<span class="text-danger" id="valid8-' + i +
                            '" style="font-size: 8px; display: none;">(Ex. 0.0005)</span>'
                        boddi += '<span class="text-success" id="ceklis8-' + i +
                            '" style="font-size: 8px; display: none;">Desimal sesuai</span>'
                        boddi += '</div>'
                        boddi += '</div>'
                        boddi += '</div>'
                        boddi += '</div>'
                        boddi += '</div>'
                        $('#pengukuran').append(boddi);
                        $('.peng-getLing-1').show();

                        $("#btnAksi").empty();
                        var btn =
                            '<div class="mb-2 mt-2"><div class="row justify-content-center"><div class="col-6"><div class="form-group basic"><button type="button" class="btn btn-success w-100" id="prev">&laquo; Sebelumnya</button></div></div><div class="col-6"><div class="form-group basic"><button type="button" class="btn btn-success w-100" id="next">Selanjutnya &raquo;</button></div></div></div></div>'
                        $('#btnAksi').append(btn);

                        $('#permax1-' + i + '').on('keyup', function() {
                            var i = this.classList[0]
                            var ul1 = $("#permax1-" + i + "").val();

                            if (ul1 !== ".") {
                                $('#valid1-' + i + '').show();
                                $('#ceklis1-' + i + '').hide();
                            }
                            if (ul1.includes('.')) {
                                ul1 = $("#permax1-" + i + "").val();
                                var nil2 = ul1.toString().split(".")[1].length;
                                if (nil2 > 3) {
                                    $('#valid1-' + i + '').hide();
                                    $('#ceklis1-' + i + '').show();
                                }
                                if (nil2 > 4) {
                                    $('#valid1-' + i + '').show();
                                    $('#ceklis1-' + i + '').hide();
                                }
                            }
                        })

                        $('#permin1-' + i + '').on('keyup', function() {
                            var i = this.classList[0]
                            var ul1 = $("#permin1-" + i + "").val();
                            var ul2 = $("#permax1-" + i + "").val();
                            if (ul1 > ul2) {
                                Swal.fire({
                                    icon: 'info',
                                    title: 'Nilai percepatan Min tidak boleh melebihi nilai percepatan Max..',
                                    timer: 3000
                                });
                            }
                            if (ul1 !== ".") {
                                $('#valid2-' + i + '').show();
                                $('#ceklis2-' + i + '').hide();
                            }
                            if (ul1.includes('.')) {
                                ul1 = $("#permin1-" + i + "").val();
                                var nil2 = ul1.toString().split(".")[1].length;
                                if (nil2 > 3) {
                                    $('#valid2-' + i + '').hide();
                                    $('#ceklis2-' + i + '').show();
                                }
                                if (nil2 > 4) {
                                    $('#valid2-' + i + '').show();
                                    $('#ceklis2-' + i + '').hide();
                                }
                            }
                        })

                        $('#kecmax1-' + i + '').on('keyup', function() {
                            var i = this.classList[0]
                            var ul1 = $("#kecmax1-" + i + "").val();

                            if (ul1 !== ".") {
                                $('#valid3-' + i + '').show();
                                $('#ceklis3-' + i + '').hide();
                            }
                            if (ul1.includes('.')) {
                                ul1 = $("#kecmax1-" + i + "").val();
                                var nil2 = ul1.toString().split(".")[1].length;
                                if (nil2 > 3) {
                                    $('#valid3-' + i + '').hide();
                                    $('#ceklis3-' + i + '').show();
                                }
                                if (nil2 > 4) {
                                    $('#valid3-' + i + '').show();
                                    $('#ceklis3-' + i + '').hide();
                                }
                            }
                        })

                        $('#kecmin1-' + i + '').on('keyup', function() {
                            var i = this.classList[0]
                            var ul1 = $("#kecmin1-" + i + "").val();
                            var ul2 = $("#kecmax1-" + i + "").val();
                            if (ul1 > ul2) {
                                Swal.fire({
                                    icon: 'info',
                                    title: 'Nilai kecepatan Min tidak boleh melebihi nilai kecepatan Max..',
                                    timer: 3000
                                });
                            }
                            if (ul1 !== ".") {
                                $('#valid4-' + i + '').show();
                                $('#ceklis4-' + i + '').hide();
                            }
                            if (ul1.includes('.')) {
                                ul1 = $("#kecmin1-" + i + "").val();
                                var nil2 = ul1.toString().split(".")[1].length;
                                if (nil2 > 3) {
                                    $('#valid4-' + i + '').hide();
                                    $('#ceklis4-' + i + '').show();
                                }
                                if (nil2 > 4) {
                                    $('#valid4-' + i + '').show();
                                    $('#ceklis4-' + i + '').hide();
                                }
                            }
                        })
                        $('#permax2-' + i + '').on('keyup', function() {
                            var i = this.classList[0]
                            var ul1 = $("#permax2-" + i + "").val();

                            if (ul1 !== ".") {
                                $('#valid5-' + i + '').show();
                                $('#ceklis5-' + i + '').hide();
                            }
                            if (ul1.includes('.')) {
                                ul1 = $("#permax2-" + i + "").val();
                                var nil2 = ul1.toString().split(".")[1].length;
                                if (nil2 > 3) {
                                    $('#valid5-' + i + '').hide();
                                    $('#ceklis5-' + i + '').show();
                                }
                                if (nil2 > 4) {
                                    $('#valid5-' + i + '').show();
                                    $('#ceklis5-' + i + '').hide();
                                }
                            }
                        })

                        $('#permin2-' + i + '').on('keyup', function() {
                            var i = this.classList[0]
                            var ul1 = $("#permin2-" + i + "").val();
                            var ul2 = $("#permax2-" + i + "").val();
                            if (ul1 > ul2) {
                                Swal.fire({
                                    icon: 'info',
                                    title: 'Nilai percepatan Min tidak boleh melebihi nilai percepatan Max..',
                                    timer: 3000
                                });
                            }
                            if (ul1 !== ".") {
                                $('#valid6-' + i + '').show();
                                $('#ceklis6-' + i + '').hide();
                            }
                            if (ul1.includes('.')) {
                                ul1 = $("#permin2-" + i + "").val();
                                var nil2 = ul1.toString().split(".")[1].length;
                                if (nil2 > 3) {
                                    $('#valid6-' + i + '').hide();
                                    $('#ceklis6-' + i + '').show();
                                }
                                if (nil2 > 4) {
                                    $('#valid6-' + i + '').show();
                                    $('#ceklis6-' + i + '').hide();
                                }
                            }
                        })

                        $('#kecmax2-' + i + '').on('keyup', function() {
                            var i = this.classList[0]
                            var ul1 = $("#kecmax2-" + i + "").val();

                            if (ul1 !== ".") {
                                $('#valid7-' + i + '').show();
                                $('#ceklis7-' + i + '').hide();
                            }
                            if (ul1.includes('.')) {
                                ul1 = $("#kecmax2-" + i + "").val();
                                var nil2 = ul1.toString().split(".")[1].length;
                                if (nil2 > 3) {
                                    $('#valid7-' + i + '').hide();
                                    $('#ceklis7-' + i + '').show();
                                }
                                if (nil2 > 4) {
                                    $('#valid7-' + i + '').show();
                                    $('#ceklis7-' + i + '').hide();
                                }
                            }
                        })

                        $('#kecmin2-' + i + '').on('keyup', function() {
                            var i = this.classList[0]
                            var ul1 = $("#kecmin2-" + i + "").val();
                            var ul2 = $("#kecmax2-" + i + "").val();
                            if (ul1 > ul2) {
                                Swal.fire({
                                    icon: 'info',
                                    title: 'Nilai kecepatan Min tidak boleh melebihi nilai kecepatan Max..',
                                    timer: 3000
                                });
                            }
                            if (ul1 !== ".") {
                                $('#valid8-' + i + '').show();
                                $('#ceklis8-' + i + '').hide();
                            }
                            if (ul1.includes('.')) {
                                ul1 = $("#kecmin2-" + i + "").val();
                                var nil2 = ul1.toString().split(".")[1].length;
                                if (nil2 > 3) {
                                    $('#valid8-' + i + '').hide();
                                    $('#ceklis8-' + i + '').show();
                                }
                                if (nil2 > 4) {
                                    $('#valid8-' + i + '').show();
                                    $('#ceklis8-' + i + '').hide();
                                }
                            }
                        })
                    }
                    let vi = 1,
                        fi = 0,
                        wi = 0,
                        fe = 0,
                        we = 0;
                    $('#next').prop("disabled", false)
                    $('#prev').prop("disabled", true)
                    $('#peng_k').html(vi);

                    $('#next').click(function() {
                        fi = ++vi
                        wi = vi - 1;
                        $('#peng_k').html(vi);
                        $('#prev').prop("disabled", false)
                        if (fi == 3) {
                            $('#next').prop("disabled", true)
                        }
                        // console.log(vi)
                        $('.peng-getLing-' + fi).show();
                        $('.peng-getLing-' + wi).hide();

                    });
                    $('#prev').click(function() {
                        fe = vi--
                        we = vi
                        $('#peng_k').html(we);
                        if (fe == 2) {
                            $('#prev').prop("disabled", true)
                        }
                        $('.peng-getLing-' + fe).hide();
                        $('.peng-getLing-' + we).show();
                        $('#next').prop("disabled", false)
                    });
                } else if (posisi == 'Berdiri') {
                    $("#pengukuran").empty();
                    for (i = 1; i <= 3; i++) {
                        var boddi = '<div class="peng-getLing-' + i + '" style="display: none;">'
                        boddi += '<div class="mb-0"><h6>Pengukuran : Tangan</h6></div>'
                        boddi += '<div class="row px-3 mb-2">'
                        boddi += '<div class="col-12 text-center">'
                        boddi += '<label class="label label-1" for="modalInputusername">Percepatan (RMS)</label>'
                        boddi += '</div>'
                        boddi += '<div class="col-6">'
                        boddi += '<div class="form-group basic">'
                        boddi += '<div class="input-wrapper">'
                        boddi += '<label class="label label-1" for="modalInputusername">Nilai Max</label>'
                        boddi += '<input id="permax1-' + i + '" type="number" class="' + i +
                            ' form-control" name="permax1[]" autocomplete="off" step="0.0001" required>'
                        boddi += '<span class="text-danger" id="valid1-' + i +
                            '" style="font-size: 8px; display: none;">(Ex. 0.0005)</span>'
                        boddi += '<span class="text-success" id="ceklis1-' + i +
                            '" style="font-size: 8px; display: none;">Desimal sesuai</span>'
                        boddi += '</div>'
                        boddi += '</div>'
                        boddi += '</div>'
                        boddi += '<div class="col-6">'
                        boddi += '<div class="form-group basic">'
                        boddi += '<div class="input-wrapper">'
                        boddi += '<label class="label label-1" for="modalInputusername">Nilai Min</label>'
                        boddi += '<input id="permin1-' + i + '" type="number" class="' + i +
                            ' form-control" name="permin1[]" autocomplete="off" step="0.0001" required>'
                        boddi += '<span class="text-danger" id="valid2-' + i +
                            '" style="font-size: 8px; display: none;">(Ex. 0.0005)</span>'
                        boddi += '<span class="text-success" id="ceklis2-' + i +
                            '" style="font-size: 8px; display: none;">Desimal sesuai</span>'
                        boddi += '</div>'
                        boddi += '</div>'
                        boddi += '</div>'
                        boddi += '<div class="row px-3">'
                        boddi += '<div class="col-12 text-center">'
                        boddi += '<label class="label label-1" for="modalInputusername">Kecepatan (RMS)</label>'
                        boddi += '</div>'
                        boddi += '<div class="col-6">'
                        boddi += '<div class="form-group basic">'
                        boddi += '<div class="input-wrapper">'
                        boddi += '<label class="label label-1" for="modalInputusername">Nilai Max</label>'
                        boddi += '<input id="kecmax1-' + i + '" type="number" class="' + i +
                            ' form-control" name="kecmax1[]" autocomplete="off" step="0.0001" required>'
                        boddi += '<span class="text-danger" id="valid3-' + i +
                            '" style="font-size: 8px; display: none;">(Ex. 0.0005)</span>'
                        boddi += '<span class="text-success" id="ceklis3-' + i +
                            '" style="font-size: 8px; display: none;">Desimal sesuai</span>'
                        boddi += '</div>'
                        boddi += '</div>'
                        boddi += '</div>'
                        boddi += '<div class="col-6">'
                        boddi += '<div class="form-group basic">'
                        boddi += '<div class="input-wrapper">'
                        boddi += '<label class="label label-1" for="modalInputusername">Nilai Min</label>'
                        boddi += '<input id="kecmin1-' + i + '" type="number" class="' + i +
                            ' form-control" name="kecmin1[]" autocomplete="off" step="0.0001" required>'
                        boddi += '<span class="text-danger" id="valid4-' + i +
                            '" style="font-size: 8px; display: none;">(Ex. 0.0005)</span>'
                        boddi += '<span class="text-success" id="ceklis4-' + i +
                            '" style="font-size: 8px; display: none;">Desimal sesuai</span>'
                        boddi += '</div>'
                        boddi += '</div>'
                        boddi += '</div>'
                        boddi += '</div>'
                        boddi += '</div>'
                        boddi += '<div class="mb-0"><h6>Pengukuran : Pinggang</h6></div>'
                        boddi += '<div class="row px-3 mb-2">'
                        boddi += '<div class="col-12 text-center">'
                        boddi += '<label class="label label-1" for="modalInputusername">Percepatan (RMS)</label>'
                        boddi += '</div>'
                        boddi += '<div class="col-6">'
                        boddi += '<div class="form-group basic">'
                        boddi += '<div class="input-wrapper">'
                        boddi += '<label class="label label-1" for="modalInputusername">Nilai Max</label>'
                        boddi += '<input id="permax2-' + i + '" type="number" class="' + i +
                            ' form-control" name="permax2[]" autocomplete="off" step="0.0001" required>'
                        boddi += '<span class="text-danger" id="valid5-' + i +
                            '" style="font-size: 8px; display: none;">(Ex. 0.0005)</span>'
                        boddi += '<span class="text-success" id="ceklis5-' + i +
                            '" style="font-size: 8px; display: none;">Desimal sesuai</span>'
                        boddi += '</div>'
                        boddi += '</div>'
                        boddi += '</div>'
                        boddi += '<div class="col-6">'
                        boddi += '<div class="form-group basic">'
                        boddi += '<div class="input-wrapper">'
                        boddi += '<label class="label label-1" for="modalInputusername">Nilai Min</label>'
                        boddi += '<input id="permin2-' + i + '" type="number" class="' + i +
                            ' form-control" name="permin2[]" autocomplete="off" step="0.0001" required>'
                        boddi += '<span class="text-danger" id="valid6-' + i +
                            '" style="font-size: 8px; display: none;">(Ex. 0.0005)</span>'
                        boddi += '<span class="text-success" id="ceklis6-' + i +
                            '" style="font-size: 8px; display: none;">Desimal sesuai</span>'
                        boddi += '</div>'
                        boddi += '</div>'
                        boddi += '</div>'
                        boddi += '<div class="row px-3">'
                        boddi += '<div class="col-12 text-center">'
                        boddi += '<label class="label label-1" for="modalInputusername">Kecepatan (RMS)</label>'
                        boddi += '</div>'
                        boddi += '<div class="col-6">'
                        boddi += '<div class="form-group basic">'
                        boddi += '<div class="input-wrapper">'
                        boddi += '<label class="label label-1" for="modalInputusername">Nilai Max</label>'
                        boddi += '<input id="kecmax2-' + i + '" type="number" class="' + i +
                            ' form-control" name="kecmax2[]" autocomplete="off" step="0.0001" required>'
                        boddi += '<span class="text-danger" id="valid7-' + i +
                            '" style="font-size: 8px; display: none;">(Ex. 0.0005)</span>'
                        boddi += '<span class="text-success" id="ceklis7-' + i +
                            '" style="font-size: 8px; display: none;">Desimal sesuai</span>'
                        boddi += '</div>'
                        boddi += '</div>'
                        boddi += '</div>'
                        boddi += '<div class="col-6">'
                        boddi += '<div class="form-group basic">'
                        boddi += '<div class="input-wrapper">'
                        boddi += '<label class="label label-1" for="modalInputusername">Nilai Min</label>'
                        boddi += '<input id="kecmin2-' + i + '" type="number" class="' + i +
                            ' form-control" name="kecmin2[]" autocomplete="off" step="0.0001" required>'
                        boddi += '<span class="text-danger" id="valid8-' + i +
                            '" style="font-size: 8px; display: none;">(Ex. 0.0005)</span>'
                        boddi += '<span class="text-success" id="ceklis8-' + i +
                            '" style="font-size: 8px; display: none;">Desimal sesuai</span>'
                        boddi += '</div>'
                        boddi += '</div>'
                        boddi += '</div>'
                        boddi += '</div>'
                        boddi += '</div>'
                        boddi += '<div class="mb-0"><h6>Pengukuran : Betis</h6></div>'
                        boddi += '<div class="row px-3 mb-2">'
                        boddi += '<div class="col-12 text-center">'
                        boddi += '<label class="label label-1" for="modalInputusername">Percepatan (RMS)</label>'
                        boddi += '</div>'
                        boddi += '<div class="col-6">'
                        boddi += '<div class="form-group basic">'
                        boddi += '<div class="input-wrapper">'
                        boddi += '<label class="label label-1" for="modalInputusername">Nilai Max</label>'
                        boddi += '<input id="permax3-' + i + '" type="number" class="' + i +
                            ' form-control" name="permax3[]" autocomplete="off" step="0.0001" required>'
                        boddi += '<span class="text-danger" id="valid9-' + i +
                            '" style="font-size: 8px; display: none;">(Ex. 0.0005)</span>'
                        boddi += '<span class="text-success" id="ceklis9-' + i +
                            '" style="font-size: 8px; display: none;">Desimal sesuai</span>'
                        boddi += '</div>'
                        boddi += '</div>'
                        boddi += '</div>'
                        boddi += '<div class="col-6">'
                        boddi += '<div class="form-group basic">'
                        boddi += '<div class="input-wrapper">'
                        boddi += '<label class="label label-1" for="modalInputusername">Nilai Min</label>'
                        boddi += '<input id="permin3-' + i + '" type="number" class="' + i +
                            ' form-control" name="permin3[]" autocomplete="off" step="0.0001" required>'
                        boddi += '<span class="text-danger" id="valid10-' + i +
                            '" style="font-size: 8px; display: none;">(Ex. 0.0005)</span>'
                        boddi += '<span class="text-success" id="ceklis10-' + i +
                            '" style="font-size: 8px; display: none;">Desimal sesuai</span>'
                        boddi += '</div>'
                        boddi += '</div>'
                        boddi += '</div>'
                        boddi += '<div class="row px-3">'
                        boddi += '<div class="col-12 text-center">'
                        boddi += '<label class="label label-1" for="modalInputusername">Kecepatan (RMS)</label>'
                        boddi += '</div>'
                        boddi += '<div class="col-6">'
                        boddi += '<div class="form-group basic">'
                        boddi += '<div class="input-wrapper">'
                        boddi += '<label class="label label-1" for="modalInputusername">Nilai Max</label>'
                        boddi += '<input id="kecmax3-' + i + '" type="number" class="' + i +
                            ' form-control" name="kecmax3[]" autocomplete="off" step="0.0001" required>'
                        boddi += '<span class="text-danger" id="valid11-' + i +
                            '" style="font-size: 8px; display: none;">(Ex. 0.0005)</span>'
                        boddi += '<span class="text-success" id="ceklis11-' + i +
                            '" style="font-size: 8px; display: none;">Desimal sesuai</span>'
                        boddi += '</div>'
                        boddi += '</div>'
                        boddi += '</div>'
                        boddi += '<div class="col-6">'
                        boddi += '<div class="form-group basic">'
                        boddi += '<div class="input-wrapper">'
                        boddi += '<label class="label label-1" for="modalInputusername">Nilai Min</label>'
                        boddi += '<input id="kecmin3-' + i + '" type="number" class="' + i +
                            ' form-control" name="kecmin3[]" autocomplete="off" step="0.0001" required>'
                        boddi += '<span class="text-danger" id="valid12-' + i +
                            '" style="font-size: 8px; display: none;">(Ex. 0.0005)</span>'
                        boddi += '<span class="text-success" id="ceklis12-' + i +
                            '" style="font-size: 8px; display: none;">Desimal sesuai</span>'
                        boddi += '</div>'
                        boddi += '</div>'
                        boddi += '</div>'
                        boddi += '</div>'
                        boddi += '</div>'
                        $('#pengukuran').append(boddi);
                        $('.peng-getLing-1').show();

                        $("#btnAksi").empty();
                        var btn =
                            '<div class="mb-2 mt-2"><div class="row justify-content-center"><div class="col-6"><div class="form-group basic"><button type="button" class="btn btn-success w-100" id="prev">&laquo; Sebelumnya</button></div></div><div class="col-6"><div class="form-group basic"><button type="button" class="btn btn-success w-100" id="next">Selanjutnya &raquo;</button></div></div></div></div>'
                        $('#btnAksi').append(btn);

                        $('#permax1-' + i + '').on('keyup', function() {
                            var i = this.classList[0]
                            var ul1 = $("#permax1-" + i + "").val();

                            if (ul1 !== ".") {
                                $('#valid1-' + i + '').show();
                                $('#ceklis1-' + i + '').hide();
                            }
                            if (ul1.includes('.')) {
                                ul1 = $("#permax1-" + i + "").val();
                                var nil2 = ul1.toString().split(".")[1].length;
                                if (nil2 > 3) {
                                    $('#valid1-' + i + '').hide();
                                    $('#ceklis1-' + i + '').show();
                                }
                                if (nil2 > 4) {
                                    $('#valid1-' + i + '').show();
                                    $('#ceklis1-' + i + '').hide();
                                }
                            }
                        })

                        $('#permin1-' + i + '').on('keyup', function() {
                            var i = this.classList[0]
                            var ul1 = $("#permin1-" + i + "").val();
                            var ul2 = $("#permax1-" + i + "").val();
                            if (ul1 > ul2) {
                                Swal.fire({
                                    icon: 'info',
                                    title: 'Nilai percepatan Min tidak boleh melebihi nilai percepatan Max..',
                                    timer: 3000
                                });
                            }
                            if (ul1 !== ".") {
                                $('#valid2-' + i + '').show();
                                $('#ceklis2-' + i + '').hide();
                            }
                            if (ul1.includes('.')) {
                                ul1 = $("#permin1-" + i + "").val();
                                var nil2 = ul1.toString().split(".")[1].length;
                                if (nil2 > 3) {
                                    $('#valid2-' + i + '').hide();
                                    $('#ceklis2-' + i + '').show();
                                }
                                if (nil2 > 4) {
                                    $('#valid2-' + i + '').show();
                                    $('#ceklis2-' + i + '').hide();
                                }
                            }
                        })

                        $('#kecmax1-' + i + '').on('keyup', function() {
                            var i = this.classList[0]
                            var ul1 = $("#kecmax1-" + i + "").val();

                            if (ul1 !== ".") {
                                $('#valid3-' + i + '').show();
                                $('#ceklis3-' + i + '').hide();
                            }
                            if (ul1.includes('.')) {
                                ul1 = $("#kecmax1-" + i + "").val();
                                var nil2 = ul1.toString().split(".")[1].length;
                                if (nil2 > 3) {
                                    $('#valid3-' + i + '').hide();
                                    $('#ceklis3-' + i + '').show();
                                }
                                if (nil2 > 4) {
                                    $('#valid3-' + i + '').show();
                                    $('#ceklis3-' + i + '').hide();
                                }
                            }
                        })

                        $('#kecmin1-' + i + '').on('keyup', function() {
                            var i = this.classList[0]
                            var ul1 = $("#kecmin1-" + i + "").val();
                            var ul2 = $("#kecmax1-" + i + "").val();
                            if (ul1 > ul2) {
                                Swal.fire({
                                    icon: 'info',
                                    title: 'Nilai kecepatan Min tidak boleh melebihi nilai kecepatan Max..',
                                    timer: 3000
                                });
                            }
                            if (ul1 !== ".") {
                                $('#valid4-' + i + '').show();
                                $('#ceklis4-' + i + '').hide();
                            }
                            if (ul1.includes('.')) {
                                ul1 = $("#kecmin1-" + i + "").val();
                                var nil2 = ul1.toString().split(".")[1].length;
                                if (nil2 > 3) {
                                    $('#valid4-' + i + '').hide();
                                    $('#ceklis4-' + i + '').show();
                                }
                                if (nil2 > 4) {
                                    $('#valid4-' + i + '').show();
                                    $('#ceklis4-' + i + '').hide();
                                }
                            }
                        })
                        $('#permax2-' + i + '').on('keyup', function() {
                            var i = this.classList[0]
                            var ul1 = $("#permax2-" + i + "").val();

                            if (ul1 !== ".") {
                                $('#valid5-' + i + '').show();
                                $('#ceklis5-' + i + '').hide();
                            }
                            if (ul1.includes('.')) {
                                ul1 = $("#permax2-" + i + "").val();
                                var nil2 = ul1.toString().split(".")[1].length;
                                if (nil2 > 3) {
                                    $('#valid5-' + i + '').hide();
                                    $('#ceklis5-' + i + '').show();
                                }
                                if (nil2 > 4) {
                                    $('#valid5-' + i + '').show();
                                    $('#ceklis5-' + i + '').hide();
                                }
                            }
                        })

                        $('#permin2-' + i + '').on('keyup', function() {
                            var i = this.classList[0]
                            var ul1 = $("#permin2-" + i + "").val();
                            var ul2 = $("#permax2-" + i + "").val();
                            if (ul1 > ul2) {
                                Swal.fire({
                                    icon: 'info',
                                    title: 'Nilai percepatan Min tidak boleh melebihi nilai percepatan Max..',
                                    timer: 3000
                                });
                            }
                            if (ul1 !== ".") {
                                $('#valid6-' + i + '').show();
                                $('#ceklis6-' + i + '').hide();
                            }
                            if (ul1.includes('.')) {
                                ul1 = $("#permin2-" + i + "").val();
                                var nil2 = ul1.toString().split(".")[1].length;
                                if (nil2 > 3) {
                                    $('#valid6-' + i + '').hide();
                                    $('#ceklis6-' + i + '').show();
                                }
                                if (nil2 > 4) {
                                    $('#valid6-' + i + '').show();
                                    $('#ceklis6-' + i + '').hide();
                                }
                            }
                        })

                        $('#kecmax2-' + i + '').on('keyup', function() {
                            var i = this.classList[0]
                            var ul1 = $("#kecmax2-" + i + "").val();

                            if (ul1 !== ".") {
                                $('#valid7-' + i + '').show();
                                $('#ceklis7-' + i + '').hide();
                            }
                            if (ul1.includes('.')) {
                                ul1 = $("#kecmax2-" + i + "").val();
                                var nil2 = ul1.toString().split(".")[1].length;
                                if (nil2 > 3) {
                                    $('#valid7-' + i + '').hide();
                                    $('#ceklis7-' + i + '').show();
                                }
                                if (nil2 > 4) {
                                    $('#valid7-' + i + '').show();
                                    $('#ceklis7-' + i + '').hide();
                                }
                            }
                        })

                        $('#kecmin2-' + i + '').on('keyup', function() {
                            var i = this.classList[0]
                            var ul1 = $("#kecmin2-" + i + "").val();
                            var ul2 = $("#kecmax2-" + i + "").val();
                            if (ul1 > ul2) {
                                Swal.fire({
                                    icon: 'info',
                                    title: 'Nilai kecepatan Min tidak boleh melebihi nilai kecepatan Max..',
                                    timer: 3000
                                });
                            }
                            if (ul1 !== ".") {
                                $('#valid8-' + i + '').show();
                                $('#ceklis8-' + i + '').hide();
                            }
                            if (ul1.includes('.')) {
                                ul1 = $("#kecmin2-" + i + "").val();
                                var nil2 = ul1.toString().split(".")[1].length;
                                if (nil2 > 3) {
                                    $('#valid8-' + i + '').hide();
                                    $('#ceklis8-' + i + '').show();
                                }
                                if (nil2 > 4) {
                                    $('#valid8-' + i + '').show();
                                    $('#ceklis8-' + i + '').hide();
                                }
                            }
                        })
                        $('#permax3-' + i + '').on('keyup', function() {
                            var i = this.classList[0]
                            var ul1 = $("#permax3-" + i + "").val();

                            if (ul1 !== ".") {
                                $('#valid9-' + i + '').show();
                                $('#ceklis9-' + i + '').hide();
                            }
                            if (ul1.includes('.')) {
                                ul1 = $("#permax3-" + i + "").val();
                                var nil2 = ul1.toString().split(".")[1].length;
                                if (nil2 > 3) {
                                    $('#valid9-' + i + '').hide();
                                    $('#ceklis9-' + i + '').show();
                                }
                                if (nil2 > 4) {
                                    $('#valid9-' + i + '').show();
                                    $('#ceklis9-' + i + '').hide();
                                }
                            }
                        })

                        $('#permin3-' + i + '').on('keyup', function() {
                            var i = this.classList[0]
                            var ul1 = $("#permin3-" + i + "").val();
                            var ul2 = $("#permax3-" + i + "").val();
                            if (ul1 > ul2) {
                                Swal.fire({
                                    icon: 'info',
                                    title: 'Nilai percepatan Min tidak boleh melebihi nilai percepatan Max..',
                                    timer: 3000
                                });
                            }
                            if (ul1 !== ".") {
                                $('#valid10-' + i + '').show();
                                $('#ceklis10-' + i + '').hide();
                            }
                            if (ul1.includes('.')) {
                                ul1 = $("#permin3-" + i + "").val();
                                var nil2 = ul1.toString().split(".")[1].length;
                                if (nil2 > 3) {
                                    $('#valid10-' + i + '').hide();
                                    $('#ceklis10-' + i + '').show();
                                }
                                if (nil2 > 4) {
                                    $('#valid10-' + i + '').show();
                                    $('#ceklis10-' + i + '').hide();
                                }
                            }
                        })

                        $('#kecmax3-' + i + '').on('keyup', function() {
                            var i = this.classList[0]
                            var ul1 = $("#kecmax3-" + i + "").val();

                            if (ul1 !== ".") {
                                $('#valid11-' + i + '').show();
                                $('#ceklis11-' + i + '').hide();
                            }
                            if (ul1.includes('.')) {
                                ul1 = $("#kecmax3-" + i + "").val();
                                var nil2 = ul1.toString().split(".")[1].length;
                                if (nil2 > 3) {
                                    $('#valid11-' + i + '').hide();
                                    $('#ceklis11-' + i + '').show();
                                }
                                if (nil2 > 4) {
                                    $('#valid11-' + i + '').show();
                                    $('#ceklis11-' + i + '').hide();
                                }
                            }
                        })

                        $('#kecmin3-' + i + '').on('keyup', function() {
                            var i = this.classList[0]
                            var ul1 = $("#kecmin3-" + i + "").val();
                            var ul2 = $("#kecmax3-" + i + "").val();
                            if (ul1 > ul2) {
                                Swal.fire({
                                    icon: 'info',
                                    title: 'Nilai kecepatan Min tidak boleh melebihi nilai kecepatan Max..',
                                    timer: 3000
                                });
                            }
                            if (ul1 !== ".") {
                                $('#valid12-' + i + '').show();
                                $('#ceklis12-' + i + '').hide();
                            }
                            if (ul1.includes('.')) {
                                ul1 = $("#kecmin3-" + i + "").val();
                                var nil2 = ul1.toString().split(".")[1].length;
                                if (nil2 > 3) {
                                    $('#valid12-' + i + '').hide();
                                    $('#ceklis12-' + i + '').show();
                                }
                                if (nil2 > 4) {
                                    $('#valid12-' + i + '').show();
                                    $('#ceklis12-' + i + '').hide();
                                }
                            }
                        })
                    }
                    let vi = 1,
                        fi = 0,
                        wi = 0,
                        fe = 0,
                        we = 0;
                    $('#next').prop("disabled", false)
                    $('#prev').prop("disabled", true)
                    $('#peng_k').html(vi);

                    $('#next').click(function() {
                        fi = ++vi
                        wi = vi - 1;
                        $('#peng_k').html(vi);
                        $('#prev').prop("disabled", false)
                        if (fi == 3) {
                            $('#next').prop("disabled", true)
                        }
                        // console.log(vi)
                        $('.peng-getLing-' + fi).show();
                        $('.peng-getLing-' + wi).hide();

                    });
                    $('#prev').click(function() {
                        fe = vi--
                        we = vi
                        $('#peng_k').html(we);
                        if (fe == 2) {
                            $('#prev').prop("disabled", true)
                        }
                        $('.peng-getLing-' + fe).hide();
                        $('.peng-getLing-' + we).show();
                        $('#next').prop("disabled", false)
                    });
                }
            })
        }
    }

    var selectoption = '<div class="form-group basic"><div class="input-wrapper"><label class="label">Sub Kategori</label><select name="id_ket" id="id_ket" class="form-control" required><option value="">Pilih Sub Ketegori</option><option value="17">Getaran (Lengan & Tangan)</option><option value="20">Getaran (Seluruh Tubuh)</option></select></div></div>';

    var getaranPersonal = '<div class="mb-2"><div class="row"><div class="col-sm-12"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1" for="modalInputusername">Penamaan Titik</label><input type="text" name="keterangan_4" id="keterangan-4" class="form-control" autocomplete="off"></div></div></div></div></div><div class="mb-2"><div class="row"><div class="col-sm-12"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1">Penamaan Tambahan</label><textarea class="form-control rounded" name="keterangan_2" id="keterangan_2" required></textarea></div></div></div></div></div><div class="mb-2"><div class="row"><div class="col-6"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1">Metode Pengukuran</label><select id="metode_peng" name="metode_peng" class="form-control" autocomplete="off" style="font-size:10px" required><option value="">--Pilih Metode--</option><option value="Langsung">Langsung</option><option value="Personal">Personal</option></select></div></div></div><div class="col-6" id="seluruh" style="display:none"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1">Posisi Pengukuran</label><select name="posisi_pengSl" id="posisi_pengSl" class="form-control" autocomplete="off" style="font-size:10px" required><option value="">--Pilih Posisi--</option><option value="Duduk">Duduk</option><option value="Berdiri">Berdiri</option><option value="Berbaring">Berbaring</option></select></div></div></div><div class="col-6" id="sebagian" style="display:none"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1">Posisi Pengukuran</label><select name="posisi_pengSb" id="posisi_pengSb" class="form-control" autocomplete="off" style="font-size:10px"><option value="">--Pilih Posisi--</option><option value="Pegangan Alat">Pegangan Alat</option><option value="Telapak Tangan">Telapak Tangan</option></select></div></div></div></div></div><div class="mb-2"><div class="row"><div class="col-sm-12"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1">Sumber Getaran</label><textarea class="form-control rounded" name="sumber" id="sumber" required></textarea></div></div></div></div></div><div class="row mb-2"><div class="col-6"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1" for="modalInputusername">Jam Pengambilan</label><div class="input-group"><div class="row"><div class="col-8"><input type="text" class="form-control" name="waktu" id="time" readonly="readonly"></div><div class="col-2 px-0"><span class="d-flex align-items-center btn btn-danger"><a class="fa-solid fa-clock" onclick="mulai()"></a></span></div></div></div></div></div></div></div><div class="row"><div class="col-6"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1" for="modalInputusername">Durasi Paparan</label><div class="input-group"><input type="number" class="form-control" name="paparan" id="paparan" autocomplete="off" step="any" required><div class="input-group-append"><span class="input-group-text" style="font-size:10px">Menit</span></div></div></div></div></div><div class="col-6"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1" for="modalInputusername">Waktu Kerja</label><div class="input-group"><input type="number" class="form-control" name="kerja" id="kerja" autocomplete="off" step="any" required><div class="input-group-append"><span class="input-group-text" style="font-size:10px">Jam</span></div></div></div></div></div></div><div class="mb-2"><div class="row"><p class="text-danger mb-0 mt-0" style="font-size:10px">*Penilaian kondisi berdasarkan observesi subjectif</p><div class="col-6"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1">Kondisi</label><select name="kondisi" id="kondisi" class="form-control" autocomplete="off" style="font-size:10px" required><option value="">--Pilih Kondisi--</option><option value="Sangat Kuat">Sangat Kuat</option><option value="Kuat">Kuat</option><option value="Lemah">Lemah</option><option value="Sangat Lemah">Sangat Lemah</option><option value="Tidak Terasa">Tidak Terasa</option></select></div></div></div><div class="col-6"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1">Intensitas</label><select name="intensitas" id="intensitas" class="form-control" autocomplete="off" style="font-size:10px" required><option value="">--Pilih Intensitas--</option><option value="Konstan">Konstan</option><option value="Kejut">Kejut</option></select></div></div></div></div></div><div id="peng_sung" style="display:none"><div class="row mb-2" id="sat_pengL"></div><div class="border border-dash-gray rounded"><div class="row justify-content-center mt-2"><div class="col-12 text-center"><label class="mb-0">PENGUKURAN</label></div><div class="col-12 d-flex justify-content-between px-4" style="font-size:12px"><label>Total Titik :<span>3</span></label><label>Titik Ke :<span id="peng_k"></span></label></div></div><div id="pengukuran"></div></div><div id="btnAksi"></div></div><div id="peng_per" style="display:none"><div class="row mb-2" id="sat_pengP"></div><div class="border border-dash-gray rounded"><div class="row mt-2"><div class="col-12 text-center"><label class="mb-0">PENGUKURAN</label></div><div class="col-12 d-flex justify-content-between px-4" style="font-size:12px"><label>Total Titik :<span>3</span></label><label>Titik Ke :<span id="peng_kP"></span></label></div></div><div id="pengukuranPer"></div></div><div id="btnAksii"></div></div><label class="mt-1">Dokumentasi</label><div class="row mb-2"><div class="col-6"><div class="form-group basic"><label class="label label-1 mb-1">Lokasi Sampling<sup>*</sup></label><label for="file1"><span class="btn btn-primary" id="lokasi"><hi class="fa fa-camera"></hi>Ambil Gambar</span><input type="file" id="file1" accept="image/*" capture="environment" style="display:none" onchange="preview_image(1)"></label><textarea id="foto_lok" name="foto_lok" class="d-none"></textarea></div></div><div class="col-6"><div class="form-group basic"><label class="label label-1 mb-1">Foto Lain - Lain</label><label for="file3"><span class="btn btn-primary" id="lain"><i class="fa fa-camera"></i>Ambil Gambar</span><input type="file" id="file3" accept="image/*" capture @change="setImage" style="display:none" onchange="preview_image(3)"></label><textarea id="foto_lain" name="foto_lain" class="d-none"></textarea></div></div></div><div class="mb-2"><label style="border:1px solid #ced4da;padding:5px;border-radius:10px"><input type="checkbox" name="permis" value="1"><span>Data dan Informasi Pengambilan Sampel Ini adalah yang Sebenar-benarnya</span></label></div>';
</script>