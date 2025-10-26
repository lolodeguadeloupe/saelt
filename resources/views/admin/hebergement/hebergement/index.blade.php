@extends('admin.customer-layout.layout.default')

@section('title', trans('admin.hebergement.actions.index'))

@section('body')
<hebergement-listing :data="{{ $data->toJson() }}" :url="'{{ url('admin/hebergements') }}'" :action="'{{url('admin/hebergements') }}'" :chambre="'{{url('admin/chambres')}}'" :tarif="'{{url('admin/tarifs/detail')}}'" :urltypeheb="'{{url('admin/type-hebergements')}}'" :urlbase="'{{base_url('')}}'" :urlasset="'{{asset('')}}'" :urlhebwithprestataire="'{{url('admin/hebergements/prestataire')}}'" :urlprestataire="'{{url('admin/prestataires')}}'" :urlcalendar="'{{url('admin/event-date-heures')}}'" :urltaxe="'{{url('admin/taxes')}}'" inline-template>
    <diV style="display:contents; position:relative">
        <div class="row">
            <div class="col content-list-table">
                <div class="card position-relative">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i>
                        <h3>{{ trans('admin.hebergement.actions.index') }}</h3>

                        <a class="btn btn-primary btn-sm pull-right m-b-0" href="#" @click.prevent="createHeb($event,url+'/create')" role="button"><i class="fa fa-plus"></i>&nbsp; {{ trans('admin.hebergement.actions.create') }}</a>
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

                                            <th is='sortable' :column="'id'">{{ trans('admin.hebergement.columns.id') }}</th>
                                            <th is='sortable' :column="'name'">{{ trans('admin.hebergement.columns.name') }}</th>
                                            <th is='sortable' :column="'type_hebergement.name'">{{ trans('admin.hebergement.columns.type_hebergement') }}</th>
                                            <!--<th is='sortable' :column="'duration_min'">{{ trans('admin.hebergement.columns.duration_min') }}</th>-->
                                            <th is='sortable' :column="'adresse'">{{ trans('admin.hebergement.columns.adresse') }}</th>
                                            <th is='sortable' :column="'ville_id'">{{ trans('admin.hebergement.columns.ville_id') }}</th>
                                            <th is='sortable' :column="'iles.name'">{{ trans('admin.hebergement.columns.ile_id') }}</th>
                                            <th is='sortable' :column="'prestataire.name'">{{ trans('admin.hebergement.columns.prestataire') }}</th>
                                            <th is='sortable' :column="'id'">{{ trans('admin.hebergement.columns.taxe') }}</th>
                                            <th is='sortable' :column="'status'">{{ trans('admin.hebergement.columns.status') }}</th>

                                            <th></th>
                                        </tr>
                                        <tr v-show="(clickedBulkItemsCount > 0) || isClickedAll">
                                            <td class="bg-bulk-info d-table-cell text-center" colspan="12">
                                                <span class="align-middle font-weight-light text-dark">{{ trans('admin-base.listing.selected_items') }} @{{ clickedBulkItemsCount }}. <a href="#" class="text-primary" @click.prevent="onBulkItemsClickedAll('/admin/hebergements')" v-if="(clickedBulkItemsCount < pagination.state.total)"> <i class="fa" :class="bulkCheckingAllLoader ? 'fa-spinner' : ''"></i> {{ trans('admin-base.listing.check_all_items') }} @{{ pagination.state.total }}</a> <span class="text-primary">|</span> <a href="#" class="text-primary" @click.prevent="onBulkItemsClickedAllUncheck()">{{ trans('admin-base.listing.uncheck_all_items') }}</a> </span>

                                                <span class="pull-right pr-2">
                                                    <button class="btn btn-sm btn-danger pr-3 pl-3" @click.prevent="bulkDelete(urlbase+'/admin/hebergements/bulk-destroy')">{{ trans('admin-base.btn.delete') }}</button>
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
                                                <div class="link" @click.prevent="detail($event,item.id)"></div>
                                                <span>@{{ item.id }}</span>
                                            </td>
                                            <td>
                                                <div class="link" @click.prevent="detail($event,item.id)"></div>
                                                <span>@{{ item.name }}</span>
                                            </td>
                                            <td>
                                                <span> <a :href="urltypeheb+'?search='+item.type.name" style="color: black;"> @{{ item.type.name }}</a></span>
                                            </td>
                                            <!--<td>
                                            <div class="link" @click.prevent="detail($event,item.id)"></div>
                                            <span>@{{ item.duration_min }}</span>
                                        </td>-->
                                            <td>
                                                <div class="link" @click.prevent="detail($event,item.id)"></div>
                                                <span>@{{ item.adresse }}</span>
                                            </td>
                                            <td>
                                                <div class="link" @click.prevent="detail($event,item.id)"></div>
                                                <span>@{{ item.ville.name }}</span>
                                            </td>
                                            <td>
                                                <div class="link" @click.prevent="detail($event,item.id)"></div>
                                                <span>@{{ item.ile.name }}</span>
                                            </td>
                                            <td>
                                                <span> <a :href="urlprestataire+'?search='+item.prestataire.name" style="color: black;">@{{ item.prestataire.name }}</a></span>
                                            </td>
                                            <td>
                                                <div class="link" @click.prevent="detail($event,item.id)"></div>
                                                <ul class="list-in-table">
                                                    <li v-for="(_taxe,_index) in item.taxe">
                                                        <a href="#">@{{_taxe.titre}}</a>
                                                    </li>
                                                </ul>
                                            </td>
                                            <td>
                                                <div class="link" @click.prevent="detail($event,item.id)"></div>
                                                <div v-if="item.status == '1'" class="yes_option" style="cursor: pointer;"></div>
                                            </td>

                                            <td>
                                                <div class="row no-gutters">
                                                    <div class="col-auto">
                                                        <button type="button" class="btn btn-sm btn-info" @click.prevent="detail($event,item.id)"><i class="fa fa-info"></i></button>
                                                    </div>
                                                    <div class="col-auto">
                                                        <a class="btn btn-sm btn-info" @click.prevent="editHeb($event,item.resource_url + '/edit')" href="#" title="{{ trans('admin-base.btn.edit') }}" role="button"><i class="fa fa-edit"></i></a>
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
                                <a class="btn btn-primary" href="#" @click.prevent="createHeb($event,url+'/create')" role="button"><i class="fa fa-plus"></i>&nbsp; {{ trans('admin.hebergement.actions.create') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <modal name="edit_hebergement" :scrollable="true" :min-width="320" :max-width="1000" height="auto" width="100%" :draggable="false" @opened="myEvent.editHeb()" :adaptive="true">
            @include('admin.hebergement.hebergement.edit')
        </modal>

        <modal name="create_hebergement" :click-to-close="false" :scrollable="true" :min-width="320" :max-width="1000" height="auto" width="100%" :draggable="false" :adaptive="true">
            @include('admin.hebergement.hebergement.create')
        </modal>

        <modal name="create_type_hebergement" :scrollable="true" :min-width="320" :max-width="1000" height="auto" width="100%" :draggable="true" :adaptive="true">
            @include('admin.hebergement.hebergement.type')
        </modal>

        <modal name="create_prestataire" :scrollable="true" :min-width="320" :max-width="1000" height="auto" width="100%" :draggable="true" :adaptive="true">
            @include('admin.hebergement.hebergement.create-prestataire')
        </modal>

        <modal name="calendar" :class="'min-width'" :click-to-close="false" :scrollable="true" :min-width="320" :max-width="1000" height="auto" width="100%" :draggable="true" :adaptive="true">
            @include('admin.hebergement.hebergement.calendar')
        </modal>
        <modal name="create_taxe" :click-to-close="false" :scrollable="true" :min-width="320" :max-width="1000" height="auto" width="100%" :draggable="true" @opened="myEvent.createTaxe()" :adaptive="true">
            @include('admin.hebergement.hebergement.taxe')
        </modal>
        <modal name="create_ville" :scrollable="true" :min-width="320" :max-width="600" height="auto" width="100%" :draggable="true" :adaptive="true">
            @include('admin.hebergement.hebergement.ville')
        </modal>
        <modal name="create_ile" :scrollable="true" :min-width="320" :max-width="600" height="auto" width="100%" :draggable="true" :adaptive="true">
            @include('admin.hebergement.hebergement.ile')
        </modal>
        <modal name="create_pays" :scrollable="true" :min-width="320" :max-width="500" height="auto" width="100%" :draggable="true" :adaptive="true">
            @include('admin.hebergement.hebergement.pays')
        </modal>
        <modal name="calendar-edit" :class="'min-width'" :click-to-close="false" :scrollable="true" :min-width="320" :max-width="1000" height="auto" width="100%" :draggable="true" :adaptive="true">

            <div class="card" style="max-width: max-content;">
                <div class="card-body modifier-data-calendar-table">
                    <a class="float-right text-danger" style="cursor:pointer;" @click.prevent="closeModal('calendar-edit')"><i class="fa fa-times"></i></a>
                    <table>
                        <thead>
                            <tr>
                                <th>{{ trans('admin.event-date-heure.columns.status') }}</th>
                                <th>{{ trans('admin.event-date-heure.columns.date') }}</th>
                                <th>{{ trans('admin.event-date-heure.columns.time_start') }}</th>
                                <th>{{ trans('admin.event-date-heure.columns.time_end') }}</th>
                                <th>{{ trans('admin.event-date-heure.columns.description') }}</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(calendar_item,index) in dataCalendarModifier">
                                <td>@{{calendar_item.etat}}</td>
                                <td>@{{calendar_item.date | date}}</td>
                                <td>@{{calendar_item.time_start}}</td>
                                <td>@{{calendar_item.time_end}}</td>
                                <td>@{{calendar_item.description}}</td>
                                <td>
                                    <div class="row no-gutters">
                                        <div class="col-auto">
                                            <a class="btn btn-sm btn-danger" @click.prevent="deleteCalendar($event,calendar_item,index)" href="#" title="{{ trans('admin-base.btn.delete') }}" role="button"><i class="fa fa-trash-o"></i></a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </modal>
    </diV>
</hebergement-listing>

@endsection