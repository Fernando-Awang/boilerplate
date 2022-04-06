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
    <!-- Theme style -->
    <link rel="stylesheet" href="/dist/css/adminlte.min.css">
</head>

<body class="hold-transition sidebar-mini">
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
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="/dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="/dist/js/adminlte.js"></script>
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
