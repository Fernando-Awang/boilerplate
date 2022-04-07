<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Navbar Search -->

        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-user"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                <a href="#" class="dropdown-item" data-toggle="modal" data-target="#accountModal" onclick="accountGet()">
                    <i class="fas fa-user mr-2"></i> Akun
                </a>
                <a href="#" class="dropdown-item" onclick="logout()">
                    <i class="fas fa-power-off mr-2"></i> Logout
                </a>
            </div>
        </li>
    </ul>
</nav>
<div class="modal fade" id="accountModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Pengaturan Akun</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="">Nama</label>
                    <input type="text" class="form-control" id="accountName" placeholder="Nama">
                    <div id="accountNameInvalid" class="invalid-feedback"></div>
                </div>
                <div class="form-group">
                    <label for="">Email</label>
                    <input type="text" class="form-control" id="accountEmail" readonly placeholder="Email">
                    <div id="accountEmailInvalid" class="invalid-feedback"></div>
                </div>
                <div class="form-group">
                    <label for="">Password</label>
                    <input type="password" class="form-control" id="accountPassword" placeholder="Password">
                    <div id="accountPasswordInvalid" class="invalid-feedback"></div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-success" onclick="accountUpdate('{{auth()->user()->id}}')">
                    <li class="fas fa-save"></li>
                    Simpan
                </a>
            </div>
        </div>
    </div>
</div>
<!-- /.navbar -->
