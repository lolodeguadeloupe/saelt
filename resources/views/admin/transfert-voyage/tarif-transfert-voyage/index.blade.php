@extends('admin.customer-layout.layout.default')

@section('title', trans('admin.tarif-transfert-voyage.actions.index'))

@section('body')
<tarif-transfert-voyage-listing :data="{{ $data->toJson() }}" :url="'{{ url('admin/tarif-transfert-voyages?transfert='.$typeTransfertVoyage->id) }}'" :action="'{{ url('admin/tarif-transfert-voyages?transfert='.$typeTransfertVoyage->id) }}'" :tranchetransfertvoyage="{{$tranchetransfertvoyage->toJson()}}" :trajettransfertvoyage="{{$trajettransfertvoyage->toJson()}}" :urlbase="'{{base_url('')}}'" :urlasset="'{{asset('')}}'" inline-template>
    <div style="display: contents;position:relative">
        <div class="row">
            @include('admin.transfert-voyage.view-header.header')
        </div>
        <div class="row has--child-nav">
            <div class="col-2 child-_nav" style="height: auto !important;">
                @include('admin.transfert-voyage.view-header.nav-child')
            </div>
            <div class="col-10 content-_nav">
                <div class="card position-relative">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i>
                        <h5>{{ trans('admin.tarif-transfert-voyage.actions.index') }}</h5>
                        <a class="btn btn-primary btn-sm pull-right m-b-0" href="#" @click.prevent="createTarif($event,'{{url('admin/tarif-transfert-voyages/create?transfert='.$typeTransfertVoyage->id)}}')" role="button"><i class="fa fa-plus"></i>&nbsp; {{ trans('admin.tarif-transfert-voyage.actions.create') }}</a>
                    </div>
                    <div class="card-body" v-cloak>
                        <div class="card-block position-relative">
                            <form @submit.prevent="" class="w-100">
                                <div class="w-100 p-4">
                                    <div class="row border py-4 position-relative">
                                        <span class="position-absolute bg-white px-2" style="top: -14px;left: 5px;">
                                            {{trans('admin-base.filter.with')}}&nbsp;:
                                        </span>
                                        <div class="col-md-6 form-group ">
                                            <div class="input-group">
                                                <span class="input-group-append">
                                                    <span style="background-color: #8080804f;padding: 5px 15px;"><i class="fa fa-filter"></i>&nbsp; {{ trans('admin.tarif-transfert-voyage.columns.tranche_personne_transfert_voyage') }}</span>
                                                </span>
                                                <select class="form-control" v-model="data_request_customer.tranche_transfert_voyage_id">
                                                    <option v-for="_tranche_transfert_voyage of state_tranchetransfertvoyage" :value="_tranche_transfert_voyage.id">@{{_tranche_transfert_voyage.titre}} (@{{_tranche_transfert_voyage.nombre_min}}Pers. - @{{_tranche_transfert_voyage.nombre_max}}Pers.)</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6 form-group ">
                                            <div class="input-group">
                                                <span class="input-group-append">
                                                    <span style="background-color: #8080804f;padding: 5px 15px;"><i class="fa fa-filter"></i>&nbsp; {{ trans('admin.tarif-transfert-voyage.columns.trajet_transfert_voyage') }}</span>
                                                </span>
                                                <select class="form-control" v-model="data_request_customer.trajet_transfert_voyage_id">
                                                    <option v-for="_trajet_transfert_voyage of state_trajettransfertvoyage" :value="_trajet_transfert_voyage.id">@{{_trajet_transfert_voyage.titre}}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row justify-content-md-between">
                                    <div class="col col-lg-5 col-xl-5 form-group">
                                        <div class="input-group">
                                            <input class="form-control" placeholder="{{ trans('admin-base.placeholder.search') }}" v-model="search" @keyup.enter="filter('search', $event.target.value)" />
                                            <span class="input-group-append">
                                                <button type="button" class="btn btn-primary" @click.prevent="filter('search', search)"><i class="fa fa-search"></i>&nbsp; {{ trans('admin-base.btn.search') }}</button>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-auto form-group">
                                        <select class="form-control" v-model="pagination.state.per_page">

                                            <option value="10">10</option>
                                            <option value="25">25</option>
                                            <option value="100">100</option>
                                        </select>
                                    </div>
                                </div>

                            </form>

                            <div class="content-card-body">
                                <table class="table table-hover table-listing">
                                    <thead>
                                        <tr>
                                            <th class="bulk-checkbox">
                                                <input class="form-check-input" id="enabled" type="checkbox" v-model="isClickedAll" v-validate="''" data-vv-name="enabled" name="enabled_fake_element" @click.prevent="onBulkItemsClickedAllWithPagination()">
                                                <label class="form-check-label" for="enabled">
                                                </label>
                                            </th>

                                            <th is='sortable' :column="'id'">{{ trans('admin.tarif-transfert-voyage.columns.id') }}</th>
                                            <th is='sortable' :column="'trajet_transfert_voyage.titre'">{{ trans('admin.tarif-transfert-voyage.columns.trajet_transfert_voyage_id') }}</th>
                                            <th is='sortable' :column="'tranche_personne_transfert_voyage.titre'">{{ trans('admin.tarif-transfert-voyage.columns.tranche_transfert_voyage_id') }}</th>
                                            <th is='sortable' :column="'prime_nuit'">{{ trans('admin.tarif-transfert-voyage.columns.prime_nuit') }}</th>
                                            <th is='sortable' :column="'prix_achat_aller'" class="text-center">{{ trans('admin.tarif-transfert-voyage.columns.tarif_aller') }}</th>
                                            <th is='sortable' :column="'prix_achat_aller'" class="text-center">{{ trans('admin.tarif-transfert-voyage.columns.tarif_aller_retour') }}</th>

                                            <th></th>
                                        </tr>
                                        <tr v-show="(clickedBulkItemsCount > 0) || isClickedAll">
                                            <td class="bg-bulk-info d-table-cell text-center" colspan="8">
                                                <span class="align-middle font-weight-light text-dark">{{ trans('admin-base.listing.selected_items') }} @{{ clickedBulkItemsCount }}. <a href="#" class="text-primary" @click.prevent="onBulkItemsClickedAll('/admin/tarif-transfert-voyages')" v-if="(clickedBulkItemsCount < pagination.state.total)"> <i class="fa" :class="bulkCheckingAllLoader ? 'fa-spinner' : ''"></i> {{ trans('admin-base.listing.check_all_items') }} @{{ pagination.state.total }}</a> <span class="text-primary">|</span> <a href="#" class="text-primary" @click.prevent="onBulkItemsClickedAllUncheck()">{{ trans('admin-base.listing.uncheck_all_items') }}</a> </span>

                                                <span class="pull-right pr-2">
                                                    <button class="btn btn-sm btn-danger pr-3 pl-3" @click.prevent="bulkDelete(urlbase+'/admin/tarif-transfert-voyages/bulk-destroy')">{{ trans('admin-base.btn.delete') }}</button>
                                                </span>

                                            </td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(item, index) in collection" :key="item.id" :class="bulkItems[item.id] ? 'bg-bulk' : ''">
                                            <td class="bulk-checkbox">
                                                <input class="form-check-input" :id="'enabled' + item.id" type="checkbox" v-model="bulkItems[item.id]" v-validate="''" :data-vv-name="'enabled' + item.id" :name="'enabled' + item.id + '_fake_element'" @click.prevent="onBulkItemClicked(item.id)" :disabled="bulkCheckingAllLoader">
                                                <label class="form-check-label" :for="'enabled' + item.id">
                                                </label>
                                            </td>

                                            <td>@{{ index + 1 }}</td>
                                            <td>@{{ item.trajet.titre }}</td>
                                            <td>@{{ item.tranche.titre }} <br> (@{{item.tranche.nombre_min}}Pers. - @{{item.tranche.nombre_max}}Pers.)</td>
                                            <td>@{{ item.prime_nuit?item.prime_nuit.prime_nuit:0 }}%</td>
                                            <td>
                                                <ul style="list-style: none;padding: 0;margin: 0;">
                                                    <li style="border-style:solid; border-color: #f0f2f5; border-width:1px 0 1px 1px; padding: 5px 0;" v-for="(item_tarif, index_tarif) in item.tarif">
                                                        <div class="d-flex flex-row align-items-center">
                                                            <div class="p-2 pr-4 flex-grow-1">
                                                                @{{ item_tarif.personne.type }}
                                                            </div>
                                                            <div>
                                                                <div class="d-flex flex-row">
                                                                    <span class="p-2"> Achat</span>
                                                                    <span class="p-2">@{{ item_tarif.prix_achat_aller }}€</span>
                                                                </div>
                                                                <div class="d-flex flex-row" style="border-top: 1px solid #ebeaea;">
                                                                    <span class="p-2"> Marge</span>
                                                                    <span class="p-2">@{{ item_tarif.marge_aller }}€</span>
                                                                </div>
                                                                <div class="d-flex flex-row" style="border-top: 1px solid #ebeaea;background-color: #eaf7fb;">
                                                                    <span class="p-2"> Vente</span>
                                                                    <span class="p-2">@{{ item_tarif.prix_vente_aller }}€</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </td>
                                            <td>
                                                <ul style="list-style: none;padding: 0;margin: 0;">
                                                    <li style="border-style:solid; border-color: #f0f2f5; border-width:1px 1px 1px 0; padding: 5px 0;" v-for="(item_tarif, index_tarif) in item.tarif">
                                                        <div class="d-flex flex-row align-items-center">
                                                            <div>
                                                                <div class="d-flex flex-row">
                                                                    <span class="p-2"> Achat</span>
                                                                    <span class="p-2">@{{ item_tarif.prix_achat_aller_retour }}€</span>
                                                                </div>
                                                                <div class="d-flex flex-row" style="border-top: 1px solid #ebeaea;">
                                                                    <span class="p-2"> Marge</span>
                                                                    <span class="p-2">@{{ item_tarif.marge_aller_retour }}€</span>
                                                                </div>
                                                                <div class="d-flex flex-row" style="border-top: 1px solid #ebeaea;background-color: #eaf7fb;">
                                                                    <span class="p-2"> Vente</span>
                                                                    <span class="p-2">@{{ item_tarif.prix_vente_aller_retour }}€</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </td>
                                            <td>
                                                <div class="row no-gutters">
                                                    <div class="col-auto">
                                                        <a class="btn btn-sm btn-info" href="#" @click.prevent="editTarif($event,item.resource_url+'/edit?transfert={{$typeTransfertVoyage->id}}')" title="{{ trans('admin-base.btn.edit') }}" role="button"><i class="fa fa-edit"></i></a>
                                                    </div>
                                                    <form class="col" @submit.prevent="deleteItem(item.resource_url)">
                                                        <button type="submit" class="btn btn-sm btn-danger" title="{{ trans('admin-base.btn.delete') }}"><i class="fa fa-trash-o"></i></button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="row justify-content-md-between align-items-center mb-2 pt-5" v-if="pagination.state.total > 0">
                                <div class="col-sm">
                                    <span class="pagination-caption">{{ trans('admin-base.pagination.overview') }}</span>
                                </div>
                                <div class="col-sm-auto">
                                    <pagination></pagination>
                                </div>
                            </div>

                            <div class="no-items-found" v-if="!collection.length > 0">
                                <i class="icon-magnifier"></i>
                                <h3>{{ trans('admin-base.index.no_items') }}</h3>
                                <p>{{ trans('admin-base.index.try_changing_items') }}</p>
                                <a class="btn btn-primary" href="#" @click.prevent="createTarif($event,'{{url('admin/tarif-transfert-voyages/create?transfert='.$typeTransfertVoyage->id)}}')" role="button"><i class="fa fa-plus"></i>&nbsp; {{ trans('admin.tarif-transfert-voyage.actions.create') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <modal name="create_tarif" :scrollable="true" :min-width="320" :max-width="1000" height="auto" width="100%" :draggable="false" @opened="myEvent.createTarif()" :adaptive="true">
            @include('admin.transfert-voyage.tarif-transfert-voyage.create')
        </modal>
        <modal name="edit_tarif" :scrollable="true" :min-width="320" :max-width="1000" height="auto" width="100%" :draggable="false" @opened="myEvent.editTarif()" :adaptive="true">
            @include('admin.transfert-voyage.tarif-transfert-voyage.edit')
        </modal>
        <modal name="create_personne" :min-width="320" :max-width="1000" height="auto" width="100%" :draggable="true" @opened="myEvent.createPersonne()" :adaptive="true">
            @include('admin.transfert-voyage.tarif-transfert-voyage.type-personne')
        </modal>

    </div>
</tarif-transfert-voyage-listing>
@endsection