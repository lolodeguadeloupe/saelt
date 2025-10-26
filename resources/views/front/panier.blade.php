@extends('front.layouts.layout')

@push('after-blocks-css')
<link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap-slider/css/bootstrap-slider.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/slick-1.8.1/slick.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/slick-1.8.1/slick-theme.css') }}">
@endpush

@push('after-script-js')
<script src="{{ asset('assets/vendor/bootstrap-slider/bootstrap-slider.min.js') }}"></script>
<script src="{{ asset('assets/vendor/slick-1.8.1/slick.min.js') }}"></script>
<script src="{{ asset('assets/js/slick-script.js') }}"></script>
<script src="{{ asset('assets/js/slide-script.js') }}"></script>
@endpush

@section('title', trans('front-panier.panier'))

@section('content')

<section class="banner page banner-overlay background-cover bg-dark pb-5 position-relative pt-5 text-white" style="background-image: {{'url(\''.asset('/assets/img/ct_sea-418742_1920.jpg').'\')'}};">
    <div class="container mt-5 pt-4">
        <div class="row">
            <div class="col-md">
                <h1 class="text-uppercase">{{trans('front-panier.votre_panier')}}</h1>
            </div>
        </div>
    </div>
</section>

<panier :url="'{{route('panier')}}'" :urlbase="'{{base_url('')}}'" :urlasset="'{{asset('')}}'" :data="{{$data->toJson()}}" :aside="{{$aside}}" :sessionrequest="{{$session_request}}" :keysessionrequest="'{{app('request')->has('key_')?app('request')->key_:''}}'" :tva="{{$TVA->toJson()}}" :modepayement="{{$modePayement->toJson()}}" :fraisdossier="{{$fraisdossier->toJson()}}" inline-template>
    <div>
        <section class="pt-5 pb-5 notification" v-if="length_pannier==0">
            <div class="container p-3" style="background-color:#eaeaea">
                <p class="mb-0"><i class="fas fa-shopping-cart mr-3" style="font-size: 1rem;"></i>{{trans('front-panier.votre_panier_est_actuellement_vide')}}.</p>
            </div>
        </section>
        <section class="py-5" v-if="length_pannier>0">
            <div class="container order-tab">
                <div class="row title-tab text-white text-uppercase pt-3 pb-2 mb-4 mx-0 text-center position-relative" style="background-color: #77a464; letter-spacing: 2px;">
                    <div class="col-sm-3"></div>
                    <div class="col-sm-7">
                        <h5>{{trans('front-panier.votre_devis')}}</h5>
                    </div>
                    <div class="col-sm-2">
                        <h5>{{trans('front-panier.sous_total')}}</h5>
                    </div>
                </div>

                <div class="border mt-4 p-3 position-relative" v-if="billeterie.length > 0">
                    <div class="categorie-produit position-absolute">{{trans('front-panier.billetterie')}}</div>
                    <div class="container border mt-4 p-3 position-relative" v-for="(item,index) in billeterie">
                        <div class="btn-icon-edit position-absolute">
                            <div class="row">
                                <div class="col-6 pl-2">
                                    <i class="fas fa-times" style="font-size: 1.2rem; color: #ab2e30" @click.prevent="deletePanier($event,item.commande,item.id,{index_produit:index})"></i>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3 d-block position-relative">
                                <img :src="urlasset+'/'+item.image" class="img-fluid w-100">
                            </div>
                            <div class="col-sm-7">
                                <h5 class="text-decoration-none text-primary">@{{item.data.item.depart.name}} - @{{item.data.item.arrive.name}}</h5>
                                <table width="100%" class="mt-3">
                                    <tbody>
                                        <tr>
                                            <th colspan="2" style="font-size: large;">{{trans('front-billeterie.aller')}} </th>
                                        </tr>
                                        <tr>
                                            <th width="50%">{{trans('front-billeterie.port_depart')}} : </th>
                                            <td>@{{item.data.item.depart.name}}</td>
                                        </tr>
                                        <tr>
                                            <th>{{trans('front-billeterie.port_arrive')}} : </th>
                                            <td>@{{item.data.item.arrive.name}}</td>
                                        </tr>
                                        <tr>
                                            <th>{{trans('front-billeterie.date_et_heure_depart')}} : </th>
                                            <td>@{{$formatDateString(item.data.item.date_depart,true)}} à @{{item.form.heure_aller | formatTime }}</td>
                                        </tr>
                                        <tr v-if="item.data.item.parcours == 2">
                                            <td style="height: 10px;"></td>
                                        </tr>
                                        <tr v-if="item.data.item.parcours == 2">
                                            <th colspan="2" style="font-size: large;">{{trans('front-billeterie.retour')}} </th>
                                        </tr>
                                        <tr v-if="item.data.item.parcours == 2">
                                            <th width="50%">{{trans('front-billeterie.port_depart')}} : </th>
                                            <td>@{{item.data.item.arrive.name}}</td>
                                        </tr>
                                        <tr v-if="item.data.item.parcours == 2">
                                            <th>{{trans('front-billeterie.port_arrive')}} : </th>
                                            <td>@{{item.data.item.depart.name}}</td>
                                        </tr>
                                        <tr v-if="item.data.item.parcours == 2">
                                            <th>{{trans('front-billeterie.date_et_heure_retour')}} : </th>
                                            <td>@{{$formatDateString(item.data.item.date_retour,true)}} à @{{item.form.heure_retour | formatTime}}</td>
                                        </tr>
                                        <tr>
                                            <td style="height: 10px;"></td>
                                        </tr>
                                        <tr>
                                            <th colspan="2" style="font-size: large;">{{trans('front-billeterie.passagers')}} </th>
                                        </tr>
                                        <tr v-for="_item_personne of item.data.item.tarif">
                                            <th>@{{_item_personne.personne.type}} : </th>
                                            <td>@{{_item_personne.nb}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-sm-2 text-center border-left d-flex align-items-center">
                                <div class="subtotal m-auto">@{{$parseFloat(item.computed.prixTotal)}}€</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="border mt-4 p-3 position-relative" v-if="excursion.length > 0">
                    <div class="categorie-produit position-absolute">{{trans('front-panier.excursion')}}</div>
                    <div class="container border mt-4 p-3 position-relative" v-for="(item,index) in excursion">
                        <div class="btn-icon-edit position-absolute">
                            <div class="row">
                                <div class="col-6 pr-2" @click.prevent="managerRequest($event,item.produit_link,{id:item.id,panier:true,date_commande:item.date_commande,index_produit:index})">
                                    <i class="fas fa-pencil-alt" style="color: #77a464"></i>
                                </div>
                                <div class="col-6 pl-2" @click.prevent="deletePanier($event,item.commande,item.id,{index_produit:index})">
                                    <i class="fas fa-times" style="font-size: 1.2rem; color: #ab2e30"></i>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3 d-block position-relative">
                                <img :src="urlasset+'/'+item.image" class="img-fluid w-100">
                            </div>
                            <div class="col-sm-7">
                                <h5 class="text-decoration-none text-primary">@{{item.titre}}</h5>
                                <table width="100%" class="mt-3">
                                    <tbody>
                                        <tr>
                                            <th width="50%">{{trans('front-excursion.date_excursion')}} :</th>
                                            <td>@{{$getArrayDateString(item.data.selectCalendarDate)}}</td>
                                        </tr>
                                        <tr>
                                            <th>{{trans('front-excursion.destination')}} :</th>
                                            <td>@{{item.data.item.ile.name}}</td>
                                        </tr>
                                        <tr>
                                            <th>{{trans('front-excursion.duree')}} :</th>
                                            <td>@{{item.data.item.duration}}</td>
                                        </tr>
                                        <tr>
                                            <td style="height: 10px;"></td>
                                        </tr>
                                        <tr>
                                            <th colspan="2" style="font-size: large;">{{trans('front-excursion.personnes')}} </th>
                                        </tr>
                                        <tr v-for="_item_personne of item.computed.personneChecked">
                                            <th>@{{_item_personne.type.type}} : </th>
                                            <td>@{{_item_personne.nb}}</td>
                                        </tr>
                                        <tr>
                                            <td style="height: 10px;"></td>
                                        </tr>
                                        <tr v-if="$isEmpty(item.data.supplementCkecked) == false">
                                            <td colspan="2" class="supp-info">
                                                <span class="titre">{{trans('front-excursion.supplements')}} :</span>
                                                <div class="item">
                                                    <ul class="list-info" v-for="_item_supp of item.data.supplementCkecked">
                                                        <li v-for="_child_supp of _item_supp"><span style="width: 48%;display: inline-block;font-weight:500">@{{_child_supp.titre}} :</span> <span style="display: inline-block">@{{_child_supp.prix_calculer}}€</span></li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-sm-2 text-center border-left d-flex align-items-center">
                                <div class="subtotal m-auto">@{{$parseFloat(item.computed.prixTotal)}}€</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="border mt-4 p-3 position-relative" v-if="hebergement.length > 0">
                    <div class="categorie-produit position-absolute">{{trans('front-panier.hebergement')}}</div>
                    <div class="container border mt-4 p-3 position-relative" v-for="(item,index) in hebergement">
                        <div class="btn-icon-edit position-absolute">
                            <div class="row">
                                <div class="col-6 pr-2" @click.prevent="managerRequest($event,item.produit_link,{id:item.id,panier:true,date_commande:item.date_commande,index_produit:index})">
                                    <i class="fas fa-pencil-alt" style="color: #77a464"></i>
                                </div>
                                <div class="col-6 pl-2" @click.prevent="deletePanier($event,item.commande,item.id,{index_produit:index})">
                                    <i class="fas fa-times" style="font-size: 1.2rem; color: #ab2e30"></i>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3 d-block position-relative">
                                <img :src="urlasset+'/'+item.image" class="img-fluid w-100">
                            </div>
                            <div class="col-sm-7">
                                <h5 class="text-decoration-none text-primary">@{{item.titre}}</h5>
                                <table width="100%" class="mt-3">
                                    <tbody>
                                        <tr>
                                            <th width="50%">{{trans('front-hebergement.transport')}} :</th>
                                            <td v-if="item.data.item.vol != undefined">Avec vol</td>
                                            <td v-if="item.data.item.vol == undefined">Sans vol</td>
                                        </tr>
                                        <tr>
                                            <td style="height: 10px;"></td>
                                        </tr>
                                        <tr>
                                            <th>{{trans('front-hebergement.nombre_nuits')}} : </th>
                                            <td>@{{item.computed.nombreNuitCalendar}}</td>
                                        </tr>
                                        <tr>
                                            <th>{{trans('front-hebergement.dates_sejour')}} : </th>
                                            <td>@{{item.computed.dateDebutCalendar}} au @{{item.computed.dateEndCalendar}}</td>
                                        </tr>
                                        <tr>
                                            <td style="height: 10px;"></td>
                                        </tr>
                                        <tr>
                                            <th>{{trans('front-hebergement.nombre_chambre')}} : </th>
                                            <td>@{{item.data.chambreChecked}} </td>
                                        </tr>
                                        <tr>
                                            <th>{{trans('front-hebergement.base_type')}} : </th>
                                            <td>@{{item.data.item.base_type.nombre}} Pers.</td>
                                        </tr>
                                        <tr>
                                            <th>{{trans('front-hebergement.capacite_max')}} : </th>
                                            <td>@{{item.data.item.type_chambre.capacite}} Pers.</td>
                                        </tr>
                                        <tr>
                                            <td style="height: 10px;"></td>
                                        </tr>
                                        <tr>
                                            <th colspan="2" style="font-size: large;">{{trans('front-hebergement.personnes')}} </th>
                                        </tr>
                                        <tr v-for="_item_personne of item.computed.personneChecked">
                                            <th>@{{_item_personne.type.type}} : </th>
                                            <td>@{{_item_personne.nb}}</td>
                                        </tr>
                                        <tr>
                                            <td style="height: 10px;"></td>
                                        </tr>
                                        <tr v-if="!$isEmpty(item.data.supplementCkecked)">
                                            <td colspan="2" class="supp-info"> 
                                                <span class="titre">{{trans('front-hebergement.supplements')}} :</span>
                                                <div class="item">
                                                    <ul class="list-info" v-for="_item_supp of item.data.supplementCkecked">
                                                        <li v-for="_child_supp of _item_supp"><span style="width: 48%;display: inline-block;font-weight:500">@{{_child_supp.titre}} :</span> <span style="display: inline-block">@{{_child_supp.prix_calculer}}€</span></li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-sm-2 text-center border-left d-flex align-items-center">
                                <div class="subtotal m-auto">@{{$parseFloat(item.computed.prixTotal)}}€</div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="border mt-4 p-3 position-relative" v-if="location.length > 0">
                    <div class="categorie-produit position-absolute">{{trans('front-panier.location')}}</div>
                    <div class="container border mt-4 p-3 position-relative" v-for="(item,index) in location">
                        <div class="btn-icon-edit position-absolute">
                            <div class="row">
                                <div class="col-6 pr-2">
                                    <i class="fas fa-pencil-alt" style="color: #77a464" @click.prevent="managerRequest($event,item.produit_link,{id:item.id,panier:true,date_commande:item.date_commande,search_condition:item.data.item.search_condition,index_produit:index})"></i>
                                </div>
                                <div class="col-6 pl-2">
                                    <i class="fas fa-times" style="font-size: 1.2rem; color: #ab2e30" @click.prevent="deletePanier($event,item.commande,item.id,{index_produit:index})"></i>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3 d-block position-relative">
                                <img :src="urlasset+'/'+item.image" class="img-fluid w-100">
                            </div>
                            <div class="col-sm-7">
                                <h5 class="text-decoration-none text-primary">@{{item.data.item.categorie.titre}}</h5>
                                <table width="100%" class="mt-3">
                                    <tbody>
                                        <tr>
                                            <th width="50%">{{trans('front-location.lieu_depart')}} : </th>
                                            <td>@{{item.data.item.agence_recuperation.name}}</td>
                                        </tr>
                                        <tr>
                                            <th>{{trans('front-location.date_et_heure_depart')}} : </th>
                                            <td>@{{$formatDateString(item.data.item.search_condition.date_recuperation,true)}} à @{{item.data.item.search_condition.heure_recuperation|formatTime}}</td>
                                        </tr>
                                        <tr>
                                            <td style="height: 10px;"></td>
                                        </tr>
                                        <tr>
                                            <th>{{trans('front-location.lieu_retour')}} : </th>
                                            <td>@{{item.data.item.agence_restriction.name}}</td>
                                        </tr>
                                        <tr>
                                            <th>{{trans('front-location.date_et_heure_retour')}} : </th>
                                            <td>@{{$formatDateString(item.data.item.search_condition.date_restriction,true)}} à @{{item.data.item.search_condition.heure_restriction|formatTime}}</td>
                                        </tr>
                                        <tr>
                                            <td style="height: 10px;"></td>
                                        </tr>
                                        <tr>
                                            <th>{{trans('front-location.supplement_deplacements')}} :</th>
                                            <td>@{{item.data.item.categorie.supplement != null ? item.data.item.categorie.supplement.tarif:0}}€</td>
                                        </tr>
                                        <tr>
                                            <th>{{trans('front-location.caution')}} :</th>
                                            <td>@{{item.data.item.caution}}€</td>
                                        </tr>
                                        <tr>
                                            <td style="height: 10px;"></td>
                                        </tr>
                                        <tr v-for="_assurance of item.data.assurance">
                                            <th v-if="_assurance.assurance == 'franchise'">{{trans('front-location.franchise')}} :</th>
                                            <th v-if="_assurance.assurance == 'franchise_non_rachatable'">{{trans('front-location.franchise_non_rachatable')}} :</th>
                                            <td class="detail-info">
                                                @{{_assurance.value}}€
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div style="position: relative;margin-top:10px;">
                                    <input type="checkbox" :id="`info-conduct_${index}`" class="info-conduct">
                                    <label :for="`info-conduct_${index}`" class="text-success toogle-info-conducteur info-conducteur-panier-titre">{{trans('front-location.information_conducteur')}}</label>
                                    <div class="row content-info-conducteur">
                                        <div class="col-12">
                                            <div class="row">
                                                <div class="col" style="margin-bottom: 10px;">
                                                    <span style="font-weight: bold;white-space: nowrap;">{{trans('front-location.nom')}} : </span>
                                                    <span style="padding-left: 10px">@{{item.form.nom}}</span>
                                                </div>
                                                <div class="col" style="margin-bottom: 10px;">
                                                    <span style="font-weight: bold;white-space: nowrap;">{{trans('front-location.prenom')}} : </span>
                                                    <span style="padding-left: 10px">@{{item.form.prenom}}</span>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col" style="margin-bottom: 10px;">
                                                    <span style="font-weight: bold;white-space: nowrap;">{{trans('front-location.adresse')}} : </span>
                                                    <span style="padding-left: 10px">@{{item.form.adresse}}</span>
                                                </div>
                                                <div class="col" style="margin-bottom: 10px;">
                                                    <span style="font-weight: bold;white-space: nowrap;">{{trans('front-location.ville')}} : </span>
                                                    <span style="padding-left: 10px">@{{item.form.ville}}</span>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col" style="margin-bottom: 10px;">
                                                    <span style="font-weight: bold;white-space: nowrap;">{{trans('front-location.code_postal')}} : </span>
                                                    <span style="padding-left: 10px">@{{item.form['code-postal']}}</span>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col" style="margin-bottom: 10px;">
                                                    <span style="font-weight: bold;white-space: nowrap;">{{trans('front-location.telephone')}} : </span>
                                                    <span style="padding-left: 10px">@{{item.form.telephone}}</span>
                                                </div>
                                                <div class="col" style="margin-bottom: 10px;">
                                                    <span style="font-weight: bold;white-space: nowrap;">{{trans('front-location.email')}} : </span>
                                                    <span style="padding-left: 10px">@{{item.form.email}}</span>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col" style="margin-bottom: 10px;">
                                                    <span style="font-weight: bold;white-space: nowrap;">{{trans('front-location.date_naissance')}} : </span>
                                                    <span style="padding-left: 10px">@{{item.form['date-naissance']}}</span>
                                                </div>
                                                <div class="col" style="margin-bottom: 10px;">
                                                    <span style="font-weight: bold;white-space: nowrap;">{{trans('front-location.lieu_naissance')}} : </span>
                                                    <span style="padding-left: 10px">@{{item.form['lieu-naissance']}}</span>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col" style="margin-bottom: 10px;">
                                                    <span style="font-weight: bold;white-space: nowrap;">{{trans('front-location.numero_permis')}} : </span>
                                                    <span style="padding-left: 10px">@{{item.form['num-permis']}}</span>
                                                </div>
                                                <div class="col" style="margin-bottom: 10px;">
                                                    <span style="font-weight: bold;white-space: nowrap;">{{trans('front-location.date_permis')}} : </span>
                                                    <span style="padding-left: 10px">@{{item.form['date-permis']}}</span>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col" style="margin-bottom: 10px;">
                                                    <span style="font-weight: bold;white-space: nowrap;">{{trans('front-location.lieu_delivrance_permis')}} : </span>
                                                    <span style="padding-left: 10px">@{{item.form['lieu-deliv-permis']}}</span>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col" style="margin-bottom: 10px;">
                                                    <span style="font-weight: bold;white-space: nowrap;">{{trans('front-location.numero_piece_identite')}} : </span>
                                                    <span style="padding-left: 10px">@{{item.form['num-identite']}}</span>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col" style="margin-bottom: 10px;">
                                                    <span style="font-weight: bold;white-space: nowrap;">{{trans('front-location.date_delivrance_identite')}} : </span>
                                                    <span style="padding-left: 10px">@{{item.form['date-emis-identite']}}</span>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col" style="margin-bottom: 10px;">
                                                    <span style="font-weight: bold;white-space: nowrap;">{{trans('front-location.lieu_delivrance_identite')}} : </span>
                                                    <span style="padding-left: 10px">@{{item.form['lieu-deliv-identite']}}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-2 text-center border-left d-flex align-items-center">
                                <div class="subtotal m-auto">@{{$parseFloat(item.computed.prixTotal)}}€</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="border mt-4 p-3 position-relative" v-if="transfert.length > 0">
                    <div class="categorie-produit position-absolute">{{trans('front-panier.transfert')}}</div>
                    <div class="container border mt-4 p-3 position-relative" v-for="(item,index) in transfert">
                        <div class="btn-icon-edit position-absolute">
                            <div class="row">
                                <div class="col-6 pl-2">
                                    <i class="fas fa-times" style="font-size: 1.2rem; color: #ab2e30" @click.prevent="deletePanier($event,item.commande,item.id,{index_produit:index})"></i>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3 d-block position-relative">
                                <img :src="urlasset+'/'+item.image" class="img-fluid w-100">
                            </div>
                            <div class="col-sm-7">
                                <h5 class="text-decoration-none text-primary">@{{item.titre}}</h5>
                                <table width="100%" class="mt-3">
                                    <tbody>
                                        <tr>
                                            <th colspan="2" style="font-size: large;">{{trans('front-transfert.aller')}}</th>
                                        </tr>
                                        <tr>
                                            <th width="50%">{{trans('front-transfert.lieu_depart')}} : </th>
                                            <td>@{{item.data.item.lieu_depart.adresse?item.data.item.lieu_depart.adresse:item.data.item.lieu_depart.titre}}</td>
                                        </tr>
                                        <tr>
                                            <th>{{trans('front-transfert.lieu_arrive')}} : </th>
                                            <td>@{{item.data.item.lieu_retour.adresse?item.data.item.lieu_retour.adresse:item.data.item.lieu_retour.titre}}</td>
                                        </tr>
                                        <tr>
                                            <th>{{trans('front-transfert.date_et_heure_depart')}} : </th>
                                            <td>@{{$formatDateString(item.data.item.date_depart,true)}} à @{{item.data.item.heure_depart | formatTime }}</td>
                                        </tr>
                                        <tr v-if="item.data.item.prime_depart > 0">
                                            <th>{{trans('front-transfert.prime_nuit')}} : </th>
                                            <td>@{{item.data.item.prime_depart}}€</td>
                                        </tr>
                                        <tr v-if="item.data.item.parcours == 2">
                                            <td style="height: 10px;"></td>
                                        </tr>
                                        <tr v-if="item.data.item.parcours == 2">
                                            <th colspan="2" style="font-size: large;">{{trans('front-transfert.retour')}}</th>
                                        </tr>
                                        <tr v-if="item.data.item.parcours == 2">
                                            <th width="50%">{{trans('front-transfert.lieu_depart')}} : </th>
                                            <td>@{{item.data.item.lieu_retour.adresse?item.data.item.lieu_retour.adresse:item.data.item.lieu_retour.titre}}</td>
                                        </tr>
                                        <tr v-if="item.data.item.parcours == 2">
                                            <th>{{trans('front-transfert.lieu_arrive')}} : </th>
                                            <td>@{{item.data.item.lieu_depart.adresse?item.data.item.lieu_depart.adresse:item.data.item.lieu_depart.titre}}</td>
                                        </tr>
                                        <tr v-if="item.data.item.parcours == 2">
                                            <th>{{trans('front-transfert.date_et_heure_retour')}} : </th>
                                            <td>@{{$formatDateString(item.data.item.date_retour,true)}} à @{{item.data.item.heure_retour | formatTime}}</td>
                                        </tr>
                                        <tr v-if="item.data.item.prime_retour > 0">
                                            <th>{{trans('front-transfert.prime_nuit')}} : </th>
                                            <td>@{{item.data.item.prime_retour}}€</td>
                                        </tr>
                                        <tr>
                                            <td style="height: 10px;"></td>
                                        </tr>
                                        <tr>
                                            <th colspan="2" style="font-size: large;">{{trans('front-transfert.passagers')}} </th>
                                        </tr>
                                        <tr v-for="_item_personne of item.data.item.personne">
                                            <th>@{{_item_personne.type}} : </th>
                                            <td>@{{_item_personne.nb}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-sm-2 text-center border-left d-flex align-items-center">
                                <div class="subtotal m-auto">@{{$parseFloat(item.computed.prixTotal)}}€</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="border position-relative mt-3 mb-5">
                    <div class="container position-relative">
                        <div class="row">
                            <div class="col-sm-10 border-bottom p-3 d-flex align-items-center" style="margin-bottom: -1px; font-weight: 800; text-transform: uppercase; font-size: 1rem;">
                                {{trans('front-panier.frais_dossier')}}
                            </div>
                            <div class="col-sm-2 text-center border-left d-flex align-items-center px-0 mx-0 border-bottom" style="margin-bottom: -1px;">
                                <div class="subtotal m-auto">@{{frais_dossier}}€</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mb-2 p-3 position-relative">
                    <div class="row border-top border-left border-right border-bottom">
                        <div class="col-sm-6 text-uppercase text-center p-2 position-relative">
                            <div class="total-titre">
                                <h6 class="font-weight-bold" style="font-size:1.2rem">{{trans('front-panier.tva')}}</h6>
                            </div>
                        </div>
                        <div class="col-sm-6 text-center p-2 border-left">
                            <div class="total font-weight-bold" style="font-size:1.2rem;">@{{taxe_tva}} €</div>
                        </div>
                    </div>
                    <div class="row border-left border-right border-bottom">
                        <div class="col-sm-6 text-uppercase text-center p-2 position-relative">
                            <div class="total-titre">
                                <h6 class="font-weight-bold" style="font-size:1.2rem">{{trans('front-panier.ht')}}</h6>
                            </div>
                        </div>
                        <div class="col-sm-6 text-center p-2 border-left">
                            <div class="total font-weight-bold" style="font-size:1.2rem;">@{{tarifTotal}} €</div>
                        </div>
                    </div>
                    <div class="row border-left border-right border-bottom">
                        <div class="col-sm-6 text-uppercase text-center p-2 position-relative">
                            <div class="total-titre">
                                <h6 class="font-weight-bold" style="font-size:1.8rem">{{trans('front-panier.total_ttc')}}</h6>
                            </div>
                        </div>
                        <div class="col-sm-6 text-center p-2 border-left">
                            <div class="total font-weight-bold" style="font-size:1.8rem;">@{{tarifTotalTaxe}} €</div>
                        </div>
                    </div>
                </div>

                <div class="mb-4 p-3 position-relative total-cart">
                    <div class="row">
                        <div class="col-sm-6 text-center vide"></div>
                        <div class="col-sm-6 text-center">
                        </div>
                        <div class="col-sm-9 text-center vide mt-3"></div>
                        <div class="col-sm-3 text-center mt-3 p-0">
                            <div class="text-center">
                                <a class="btn btn-primary text-white py-3 px-4 text-uppercase font-weight-bolder" href="{{ route('facturation') }}">{{trans('front-panier.valider_votre_panier')}}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    </section>
</panier>

@endsection