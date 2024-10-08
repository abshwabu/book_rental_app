<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    @auth
        <title>{{Auth::user()->role}} - page</title>
    @endauth
    

    <!-- Custom fonts for this template-->
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">
</head>

<body id="page-top">

    <!-- Wrapper -->
    <div id="wrapper">
        @auth
        <x-sidebar/>
        @endauth
        <!-- Sidebar -->
        
        
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
           

            <!-- Main Content -->
            <div id="content">
                
                <!-- Topbar -->
                <x-navbar />
                @if (session('status'))
                    <div id="status-message" class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div id="error-message" class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <!-- Page content goes here -->
                    @yield('content')
                </div>
                <!-- /.container-fluid -->
                
            </div>
            <!-- End of Main Content -->
            
            <!-- Footer -->
            <x-footer/>
        
        </div>
        <!-- End of Content Wrapper -->
    
    </div>
    <!-- End of Wrapper -->

    <!-- Scripts -->
    
    <!-- jQuery, Bootstrap JS, and SB Admin JS -->
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>

    <!-- Page level plugins -->
    <script src="{{ asset('vendor/chart.js/Chart.min.js') }}"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset('js/demo/chart-area-demo.js') }}"></script>
    <script src="{{ asset('js/demo/chart-pie-demo.js') }}"></script>
    <script>
        // Function to hide status and error messages after 3 seconds
        setTimeout(function() {
            let statusMessage = document.getElementById('status-message');
            let errorMessage = document.getElementById('error-message');
    
            // Hide the status message if it exists
            if (statusMessage) {
                statusMessage.style.display = 'none';
            }
    
            // Hide the error message if it exists
            if (errorMessage) {
                errorMessage.style.display = 'none';
            }
        }, 3000); // 3000ms = 3 seconds
    </script>
    

</body>
</html>
