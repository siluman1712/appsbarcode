  
  <?php
$query  = "SELECT s_tglawal, s_tglakhir, s_thnang FROM s_settgl ORDER BY idtgl ASC";
$tgl    = $koneksi->query($query);
$rs     = mysqli_fetch_array($tgl);
  ?>
  <header class="main-header">
    <nav class="navbar navbar-static-top">
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <div class="container-fluid">
        <div class="navbar-header">
          <a href="?module=home" class="navbar-brand"><b>APPENDI.XII</b></a>
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
            <i class="fa fa-bars"></i>
          </button>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
          <ul class="nav navbar-nav">
            <li><a href="?module=home" title="Home/Halaman Utama"><i class="fa fa-home"></i><span class="sr-only">(current)</span> Halaman Utama</a></li>

            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-tasks"></i>&nbsp;&nbsp;&nbsp;Referensi <span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                <li><a href="?module=satker"><i class="fa fa-circle-o text-aqua"></i>Satuan Kerja </a></li>
                <li><a href="?module=kodefbmn"><i class="fa fa-circle-o text-aqua"></i>Kodefikasi BMN </a></li>
                <li><a href="?module=settgl"><i class="fa fa-circle-o text-aqua"></i>Konfig. Tgl </a></li>
                <li><a href="?module=konfigruangan"><i class="fa fa-circle-o text-aqua"></i>Konfig. Ruangan </a></li>
                <li><a href="?module=dbpegawai"><i class="fa fa-circle-o text-aqua"></i>Data Base Pegawai </a></li>
                <li><a href="?module=penandatanganan"><i class="fa fa-circle-o text-aqua"></i>Penandatanganan </a></li>
              </ul>
            </li>

            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-search"></i>&nbsp;&nbsp;&nbsp; Pencarian BMN<span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">


                <li><a href="?module=infobmn">
                &nbsp;&nbsp;&nbsp;Informasi BMN&nbsp;&nbsp;&nbsp;
                <i class="fa fa-info text-aqua">
                </i></a></li>


              </ul>
            </li>


          </ul>
        </div>
        <!-- /.navbar-collapse -->
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">
            <li class="dropdown messages-menu">
              <!-- Menu toggle button -->
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <i class="fa fa-envelope-o"></i>&nbsp;
                <span class="label label-success">4</span>
                &nbsp;NOTIFIKASI
              </a>
              <ul class="dropdown-menu">
                <li class="header">You have 4 messages</li>
                <li>
                  <!-- inner menu: contains the messages -->
                  <ul class="menu">
                    <li><!-- start message -->
                      <a href="#">
                        <div class="pull-left">
                          <!-- User Image -->
                          <img src="dist/img/logo.png" class="img-circle" alt="User Image">
                        </div>
                        <!-- Message title and timestamp -->
                        <h4>
                          Support Team
                          <small><i class="fa fa-clock-o"></i> 5 mins</small>
                        </h4>
                        <!-- The message -->
                        <p>Why not buy a new awesome theme?</p>
                      </a>
                    </li>
                    <!-- end message -->
                  </ul>
                  <!-- /.menu -->
                </li>
                <li class="footer"><a href="#">See All Messages</a></li>
              </ul>
            </li>
            <!-- User Account Menu -->
            <li class="dropdown user user-menu">
              <!-- Menu Toggle Button -->
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <!-- The user image in the navbar-->
                <img src="dist/img/logo.png" class="user-image" alt="User Image">
                <!-- hidden-xs hides the username on small devices so only the image appears. -->
                <span class="hidden-xs"><?php echo"$_SESSION[LOKINS]";?></span>
              </a>
              <ul class="dropdown-menu">
                <!-- The user image in the menu -->
                <li class="user-header">
                  <img src="dist/img/logo.png" class="img-circle" alt="User Image">

                  <p>
                  <?php echo"$_SESSION[NIP]";?>
                  <small><?php echo"$_SESSION[LOGIN_TERAKHIR]";?></small>
                  </p>
                </li>
                <!-- Menu Body -->
                <li class="user-body">
                  <div class="row">
                  <div class="col-xs-12 text-center">
                  <a href="?module=user" class="btn bg-blue btn-block btn-flat"><font color='#fff'>User</font></a>
                  <a href="logout.php" class="btn bg-navy btn-block btn-flat"><font color='#fff'>Keluar</font></a>
                  </div>
                  </div>
                  <!-- /.row -->
                </li>
              </ul>
            </li>
          </ul>
        </div>
        <!-- /.navbar-custom-menu -->
      </div>
      <!-- /.container-fluid -->
    </nav>
  </header>