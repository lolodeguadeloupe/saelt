@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.tarif-transfert-voyage.actions.index'))

@section('body')

    <tarif-transfert-voyage-listing
        :data="{{ $data->toJson() }}"
        :url="'{{ url('admin/tarif-transfert-voyages') }}'"
        inline-template>

        <div class="row">
            <div class="col">
                <div class="card position-relative">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> {{ trans('admin.tarif-transfert-voyage.actions.index') }}
                        <a class="btn btn-primary btn-spinner btn-sm pull-right m-b-0" href="{{ url('admin/tarif-transfert-voyages/create') }}" role="button"><i class="fa fa-plus"></i>&nbsp; {{ trans('admin.tarif-transfert-voyage.actions.create') }}</a>
                    </div>
                    <div class="card-body" v-cloak>
                        <div class="card-block">
                            <form @submit.prevent="" class="position-absolute w-100 right-0 px-5">
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

                            <table class="table table-hover table-listing mt-5">
                                <thead>
                                    <tr>
                                        <th class="bulk-checkbox">
                                            <input class="form-check-input" id="enabled" type="checkbox" v-model="isClickedAll" v-validate="''" data-vv-name="enabled"  name="enabled_fake_element" @click.prevent="onBulkItemsClickedAllWithPagination()">
                                            <label class="form-check-label" for="enabled">
                                                #
                                            </label>
                                        </th>

                                        <th is='sortable' :column="'id'">{{ trans('admin.tarif-transfert-voyage.columns.id') }}</th>
                                        <th is='sortable' :column="'trajet_transfert_voyage_id'">{{ trans('admin.tarif-transfert-voyage.columns.trajet_transfert_voyage_id') }}</th>
                                        <th is='sortable' :column="'tranche_transfert_voyage_id'">{{ trans('admin.tarif-transfert-voyage.columns.tranche_transfert_voyage_id') }}</th>
                                        <th is='sortable' :column="'type_personne_id'">{{ trans('admin.tarif-transfert-voyage.columns.type_personne_id') }}</th>
                                        <th is='sortable' :column="'prix_achat_aller'">{{ trans('admin.tarif-transfert-voyage.columns.prix_achat_aller') }}</th>
                                        <th is='sortable' :column="'prix_achat_aller_retour'">{{ trans('admin.tarif-transfert-voyage.columns.prix_achat_aller_retour') }}</th>
                                        <th is='sortable' :column="'marge_aller'">{{ trans('admin.tarif-transfert-voyage.columns.marge_aller') }}</th>
                                        <th is='sortable' :column="'marge_aller_retour'">{{ trans('admin.tarif-transfert-voyage.columns.marge_aller_retour') }}</th>
                                        <th is='sortable' :column="'prix_vente_aller'">{{ trans('admin.tarif-transfert-voyage.columns.prix_vente_aller') }}</th>
                                        <th is='sortable' :column="'prix_vente_aller_retour'">{{ trans('admin.tarif-transfert-voyage.columns.prix_vente_aller_retour') }}</th>
                                        <th is='sortable' :column="'prime_nuit'">{{ trans('admin.tarif-transfert-voyage.columns.prime_nuit') }}</th>

                                        <th></th>
                                    </tr>
                                    <tr v-show="(clickedBulkItemsCount > 0) || isClickedAll">
                                        <td class="bg-bulk-info d-table-cell text-center" colspan="13">
                                            <span class="align-middle font-weight-light text-dark">{{ trans('brackets/admin-ui::admin.listing.selected_items') }} @{{ clickedBulkItemsCount }}.  <a href="#" class="text-primary" @click.prevent="onBulkItemsClickedAll('/admin/tarif-transfert-voyages')" v-if="(clickedBulkItemsCount < pagination.state.total)"> <i class="fa" :class="bulkCheckingAllLoader ? 'fa-spinner' : ''"></i> {{ trans('brackets/admin-ui::admin.listing.check_all_items') }} @{{ pagination.state.total }}</a> <span class="text-primary">|</span> <a
                                                        href="#" class="text-primary" @click.prevent="onBulkItemsClickedAllUncheck()">{{ trans('brackets/admin-ui::admin.listing.uncheck_all_items') }}</a>  </span>

                                            <span class="pull-right pr-2">
                                                <button class="btn btn-sm btn-danger pr-3 pl-3" @click.prevent="bulkDelete(urlbase+'/admin/tarif-transfert-voyages/bulk-destroy')">{{ trans('brackets/admin-ui::admin.btn.delete') }}</button>
                                            </span>

                                        </td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(item, index) in collection" :key="item.id" :class="bulkItems[item.id] ? 'bg-bulk' : ''">
                                        <td class="bulk-checkbox">
                                            <input class="form-check-input" :id="'enabled' + item.id" type="checkbox" v-model="bulkItems[item.id]" v-validate="''" :data-vv-name="'enabled' + item.id"  :name="'enabled' + item.id + '_fake_element'" @click.prevent="onBulkItemClicked(item.id)" :disabled="bulkCheckingAllLoader">
                                            <label class="form-check-label" :for="'enabled' + item.id">
                                            </label>
                                        </td>

                                    <td>@{{ item.id }}</td>
                                        <td>@{{ item.trajet_transfert_voyage_id }}</td>
                                        <td>@{{ item.tranche_transfert_voyage_id }}</td>
                                        <td>@{{ item.type_personne_id }}</td>
                                        <td>@{{ item.prix_achat_aller }}</td>
                                        <td>@{{ item.prix_achat_aller_retour }}</td>
                                        <td>@{{ item.marge_aller }}</td>
                                        <td>@{{ item.marge_aller_retour }}</td>
                                        <td>@{{ item.prix_vente_aller }}</td>
                                        <td>@{{ item.prix_vente_aller_retour }}</td>
                                        <td>@{{ item.prime_nuit }}</td>
                                        
                                        <td>
                                            <div class="row no-gutters">
                                                <div class="col-auto">
                                                    <a class="btn btn-sm btn-spinner btn-info" :href="item.resource_url + '/edit'" title="{{ trans('brackets/admin-ui::admin.btn.edit') }}" role="button"><i class="fa fa-edit"></i></a>
                                                </div>
                                                <form class="col" @submit.prevent="deleteItem(item.resource_url)">
                                                    <button type="submit" class="btn btn-sm btn-danger" title="{{ trans('brackets/admin-ui::admin.btn.delete') }}"><i class="fa fa-trash-o"></i></button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <div class="row" v-if="pagination.state.total > 0">
                                <div class="col-sm">
                                    <span class="pagination-caption">{{ trans('brackets/admin-ui::admin.pagination.overview') }}</span>
                                </div>
                                <div class="col-sm-auto">
                                    <pagination></pagination>
                                </div>
                            </div>

                            <div class="no-items-found" v-if="!collection.length > 0">
                                <i class="icon-magnifier"></i>
                                <h3>{{ trans('brackets/admin-ui::admin.index.no_items') }}</h3>
                                <p>{{ trans('brackets/admin-ui::admin.index.try_changing_items') }}</p>
                                <a class="btn btn-primary" href="{{ url('admin/tarif-transfert-voyages/create') }}" role="button"><i class="fa fa-plus"></i>&nbsp; {{ trans('admin.tarif-transfert-voyage.actions.create') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </tarif-transfert-voyage-listing>

@endsection