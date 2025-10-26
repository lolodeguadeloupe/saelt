@extends('admin.customer-layout.layout.default')

@section('title', trans('admin.supplement-excursion.actions.index'))

@section('styles')
<style>
    #supplement_excursion_block .form-control-feedback.form-text {
        bottom: -6px !important;
    }
</style>
@endsection

@section('body')

<supplement-excursion-listing :data="{{ $data->toJson() }}" :url="'{{ url('admin/supplement-excursions?excursion='.$excursion->id) }}'" :action="'{{url('admin/supplement-excursions?excursion='.$excursion->id) }}'" :urlbase="'{{base_url('')}}'" :urlasset="'{{asset('')}}'" :excursion="{{$excursion->toJson()}}" :typesupplement="{{$typeSupplement->toJson()}}" inline-template>
    <div style="display: contents;position:relative">
        <div class="row">
            @include('admin.excursion.view-header.header')
        </div>
        <div class="row has--child-nav">
            <div class="col-2 child-_nav" style="height: auto !important;">
                @include('admin.excursion.view-header.nav-child')
            </div>
            <div class="col-10 content-_nav">
                <div class="card position-relative">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i>
                        <h3>{{ trans('admin.supplement-excursion.actions.index') }}</h3>
                        <a class="btn btn-primary btn-sm pull-right m-b-0" href="#" @click.prevent="createSupplement($event,'{{ url('admin/supplement-excursions/create?excursion='.$excursion->id) }}')" role="button"><i class="fa fa-plus"></i>&nbsp; {{ trans('admin.supplement-excursion.actions.create') }}</a>
                    </div>
                    <div class="card-body" v-cloak>
                        <div class="card-block position-relative">
                            <form @submit.prevent="" class="w-100">
                                <div class="row justify-content-md-between">
                                    <div class="col col-lg-7 col-xl-5 form-group">
                                        <div class="input-group">
                                            <input class="form-control" placeholder="{{ trans('brackets/admin-ui::admin.placeholder.search') }}" v-model="search" @keyup.enter="filter('search', $event.target.value)" />
                                            <span class="input-group-append">
                                                <button type="button" class="btn btn-primary" @click.prevent="filter('search', search)"><i class="fa fa-search"></i>&nbsp; {{ trans('brackets/admin-ui::admin.btn.search') }}</button>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-auto form-group ">
                                        <select class="form-control" v-model="pagination.state.per_page">

                                            <option value="10">10</option>
                                            <option value="25">25</option>
                                            <option value="100">100</option>
                                        </select>
                                    </div>
                                </div>
                            </form>

                            <div class="content-card-body">
                                <table class="table table-hover table-listing mt-5">
                                    <thead>
                                        <tr>
                                            <th class="bulk-checkbox">
                                                <input class="form-check-input" id="enabled" type="checkbox" v-model="isClickedAll" v-validate="''" data-vv-name="enabled" name="enabled_fake_element" @click.prevent="onBulkItemsClickedAllWithPagination()">
                                                <label class="form-check-label" for="enabled">
                                                </label>
                                            </th>

                                            <th is='sortable' :column="'id'">{{ trans('admin.supplement-excursion.columns.id') }}</th>
                                            <th is='sortable' :column="'titre'">{{ trans('admin.supplement-excursion.columns.titre') }}</th>
                                            <th is='sortable' :column="'prestataire_id'">{{ trans('admin.prestataire.title') }}</th>
                                            <th>{{ trans('admin.supplement-excursion.columns.type_personne_id') }}</th>
                                            <th>{{ trans('admin.supplement-activite.columns.tarif') }} / Jour</th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                        <tr v-show="(clickedBulkItemsCount > 0) || isClickedAll">
                                            <td class="bg-bulk-info d-table-cell text-center" colspan="8">
                                                <span class="align-middle font-weight-light text-dark">{{ trans('brackets/admin-ui::admin.listing.selected_items') }} @{{ clickedBulkItemsCount }}. <a href="#" class="text-primary" @click.prevent="onBulkItemsClickedAll('/admin/supplement-excursions')" v-if="(clickedBulkItemsCount < pagination.state.total)"> <i class="fa" :class="bulkCheckingAllLoader ? 'fa-spinner' : ''"></i> {{ trans('brackets/admin-ui::admin.listing.check_all_items') }} @{{ pagination.state.total }}</a> <span class="text-primary">|</span> <a href="#" class="text-primary" @click.prevent="onBulkItemsClickedAllUncheck()">{{ trans('brackets/admin-ui::admin.listing.uncheck_all_items') }}</a> </span>

                                                <span class="pull-right pr-2">
                                                    <button class="btn btn-sm btn-danger pr-3 pl-3" @click.prevent="bulkDelete(urlbase+'/admin/supplement-excursions/bulk-destroy')">{{ trans('brackets/admin-ui::admin.btn.delete') }}</button>
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

                                            <td>@{{ item.id }}</td>
                                            <td>@{{ item.titre }}</td>
                                            <td>@{{ item.prestataire?item.prestataire.name:'' }}</td>
                                            <td>
                                                <ul style="list-style: none;padding: 0;margin: 0;">
                                                    <li v-for="(tarif, _index) in item.tarif" style="border-bottom: 1px solid #f0f2f5; padding: 5px 0;">@{{tarif.personne.type}} <span> (@{{tarif.personne.age}})</span></li>
                                                </ul>
                                            </td>
                                            <td>
                                                <ul style="list-style: none;padding: 0;margin: 0;">
                                                    <li v-for="(tarif, _index) in item.tarif" style="border-bottom: 1px solid #f0f2f5; padding: 5px 0;">@{{tarif.prix_vente}} <span class="unite-tarif">€</span></li>
                                                </ul>
                                            </td>
                                            <td>
                                                <ul style="list-style: none;padding: 0;margin: 0;">
                                                    <li v-for="(tarif, _index) in item.tarif" style="border-bottom: 1px solid #f0f2f5; padding: 5px 0;">
                                                        <button class="border-0 bg-transparent" type="button" @click.prevent="editTarifForm($event,tarif.resource_url + '/edit','')"><i class="fa fa-pencil text-info"></i></button>
                                                    </li>
                                                </ul>
                                            </td>

                                            <td style="display: table-cell;">
                                                <div class="row no-gutters">
                                                    <div class="col-auto">
                                                        <a class="btn btn-sm btn-info" @click.prevent="editSupplement($event,item.resource_url + '/edit')" href="#" title="{{ trans('brackets/admin-ui::admin.btn.edit') }}" role="button"><i class="fa fa-edit"></i></a>
                                                    </div>
                                                    <form class="col" @submit.prevent="deleteItem(item.resource_url)">
                                                        <button type="submit" class="btn btn-sm btn-danger" title="{{ trans('brackets/admin-ui::admin.btn.delete') }}"><i class="fa fa-trash-o"></i></button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <!--
                            <table class="table table-hover table-listing">
                                <thead>
                                    <tr>
                                        <th class="bulk-checkbox">
                                            <input class="form-check-input" id="enabled" type="checkbox" v-model="isClickedAll" v-validate="''" data-vv-name="enabled" name="enabled_fake_element" @click.prevent="onBulkItemsClickedAllWithPagination()">
                                            <label class="form-check-label" for="enabled">
                                            </label>
                                        </th>

                                        <th is='sortable' :column="'id'">{{ trans('admin.supplement-excursion.columns.id') }}</th>
                                        <th is='sortable' :column="'titre'">{{ trans('admin.supplement-excursion.columns.titre') }}</th>
                                        <th>{{ trans('admin.supplement-excursion.columns.type_personne_id') }}</th>
                                        <th>{{ trans('admin.supplement-activite.columns.marge') }}</th>
                                        <th>{{ trans('admin.supplement-activite.columns.prix_achat') }}</th>
                                        <th>{{ trans('admin.supplement-activite.columns.prix_vente') }}</th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                    <tr v-show="(clickedBulkItemsCount > 0) || isClickedAll">
                                        <td class="bg-bulk-info d-table-cell text-center" colspan="9">
                                            <span class="align-middle font-weight-light text-dark">{{ trans('brackets/admin-ui::admin.listing.selected_items') }} @{{ clickedBulkItemsCount }}. <a href="#" class="text-primary" @click.prevent="onBulkItemsClickedAll('/admin/supplement-excursions')" v-if="(clickedBulkItemsCount < pagination.state.total)"> <i class="fa" :class="bulkCheckingAllLoader ? 'fa-spinner' : ''"></i> {{ trans('brackets/admin-ui::admin.listing.check_all_items') }} @{{ pagination.state.total }}</a> <span class="text-primary">|</span> <a href="#" class="text-primary" @click.prevent="onBulkItemsClickedAllUncheck()">{{ trans('brackets/admin-ui::admin.listing.uncheck_all_items') }}</a> </span>

                                            <span class="pull-right pr-2">
                                                <button class="btn btn-sm btn-danger pr-3 pl-3" @click.prevent="bulkDelete(urlbase+'/admin/supplement-excursions/bulk-destroy')">{{ trans('brackets/admin-ui::admin.btn.delete') }}</button>
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

                                        <td>@{{ item.id }}</td>
                                        <td>@{{ item.titre }}</td>
                                        <td>
                                            <ul style="list-style: none;padding: 0;margin: 0;">
                                                <li v-for="(tarif, _index) in item.tarif" style="border-bottom: 1px solid #f0f2f5; padding: 5px 0;">@{{tarif.personne.type}} <span> (@{{tarif.personne.age}})</span></li>
                                            </ul>
                                        </td>
                                        <td>
                                            <ul style="list-style: none;padding: 0;margin: 0;">
                                                <li v-for="(tarif, _index) in item.tarif" style="border-bottom: 1px solid #f0f2f5; padding: 5px 0;">@{{tarif.marge}} <span class="unite-tarif">€</span></li>
                                            </ul>
                                        </td>
                                        <td>
                                            <ul style="list-style: none;padding: 0;margin: 0;">
                                                <li v-for="(tarif, _index) in item.tarif" style="border-bottom: 1px solid #f0f2f5; padding: 5px 0;">@{{tarif.prix_achat}} <span class="unite-tarif">€</span></li>
                                            </ul>
                                        </td>
                                        <td>
                                            <ul style="list-style: none;padding: 0;margin: 0;">
                                                <li v-for="(tarif, _index) in item.tarif" style="border-bottom: 1px solid #f0f2f5; padding: 5px 0;">@{{tarif.prix_vente}} <span class="unite-tarif">€</span></li>
                                            </ul>
                                        </td>
                                        <td>
                                            <ul style="list-style: none;padding: 0;margin: 0;">
                                                <li v-for="(tarif, _index) in item.tarif" style="border-bottom: 1px solid #f0f2f5; padding: 5px 0;">
                                                    <button class="btn btn-sm btn-info" type="button" @click.prevent="editTarifForm($event,tarif.resource_url + '/edit','')"><i class="fa fa-edit"></i></button>
                                                </li>
                                            </ul>
                                        </td>

                                        <td style="display: table-cell;">
                                            <div class="row no-gutters">
                                                <div class="col-auto">
                                                    <a class="btn btn-sm btn-info" @click.prevent="editSupplement($event,item.resource_url + '/edit')" href="#" title="{{ trans('brackets/admin-ui::admin.btn.edit') }}" role="button"><i class="fa fa-edit"></i></a>
                                                </div>
                                                <form class="col" @submit.prevent="deleteItem(item.resource_url)">
                                                    <button type="submit" class="btn btn-sm btn-danger" title="{{ trans('brackets/admin-ui::admin.btn.delete') }}"><i class="fa fa-trash-o"></i></button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
-->

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
                                <a class="btn btn-primary" href="#" @click.prevent="createSupplement($event,'{{ url('admin/supplement-excursions/create?excursion='.$excursion->id) }}')" role="button"><i class="fa fa-plus"></i>&nbsp; {{ trans('admin.supplement-excursion.actions.create') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <modal name="edit_supplement" :scrollable="true" :min-width="320" :max-width="1000" height="auto" width="100%" :draggable="true" @opened="myEvent.editSupplement()" :adaptive="true">
            @include('admin.excursion.supplement-excursion.edit')
        </modal>

        <modal name="create_supplement" :click-to-close="false" :scrollable="true" :min-width="320" :max-width="1000" height="auto" width="100%" :draggable="true" :adaptive="true">
            @include('admin.excursion.supplement-excursion.create')
        </modal>

        <modal name="edit_tarif_form" :scrollable="true" :min-width="320" :max-width="1000" height="auto" width="100%" :draggable="true" @opened="myEvent.editTarifPersonne()" :adaptive="true">
            <form class="form-horizontal form-edit" id="edit-tarif-form" method="post" @submit.prevent="updateTarifForm($event,'edit_tarif_form')" :action="actionEditTarifPersonne" novalidate>
                <div class="card-header">
                    <i class="fa fa-pencil"></i>
                    <h3> {{ trans('admin.supplement-activite.actions.edit') }}</h3>
                    <a class="float-right text-danger" style="cursor:pointer;" @click.prevent="closeModal('edit_tarif_form')"><i class="fa fa-times"></i></a>
                </div>

                <div class="card-body">
                    <div class="form-group row align-items-center">
                        <label for="type_personne" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.supplement-activite.columns.type_personne') }}</label>
                        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
                            <input type="text" class="form-control" readonly name="type_personne">
                            <input type="text" name="type_personne_id" required class="form-control" style="display: none;">
                            <input type="text" name="supplement_excursion_id" required class="form-control" style="display: none;">
                        </div>
                    </div>
                    <div class="form-group row align-items-center">
                        <label for="montant" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.supplement-activite.columns.prix_vente') }}</label>
                        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
                            <input type="number" inputmode="decimal" step="any" min="0" class="form-control" @input="checkMarge($event,'')" name="marge" style="display: none;">
                            <input type="number" inputmode="decimal" step="any" min="0" class="form-control" @input="checkMarge($event,'')" name="prix_achat" style="display: none;">
                            <input type="number" inputmode="decimal" step="any" min="0" class="form-control with-unite" name="prix_vente">
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
            @include('admin.excursion.supplement-excursion.type-personne')
        </modal>
    </diV>
</supplement-excursion-listing>

@endsection