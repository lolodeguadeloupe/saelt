@extends('front.layouts.layout')

@push('after-blocks-css')
<link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap-slider/css/bootstrap-slider.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/slick-1.8.1/slick.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/slick-1.8.1/slick-theme.css') }}">

<!--Flatpickr - datepicker css-->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush

@push('after-script-js')
<script src="{{ asset('assets/vendor/bootstrap-slider/bootstrap-slider.min.js') }}"></script>
<script src="{{ asset('assets/vendor/slick-1.8.1/slick.min.js') }}"></script>
<script src="{{ asset('assets/js/slick-script.js') }}"></script>
<script src="{{ asset('assets/js/slide-script.js') }}"></script>

<!--Flatpickr - datepicker js-->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>
    config = {
        dateFormat: "d-m-Y",
        minDate: "today"
    }

    flatpickr("input[type=datetime-local]", config);
</script>
@endpush

@section('title', trans('front-location.titre'))

@section('content')

<section class="banner page banner-overlay background-cover bg-dark pb-5 position-relative pt-5 text-white" style="background-image: {{'url(\''.asset('/assets/img/Mountain_Road.jpg').'\')'}};">
    <div class="container mt-5 pt-4">
        <div class="row">
            <div class="col-md">
                <h1 class="text-uppercase d-none">{{trans('front-location.titre')}}</h1>
            </div>
        </div>
    </div>
</section>
<aside-page-location :aside="{{$aside}}" :urlbase="'{{base_url('')}}'" :urlasset="'{{asset('')}}'" :aside="{{$aside}}" :sessionrequest="{{$session_request}}" :keysessionrequest="'{{app('request')->has('key_')?app('request')->key_:''}}'" inline-template>
    <section class="mx-5 box-search text-white">
        <div class="row justify-content-around">
            <div class="col-md-4 rounded-sm filter-search px-2 mb-4">
                <div class="filter-rent p-4 text-white">
                    <form @submit.prevent="searchData" id="search_data" class="form_customer_search">
                        <div class="text-wrap mb-4">
                            <h4>Louez votre voiture</h4>
                            <hr class="separator ml-0">
                        </div>
                        <div class="row">
                            <div class="col-md">
                                <div class="form-group">
                                    <label for="exampleFormControlSelect1">Lieu de départ</label>
                                    <select class="form-control" id="exampleFormControlSelect1" required name="lieu_recuperation" @change="selectLieu($event,lieu.recuperation)">
                                        <option value="">--Sélectionnez un lieu de départ--</option>
                                        <option v-for="recuperation of lieu.recuperation" :value="recuperation.id">@{{recuperation.name}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md">
                                <div class="form-group">
                                    <label for="exampleFormControlSelect2">Lieu de retour</label>
                                    <select class="form-control" id="exampleFormControlSelect2" required name="lieu_restriction" @change="selectLieu($event,lieu.restriction)">
                                        <option value="">--Sélectionnez un lieu de retour--</option>
                                        <option v-for="restriction of lieu.restriction" :value="restriction.id">@{{restriction.name}}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md">
                                <label for="exampleFormControlSelect3">Date et heure de départ</label>
                                <div class="row">
                                    <v-date-picker class="col-md form-group" :min-date='new Date()' :disabled-dates='calendarExclude.lieu_recuperation' v-model="lieu_recuperation">
                                        <template v-slot="{ inputValue, togglePopover }">
                                            <div class="input-group">
                                                <input class="form-control" readonly type="date" required id="exampleFormControlSelect3" style="background-color: #fff" placeholder="-- / -- / ----" name="date_recuperation" :value='parseDateToString(inputValue)'>
                                                <div class="input-group-append d-flex align-items-start mt-2" @click.prevent="togglePopover()">
                                                    <i class="fa fa-calendar" style="margin-left: -20px;z-index:5;color: black"></i>
                                                </div>
                                            </div>
                                        </template>
                                    </v-date-picker> 
                                    <vue-timepicker  required="required" tabindex="9999" class="col-md form-group" name="heure_recuperation" input-class="form-control" hide-clear-button :hour-range="heures.lieu_recuperation" :minute-interval="15" close-on-complete v-model="times_model.lieu_recuperation"></vue-timepicker>
                                </div>
                            </div>
                            <div class="col-md">
                                <label for="exampleFormControlSelect4">Date et heure de retour</label>
                                <div class="row">
                                    <v-date-picker class="col-md form-group" :min-date="$maxDate(new Date(),lieu_recuperation==''?new Date():lieu_recuperation )" :disabled-dates='calendarExclude.lieu_restriction' v-model="lieu_restriction">
                                        <template v-slot="{ inputValue, togglePopover }">
                                            <div class="input-group">
                                                <input class="form-control" readonly required type="date" id="exampleFormControlSelect4" style="background-color: #fff" placeholder="-- / -- / ----" name="date_restriction" :value='parseDateToString(inputValue)'>
                                                <div class="input-group-append d-flex align-items-start mt-2" @click.prevent="togglePopover()">
                                                    <i class="fa fa-calendar" style="margin-left: -20px;z-index:5;color: black"></i>
                                                </div>
                                            </div>
                                        </template>
                                    </v-date-picker>
                                    <vue-timepicker required="required" tabindex="9999" class="col-md form-group" name="heure_restriction" input-class="form-control" hide-clear-button :hour-range="heures.lieu_restriction" :minute-interval="15" close-on-complete v-model="times_model.lieu_restriction">
                                    </vue-timepicker> 
                                </div>
                            </div>
                        </div>

                        <div class="text-right">
                            <button type="submit" class="btn btn-primary pl-4 pr-4 rounded-sm text-white">
                                <span>Rechercher</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-8 mb-4" v-if="action_search == false && hasProduitStatus() && aside.coup_coeur[0] != undefined">
                <div class="rounded-sm py-3 featured-product">
                    <h4 class="px-3 py-1">Nos coups de cœur</h4>
                    <div class="slick-carousel slick-product rounded-sm">
                        <div v-for="(_coup_coeur,_index) in $grouperArrayRepet(aside.coup_coeur,2)">
                            <div class="justify-content-center row">
                                <div class="col-md" v-for="item_coup_coeur in _coup_coeur">
                                    <a @contextmenu.prevent="" @click.prevent="managerRequest($event,item_coup_coeur.url,{id:item_coup_coeur.id_produit})" class="d-block position-relative">
                                        <img :src="item_coup_coeur.image ? ($isBase64(item_coup_coeur.image)?item_coup_coeur.image:`${urlasset}/${item_coup_coeur.image}`) : ''" class="img-fluid w-100" style="height: 366px;">
                                        <h5>@{{item_coup_coeur.titre}}</h5>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</aside-page-location>
<section class="pt-5 pb-3 section-info-msg">
    <div class="container" style="font-size: 18px">
        <p class="text-center">Votre séjour commence ou se termine, restez Zen ! <br />
            Avec notre gamme de véhicules, de la voiture individuelle au minibus de 8/19/35/55 places, pour que votre séjour soit synonyme de tranquillité, nous effectuons vos transferts au départ ou à l’arrivée, de votre hôtel, de l’aéroport Pôles Caraïbes, ou des différents ports de Guadeloupe.
        </p>
        <hr class="separator" />
    </div>
</section>
<location :url="'{{route('locations')}}'" :urlbase="'{{base_url('')}}'" :urlasset="'{{asset('')}}'" :data="{{$data->toJson()}}" :aside="{{$aside}}" :sessionrequest="{{$session_request}}" :keysessionrequest="'{{app('request')->has('key_')?app('request')->key_:''}}'" inline-template>
    <section class="pt-4 pb-5">
        <div class="container">
            <div class="row" v-if="action_search==true && collection.length > 0">
                <div class="col-md-12">
                    <div class="h-100 d-flex pb-3 pt-3">
                        <div class="m-auto">
                            <p class="mb-0 resultat-search">Résultat correspondant à votre recherche</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 pb-3 pt-3" v-for="(item,index) in collection">
                    <div class="border">
                        <a @contextmenu.prevent="" @click.prevent="managerRequest($event,'{{ route('location-product') }}',{id:item.id,search_condition:item.search_condition})" class="d-block position-relative" style="height: 190px;"><img :src="(item.image != null && item.image[0] != undefined) ? `${urlasset}/${item.image[0].name}`:'{{asset('/assets/img/c3.jpg')}}'" class="img-fluid w-100" style="max-height: 190px;"></a>
                        <div class="pb-3 pl-4 pr-4 pt-4">
                            <div>
                                <div class="pt-1">
                                    <a @contextmenu.prevent="" @click.prevent="managerRequest($event,'{{ route('location-product') }}',{id:item.id,search_condition:item.search_condition})" class="text-dark text-decoration-none">
                                        <h5 class="mb-1 text-primary">Modèle : @{{item.modele.titre}}</h5>
                                    </a>
                                    <div class="font-size-0-8-em mt-2">
                                        <i class="fa fa-list-ul text-primary mr-1"></i>
                                        <span>@{{item.categorie.titre}}</span>
                                    </div>
                                    <div class="mt-3">
                                        <p class="font-size-0-8-em">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                                    </div>
                                </div>
                                <hr />
                                <div class="d-flex font-size-0-8-em">
                                    <div class="flex-fill text-center img-icon border-right">
                                        <img class="mr-1" src="{{asset('/assets/img/car-chair.png')}}" width="12">
                                        <span>@{{item.info_tech.nombre_place}}</span>
                                    </div>
                                    <div class="flex-fill text-center img-icon border-right">
                                        <img class="mr-1" src="{{asset('/assets/img/car-door.png')}}" width="12">
                                        <span>@{{item.info_tech.nombre_porte}}</span>
                                    </div>
                                    <div class="flex-fill text-center img-icon border-right">
                                        <img class="mr-1" src="{{asset('/assets/img/fuel.png')}}" width="12">
                                        <span>@{{item.info_tech.type_carburant}}</span>
                                    </div>
                                    <div class="flex-fill text-center img-icon">
                                        <img class="mr-1" src="{{asset('/assets/img/gearbox.png')}}" width="13">
                                        <span>@{{item.info_tech.boite_vitesse}}</span>
                                    </div>
                                </div>
                            </div>
                            <hr />
                            <div class="align-items-center d-flex justify-content-between">
                                <div>
                                    <p class="font-size-15-px text-success text-center">à partir de</br><span class="font-size-1-3-em font-weight-bold">@{{item.tarif_location.prix_vente}}&euro; (HT)</span> / jour</p>
                                </div>
                                <div>
                                    <a class="btn btn-primary text-white" @contextmenu.prevent="" @click.prevent="managerRequest($event,'{{ route('location-product') }}',{id:item.id,search_condition:item.search_condition,history_session:sessionrequest})" data-dismiss="modal">Voir l'offre</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row h-100" v-if="action_search==true && collection.length == 0">
                <div class="col-md-12 h-100">
                    <div class="border h-100 d-flex pb-3 pt-3" style="background-color:#eaeaea">
                        <div class="m-auto">
                            <p class="mb-0">Aucun résultat correspond à votre recherche</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</location>
<section class="py-5 evasion d-none">
    <div class="container">
        <div class="mb-4 text-center">
            <h2 class="text-dark text-uppercase">FORMULES EVASION</h2>
            <hr class="separator" />
        </div>
        <div class="justify-content-center row">
            <div class="col-md pb-3 pt-3">
                <div class="border">
                    <a href="#" class="d-block position-relative"><img src="https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?ixid=MXwyMDkyMnwwfDF8c2VhcmNofDY5fHxhbyUyMG5hbmd8ZW58MHx8fA&ixlib=rb-1.2.1q=85&fm=jpg&crop=faces&cs=srgb&w=350&h=240&fit=crop" class="img-fluid w-100"></a>
                    <div class="bg-white p-4">
                        <div>
                            <div class="pb-1 pt-1">
                                <a href="#" class="text-dark text-decoration-none">
                                    <h5 class="mb-1 text-primary">Pack 3 Îles</h5>
                                </a>
                                <div class="font-size-0-8-em mt-2">
                                    <i class="fa-map-marker-alt fas text-primary mr-1"></i>
                                    <span>Guadeloupe, Les Saintes, Marie-Galante</span>
                                </div>
                                <div class="mt-3">
                                    <p class="font-size-0-8-em">Les Saintes, Marie-Galante et la Grande Terre (Paysage et ...</p>
                                </div>
                            </div>
                            <div class="font-size-0-8-em">
                                <i class="fa-swimmer fas mr-1"></i>
                                <span>Baignade : belles plages de l’île bordée ...</span>
                            </div>
                            <div class="font-size-0-8-em">
                                <i class="fa-hamburger fas mr-1"></i>
                                <span>Déjeuner : déjeuner saintois au bord de l’eau</span>
                            </div>
                        </div>
                        <hr />
                        <div class="align-items-center d-flex justify-content-between">
                            <div>
                                <p class="font-size-15-px text-success">à partir de<br><span class="font-size-1-3-em font-weight-bold">227&euro;</span> / personne</p>
                            </div>
                            <div>
                                <a class="btn btn-primary text-white" href="#">Réserver</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md pb-3 pt-3">
                <div class="border">
                    <a href="#" class="d-block position-relative"><img src="https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?ixid=MXwyMDkyMnwwfDF8c2VhcmNofDY5fHxhbyUyMG5hbmd8ZW58MHx8fA&ixlib=rb-1.2.1q=85&fm=jpg&crop=faces&cs=srgb&w=350&h=240&fit=crop" class="img-fluid w-100"></a>
                    <div class="bg-white p-4">
                        <div>
                            <div class="pb-1 pt-1">
                                <a href="#" class="text-dark text-decoration-none">
                                    <h5 class="mb-1 text-primary">Pack Evasion</h5>
                                </a>
                                <div class="font-size-0-8-em mt-2">
                                    <i class="fa-map-marker-alt fas text-primary mr-1"></i>
                                    <span>Guadeloupe, Les Saintes, Marie-Galante</span>
                                </div>
                                <div class="mt-3">
                                    <p class="font-size-0-8-em">Grande-Terre (paysages et patrimoine) / Sud Basse-Terre (aventure tropicale) / Les ...</p>
                                </div>
                            </div>
                            <div class="font-size-0-8-em">
                                <i class="fa-hamburger fas mr-1"></i>
                                <span>Déjeuner : Déjeuner antillais</span>
                            </div>
                            <div class="font-size-0-8-em">
                                <i class="fa-swimmer fas mr-1"></i>
                                <span>Baignade : Baignade en cours d’excursion</span>
                            </div>
                        </div>
                        <hr />
                        <div class="align-items-center d-flex justify-content-between">
                            <div>
                                <p class="font-size-15-px text-success">à partir de<br><span class="font-size-1-3-em font-weight-bold">242&euro;</span> / personne</p>
                            </div>
                            <div>
                                <a class="btn btn-primary text-white" href="#">Réserver</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md pb-3 pt-3">
                <div class="border">
                    <a href="#" class="d-block position-relative"><img src="https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?ixid=MXwyMDkyMnwwfDF8c2VhcmNofDY5fHxhbyUyMG5hbmd8ZW58MHx8fA&ixlib=rb-1.2.1q=85&fm=jpg&crop=faces&cs=srgb&w=350&h=240&fit=crop" class="img-fluid w-100"></a>
                    <div class="bg-white p-4">
                        <div>
                            <div class="pb-1 pt-1">
                                <a href="#" class="text-dark text-decoration-none">
                                    <h5 class="mb-1 text-primary">Pack Evasion Plus</h5>
                                </a>
                                <div class="font-size-0-8-em mt-2">
                                    <i class="fa-map-marker-alt fas text-primary mr-1"></i>
                                    <span>Guadeloupe, Les Saintes, Marie-Galante</span>
                                </div>
                                <div class="mt-3">
                                    <p class="font-size-0-8-em">Grande-Terre (paysages et patrimoine) / Sud Basse-Terre (aventure tropicale) ...</p>
                                </div>
                            </div>
                            <div class="font-size-0-8-em">
                                <i class="fa-hamburger fas mr-1"></i>
                                <span>Déjeuner : Déjeuner antillais</span>
                            </div>
                            <div class="font-size-0-8-em">
                                <i class="fa-mountain fas mr-1"></i>
                                <span>Découverte : Pointe des Châteaux</span>
                            </div>
                        </div>
                        <hr />
                        <div class="align-items-center d-flex justify-content-between">
                            <div>
                                <p class="font-size-15-px text-success">à partir de<br><span class="font-size-1-3-em font-weight-bold">311&euro;</span> / personne</p>
                            </div>
                            <div>
                                <a class="btn btn-primary text-white" href="#">Réserver</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection