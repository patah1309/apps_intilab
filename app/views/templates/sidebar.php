<body style="z-index: -100;">
   <div class="loading">
      <div class="spinner-border text-primary" role="status"></div>
   </div>
   <!-- loader -->
   <div id="loader">
      <img src="<?= base_url; ?>/assets/img/Preloader.gif" alt="icon" class="loading-icon">
   </div>
   <!-- * loader -->
   <!-- App Header -->
   <div class="appHeader bg-primary text-light">
      <div class="left">
         <a href="#" class="headerButton" data-toggle="modal" data-target="#sidebarPanel">
            <ion-icon name="menu-outline"></ion-icon>
         </a>
         <i class="fa fa-square" id="status-connection">&nbsp;</i><span
            id="status-text">&nbsp;</span>
      </div>
      <div class="right">
         <div class="headerButton" data-toggle="dropdown" id="dropdownMenuLink" aria-haspopup="true">
            <img src="<?= base_url; ?>/assets/img/admin.png" alt="image" class="imaged w40">
            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                <!-- <a class="dropdown-item"  href="#"><ion-icon size="small" name="person-outline"></ion-icon>Profil</a> -->
                <a class="dropdown-item"  href="#" onclick="location.href='logout';"><ion-icon size="small" name="log-out-outline"></ion-icon>Keluar</a>
            </div>
         </div>
      </div>
   </div>
   <div class="modal fade panelbox panelbox-left" id="sidebarPanel" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
         <div class="modal-content">
            <div class="modal-body p-0">
               <!-- profile box -->
               <div class="profileBox pt-2 pb-2">
                  <div class="image-wrapper"><img src="./assets/img/admin.png" class="imaged w36">
                  </div>
                  <div class="in">
                     <strong><span id="name_user"></span></strong>
                     <div class="text-muted">dedi@intilab.com</div>
                  </div>
                  <a href="#" class="btn btn-link btn-icon sidebar-close" data-dismiss="modal">
                     <ion-icon name="close-outline"></ion-icon>
                  </a>
               </div>
               <!-- * profile box -->

               <!-- menu -->
               <div class="listview-title mt-1">MENU UTAMA</div>
               <ul class="listview flush transparent no-line image-listview">
                  <li>
                     <a href="./profile" class="item">
                        <div class="icon-box bg-primary">
                           <ion-icon name="person-outline"></ion-icon>
                        </div> Profil
                     </a>
                  </li>
                  <li>
                     <a href="<?= base_url;?>/logout" class="item">
                        <div class="icon-box bg-primary">
                           <ion-icon name="person-outline"></ion-icon>
                        </div> Logout
                     </a>
                  </li>
               </ul>
            </div>
         </div>
      </div>
   </div>