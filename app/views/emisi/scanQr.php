 <style>
    #preview{
        position: fixed;
        top: 50%;
        left: 50%;
        min-width: 100%;
        min-height: 100%;
        width: auto;
        height: auto;
        z-index: 1;
        transform: translateX(-50%) translateY(-50%);
        transition: 1s opacity;
    }

    .btn-switch{
        padding: 5px 10px;
        border-radius: 10px;
        border: 1px solid #60606b;
        background: transparent;
        position: fixed;
        left: 40%;
        bottom: 3%;
    }
    .btn-add{
        /*padding: 10px;*/
        /*border-radius: 50px;*/
        /*border: 1px solid #2EB82E;*/
        font-size: 60px;
        color: #2EB82E !important;
        position: fixed;
        right: 10%;
        bottom: 13%;
    }
    .btn-close-scann{
        padding: 5px 10px; 
        border-radius: 10px; 
        border: 1px solid; 
        background: transparent; 
        position: fixed; 
        right: 5%;
    }
 </style>
 <!-- * App Sidebar -->
 <div id="appCapsule">
     <!-- <div class="section-title">Data Qr <span id="qr_code"></span></div> -->
    <div class="section mt-2">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-4 col-md-4">
                        <form action="<?= base_url; ?>/emisi/detailEmisi" method="POST">
                            <input type="hidden" name="qr_code" id="qr_code">
                            <button type="submit" style="color: green; font-size: 20px;background-color: transparent;border-color: transparent;">Hasil Record (<span id="sum"></span>)</button>
                        </form>
                    </div>
                    <form action="<?= base_url; ?>/emisi/addOrderemisi" method="POST">
                        <input type="hidden" name="qr" id="qr">
                        <button class="btn-add" type="submit" style="color: #ffffff !important;background-color: transparent;border-color: transparent;"><i class="fa-solid fa-circle-plus fa-xs"></i></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade text-start" id="ccc" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div>
                    <video id="preview" ></video>
                    <div class="btn-group btn-group-toggle mb-5" data-toggle="buttons" style="position: absolute; z-index: 2;">
                        <button class="btn-close-scann" id="close-scann">X</button>
                        <button class="btn-switch" value="1" id="switch-togle"> <img src="<?= base_url; ?>/assets/img/switc.png" style="width:50px"> </button>
                    </div>
                </div>                        
            </div>
        </div>
    </div>
 </div>
<div class="btnBottom">
    <div class="btnTengah" onclick="location.href='emisi/add_data'"></a></div>
    <div class="btnMenu">
        <ul>
            <li style="--i:0.1s;"><a href="<?= base_url;?>/home"><i class="fa-solid fa-gauge"></i></a></li>
            <li style="--i:0.2s;"><a href="<?= base_url;?>/emisi"><i class="fa-solid fa-house"></i></a></li>
            <li></li>
            <li style="--i:0.2s;"><a href="<?= base_url;?>/emisi/viewData"><i class="fa-solid fa-file-lines"></i></a></li>
            <li style="--i:0.1s;"><a href="<?= base_url;?>/profile"><i class="fa-solid fa-user"></i></a></li>
        </ul>
    </div>
</div>

<script>
    $(document).ready(function(){
        // var scanner=new Instascan.Scanner({video:document.getElementById("preview"),scanPeriod:5,mirror:!1});scanner.addListener("scan",(function(e){var t=e.substr(e.length-11);$("#ccc").modal("hide"),scanner.stop();var a=global_var("dpath"),o=global_var("checkQr");let r=getCookie("token");$.ajax({url:a+o,type:"post",data:{token:r,qr:t},success:function(e){$("#sum").html(e.record),localStorage.setItem("id_qr",e.id),Swal.fire({icon:"success",title:e.message,timer:2e3}),0!=e.record?(localStorage.setItem("record",e.record),localStorage.setItem("id_qr",e.id_qr),localStorage.setItem("kode_qr",t),localStorage.setItem("bbm",e.bbm),localStorage.setItem("kategori_3",e.kategori_3),localStorage.setItem("no_sample",e.no_sample),localStorage.setItem("client",e.client),localStorage.setItem("plat",e.plat),localStorage.setItem("no_mesin",e.no_mesin),localStorage.setItem("merk",e.merk),localStorage.setItem("transmisi",e.transmisi),localStorage.setItem("tahun",e.tahun),localStorage.setItem("cc",e.cc),localStorage.setItem("km",e.km),localStorage.setItem("bobot",e.bobot),localStorage.setItem("kategori",e.kategori)):(localStorage.setItem("kode_qr",t),localStorage.setItem("record",e.record))},error:function(e){Swal.fire({icon:"info",title:e.responseJSON.message,timer:2e3})}})})),Instascan.Camera.getCameras().then((function(e){e.length>0?(scanner.start(e[1]),$("#switch-togle").on("click",(function(t){switch(console.log(this.value),this.value){case"1":this.value="2",""!=e[0]?scanner.start(e[0]):alert("No Front camera found!");break;case"2":this.value="1",""!=e[0]?scanner.start(e[1]):alert("No Front camera found!")}})),$("#close-scann").on("click",(function(){$("#ccc").modal("hide"),scanner.stop()}))):(console.error("No cameras found."),alert("No cameras found."))})).catch((function(e){console.error(e),alert(e)})),$(document).ready((function(){$("#ccc").modal("show")}));
            var scanner = new Instascan.Scanner({
                video: document.getElementById("preview"),
                scanPeriod: 5,
                mirror: !1
            });
            scanner.addListener("scan", function(e) {
                    var t = e.substr(e.length - 11);
                    $("#ccc").modal("hide"), scanner.stop();
                    $.ajax({
                        url: '/public/emisi/scann',
                        type: "post",
                        data: {
                            qr: t,
                            no_sample: ''
                        },
                        success: function(e) {
                            e = JSON.parse(e)
                            $("#sum").html(e.record),
                            $('#qr').val(t)
                            $('#qr_code').val(t)
                            localStorage.setItem("id_qr", e.id),
                            Swal.fire({
                                icon: "success",
                                title: e.message,
                                timer: 2e3
                            })
                        },
                        error: function(e) {
                            Swal.fire({
                                icon: "info",
                                title: e.responseJSON.message,
                                timer: 2e3
                            });
                        },
                    });
                }),
                Instascan.Camera.getCameras()
                .then(function(e) {
                    e.length > 0 ?
                        (scanner.start(e[1]),
                            $("#switch-togle").on("click", function(t) {
                                switch ((console.log(this.value), this.value)) {
                                    case "1":
                                        (this.value = "2"), "" != e[0] ? scanner.start(e[0]) : alert("No Front camera found!");
                                        break;
                                    case "2":
                                        (this.value = "1"), "" != e[0] ? scanner.start(e[1]) : alert("No Front camera found!");
                                }
                            }),
                            $("#close-scann").on("click", function() {
                                $("#ccc").modal("hide"), scanner.stop();
                            })) :
                        (console.error("No cameras found."), alert("No cameras found."));
                })
                .catch(function(e) {
                    console.error(e), alert(e);
                }),
                $(document).ready(function() {
                    $("#ccc").modal("show");
                });
    })
</script>