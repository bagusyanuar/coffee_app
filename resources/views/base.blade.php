<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <link rel="stylesheet" href="{{ asset('/bootstrap/css/bootstrap.min.css') }}">
    <link href="{{ asset('/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/sweetalert2.css') }}" rel="stylesheet">
    <script src="{{ asset('/js/sweetalert2.min.js')}}"></script>
    <title>Document</title>
    @yield('css')
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Sistem Pemesanan Coffee Shop</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="/dashboard">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/pengguna">Pengguna</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-expanded="false">
                        Master Data
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="/kategori">Kategori</a>
                        <a class="dropdown-item" href="/menu">Menu</a>
                    </div>
                </li>
            </ul>
            <div class="d-flex">
                <a href="/logout" class="btn btn-outline-light">Keluar</a>
            </div>
        </div>
    </div>
</nav>
<div aria-live="polite" aria-atomic="true" style="position: relative; min-height: 0;">
    <div class="toast d-none" style="position: fixed; top: 0; right: 0; z-index: 99999" data-autohide="true"
         data-delay="8000">
        <div class="toast-header">
            <img src="" class="rounded mr-2" alt="">
            <strong class="mr-auto" id="toast-title"></strong>
            <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="toast-body" id="toast-message">
        </div>
    </div>
</div>
@yield('content')
<script src="{{ asset('/jQuery/jquery-3.4.1.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
<script src="{{ asset('/bootstrap/js/bootstrap.js') }}"></script>
<script src="{{ asset('/datatables/jquery.dataTables.js') }}"></script>
<script src="{{ asset('/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script src="https://www.gstatic.com/firebasejs/8.0.0/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.0.0/firebase-auth.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.0.0/firebase-firestore.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.0.0/firebase-messaging.js"></script>
<script>
    async function getWebDeviceToken() {
        let token = null;
        const messaging = firebase.messaging();
        try {
            token = await messaging.getToken();
        }catch(e) {
            console.log(e);
        }
        console.log(token);
        return  token;
    }

    var messaging;
    var db;
    var createdAt;
    if ('serviceWorker' in navigator) {
        if (!firebase.apps.length) {
            var firebaseConfig = {
                apiKey: "AIzaSyCsyzivLelJuTTP35aLoocq94hNCWwq0ZU",
                authDomain: "johnny-app-9d4c3.firebaseapp.com",
                projectId: "johnny-app-9d4c3",
                storageBucket: "johnny-app-9d4c3.appspot.com",
                messagingSenderId: "26716726425",
                appId: "1:26716726425:web:320a3001ca5663dda74408"
            };
            firebase.initializeApp(firebaseConfig);
            if(firebase.messaging.isSupported()){
                messaging = firebase.messaging();
                messaging.usePublicVapidKey('BBMqaivadfJy3Eo1_2p-iZqck2VG44cT5PMCI5Aa2vvEwQNccRR9AW8a99KkI70dG50FM3A_KVcfwqntsSYJ7lI');
                db = firebase.firestore();
                createdAt = firebase.firestore.Timestamp.fromDate(new Date());
                console.log('Browser Support for Messaging');
                messaging.onMessage((payload) => {
                    console.log('Message received. ', payload);
                    let title = payload['data']['title'];
                    let body = payload['data']['body'];

                    $('#toast-title').html(title);
                    $('#toast-message').html(body);
                    $('.toast').removeClass('d-none');
                    $('.toast').toast('show');

                });

            }else{
                console.log('Your Browser Not Supported Messaging')
            }
        }
        console.log('in sw');
    }else {
        console.log('not in sw')
    }

    navigator.serviceWorker.register('/firebase-messaging-sw.js');

    $(document).ready(function () {
        getWebDeviceToken();
    });
</script>
@yield('js')
</body>
</html>
