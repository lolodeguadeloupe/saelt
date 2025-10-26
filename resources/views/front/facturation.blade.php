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

@section('title', trans('front-panier.facturation'))

@section('content')

<section class="banner page banner-overlay background-cover bg-dark pb-5 position-relative pt-5 text-white" style="background-image: {{'url(\''.asset('/assets/img/ct_sea-418742_1920.jpg').'\')'}};">
    <div class="container mt-5 pt-4">
        <div class="row">
            <div class="col-md text-center">
                <h1 class="text-uppercase">{{trans('front-panier.facturation')}}</h1>
            </div>
        </div>
    </div>
</section>

<facturation :url="'{{route('facturation')}}'" :urlbase="'{{base_url('')}}'" :urlasset="'{{asset('')}}'" :data="{{$data->toJson()}}" :aside="{{$aside}}" :sessionrequest="{{$session_request}}" :keysessionrequest="'{{app('request')->has('key_')?app('request')->key_:''}}'" :tva="{{$TVA->toJson()}}" :modepayement="{{$modePayement->toJson()}}" :fraisdossier="{{$fraisdossier->toJson()}}" inline-template>
    <section class="py-5">
        <div class="container p-3" style="background-color:#eaeaea" v-if="length_pannier==0">
            <p class="mb-0"><i class="fas fa-shopping-cart mr-3" style="font-size: 1rem;"></i>{{trans('front-panier.votre_panier_est_actuellement_vide')}}.</p>
        </div>
        <div class="container-fluid px-5" v-if="length_pannier>0">
            <div class="row px-5">
                <div class="col-lg-7">
                    <div class="pb-3 border-bottom">
                        <h4>{{trans('front-panier.detail_de_votre_facture')}}</h4>
                        <hr class="separator mb-4 ml-0">
                        <form id="form-facturation">
                            <div class="row">
                                <div class="col-md">
                                    <div class="form-group">
                                        <label for="nom">{{trans('front-panier.nom')}} <span style="color:#ab2e30">*</span> :</label>
                                        <input data-ctr="alph" class="form-control" type="text" id="nom" name="nom" required>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="form-group">
                                        <label for="prenom">{{trans('front-panier.prenom')}} <span style="color:#ab2e30">*</span> :</label>
                                        <input data-ctr="alph" class="form-control" type="text" id="prenom" name="prenom" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md">
                                    <div class="form-group">
                                        <label for="adresse">{{trans('front-panier.adresse')}} <span style="color:#ab2e30">*</span> :</label>
                                        <input data-ctr="alph-num" class="form-control" type="text" id="adresse" name="adresse" required>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="form-group">
                                        <label for="ville">{{trans('front-panier.ville')}} <span style="color:#ab2e30">*</span> :</label>
                                        <input data-ctr="alph-num" class="form-control" type="text" id="ville" name="ville" required>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="form-group">
                                        <label for="code-postal">{{trans('front-panier.code_postal')}} <span style="color:#ab2e30">*</span> :</label>
                                        <input class="form-control" data-ctr="code-postal" type="text" id="code-postal" name="code_postal" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md">
                                    <div class="form-group">
                                        <label for="telephone">{{trans('front-panier.telephone')}} <span style="color:#ab2e30">*</span> :</label>
                                        <input data-ctr="phone" placeholder="xxxxxxxxx" class="form-control" type="text" id="telephone" name="telephone" required>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="form-group">
                                        <label for="mobile">{{trans('front-panier.email')}} <span style="color:#ab2e30">*</span> :</label>
                                        <input data-ctr="email" class="form-control" type="text" id="email" name="email" required>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="pt-4 pb-3">
                        <h4>{{trans('front-panier.informations_complementaires')}}</h4>
                        <hr class="separator mb-4 ml-0">
                        <form id="info-complementaire">
                            <label for="info-add">{{trans('front-panier.notes_de_commande')}}</label>
                            <textarea class="form-control" name="order_comments" id="info-add" cols="30" rows="10"></textarea>
                            <div class="checkbox mt-4 font-size-0-8-em d-flex align-items-center">
                                <input id="checkboxa1" type="checkbox" class="mr-2 input-checked-confirm" name="new_compte">
                                <label for="checkboxa1" class="label-checked-confirm mb-0">{{trans('front-panier.creer_un_compte')}}.</label>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-5 border-left">
                    <div class="pb-3">
                        <h4>{{trans('front-panier.details_des_commandes')}}</h4>
                        <hr class="separator mb-4 ml-0">

                        <div class="border position-relative mt-5" v-if="billeterie.length > 0">
                            <div class="categorie-produit position-absolute">{{trans('front-panier.billetterie')}}</div>
                            <div class="container position-relative" v-for="(item,index) in billeterie">
                                <div class="row">
                                    <div class="col-sm-10 border-bottom p-3" style="margin-bottom: -1px;">
                                        <h5 class="text-decoration-none text-primary pt-3">@{{item.data.item.depart.name}} - @{{item.data.item.arrive.name}}</h5>
                                        <img :src="urlasset+'/'+item.image" class="image-une-facturation">
                                        <table width="100%" class="my-3">
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
                                    <div class="col-sm-2 text-center border-left d-flex align-items-center px-0 mx-0 border-bottom" style="margin-bottom: -1px;">
                                        <div class="subtotal m-auto">@{{$parseFloat(item.computed.prixTotal)}}€ (ttc)</div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="border position-relative mt-5" v-if="excursion.length > 0">
                            <div class="categorie-produit position-absolute">{{trans('front-panier.excursion')}}</div>
                            <div class="container position-relative" v-for="(item,index) in excursion">
                                <div class="row">
                                    <div class="col-sm-10 border-bottom p-3" style="margin-bottom: -1px;">
                                        <h5 class="text-decoration-none text-primary pt-3">@{{item.titre}}</h5>
                                        <img :src="urlasset+'/'+item.image" class="image-une-facturation">
                                        <table width="100%" class="my-3">
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
                                    <div class="col-sm-2 text-center border-left d-flex align-items-center px-0 mx-0 border-bottom" style="margin-bottom: -1px;">
                                        <div class="subtotal m-auto">@{{$parseFloat(item.computed.prixTotal)}}€ (ttc)</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="border position-relative mt-5" v-if="hebergement.length > 0">
                            <div class="categorie-produit position-absolute">{{trans('front-panier.hebergement')}}</div>
                            <div class="container position-relative" v-for="(item,index) in hebergement">
                                <div class="row">
                                    <div class="col-sm-10 border-bottom p-3" style="margin-bottom: -1px;">
                                        <h5 class="text-decoration-none text-primary pt-3">@{{item.titre}}</h5>
                                        <img :src="urlasset+'/'+item.image" class="image-une-facturation">
                                        <table width="100%" class="my-3">
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
                                        </table>
                                    </div>
                                    <div class="col-sm-2 text-center border-left d-flex align-items-center px-0 mx-0 border-bottom" style="margin-bottom: -1px;">
                                        <div class="subtotal m-auto">@{{$parseFloat(item.computed.prixTotal)}}€ (ttc)</div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="border position-relative mt-5" v-if="location.length > 0">
                            <div class="categorie-produit position-absolute">{{trans('front-panier.location')}}</div>
                            <div class="container position-relative" v-for="(item,index) in location">
                                <div class="row">
                                    <div class="col-sm-10 border-bottom p-3" style="margin-bottom: -1px;">
                                        <h5 class="text-decoration-none text-primary pt-3">@{{item.data.item.categorie.titre}}</h5>
                                        <img :src="urlasset+'/'+item.image" class="image-une-facturation">
                                        <table width="100%" class="my-3">
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
                                    </div>
                                    <div class="col-sm-2 text-center border-left d-flex align-items-center px-0 mx-0 border-bottom" style="margin-bottom: -1px;">
                                        <div class="subtotal m-auto">@{{$parseFloat(item.computed.prixTotal)}}€ (ttc)</div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="border position-relative mt-5" v-if="transfert.length > 0">
                            <div class="categorie-produit position-absolute">{{trans('front-panier.transfert')}}</div>
                            <div class="container position-relative" v-for="(item,index) in transfert">
                                <div class="row">
                                    <div class="col-sm-10 border-bottom p-3" style="margin-bottom: -1px;">
                                        <h5 class="text-decoration-none text-primary pt-3">@{{item.titre}}</h5>
                                        <img :src="urlasset+'/'+item.image" class="image-une-facturation">
                                        <table width="100%" class="my-3">
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
                                    <div class="col-sm-2 text-center border-left d-flex align-items-center px-0 mx-0 border-bottom" style="margin-bottom: -1px;">
                                        <div class="subtotal m-auto">@{{$parseFloat(item.computed.prixTotal)}}€ (ttc)</div>
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
                                        <h6 class="font-weight-bold" style="font-size:1.2rem;">{{trans('front-panier.tva')}}</h6>
                                    </div>
                                </div>
                                <div class="col-sm-6 text-center p-2 border-left">
                                    <div class="total font-weight-bold" style="font-size:1.2rem;">@{{taxe_tva}} €</div>
                                </div>
                            </div>
                            <div class="row border-left border-right border-bottom">
                                <div class="col-sm-6 text-uppercase text-center p-2 position-relative">
                                    <div class="total-titre">
                                        <h6 class="font-weight-bold" style="font-size:1.2rem;">{{trans('front-panier.ht')}}</h6>
                                    </div>
                                </div>
                                <div class="col-sm-6 text-center p-2 border-left">
                                    <div class="total font-weight-bold" style="font-size:1.2rem;">@{{tarifTotal}} €</div>
                                </div>
                            </div>
                            <div class="row border-left border-right border-bottom">
                                <div class="col-sm-6 text-uppercase text-center p-2 position-relative">
                                    <div class="total-titre">
                                        <h6 class="font-weight-bold" style="font-size:1.8rem;">{{trans('front-panier.total_ttc')}}</h6>
                                    </div>
                                </div>
                                <div class="col-sm-6 text-center p-2 border-left">
                                    <div class="total font-weight-bold" style="font-size:1.8rem;">@{{tarifTotalTaxe}} €</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="pt-4 pb-3">
                        <h4>Mode de paiement</h4>
                        <hr class="separator mb-4 ml-0">
                        <div class="mb-4">
                            <form id="payment-mode">
                                <div v-for="_payement of modepayement">
                                    <div class="form-check-inline">
                                        <label class="form-check-label mb-2" :for="'payement'+_payement.id">
                                            <input type="radio" class="form-check-input mx-3" :id="'payement'+_payement.id" required name="payement" :value="_payement.id">
                                            <img v-if="_payement.icon != null" :src="urlasset+'/'+_payement.icon" class="img-fluid" style="height: 30px">
                                            <span v-if="_payement.icon == null"> @{{_payement.titre}}</span>
                                        </label>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 d-flex align-items-center">
                    <div class="checkbox float-left d-flex align-items-center">
                        <input id="checkboxa2" type="checkbox" v-model="accepted" class="mr-2 input-checked-confirm">
                        <label for="checkboxa2" class="mb-0 label-checked-confirm">{{trans('front-panier.j_accepte_toutes_les_informations_et_')}} </label>&nbsp;<span class="label-checked-confirm link-checked-confirm" @click.prevent="$modal.show('terme-condition')"> {{trans('front-panier._les_conditions')}}.</span>
                    </div>
                </div>
                <div class="col-lg-6 d-flex align-items-center">
                    <div class="m-auto" @click.prevent="ajouterFacturation">
                        <a v-if="accepted" @contextmenu.prevent="" class="btn btn-primary text-white py-2 px-4 text-uppercase" href="{{ route('home') }}">{{trans('front-panier.proceder_au_paiement')}}</a>
                    </div>
                </div>
            </div>
        </div>
        <modal name="terme-condition" :class="'max-width'" :click-to-close="false" :scrollable="true" height="auto" width="90%" :draggable="true" :adaptive="true">
            @include('front.terme-condition')
        </modal>
    </section>
</facturation>

@endsection