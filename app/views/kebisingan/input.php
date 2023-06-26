<div id="appCapsule">
    <div class="section mb-5 p-2">
        <form id="form-add" method="POST" action="<?= base_url; ?>/kebisingan/saveData">
            <div class="card">
                <div class="card-body pb-1">
                    <div class="row">
                        <div class="col-12 text-center">
                            <label for="">FDL Kebisingan</label>
                        </div>
                    </div>
                    <div class="form-group basic">
                        <div class="input-wrapper">
                            <label class="label">No Sample</label>
                            <div class="input-groups input-group-sm mb-2">
                                <div class="row">
                                    <div class="col-8">
                                        <input type="text" class="form-control" id="no_sample" name="no_sample" required autocomplete="off" style="font-size:12px" >
                                        <!-- <input type="hidden" id="id_kat" name="id_kat"> -->
                                    </div>
                                    <div class="col-4">
                                        <span class="input-group-prepends" style="width:30%">
                                            <a class="btn btn-info" href="javascript:;" onclick="getdata()"><i class="fa-solid fa-rotate"></i></a>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group basic">
                        <div class="input-wrapper">
                            <label class="label">Sub Kategori</label>
                            <select name="id_kat" id="id_kat" class="form-control" required>
                                <option value="">Pilih Sub Ketegori</option>
                                <option value="23">Kebisingan</option>
                                <option value="24">Kebisingan (24 Jam)</option>
                                <option value="25">Kebisingan (Indoor)</option>
                                <option value="26">Kebisingan (Outdoor)</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group basic">
                        <div class="input-wrapper">
                            <label class="label">Penamaan Titik</label>
                            <input type="text" name="keterangan_4" id="keterangan-4" class="form-control" autocomplete="off" required>
                            <i class="clear-input">
                                <ion-icon name="close-circle" role="img" class="md hydrated" aria-label="close circle"></ion-icon>
                            </i>
                        </div>
                    </div>
                    <div class="mb-2">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group basic">
                                    <div class="input-wrapper">
                                        <label class="label label-1">Penamaan Tambahan</label>
                                        <textarea class="form-control rounded" name="information" id="p_tambahan" required></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-2">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group basic">
                                    <div class="input-wrapper">
                                        <label class="label label-1">Sumber Kebisingan</label>
                                        <textarea class="form-control rounded" name="sumber_keb" id="sumber_keb" required></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group basic">
                                <div class="input-wrapper">
                                    <label class="label label-1">Jenis Frekuensi</label>
                                    <select name="jen_frek" id="jen_frek" class="form-control" style="font-size:10px" required>
                                        <option value="">--Pilih Jenis--</option>
                                        <option value="Bising Kontiniu">Bising Kontiniu</option>
                                        <option value="Bising Intermitten">Bising Intermitten</option>
                                        <option value="Bising Impulsif">Bising Impulsif</option>
                                        <option value="Bising Impulsif Berulang">Bising Impulsif Berulang</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group basic">
                        <div class="row">
                            <div class="col-sm-12">
                                <label class="label label-1">Titik Koordinat Sampling</label>
                                <div class="input-groups input-group-sm mb-2">
                                    <input type="hidden" name="lat" id="lat">
                                    <input type="hidden" name="longi" id="longi">
                                    <div class="row">
                                        <div class="col-8">
                                            <input type="text" class="form-control" name="posisi" id="posisi" required autocomplete="off" style="font-size:12px">
                                        </div>
                                        <div class="col-4">
                                            <span class="input-group-prepends" style="width:30%">
                                                <a class="btn btn-info" onclick="getlocation()"><i class="fa-solid fa-location-dot"></i> Get Location</a>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group basic">
                                <div class="input-wrapper">
                                    <label class="label">Jam Pengambilan</label>
                                    <div class="row">
                                        <div class="col-8">
                                            <input type="text" class="form-control" name="waktu" id="jam" readonly="readonly" required>
                                        </div>
                                        <div class="col-2 px-0">
                                            <span class="d-flex align-items-center btn btn-danger">
                                                <a class="fa-solid fa-clock" onclick="mulai()"></a>
                                                <!-- <i class="fa-solid fa-clock"></i> -->
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group basic">
                                <div class="input-wrapper">
                                    <label class="label label-1">Jenis Pengujian</label>
                                    <select name="jenis_kat" id="jenis_kat" class="form-control" style="font-size:10px" required>
                                        <option value="">--Pilih Jenis--</option>
                                        <option value="Ambient">Ambient</option>
                                        <option value="Lingkungan Kerja">Lingkungan Kerja</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group basic">
                                <div class="input-wrapper">
                                    <label class="label label-1">Kategori Pengujian</label>
                                    <select name="jenis_durasi" id="jenis_durasi" class="form-control" style="font-size:10px" required>
                                        <option value="">--Pilih Kategori--</option>
                                        <option value="Sesaat">Sesaat</option>
                                        <option value="24 Jam">24 Jam</option>
                                        <option value="8 Jam">8 Jam</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group basic">
                                <div class="input-wrapper">
                                    <label class="label label-1">Shift Pengambilan</label>
                                    <select name="durasi_sampl" id="durasi_sampl" class="form-control"></select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group basic">
                                <div class="input-wrapper">
                                    <label class="label label-1" for="modalInputusername">Suhu Udara</label>
                                    <div class="input-group">
                                        <input id="suhu" type="number" class="form-control" name="suhu_udara" autocomplete="off" step="any" required>
                                        <div class="input-group-append">
                                            <span class="input-group-text" style="font-size:10px">&#8451;</span>
                                        </div>
                                    </div>
                                    <span class="text-danger text-bold" id="valsuhu" style="font-size:10px;display:none">(Ex. -10,5 atau 5,5)</span>
                                    <span class="text-success" id="ceksuhu" style="font-size:10px;display:none">Desimal sesuai</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group basic">
                                <div class="input-wrapper">
                                    <label class="label label-1" for="modalInputusername">Kelembapan Udara</label>
                                    <div class="input-group">
                                        <input id="kelem" type="number" class="form-control" name="kelembapan_udara" autocomplete="off" step="any" required>
                                        <div class="input-group-append">
                                            <span class="input-group-text" style="font-size:10px">%</span>
                                        </div>
                                    </div>
                                    <span class="text-danger text-bold" id="valkelem" style="font-size:10px;display:none">(Ex. -10,5 atau 5,5)</span>
                                    <span class="text-success" id="cekkelem" style="font-size:10px;display:none">Desimal sesuai</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="kebisingan"></div>
                    <div id="kebisingan-value"></div>
                    <canvas class="d-none" id="canvas"></canvas>
                    <label class="mt-1">Dokumentasi</label>
                    <div class="row mb-2">
                        <div class="col-6">
                            <div class="form-group basic">
                                <label class="label label-1 mb-1">Lokasi Sampling <sup>*</sup>
                                </label>
                                <label for="file1">
                                    <span class="btn btn-primary" id="lokasi">
                                        <i class="fa-solid fa-camera"> </i> Ambil Gambar </span>
                                    <input type="file" id="file1" accept="image/*" capture="environment" style="display:none" onchange="preview_image(1)">
                                </label>
                                <textarea id="foto_lok" name="foto_lok" class="d-none"></textarea>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group basic">
                                <label class="label label-1 mb-1">Foto Lain - Lain</label>
                                <label for="file3">
                                    <span class="btn btn-primary" id="lain">
                                        <i class="fa-solid fa-camera"> </i> Ambil Gambar </span>
                                    <input type="file" id="file3" accept="image/*" capture="environment" style="display:none" onchange="preview_image(3)">
                                </label>
                                <textarea id="foto_lain" name="foto_lain" class="d-none"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="mb-2">
                        <label style="margin-top:20px;border:1px solid #ced4da;padding:5px;border-radius:10px;font-size:14px">
                            <input type="checkbox" name="permis" value="1">
                            <span style="margin-left:12px">Data dan Informasi Pengambilan Sampel Ini adalah yang Sebenar-benarnya</span>
                        </label>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6">
                            <div class="form-group basic">
                                <a href="javascript:;" class="btn btn-primary" style="width:100%"> Cancel </a>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group basic">
                                <button class="btn btn-success" type="submit" style="width:100%" id="btn-submit"> Save</button>
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

<script>
    let uri = '<?= base_url; ?>/sound/';
    var success = new Audio(uri + 'success.wav');
    var error = new Audio(uri + 'error.mp3');

    $('#form-add').on('submit', function(e){
        e.preventDefault()
        let data_form = $(this).serialize();
        if ($("input[name=permis]").is(':checked')) {
            if($('#lain').hasClass('sukses') && $('#lokasi').hasClass('sukses')){
                $('#btn-submit').prop('disabled', true);
                $.ajax({
                    statusCode: {
                        500: function() {
                            Swal.fire({
                                icon : 'error',
                                title : 'Server Error',
                                timer : 3000
                            })
                            $('#btn-submit').prop('disabled', false);
                        }
                    },
                    url: '/public/kebisingan/saveData',
                    method: 'POST',
                    data: data_form,
                    success: function(resp) {
                        resp = JSON.parse(resp)
                        if(resp == 'success'){
                            Swal.fire({
                                icon : 'success',
                                title : 'Success',
                                text : 'Data hasbeen Save',
                                timer : 3000
                            })
                            document.getElementById("form-add").reset();
                            $('#btn-submit').prop('disabled', false);
                            $('#kebisingan').empty();
                            $('#kebisingan-value').empty();
                            document.getElementById("lokasi").style.setProperty("background-color", "#00B4FF", "important");
                            document.getElementById("lokasi").style.setProperty("border-color", "#00B4FF", "important");
                            document.getElementById("lain").style.setProperty("background-color", "#00B4FF", "important");
                            document.getElementById("lain").style.setProperty("border-color", "#00B4FF", "important");
                        } else {
                            Swal.fire({
                                icon : 'error',
                                title : 'Opps..!',
                                text : 'Please Check the Data.',
                                timer : 3000
                            })
                            $('#btn-submit').prop('disabled', false);
                        }
                    }, error : function(err){
                        Swal.fire({
                            icon : 'error',
                            title : err.responseJSON,
                            timer : 3000
                        })
                        $('#btn-submit').prop('disabled', false);
                    }
                })
            }else {
                Swal.fire({
                    icon: 'error',
                    title: 'Oooooops.....',
                    text: 'Foto Lokasi Dan Foto Lain - Lain wajib di lakukan.!',
                    timer: 3000
                })
            }
        }else {
            Swal.fire({
                icon: 'info',
                title: 'Please checked Confirm permission',
                timer: 3000
            })
        }
    })

    function getdata(){
        let net = $('#status-text').text();
        if(net == "Online"){
            var no_sample = $("#no_sample").val();
            $.ajax({
               url: '/public/kebisingan/getSampel',
               method: 'POST',
               data: {
                  no_sample: no_sample
               },
               success: function(resp) {
                e = JSON.parse(resp);
                    if (e.id_ket == '23' || e.id_ket == '24' || e.id_ket == '25' || e.id_ket === '26') {
                        //  $('#btnBawah').hide()
                        //  $('#udara').html(kebisingan).fadeIn('slow');
                        $('#keterangan-4').val(e.keterangan);
                        $('#id_kat').val(e.id_ket);
                        $('#jam').clockTimePicker();
                        $('#jamm').clockTimePicker();
                        input_kebisingan(120);
                        jendur();
                        kelas(120);
                    } else {
                        //  error.play();
                        // $('#form-add').trigger('reset');
                        Swal.fire({
                            title: 'Tidak ada kategori FDL kebisingan di No Sample tersebut',
                            icon: 'warning',
                            confirmButtonColor: '#3085d6',
                        })
                    }
                },
                error: function(e) {
                    e = JSON.parse(e)  
                    Swal.fire({
                        icon: 'error',
                        title: 'Ooooops.....',
                        text: e.message
                    })
                }
            })
        } else {
            Swal.fire({
                icon: 'info',
                title : 'Anda Sedang Offline',
                timer : 3000
            })
            $('#jam').clockTimePicker();
            $('#jamm').clockTimePicker();
            input_kebisingan(120);
            jendur();
            kelas(120);
        }
    }

    function kelas(nilai) {
        $('#kebisingan-value').empty();
        var html = '<div class="mb-2 row" id="value-kebisingan" style="display:none;">'
        //var html = '<label class="form-label" for="modalInputusername">Hasil Pengukuran Kebisingan</label>'  
        for (i = 1; i <= nilai; i++) {
            html += '<div class="col-3 mb-2">'
            html += '<input type="number" class="form-control nilai_kebisingan" id="nilai-' + i +
                '" nameGroup="nilai_kebisingan" name="kebisingan[]" autocomplete="off" placeholder ="Input - ' + i +
                '" min="45" max="95" step="any">'
            html += '</div>'

        }
        html += '</div>'
        $('#kebisingan-value').html(html);
        // validasi(nilai)
    }
    function mulai() {
        var date = new Date();
        jam = date.getHours();
        jam = ("0" + jam).slice(-2);
        menit = date.getMinutes();
        menit = ("0" + menit).slice(-2);
        $('#jam').val(jam + ":" + menit);
    }

    function getlocation() {
        navigator.geolocation ? (geoloc = navigator.geolocation, watchID = geoloc.getCurrentPosition(showPosition)) : Swal
            .fire({
                icon: "error",
                title: "Geolocation is not supported by this browser."
            })
    }

    function showPosition(position) {

        var t = position.coords.latitude;
        var e = position.coords.longitude;
        $('#lat').val(t);
        $('#longi').val(e);
        getdms(t, e)
        var lat = getdms(t, !0);
        var long = getdms(e, !1);
        $('#posisi').val(lat + ' ' + long)
        navigator.geolocation.clearWatch(watchID);
        watchID = false;
    }

    function getdms(t, e) {
        var n = 0, a = 0, m = 0, l = "X";
        return l = e && 0 > t ? "S" : !e && 0 > t ? "W" : e ? "N" : "E", d = Math.abs(t), n = Math.floor(d), m = 3600 * (
            d - n), 
            a = Math.floor(m / 60), 
            m = Math.round(1e4 * (m - 60 * a)) / 1e4, l + "" + n + "°" + a + "'" + m
    }

    function input_kebisingan(span) {
        $('#kebisingan').empty();

        for (i = 1; i <= span; i++) {
            var html = '<div class="form-group basic" id="input-value-kebisingan-' + i + '" style="display:none;">'
            html += '<div class="input-wrapper">'
            html += '<label class="label-1" for="modalInputusername">Data - ' + i + '</label>'
            html += '<input type="number" class="form-control kebisingan ' + i + '" id="kebisingan-' + i +
                '" placeholder ="Input - ' + i + '" min="45" max="95" step="any" required>'
            html += '</div>'
            html += '</div>'
            $('#kebisingan').append(html);
            $('#input-value-kebisingan-1').show();
            var keyTimer
            $('#kebisingan-' + i + '').on('keyup', function() {

                if (keyTimer) {
                clearTimeout(keyTimer);
                }

                var a = parseInt(this.classList[2])
                var id = a + 1;

                if (a == span) {
                var getId = this.id;
                var nilai = this.value;
                keyTimer = setTimeout(function() {
                    if (nilai < 40) {
                        $('#' + getId + '').focus()
                        error.play();
                        Swal.fire({
                            icon: 'info',
                            title: 'Nilai limit minimum adalah 40',
                            timer: 2000
                        });
                    } else if (nilai > 120.9) {
                        $('#' + getId + '').focus()
                        error.play();
                        Swal.fire({
                            icon: 'info',
                            title: 'Nilai limit maximum adalah 120',
                            timer: 2000
                        });
                    } else if (nilai.includes('.')) {
                        nilll = $('#kebisingan-' + a + '').val();
                        var nil2 = nilll.toString().split(".")[1].length;
                        if (nil2 !== 1) {
                            $('#' + getId + '').focus()
                            error.play();
                            Swal.fire({
                            icon: 'info',
                            title: 'Jumlah Desimal Wajib 1 Angka dibelakang Koma',
                            timer: 2000
                            });
                        } else {
                            $('#value-kebisingan').show()
                            $('#input-value-kebisingan-' + a + '').hide();
                            $('#nilai-' + a + '').val(nilai);
                            success.play();
                        }
                    } else {
                        $('#' + getId + '').focus()
                        error.play();
                        Swal.fire({
                            icon: 'info',
                            title: 'Jumlah Desimal Wajib 1 Angka dibelakang Koma',
                            timer: 2000
                        });
                    }
                }, 5000)

                } else {
                var getId = this.id;
                keyTimer = setTimeout(function() {
                    var nilai = $('#kebisingan-' + a + '').val();
                    if (nilai < 40) {
                        $('#' + getId + '').focus()
                        error.play();
                        Swal.fire({
                            icon: 'info',
                            title: 'Nilai limit minimum adalah 40',
                            timer: 2000
                        });
                    } else if (nilai > 120.9) {
                        $('#' + getId + '').focus()
                        error.play();
                        Swal.fire({
                            icon: 'info',
                            title: 'Nilai limit maximum adalah 120',
                            timer: 2000
                        });
                    } else if (nilai.includes('.')) {
                        nilll = $('#kebisingan-' + a + '').val();
                        var nil2 = nilll.toString().split(".")[1].length;
                        if (nil2 !== 1) {
                            $('#' + getId + '').focus()
                            error.play();
                            Swal.fire({
                            icon: 'info',
                            title: 'Jumlah Desimal Wajib 1 Angka dibelakang Koma',
                            timer: 2000
                            });
                        } else {
                            $('#input-value-kebisingan-' + a + '').hide();
                            $('#input-value-kebisingan-' + id + '').show();
                            $('#kebisingan-' + id + '').focus()
                            $('#nilai-' + a + '').val(nilai)
                            success.play()
                        }
                    } else {
                        $('#' + getId + '').focus()
                        error.play();
                        Swal.fire({
                            icon: 'info',
                            title: 'Jumlah Desimal Wajib 1 Angka dibelakang Koma',
                            timer: 2000
                        });
                    }
                }, 5000)
                }
            })
        }
        $('#kelem').on('keyup', function() {
            var ul1 = $("#kelem").val();
            if (ul1 !== ".") {
                $('#valkelem').show();
                $('#cekkelem').hide();
            }
            if (ul1.includes('.')) {
                ul1 = $("#kelem").val();
                var nil2 = ul1.toString().split(".")[1].length;
                if (nil2 == 1) {
                $('#valkelem').hide();
                $('#cekkelem').show();
                }
                if (nil2 > 1) {
                $('#valkelem').show();
                $('#cekkelem').hide();
                }
            }
        })
        $('#suhu').on('keyup', function() {
            var ul1 = $("#suhu").val();
            if (ul1 !== ".") {
                $('#valsuhu').show();
                $('#ceksuhu').hide();
            }
            if (ul1.includes('.')) {
                ul1 = $("#suhu").val();
                var nil2 = ul1.toString().split(".")[1].length;
                if (nil2 == 1) {
                $('#valsuhu').hide();
                $('#ceksuhu').show();
                }
                if (nil2 > 1) {
                $('#valsuhu').show();
                $('#ceksuhu').hide();
                }
            }
        })
    }

    function jendur() {
      $('#jenis_durasi').on('change', function() {
         var getNilai = document.getElementById('jenis_durasi').value
         if (getNilai == '24 Jam') {
            var jam = 24
         } else if (getNilai == '8 Jam') {
            var jam = 8
         }

         $('#durasi_sampl').empty();
         var html = '">'
         for (i = 1; i <= jam; i++) {
            html += '<option value="L' + i + '">L' + i + '</option>'
         }
         $('#durasi_sampl').html(html);
      })
   }


</script>