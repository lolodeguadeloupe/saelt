@extends('admin.customer-layout.layout.default')

@section('title', trans('admin.supplement-vue.actions.index'))

@section('body')

<supplement-vue-listing :data="{{ $data->toJson() }}" :url="'{{ url('admin/supplement-vues?heb='.$hebergement->id) }}'" :action="'{{ url('admin/supplement-vues?heb='.$hebergement->id) }}'" :appliquer="{{$supp_appliquer}}" :urlchambre="'{{url('admin/chambres?heb='.$hebergement->id)}}'" :urlbase="'{{base_url('')}}'" :urlasset="'{{asset('')}}'" inline-template>

    <div style="display: contents;position:relative">
        <div class="row">
            @include('admin.hebergement.view-header.header')
        </div>
        <div class="row has--child-nav">
            <div class="col-2 child-_nav" style="height: auto !important;">
                @include('admin.hebergement.view-header.nav-child')
            </div>
            <div class="col-10 content-_nav">
                <div class="card position-relative">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i>
                        <h3>{{ trans('admin.supplement-vue.actions.index') }}</h3>
                        <a class="btn btn-primary btn-sm pull-right m-b-0" href="#" @click.prevent="createSupVue($event,'{{url('admin/supplement-vues/create?heb='.$hebergement->id)}}')" role="button"><i class="fa fa-plus"></i>&nbsp; {{ trans('admin.supplement-vue.actions.create') }}</a>
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
                                                <input class="form-check-input" id="enabled" type="checkbox" v-model="isClickedAll" v-validate="''" data-vv-name="enabled" name="enabled_fake_element" @click.prevent="onBulkItemsClickedAllWithPagination()">
                                                <label class="form-check-label" for="enabled">
                                                </label>
                                            </th>

                                            <th is='sortable' :column="'id'">{{ trans('admin.supplement-vue.columns.id') }}</th>
                                            <th is='sortable' :column="'titre'">{{ trans('admin.supplement-vue.columns.titre') }}</th>
                                            <th is='sortable' :column="'prestataire_id'">{{ trans('admin.prestataire.title') }}</th>
                                            <th is='sortable' :column="'regle_tarif'">{{ trans('admin.supplement-vue.columns.regle_tarif') }}</th>
                                            <th>{{ trans('admin.supplement-activite.columns.tarif') }} / Jour</th>

                                            <th></th>
                                        </tr>
                                        <tr v-show="(clickedBulkItemsCount > 0) || isClickedAll">
                                            <td class="bg-bulk-info d-table-cell text-center" colspan="9">
                                                <span class="align-middle font-weight-light text-dark">{{ trans('admin-base.listing.selected_items') }} @{{ clickedBulkItemsCount }}. <a href="#" class="text-primary" @click.prevent="onBulkItemsClickedAll('/admin/supplement-vues')" v-if="(clickedBulkItemsCount < pagination.state.total)"> <i class="fa" :class="bulkCheckingAllLoader ? 'fa-spinner' : ''"></i> {{ trans('admin-base.listing.check_all_items') }} @{{ pagination.state.total }}</a> <span class="text-primary">|</span> <a href="#" class="text-primary" @click.prevent="onBulkItemsClickedAllUncheck()">{{ trans('admin-base.listing.uncheck_all_items') }}</a> </span>

                                                <span class="pull-right pr-2">
                                                    <button class="btn btn-sm btn-danger pr-3 pl-3" @click.prevent="bulkDelete(urlbase+'/admin/supplement-vues/bulk-destroy')">{{ trans('admin-base.btn.delete') }}</button>
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
                                            <td>@{{ appliquer[item.regle_tarif - 1].value }}</td>
                                            <td>@{{ item.tarif[0].prix_vente }} <span class="unite-tarif">€</span></td>

                                            <td>
                                                <div class="row no-gutters">
                                                    <div class="col-auto">
                                                        <a class="btn btn-sm btn-info" @click.prevent="editSupVue($event,item.resource_url + '/edit')" href="#" title="{{ trans('admin-base.btn.edit') }}" role="button"><i class="fa fa-edit"></i></a>
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

                            <!--
                            <table class="table table-hover table-listing">
                                <thead>
                                    <tr>
                                        <th class="bulk-checkbox">
                                            <input class="form-check-input" id="enabled" type="checkbox" v-model="isClickedAll" v-validate="''" data-vv-name="enabled" name="enabled_fake_element" @click.prevent="onBulkItemsClickedAllWithPagination()">
                                            <label class="form-check-label" for="enabled">
                                            </label>
                                        </th>

                                        <th is='sortable' :column="'id'">{{ trans('admin.supplement-vue.columns.id') }}</th>
                                        <th is='sortable' :column="'titre'">{{ trans('admin.supplement-vue.columns.titre') }}</th>
                                        <th is='sortable' :column="'regle_tarif'">{{ trans('admin.supplement-vue.columns.regle_tarif') }}</th>
                                        <th>{{ trans('admin.supplement-activite.columns.marge') }}</th>
                                        <th>{{ trans('admin.supplement-activite.columns.prix_achat') }}</th>
                                        <th>{{ trans('admin.supplement-activite.columns.prix_vente') }}</th>

                                        <th></th>
                                    </tr>
                                    <tr v-show="(clickedBulkItemsCount > 0) || isClickedAll">
                                        <td class="bg-bulk-info d-table-cell text-center" colspan="8">
                                            <span class="align-middle font-weight-light text-dark">{{ trans('admin-base.listing.selected_items') }} @{{ clickedBulkItemsCount }}. <a href="#" class="text-primary" @click.prevent="onBulkItemsClickedAll('/admin/supplement-vues')" v-if="(clickedBulkItemsCount < pagination.state.total)"> <i class="fa" :class="bulkCheckingAllLoader ? 'fa-spinner' : ''"></i> {{ trans('admin-base.listing.check_all_items') }} @{{ pagination.state.total }}</a> <span class="text-primary">|</span> <a href="#" class="text-primary" @click.prevent="onBulkItemsClickedAllUncheck()">{{ trans('admin-base.listing.uncheck_all_items') }}</a> </span>

                                            <span class="pull-right pr-2">
                                                <button class="btn btn-sm btn-danger pr-3 pl-3" @click.prevent="bulkDelete(urlbase+'/admin/supplement-vues/bulk-destroy')">{{ trans('admin-base.btn.delete') }}</button>
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
                                        <td>@{{ appliquer[item.regle_tarif - 1].value }}</td>
                                        <td>@{{ item.tarif[0].marge }} <span class="unite-tarif">€</span></td>
                                        <td>@{{ item.tarif[0].prix_achat }} <span class="unite-tarif">€</span></td>
                                        <td>@{{ item.tarif[0].prix_vente }} <span class="unite-tarif">€</span></td>

                                        <td>
                                            <div class="row no-gutters">
                                                <div class="col-auto">
                                                    <a class="btn btn-sm btn-info" @click.prevent="editSupVue($event,item.resource_url + '/edit')" href="#"  title="{{ trans('admin-base.btn.edit') }}" role="button"><i class="fa fa-edit"></i></a>
                                                </div>
                                                <form class="col" @submit.prevent="deleteItem(item.resource_url)">
                                                    <button type="submit" class="btn btn-sm btn-danger" title="{{ trans('admin-base.btn.delete') }}"><i class="fa fa-trash-o"></i></button>
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
                                <a class="btn btn-primary" href="#" @click.prevent="createSupVue($event,'{{url('admin/supplement-vues/create?heb='.$hebergement->id)}}')" role="button"><i class="fa fa-plus"></i>&nbsp; {{ trans('admin.supplement-vue.actions.create') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <modal name="edit_sup_vue" :scrollable="true" :min-width="320" :max-width="1000" height="auto" width="100%" :draggable="true" @opened="myEvent.editSupVue()" :adaptive="true">
            @include('admin.hebergement.supplement-vue.edit')
        </modal>
        <modal name="create_sup_vue" :scrollable="true" :min-width="320" :max-width="1000" height="auto" width="100%" :draggable="true" @opened="myEvent.createSupVue()" :adaptive="true">
            @include('admin.hebergement.supplement-vue.create')
        </modal>
    </div>
</supplement-vue-listing>

@endsection