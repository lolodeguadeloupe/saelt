@extends('front.layouts.layout')

@push('after-blocks-css')
<link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap-slider/css/bootstrap-slider.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/slick-1.8.1/slick.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/slick-1.8.1/slick-theme.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/style-single-product.css') }}">
@endpush

@push('after-script-js')
<script src="{{ asset('assets/vendor/bootstrap-slider/bootstrap-slider.min.js') }}"></script>
<script src="{{ asset('assets/vendor/slick-1.8.1/slick.min.js') }}"></script>
<script src="{{ asset('assets/js/slick-script.js') }}"></script>
<script src="{{ asset('assets/js/slide-script.js') }}"></script>
<script src="{{ asset('assets/js/return.trip.check.js') }}"></script>
@endpush

@section('title', 'Saelt voyages')

@section('content')

<section class="slide-carousel background-cover bg-dark pb-5 position-relative text-white" style="background-image:url('https://images.unsplash.com/photo-1533130061792-64b345e4a833?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=MXwyMDkyMnwwfDF8c2VhcmNofDY2fHxtdXN0YW5nJTIwbmVwYWx8ZW58MHx8fA&ixlib=rb-1.2.1&q=80&w=1080');">
    <div class="mx-5 mt-5" style="min-height: 200px;">
        <aside-page :aside="{{$aside}}" :urlbase="'{{base_url('')}}'" :urlasset="'{{asset('')}}'" :aside="{{$aside}}" :sessionrequest="{{$session_request}}" :keysessionrequest="'{{app('request')->has('key_')?app('request')->key_:''}}'" inline-template>
            <div class="search-bar container-box center">
                <div class="row justify-content-around" v-if="hasProduitStatus()">
                    <!--Recherche tab-->
                    <div class="col-md-4 filter-search rounded-sm px-2 mb-4">
                        <div class="search-group">
                            <ul class="nav nav-pills nav-justified pt-1 mb-4 text-white">
                                <li v-if="aside.produit.hebergement.status == 1" class="nav-item"><a @contextmenu.prevent="" class="text-white nav-link" style="border-bottom: 2px solid #ffffff50" role="tab" data-toggle="tab" href="#heb">{{trans('front-home.hebergements')}}</a></li>
                                <li v-if="aside.produit.excursion.status == 1" class="nav-item"><a @contextmenu.prevent="" class="text-white nav-link" style="border-bottom: 2px solid #ffffff50" role="tab" data-toggle="tab" href="#exc">{{trans('front-home.excursions')}}</a></li>
                                <li v-if="aside.produit.location.status == 1" class="nav-item"><a @contextmenu.prevent="" class="text-white nav-link" style="border-bottom: 2px solid #ffffff50" role="tab" data-toggle="tab" href="#loc">{{trans('front-home.voitures')}}</a></li>
                                <li v-if="aside.produit.billetterie.status == 1" class="nav-item"><a @contextmenu.prevent="" class="text-white nav-link" style="border-bottom: 2px solid #ffffff50" role="tab" data-toggle="tab" href="#bil">{{trans('front-home.bateaux')}}</a></li>
                                <li v-if="aside.produit.transfert.status == 1" class="nav-item"><a @contextmenu.prevent="" class="text-white nav-link" style="border-bottom: 2px solid #ffffff50" role="tab" data-toggle="tab" href="#trans">{{trans('front-home.transferts')}}</a></li>
                            </ul>

                            <div class="tab-content mx-3 mb-3">
                                <div v-if="aside.produit.hebergement.status == 1" class="tab-pane fade show" role="tabpanel" aria-labelledby="heb-tab" id="heb">
                                    <form @submit.prevent="searchDataHome" action="{{route('hebergement-all-hosts')}}" class="form_customer_search">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="iles_heb">{{trans('front-hebergement.destination')}}</label>
                                                    <select class="form-control" name="ile" id="iles_heb" @change="changeIle" required>
                                                        <option v-if="aside.ile" :value="$getKey(aside.ile,'id')">{{trans('admin-base.filter.all')}}</option>
                                                        <option v-for="item of (aside.ile?aside.ile:[])" :value="item.id">@{{item.name}}</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="ville-heb">Ville</label>
                                                    <select class="form-control" id="ville-heb" name="ville" required>
                                                        <option v-if="ville" :value="$getKey(ville,'id')">{{trans('admin-base.filter.all')}}</option>
                                                        <option v-for="item of ville" :value="item.id">@{{item.name}}</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md">
                                                <div class="form-group">
                                                    <label for="date-debut-heb">{{trans('front-hebergement.date_debut')}}</label>
                                                    <v-date-picker :min-date="new Date()" v-model="date_debut">
                                                        <template v-slot="{ inputValue, togglePopover }">
                                                            <div class="input-group">
                                                                <input v-if="inputValue == ''" class="form-control" readonly type="date" required id="date-debut-heb" style="background-color: #fff" placeholder="-- / -- / ----" name="date_debut" value="">
                                                                <input v-if="inputValue != ''" class="form-control" readonly type="date" required id="date-debut-heb" style="background-color: #fff" placeholder="-- / -- / ----" name="date_debut" :value='parseDateToString(inputValue)'>
                                                                <div class="input-group-append d-flex align-items-start mt-2" @click.prevent="togglePopover()">
                                                                    <i class="fa fa-calendar" style="margin-left: -20px;z-index:5;color: black"></i>
                                                                </div>
                                                            </div>
                                                        </template>
                                                    </v-date-picker>
                                                </div>
                                            </div>
                                            <div class="col-md">
                                                <div class="form-group">
                                                    <label for="date-fin-heb">{{trans('front-hebergement.date_fin')}}</label>
                                                    <v-date-picker :min-date="(date_debut==''?new Date(): date_debut)" :value="''">
                                                        <template v-slot="{ inputValue, togglePopover }">
                                                            <div class="input-group">
                                                                <input v-if="inputValue == ''" class="form-control" readonly type="date" required id="date-fin-heb" style="background-color: #fff" placeholder="-- / -- / ----" name="date_fin" value="">
                                                                <input v-if="inputValue != ''" class="form-control" readonly type="date" required id="date-fin-heb" style="background-color: #fff" placeholder="-- / -- / ----" name="date_fin" :value='parseDateToString(inputValue)'>
                                                                <div class="input-group-append d-flex align-items-start mt-2" @click.prevent="togglePopover()">
                                                                    <i class="fa fa-calendar" style="margin-left: -20px;z-index:5;color: black"></i>
                                                                </div>
                                                            </div>
                                                        </template>
                                                    </v-date-picker>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="text-right">
                                            <button type="submit" class="btn btn-primary pl-4 pr-4 rounded-sm text-white">
                                                <span>{{trans('front-hebergement.rechercher')}}</span>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                                <div v-if="aside.produit.excursion.status == 1" class="tab-pane fade" role="tabpanel" aria-labelledby="exc-tab" id="exc">
                                    <form @submit.prevent="searchDataHome" action="{{route('excursion-all-products')}}" class="form_customer_search">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="iles_exc">{{trans('front-excursion.destination')}}</label>
                                                    <select class="form-control" name="ile" id="iles_exc" @change="changeIle" required>
                                                        <option v-if="aside.ile" :value="$getKey(aside.ile,'id')">{{trans('admin-base.filter.all')}}</option>
                                                        <option v-for="item of (aside.ile?aside.ile:[])" :value="item.id">@{{item.name}}</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="ville-exc">{{trans('front-excursion.ville')}}</label>
                                                    <select class="form-control" id="ville-exc" name="ville" required>
                                                        <option v-if="ville" :value="$getKey(ville,'id')">{{trans('admin-base.filter.all')}}</option>
                                                        <option v-for="item of ville" :value="item.id">@{{item.name}}</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md">
                                                <div class="form-group">
                                                    <label for="date-debut-exc">{{trans('front-excursion.date_debut')}}</label>
                                                    <v-date-picker :min-date="new Date()" v-model="date_debut">
                                                        <template v-slot="{ inputValue, togglePopover }">
                                                            <div class="input-group">
                                                                <input class="form-control" readonly type="date" required id="date-debut-exc" style="background-color: #fff" placeholder="-- / -- / ----" name="date_debut" :value='parseDateToString(inputValue)'>
                                                                <div class="input-group-append d-flex align-items-start mt-2" @click.prevent="togglePopover()">
                                                                    <i class="fa fa-calendar" style="margin-left: -20px;z-index:5;color: black"></i>
                                                                </div>
                                                            </div>
                                                        </template>
                                                    </v-date-picker>
                                                </div>
                                            </div>
                                            <div class="col-md">
                                                <div class="form-group">
                                                    <label for="date-fin-exc">{{trans('front-excursion.date_fin')}}</label>
                                                    <v-date-picker :min-date="(date_debut==''?new Date(): date_debut)" :value="''">
                                                        <template v-slot="{ inputValue, togglePopover }">
                                                            <div class="input-group">
                                                                <input class="form-control" readonly type="date" required id="date-fin-exc" style="background-color: #fff" placeholder="-- / -- / ----" name="date_fin" :value='parseDateToString(inputValue)'>
                                                                <div class="input-group-append d-flex align-items-start mt-2" @click.prevent="togglePopover()">
                                                                    <i class="fa fa-calendar" style="margin-left: -20px;z-index:5;color: black"></i>
                                                                </div>
                                                            </div>
                                                        </template>
                                                    </v-date-picker>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <button type="submit" class="btn btn-primary pl-4 pr-4 rounded-sm text-white">
                                                <span>{{trans('front-excursion.rechercher')}}</span>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                                <div v-if="aside.produit.location.status == 1" class="tab-pane fade" role="tabpanel" aria-labelledby="loc-tab" id="loc">
                                    <form @submit.prevent="searchDataHome" action="{{route('locations')}}" class="form_customer_search">
                                        <div class="row">
                                            <div class="col-md">
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1">{{trans('front-location.lieu_depart')}}</label>
                                                    <select class="form-control" id="exampleFormControlSelect1" required name="lieu_recuperation" @change="selectLieuLocation($event,(aside && aside.agence_location)?aside.agence_location:[])">
                                                        <option value="">--{{trans('front-location.selectionnez_lieu_depart')}}--</option>
                                                        <option v-for="recuperation of (aside && aside.agence_location)?aside.agence_location:[]" :value="recuperation.id">@{{recuperation.name}}</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md">
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect2">{{trans('front-location.lieu_retour')}}</label>
                                                    <select class="form-control" id="exampleFormControlSelect2" required name="lieu_restriction" @change="selectLieuLocation($event,(aside && aside.agence_location)?aside.agence_location:[])">
                                                        <option value="">--{{trans('front-location.selectionnez_lieu_retour')}}--</option>
                                                        <option v-for="restriction of (aside && aside.agence_location)?aside.agence_location:[]" :value="restriction.id">@{{restriction.name}}</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md">
                                                <label for="exampleFormControlSelect3">{{trans('front-location.date_et_heure_depart')}}</label>
                                                <div class="row">
                                                    <v-date-picker class="col-md form-group" :min-date="new Date()" :disabled-dates='calendarExclude.lieu_recuperation_location' v-model="lieu_recuperation_location">
                                                        <template v-slot="{ inputValue, togglePopover }">
                                                            <div class="input-group">
                                                                <input class="form-control" readonly type="date" required id="exampleFormControlSelect3" style="background-color: #fff" placeholder="-- / -- / ----" name="date_recuperation" :value='parseDateToString(inputValue)'>
                                                                <div class="input-group-append d-flex align-items-start mt-2" @click.prevent="togglePopover()">
                                                                    <i class="fa fa-calendar" style="margin-left: -20px;z-index:5;color: black"></i>
                                                                </div>
                                                            </div>
                                                        </template>
                                                    </v-date-picker>
                                                    <vue-timepicker required="required" tabindex="9999" class="col-md form-group" name="heure_recuperation" input-class="form-control" hide-clear-button :hour-range="heures.lieu_recuperation_location" :minute-interval="15" close-on-complete v-model="times_model.lieu_recuperation_location"></vue-timepicker>
                                                </div>
                                            </div>
                                            <div class="col-md">
                                                <label for="exampleFormControlSelect4">{{trans('front-location.date_et_heure_retour')}}</label>
                                                <div class="row">
                                                    <v-date-picker class="col-md form-group" :min-date="lieu_recuperation_location == '' ? new Date() : lieu_recuperation_location" :disabled-dates='calendarExclude.lieu_restriction_location' v-model="lieu_restriction_location">
                                                        <template v-slot="{ inputValue, togglePopover }">
                                                            <div class="input-group">
                                                                <input class="form-control" readonly required type="date" id="exampleFormControlSelect4" style="background-color: #fff" placeholder="-- / -- / ----" name="date_restriction" :value='parseDateToString(inputValue)'>
                                                                <div class="input-group-append d-flex align-items-start mt-2" @click.prevent="togglePopover()">
                                                                    <i class="fa fa-calendar" style="margin-left: -20px;z-index:5;color: black"></i>
                                                                </div>
                                                            </div>
                                                        </template>
                                                    </v-date-picker>
                                                    <vue-timepicker required="required" tabindex="9999" class="col-md form-group" name="heure_restriction" input-class="form-control" hide-clear-button :hour-range="heures.lieu_restriction_location" :minute-interval="15" close-on-complete v-model="times_model.lieu_restriction_location">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="text-right">
                                            <button type="submit" class="btn btn-primary pl-4 pr-4 rounded-sm text-white">
                                                <span>{{trans('front-location.rechercher')}}</span>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                                <div v-if="aside.produit.billetterie.status == 1" class="tab-pane fade" role="tabpanel" aria-labelledby="bil-tab" id="bil">
                                    <form @submit.prevent="searchDataHome" action="{{route('billetteries')}}" class="form_customer_search">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <div class="form-check-inline">
                                                        <label class="form-check-label" for="aller-bil">
                                                            <input type="radio" class="form-check-input mr-3 check-parcours" id="aller-bil" name="parcours" value="1" checked @change="checkParcoursBillet($event)">{{trans('front-billeterie.aller_simple')}}
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <div class="form-check-inline">
                                                        <label class="form-check-label" for="aller-retour-bil">
                                                            <input type="radio" class="form-check-input mr-3 check-parcours aller-retour" id="aller-retour-bil" name="parcours" value="2" @change="checkParcoursBillet($event)">{{trans('front-billeterie.aller_retour')}}
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md">
                                                <div class="form-group">
                                                    <label for="depart-bil">{{trans('front-billeterie.port_depart')}}</label>
                                                    <select class="form-control" id="depart-bil" name="depart" @change="selectPort" required>
                                                        <option value="">--{{trans('front-billeterie.select_port_depart')}}--</option>
                                                        <optgroup :label="_depart.length?_depart[0].ville.name:''" v-for="_depart of port_depart">
                                                            <option :value="_item_depart.id" v-for="_item_depart of _depart">@{{_item_depart.name}}</option>
                                                        </optgroup>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md">
                                                <div class="form-group">
                                                    <label for="arrive-bil">{{trans('front-billeterie.port_arrive')}}</label>
                                                    <select class="form-control" id="arrive-bil" name="arrive" required>
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
                                                    <label for="date-depart-bil">{{trans('front-billeterie.date_depart')}}</label>
                                                    <v-date-picker :min-date="min_date_depart_billet" class="col-md form-group" v-model="date_depart_billet">
                                                        <template v-slot="{ inputValue, togglePopover }">
                                                            <div class="input-group">
                                                                <input class="form-control" type="date" readonly required id="date-depart-bil" style="background-color: #fff" placeholder="-- / -- / ----" name="date_depart" :value='parseDateToString(inputValue)'>
                                                                <div class="input-group-append d-flex align-items-start mt-2" @click.prevent="togglePopover()">
                                                                    <i class="fa fa-calendar" style="margin-left: -20px;z-index:5;color: black"></i>
                                                                </div>
                                                            </div>
                                                        </template>
                                                    </v-date-picker>
                                                </div>
                                            </div>
                                            <div class="col-md" v-if="parcours_billet==2">
                                                <div class="form-group">
                                                    <label for="date-retour-bil">{{trans('front-billeterie.date_arrive')}}</label>
                                                    <v-date-picker :min-date="min_date_arrive_billet" class="col-md form-group" v-model="date_arrive_billet">
                                                        <template v-slot="{ inputValue, togglePopover }">
                                                            <div class="input-group">
                                                                <input class="form-control" type="date" readonly required id="date-retour-bil" style="background-color: #fff" placeholder="-- / -- / ----" name="date_retour" :value='parseDateToString(inputValue)'>
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
                                                    <input class="form-control" type="number" step="1" :min="_personne.id == 1?1:0" :value="_personne.id == 1?1:0" required :name="'personne_'+_personne.id">
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
                                <div v-if="aside.produit.transfert.status == 1" class="tab-pane fade" role="tabpanel" aria-labelledby="trans-tab" id="trans">
                                    <form @submit.prevent="searchDataHome" action="{{route('transferts')}}" class="form_customer_search">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <div class="form-check-inline">
                                                        <label class="form-check-label" for="aller-trans">
                                                            <input type="radio" class="form-check-input mr-3 check-parcours" id="aller-trans" name="parcours" value="1" checked @change="checkParcoursTrans($event)">{{trans('front-transfert.aller_simple')}}
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <div class="form-check-inline">
                                                        <label class="form-check-label" for="aller-retour-trans">
                                                            <input type="radio" class="form-check-input mr-3 check-parcours aller-retour" id="aller-retour-trans" name="parcours" value="2" @change="checkParcoursTrans($event)">{{trans('front-transfert.aller_retour')}}
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md">
                                                <div class="form-group">
                                                    <label for="depart-trans">{{trans('front-transfert.lieu_depart')}}</label>
                                                    <select class="form-control" id="depart-trans" name="depart" @change="selectLieuTrans" required>
                                                        <option value="">--{{trans('front-transfert.selectionnez_lieu_depart')}}--</option>
                                                        <optgroup :label="_depart.length?_depart[0].ville.name:''" v-for="_depart of lieu_depart_trans">
                                                            <option :value="_item_depart.id" v-for="_item_depart of _depart">@{{_item_depart.titre}}</option>
                                                        </optgroup>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md">
                                                <div class="form-group">
                                                    <label for="retour-trans">{{trans('front-transfert.lieu_arrive')}}</label>
                                                    <select class="form-control" id="retour-trans" name="retour" required>
                                                        <option value="">--{{trans('front-transfert.selectionnez_lieu_arrive')}}--</option>
                                                        <optgroup :label="_arrive.length?_arrive[0].ville.name:''" v-for="_arrive of lieu_arrive_trans">
                                                            <option :value="_item_arrive.id" v-for="_item_arrive of _arrive">@{{_item_arrive.titre}}</option>
                                                        </optgroup>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md">
                                                <label for="date-depart-trans">{{trans('front-transfert.date_et_heure_depart')}}</label>
                                                <div class="row">
                                                    <v-date-picker :min-date="min_date_depart_trans" class="col-md form-group" v-model="date_depart_trans">
                                                        <template v-slot="{ inputValue, togglePopover }">
                                                            <div class="input-group">
                                                                <input class="form-control" type="date" readonly required id="date-retour-trans" style="background-color: #fff" placeholder="-- / -- / ----" name="date_depart" :value='parseDateToString(inputValue)'>
                                                                <div class="input-group-append d-flex align-items-start mt-2" @click.prevent="togglePopover()">
                                                                    <i class="fa fa-calendar" style="margin-left: -20px;z-index:5;color: black"></i>
                                                                </div>
                                                            </div>
                                                        </template>
                                                    </v-date-picker>
                                                    <vue-timepicker required="required" tabindex="9999" class="col-md form-group" id="time-depart-trans" name="heure_depart" input-class="form-control" hide-clear-button :hour-range="heure_depart_trans" :minute-interval="15" close-on-complete v-model="times_model.heure_depart_trans"></vue-timepicker>
                                                </div>
                                            </div>
                                            <div class="col-md" v-if="parcours_trans==2">
                                                <label for="date-retour-trans">{{trans('front-transfert.date_et_heure_retour')}}</label>
                                                <div class="row">
                                                    <v-date-picker :min-date="min_date_arrive_trans" class="col-md form-group" v-model="date_arrive_trans">
                                                        <template v-slot="{ inputValue, togglePopover }">
                                                            <div class="input-group">
                                                                <input class="form-control" type="date" readonly required id="date-retour-trans" style="background-color: #fff" placeholder="-- / -- / ----" name="date_retour" :value='parseDateToString(inputValue)'>
                                                                <div class="input-group-append d-flex align-items-start mt-2" @click.prevent="togglePopover()">
                                                                    <i class="fa fa-calendar" style="margin-left: -20px;z-index:5;color: black"></i>
                                                                </div>
                                                            </div>
                                                        </template>
                                                    </v-date-picker>
                                                    <vue-timepicker required="required" tabindex="9999" class="col-md form-group" id="time-retour-trans" name="heure_retour" input-class="form-control" hide-clear-button :hour-range="heure_retour_trans" :minute-interval="15" close-on-complete v-model="times_model.heure_retour_trans"></vue-timepicker>
                                                </div>
                                            </div>
                                        </div>
                                        <label for="passagers">{{trans('front-transfert.passagers')}}</label>
                                        <div class="row">
                                            <div class="col-md" v-for=" (_personne,_index) in aside.personne?aside.personne:[]">
                                                <div class="form-group">
                                                    <label :for="'personne_'+_personne.id">@{{_personne.type}}</label>
                                                    <input class="form-control" type="number" step="1" required :min="_personne.id == 1? 1:0" :value="_personne.id == 1? 1: 0" :name="'personne_'+_personne.id">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <button type="submit" class="btn btn-primary pl-4 pr-4 rounded-sm text-white">
                                                <span>{{trans('front-transfert.rechercher')}}</span>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-8 mb-4" v-if="hasProduitStatus() && aside.coup_coeur[0] != undefined">
                        <div class="rounded-sm py-3 featured-product">
                            <h4 class="px-3 py-1">{{trans('front-home.nos_coup_coeur')}}</h4>
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
            </div>
        </aside-page>
    </div>
</section>
<section class="pt-5 pb-3">
    <div class="container" style="font-size: 18px">
        <p class="text-center">DISPOSITIONS COVID OUTRE-MER</p>

        <p class="text-center">Certains territoires d’outre-mer sont concernés par des mesures de confinement et /ou de couvre-feu.</br>

            Concernant les transports aériens vers les Outre-mer, le test PCR dans les 72h avant embarquement est une obligation.</br>

            Plus d’informations, veuillez vous rendre sur le lien <a href="https://www.gouvernement.fr/info-coronavirus/outre-mer/" target="_blank">https://www.gouvernement.fr/info-coronavirus/outre-mer</a></p>
        </p>
        <hr class="separator" />
    </div>
</section>
<other-product :url="'{{route('panier')}}'" :urlbase="'{{base_url('')}}'" :urlasset="'{{asset('')}}'" :data="{{$data->toJson()}}" :aside="{{$aside}}" :sessionrequest="{{$session_request}}" :keysessionrequest="'{{app('request')->has('key_')?app('request')->key_:''}}'" inline-template>
    <section class="pt-5 pb-3">
        <div class="container">
            <div class="mb-4 text-center">
                <h2 class="text-dark text-uppercase">{{trans('front-home.nos_iles')}}</h2>
                <hr class="separator" />
            </div>
            <div class="slick-carousel">
                <div v-for="item of allIsland">
                    <div class="justify-content-center row">
                        <div class="col-md py-3" v-for="sub_item of item">
                            <div class="align-items-center background-center-center background-cover d-flex h-100 justify-content-center px-2 py-5" :style="'background-image: url(\''+(sub_item.background_image? $isBase64(sub_item.background_image)?sub_item.background_image:`${urlasset}/${sub_item.background_image}`: '{{asset('/assets/img/Guadeloupe.jpg')}}' )+'\')'">
                                <div>
                                    <div class="text-center text-decoration-none text-white">
                                        <div>
                                            <img :src="sub_item.card? $isBase64(sub_item.card)?sub_item.card:`${urlasset}/${sub_item.card}` : '{{asset('/assets/img/Guadeloupe_location_map-1-110x100.png')}}'" class="map-white mx-auto">
                                            <div>
                                                <h3 class="text-shadow">@{{sub_item.name}}</h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</other-product>
<other-product :url="'{{route('panier')}}'" :urlbase="'{{base_url('')}}'" :urlasset="'{{asset('')}}'" :data="{{$data->toJson()}}" :aside="{{$aside}}" :sessionrequest="{{$session_request}}" :keysessionrequest="'{{app('request')->has('key_')?app('request')->key_:''}}'" inline-template>
    <section class="pb-5 pt-5" style="background-color:rgba(230, 230, 230, 0.3)">
        <div class="container" v-if="hasProduitStatus() && aside.coup_coeur[0] != undefined">
            <div class="mb-4 text-center">
                <h2 class="text-dark text-uppercase">{{trans('front-home.nos_coup_coeur')}}</h2>
                <hr class="separator" />
            </div>
            <div class="slick-carousel slick-product">
                <div v-for="(_coup_coeur,_index) in $grouperArrayRepet(aside.coup_coeur,3)">
                    <div class="justify-content-center row">
                        <div class="col-md-4 pb-3 pt-3" v-for="item_coup_coeur in _coup_coeur">
                            <div class="border h-100 d-flex flex-column">
                                <a @contextmenu.prevent="" @click.prevent="managerRequest($event,item_coup_coeur.url,{id:item_coup_coeur.id_produit})" class="d-block position-relative" style="max-height: 230px;">
                                    <img src="{{asset('/assets/img/La_Creole_Beach_Hotel_Spa-Le_Gosier-thumb.jpg')}}" class="img-fluid w-100">
                                </a>
                                <div class="pb-3 pl-4 pr-4 pt-4 d-flex flex-grow-1 flex-column position-relative">
                                    <div class="d-flex flex-column flex-grow-1">
                                        <div class="pb-1 pt-1 mb-auto">
                                            <a @contextmenu.prevent="" @click.prevent="managerRequest($event,item_coup_coeur.url,{id:item_coup_coeur.id_produit})" class="text-dark text-decoration-none">
                                                <h5 class="mb-1 text-primary">@{{item_coup_coeur.titre}} </h5>
                                            </a>
                                            <div class="d-flex">
                                                <div class="flex-fill font-size-0-8-em mt-2">
                                                    <i class="fa-map-marker-alt fas text-primary mr-1"></i>
                                                    <span>@{{item_coup_coeur.ile}}</span>
                                                </div>
                                                <div class="flex-fill font-size-0-8-em mt-2 border-left text-center">
                                                    <span v-if="item_coup_coeur.sigle == 'hebergement'">@{{item_coup_coeur.data.tarif.type_chambre.capacite}} {{trans('front-hebergement.pers_max_1_chambre')}}</span>
                                                    <span v-if="item_coup_coeur.sigle == 'excursion'">{{trans('front-hebergement.une')}} @{{$lowerCase(item_coup_coeur.data.duration)}}</span>
                                                </div>
                                            </div>
                                            <div class="mt-3 position-relative">
                                                <div class="short-definition">
                                                    <div class="more-definition p-2 rounded-sm position-absolute border">
                                                        <p class="font-size-0-8-em">@{{$textDescription(item_coup_coeur.description)}}</p>
                                                    </div>
                                                    <p class="font-size-0-8-em">@{{$textDescription(item_coup_coeur.description, 100)}}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <hr class="w-100">
                                        <div class="d-flex" v-if="item_coup_coeur.sigle == 'excursion'">
                                            <div class="flex-fill text-center px-1 border-right">
                                                <div class="font-size-0-8-em jour-dispo position-relative">
                                                    <i class="fa-calendar-alt far mr-1"></i>
                                                    <span>@{{$availability(item_coup_coeur.data.availability).length}} {{trans('front-excursion.jours_sur_7')}}</span>
                                                    <div class="jour-dispo-detail rounded-sm p-2 border"> 
                                                        <i class="fa-calendar-alt far mr-1"></i>
                                                        <span>@{{$availability(item_coup_coeur.data.availability).length}} {{trans('front-excursion.jours_sur_7')}}</span>
                                                        <ul class="mt-2 pt-2 border-top">
                                                            <li v-for="jour of $availability(item_coup_coeur.data.availability)">@{{jour}}</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="flex-fill text-center px-1 d-flex" v-if="(item_coup_coeur.data.lunch == 1 || item_coup_coeur.data.ticket == 1)">
                                                <div class="font-size-0-8-em position-relative d-flex align-items-center m-auto" v-if="item_coup_coeur.data.ticket == 1 || item_coup_coeur.data.lunch == 1">
                                                    <i class="fas fa-supp-icon mr-1" style="background-image: url('{{asset('images/repas.png')}}');" v-if="item_coup_coeur.data.lunch == 1"></i>
                                                    <span v-if="item_coup_coeur.data.lunch == 1">{{trans('front-excursion.repas')}}</span>
                                                    <span v-if="item_coup_coeur.data.ticket == 1 && item_coup_coeur.data.lunch == 1">&nbsp; + &nbsp;</span>
                                                    <i class="fas fa-supp-icon mr-1" style="background-image: url('{{asset('images/ticket.png')}}');" v-if="item_coup_coeur.data.ticket == 1"></i>
                                                    <span v-if="item_coup_coeur.data.ticket == 1">{{trans('front-excursion.billet_avion')}}</span>
                                                </div>
                                            </div>
                                            <div class="flex-fill text-center px-1 d-flex" v-if="(item_coup_coeur.data.lunch == 0 && item_coup_coeur.data.ticket == 0)">
                                                <div class="font-size-0-8-em position-relative d-flex align-items-center m-auto">
                                                    <span>{{trans('front-excursion.excursion_seule')}}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex" v-if="item_coup_coeur.sigle == 'hebergement'">
                                            <div class="flex-fill text-center px-1 border-right">
                                                <div class="font-size-0-8-em ">
                                                    <i class="fa-clock far mr-1"></i>
                                                    <span>{{trans('front-hebergement.base')}} @{{item_coup_coeur.data.tarif.base_type.nombre}} {{trans('front-hebergement.pers')}}</span>
                                                </div>
                                            </div>
                                            <div class="flex-fill text-center px-1" v-if="item_coup_coeur.data.tarif.type_chambre.formule" style="width: 50%">
                                                <div class="font-size-0-8-em supplement position-relative d-flex align-items-center">
                                                    <i class="fas fa-supp-icon mr-1" style="background-image: url('{{asset('images/repas.png')}}"></i>
                                                    <span class="flex-grow-1" style="width: 80%">@{{item_coup_coeur.data.tarif.type_chambre.formule.desc}}</span>
                                                </div>
                                            </div>
                                            <div class="flex-fill text-center px-1" v-if="item_coup_coeur.data.tarif.type_chambre.formule == null" style="width: 50%">
                                                <div class="font-size-0-8-em supplement position-relative d-flex align-items-center">
                                                    <span class="m-auto">{{trans('front-hebergement.hebergement_seul')}}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr class="w-100">
                                    <div class="align-items-center d-flex justify-content-between" v-if="item_coup_coeur.sigle == 'hebergement'">
                                        <div>
                                            <p class="font-size-15-px text-success text-center">{{trans('front-hebergement.a_partir_de')}} <br><span class="font-size-1-3-em font-weight-bold">@{{item_coup_coeur.data.tarif.tarif.prix_vente}}&euro;</span> {{trans('front-hebergement.par_jour')}}</p>
                                        </div>
                                        <div>
                                            <a class="btn btn-primary text-white" @contextmenu.prevent="" @click.prevent="managerRequest($event,item_coup_coeur.url,{id:item_coup_coeur.id_produit})">{{trans('front-hebergement.reserver')}}</a>
                                        </div>
                                    </div>
                                    <div class="align-items-center d-flex justify-content-between" v-if="item_coup_coeur.sigle == 'excursion'">
                                        <div>
                                            <p class="font-size-15-px text-success text-center">{{trans('front-excursion.a_partir_de')}}<br><span class="font-size-1-3-em font-weight-bold">@{{item_coup_coeur.data.tarif?item_coup_coeur.data.tarif.prix_vente:0}}&euro;</span> {{trans('front-excursion.par_personne')}}</p>
                                        </div>
                                        <div>
                                            <a class="btn btn-primary text-white" @contextmenu.prevent="" @click.prevent="managerRequest($event,item_coup_coeur.url,{id:item_coup_coeur.id_produit})">{{trans('front-excursion.voir_cette_offre')}}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</other-product>
<section style="display: none; background-image: {{'url(\''.asset('/assets/img//worldmap.png').'\')'}};" class="background-center-center background-cover py-5">
    <div class="container">
        <div class="mb-4 text-center">
            <h2 class="text-dark text-uppercase">{{trans('front-home.formules_evasion')}}</h2>
            <hr class="separator" />
        </div>
        <div class="justify-content-center row">
            <div class="col-md pb-3 pt-3">
                <div class="border">
                    <a href="#" class="d-block position-relative"><img src="https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?ixid=MXwyMDkyMnwwfDF8c2VhcmNofDY5fHxhbyUyMG5hbmd8ZW58MHx8fA&ixlib=rb-1.2.1q=85&fm=jpg&crop=faces&cs=srgb&w=350&h=240&fit=crop" class="img-fluid w-100">
                        <div class="bottom-0 p-2 position-absolute text-right w-100">
                            <p class="bg-primary d-inline-block font-size-0-8-em m-0 px-3 py-2 rounded-pill text-white">Excursion à la journée</p>
                            <p class="bg-primary d-inline-block font-size-0-8-em m-0 px-3 py-2 rounded-pill text-white">Formule Evasion</p>
                        </div>
                    </a>
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
                    <a href="#" class="d-block position-relative"><img src="https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?ixid=MXwyMDkyMnwwfDF8c2VhcmNofDY5fHxhbyUyMG5hbmd8ZW58MHx8fA&ixlib=rb-1.2.1q=85&fm=jpg&crop=faces&cs=srgb&w=350&h=240&fit=crop" class="img-fluid w-100">
                        <div class="bottom-0 p-2 position-absolute text-right w-100">
                            <p class="bg-primary d-inline-block font-size-0-8-em m-0 px-3 py-2 rounded-pill text-white">Excursion à la journée</p>
                            <p class="bg-primary d-inline-block font-size-0-8-em m-0 px-3 py-2 rounded-pill text-white">Formule Evasion</p>
                        </div>
                    </a>
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
                    <a href="#" class="d-block position-relative"><img src="https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?ixid=MXwyMDkyMnwwfDF8c2VhcmNofDY5fHxhbyUyMG5hbmd8ZW58MHx8fA&ixlib=rb-1.2.1q=85&fm=jpg&crop=faces&cs=srgb&w=350&h=240&fit=crop" class="img-fluid w-100">
                        <div class="bottom-0 p-2 position-absolute text-right w-100">
                            <p class="bg-primary d-inline-block font-size-0-8-em m-0 px-3 py-2 rounded-pill text-white">Excursion à la journée</p>
                            <p class="bg-primary d-inline-block font-size-0-8-em m-0 px-3 py-2 rounded-pill text-white">Formule Evasion</p>
                        </div>
                    </a>
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
<section class="p-5 text-center" style="background-image: {{'url(\''.asset('/assets/img//dark_bkg.jpg').'\')'}};">
    <div class="container">
        <div class="mb-4">
            <h2 class="text-uppercase text-white">{{trans('front-home.createur_de_reves')}}</h2>
            <hr class="separator" />
        </div>
        <div class="justify-content-center row">
            <div class="col-md pb-3 pt-3">
                <div class="p-4 text-white">
                    <img src="{{asset('/assets/img/randonnees-338x225.jpg')}}" class="img-dream">
                    <h5 class="my-3">{{trans('front-home.nos_excursions')}}</h5>
                    <hr class="separator" />
                    <p class="mb-0">Nos excursions à la journée ou demi-journée avec ou sans repas en Guadeloupe, Martinique, Sainte-Lucie, Saint-Martin, La Dominique, République-Dominicaine.</p>
                </div>
            </div>
            <div class="col-md pb-3 pt-3">
                <div class="p-4 text-white">
                    <img src="{{asset('/assets/img/Transferts-338x225.jpg')}}" class="img-dream">
                    <h5 class="my-3">{{trans('front-home.nos_transferts')}}</h5>
                    <hr class="separator" />
                    <p class="mb-0">Avec notre gamme de véhicules nous assurons vos transferts au départ ou à l’arrivée, de votre hôtel, de l’aéroport Pôles Caraïbes, ou des différents ports de Guadeloupe.</p>
                </div>
            </div>
            <div class="col-md pb-3 pt-3">
                <div class="p-4 text-white">
                    <img src="{{asset('/assets/img/Ferry-338x225.jpg')}}" class="img-dream">
                    <h5 class="my-3">{{trans('front-home.notre_billetterie_maritime')}}</h5>
                    <hr class="separator" />
                    <p class="mb-0">Vous souhaitez séjourner dans les îles de l’Arc Antillais, une semaine, un week-end ou une journée, nous vous proposons des billets de bateau pour différentes destinations.</p>
                </div>
            </div>
        </div>
    </div>
</section>
<section>
    <div>
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15323.46474620985!2d-61.38452979756477!3d16.227317627624693!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMTbCsDEzJzI2LjIiTiA2McKwMjInNDkuMyJX!5e0!3m2!1sen!2smg!4v1582633755488!5m2!1sen!2smg" height="450" frameborder="0" style="border: 0px; pointer-events: none;" allowfullscreen="" width="100%"></iframe>
    </div>
</section>

@endsection