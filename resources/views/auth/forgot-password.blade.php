<!DOCTYPE html>
<html lang="en">
<head>
    <!--  Title -->
    <title>Mordenize</title>
    <!--  Required Meta Tag -->
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="handheldfriendly" content="true" />
    <meta name="MobileOptimized" content="width" />
    <meta name="description" content="Mordenize" />
    <meta name="author" content="" />
    <meta name="keywords" content="Mordenize" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!--  Favicon -->
    <link rel="shortcut icon" type="image/png" href="../../dist/images/logos/favicon.ico" />
    <!-- Core Css -->
    <link  id="themeColors"  rel="stylesheet" href="../../dist/css/style.min.css" />
</head>
<body>
<!-- Preloader -->
<div class="preloader">
    <img src="../../dist/images/logos/favicon.ico" alt="loader" class="lds-ripple img-fluid" />
</div>
<!-- Preloader -->
<div class="preloader">
    <img src="../../dist/images/logos/favicon.ico" alt="loader" class="lds-ripple img-fluid" />
</div>
<!--  Body Wrapper -->
<div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
    <div class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
        <div class="d-flex align-items-center justify-content-center w-100">
            <div class="row justify-content-center w-100">
                <div class="col-md-8 col-lg-6 col-xxl-3">
                    <div class="card mb-0">
                        <div class="card-body pt-5">
                            <a href="./index.html" class="text-nowrap logo-img text-center d-block mb-4">
                                <img src="../../dist/images/logos/dark-logo.svg" width="180" alt="">
                            </a>
                            <div class="mb-5 text-center">
                                <p class="mb-0 ">
                                    Please enter the email address associated with your account and We will email you a link to reset your password.
                                </p>
                            </div>
                            <form method="POST" action="{{ route('password.email') }}">
                                @csrf
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Email address</label>
                                    @if(session('status') !== null)
                                        <input type="email" name="email" class="form-control is-valid" id="exampleInputEmail1" aria-describedby="emailHelp">
                                        <div class="valid-feedback">
                                            {{ session('status') }}
                                        </div>
                                    @else
                                        <input type="email" name="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" id="exampleInputEmail1" aria-describedby="emailHelp">
                                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                    @endif
                                </div>
                                <button class="btn btn-primary w-100 py-8 mb-3">Forgot Password</button>
                                <a href="{{ route("login") }}" class="btn btn-light-primary text-primary w-100 py-8">Back to Login</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--  Import Js Files -->
<script src="../../dist/libs/jquery/dist/jquery.min.js"></script>
<script src="../../dist/libs/simplebar/dist/simplebar.min.js"></script>
<script src="../../dist/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<!--  core files -->
<script src="../../dist/js/app.min.js"></script>
<script src="../../dist/js/app.init.js"></script>
<script src="../../dist/js/app-style-switcher.js"></script>
<script src="../../dist/js/sidebarmenu.js"></script>

<script src="../../dist/js/custom.js"></script>
</body>
</html>
