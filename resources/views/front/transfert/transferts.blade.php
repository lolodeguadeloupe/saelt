@extends('front.layouts.layout')

@push('after-blocks-css')
<link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap-slider/css/bootstrap-slider.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/slick-1.8.1/slick.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/slick-1.8.1/slick-theme.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/style-single-product.css') }}">

<!--Flatpickr - datepicker css-->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush

@push('after-script-js')
<script src="{{ asset('assets/vendor/bootstrap-slider/bootstrap-slider.min.js') }}"></script>
<script src="{{ asset('assets/vendor/slick-1.8.1/slick.min.js') }}"></script>
<script src="{{ asset('assets/js/slick-script.js') }}"></script>
<script src="{{ asset('assets/js/slide-script.js') }}"></script>
<script src="{{ asset('assets/js/return.trip.check.js') }}"></script>

<!--Flatpickr - datepicker js-->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>
    config = {
        dateFormat: "d / m / Y",
        minDate: "today"
    }

    flatpickr("input[type=datetime-local]", config);
</script>
@endpush

@section('title', trans('front-transfert.titre'))

@section('content')

<section class="banner page banner-overlay background-cover bg-dark pb-5 position-relative pt-5 text-white" style="background-image: {{'url(\''.asset('/assets/img/ct_sea-418742_1920.jpg').'\')'}};">
    <div class="container mt-5 pt-4">
        <div class="row">
            <div class="col-md">
                <h1 class="text-uppercase d-none">{{trans('front-transfert.titre')}}</h1>
            </div>
        </div>
    </div>
</section>
<aside-page-transfert :aside="{{$aside}}" :urlbase="'{{base_url('')}}'" :urlasset="'{{asset('')}}'" :aside="{{$aside}}" :sessionrequest="{{$session_request}}" :keysessionrequest="'{{app('request')->has('key_')?app('request')->key_:''}}'" inline-template>
    <section class="mx-5 box-search text-white">
        <div class="row justify-content-around">
            <div class="col-md-4 rounded-sm filter-search px-2 mb-4">
                <div class="filter-rent p-4 text-white" id="trans">
                    <form @submit.prevent="searchData" id="search_data" class="form_customer_search">
                        <div class="text-wrap mb-4">
                            <h4>Réservez votre transfert</h4>
                            <hr class="separator ml-0">
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="form-check-inline">
                                        <label class="form-check-label" for="aller-trans">
                                            <input type="radio" class="form-check-input mr-3 check-parcours" id="aller-trans" name="parcours" value="1" checked @change="checkParcours($event)">Aller Simple
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="form-check-inline">
                                        <label class="form-check-label" for="aller-retour-trans">
                                            <input type="radio" class="form-check-input mr-3 check-parcours aller-retour" id="aller-retour-trans" name="parcours" value="2" @change="checkParcours($event)">Aller / Retour
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md">
                                <div class="form-group">
                                    <label for="depart">Lieu de départ</label>
                                    <select class="form-control" id="depart" name="depart" @change="selectLieu" required>
                                        <option value="">--Sélectionnez un lieu de départ--</option>
                                        <optgroup :label="_depart.length?_depart[0].ville.name:''" v-for="_depart of lieu_depart">
                                            <option :value="_item_depart.id" v-for="_item_depart of _depart">@{{_item_depart.titre}}</option>
                                        </optgroup>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md">
                                <div class="form-group">
                                    <label for="retour">Lieu d'arrivée</label>
                                    <select class="form-control" id="retour" name="retour" required>
                                        <option value="">--Sélectionnez un lieu d'arrivée--</option>
                                        <optgroup :label="_arrive.length?_arrive[0].ville.name:''" v-for="_arrive of lieu_arrive">
                                            <option :value="_item_arrive.id" v-for="_item_arrive of _arrive">@{{_item_arrive.titre}}</option>
                                        </optgroup>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md">
                                <label for="date-depart">Date et heure de départ</label>
                                <div class="row">
                                    <v-date-picker :min-date="min_date_depart" class="col-md form-group" v-model="date_depart">
                                        <template v-slot="{ inputValue, togglePopover }">
                                            <div class="input-group">
                                                <input class="form-control" type="date" readonly required id="date-retour" style="background-color: #fff" placeholder="-- / -- / ----" name="date_depart" :value='parseDateToString(inputValue)'>
                                                <div class="input-group-append d-flex align-items-start mt-2" @click.prevent="togglePopover()">
                                                    <i class="fa fa-calendar" style="margin-left: -20px;z-index:5;color: black"></i>
                                                </div>
                                            </div>
                                        </template>
                                    </v-date-picker>
                                    <vue-timepicker required="required" tabindex="9999" class="col-md form-group" id="time-depart" name="heure_depart" input-class="form-control" hide-clear-button :hour-range="heure_depart" :minute-interval="15" close-on-complete v-model="times_model.heure_depart"></vue-timepicker>
                                </div>
                            </div>
                            <div class="col-md" v-if="parcours==2">
                                <label for="date-retour">Date et heure de retour</label>
                                <div class="row">
                                    <v-date-picker :min-date="min_date_arrive" class="col-md form-group" v-model="date_arrive">
                                        <template v-slot="{ inputValue, togglePopover }">
                                            <div class="input-group">
                                                <input class="form-control" type="date" readonly required id="date-retour" style="background-color: #fff" placeholder="-- / -- / ----" name="date_retour" :value='parseDateToString(inputValue)'>
                                                <div class="input-group-append d-flex align-items-start mt-2" @click.prevent="togglePopover()">
                                                    <i class="fa fa-calendar" style="margin-left: -20px;z-index:5;color: black"></i>
                                                </div>
                                            </div>
                                        </template>
                                    </v-date-picker>
                                    <vue-timepicker required="required" tabindex="9999" class="col-md form-group" id="time-retour" name="heure_retour" input-class="form-control" hide-clear-button :hour-range="heure_retour" :minute-interval="15" close-on-complete v-model="times_model.heure_retour"></vue-timepicker>
                                </div>
                            </div>
                        </div>
                        <label for="passagers">Passagers</label>
                        <div class="row">
                            <div class="col-md" v-for=" (_personne,_index) in aside.personne?aside.personne:[]">
                                <div class="form-group">
                                    <label :for="'personne_'+_personne.id">@{{_personne.type}}</label>
                                    <input class="form-control" type="number" required step="1" :min="_personne.id == 1 ? 1 : 0" :value="_personne.id == 1 ? 1 : 0" :name="'personne_'+_personne.id">
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
            <div class="col-md-8 mb-4" v-if="action_search ==false && hasProduitStatus() && aside.coup_coeur[0] != undefined">
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
</aside-page-transfert>

<section class="pt-5 pb-3 section-info-msg">
    <div class="container" style="font-size: 18px">
        <p class="text-center">Votre séjour commence ou se termine, restez Zen ! <br />
            Avec notre gamme de véhicules, de la voiture individuelle au minibus de 8/19/35/55 places, pour que votre séjour soit synonyme de tranquillité, nous effectuons vos transferts au départ ou à l’arrivée, de votre hôtel, de l’aéroport Pôles Caraïbes, ou des différents ports de Guadeloupe.
        </p>
        <hr class="separator" />
    </div>
</section>
<transfert :url="'{{route('transferts')}}'" :urlbase="'{{base_url('')}}'" :urlasset="'{{asset('')}}'" :data="{{$data->toJson()}}" :aside="{{$aside}}" :sessionrequest="{{$session_request}}" :keysessionrequest="'{{app('request')->has('key_')?app('request')->key_:''}}'" inline-template>
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
                        <div class="d-block position-relative" style="height: 190px;"><img :src="(item.vehicule && item.vehicule[0] != undefined && item.vehicule[0].image[0] != undefined)? `${urlasset}/${item.vehicule[0].image[0].name}`:'{{asset('/assets/img/nissan.jpg')}}'" class="img-fluid w-100" style="max-height: 190px;"></div>
                        <div class="pb-3 pl-4 pr-4">
                            <hr />
                            <div class="mb-3">
                                <h5 class="mb-1 text-primary">@{{item.titre}}</h5>
                                <h5 class="mb-1 text-primary text-center d-none">@{{item.lieu_depart.adresse?item.lieu_depart.adresse:item.lieu_depart.titre}} - @{{item.lieu_retour.adresse?item.lieu_retour.adresse:item.lieu_retour.titre}}</h5>
                            </div>
                            <hr />
                            <div class="aller text-uppercase">
                                <h6>Aller</h6>
                            </div>
                            <div class="transfert-detail aller">
                                <div class="port-depart pb-2">
                                    <i class="fa fa-ship d-inline mr-2" aria-hidden="true"></i>
                                    <p class="d-inline text-uppercase" style="letter-spacing: 1px;"> <span class="text-success font-weight-bold">Départ : </span> @{{item.lieu_depart.adresse?item.lieu_depart.adresse:item.lieu_depart.titre}}</p>
                                </div>
                                <div class="port-depart pb-2">
                                    <i class="fa fa-ship d-inline mr-2" aria-hidden="true"></i>
                                    <p class="d-inline text-uppercase" style="letter-spacing: 1px;"> <span class="text-success font-weight-bold">Arrivée : </span> @{{item.lieu_retour.adresse?item.lieu_retour.adresse:item.lieu_retour.titre}}</p>
                                </div>
                                <div class=" d-flex">
                                    <div class="date-depart pb-1 flex-fill">
                                        <i class="fa fa-calendar d-inline mr-2" aria-hidden="true"></i>
                                        <p class="d-inline" style="letter-spacing: 1px;">@{{item.date_depart}}</p>
                                    </div>
                                    <div class="heure-depart pb-1 flex-fill">
                                        <i class="fas fa-clock d-inline mr-2"></i>
                                        <p class="d-inline" style="letter-spacing: 1px;">@{{item.heure_depart | formatTime}}</p>
                                    </div>
                                </div>
                                <div class="pb-2" v-if="item.prime_depart>0">
                                    <i class="fa fa-ticket-alt d-inline mr-2" aria-hidden="true"></i>
                                    <p class="d-inline text-uppercase" style="letter-spacing: 1px;"> <span class="text-success font-weight-bold">Prime nuit : </span> @{{item.prime_depart}}€</p>
                                </div>
                            </div>
                            <hr />
                            <div class="aller text-uppercase" v-if="item.parcours == 2">
                                <h6>Retour</h6>
                            </div>
                            <div class="transfert-detail" v-if="item.parcours == 2">
                                <div class="port-depart pb-2">
                                    <i class="fa fa-ship d-inline mr-2" aria-hidden="true"></i>
                                    <p class="d-inline text-uppercase" style="letter-spacing: 1px;"> <span class="text-success font-weight-bold">Départ : </span> @{{item.lieu_retour.adresse?item.lieu_retour.adresse:item.lieu_retour.titre}}</p>
                                </div>
                                <div class="port-depart pb-2">
                                    <i class="fa fa-ship d-inline mr-2" aria-hidden="true"></i>
                                    <p class="d-inline text-uppercase" style="letter-spacing: 1px;"> <span class="text-success font-weight-bold">Arrivée : </span> @{{item.lieu_depart.adresse?item.lieu_depart.adresse:item.lieu_depart.titre}}</p>
                                </div>
                                <div class=" d-flex">
                                    <div class="date-depart pb-1 flex-fill">
                                        <i class="fa fa-calendar d-inline mr-2" aria-hidden="true"></i>
                                        <p class="d-inline" style="letter-spacing: 1px;">@{{item.date_retour}}</p>
                                    </div>
                                    <div class="heure-depart pb-1 flex-fill">
                                        <i class="fas fa-clock d-inline mr-2"></i>
                                        <p class="d-inline" style="letter-spacing: 1px;">@{{item.heure_retour | formatTime}}</p>
                                    </div>
                                </div>
                                <div class="pb-2" v-if="item.prime_retour>0">
                                    <i class="fa fa-ticket-alt d-inline mr-2" aria-hidden="true"></i>
                                    <p class="d-inline text-uppercase" style="letter-spacing: 1px;"> <span class="text-success font-weight-bold">Prime nuit : </span> @{{item.prime_retour}}€</p>
                                </div>
                            </div>
                            <hr v-if="item.parcours == 2"/>
                            <div class="passager text-uppercase">
                                <h6>Passagers</h6>
                            </div>
                            <div class="transfert-detail-passager">
                                <div class=" d-flex flex-column">
                                    <div class="flex-fill" v-for="_personne of item.personne">
                                        <p class="mb-2" style="letter-spacing: 1px;">@{{_personne.type}} <span class="text-lowercase"> @{{_personne.age}}</span> : <span class="font-weight-bold">@{{_personne.nb}}</span></p>
                                    </div>
                                </div>
                            </div>
                            <hr />
                            <div class="align-items-center d-flex justify-content-between">
                                <div style="display: flex; flex-direction: column; align-items: center;">
                                    <p class="font-size-15-px text-success mb-0"><Span class="font-weight-bold">Prix : </Span><span class="font-size-1-3-em font-weight-bold">@{{item.parcours == 2? item.tranche.tarif_calculer.aller_retour: item.tranche.tarif_calculer.aller}}&euro;</span></p>
                                </div>
                                <div @click.prevent="validerCommander($event,item)" :id-commande="item.id" :reference-prix="item.tranche.reference_prix" :titre-commande="item.titre" :image-commande="(item.vehicule && item.vehicule[0] != undefined && item.vehicule[0].image[0] != undefined)? `${item.vehicule[0].image[0].name}`:'/assets/img/nissan.jpg'" :produit-url="url">
                                    <a @contextmenu.prevent="" class="btn btn-primary text-white" href="#" data-dismiss="modal">Reservez</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 h-100" v-if="action_search==true && collection.length == 0">
                    <div class="border h-100 d-flex pb-3 pt-3" style="background-color:#eaeaea">
                        <div class="m-auto">
                            <p class="mb-0">Aucun résultat correspond à votre recherche</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</transfert>

@endsection