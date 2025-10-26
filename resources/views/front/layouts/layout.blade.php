<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" type="image/png" href="data:image/png;base64,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">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @include('front.layouts.parts.seo')

    <title>@yield('title', env('APP_NAME'))</title>

    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />

    @stack('before-css')

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">
    @stack('after-bootstrap-css')
    <link rel="stylesheet" href="{{asset('front/css/all.css')}}">
    @stack('after-fontawesome-css')
    <link rel="stylesheet" href="{{ asset('assets/css/blocks.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/loading.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/my-icon.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/form-error.css') }}">
    @stack('after-blocks-css')

    <!-- styles for this template -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;1,100;1,200;1,300;1,400;1,500;1,600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,600;1,300;1,400&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;1,100;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">

    @stack('after-css')
</head>

<body class="text-secondary" time-stamps="{{time()}}">
    <div id="app">
        <div style="position: fixed;background: #3a919f;z-index: 9999;height: 100%;width: 100%;display: flex;align-items: center;" class="loading-front">
            <div class="spinner">
                <div class="rect1"></div>
                <div class="rect2"></div>
                <div class="rect3"></div>
                <div class="rect4"></div>
                <div class="rect5"></div>
            </div>
        </div>

        @include('front.layouts.parts.top-bar')

        <div class="modals">
            <v-dialog :click-to-Close="false" />
        </div>

        @yield('content')
        <!--<notifications group="notif-product-commande" position="top center" :duration="20000" :width="'500px'">
            <template slot="body" slot-scope="props">
                <div class="card bg-warning border border-warning text-white mt-2" @click="props.close">
                    <div class="card-header">
                        <h6> @{{props.item.title}}</h6>
                    </div>
                    <div class="card-body">
                        <span v-html="props.item.text"></span> 
                    </div>
                </div>
            </template>
        </notifications>-->
    </div>

    @include('front.layouts.parts.footer')

    @stack('before-js')
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    @stack('after-jquery-js')
    <script src="{{ asset('assets/js/popper.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    @stack('after-popper-js')
    <script src="{{ asset('assets/bootstrap/js/bootstrap.min.js') }}"></script>
    @stack('after-bootstrap-js')
    <script src="{{ asset('assets/js/script.js') }}"></script>

    <script type="text/javascript" src="https://cdn.polyfill.io/v2/polyfill.min.js"></script>
    <script type="text/javascript" src="{{ asset('/front/js/monJs.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/front.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/refresh-page-control.js') }}"></script>
    @stack('after-script-js')

    @stack('after-js')
</body>

</html>