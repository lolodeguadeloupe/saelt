@extends('admin.customer-layout.layout.default')

@section('title', trans('admin.tarif-excursion.actions.index'))

@section('body')

<tarif-excursion-listing :data="{{ $data->toJson() }}" :excursion="{{$excursion->toJson()}}" :url="'{{ url('admin/tarif-excursions?excursion='.$excursion->id) }}'" :action="'{{url('admin/tarif-excursions') }}'" :urlbase="'{{base_url('')}}'" :urlasset="'{{asset('')}}'" inline-template>

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
                        <h3>{{ trans('admin.tarif-excursion.actions.index') }}</h3>
                        <a class="btn btn-primary btn-sm pull-right m-b-0" href="#" @click.prevent="createTarif($event,'{{ url('admin/tarif-excursions/create?excursion='.$excursion->id) }}')" role="button"><i class="fa fa-plus"></i>&nbsp; {{ trans('admin.tarif-excursion.actions.create') }}</a>
                        <a v-if="collection.length > 0" style="margin-right: 15px;" class="btn btn-primary btn-sm pull-right m-b-0" href="#" @click.prevent="editTarif($event,'{{ url('admin/tarif-excursions/'.$excursion->id) }}')" role="button"><i class="fa fa-edit"></i>&nbsp; {{ trans('admin.tarif-excursion.actions.edit') }}</a>
                    </div>
                    <div class="card-body" v-cloak>
                        <div class="card-block position-relative">
                            <form @submit.prevent="" class="w-100">
                                <div class="row justify-content-md-between">
                                    <div class="col col-lg-7 col-xl-5 form-group">
                                        <div class="input-group">
                                            <input class="form-control" placeholder="{{ trans('admin-base.placeholder.search') }}" v-model="search" @keyup.enter="filter('search', $event.target.value)" />
                                            <span class="input-group-append">
                                                <button type="button" class="btn btn-primary" @click.prevent="filter('search', search)"><i class="fa fa-search"></i>&nbsp; {{ trans('admin-base.btn.search') }}</button>
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
                                                <!--<input class="form-check-input" id="enabled" type="checkbox" v-model="isClickedAll" v-validate="''" data-vv-name="enabled" name="enabled_fake_element" @click.prevent="onBulkItemsClickedAllWithPagination()">-->
                                                <label class="form-check-label" for="enabled">
                                                </label>
                                            </th>

                                            <th is='sortable' :column="'id'">{{ trans('admin.tarif-excursion.columns.id') }}</th>
                                            <th is='sortable' :column="'titre'">{{ trans('admin.tarif-excursion.columns.saison') }}</th>
                                            <th is='sortable' :column="'type_personne_id'">{{ trans('admin.tarif-excursion.columns.type_personne_id') }}</th>
                                            <th>{{ trans('admin.tarif-excursion.columns.prix_achat') }}</th>
                                            <th>{{ trans('admin.tarif-excursion.columns.marge') }}</th>
                                            <th>{{ trans('admin.tarif-excursion.columns.prix_vente') }}</th>
                                            <th></th>
                                        </tr>
                                        <tr v-show="(clickedBulkItemsCount > 0) || isClickedAll">
                                            <td class="bg-bulk-info d-table-cell text-center" colspan="8">
                                                <span class="align-middle font-weight-light text-dark">{{ trans('admin-base.listing.selected_items') }} @{{ clickedBulkItemsCount }}. <a href="#" class="text-primary" @click.prevent="onBulkItemsClickedAll('/admin/tarif-excursions')" v-if="(clickedBulkItemsCount < pagination.state.total)"> <i class="fa" :class="bulkCheckingAllLoader ? 'fa-spinner' : ''"></i> {{ trans('admin-base.listing.check_all_items') }} @{{ pagination.state.total }}</a> <span class="text-primary">|</span> <a href="#" class="text-primary" @click.prevent="onBulkItemsClickedAllUncheck()">{{ trans('admin-base.listing.uncheck_all_items') }}</a> </span>

                                                <span class="pull-right pr-2">
                                                    <button class="btn btn-sm btn-danger pr-3 pl-3" @click.prevent="bulkDelete(urlbase+'/admin/tarif-excursions/bulk-destroy')">{{ trans('admin-base.btn.delete') }}</button>
                                                </span>

                                            </td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(item, index) in collection" :key="item.id" :class="bulkItems[item.id] ? 'bg-bulk' : ''">
                                            <td class="bulk-checkbox" :class="item.tarif[0] == undefined ? 'bg-danger':''">
                                                <!--<input class="form-check-input" :id="'enabled' + item.id" type="checkbox" v-model="bulkItems[item.id]" v-validate="''" :data-vv-name="'enabled' + item.id" :name="'enabled' + item.id + '_fake_element'" @click.prevent="onBulkItemClicked(item.id)" :disabled="bulkCheckingAllLoader">-->
                                                <label class="form-check-label" :for="'enabled' + item.id">
                                                </label>
                                            </td>

                                            <td :class="item.tarif[0] == undefined ? 'bg-danger':''">@{{ item.id }}</td>
                                            <td :class="item.tarif[0] == undefined ? 'bg-danger':''">@{{ item.titre }} (@{{ item.debut_format }} - @{{ item.fin_format }})</td>
                                            <td :class="item.tarif[0] == undefined ? 'bg-danger':''">
                                                <ul style="list-style: none;padding: 0;margin: 0;">
                                                    <li v-for="(personne, _index) in item.tarif" style="border-bottom: 1px solid #f0f2f5; padding: 5px 0;">@{{personne.personne.type}} </li>
                                                </ul>
                                            </td>
                                            <td :class="item.tarif[0] == undefined ? 'bg-danger':''">
                                                <ul style="list-style: none;padding: 0;margin: 0;">
                                                    <li v-for="(tarif, _index) in item.tarif" style="border-bottom: 1px solid #f0f2f5; padding: 5px 0;">@{{tarif.prix_achat}} <span class="unite-tarif">€</span></li>
                                                </ul>
                                            </td>
                                            <td :class="item.tarif[0] == undefined ? 'bg-danger':''">
                                                <ul style="list-style: none;padding: 0;margin: 0;">
                                                    <li v-for="(tarif, _index) in item.tarif" style="border-bottom: 1px solid #f0f2f5; padding: 5px 0;">@{{tarif.marge}} <span class="unite-tarif">€</span></li>
                                                </ul>
                                            </td>
                                            <td :class="item.tarif[0] == undefined ? 'bg-danger':''">
                                                <ul style="list-style: none;padding: 0;margin: 0;">
                                                    <li v-for="(tarif, _index) in item.tarif" style="border-bottom: 1px solid #f0f2f5; padding: 5px 0;">@{{tarif.prix_vente}} <span class="unite-tarif">€</span></li>
                                                </ul>
                                            </td>
                                            <td style="display: table-cell !important;" :class="item.tarif[0] == undefined ? 'bg-danger':''">
                                                <ul style="list-style: none;padding: 0;margin: 0;">
                                                    <li v-for="(tarif, _index) in item.tarif" style="border-bottom: 1px solid #f0f2f5; padding: 5px 0;">
                                                        <a class="btn btn-sm btn-info" @click.prevent="editTarifForm($event,tarif.resource_url + '/edit','')" href="#" title="{{ trans('admin-base.btn.edit') }}" role="button"><i class="fa fa-edit"></i></a>
                                                    </li>
                                                </ul>
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
                                <a class="btn btn-primary" href="#" @click.prevent="createTarif($event,'{{ url('admin/tarif-excursions/create?excursion='.$excursion->id) }}')" role="button"><i class="fa fa-plus"></i>&nbsp; {{ trans('admin.tarif-excursion.actions.create') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <modal name="edit_tarif" :scrollable="true" :min-width="320" :max-width="1000" height="auto" width="100%" :draggable="true" @opened="myEvent.editTarif()" :adaptive="true">
            @include('admin.excursion.tarif-excursion.edit')
        </modal>

        <modal name="create_tarif" :click-to-close="false" :scrollable="true" :min-width="320" :max-width="1000" height="auto" width="100%" :draggable="true" :adaptive="true">
            @include('admin.excursion.tarif-excursion.create')
        </modal>
        <modal name="create_personne" :min-width="320" :max-width="1000" height="auto" width="100%" :draggable="true" @opened="myEvent.createPersonne()" :adaptive="true">
            @include('admin.excursion.tarif-excursion.type-personne')
        </modal>
        <modal name="create_saison" :min-width="320" :max-width="1000" height="auto" width="100%" :draggable="true" @opened="myEvent.createSaison()" :adaptive="true">
            @include('admin.excursion.tarif-excursion.saison')
        </modal>
        <modal name="edit_tarif_form" :scrollable="true" :min-width="320" :max-width="1000" height="auto" width="100%" :draggable="true" @opened="myEvent.editTarifForm()" :adaptive="true">
            <form class="form-horizontal form-edit" id="edit-tarif-form" method="post" @submit.prevent="updateTarifForm($event,'edit_tarif_form')" :action="actionEditTarifForm" novalidate>
                <div class="card-header">
                    <i class="fa fa-pencil"></i>
                    <h3> {{ trans('admin.tarif-excursion.actions.edit') }}</h3>
                    <a class="float-right text-danger" style="cursor:pointer;" @click.prevent="closeModal('edit_tarif_form')"><i class="fa fa-times"></i></a>
                </div>

                <div class="card-body">
                    <div class="form-group row align-items-center">
                        <label for="type_personne" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.tarif-excursion.columns.type_personne') }}</label>
                        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
                            <input type="text" class="form-control" readonly name="type_personne">
                            <input type="text" name="type_personne_id" required class="form-control" style="display: none;">
                            <input type="text" name="saison_id" required class="form-control" style="display: none;">
                        </div>
                    </div>
                    <div class="form-group row align-items-center">
                        <label for="montant" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.tarif-excursion.columns.prix_achat') }}</label>
                        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
                            <input type="number" inputmode="decimal" step="any" min="0" class="form-control with-unite" @input="checkMarge($event,'')" name="prix_achat">
                            <span style="position: absolute; left: 20px; top: 0; width:auto; height: 100%;display: flex;align-items: center; font-weight: 500; text-decoration: underline;font-size: 18px;">€</span>
                        </div>
                    </div>
                    <div class="form-group row align-items-center">
                        <label for="montant" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.tarif-excursion.columns.marge') }}</label>
                        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
                            <input type="number" inputmode="decimal" step="any" min="0" class="form-control with-unite" @input="checkMarge($event,'')" name="marge">
                            <span style="position: absolute; left: 20px; top: 0; width:auto; height: 100%;display: flex;align-items: center; font-weight: 500; text-decoration: underline;font-size: 18px;">€</span>
                        </div>
                    </div>
                    <div class="form-group row align-items-center">
                        <label for="montant" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.tarif-excursion.columns.prix_vente') }}</label>
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
    </diV>
</tarif-excursion-listing>

@endsection