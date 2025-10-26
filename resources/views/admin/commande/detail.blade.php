@extends('admin.customer-layout.layout.default')

@section('title', trans('admin.commande.actions.index'))

@section('body')

<commande-detail :data="{{ $data->toJson() }}" :url="'{{ url('admin/commandes') }}'" :action="'{{url('admin/commandes') }}'" :urlbase="'{{base_url('')}}'" :urlasset="'{{asset('')}}'" :modepayement="{{$modePayement->toJson()}}" inline-template>
    <div style="display: contents;position:relative">
        <div class="row" v-for="item of collection">
            <div class="col">
                <div class="card">
                    <div class="card-body" v-cloak>
                        <div class="card-block">
                            <div class="row">
                                <div class="border col-md px-4 py-2 mx-2 my-2">
                                    <form method="post" @submit.prevent="saveCommande($event)" :action="item.resource_url">
                                        <h4 class="mb-4">{{trans('front-panier.information_commande')}}</h4>
                                        <div>
                                            <div class="form-group row">
                                                <label for="id_commande" class="col-sm-4 col-form-label">{{trans('front-panier.id_commade')}} :</label>
                                                <div class="col-sm-8">
                                                    <input class="form-control" readonly type="text" id="id_commande" name="id" :value="item.id">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="date_commande" class="col-sm-4 col-form-label">{{trans('front-panier.date_commande')}} :</label>
                                                <div class="col-sm-8">
                                                    <input class="form-control" type="date" id="date_commande" name="date" @change="changeForm" :value="$parseDateToString(item.date)">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="status_commande" class="col-sm-4 col-form-label">{{trans('front-panier.etat_commande')}} :</label>
                                                <div class="col-sm-8">
                                                    <select class="form-control" name="status" id="status_commande" @change="changeForm" :value="item.status">
                                                        @foreach(config('ligne-commande.status') as $key => $value)
                                                        <option value="{{$value['id']}}">{{$value['value']}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="status_commande" class="col-sm-4 col-form-label">{{ trans('front-panier.mode_payement') }} :</label>
                                                <div class="col-sm-8">
                                                    <select class="form-control" name="mode_payement_id" id="status_commande" @change="changeForm" :value="item.mode_payement_id">
                                                        <option v-for="_payement of modepayement" :value="_payement.id">@{{_payement.titre}}</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="status_payement" class="col-sm-4 col-form-label">{{trans('front-panier.status_paiement')}} :</label>
                                                <div class="col-sm-8">
                                                    <select class="form-control" name="status_payement" id="status_payement" @change="changeForm" :value="item.status_payement">
                                                        @foreach(config('paiement.status') as $key => $value)
                                                        <option value="{{$key}}">{{$value}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="paiement_id" class="col-sm-4 col-form-label">{{trans('front-panier.reference_payement')}} :</label>
                                                <div class="col-sm-8">
                                                    <input class="form-control" readonly type="text" id="paiement_id" @change="changeForm" name="paiement_id" :value="item.paiement_id">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="devis_commande" class="col-sm-4 col-form-label">{{trans('front-panier.montant_commande')}} :</label>
                                                <div class="col-sm-8">
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">€</span>
                                                        </div>
                                                        <input type="text" class="form-control" readonly @change="changeForm" id="devis_commande" name="prix_total" :value="item.prix_total">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex align-center" v-if="change_form">
                                            <button class="btn btn-success ml-auto mr-0" type="submit">{{trans('admin-base.btn.save')}}</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-md-1"></div>
                                <div class=" border col-md px-4 py-2 mx-2 my-2">
                                    <h4 class="mb-4">{{trans('front-panier.facturation')}} </h4>
                                    <div>
                                        <div class="mb-1">
                                            <label>{{trans('front-panier.nom')}} : </label>
                                            <span>@{{item.facture.nom}}</span>
                                        </div>
                                        <div class="mb-1">
                                            <label>{{trans('front-panier.prenom')}} : </label>
                                            <span>@{{item.facture.prenom}}</span>
                                        </div>
                                        <div class="mb-1">
                                            <label>{{trans('front-panier.adresse')}} : </label>
                                            <span>@{{item.facture.adresse}}</span>
                                        </div>
                                        <div class="mb-1">
                                            <label>{{trans('front-panier.ville')}} : </label>
                                            <span>@{{item.facture.ville}}</span>
                                        </div>
                                        <div class="mb-1">
                                            <label>{{trans('front-panier.code_postal')}} : </label>
                                            <span>@{{item.facture.code_postal}}</span>
                                        </div>
                                        <div class="mb-1">
                                            <label>{{trans('front-panier.telephone')}} : </label>
                                            <span>@{{item.facture.telephone}}</span>
                                        </div>
                                        <div class="mb-1">
                                            <label>{{trans('front-panier.email')}} : </label>
                                            <span>@{{item.facture.email}}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col border px-2 py-2 mx-2 my-2">
                                    <div class="row title-tab text-white text-uppercase pt-3 pb-2 mb-4 mx-0 text-center position-relative" style="background-color: #77a464; ">
                                        <div class="col-sm-3">
                                            <a href="#" class="text-white"> {{trans('front-panier.telecharger_version_pdf')}} <i class="fa fa-download"></i></a>
                                        </div>
                                        <div class="col-sm-7">
                                            <h5>{{trans('front-panier.votre_devis')}}</h5>
                                        </div>
                                        <div class="col-sm-2">
                                            <h5>{{trans('front-panier.sous_total')}}</h5>
                                        </div>
                                    </div>
                                    <div class="border mt-4 pt-3 px-3 position-relative" v-if="item.billeterie.length > 0">
                                        <div class="categorie-produit position-absolute">{{trans('front-panier.billetterie')}}</div>
                                        <div class="border-top mt-4 p-3 position-relative" v-for="(_item,index) in item.billeterie">
                                            <div class="row">
                                                <div class="col-sm-3 d-flex flex-column position-relative">
                                                    <img :src="urlasset+'/'+_item.image" class="img-fluid w-100">
                                                    <div class="text-center mt-auto mb-0">
                                                        <a href="#" class="text-info"> {{trans('front-panier.telecharger_voucher')}} <i class="fa fa-download"></i></a>
                                                    </div>
                                                </div>
                                                <div class="col-sm-7">
                                                    <h5 class="text-decoration-none text-primary">@{{_item.titre}}</h5>
                                                    <table width="100%" class="my-3">
                                                        <tbody>
                                                            <tr>
                                                                <th colspan="2" style="font-size: large;">{{trans('front-billeterie.aller')}} </th>
                                                            </tr>
                                                            <tr>
                                                                <th width="50%">{{trans('front-billeterie.port_depart')}} : </th>
                                                                <td>@{{_item.lieu_depart_name}}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>{{trans('front-billeterie.port_arrive')}} : </th>
                                                                <td>@{{_item.lieu_arrive_name}}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>{{trans('front-billeterie.date_et_heure_depart')}} : </th>
                                                                <td>@{{$formatDateString(_item.date_depart,true)}} à @{{_item.heure_aller | formatTime }}</td>
                                                            </tr>
                                                            <tr v-if="_item.parcours == 2">
                                                                <td style="height: 10px;"></td>
                                                            </tr>
                                                            <tr v-if="_item.parcours == 2">
                                                                <th colspan="2" style="font-size: large;">{{trans('front-billeterie.retour')}} </th>
                                                            </tr>
                                                            <tr v-if="_item.parcours == 2">
                                                                <th width="50%">{{trans('front-billeterie.port_depart')}} : </th>
                                                                <td>@{{_item.lieu_arrive_name}}</td>
                                                            </tr>
                                                            <tr v-if="_item.parcours == 2">
                                                                <th>{{trans('front-billeterie.port_arrive')}} : </th>
                                                                <td>@{{_item.lieu_depart_name}}</td>
                                                            </tr>
                                                            <tr v-if="_item.parcours == 2">
                                                                <th>{{trans('front-billeterie.date_et_heure_retour')}} : </th>
                                                                <td>@{{$formatDateString(_item.date_retour,true)}} à @{{_item.heure_retour | formatTime}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="height: 10px;"></td>
                                                            </tr>
                                                            <tr>
                                                                <th colspan="2" style="font-size: large;">{{trans('front-billeterie.passagers')}} </th>
                                                            </tr>
                                                            <tr v-for="_item_personne of _item.personne">
                                                                <th>@{{_item_personne.type}} : </th>
                                                                <td>@{{_item_personne.nb}}</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="col-sm-2 text-center border-left d-flex align-items-center">
                                                    <div class="subtotal m-auto">@{{_item.prix_total}}€</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="border mt-4 pt-3 px-3 position-relative" v-if="item.excursion.length > 0">
                                        <div class="categorie-produit position-absolute">{{trans('front-panier.excursion')}}</div>
                                        <div class="border-top mt-4 p-3 position-relative" v-for="(_item,index) in item.excursion">
                                            <div class="row">
                                                <div class="col-sm-3 d-flex flex-column position-relative">
                                                    <img :src="urlasset+'/'+_item.fond_image" class="img-fluid w-100">
                                                    <div class="text-center mt-auto mb-0">
                                                        <a href="#" class="text-info"> {{trans('front-panier.telecharger_voucher')}} <i class="fa fa-download"></i></a>
                                                    </div>
                                                </div>
                                                <div class="col-sm-7">
                                                    <h5 class="text-decoration-none text-primary">@{{_item.title}}</h5>
                                                    <table width="100%" class="my-3">
                                                        <tbody>
                                                            <tr>
                                                                <th width="50%">{{trans('front-excursion.date_excursion')}} :</th>
                                                                <td>@{{$formatDateString(_item.date_excursion,true)}}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>{{trans('front-excursion.destination')}} :</th>
                                                                <td>@{{_item.ile.name}}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>{{trans('front-excursion.duree')}} :</th>
                                                                <td>@{{_item.duration}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="height: 10px;"></td>
                                                            </tr>
                                                            <tr>
                                                                <th colspan="2" style="font-size: large;">{{trans('front-excursion.personnes')}} </th>
                                                            </tr>
                                                            <tr v-for="_item_personne of _item.personne">
                                                                <th>@{{_item_personne.type}} : </th>
                                                                <td>@{{_item_personne.nb}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="height: 10px;"></td>
                                                            </tr>
                                                            <tr>
                                                                <th>{{trans('front-excursion.supplements')}} :</th>
                                                                <td class="detail-info">
                                                                    @{{calculerSupplement(_item.supplement)}}€
                                                                    <div class="detail-block position-absolute">
                                                                        <ul class="list-info">
                                                                            <li v-for="_child_supp of _item.supplement"><span class="font-weight-bold float-left">@{{_child_supp.titre}} :</span> <span class="float-right">@{{_child_supp.prix}}€</span></li>
                                                                        </ul>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="col-sm-2 text-center border-left d-flex align-items-center">
                                                    <div class="subtotal m-auto">@{{_item.prix_total}}€</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="border mt-4 pt-3 px-3 position-relative" v-if="item.hebergement.length > 0">
                                        <div class="categorie-produit position-absolute">{{trans('front-panier.hebergement')}}</div>
                                        <div class="border-top mt-4 p-3 position-relative" v-for="(_item,index) in item.hebergement">
                                            <div class="row">
                                                <div class="col-sm-3 d-flex flex-column position-relative">
                                                    <img :src="urlasset+'/'+_item.chambre_image" class="img-fluid w-100">
                                                    <div class="text-center mt-auto mb-0">
                                                        <a href="#" class="text-info"> {{trans('front-panier.telecharger_voucher')}} <i class="fa fa-download"></i></a>
                                                    </div>
                                                </div>
                                                <div class="col-sm-7">
                                                    <h5 class="text-decoration-none text-primary">@{{_item.chambre_name}}</h5>
                                                    <table width="100%" class="my-3">
                                                        <tbody>
                                                            <tr>
                                                                <th width="50%">{{trans('front-hebergement.transport')}} :</th>
                                                                <td v-if="$isEmpty(_item.vol) == true">Avec vol</td>
                                                                <td v-if="$isEmpty(_item.vol) == false">Sans vol</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="height: 10px;"></td>
                                                            </tr>
                                                            <tr>
                                                                <th>{{trans('front-hebergement.nombre_nuits')}} : </th>
                                                                <td>@{{ $intervalDateDays(_item.date_debut,_item.date_fin,true)}}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>{{trans('front-hebergement.dates_sejour')}} : </th>
                                                                <td>@{{ $formatDateString(_item.date_debut,true) }} au @{{ $formatDateString(_item.date_fin,true)}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="height: 10px;"></td>
                                                            </tr>
                                                            <tr>
                                                                <th>{{trans('front-hebergement.base_type')}} : </th>
                                                                <td>@{{_item.chambre_base_type_titre}} (@{{_item.chambre_base_type_nombre}}Pers.)</td>
                                                            </tr>
                                                            <tr>
                                                                <th>{{trans('front-hebergement.capacite_max')}} : </th>
                                                                <td>@{{_item.chambre_capacite}} Pers.</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="height: 10px;"></td>
                                                            </tr>
                                                            <tr>
                                                                <th colspan="2" style="font-size: large;">{{trans('front-hebergement.personnes')}} </th>
                                                            </tr>
                                                            <tr v-for="_item_personne of _item.personne">
                                                                <th>@{{_item_personne.type}} : </th>
                                                                <td>@{{_item_personne.nb}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="height: 10px;"></td>
                                                            </tr>
                                                            <tr>
                                                                <th>{{trans('front-hebergement.supplements')}} :</th>
                                                                <td class="detail-info">
                                                                    @{{calculerSupplement(_item.supplement)}}€
                                                                    <div class="detail-block position-absolute">
                                                                        <ul class="list-info">
                                                                            <li v-for="_child_supp of _item.supplement"><span class="font-weight-bold float-left">@{{_child_supp.titre}} :</span> <span class="float-right">@{{_child_supp.prix}}€</span></li>
                                                                        </ul>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="col-sm-2 text-center border-left d-flex align-items-center">
                                                    <div class="subtotal m-auto">@{{_item.prix_total}}€</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="border mt-4 pt-3 px-3 position-relative" v-if="item.location.length > 0">
                                        <div class="categorie-produit position-absolute">{{trans('front-panier.location')}}</div>
                                        <div class="border-top mt-4 p-3 position-relative" v-for="(_item,index) in item.location">
                                            <div class="row">
                                                <div class="col-sm-3 d-flex flex-column position-relative">
                                                    <img :src="urlasset+'/'+_item.image" class="img-fluid w-100">
                                                    <div class="text-center mt-auto mb-0">
                                                        <a href="#" class="text-info"> {{trans('front-panier.telecharger_voucher')}} <i class="fa fa-download"></i></a>
                                                    </div>
                                                </div>
                                                <div class="col-sm-7">
                                                    <h5 class="text-decoration-none text-primary">@{{_item.titre}}</h5>
                                                    <table width="100%" class="my-3">
                                                        <tbody>
                                                            <tr>
                                                                <th width="45%">{{trans('front-location.lieu_depart')}} : </th>
                                                                <td>@{{_item.agence_recuperation_name}}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>{{trans('front-location.date_et_heure_depart')}} : </th>
                                                                <td>@{{$formatDateString(_item.date_recuperation,true)}} à @{{_item.heure_recuperation | formatTime}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="height: 10px;"></td>
                                                            </tr>
                                                            <tr>
                                                                <th>{{trans('front-location.lieu_retour')}} : </th>
                                                                <td>@{{_item.agence_restriction_name}}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>{{trans('front-location.date_et_heure_retour')}} : </th>
                                                                <td>@{{$formatDateString(_item.date_restriction,true)}} à @{{_item.heure_restriction | formatTime}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="height: 10px;"></td>
                                                            </tr>
                                                            <tr v-if="_item.franchise != 0">
                                                                <th>{{trans('front-location.franchise')}} :</th>
                                                                <td class="detail-info">
                                                                    @{{_item.franchise}}€
                                                                </td>
                                                            </tr>
                                                            <tr v-if="_item.caution != 0">
                                                                <th>{{trans('front-location.caution')}} :</th>
                                                                <td class="detail-info">
                                                                    @{{_item.caution}}€
                                                                </td>
                                                            </tr>
                                                            <tr v-if="_item.franchise_non_rachatable != 0">
                                                                <th>{{trans('front-location.franchise_non_rachatable')}} :</th>
                                                                <td class="detail-info">
                                                                    @{{_item.franchise_non_rachatable}}€
                                                                </td>
                                                            </tr>
                                                            <tr v-if="_item.deplacement_lieu_tarif != 0">
                                                                <th>{{trans('front-location.supplement_deplacements')}} :</th>
                                                                <td class="detail-info">
                                                                    @{{_item.deplacement_lieu_tarif}}€
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <div style="position: relative;" v-if="_item.info_tech && _item.info_tech.fiche_technique">
                                                        <a class="text-success font-weight-bold" style="cursor: pointer;" :href="`${urlasset}/${_item.info_tech.fiche_technique}`" :download="_item.modele_vehicule_titre">Fiche technique <i class="fa fa-download"></i></a>
                                                    </div>
                                                    <div style="position: relative;margin-top: 10px;">
                                                        <span class="text-success font-weight-bold info-conduct-titre">{{trans('front-location.information_conducteur')}}</span>
                                                        <input type="checkbox" class="info-conduct">
                                                        <div class="row content-info-conducteur">
                                                            <div class="col-12">
                                                                <div class="row my-2" style="text-align: center; ">
                                                                    <div class="col">
                                                                        <a style="background-color: #f0e9e9; cursor: pointer;padding: 5px;" :href="`${urlbase}/conducteur-info/${_item.id}`" target="_blank"> Télécharger en pdf <i class="fa fa-download"></i></a>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-12" style="margin-bottom: 10px;">
                                                                        <span style="font-weight: bold;white-space: nowrap;">{{trans('front-location.nom')}} : </span>
                                                                        <span style="padding-left: 10px">@{{_item.nom_conducteur}}</span>
                                                                    </div>
                                                                    <div class="col-12" style="margin-bottom: 10px;">
                                                                        <span style="font-weight: bold;white-space: nowrap;">{{trans('front-location.prenom')}} : </span>
                                                                        <span style="padding-left: 10px">@{{_item.prenom_conducteur}}</span>
                                                                    </div>
                                                                    <div class="col-12" style="margin-bottom: 10px;">
                                                                        <span style="font-weight: bold;white-space: nowrap;">{{trans('front-location.adresse')}} : </span>
                                                                        <span style="padding-left: 10px">@{{_item.adresse_conducteur}}</span>
                                                                    </div>
                                                                    <div class="col-12" style="margin-bottom: 10px;">
                                                                        <span style="font-weight: bold;white-space: nowrap;">{{trans('front-location.ville')}} : </span>
                                                                        <span style="padding-left: 10px">@{{_item.ville_conducteur}}</span>
                                                                    </div>
                                                                    <div class="col-12" style="margin-bottom: 10px;">
                                                                        <span style="font-weight: bold;white-space: nowrap;">{{trans('front-location.code_postal')}} : </span>
                                                                        <span style="padding-left: 10px">@{{_item.code_postal_conducteur}}</span>
                                                                    </div>
                                                                    <div class="col-12" style="margin-bottom: 10px;">
                                                                        <span style="font-weight: bold;white-space: nowrap;">{{trans('front-location.telephone')}} : </span>
                                                                        <span style="padding-left: 10px">@{{_item.telephone_conducteur}}</span>
                                                                    </div>
                                                                    <div class="col-12" style="margin-bottom: 10px;">
                                                                        <span style="font-weight: bold;white-space: nowrap;">{{trans('front-location.email')}} : </span>
                                                                        <span style="padding-left: 10px">@{{_item.email_conducteur}}</span>
                                                                    </div>
                                                                    <div class="col-12" style="margin-bottom: 10px;">
                                                                        <span style="font-weight: bold;white-space: nowrap;">{{trans('front-location.date_naissance')}} : </span>
                                                                        <span style="padding-left: 10px">@{{_item.date_naissance_conducteur}}</span>
                                                                    </div>
                                                                    <div class="col-12" style="margin-bottom: 10px;">
                                                                        <span style="font-weight: bold;white-space: nowrap;">{{trans('front-location.lieu_naissance')}} : </span>
                                                                        <span style="padding-left: 10px">@{{_item.lieu_naissance_conducteur}}</span>
                                                                    </div>
                                                                    <div class="col-12" style="margin-bottom: 10px;">
                                                                        <span style="font-weight: bold;white-space: nowrap;">{{trans('front-location.numero_permis')}} : </span>
                                                                        <span style="padding-left: 10px">@{{_item.num_permis_conducteur}}</span>
                                                                    </div>
                                                                    <div class="col-12" style="margin-bottom: 10px;">
                                                                        <span style="font-weight: bold;white-space: nowrap;">{{trans('front-location.date_permis')}} : </span>
                                                                        <span style="padding-left: 10px">@{{_item.date_permis_conducteur}}</span>
                                                                    </div>
                                                                    <div class="col-12" style="margin-bottom: 10px;">
                                                                        <span style="font-weight: bold;white-space: nowrap;">{{trans('front-location.lieu_delivrance_permis')}} : </span>
                                                                        <span style="padding-left: 10px">@{{_item.lieu_deliv_permis_conducteur}}</span>
                                                                    </div>
                                                                    <div class="col-12" style="margin-bottom: 10px;">
                                                                        <span style="font-weight: bold;white-space: nowrap;">{{trans('front-location.numero_piece_identite')}} : </span>
                                                                        <span style="padding-left: 10px">@{{_item.num_identite_conducteur}}</span>
                                                                    </div>
                                                                    <div class="col-12" style="margin-bottom: 10px;">
                                                                        <span style="font-weight: bold;white-space: nowrap;">{{trans('front-location.date_delivrance_identite')}} : </span>
                                                                        <span style="padding-left: 10px">@{{_item.date_emis_identite_conducteur}}</span>
                                                                    </div>
                                                                    <div class="col-12" style="margin-bottom: 10px;">
                                                                        <span style="font-weight: bold;white-space: nowrap;">{{trans('front-location.lieu_delivrance_identite')}} : </span>
                                                                        <span style="padding-left: 10px">@{{_item.lieu_deliv_identite_conducteur}}</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-2 text-center border-left d-flex align-items-center">
                                                    <div class="subtotal m-auto">@{{_item.prix_total}}€</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="border mt-4 pt-3 px-3 position-relative" v-if="item.transfert.length > 0">
                                        <div class="categorie-produit position-absolute">{{trans('front-panier.transfert')}}</div>
                                        <div class="border-top mt-4 p-3 position-relative" v-for="(_item,index) in item.transfert">
                                            <div class="row">
                                                <div class="col-sm-3 d-flex flex-column position-relative">
                                                    <img :src="urlasset+'/'+_item.image" class="img-fluid w-100">
                                                    <div class="text-center mt-auto mb-0">
                                                        <a href="#" class="text-info"> {{trans('front-panier.telecharger_voucher')}} <i class="fa fa-download"></i></a>
                                                    </div>
                                                </div>
                                                <div class="col-sm-7">
                                                    <h5 class="text-decoration-none text-primary">@{{_item.titre}}</h5>
                                                    <table width="100%" class="my-3">
                                                        <tbody>
                                                            <tr>
                                                                <th colspan="2" style="font-size: large;">{{trans('front-transfert.aller')}}</th>
                                                            </tr>
                                                            <tr>
                                                                <th width="50%">{{trans('front-transfert.lieu_depart')}} : </th>
                                                                <td>@{{_item.lieu_depart_name}}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>{{trans('front-transfert.lieu_arrive')}} : </th>
                                                                <td>@{{_item.lieu_arrive_name}}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>{{trans('front-transfert.date_et_heure_depart')}} : </th>
                                                                <td>@{{$formatDateString(_item.date_depart,true)}} à @{{_item.heure_depart | formatTime }}</td>
                                                            </tr>
                                                            <tr v-if="_item.prime_depart > 0">
                                                                <th>{{trans('front-transfert.prime_nuit')}} : </th>
                                                                <td>@{{_item.prime_depart}}€</td>
                                                            </tr>
                                                            <tr v-if="_item.parcours == 2">
                                                                <td style="height: 10px;"></td>
                                                            </tr>
                                                            <tr v-if="_item.parcours == 2">
                                                                <th colspan="2" style="font-size: large;">{{trans('front-transfert.retour')}}</th>
                                                            </tr>
                                                            <tr v-if="_item.parcours == 2">
                                                                <th width="50%">{{trans('front-transfert.lieu_depart')}} : </th>
                                                                <td>@{{_item.lieu_arrive_name}}</td>
                                                            </tr>
                                                            <tr v-if="_item.parcours == 2">
                                                                <th>{{trans('front-transfert.lieu_arrive')}} : </th>
                                                                <td>@{{_item.lieu_depart_name}}</td>
                                                            </tr>
                                                            <tr v-if="_item.parcours == 2">
                                                                <th>{{trans('front-transfert.date_et_heure_retour')}} : </th>
                                                                <td>@{{$formatDateString(_item.date_retour,true)}} à @{{_item.heure_retour | formatTime}}</td>
                                                            </tr>
                                                            <tr v-if="_item.prime_retour > 0">
                                                                <th>{{trans('front-transfert.prime_nuit')}} : </th>
                                                                <td>@{{_item.prime_retour}}€</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="height: 10px;"></td>
                                                            </tr>
                                                            <tr>
                                                                <th colspan="2" style="font-size: large;">{{trans('front-transfert.passagers')}} </th>
                                                            </tr>
                                                            <tr v-for="_item_personne of _item.personne">
                                                                <th>@{{_item_personne.type}} : </th>
                                                                <td>@{{_item_personne.nb}}</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="col-sm-2 text-center border-left d-flex align-items-center">
                                                    <div class="subtotal m-auto">@{{_item.prix_total}}€</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="border mt-3 mb-5 px-3 position-relative">
                                        <div class="position-relative px-3">
                                            <div class="position-relative">
                                                <div class="row">
                                                    <div class="col-sm-10 border-bottom d-flex align-items-center" style="margin-bottom: -1px; font-weight: 800; font-size: 1rem;text-transform: uppercase;">
                                                        {{trans('front-panier.frais_dossier')}}
                                                    </div>
                                                    <div class="col-sm-2 text-center border-left d-flex align-items-center px-0 mx-0 border-bottom" style="margin-bottom: -1px;">
                                                        <div class="subtotal m-auto">@{{item.frais_dossier}}€</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="border mt-3 px-3 position-relative">
                                        <div class="px-3 position-relative">
                                            <div class="row">
                                                <div class="col-sm-10 text-uppercase text-center p-2 position-relative">
                                                    <div class="total-titre">
                                                        <h6 class="font-weight-bold" style="font-size:1rem">{{trans('front-panier.tva')}}</h6>
                                                    </div>
                                                </div>
                                                <div class="col-sm-2 text-center p-2 border-left">
                                                    <div class="total font-weight-bold">@{{item.tva}} €</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="border mt-3 px-3 position-relative">
                                        <div class="px-3 position-relative">
                                            <div class="row">
                                                <div class="col-sm-10 text-uppercase text-center p-2 position-relative">
                                                    <div class="total-titre">
                                                        <h6 class="font-weight-bold" style="font-size:1rem">{{trans('front-panier.ht')}}</h6>
                                                    </div>
                                                </div>
                                                <div class="col-sm-2 text-center p-2 border-left">
                                                    <div class="total font-weight-bold">@{{item.prix}} €</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="border mt-3 px-3 position-relative">
                                        <div class="px-3 position-relative">
                                            <div class="row">
                                                <div class="col-sm-10 text-uppercase text-center p-2 position-relative">
                                                    <div class="total-titre">
                                                        <h6 class="font-weight-bold" style="font-size:1rem">{{trans('front-panier.total_ttc')}}</h6>
                                                    </div>
                                                </div>
                                                <div class="col-sm-2 text-center p-2 border-left">
                                                    <div class="total font-weight-bold">@{{item.prix_total}} €</div>
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
        </div>
    </div>
</commande-detail>

@endsection