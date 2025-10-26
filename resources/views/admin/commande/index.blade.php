@extends('admin.customer-layout.layout.default')

@section('title', trans('admin.commande.actions.index'))

@section('body')

<commande-listing :data="{{ $data->toJson() }}" :url="'{{ url('admin/commandes') }}'" :url="'{{ url('admin/commandes') }}'" :action="'{{url('admin/commandes') }}'" :urlbase="'{{base_url('')}}'" :urlasset="'{{asset('')}}'" inline-template>
    <div style="display: contents;position:relative">
        <div class="row">
            <div class="col">
                <div class="card position-relative">
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
                                <table class="table table-hover table-listing mt-5 my-table-striped">
                                    <thead>
                                        <tr>
                                            <th class="bulk-checkbox">
                                                <input class="form-check-input" id="enabled" type="checkbox" v-model="isClickedAll" v-validate="''" data-vv-name="enabled" name="enabled_fake_element" @click.prevent="onBulkItemsClickedAllWithPagination()">
                                                <label class="form-check-label" for="enabled">
                                                </label>
                                            </th>
                                            <th is='sortable' :column="'commande.id'">{{ trans('admin.commande.columns.id') }}</th>
                                            <th is='sortable' :column="'commande.date'">{{ trans('admin.commande.columns.date') }}</th>
                                            <th is='sortable' :column="'facturation_commande.nom'">{{ trans('admin.commande.columns.nom') }}</th>
                                            <th is='sortable' :column="'facturation_commande.prenom'">{{ trans('admin.commande.columns.prenom') }}</th>
                                            <th is='sortable' :column="'facturation_commande.ville'">{{ trans('admin.commande.columns.ville') }}</th>
                                            <th is='sortable' :column="'facturation_commande.code_postal'">{{ trans('admin.commande.columns.code_postal') }}</th>
                                            <th is='sortable' :column="'commande.status'">{{ trans('admin.commande.columns.status') }}</th>
                                            <th is='sortable' :column="'commande.prix'">{{ trans('admin.commande.columns.prix') }}</th>
                                            <th is='sortable' :column="'commande.tva'">{{ trans('admin.commande.columns.tva') }}</th>
                                            <th is='sortable' :column="'commande.frais_dossier'">{{ trans('admin.commande.columns.frais_dossier') }}</th>
                                            <th is='sortable' :column="'commande.prix_total'">{{ trans('admin.commande.columns.prix_total') }}</th>
                                            <th is='sortable' :column="'mode_payement.titre'">{{ trans('admin.commande.columns.mode_payement') }}</th>
                                            <th></th>
                                        </tr>
                                        <tr v-show="(clickedBulkItemsCount > 0) || isClickedAll">
                                            <td class="bg-bulk-info d-table-cell text-center" colspan="14">
                                                <span class="align-middle font-weight-light text-dark">{{ trans('brackets/admin-ui::admin.listing.selected_items') }} @{{ clickedBulkItemsCount }}. <a href="#" class="text-primary" @click.prevent="onBulkItemsClickedAll('/admin/commandes')" v-if="(clickedBulkItemsCount < pagination.state.total)"> <i class="fa" :class="bulkCheckingAllLoader ? 'fa-spinner' : ''"></i> {{ trans('brackets/admin-ui::admin.listing.check_all_items') }} @{{ pagination.state.total }}</a> <span class="text-primary">|</span> <a href="#" class="text-primary" @click.prevent="onBulkItemsClickedAllUncheck()">{{ trans('brackets/admin-ui::admin.listing.uncheck_all_items') }}</a> </span>

                                                <span class="pull-right pr-2">
                                                    <button class="btn btn-sm btn-danger pr-3 pl-3 d-none" @click.prevent="bulkDelete('/admin/commandes/bulk-destroy')">{{ trans('brackets/admin-ui::admin.btn.delete') }}</button>
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

                                            <td>
                                                <div class="link" @click.prevent="detail($event,item.id)"></div> <span>@{{ item.id }}</span>
                                            </td>
                                            <td>
                                                <div class="link" @click.prevent="detail($event,item.id)"></div><span>@{{ item.date | date }}</span>
                                            </td>
                                            <td>
                                                <div class="link" @click.prevent="detail($event,item.id)"></div><span>@{{ item.facture.nom }}</span>
                                            </td>
                                            <td>
                                                <div class="link" @click.prevent="detail($event,item.id)"></div><span>@{{ item.facture.prenom }}</span>
                                            </td>
                                            <td>
                                                <div class="link" @click.prevent="detail($event,item.id)"></div><span>@{{ item.facture.ville }}</span>
                                            </td>
                                            <td>
                                                <div class="link" @click.prevent="detail($event,item.id)"></div><span>@{{ item.facture.code_postal }}</span>
                                            </td>
                                            <td>
                                                <div class="link" @click.prevent="detail($event,item.id)"></div><span>@{{ item.status }}</span>
                                            </td>
                                            <td>
                                                <div class="link" @click.prevent="detail($event,item.id)"></div><span>@{{ item.prix }}€</span>
                                            </td>
                                            <td>
                                                <div class="link" @click.prevent="detail($event,item.id)"></div><span>@{{ item.tva }}€</span>
                                            </td>
                                            <td>
                                                <div class="link" @click.prevent="detail($event,item.id)"></div><span>@{{ item.frais_dossier }}€</span>
                                            </td>
                                            <td>
                                                <div class="link" @click.prevent="detail($event,item.id)"></div><span>@{{ item.prix_total }}€</span>
                                            </td>
                                            <td style="text-align: left;">
                                                <div class="link" @click.prevent="detail($event,item.id)"></div><span>@{{ item.mode_payement.titre }}</span>
                                            </td>
                                            <td>
                                                <div class="col-auto">
                                                    <button type="button" class="btn btn-sm btn-info" @click.prevent="detail($event,item.id)"><i class="fa fa-info"></i></button>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="row justify-content-md-between align-items-center mb-2 pt-5" v-if="pagination.state.total > 0">
                                <div class="col-sm">
                                    <span class="pagination-caption">{{ trans('brackets/admin-ui::admin.pagination.overview') }}</span>
                                </div>
                                <div class="col-sm-auto">
                                    <pagination></pagination>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</commande-listing>

@endsection