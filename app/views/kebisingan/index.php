<div id="appCapsule">
    <div class="section wallet-card-section pt-1">
        <div class="wallet-card">
            <div class="balance">
                <div class="left">
                    <span class="title"><?= $data['salam']; ?></span>
                    <h1 class="total"><span><?= $data['nama']; ?></span></h1>
                </div>
                <div class="right">
                    <span class="title">Total Data Offline : <?= $data['total_data']; ?></span>
                    <button class="btn btn-success" id="sync"><i class="fa-solid fa-upload"></i> Upload Data</button>
                </div>
            </div>
            
            <!-- * Balance -->
            <!-- Wallet Footer -->
            <div class="wallet-footer">
                <div class="item">
                    <a href="<?= base_url;?>/kebisingan/add_data">
                        <div class="icon-wrapper bg-primary">
                            <i class="fa-solid fa-plus"></i>
                        </div>
                        <strong>Add Data</strong>
                    </a>
                </div>
                <div class="item">
                    <a href="./datakebisingan">
                        <div class="icon-wrapper bg-danger">
                            <i class="fa-solid fa-file-lines"></i>
                        </div>
                        <strong>Data</strong>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
    

<div class="btnBottom">
    <div class="btnTengah" onclick="location.href='kebisingan/add_data'"></a></div>
    <div class="btnMenu">
        <ul>
            <li style="--i:0.1s;"><a href="<?= base_url;?>/home"><i class="fa-solid fa-gauge"></i></a></li>
            <li style="--i:0.2s;"><a href="<?= base_url;?>/kebisingan"><i class="fa-solid fa-house"></i></a></li>
            <li></li>
            <li style="--i:0.2s;"><a href="<?= base_url;?>/datakebisingan"><i class="fa-solid fa-file-lines"></i></a></li>
            <li style="--i:0.1s;"><a href="<?= base_url;?>/profile"><i class="fa-solid fa-user"></i></a></li>
        </ul>
    </div>
</div>

<script>
    $('#sync').on('click', function(){
        let net = $('#status-text').text();
        if(net == "Online"){
            var no_sample = $("#no_sample").val();
            $.ajax({
                url: '/public/kebisingan/upload_data_to_server',
                method: 'POST',
                success: function(resp) {
                    resp = JSON.parse(resp)
                    if(resp.length == 0){
                        Swal.fire({
                            icon: 'error',
                            title: 'Ada Masalah Pada Data Silahkan Hubungi IT.!',
                        })
                    }else {
                        Swal.fire({
                            title : "Data Berhasil Disimpan",
                            icon : "success",
                            timer : 2000
                        })
                    }     
                },
                error: function(e) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Tidak Dapat Mengirim Data.!',
                    })
                }
            })
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Anda Sedang Offline, Tidak Dapat Melakukan Sinkronisasi',
            })
        }
    })
</script>