<!DOCTYPE html>
<html lang="en">

<head>
    <!--  Title -->
    <title>Psikotes</title>
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
    <link rel="shortcut icon" type="image/png" href="/dist/images/logos/4.1.png" />
    <!-- Core Css -->
    <link id="themeColors" rel="stylesheet" href="/dist/css/style.min.css" />
    {!! htmlScriptTagJsApi() !!}
</head>

<body>
    <!-- Preloader -->
    <div class="preloader">
        <img src="/dist/images/logos/favicon.ico" alt="loader" class="lds-ripple img-fluid" />
    </div>
    <!-- Preloader -->
    <div class="preloader">
        <img src="/dist/images/logos/favicon.ico" alt="loader" class="lds-ripple img-fluid" />
    </div>
    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
        <div class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
            <div class="d-flex align-items-center justify-content-center w-100">
                <div class="row justify-content-center w-100">
                    <div class="col-md-8 col-lg-6 col-xxl-3">
                        <div class="card mb-xl-4">
                            <div class="card-body">
                                <a href="./index.html" class="text-nowrap logo-img text-center d-block mb-5 w-100">
                                    <img src="/dist/images/logos/4.png" width="150" alt="">
                                </a>
                                <div class="row">
                                    <a class="btn btn-white text-dark border fw-normal d-flex align-items-center justify-content-center rounded-2 py-8" href="{{ route('oauth.redirect') }}" role="button">
                                        <img src="/dist/images/svgs/google-icon.svg" alt="" class="img-fluid me-2" width="18" height="18">
                                        <span class="d-none d-sm-block me-1 flex-shrink-0"></span>Google
                                    </a>
                                </div>
                                <div class="position-relative text-center my-4">
                                    <p class="mb-0 fs-4 px-3 d-inline-block bg-white text-dark z-index-5 position-relative">or sign in with</p>
                                    <span class="border-top w-100 position-absolute top-50 start-50 translate-middle"></span>
                                </div>
                                <form class="mb-4" action="{{ route('login') }}" method="POST">
                                    @if(session('status'))
                                    <div class="alert alert-success" role="alert">
                                        {{ session('status') }}
                                    </div>
                                    @endif
                                    <div class="mb-3">
                                        <label for="exampleInputEmail1" class="form-label">Username</label>
                                        <input type="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : ''}}" name="email" aria-describedby="emailHelp">
                                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                    </div>
                                    <div class="mb-4">
                                        <label for="exampleInputPassword1" class="form-label">Password</label>
                                        <input type="password" class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" name="password">

                                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between mb-4">
                                        {!! htmlFormSnippet() !!}
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between mb-4">
                                        <div class="form-check">
                                            <input class="form-check-input primary" type="checkbox" id="flexCheckChecked" name="remember">
                                            <label class="form-check-label text-dark" for="flexCheckChecked">
                                                Remeber this Device
                                            </label>
                                        </div>
                                    </div>
                                    <div class="d-grid gap mb-4">
                                        <a class="text-primary fw-medium" href="{{ route('password.request') }}">Forgot Password ?</a>
                                    </div>
                                    @csrf
                                    <x-input-error :messages="$errors->get('g-recaptcha-response')" class="mt-2" />
                                    <button class="btn btn-primary w-100 py-8 mb-4 rounded-2">Sign In</button>
                                    <div class="d-flex align-items-center justify-content-center">
                                        <p class="fs-4 mb-0 fw-medium">New to {{ env("APP_NAME") }} ?</p>
                                        <a class="text-primary fw-medium ms-2" href="{{ route("register") }}">Create an account</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--  Import Js Files -->
    <script src="/dist/libs/jquery/dist/jquery.min.js"></script>
    <script src="/dist/libs/simplebar/dist/simplebar.min.js"></script>
    <script src="/dist/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <!--  core files -->
    <script src="/dist/js/app.min.js"></script>
    <script src="/dist/js/app.init.js"></script>
    <script src="/dist/js/app-style-switcher.js"></script>
    <script src="/dist/js/sidebarmenu.js"></script>

    <script src="/dist/js/custom.js"></script>
</body>

</html>