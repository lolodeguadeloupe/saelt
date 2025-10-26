@extends('admin.customer-layout.layout.default')

@section('title', trans('admin.vehicule-categorie-supplement.actions.index'))

@section('body')

<vehicule-categorie-supplement-listing :data="{{ $data->toJson() }}" :url="'{{ url('admin/vehicule-categorie-supplements/'.$categorie->id) }}'" :action="'{{ url('admin/vehicule-categorie-supplements') }}'" :urlbase="'{{base_url('')}}'" :urlasset="'{{asset('')}}'" :categorie="{{$categorie->toJson()}}" inline-template>

    <div class="row">
        <div class="col">
            <div class="card position-relative">
                <div class="card-header">
                    <i class="fa fa-align-justify"></i>
                    <h3> {{ trans('admin.vehicule-categorie-supplement.actions.index') }}</h3>
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

                        <form id="vehicule-categorie-supplementnalite" method="post" @submit.prevent="storeSupplement($event)" :action="actionFormUrlSupplement">
                            <div class="content-card-body">
                                <table class="table table-hover table-listing mt-5">
                                    <thead>
                                        <tr>
                                            <th class="bulk-checkbox">
                                                <input class="form-check-input" id="enabled" type="checkbox" v-model="isClickedAll" v-validate="''" data-vv-name="enabled" name="enabled_fake_element" @click.prevent="onBulkItemsClickedAllWithPagination()">
                                                <label class="form-check-label" for="enabled">
                                                </label>
                                            </th>

                                            <th is='sortable' :column="'id'" style="width: 15%;">{{ trans('admin.vehicule-categorie-supplement.columns.id') }}</th>
                                            <th style="width: 25%;" is='sortable' :column="'categorie.titre'">{{ trans('admin.vehicule-categorie-supplement.columns.categorie_vehicule_id') }}</th>
                                            <th style="width: 20%;" is='sortable' :column="'trajet.titre'">{{ trans('admin.vehicule-categorie-supplement.columns.trajet') }}</th>
                                            <th style="width: 20%;" is='sortable' :column="'tarif'">{{ trans('admin.vehicule-categorie-supplement.columns.tarif') }}</th>

                                            <th style="width: 20%;"></th>
                                        </tr>
                                        <tr v-show="(clickedBulkItemsCount > 0) || isClickedAll">
                                            <td class="bg-bulk-info d-table-cell text-center" colspan="6">
                                                <span class="align-middle font-weight-light text-dark">{{ trans('admin-base.listing.selected_items') }} @{{ clickedBulkItemsCount }}. <a href="#" class="text-primary" @click.prevent="onBulkItemsClickedAll(action)" v-if="(clickedBulkItemsCount < pagination.state.total)"> <i class="fa" :class="bulkCheckingAllLoader ? 'fa-spinner' : ''"></i> {{ trans('admin-base.listing.check_all_items') }} @{{ pagination.state.total }}</a> <span class="text-primary">|</span> <a href="#" class="text-primary" @click.prevent="onBulkItemsClickedAllUncheck()">{{ trans('admin-base.listing.uncheck_all_items') }}</a> </span>

                                                <span class="pull-right pr-2">
                                                    <button type="button" class="btn btn-sm btn-danger pr-3 pl-3" @click.prevent="bulkDelete(action+'/bulk-destroy')">{{ trans('admin-base.btn.delete') }}</button>
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

                                            <td :id="'liste-id-'+item.id">@{{ item.id }}</td>
                                            <td :id="'liste-categorie_vehicule_titre-'+item.id">@{{ item.categorie.titre }}</td>
                                            <td :id="'liste-restriction_trajet_titre-'+item.id">@{{ item.trajet.titre }}</td>
                                            <td :id="'liste-tarif-'+item.id">@{{ item.tarif }}</td>

                                            <td :id="'liste-modif-'+item.id">
                                                <div class="row no-gutters">
                                                    <div class="col-auto">
                                                        <a class="btn btn-sm btn-info" @click.prevent="editSupplement($event, action+ '/' + item.id + '/edit/'+item.categorie.id, item.id)" href="#" title="{{ trans('admin-base.btn.edit') }}" role="button"><i class="fa fa-edit"></i></a>
                                                    </div>
                                                    <div class="col">
                                                        <button type="button" @click.prevent="deleteSupplement($event,action+ '/' + item.id)" class="btn btn-sm btn-danger" title="{{ trans('admin-base.btn.delete') }}"><i class="fa fa-trash-o"></i></button>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr v-if="actionForm">
                                            <td></td>
                                            <td>
                                                <div class="form-group row align-items-center">
                                                    <div class="col-12">
                                                        <input type="text" readonly class="form-control" name="id" placeholder="{{ trans('admin.vehicule-categorie-supplement.columns.id') }}">
                                                    </div>
                                                </div>
                                            </td>

                                            <td>
                                                <div class="form-group row align-items-center">

                                                    <div class="col-12">
                                                        <input type="text" name="categorie_vehicule_id" style="display: none;" :value="categorie.id">
                                                        <input type="text" required class="form-control" readonly name="categorie_vehicule_titre" :value="categorie.titre" placeholder="{{ trans('admin.vehicule-categorie-supplement.columns.categorie') }}">
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group row align-items-center">

                                                    <div class="col-12">
                                                        <input type="text" name="restriction_trajet_id" style="display: none;">
                                                        <input type="text" required name="restriction_trajet_titre" class="form-control" placeholder="{{ trans('admin.vehicule-categorie-supplement.columns.trajet') }}" v-autocompletion="autocompleteTrajet" :action="urlbase+'/admin/autocompletion/restriction-trajet-locations'" :autokey="'id'" :label="'titre'" :inputkey="'restriction_trajet_id'" :inputlabel="'restriction_trajet_titre'">
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group row align-items-center">

                                                    <div class="col-12">
                                                        <input type="number" inputmode="decimal" step="any" required class="form-control" name="tarif" placeholder="{{ trans('admin.vehicule-categorie-supplement.columns.tarif') }}">
                                                    </div>
                                                </div>
                                            </td>
                                            <td style="padding-top: 5px;">
                                                <div class="row no-gutters">
                                                    <button type="submit" class="btn btn-primary" style="display: flex;align-items: center;width: max-content;">
                                                        <i class="fa fa-download"></i> &nbsp;
                                                        {{ trans('admin-base.btn.save') }}
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr v-if="!actionForm">
                                            <td colspan="6" style="display: table-cell !important;">
                                                <a class="btn btn-primary" href="#" @click.prevent="createSupplement" role="button"><i class="fa fa-plus"></i>&nbsp; {{ trans('admin.vehicule-categorie-supplement.actions.create') }}</a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <input type="text" name="model_saison" value="location_voiture" style="display: none;">F
                            </div>
                        </form>

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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</vehicule-categorie-supplement-listing>

@endsection