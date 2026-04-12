<!DOCTYPE html>
<!-- <html class="no-js" lang="zxx"> -->
<html class="no-js" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>@yield('title', 'Lasu C&S Chapter')</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/img/favicon.png') }}">

    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#ffffff">

    <!--================ Seo Optimization =================-->
    @include('includes.seo')
    <!--================ External Styling link =================-->
    @include('includes.style')
    <!--================ Inline Styling =================-->
    @yield('style')
</head>

<body>
    <!-- ? Preloader Start -->
    <div id="preloader-active">
        <div class="preloader d-flex align-items-center justify-content-center">
            <div class="preloader-inner position-relative">
                <div class="preloader-circle"></div>
                <div class="preloader-img pere-text">
                    <img src="{{ asset('assets/img/logo/lasu_cns_logo.png') }}" alt="Logo">
                </div>
            </div>
        </div>
    </div>
    <!-- Preloader Start -->
    <!--================ Start Header Menu Area =================-->
    @include('includes.header')
    <main>
        @yield('content')
    </main>
    <!--================ Start footer Area  =================-->
    @include('includes.footer')

    <!-- The Modal -->
    <div class="modal fade mt-40" id="myModal">
        <div class="modal-dialog modal-s modal-dialog-centered">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Support the Fellowship</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <p>
                        Your giving helps us grow and reach more lives. Thank you!
                    </p>
                    <p class="m-0">
                        <strong>Account Name:</strong>
                        <span id="accountName">Cherubim & Seraphim Unification</span>
                        <i class="fa-regular fa-copy ms-2 text-success" style="cursor: pointer;"
                            onclick="copySingle('accountName', this)" title="Copy"></i>
                    </p>
                    <p class="m-0">
                        <strong>Account Number:</strong>
                        <span id="accountNumber">0504029090</span>
                        <i class="fa-regular fa-copy ms-2 text-success" style="cursor: pointer;"
                            onclick="copySingle('accountNumber', this)" title="Copy"></i>
                    </p>
                    <p class="m-0">
                        <strong>Bank:</strong>
                        <span id="bankName">Sterling Bank</span>
                        <i class="fa-regular fa-copy ms-2 text-success" style="cursor: pointer;"
                            onclick="copySingle('bankName', this)" title="Copy"></i>
                    </p>
                    <p class="mt-2">
                        <em>“Each one must give as he has decided in his heart… for God loves a cheerful giver.” –
                            2Corinthians 9:7</em>
                    </p>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer d-flex">
                    {{-- <a href="#" target="_blank" class="btn">💳 Give Online</a> --}}
                    <button type="button" class="btn btn-outline" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Scroll Up -->
    <div id="back-top">
        <a title="Go to Top" href="#"> <i class="fas fa-level-up-alt"></i></a>
    </div>

    <!--================ Script link =================-->
    @include('includes.script')
    <!--================ Inline Script  =================-->
    @yield('script')
    <script>
        function copySingle(elementId, iconElement) {
            const text = document.getElementById(elementId).innerText;
            navigator.clipboard.writeText(text).then(() => {
                iconElement.classList.remove('fa-copy');
                iconElement.innerText = "Copied!";
                setTimeout(() => {
                    iconElement.innerText = "";
                    iconElement.classList.add('fa-copy');
                }, 2000);
            }).catch(() => {
                alert("Failed to copy. Please try again.");
            });
        }

        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/serviceworker.js').then(reg => {

                    // Force the SW to check for updates
                    reg.update();

                    // If there's a waiting SW, activate it immediately
                    if (reg.waiting) {
                        reg.waiting.postMessage({
                            type: 'SKIP_WAITING'
                        });
                    }

                    // Listen for new SW installation
                    reg.addEventListener('updatefound', () => {
                        const newWorker = reg.installing;
                        newWorker.addEventListener('statechange', () => {
                            if (newWorker.state === 'installed' && navigator.serviceWorker
                                .controller) {
                                newWorker.postMessage({
                                    type: 'SKIP_WAITING'
                                });
                                window.location.reload();
                            }
                        });
                    });
                });
            });

            // When controller changes, page reloads
            navigator.serviceWorker.addEventListener('controllerchange', () => {
                console.log('Service worker activated, page reloading...');
                window.location.reload();
            });
        }
    </script>
</body>

</html>
