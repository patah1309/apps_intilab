<!-- * App Sidebar -->
<div id="appCapsule">
   <div class="card">
      <div class="card-body ">
         <div class="table-responsive">
            <table class="loaddata table table-bordered table-striped" id="data">
               <thead>
                  <tr>
                     <th>#</th>
                     <th nowrap>Tgl Uji</th>
                     <th nowrap>No Qr</th>
                     <th nowrap>No Sample</th>
                     <?php if($data['koneksi'] == true) {?>
                     <th nowrap>Nama Perusahaan</th>
                     <?php }?>
                  </tr>
               </thead>
               <tbody>
                  <?php foreach($data['data'] as $value):?>
                  <tr>
                     <td>
                        <div class="d-flex">
                           <?php if($data['koneksi'] == true) {?>
                           <a href="<?= base_url;?>/emisi/detailEmisi/<?=$value->kode?>"><span class="col-blue"><i
                                    class="fa-solid fa-eye"></i></span></a> &nbsp;|&nbsp;
                           <?php }else { ?>
                           <a href="<?= base_url;?>/emisi/detailEmisioff/<?= str_replace("/","_", $value->no_sample)?>"><span
                                 class="col-blue"><i class="fa-solid fa-eye"></i></span></a> &nbsp;|&nbsp;
                           <?php } ?>
                           <?php 
                           if($value->approve == 0) { ?>
                           <?php if($data['koneksi'] == true) {?>
                           <a href="javascript:;" onclick="approve(<?= $value->id ?>)"><span class="col-by"><i
                                    class="fa-solid fa-check"></i></span></a>&nbsp;
                           <?php }else {   ?>
                           <a href="javascript:;" onclick="del('<?= str_replace('/','_', $value->no_sample) ?>')"><span
                                 class="col-by"><i class="fa-solid fa-trash-can"></i></span></a>
                           &nbsp;&nbsp;
                           <?php } ?>
                           <?php } ?>
                        </div>
                     </td>
                     <td><?= $value->tgl ?></td>
                     <td><?= $value->kode; ?></td>
                     <td><?= $value->no_sample; ?></td>
                     <?php if($data['koneksi'] == true) {?>
                     <td><?= $value->nama; ?></td>
                     <?php } ?>
                  </tr>
                  <?php endforeach; ?>
               </tbody>
            </table>
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
var toastMixin = Swal.mixin({
   toast: true,
   icon: 'success',
   title: 'General Title',
   animation: false,
   position: 'top-right',
   showConfirmButton: false,
   timer: 2000,
   timerProgressBar: true,
   didOpen: (toast) => {
      toast.addEventListener('mouseenter', Swal.stopTimer)
      toast.addEventListener('mouseleave', Swal.resumeTimer)
   }
});

var table = null;

$(document).ready(function() {
   if ($('#status-text').text() == 'Offline') {
      Swal.fire({
         icon: 'info',
         title: 'Oooops...',
         text: 'Saat ini anda sedang offline...!',
         timer: 3000
      })
   }
   tabel = $('#data').DataTable()
})

function approve(id) {
   Swal.fire({
      title: 'Are you sure APPROVE this data?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, Approve it!'
   }).then((result) => {
      if (result.isConfirmed) {
         $.ajax({
            url: '/public/emisi/approveEmisi',
            method: 'POST',
            data: {
               id: id
            },
            success: function(resp) {
               e = JSON.parse(resp)
               if (e.length == 0) {
                  Swal.fire({
                     icon: 'error',
                     title: 'Approve Data Galal.!',
                  })
               } else {
                  Swal.fire({
                     title: e.message,
                     icon: "success",
                     timer: 2000
                  })
                  window.location.href = "<?= base_url; ?>/emisi/viewData";
               }
            }
         })
      }
   });
}

function del(id) {
   Swal.fire({
      title: 'Are you sure DELETE this data?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, Delete it!'
   }).then((result) => {
      if (result.isConfirmed) {
         $.ajax({
            url: '/public/emisi/hapusData',
            method: 'POST',
            data: {
               id: id
            },
            success: function(resp) {
               e = JSON.parse(resp)
               if (e.length == 0) {
                  Swal.fire({
                     icon: 'error',
                     title: 'Approve Data Galal.!',
                  })
               } else {
                  Swal.fire({
                     title: e.message,
                     icon: "success",
                     timer: 2000
                  })
                  window.location.href = "<?= base_url; ?>/emisi/viewData";
               }
            }
         })
      }
   });
}
</script>