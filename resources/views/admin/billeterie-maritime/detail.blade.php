@extends('admin.customer-layout.layout.default')

@section('title', trans('admin.billeterie-maritime.actions.index'))


@section('body')
<detail-billeterie-maritime-listing :detail="{{$data}}" :url="'{{ $billeterieMaritime->resource_url }}'" :action="'{{url('admin/billeterie-maritimes') }}'" :urlbase="'{{base_url('')}}'" :urlasset="'{{asset('')}}'" inline-template>
    <div style="display: contents;position:relative" id="parent-loader">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i>
                        <h3>{{ trans('admin.billeterie-maritime.actions.index') }}</h3>
                    </div>
                    <div class="card-body" v-cloak v-for="(item,index) in data_detail" :key="item.id">
                        <div class="my--tab">
                            <div class="item--tab" :class="pagination_[0]?'active':''" @click.prevent="nextPage([false,true])"><span>{{ trans('admin.billeterie-maritime.actions.index') }} </span> <i v-if="pagination_[0]" class="fa fa-pencil edit" @click.prevent="editBilleterie($event,item.resource_url + '/edit')"></i> </div>
                            <div class="item--tab" :class="pagination_[1]?'active':''" @click.prevent="nextPage([true,false])"><span>{{ trans('admin.billeterie-maritime.columns.planing_time') }}</span> </div>
                        </div>
                        <div class="row">
                            <div class="col-12" v-if="pagination_[0]">
                                <div class="form-_label">
                                    <label for="titre" class="col-form-label text-md-right col-md-3">{{ trans('admin.billeterie-maritime.columns.titre')}} </label>
                                    <span class="form-control cliquable" @click.prevent="editBilleterie($event,item.resource_url + '/edit')">@{{item.titre}}</span>
                                </div>
                                <!--<div class="form-_label">
                                    <label for="date_depart" class="col-form-label text-md-right col-md-3">{{ trans('admin.billeterie-maritime.columns.date_depart')}} </label>
                                    <span class="form-control cliquable" @click.prevent="editBilleterie($event,item.resource_url + '/edit')">@{{item.date_depart | date}}</span>
                                </div>-->
                                <div class="form-_label">
                                    <label for="lieu_depart" class="col-form-label text-md-right col-md-3">{{ trans('admin.billeterie-maritime.columns.lieu_depart')}} </label>
                                    <span class="form-control cliquable" @click.prevent="editBilleterie($event,item.resource_url + '/edit')">@{{item.depart.name}}</span>
                                </div>
                                <!--<div class="form-_label"> 
                                    <label for="date_arrive" class="col-form-label text-md-right col-md-3">{{ trans('admin.billeterie-maritime.columns.date_arrive')}} </label>
                                    <span class="form-control cliquable" @click.prevent="editBilleterie($event,item.resource_url + '/edit')">@{{item.date_arrive | date}}</span>
                                </div>-->
                                <div class="form-_label">
                                    <label for="lieu_arrive" class="col-form-label text-md-right col-md-3">{{ trans('admin.billeterie-maritime.columns.lieu_arrive')}} </label>
                                    <span class="form-control cliquable" @click.prevent="editBilleterie($event,item.resource_url + '/edit')">@{{item.arrive.name}}</span>
                                </div>
                                <div class="form-_label">
                                    <label for="lieu_arrive" class="col-form-label text-md-right col-md-3">{{ trans('admin.billeterie-maritime.columns.duree_trajet')}} </label>
                                    <span class="form-control cliquable" @click.prevent="editBilleterie($event,item.resource_url + '/edit')">@{{item.duree_trajet}}</span>
                                </div>

                                <div class="form-_label">
                                    <label for="title" class="col-form-label text-md-right col-md-3">{{ trans('admin.billeterie-maritime.columns.compagnie_transport_id')}} </label>
                                    <span class="form-control cliquable" @click.prevent="editBilleterie($event,item.resource_url + '/edit')">@{{item.compagnie.nom}}</span>
                                </div>
                                <div class="form-_label">
                                    <label for="description" class="col-form-label text-md-right col-md-3">{{ trans('admin.billeterie-maritime.columns.quantite')}} </label>
                                    <span class="form-control  cliquable" @click.prevent="editBilleterie($event,item.resource_url + '/edit')">@{{item.quantite}}</span>
                                </div>
                                <div class="form-_label">
                                    <label for="date_acquisition" class="col-form-label text-md-right col-md-3">{{ trans('admin.billeterie-maritime.columns.date_acquisition')}} </label>
                                    <span class="form-control cliquable" @click.prevent="editBilleterie($event,item.resource_url + '/edit')">@{{item.date_acquisition}}</span>
                                </div>
                                <div class="form-_label">
                                    <label for="date_limite" class="col-form-label text-md-right col-md-3">{{ trans('admin.billeterie-maritime.columns.date_limite')}} </label>
                                    <span class="form-control cliquable" @click.prevent="editBilleterie($event,item.resource_url + '/edit')">@{{item.date_limite}}</span>
                                </div>
                                <div class="form-_label">
                                    <label for="type" class="col-form-label text-md-right col-md-3">{{ trans('admin.billeterie-maritime.columns.tarif_aller')}} </label>
                                    <span class="form-control" style="padding-right: 1em !important">
                                        <table class="table table-hover table-listing">
                                            <thead>
                                                <tr>
                                                    <th>{{ trans('admin.billeterie-maritime.columns.type_personne_id') }}</th>
                                                    <th>{{ trans('admin.billeterie-maritime.columns.marge_aller')}}</th>
                                                    <th>{{ trans('admin.billeterie-maritime.columns.prix_achat_aller')}}</th>
                                                    <th>{{ trans('admin.billeterie-maritime.columns.prix_vente_aller')}}</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="tarif of item.tarif">
                                                    <td>@{{tarif.personne.type}}&nbsp; @{{tarif.personne.age}}</td>
                                                    <td>@{{tarif.prix_achat_aller}}</td>
                                                    <td>@{{tarif.marge_aller}}</td>
                                                    <td>@{{tarif.prix_vente_aller}}</td>
                                                    <td>
                                                        <div class="row no-gutters">
                                                            <div class="col-auto">
                                                                <button class="btn btn-sm btn-info" type="button" @click.prevent="editTarifPersonne($event,tarif.resource_url + '/edit','_aller')"><i class="fa fa-edit"></i></button>
                                                            </div>
                                                            <button type="submit" class="btn btn-sm btn-danger" title="{{ trans('admin-base.btn.delete') }}" @click.prevent="deleteBilleterie(tarif.resource_url)"><i class="fa fa-trash-o"></i></button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </span>
                                </div>
                                <div class="form-_label">
                                    <label for="type" class="col-form-label text-md-right col-md-3">{{ trans('admin.billeterie-maritime.columns.tarif_aller_retour')}} </label>
                                    <span class="form-control" style="padding-right: 1em !important">
                                        <table class="table table-hover table-listing">
                                            <thead>
                                                <tr>
                                                    <th>{{ trans('admin.billeterie-maritime.columns.type_personne_id') }}</th>
                                                    <th>{{ trans('admin.billeterie-maritime.columns.prix_achat_aller_retour')}}</th>
                                                    <th>{{ trans('admin.billeterie-maritime.columns.marge_aller_retour')}}</th>
                                                    <th>{{ trans('admin.billeterie-maritime.columns.prix_vente_aller_retour')}}</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="tarif of item.tarif">
                                                    <td>@{{tarif.personne.type}}&nbsp; @{{tarif.personne.age}}</td>
                                                    <td>@{{tarif.prix_achat_aller_retour}}</td>
                                                    <td>@{{tarif.marge_aller_retour}}</td>
                                                    <td>@{{tarif.prix_vente_aller_retour}}</td>
                                                    <td>
                                                        <div class="row no-gutters">
                                                            <div class="col-auto">
                                                                <button class="btn btn-sm btn-info" type="button" @click.prevent="editTarifPersonne($event,tarif.resource_url + '/edit','_aller_retour')"><i class="fa fa-edit"></i></button>
                                                            </div>
                                                            <button type="submit" class="btn btn-sm btn-danger" title="{{ trans('admin-base.btn.delete') }}" @click.prevent="deleteBilleterie(tarif.resource_url)"><i class="fa fa-trash-o"></i></button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </span>
                                </div>
                            </div>
                            <div class="col-12" style="overflow: auto;" v-if="pagination_[1]" v-for="(item,index) in data_detail" :key="item.id">
                                <form class="form-horizontal form-create" id="planing_time" method="post" @submit.prevent="storePlaningTime($event)" :action="url_item_time" novalidate>
                                    <table class="table table-hover table-listing">
                                        <thead>
                                            <tr>
                                                <th>{{trans('admin.billeterie-maritime.columns.heure-debut')}}</th>
                                                <th>{{trans('admin.billeterie-maritime.columns.heure-fin')}}</th>
                                                <th>{{trans('admin.excursion.columns.availability')}}</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="time of trierPlaningTime(item.planingTime)">
                                                <td v-if="time.debut">@{{time.debut | formatTime}}</td>
                                                <td v-if="time.debut == null"> -:- </td>
                                                <td v-if="time.fin">@{{time.fin | formatTime}}</td>
                                                <td v-if="time.fin == null"> -:-</td>
                                                <td>
                                                    <div class="link"></div>
                                                    <div class="list-week">
                                                        <span class="list-week-item" v-for="(week ,index) in $dictionnaire.week_list">
                                                            <input type="checkbox" :checked='$splite(time.availability,",").findIndex(__val => __val == index ) >= 0'> @{{week}}
                                                        </span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="row">
                                                        <div class="col-auto">
                                                            <button type="button" class="btn btn-sm btn-success" title="{{ trans('admin-base.btn.edit') }}" @click.prevent="editPlaningTime(time)"><i class="fa fa-edit"></i></button>
                                                        </div>
                                                        <div class="col-auto">
                                                            <button type="button" class="btn btn-sm btn-danger" title="{{ trans('admin-base.btn.delete') }}" @click.prevent="deletePlaningTime(time.resource_url)"><i class="fa fa-trash-o"></i></button>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr style="border: 2px solid #1a91bd;" :class="(has_create_time == true || has_edit_time == true)?'':'d-none'">
                                                <td>
                                                    <div class="form-group" style="margin-bottom: 0 !important;">
                                                        <input type="text" name="id_model" style="display: none;" :value="'billeterie_maritime_' + item.id">
                                                        <input type="time" name="debut" class="form-control">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group" style="margin-bottom: 0 !important;">
                                                        <input type="time" name="fin" class="form-control">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="list-week" id="billeterie-list-week">
                                                        <span class="list-week-item" v-for="(week ,index) in $dictionnaire.short_week_list">
                                                            <input type="checkbox" :data-value="index" :checked='weeksAvailability.length && weeksAvailability.findIndex(_val => _val == index ) >= 0' @change="changeWeekAvailableDate"> @{{week}}
                                                        </span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="row">
                                                        <div class="col-auto">
                                                            <div class="form-group" style="margin-bottom: 0 !important;" v-if="has_create_time==true">
                                                                <input type="submit" style="background-color: #1a91bd; border: none; border-radius: 5px; color: white;padding: 5px 15px;" value="{{trans('admin-base.btn.create')}}">
                                                            </div>
                                                            <div class="form-group" style="margin-bottom: 0 !important;" v-if="has_edit_time==true">
                                                                <input type="submit" style="background-color: #1a91bd; border: none; border-radius: 5px; color: white;padding: 5px 15px;" value="{{trans('admin-base.btn.save')}}">
                                                            </div>
                                                        </div>
                                                        <div class="col-auto">
                                                            <button type="button" class="btn btn-sm btn-danger" @click.prevent="has_edit_time=false;has_create_time=false;"><i class="fa fa-times"></i></button>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" style="margin: 0 0 0 auto;" v-if="has_create_time == false && has_edit_time == false">
                                                    <div class="form-group" style="margin-bottom: 0 !important;">
                                                        <input type="button" style="background-color: #1a91bd; border: none; border-radius: 5px; color: white;padding: 5px 15px;" value="{{trans('admin-base.btn.new')}}" @click.prevent="createPlaningTime">
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <modal name="edit_billeterie" :scrollable="true" :min-width="320" :max-width="1000" height="auto" width="100%" :draggable="true" @opened="myEvent.editBilleterie()" :adaptive="true">
            @include('admin.billeterie-maritime.edit-detail')
        </modal>
        <modal name="create_personne" :min-width="320" :max-width="1000" height="auto" width="100%" :draggable="true" @opened="myEvent.createPersonne()" :adaptive="true">
            @include('admin.billeterie-maritime.type-personne')
        </modal>
        <modal name="create_compagnie" :scrollable="true" :min-width="320" :max-width="1000" height="auto" width="100%" :draggable="true" @opened="myEvent.createCompagnie()" :adaptive="true">
            @include('admin.billeterie-maritime.compagnie')
        </modal>
        <modal name="edit_tarif_personne_aller" :scrollable="true" :min-width="320" :max-width="1000" height="auto" width="100%" :draggable="true" @opened="myEvent.editTarifPersonne()" :adaptive="true">
            <form class="form-horizontal form-edit" id="edit-tarif-form_aller" method="post" @submit.prevent="updateTarifForm($event,'edit_tarif_personne_aller')" :action="actionEditTarifPersonne" novalidate>
                <div class="card-header">
                    <i class="fa fa-pencil"></i>
                    <h3> {{ trans('admin.billeterie-maritime.actions.edit') }}</h3>
                    <a class="float-right text-danger" style="cursor:pointer;" @click.prevent="closeModal('edit_tarif_personne_aller')"><i class="fa fa-times"></i></a>
                </div>

                <div class="card-body">
                    <div class="form-group row align-items-center">
                        <label for="type_personne" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.billeterie-maritime.columns.type_personne_id') }}</label>
                        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
                            <input type="text" class="form-control" readonly name="type_personne">
                            <input type="text" name="type_personne_id" required class="form-control" style="display: none;">
                            <input type="text" name="billeterie_maritime_id" required class="form-control" style="display: none;">
                        </div>
                    </div>
                    <div class="form-group row align-items-center">
                        <label for="montant" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.billeterie-maritime.columns.prix_achat_aller') }}</label>
                        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
                            <input type="number" inputmode="decimal" step="any" min="0" class="form-control" @input="checkMarge($event,'aller')" name="prix_achat_aller">
                        </div>
                    </div>
                    <div class="form-group row align-items-center">
                        <label for="montant" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.billeterie-maritime.columns.marge_aller') }}</label>
                        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
                            <input type="number" inputmode="decimal" step="any" min="0" class="form-control" @input="checkMarge($event,'aller')" name="marge_aller">
                        </div>
                    </div>
                    <div class="form-group row align-items-center">
                        <label for="montant" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.billeterie-maritime.columns.prix_vente_aller') }}</label>
                        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
                            <input type="number" inputmode="decimal" step="any" min="0" class="form-control" readonly name="prix_vente_aller">
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
        <modal name="edit_tarif_personne_aller_retour" :scrollable="true" :min-width="320" :max-width="1000" height="auto" width="100%" :draggable="true" @opened="myEvent.editTarifPersonne()" :adaptive="true">
            <form class="form-horizontal form-edit" id="edit-tarif-form_aller_retour" method="post" @submit.prevent="updateTarifForm($event,'edit_tarif_personne_aller_retour')" :action="actionEditTarifPersonne" novalidate>
                <div class="card-header">
                    <i class="fa fa-pencil"></i>
                    <h3> {{ trans('admin.billeterie-maritime.actions.edit') }}</h3>
                    <a class="float-right text-danger" style="cursor:pointer;" @click.prevent="closeModal('edit_tarif_personne_aller_retour')"><i class="fa fa-times"></i></a>
                </div>

                <div class="card-body">
                    <div class="form-group row align-items-center">
                        <label for="type_personne" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.billeterie-maritime.columns.type_personne_id') }}</label>
                        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
                            <input type="text" class="form-control" readonly name="type_personne">
                            <input type="text" name="type_personne_id" required class="form-control" style="display: none;">
                            <input type="text" name="billeterie_maritime_id" required class="form-control" style="display: none;">
                        </div>
                    </div>
                    <div class="form-group row align-items-center">
                        <label for="montant" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.billeterie-maritime.columns.prix_achat_aller_retour') }}</label>
                        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
                            <input type="number" inputmode="decimal" step="any" min="0" class="form-control" @input="checkMarge($event,'aller_retour')" name="prix_achat_aller_retour">
                        </div>
                    </div>
                    <div class="form-group row align-items-center">
                        <label for="montant" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.billeterie-maritime.columns.marge_aller_retour') }}</label>
                        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
                            <input type="number" inputmode="decimal" step="any" min="0" class="form-control" @input="checkMarge($event,'aller_retour')" name="marge_aller_retour">
                        </div>
                    </div>
                    <div class="form-group row align-items-center">
                        <label for="montant" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.billeterie-maritime.columns.prix_vente_aller_retour') }}</label>
                        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
                            <input type="number" inputmode="decimal" step="any" min="0" class="form-control" readonly name="prix_vente_aller_retour">
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
    </diV>
</detail-billeterie-maritime-listing>

@endsection