<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{str_replace("_","-",env('APP_NAME'))}}</title>

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

<body class="home-body antialiased bg-dots-darker bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900">
    <!-- Alert2 -->
    @include('sweetalert::alert')

    <div class="container-fluid">
        <!-- NAV BAR -->
        <div class="row bg-light nav-div p-0 m-0 shadow">
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
                                        <a class="nav-link" aria-current="page" href="/">Accueil</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{env('APP_URL')}}#about">A propos</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{env('APP_URL')}}#contact">Contact</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{route('routerLocalization')}}">Localisation de wifizone</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link active" href="{{route('getTicket')}}">Récupérer mon ticket</a>
                                    </li>
                                    <li class="nav-item">
                                        @if (Route::has('login'))
                                        @auth
                                        <a href="{{ url('/dashboard') }}" class="btn btn-sm border bg-blue text-white btn-hover">Tableau de board</a>
                                        @else
                                        <a href="{{ route('login') }}" class="btn btn-sm border bg-blue text-white btn-hover shadow"><i class="bi bi-person-fill-lock"></i> Se connecter</a>
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
    </div>

    <!-- Section1 -->
    <div class="container section" id="about">
        <div class="row d-flex justify-content-center">
            <div class="col-md-8">
                <h3 class="title text-center"> <img src="{{asset('images/wifi.png')}}" alt="wifi" class="img-fluid"> Récupérer un ticket</h3>
                <p class="text-center">Lorem ipsum dolor sit amet consectetur adipisicing elit. Distinctio minus autem, error qui corporis dolorum repudiandae architecto facere laborum accusantium vitae praesentium iste, ratione, laudantium quibusdam possimus quidem. Veritatis, quae.
                    Ipsam, </p>

                <form action="{{route('getTicket')}}" method="POST">
                    @csrf
                    <div class="mb-3 rounded p-3 shadow">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <input type="number" name="number" value="{{old('number')}}" required class="form-control" placeholder="Ex : 7645879">
                                </div>
                                @error("number")
                                <div class="text-danger">{{$message}}</div>
                                @enderror
                            </div>
                        </div>
                        <button type="submit" class="btn btn-lg btn-hover bg-orange w-100"><i class="bi bi-download"></i> Télecharger</button>
                    </div>
                </form>


            </div>
        </div>
    </div>

    <!-- footer -->
    <div class="container-fluid section" id="contact" style="position: relative;">
        <div class="footer-circle"></div>
        <div class="row" id="header">
            <div class="col-md-12 content-blok">
                <div class="row">
                    <div class="col-12">
                        <h3 class="title text-center"> <img src="{{asset('images/wifi.png')}}" alt="wifi" class="img-fluid"> Contactez-nous!</h3>
                        <p class="text-center text-light">Laissez-nous un message pour plus d'informations!</p>
                    </div>
                </div>
                <br><br>
                <div class="row">
                    <div class="col-md-4 mb-2 d-flex flex-column justify-content-center align-items-center">
                        <ol class="list-group list-group-numbered">
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold">Adresse</div>
                                    Rue 313 AGP | Cotonou | Bénin
                                </div>
                                <span class="badge bg-blue rounded-pill"><i class="bi bi-geo-alt"></i></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold">Email</div>
                                    admin@gmail.com
                                </div>
                                <span class="badge bg-blue rounded-pill"><i class="bi bi-envelope-check"></i></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold">Télephone</div>
                                    +22901876543
                                </div>
                                <span class="badge bg-blue rounded-pill"><i class="bi bi-telephone-inbound"></i></span>
                            </li>
                        </ol>
                    </div>
                    <div class="col-md-8">
                        <form action="/" method="POST">
                            @csrf
                            <div class="mb-3 rounded shadow">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <input type="text" name="name" value="{{old('name')}}" class="form-control" placeholder="Nom & Prénom">
                                        </div>
                                        @error("name")
                                        <div class="text-danger">{{$message}}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <input type="email" name="email" value="{{old('email')}}" class="form-control" placeholder="name@example.com">
                                        </div>
                                        @error("email")
                                        <div class="text-danger">{{$message}}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <input type="text" name="objet" value="{{old('objet')}}" class="form-control" placeholder="Objet: Prendre un abonnment">
                                    </div>
                                    @error("objet")
                                    <div class="text-danger">{{$message}}</div>
                                    @enderror
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <input type="phone" name="phone" value="{{old('phone')}}" class="form-control" placeholder="Telephone">
                                    </div>
                                    @error("phone")
                                    <div class="text-danger">{{$message}}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <div class="col-12">
                                        <textarea name="message" value="{{old('message')}}" class="form-control" placeholder="Laissez un commentaire ici ..." rows="3"></textarea>
                                    </div>
                                    @error("message")
                                    <div class="text-danger">{{$message}}</div>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-lg btn-hover bg-orange w-100"><i class="bi bi-send-check-fill"></i> Envoyer</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <p class="text-center">@Copyright <strong class="badge bg-light text-blue border">{{date("Y")}}</strong> | Tous droits réservés | Réalisé par <strong class="badge bg-light text-blue border">Code4Christ</strong> </p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
</body>