@extends('admin.customer-layout.layout.default')

@section('title', trans('admin.excursion.actions.index'))

@section('body')

<excursion-listing :data="{{ $data->toJson() }}" :url="'{{ url('admin/excursions') }}'" :action="'{{url('admin/excursions') }}'" :urlbase="'{{base_url('')}}'" :urlasset="'{{asset('')}}'" :urlexcursionwithprestataire="'{{url('admin/excursions/prestataire')}}'" :urlprestataire="'{{url('admin/prestataires')}}'" :urlcalendar="'{{url('admin/event-date-heures')}}'" :urltaxe="'{{url('admin/taxes')}}'" inline-template>
    <diV style="display:contents; position:relative">
        <div class="row">
            <div class="col">
                <div class="card position-relative">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i>
                        <h3>{{ trans('admin.excursion.actions.index') }}</h3>
                        <a class="btn btn-primary btn-sm pull-right m-b-0" href="#" @click.prevent="createExcursion($event,'{{ url('admin/excursions/create') }}')" role="button"><i class="fa fa-plus"></i>&nbsp; {{ trans('admin.excursion.actions.create') }}</a>
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

                                            <th is='sortable' :column="'id'">{{ trans('admin.excursion.columns.id') }}</th>
                                            <th is='sortable' :column="'title'">{{ trans('admin.excursion.columns.title') }}</th>
                                            <th is='sortable' :column="'participant_min'">{{ trans('admin.excursion.columns.participant_min') }}</th>
                                            <th is='sortable' :column="'ville_id'">{{ trans('admin.excursion.columns.ville_id') }}</th>
                                            <th is='sortable' :column="'iles.name'">{{ trans('admin.excursion.columns.ile_id') }}</th>
                                            <th is='sortable' :column="'prestataire.name'">{{ trans('admin.excursion.columns.prestataire') }}</th>
                                            <th is='sortable' :column="'duration'">{{ trans('admin.excursion.columns.duration') }}</th>
                                            <th is='sortable' :column="'availability'">{{ trans('admin.excursion.columns.availability') }}</th>
                                            <th is='sortable' :column="'heure_depart'">{{ trans('admin.excursion.columns.heure_depart') }}</th>
                                            <th is='sortable' :column="'adresse_depart'">{{ trans('admin.excursion.columns.adresse_depart') }}</th>
                                            <th is='sortable' :column="'adresse_arrive'">{{ trans('admin.excursion.columns.adresse_arrive') }}</th>
                                            <th is='sortable' :column="'lunch'">{{ trans('admin.excursion.columns.options_included.title') }}</th>
                                            <th>{{ trans('admin.excursion.columns.lunch_prestataire') }}</th>
                                            <th>{{ trans('admin.excursion.columns.ticket_billeterie') }}</th>
                                            <!--<th is='sortable' :column="'id'">{{ trans('admin.hebergement.columns.taxe') }}</th>-->
                                            <th is='sortable' :column="'status'">{{ trans('admin.excursion.columns.status') }}</th>


                                            <th></th>
                                        </tr>
                                        <tr v-show="(clickedBulkItemsCount > 0) || isClickedAll">
                                            <td class="bg-bulk-info d-table-cell text-center" colspan="18">
                                                <span class="align-middle font-weight-light text-dark">{{ trans('admin-base.listing.selected_items') }} @{{ clickedBulkItemsCount }}. <a href="#" class="text-primary" @click.prevent="onBulkItemsClickedAll('/admin/excursions')" v-if="(clickedBulkItemsCount < pagination.state.total)"> <i class="fa" :class="bulkCheckingAllLoader ? 'fa-spinner' : ''"></i> {{ trans('brackets/admin-ui::admin.listing.check_all_items') }} @{{ pagination.state.total }}</a> <span class="text-primary">|</span> <a href="#" class="text-primary" @click.prevent="onBulkItemsClickedAllUncheck()">{{ trans('admin-base.listing.uncheck_all_items') }}</a> </span>

                                                <span class="pull-right pr-2">
                                                    <button class="btn btn-sm btn-danger pr-3 pl-3" @click.prevent="bulkDelete(urlbase+'/admin/excursions/bulk-destroy')">{{ trans('admin-base.btn.delete') }}</button>
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
                                                @{{ item.id }}
                                            </td>
                                            <td>
                                                <div class="link" @click.prevent="detail($event,item.id)"></div>
                                                @{{ item.title }}
                                            </td>

                                            <td>
                                                <div class="link" @click.prevent="detail($event,item.id)"></div>
                                                @{{ item.participant_min }}
                                            </td>
                                            <td>
                                                <div class="link" @click.prevent="detail($event,item.id)"></div>
                                                <span>@{{ item.ville?item.ville.name:'' }}</span>
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
                                                <span>@{{item.duration}}</span>
                                            </td>

                                            <td>
                                                <ul class="list-in-table">
                                                    <li v-for="(availability,_index) in fnWeekRender(item.availability)">
                                                        <div class="link" @click.prevent="detail($event,item.id)"></div>
                                                        <span>@{{availability}}</span>
                                                    </li>
                                                </ul>
                                            </td>

                                            <td>
                                                <div class="link" @click.prevent="detail($event,item.id)"></div>
                                                <span>@{{item.heure_depart}}</span>
                                            </td>
                                            <td>
                                                <div class="link" @click.prevent="detail($event,item.id)"></div>
                                                <span>@{{item.adresse_depart}}</span>
                                            </td>
                                            <td>
                                                <div class="link" @click.prevent="detail($event,item.id)"></div>
                                                <span>@{{item.adresse_arrive}}</span>
                                            </td>

                                            <td>
                                                <div class="link" @click.prevent="detail($event,item.id)"></div>
                                                <ul class="list-in-table">
                                                    <li v-if="item.lunch == '1'">
                                                        {{ trans('admin.excursion.columns.options_included.lunch') }}
                                                    </li>
                                                    <li v-if="item.ticket == '1'">
                                                        {{ trans('admin.excursion.columns.options_included.ticket') }}
                                                    </li>
                                                </ul>
                                            </td>
                                            <td>
                                                <ul class="list-in-table">
                                                    <li v-for="(retaurant,_i_restaurant) in item.lunch_prestataire">
                                                        <div class="link" @click.prevent="detail($event,item.id)"></div>
                                                        <span>@{{retaurant.name}}</span>
                                                    </li>
                                                </ul>
                                            </td>
                                            <td>
                                                <ul class="list-in-table">
                                                    <li v-for="(billeterie,_i_billeterie) in item.ticket_billeterie">
                                                        <div class="link" @click.prevent="detail($event,item.id)"></div>
                                                        <span>@{{billeterie.titre}}</span>
                                                    </li>
                                                </ul>
                                            </td>
                                            <!--
                                        <td>
                                            <div class="link" @click.prevent="detail($event,item.id)"></div>
                                            <ul class="list-in-table">
                                                <li v-for="(_taxe,_index) in item.taxe">
                                                    <a href="#">@{{_taxe.titre}}</a>
                                                </li>
                                            </ul>
                                        </td>
-->
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
                                                        <a class="btn btn-sm btn-info" @click.prevent="editExcursion($event,item.resource_url + '/edit')" href="#" title="{{ trans('brackets/admin-ui::admin.btn.edit') }}" role="button"><i class="fa fa-edit"></i></a>
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
                                <a class="btn btn-primary" href="#" @click.prevent="createExcursion($event,'{{ url('admin/excursions/create') }}')" role="button"><i class="fa fa-plus"></i>&nbsp; {{ trans('admin.excursion.actions.create') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <modal name="edit_excursion" :scrollable="true" :min-width="320" :max-width="1000" height="auto" width="100%" :draggable="false" @opened="myEvent.editExcursion()" :adaptive="true">
            @include('admin.excursion.excursion.edit')
        </modal>

        <modal name="create_excursion" :click-to-close="false" :scrollable="true" :min-width="320" :max-width="1000" height="auto" width="100%" :draggable="false" :adaptive="true">
            @include('admin.excursion.excursion.create')
        </modal>

        <modal name="create_prestataire" :scrollable="true" :min-width="320" :max-width="1000" height="auto" width="100%" :draggable="true" :adaptive="true">
            @include('admin.excursion.excursion.create-prestataire')
        </modal>


        <modal name="create_ville" :scrollable="true" :min-width="320" :max-width="600" height="auto" width="100%" :draggable="true" :adaptive="true">
            @include('admin.excursion.excursion.ville')
        </modal>

        <modal name="create_ile" :scrollable="true" :min-width="320" :max-width="600" height="auto" width="100%" :draggable="true" :adaptive="true">
            @include('admin.excursion.excursion.ile')
        </modal>

        <modal name="create_pays" :scrollable="true" :min-width="320" :max-width="500" height="auto" width="100%" :draggable="true" :adaptive="true">
            @include('admin.excursion.excursion.pays')
        </modal>

        <modal name="calendar" :class="'min-width'" :click-to-close="false" :scrollable="true" :min-width="320" :max-width="1000" height="auto" width="100%" :draggable="true" :adaptive="true">
            @include('admin.excursion.excursion.calendar')
        </modal>
        <modal name="create_taxe" :click-to-close="false" :scrollable="true" :min-width="320" :max-width="1000" height="auto" width="100%" :draggable="true" @opened="myEvent.createTaxe()" :adaptive="true">
            @include('admin.excursion.excursion.taxe')
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
</excursion-listing>

@endsection