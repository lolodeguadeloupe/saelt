@extends('admin.customer-layout.layout.default')

@section('title', trans('admin.tarif.actions.index'))

@section('body')

<tarif-listing :data="{{ $data->toJson() }}" :typechambre="{{$chambres->toJson()}}" :url="'{{ url('admin/tarifs?heb='.$hebergement->id) }} '" :action="'{{ url('admin/tarifs') }}'" :idheb="'{{$hebergement->id}}'" :urlchambre="'{{url('admin/type-chambres?heb='.$hebergement->id)}}'" :urlbasetype="'{{url('admin/base-types?heb='.$hebergement->id)}}'" :urlpersonne="'{{url('admin/type-personnes?heb='.$hebergement->id)}}'" :urlsaison="'{{url('admin/saisons?heb='.$hebergement->id)}}'" :urltarifvol="'{{url('admin/hebergement-vols')}}'" :urltarifwithvol="'{{url('admin/tarifs/vol')}}'" :urlallotement="'{{url('admin/allotements')}}'" :urlbase="'{{base_url('')}}'" :urlasset="'{{asset('')}}'" inline-template>

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
                        <h3>{{ trans('admin.tarif.actions.index') }}</h3>
                        <a class="btn btn-primary btn-sm pull-right m-b-0" href="#" @click.prevent="createTarif($event,'{{url('admin/tarifs/create?heb='.$hebergement->id)}}')" role="button"><i class="fa fa-plus"></i>&nbsp; {{ trans('admin.tarif.actions.create') }}</a>
                    </div>
                    <div class="card-body" v-cloak>
                        <div class="card-block position-relative">
                            <form @submit.prevent="" class="w-100">
                                <div class="w-100 p-4">
                                    <div class="row border py-4 position-relative">
                                        <span class="position-absolute bg-white px-2" style="top: -14px;left: 5px;">
                                            {{trans('admin-base.filter.with')}}&nbsp;:
                                        </span>
                                        <div class="col-auto">
                                            <div class="input-group">
                                                <div class="input-group-prepend rounded-0">
                                                    <span class="input-group-text rounded-0">{{ trans('admin.tarif.columns.chambre_id') }}</span>
                                                </div>
                                                <select class="form-control" v-model="data_request_customer.type_chambre_id">
                                                    <option :value="$joinKey(state_Chambres,'id',',')"> {{trans('admin-base.filter.all')}}</option>
                                                    <option v-for="_type_chambre of state_Chambres" :value="_type_chambre.id"> @{{_type_chambre.name}}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="px-2">
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

                                            <th is='sortable' :column="'id'">{{ trans('admin.tarif.columns.id') }}</th>
                                            <th is='sortable' :column="'saisons.titre'">{{ trans('admin.tarif.columns.saison_id') }}</th>
                                            <th is='sortable' :column="'type_chambre.name'">{{ trans('admin.tarif.columns.chambre_id') }}</th>
                                            <th is='sortable' :column="'base_type.titre'">{{ trans('admin.tarif.columns.base_type_id') }}</th>
                                            <th>{{ trans('admin.tarif.columns.with_vol') }}</th>
                                            <th>Personne supplémentaire</th>
                                            <th>{{ trans('admin.tarif.columns.type_personne') }}</th>
                                            <th>{{ trans('admin.supplement-activite.columns.prix_achat') }}</th>
                                            <th>{{ trans('admin.supplement-activite.columns.marge') }}</th>
                                            <th>{{ trans('admin.supplement-activite.columns.prix_vente') }}</th>
                                            <th v-if="affiche_detail || true">{{ trans('admin.tarif.columns.tarif_supp') }}</th>
                                            <th colspan="2" class="text-left">
                                                <!-- <a @click.prevent="affiche_detail = !affiche_detail" class="btn btn-success btn-sm m-b-0" style="margin-top: -14px;" title="Plus détail"><i :class="`fa ${affiche_detail?'fa-chevron-left':'fa-chevron-right'}`"></i></a>-->
                                            </th>
                                        </tr>
                                        <tr v-show="(clickedBulkItemsCount > 0) || isClickedAll">
                                            <td class="bg-bulk-info d-table-cell text-center" colspan="13">
                                                <span class="align-middle font-weight-light text-dark">{{ trans('admin-base.listing.selected_items') }} @{{ clickedBulkItemsCount }}. <a href="#" class="text-primary" @click.prevent="onBulkItemsClickedAll('/admin/tarifs')" v-if="(clickedBulkItemsCount < pagination.state.total)"> <i class="fa" :class="bulkCheckingAllLoader ? 'fa-spinner' : ''"></i> {{ trans('admin-base.listing.check_all_items') }} @{{ pagination.state.total }}</a> <span class="text-primary">|</span> <a href="#" class="text-primary" @click.prevent="onBulkItemsClickedAllUncheck()">{{ trans('admin-base.listing.uncheck_all_items') }}</a> </span>

                                                <span class="pull-right pr-2">
                                                    <button class="btn btn-sm btn-danger pr-3 pl-3" @click.prevent="bulkDelete(urlbase+'/admin/tarifs/bulk-destroy')">{{ trans('admin-base.btn.delete') }}</button>
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
                                                <div class="link" @click.prevent="detail(item.id)"></div>
                                                @{{ item.id }}
                                            </td>
                                            <td>
                                                <a :href="urlsaison+'&search='+item.saison.titre">@{{ item.saison.titre }} <br> (@{{ item.saison.debut_format }} - @{{ item.saison.fin_format }})</a>
                                            </td>
                                            <td>
                                                <a :href="urlchambre+'&search='+item.type_chambre.name">@{{item.type_chambre.name}}</a>
                                            </td>
                                            <td>
                                                <a v-if="item.base_type" :href="urlbasetype+'&search='+item.base_type.titre">@{{item.base_type.titre}}</a>
                                            </td>
                                            <td>
                                                <div class="link" @click.prevent="detail(item.id)"></div>
                                                <div v-if="item.vol" class="yes_option" style="cursor: pointer;" :title="item.vol.depart|date" @click.prevent="detail(item.id)"></div>
                                            </td>
                                            <td>
                                                <div class="link" @click.prevent="detail(item.id)"></div>
                                                <span v-if="item.base_type">@{{ $parseInt(item.type_chambre.capacite) - $parseInt(item.base_type.nombre) }} Pers. supp.</span>
                                            </td>
                                            <td>
                                                <ul style="list-style: none;padding: 0;margin: 0;">
                                                    <li v-for="(tarif, _index) in item.tarif" style="border-bottom: 1px solid #f0f2f5; padding: 5px 0;">@{{tarif.personne.type}} <span> (@{{tarif.personne.age}})</span></li>
                                                </ul>
                                            </td>
                                            <td>
                                                <ul style="list-style: none;padding: 0;margin: 0;">
                                                    <li v-for="(tarif, _index) in item.tarif" style="border-bottom: 1px solid #f0f2f5; padding: 5px 0;">@{{tarif.prix_achat}} <span class="unite-tarif">€</span></li>
                                                </ul>
                                            </td>
                                            <td>
                                                <ul style="list-style: none;padding: 0;margin: 0;">
                                                    <li v-for="(tarif, _index) in item.tarif" style="border-bottom: 1px solid #f0f2f5; padding: 5px 0;">@{{tarif.marge}} <span class="unite-tarif">€</span></li>
                                                </ul>
                                            </td>
                                            <td>
                                                <ul style="list-style: none;padding: 0;margin: 0;">
                                                    <li v-for="(tarif, _index) in item.tarif" style="border-bottom: 1px solid #f0f2f5; padding: 5px 0;">@{{tarif.prix_vente}} <span class="unite-tarif">€</span></li>
                                                </ul>
                                            </td>
                                            <td v-if="affiche_detail || true">
                                                <ul style="list-style: none;padding: 0;margin: 0;" v-if="item.base_type">
                                                    <li v-for="(tarif, _index) in item.tarif" :class="($parseInt(item.type_chambre.capacite) - $parseInt(item.base_type.nombre) > 0 && !item.tarif)?'border-danger border':''" style="border-bottom: 1px solid #f0f2f5; padding: 5px 0;text-align: center;" v-if="tarif.prix_vente_supp != null">@{{tarif.prix_vente_supp}} <span class="unite-tarif">€</span></li>
                                                </ul>
                                            </td>
                                            <td>
                                                <ul style="list-style: none;padding: 0;margin: 0;">
                                                    <li v-for="(tarif, _index) in item.tarif" style="border-bottom: 1px solid #f0f2f5; padding: 5px 0;">
                                                        <button class="border-0 bg-transparent" title="{{trans('admin-base.btn.edit_single')}}" type="button" @click.prevent="editTarifPersonne($event,tarif.resource_url + '/edit','')"><i class="fa fa-pencil text-info"></i></button>
                                                    </li>
                                                </ul>
                                            </td>
                                            <td style="display: table-cell !important;">
                                                <div class="row no-gutters">
                                                    <div class="col-auto">
                                                        <button type="button" class="btn btn-sm btn-info" @click.prevent="detail(item.id)"><i class="fa fa-info"></i></button>
                                                    </div>
                                                    <div class="col-auto">
                                                        <a class="btn btn-sm btn-info" @click.prevent="editTarif($event,item.resource_url + '/edit')" title="{{ trans('admin-base.btn.edit') }}" role="button"><i class="fa fa-edit"></i></a>
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
                                <div class="col col-lg-7 col-xl-5 form-group">
                                    <span class="pagination-caption mb-0">{{ trans('admin-base.pagination.overview') }}</span>
                                </div>
                                <div class="col-sm-auto form-group ">
                                    <pagination class="mb-ul-0"></pagination>
                                </div>
                            </div>

                            <div class="no-items-found" v-if="!collection.length > 0">
                                <i class="icon-magnifier"></i>
                                <h3>{{ trans('admin-base.index.no_items') }}</h3>
                                <p>{{ trans('admin-base.index.try_changing_items') }}</p>
                                <a class="btn btn-primary" href="#" @click.prevent="createTarif($event,'{{url('admin/tarifs/create?heb='.$hebergement->id)}}')" role="button"><i class="fa fa-plus"></i>&nbsp; {{ trans('admin.tarif.actions.create') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <modal name="edit_tarif" :scrollable="true" :min-width="320" :max-width="1000" height="auto" width="100%" :draggable="true" @opened="myEvent.editTarif()" :adaptive="true">
            @include('admin.hebergement.tarif.edit')
        </modal>
        <modal name="create_tarif" :scrollable="true" :min-width="320" :max-width="1000" height="auto" width="100%" :draggable="true" @opened="myEvent.createTarif()" :adaptive="true">
            @include('admin.hebergement.tarif.create')
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
                        <label for="montant" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.tarif.columns.prix_achat') }}</label>
                        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
                            <input type="number" inputmode="decimal" step="any" min="0" class="form-control with-unite" @input="checkMarge($event,'')" name="prix_achat">
                            <span style="position: absolute; left: 20px; top: 0; width:auto; height: 100%;display: flex;align-items: center; font-weight: 500; text-decoration: underline;font-size: 18px;">€</span>
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
    </div>
</tarif-listing>

@endsection