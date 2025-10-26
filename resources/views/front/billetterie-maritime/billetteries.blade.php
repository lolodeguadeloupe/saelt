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
        dateFormat: "d-m-Y",
        minDate: "today"
    }

    flatpickr("input[type=datetime-local]", config);
</script>
@endpush

@section('title', trans('front-billeterie.titre'))

@section('content')

<section class="banner page banner-overlay background-cover bg-dark pb-5 position-relative pt-5 text-white" style="background-image: {{'url(\''.asset('/assets/img/ct_sea-418742_1920.jpg').'\')'}};">
    <div class="container mt-5 pt-4">
        <div class="row">
            <div class="col-md">
                <h1 class="text-uppercase d-none">{{trans('front-billeterie.titre')}}</h1>
            </div>
        </div>
    </div>
</section>
<aside-page-billeterie :aside="{{$aside}}" :urlbase="'{{base_url('')}}'" :urlasset="'{{asset('')}}'" :aside="{{$aside}}" :sessionrequest="{{$session_request}}" :keysessionrequest="'{{app('request')->has('key_')?app('request')->key_:''}}'" inline-template>
    <section class="mx-5 box-search text-white">
        <div class="row justify-content-around">
            <div class="col-md-4 rounded-sm filter-search px-2 mb-4">
                <div class="filter-rent p-4 rounded-sm text-white" id="bil">
                    <form @submit.prevent="searchData" id="search_data" class="form_customer_search">
                        <div class="text-wrap mb-4">
                            <h4>{{trans('front-billeterie.reserver_billet')}}</h4>
                            <hr class="separator ml-0">
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="form-check-inline">
                                        <label class="form-check-label" for="aller-bil">
                                            <input type="radio" class="form-check-input mr-3 check-parcours" id="aller-bil" name="parcours" value="1" checked @change="checkParcours($event)">{{trans('front-billeterie.aller_simple')}}
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="form-check-inline">
                                        <label class="form-check-label" for="aller-retour-bil">
                                            <input type="radio" class="form-check-input mr-3 check-parcours aller-retour" id="aller-retour-bil" name="parcours" value="2" @change="checkParcours($event)">{{trans('front-billeterie.aller_retour')}}
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md">
                                <div class="form-group">
                                    <label for="depart">{{trans('front-billeterie.port_depart')}}</label>
                                    <select class="form-control" id="depart" name="depart" @change="selectLieu" required>
                                        <option value="">--{{trans('front-billeterie.select_port_depart')}}--</option>
                                        <optgroup :label="_depart.length?_depart[0].ville.name:''" v-for="_depart of port_depart">
                                            <option :value="_item_depart.id" v-for="_item_depart of _depart">@{{_item_depart.name}}</option>
                                        </optgroup>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md">
                                <div class="form-group">
                                    <label for="arrive">{{trans('front-billeterie.port_arrive')}}</label>
                                    <select class="form-control" id="arrive" name="arrive" required>
                                        <option value="">--{{trans('front-billeterie.select_port_arrive')}}--</option>
                                        <optgroup :label="_arrive.length?_arrive[0].ville.name:''" v-for="_arrive of port_arrive">
                                            <option :value="_item_arrive.id" v-for="_item_arrive of _arrive">@{{_item_arrive.name}}</option>
                                        </optgroup>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md">
                                <div class="form-group">
                                    <label for="date-depart">{{trans('front-billeterie.date_depart')}}</label>
                                    <v-date-picker :min-date="min_date_depart" class="col-md form-group" v-model="date_depart">
                                        <template v-slot="{ inputValue, togglePopover }">
                                            <div class="input-group">
                                                <input class="form-control" type="date" readonly required id="date-depart" style="background-color: #fff" placeholder="-- / -- / ----" name="date_depart" :value='parseDateToString(inputValue)'>
                                                <div class="input-group-append d-flex align-items-start mt-2" @click.prevent="togglePopover()">
                                                    <i class="fa fa-calendar" style="margin-left: -20px;z-index:5;color: black"></i>
                                                </div>
                                            </div>
                                        </template>
                                    </v-date-picker>
                                </div>
                            </div>
                            <div class="col-md" v-if="parcours==2">
                                <div class="form-group">
                                    <label for="date-retour">{{trans('front-billeterie.date_arrive')}}</label>
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
                                </div>
                            </div>
                        </div>
                        <label for="passagers">{{trans('front-billeterie.passagers')}}</label>
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
                                <span>{{trans('front-billeterie.rechercher')}}</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-8 mb-4" v-if="action_search ==false && hasProduitStatus() && aside.coup_coeur[0] != undefined">
                <div class="rounded-sm py-3 featured-product" >
                    <h4 class="px-3 py-1">{{trans('front-billeterie.nos_coup_coeur')}}</h4>
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
    </section>
</aside-page-billeterie>
<section class="pt-5 pb-3 section-info-msg">
    <div class="container" style="font-size: 18px">
        <p class="text-center">Vous souhaitez séjourner dans les îles de l’Arc Antillais, une semaine, un week-end ou une journée, nous vous proposons des billets de bateau pour Marie-Galante, Les Saintes, La Martinique, La Dominique, Sainte-Lucie, La Désirade au départ de la Guadeloupe.<br />
            Simplifiez-vous la vie, réservez vos billets maritimes sur un simple clic.<br />
            Nos conseillers en agence sont également à votre disposition pour répondre à vos demandes.<br />
            Les conditions générales sont celles des compagnies maritimes.
        </p>
        <hr class="separator" />
    </div>
</section>
<billeterie :url="'{{route('billetteries')}}'" :urlbase="'{{base_url('')}}'" :urlasset="'{{asset('')}}'" :data="{{$data->toJson()}}" :aside="{{$aside}}" :sessionrequest="{{$session_request}}" :keysessionrequest="'{{app('request')->has('key_')?app('request')->key_:''}}'" inline-template>
    <section class="pt-4 pb-5">
        <div class="container">
            <div class="row" v-if="action_search==true && collection.length > 0">
                <div class="col-md-12">
                    <div class="h-100 d-flex pb-3 pt-3">
                        <div class="m-auto">
                            <p class="mb-0 resultat-search">{{trans('front-billeterie.resultat_correspondant_a_votre_recherche')}}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 pb-3 pt-3" v-for="(item,index) in collection">
                    <div class="border">
                        <form :id="'billeterie-form-'+index">
                            <!-- <div class="d-block position-relative"><img src="{{asset('/assets/img/lexpressdesiles.jpg')}}" class="img-fluid w-100"></div>-->
                            <div class="py-3 pl-4 pr-4">
                                <div>
                                    <div class="row text-center border py-2 mb-3" style="background-color: #77a464;">
                                        <div class="col-md text-white hourly-title">{{trans('front-billeterie.horaires_aller')}}</div>
                                    </div>
                                    <div class="d-flex font-size-0-8-em">
                                        <div class="flex-fill text-center img-icon border-right" v-for="(horaire_item,horaire_index) in item.planing_time_aller != null?item.planing_time_aller:[]">
                                            <div class="form-check-inline">
                                                <label class="form-check-label" :for="'aller-'+index+horaire_index">
                                                    <input type="radio" class="form-check-input mr-2" :id="'aller-'+index+horaire_index" required name="heure_aller" :value="horaire_item.debut">@{{horaire_item.debut | formatTime}}
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row text-center border py-2 my-3" style="background-color: #77a464;" v-if="item.parcours == 2">
                                        <div class="col-md text-white hourly-title">{{trans('front-billeterie.horaires_retour')}}</div>
                                    </div>
                                    <div class="d-flex font-size-0-8-em" v-if="item.parcours == 2">
                                        <div class="flex-fill text-center img-icon border-right" v-for="(horaire_item,horaire_index) in item.planing_time_retour != null?item.planing_time_retour:[]">
                                            <div class="form-check-inline">
                                                <label class="form-check-label" :for="'retour-'+index+horaire_index">
                                                    <input type="radio" class="form-check-input mr-2" :id="'retour-'+index+horaire_index" required name="heure_retour" :value="horaire_item.fin">@{{horaire_item.fin | formatTime}}
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr />
                                <div class="align-items-center d-flex justify-content-between">
                                    <div>
                                        <p class="font-size-15-px font-weight-bold text-success mb-0">{{trans('front-billeterie.prix_total')}}</p>
                                        <p class="font-size-15-px text-success mb-0"> <span class="font-size-1-3-em font-weight-bold">@{{item.parcours == 2? item.tarif_calculer.aller_retour: item.tarif_calculer.aller}}&euro;</span></p>
                                    </div>
                                    <div @click.prevent="validerCommander($event,item,'billeterie-form-'+index)" :id-commande="item.id" :reference-prix="item.reference_prix" :titre-commande="item.titre" :image-commande="item.image? item.image:'assets/img/bubble.png'" :produit-url="url">
                                        <a @contextmenu.prevent="" class="btn btn-primary text-white text-uppercase" href="#" data-dismiss="modal">{{trans('front-billeterie.reserver')}}</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-md-12 h-100" v-if="action_search==true && collection.length == 0">
                    <div class="border h-100 d-flex pb-3 pt-3" style="background-color:#eaeaea">
                        <div class="m-auto">
                            <p class="mb-0">{{trans('front-billeterie.aucun_resultat_correspond_a_votre_recherche')}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</billeterie>

@endsection