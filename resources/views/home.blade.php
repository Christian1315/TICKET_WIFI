<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{env('APP_NAME')}}</title>

    <link rel="shortcut icon" href="{{asset('images/logo.png')}}" type="image/x-icon">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <link rel="stylesheet" href="{{asset('styles/bootstrap.css')}}">

    <link rel="stylesheet" href="{{asset('styles/home.css')}}">
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
</head>

<body class="antialiased bg-dots-darker bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900">
    <div class="container-fluid">
        <!-- NAV BAR -->
        <div class="row bg-light nav-div">
            <div class="col-12">
                <nav class="navbar navbar-expand-lg bg-body-tertiary border-bottom sticky-top">
                    <div class="container-fluid">
                        <a class="navbar-brand" href="#">
                            <img src="{{asset('images/logo.png')}}" alt="" class="logo shadow">
                        </a>

                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>

                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            </ul>
                            <div>
                                <ul class="navbar-nav align-items-center">
                                    <li class="nav-item">
                                        <a class="nav-link active" aria-current="page" href="#">Accueil</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#">A propos</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#">Contact</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#">Récupérer mon ticket</a>
                                    </li>
                                    <li class="nav-item">
                                        @if (Route::has('login'))
                                        @auth
                                        <a href="{{ url('/dashboard') }}" class="btn btn-sm border bg-blue text-white btn-hover">Tableau de board</a>
                                        @else
                                        <a href="{{ route('login') }}" class="btn btn-sm border bg-blue text-white btn-hover shadow"><i class="bi bi-person-fill-lock"></i> Se connecter</a>

                                        @if (Route::has('register'))
                                        <a href="{{ route('register') }}" class="btn btn-sm border bg-blue text-white btn-hover">Register</a>
                                        @endif
                                        @endauth
                                        @endif
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>
        </div>

        <!-- HEADER -->
        <div class="row" id="header">
            <div class="col-md-12 content-blok">
                <div class="row">
                    <div class="col-md-4 col-sm-12"></div>
                    <div class="col-md-8 col-sm-12 ">
                        <div class="content p-2 bg-layer">
                            <h1 class="text-white title animate__animated  animate__fadeInDown">BIENVENUE SUR TICKETWIFI</h1>
                            <p class="description">La plateforme qui vous permet d'automatiser la vente de vos tickets wifizone via des moyens de paiement mobile money et cartes bancaires</p>
                        </div>

                        <!-- Créer un compte -->
                        <div class="text-center">
                            <a href="#" class="btn btn-lg bg-orange btn-hover animate__animated  animate__fadeInUp">Créer un compte</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <!-- Section1 -->
        <div class="row section">
            <div class="col-6">
                <h3 class="title"> <img src="{{asset('images/wifi.png')}}" alt="wifi" class="img-fluid"> Qu'est-ce que ticketwifi?</h3>
                <p class="">Lorem ipsum dolor sit amet consectetur adipisicing elit. Distinctio minus autem, error qui corporis dolorum repudiandae architecto facere laborum accusantium vitae praesentium iste, ratione, laudantium quibusdam possimus quidem. Veritatis, quae.
                    Ipsam, iste sint aperiam nulla corporis fugiat adipisci quibusdam nemo impedit omnis neque voluptatem dolore! Iusto maxime fugit aut nisi dolore molestias, accusantium repellat facilis in, sunt eum ut pariatur.
                    Obcaecati recusandae id voluptatibus totam eveniet. Molestias pariatur enim perspiciatis repudiandae incidunt rem ipsum est soluta, veniam laudantium error nulla sed explicabo fugiat. Alias deserunt asperiores eos, doloribus possimus impedit!</p>
            </div>
            <div class="col-6"></div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
</body>