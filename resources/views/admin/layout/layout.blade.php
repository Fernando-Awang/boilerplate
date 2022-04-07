<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Side</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="/plugins/fontawesome-free/css/all.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    @yield('css')
    <!-- Theme style -->
    <link rel="stylesheet" href="/dist/css/adminlte.min.css">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <!-- Site wrapper -->
    <div class="wrapper">
        {{-- navbar --}}
        <?= view('admin.layout.navbar') ?>
        {{-- sidebar --}}
        <?= view('admin.layout.sidebar') ?>

        @yield('content')
        {{-- footer --}}
        <?= view('admin.layout.footer')?>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
         {{ route('admin.user', ['id'=>1]) }}
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    @yield('plugins')
    <!-- AdminLTE App -->
    <script src="/dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="/dist/js/demo.js"></script>
    {{-- sweetalert --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.4/dist/sweetalert2.all.min.js"
        integrity="sha256-COxwIctJg+4YcOK90L6sFf84Z18G3tTmqfK98vtnz2Q=" crossorigin="anonymous"></script>
    @yield('script');
    <script>
        // konfirm logout
        function logout() {
            Swal.fire({
                icon: 'warning',
                title: 'Konfirmasi',
                text: "Anda akan logout, Lanjutkan?",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Lanjutkan!',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Tidak!'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        icon: "success",
                        text: "Terima kasih!",
                    }).then((res) => {
                        window.location = "{{ route('admin.logout') }}";
                    })
                }
            });
        }
        function accountGet() {
            $('#accountName').prop('class', 'form-control').val('{{ auth()->user()->name }}');
            $('#accountEmail').prop('class', 'form-control').val('{{ auth()->user()->email }}');
            $('#accountPassword').prop('class', 'form-control').val('');
        }
        function accountUpdate(id) {
            $('.invalid-feedback').text('');
            $('#accountName').prop('class', 'form-control is-valid');
            $('#accountEmail').prop('class', 'form-control is-valid');
            $('#accountPassword').prop('class', 'form-control is-valid');
            let name = $('#accountName').val();
            let email = $('#accountEmail').val();
            let password = $('#accountPassword').val();
            if (name == '') {
                $('#accountName').prop('class', 'form-control is-invalid');
                $('#accountNameInvalid').text('masukan nama');
            }
            $.ajax({
                url: "{{ url('admin/user') }}" + "/" + id,
                type: 'put',
                dataType: 'json',
                data: {
                    _token: '{{csrf_token()}}',
                    name: $('#accountName').val(),
                    email: $('#accountEmail').val(),
                    password: $('#accountPassword').val(),
                },
                success: function(res) {
                    if (res.success == true) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: 'Akun disimpan',
                        }).then((done) => {
                            location.reload()
                        })
                    }else if(res.success == false){
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: 'Akun gagal disimpan',
                        })
                    }
                }
            })
        }
    </script>
    @if (session()->get('error'))
    <script>
        Swal.fire({
                    icon: 'error',
                    text: "{{session()->get('error')}}",
                })
    </script>
    @endif
    @if (session()->get('success'))
    <script>
        Swal.fire({
                    icon: 'success',
                    text: "{{session()->get('success')}}",
                })
    </script>
    @endif
</body>

</html>
