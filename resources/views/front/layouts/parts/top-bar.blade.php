<header-bar-front :url="'{{base_url('')}}'" :urlbase="'{{base_url('')}}'" :urlasset="'{{asset('')}}'" :aside="{{isset($aside)?$aside:json_encode(['test'=>'test'])}}" :sessionrequest="{{isset($session_request)?$session_request:json_encode(['test'=>'test'])}}" :keysessionrequest="'{{app('request')->has('key_')?app('request')->key_:''}}'" inline-template>
    <nav class="fixed-top navbar navbar-dark navbar-expand-lg navbar-top">
        <div class="container-fluid text-uppercase">
            <a class="font-weight-bold navbar-brand" href="{{ route('home') }}">
                <img src="{{logo()}}" width="250">
                <div class="slogan">Agence de voyages & Réceptif Antilles & Caraïbes</div>
            </a>
            <ul class="align-items-lg-center flex-row ml-auto mr-2 mr-lg-0 navbar-nav order-lg-2">
                <li class="icon-right ml-2 nav-item">
                    <a class="btn rounded-pill" style="background-color:#3a919f; color:#fff" href="{{ route('panier') }}"><i class="fa-shopping-bag fas"></i></a>
                    <span v-if="count_commande>0" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-info text-white" style="left: 80%;">
                        @{{count_commande}}
                    </span>
                </li>
            </ul>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown-3" aria-controls="navbarNavDropdown-3" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown-3">
                <div>
                    <!--<div class="alert alert-warning" role="alert">
                        A simple warning alert—check it out!
                    </div>-->
                    <ul class="navbar-nav ">
                        <li class="mx-lg-1 nav-item {{ Route::is('home') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('home') }}">Accueil</a>
                        </li>
                        <li v-if="aside.produit.hebergement.status == 1" class="mx-lg-1 nav-item {{ (Route::is('hebergements') ||  Route::is('hebergement-product-avec-vol') || Route::is('hebergement-product-sans-vol') || Route::is('hebergement-host') || Route::is('hebergement-all-hosts')) ? 'active' : '' }} dropdown">
                            <a class="nav-link" href="{{ route('hebergements') }}" id="hebergement" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Hébergements</a>
                            <div class="dropdown-menu font-size-0-8-em m-0 p-0 rounded-0" aria-labelledby="hebergement" v-if="aside.ile && aside.ile.length > 0">
                                <a class="dropdown-item py-2 px-3" @click.prevent="managerRequest($event,'{{ route('hebergement-all-hosts') }}',{ile:item.id})" href="#" v-for="item of (aside.ile?aside.ile:[])">@{{item.name}}</a>
                            </div>
                        </li>
                        <li v-if="aside.produit.excursion.status == 1" class="mx-lg-1 nav-item {{ (Route::is('excursions') || Route::is('excursion-product') || Route::is('excursion-all-products')) ? 'active' : '' }} dropdown">
                            <a class="nav-link" href="{{ route('excursions') }}" id="excursion" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Excursions</a>
                            <div class="dropdown-menu font-size-0-8-em m-0 p-0 rounded-0" aria-labelledby="excursion" v-if="aside.ile && aside.ile.length > 0">
                                <a class="dropdown-item py-2 px-3" @click.prevent="managerRequest($event,'{{ route('excursion-all-products') }}',{ile:item.id})" href="#" v-for="item of (aside.ile?aside.ile:[])">@{{item.name}}</a>
                            </div>
                        </li>
                        <li v-if="aside.produit.location.status == 1" class="mx-lg-1 nav-item {{ (Route::is('locations') || Route::is('location-product')) ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('locations') }}">Location de voitures</a>
                        </li>
                        <li v-if="aside.produit.billetterie.status == 1" class="mx-lg-1 nav-item {{ Route::is('billetteries') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('billetteries') }}">Billetterie maritime</a>
                        </li>
                        <li v-if="aside.produit.transfert.status == 1" class="mx-lg-1 nav-item {{ Route::is('transferts')? 'active' : '' }}">
                            <a class="nav-link" href="{{route('transferts')}}">Transferts</a>
                        </li>
                        <!--li class="mx-lg-1 nav-item">
                        <a class="nav-link" href="#">Formules évasions</a>
                    </li>
                    <li class="mx-lg-1 nav-item">
                        <a class="nav-link" href="#">Devis</a>
                    </li-->
                        <li class="mx-lg-1 nav-item">
                            <a class="nav-link" href="#">Contact</a>
                        </li>
                    </ul>
                </div>
                <ul class="align-items-lg-center ml-auto navbar-nav">
                    @guest
                    <li class="icon-right nav-item dropdown">
                        <!--{{ Route::is('login') ? 'active' : '' }}-->
                        <a class="nav-link" href="#" id="sign" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa-lg fa-user-circle far"></i></a>
                        <div class="dropdown-menu sign font-size-0-8-em m-0 p-0 rounded-0" aria-labelledby="sign">
                            <a class="dropdown-item py-2 px-3" href="{{ route('login') }}"><i class="fa-lg fa-user-circle far mr-2"></i>Se connecter</a>
                            <a class="dropdown-item py-2 px-3" href="{{ route('register') }}"><i class="fa-lg fa-user-circle fas mr-2"></i>S'inscrire</a>
                        </div>
                    </li>
                    <!--li class="nav-item">
                    <a class="nav-link active" href="{{ route('register') }}"><i class="fa-lg fa-user-circle fas mr-2"></i>S'inscrire</a>
                </li-->
                    @else
                    <li class="nav-item">
                        <a class="nav-link" href="#" onclick="document.getElementById('logout-form').submit();">
                            <i class="fa-lg fa-sign-out-alt fas mr-2"></i>Se déconnecter</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>
</header-bar-front>