@extends('admin.customer-layout.layout.default')

@section('title', trans('admin.tarif.actions.index'))

@section('styles')
<style>
    .form-_label {
        display: flex;
        margin-bottom: 20px;
    }

    .form-_label>span {
        margin-left: 1em;
        height: auto !important;
    }

    .cliquable:hover {
        cursor: pointer;
        font-weight: 600 !important;
    }

    .table-listing .has-danger .form-control-feedback {
        bottom: -16px !important;
    }
</style>
@endsection

@section('body')
<detail-tarif-listing :detail="{{$data->toJson()}}" :url="'{{ $data->resource_url.'?heb='.$hebergement->id }}'" :action="'{{url('admin/tarifs') }}'" :urlbase="'{{base_url('')}}'" :urlasset="'{{asset('')}}'" :idheb="'{{$hebergement->id}}'" :urlchambre="'{{url('admin/chambres?heb='.$hebergement->id)}}'" :urlbasetype="'{{url('admin/base-types?heb='.$hebergement->id)}}'" :urlpersonne="'{{url('admin/type-personnes?heb='.$hebergement->id)}}'" :urlsaison="'{{url('admin/saisons?heb='.$hebergement->id)}}'" :urltarifvol="'{{url('admin/hebergement-vols')}}'" :urltarifwithvol="'{{url('admin/tarifs/vol')}}'" :urlallotement="'{{url('admin/allotements?heb='.$hebergement->id)}}'" inline-template>
    <div style="display: contents;position:relative" id="parent-loader">
        <div class="row">
            @include('admin.hebergement.view-header.header')
        </div>
        <div class="row has--child-nav">
            <div class="col-2 child-_nav" style="height: auto !important;">
                @include('admin.hebergement.view-header.nav-child')
            </div>
            <div class="col-10 content-_nav">
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i>
                        <a :href="urlbase+'/admin/tarifs?heb='+idheb">
                            <h3>{{ trans('admin.tarif.actions.index') }}</h3>
                        </a>
                    </div>
                    <div class="card-body" v-cloak v-for="(item,index) in data_detail" :key="item.id">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-_label d-none">
                                    <label for="titre" class="col-form-label text-md-right col-md-3">{{ trans('admin.tarif.columns.titre')}} </label>
                                    <span class="form-control cliquable" @click.prevent="editTarif($event,item.resource_url + '/edit')">@{{item.titre}}</span>
                                </div>
                                <div class="form-_label">
                                    <label for="type_chambre_id" class="col-form-label text-md-right col-md-3">{{ trans('admin.tarif.columns.chambre_id')}} </label>
                                    <span class="form-control cliquable" @click.prevent="editTarif($event,item.resource_url + '/edit')">@{{item.type_chambre.name}}</span>
                                </div>
                                <div class="form-_label">
                                    <label for="type_chambre_id" class="col-form-label text-md-right col-md-3">{{ trans('admin.tarif.columns.base_type_id')}} </label>
                                    <span class="form-control cliquable" @click.prevent="editTarif($event,item.resource_url + '/edit')">@{{item.base_type?item.base_type.titre:''}}</span>
                                </div>
                                <div class="form-_label">
                                    <label for="saison" class="col-form-label text-md-right col-md-3">{{ trans('admin.tarif.columns.saison_id')}} </label>
                                    <span class="form-control cliquable" @click.prevent="editTarif($event,item.resource_url + '/edit')">@{{item.saison.titre}}</span>
                                </div>
                                <div class="form-_label">
                                    <label for="jour_min" class="col-form-label text-md-right col-md-3">{{ trans('admin.tarif.columns.jour_min') }} </label>
                                    <span class="form-control flex-span-mi-colonne">
                                        <span class="cliquable left" @click.prevent="editTarif($event,item.resource_url + '/edit')">@{{item.jour_min?item.jour_min:0}}</span>
                                        <span style="color: #64666a; font-weight: 700; text-align: center;">{{ trans('admin.tarif.columns.nuit_min') }}</span>
                                        <span class="cliquable right" @click.prevent="editTarif($event,item.resource_url + '/edit')">@{{item.nuit_min?item.nuit_min:0}}</span>
                                    </span>
                                </div>

                                <div class="form-_label">
                                    <label for="jour_min" class="col-form-label text-md-right col-md-3">{{ trans('admin.tarif.columns.jour_max') }} </label>
                                    <span class="form-control flex-span-mi-colonne">
                                        <span class="cliquable left" @click.prevent="editTarif($event,item.resource_url + '/edit')">@{{item.jour_max?item.jour_max:0}}</span>
                                        <span style="color: #64666a; font-weight: 700;text-align: center;">{{ trans('admin.tarif.columns.nuit_max') }}</span>
                                        <span class="cliquable right" @click.prevent="editTarif($event,item.resource_url + '/edit')">@{{item.nuit_max?item.nuit_max:0}}</span>
                                    </span>
                                </div>

                                <div class="form-_label">
                                    <label for="description" class="col-form-label text-md-right col-md-3">{{ trans('admin.tarif.columns.description')}} </label>
                                    <span class="form-control cliquable" @click.prevent="editTarif($event,item.resource_url + '/edit')">@{{item.description}}</span>
                                </div>

                                <div class="form-_label">
                                    <label for="vol" class="col-form-label text-md-right col-md-3">{{ trans('admin.tarif.columns.vol')}} </label>
                                    <span v-if="item.vol" class="form-control cliquable" @click.prevent="editTarif($event,item.resource_url + '/edit')">{{trans('admin.hebergement-vol.columns.avec-vol')}}</span>
                                    <span v-if="!item.vol" class="form-control cliquable" @click.prevent="editTarif($event,item.resource_url + '/edit')">{{trans('admin.hebergement-vol.columns.sans-vol')}}</span>
                                </div>
                                <div class="form-_label" v-if="item.vol">
                                    <label for="lieu_depart" class="col-form-label text-md-right col-md-3">{{ trans('admin.billeterie-maritime.columns.lieu_depart')}} </label>
                                    <span class="form-control cliquable" @click.prevent="editTarif($event,item.resource_url + '/edit')">@{{item.vol.allotement.depart.name}}</span>
                                </div>
                                <div class="form-_label" v-if="item.vol">
                                    <label for="date_depart" class="col-form-label text-md-right col-md-3">{{ trans('admin.billeterie-maritime.columns.date_depart')}} </label>
                                    <span class="form-control cliquable" @click.prevent="editTarif($event,item.resource_url + '/edit')">@{{item.vol.allotement.depart.date_depart | date}}</span>
                                </div>
                                <div class="form-_label" v-if="item.vol">
                                    <label for="lieu_arrive" class="col-form-label text-md-right col-md-3">{{ trans('admin.billeterie-maritime.columns.lieu_arrive')}} </label>
                                    <span class="form-control cliquable" @click.prevent="editTarif($event,item.resource_url + '/edit')">@{{item.vol.allotement.arrive.name}}</span>
                                </div>
                                <div class="form-_label" v-if="item.vol">
                                    <label for="date_arrive" class="col-form-label text-md-right col-md-3">{{ trans('admin.billeterie-maritime.columns.date_arrive')}} </label>
                                    <span class="form-control cliquable" @click.prevent="editTarif($event,item.resource_url + '/edit')">@{{item.vol.allotement.depart.date_arrive | date}}</span>
                                </div>

                                <div class="form-_label" v-if="item.vol">
                                    <label for="compagnie" class="col-form-label text-md-right col-md-3">{{ trans('admin.billeterie-maritime.columns.compagnie_transport_id')}} </label>
                                    <span class="form-control cliquable" @click.prevent="editTarif($event,item.resource_url + '/edit')">@{{item.vol.allotement.compagnie.nom}}</span>
                                </div>
                                <div class="form-_label">
                                    <label for="type" class="col-form-label text-md-right col-md-3">{{ trans('admin.tarif.columns.tarif')}} </label>
                                    <span class="form-control" style="padding-right: 1em !important">
                                        <table class="table table-hover table-listing">
                                            <thead>
                                                <tr>
                                                    <th>{{ trans('admin.tarif.columns.type_personne_id') }}</th>
                                                    <th>{{ trans('admin.tarif.columns.prix_achat')}}</th>
                                                    <th>{{ trans('admin.tarif.columns.marge')}}</th>
                                                    <th>{{ trans('admin.tarif.columns.prix_vente')}}</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="tarif of item.tarif">
                                                    <td>@{{tarif.personne.type}}</td>
                                                    <td>@{{tarif.prix_achat}} <span class="unite-tarif">€</span></td>
                                                    <td>@{{tarif.marge}} <span class="unite-tarif">€</span></td>
                                                    <td>@{{tarif.prix_vente}} <span class="unite-tarif">€</span></td>
                                                    <td>
                                                        <div class="row no-gutters">
                                                            <div class="col-auto">
                                                                <button class="btn btn-sm btn-info" type="button" @click.prevent="editTarifPersonne($event,tarif.resource_url + '/edit','')"><i class="fa fa-edit"></i></button>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </span>
                                </div>
                                <div class="form-_label" v-if="item.base_type && item.type_chambre.capacite > item.base_type.nombre">
                                    <label for="type" class="col-form-label text-md-right col-md-3">{{ trans('admin.tarif.columns.tarif_supp')}} </label>
                                    <span class="form-control" style="padding-right: 1em !important">
                                        <table class="table table-hover table-listing">
                                            <thead>
                                                <tr>
                                                    <th>{{ trans('admin.tarif.columns.type_personne_id') }}</th>
                                                    <th>{{ trans('admin.tarif.columns.prix_achat')}}</th>
                                                    <th>{{ trans('admin.tarif.columns.marge')}}</th>
                                                    <th>{{ trans('admin.tarif.columns.prix_vente')}}</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="tarif of item.tarif">
                                                    <td>@{{tarif.personne.type}}</td>
                                                    <td>@{{tarif.prix_achat_supp}} <span class="unite-tarif">€</span></td>
                                                    <td>@{{tarif.marge_supp}} <span class="unite-tarif">€</span></td>
                                                    <td>@{{tarif.prix_vente_supp}} <span class="unite-tarif">€</span></td>
                                                    <td>
                                                        <div class="row no-gutters">
                                                            <div class="col-auto">
                                                                <button class="btn btn-sm btn-info" type="button" @click.prevent="editTarifPersonneSupp($event,tarif.resource_url + '/edit','')"><i class="fa fa-edit"></i></button>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <modal name="edit_tarif" :scrollable="true" :min-width="320" :max-width="1000" height="auto" width="100%" :draggable="true" @opened="myEvent.editTarif()" :adaptive="true">
            @include('admin.hebergement.tarif.edit')
        </modal>
        <modal name="edit_tarif_personne" :scrollable="true" :min-width="320" :max-width="1000" height="auto" width="100%" :draggable="true" @opened="myEvent.editTarifPersonne()" :adaptive="true">
            <form class="form-horizontal form-edit" id="edit-tarif-form" method="post" @submit.prevent="updateTarifForm($event,'edit_tarif_personne')" :action="actionEditTarifPersonne" novalidate>
                <div class="card-header">
                    <i class="fa fa-pencil"></i>
                    <h3> {{ trans('admin.tarif.actions.edit') }}</h3>
                    <a class="float-right text-danger" style="cursor:pointer;" @click.prevent="closeModal('edit_tarif_personne')"><i class="fa fa-times"></i></a>
                </div>

                <div class="card-body">
                    <div class="form-group row align-items-center">
                        <label for="type_personne" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.tarif.columns.type_personne') }}</label>
                        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
                            <input type="text" class="form-control" readonly name="type_personne">
                            <input type="text" name="type_personne_id" required class="form-control" style="display: none;">
                            <input type="text" name="tarif_id" required class="form-control" style="display: none;">
                        </div>
                    </div>
                    <div class="form-group row align-items-center">
                        <label for="montant" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.tarif.columns.marge') }}</label>
                        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
                            <input type="number" inputmode="decimal" step="any" min="0" class="form-control with-unite" @input="checkMarge($event,'')" name="marge">
                            <span style="position: absolute; left: 20px; top: 0; width:auto; height: 100%;display: flex;align-items: center; font-weight: 500; text-decoration: underline;font-size: 18px;">€</span>
                        </div>
                    </div>
                    <div class="form-group row align-items-center">
                        <label for="montant" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.tarif.columns.prix_achat') }}</label>
                        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
                            <input type="number" inputmode="decimal" step="any" min="0" class="form-control with-unite" @input="checkMarge($event,'')" name="prix_achat">
                            <span style="position: absolute; left: 20px; top: 0; width:auto; height: 100%;display: flex;align-items: center; font-weight: 500; text-decoration: underline;font-size: 18px;">€</span>
                        </div>
                    </div>
                    <div class="form-group row align-items-center">
                        <label for="montant" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.tarif.columns.prix_vente') }}</label>
                        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
                            <input type="number" inputmode="decimal" step="any" min="0" class="form-control with-unite" readonly name="prix_vente">
                            <span style="position: absolute; left: 20px; top: 0; width:auto; height: 100%;display: flex;align-items: center; font-weight: 500; text-decoration: underline;font-size: 18px;">€</span>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-download"></i>
                        {{ trans('admin-base.btn.save') }}
                    </button>
                </div>

            </form>
        </modal>
        <modal name="create_personne" :min-width="320" :max-width="1000" height="auto" width="100%" :draggable="true" @opened="myEvent.createPersonne()" :adaptive="true">
            @include('admin.hebergement.tarif.type-personne')
        </modal>
    </diV>
</detail-tarif-listing>

@endsection