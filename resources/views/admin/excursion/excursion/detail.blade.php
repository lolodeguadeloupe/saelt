@extends('admin.customer-layout.layout.default')

@section('title', trans('admin.excursion.actions.index'))

@section('styles')
<style>
    .form-_label {
        display: flex;
        margin-bottom: 20px;
    }

    .form-_label>span {
        margin-left: 1em;
        height: auto !important;
    }

    .cliquable:hover {
        cursor: pointer;
        font-weight: 600 !important;
    }

    .my--tab {
        height: 40px;
        width: calc(100% + 40px);
        margin-top: -20px;
        margin-bottom: 30px;
        display: flex;
        align-items: center;
        margin-left: -20px;
    }

    .my--tab .item--tab {
        border: 1px solid rgba(207, 216, 220, 0.35);
        width: 50%;
        height: 100%;
        margin: auto;
        display: flex;
        align-items: center;
        cursor: pointer;
        box-shadow: 0 2px 3px 0 #a4ceea;
    }

    .my--tab .item--tab.active {
        border-width: 0;
        box-shadow: unset;
        cursor: initial;
    }

    .my--tab .item--tab:hover {
        font-weight: 500;
        color: #3578a5;
    }

    .my--tab .item--tab.active:hover {
        font-weight: initial;
        color: #3578a5;
    }

    .my--tab .item--tab span {
        margin: auto;
    }

    .my--tab .edit {
        margin-right: 30px;
        position: relative;
        cursor: pointer;
    }

    .my--tab .edit::after {
        box-shadow: 0 2px 0 0 grey;
        content: "";
        width: 100%;
        height: 1px;
        bottom: 0;
        left: 0;
        position: absolute;
    }

    .my--tab .edit:hover {
        transform: scale(1.6);
    }
</style>
@endsection

@section('body')
<detail-excursion-listing :detail="{{$data}}" :datacalendar="{{$calendar->toJson()}}" :url="'{{ $excursion->resource_url }}'" :action="'{{url('admin/excursions') }}'" :urlbase="'{{base_url('')}}'" :urlasset="'{{asset('')}}'" :urlcalendar="'{{url('admin/event-date-heures')}}'" :urltaxe="'{{url('admin/taxes')}}'" inline-template>
    <div style="display: contents;position:relative">
        <div class="row">
            @include('admin.excursion.view-header.header')
        </div>
        <div class="row has--child-nav">
            <div class="col-2 child-_nav" style="height: auto !important;">
                @include('admin.excursion.view-header.nav-child')
            </div>
            <div class="col-10 content-_nav">
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i>
                        <h3>{{ trans('admin.excursion.actions.index') }} / {{ trans('admin.prestataire.actions.index') }}</h3>
                    </div>
                    <div class="card-body" v-cloak style="position: relative;" v-for="(item,index) in data_detail" :key="item.id">
                        <div class="my--tab">
                            <div class="item--tab" :class="pagination_[0]?'active':''" @click.prevent="nextPage([false,true])"><span>{{ trans('admin.excursion.actions.index') }} </span> <i v-if="pagination_[0]" class="fa fa-pencil edit" @click.prevent="editExcursion($event,item.resource_url + '/edit')"></i> </div>
                            <div class="item--tab" :class="pagination_[1]?'active':''" @click.prevent="nextPage([true,false])"><span>{{ trans('admin.prestataire.actions.index') }}</span> <i v-if="pagination_[1]" class="fa fa-pencil edit" @click.prevent="editPrestataire($event,item.prestataire.resource_url + '/edit')"></i> </div>
                        </div>
                        <div class="row">
                            <div class="col-12" v-if="pagination_[0]">
                                <div class="form-_label">
                                    <label for="type" class="col-form-label text-md-right col-md-3">{{trans('admin.excursion.columns.status')}} </label>
                                    <span class="form-control  cliquable" @click.prevent="editExcursion($event,item.resource_url + '/edit')">
                                        <div v-if="item.status == '1'"> {{trans('admin.excursion.columns.ouverte')}}</div>
                                        <div v-if="item.status == '0'"> {{trans('admin.excursion.columns.fermet')}}</div>
                                    </span>
                                </div>
                                <div class="form-_label">
                                    <label for="title" class="col-form-label text-md-right col-md-3">{{trans('admin.excursion.columns.title')}} </label>
                                    <span class="form-control cliquable" @click.prevent="editExcursion($event,item.resource_url + '/edit')">@{{item.title}}</span>
                                </div>
                                <div class="form-_label">
                                    <label for="ville_exc" class="col-form-label text-md-right col-md-3">{{trans('admin.excursion.columns.ville_id')}} </label>
                                    <span class="form-control  cliquable" @click.prevent="editExcursion($event,item.resource_url + '/edit')">@{{item.ville?item.ville.name:''}}</span>
                                </div>
                                <div class="form-_label">
                                    <label for="ile_id" class="col-form-label text-md-right col-md-3">{{trans('admin.excursion.columns.ile_id')}} </label>
                                    <span class="form-control  cliquable" @click.prevent="editExcursion($event,item.resource_url + '/edit')">@{{item.ile.name}}</span>
                                </div>
                                <div class="form-_label">
                                    <label for="type" class="col-form-label text-md-right col-md-3">{{trans('admin.excursion.columns.duration')}} </label>
                                    <span class="form-control  cliquable" @click.prevent="editExcursion($event,item.resource_url + '/edit')">@{{item.duration}}</span>
                                </div>
                                <div class="form-_label">
                                    <label for="type" class="col-form-label text-md-right col-md-3">{{trans('admin.excursion.columns.participant_min')}} </label>
                                    <span class="form-control  cliquable" @click.prevent="editExcursion($event,item.resource_url + '/edit')">@{{item.participant_min}}</span>
                                </div>
                                <!--
                                <div class="form-_label">
                                    <label for="type" class="col-form-label text-md-right col-md-3">{{trans('admin.excursion.columns.taxe')}} </label>
                                    <span class="form-control  cliquable" @click.prevent="editExcursion($event,item.resource_url + '/edit')">
                                        <ul class="list-in-table">
                                            <li v-for="_taxe of item.taxe">
                                                @{{_taxe.titre}}
                                            </li>
                                        </ul>
                                    </span>
                                </div>
-->
                                <div class="form-_label">
                                    <label for="type" class="col-form-label text-md-right col-md-3">{{trans('admin.excursion.columns.availability')}} </label>
                                    <span class="form-control  cliquable" @click.prevent="editExcursion($event,item.resource_url + '/edit')">
                                        <ul class="list-in-table">
                                            <li v-for="(availability,_index) in fnWeekRender(item.availability)">
                                                @{{availability}}
                                            </li>
                                        </ul>
                                    </span>
                                </div>
                                <div class="form-_label d-none">
                                    <label for="adresse_depart" class="col-form-label text-md-right col-md-3">{{trans('admin.excursion.columns.adresse_depart')}} </label>
                                    <span class="form-control  cliquable" @click.prevent="editExcursion($event,item.resource_url + '/edit')">@{{item.adresse_depart}}</span>
                                </div>
                                <div class="form-_label d-none">
                                    <label for="adresse_arrive" class="col-form-label text-md-right col-md-3">{{trans('admin.excursion.columns.adresse_arrive')}} </label>
                                    <span class="form-control  cliquable" @click.prevent="editExcursion($event,item.resource_url + '/edit')">@{{item.adresse_arrive}}</span>
                                </div>
                                <div class="form-_label">
                                    <label for="heure_depart" class="col-form-label text-md-right col-md-3">{{trans('admin.excursion.columns.heure_depart')}} </label>
                                    <span class="form-control  cliquable" @click.prevent="editExcursion($event,item.resource_url + '/edit')">@{{item.heure_depart}}</span>
                                </div>
                                <div class="form-_label">
                                    <label for="heure_arrive" class="col-form-label text-md-right col-md-3">{{trans('admin.excursion.columns.heure_arrive')}} </label>
                                    <span class="form-control  cliquable" @click.prevent="editExcursion($event,item.resource_url + '/edit')">@{{item.heure_arrive}}</span>
                                </div>
                                <div class="form-_label">
                                    <label for="description" class="col-form-label text-md-right col-md-3">{{trans('admin.excursion.columns.options_included.title')}} </label>
                                    <span class="form-control  cliquable" @click.prevent="editExcursion($event,item.resource_url + '/edit')">
                                        <ul class="list-in-table">
                                            <li v-if="item.lunch == '1'">
                                                {{ trans('admin.excursion.columns.options_included.lunch') }}
                                            </li>
                                            <li v-if="item.ticket == '1'">
                                                {{ trans('admin.excursion.columns.options_included.ticket') }}
                                            </li>
                                        </ul>
                                    </span>
                                </div>
                                <div class="form-_label" v-if="item.lunch == '1'">
                                    <label for="description" class="col-form-label text-md-right col-md-3">{{trans('admin.excursion.columns.lunch_prestataire')}} </label>
                                    <span class="form-control  cliquable" @click.prevent="editExcursion($event,item.resource_url + '/edit')">
                                        <ul class="list-in-table">
                                            <li v-for="(retaurant,_i_restaurant) in item.lunch_prestataire">
                                                <span>@{{retaurant.name}}</span>
                                            </li>
                                        </ul>
                                    </span>
                                </div>
                                <div class="form-_label" v-if="item.ticket == '1'">
                                    <label for="description" class="col-form-label text-md-right col-md-3">{{trans('admin.excursion.columns.ticket_billeterie')}} </label>
                                    <span class="form-control  cliquable" @click.prevent="editExcursion($event,item.resource_url + '/edit')">
                                        <ul class="list-in-table">
                                            <li v-for="(billeterie,_i_billeterie) in item.ticket_billeterie">
                                                <span>@{{billeterie.titre}}</span>
                                            </li>
                                        </ul>
                                    </span>
                                </div>
                                <div class="form-_label" v-if="item.ticket == '1' && false">
                                    <label for="lieu_depart_id" class="col-form-label text-md-right col-md-3">{{trans('admin.excursion.columns.lieu_depart')}} </label>
                                    <span class="form-control  cliquable" @click.prevent="editExcursion($event,item.resource_url + '/edit')">@{{item.depart.name}}</span>
                                </div>
                                <div class="form-_label" v-if="item.ticket == '1' && false">
                                    <label for="lieu_arrive_id" class="col-form-label text-md-right col-md-3">{{trans('admin.excursion.columns.lieu_arrive')}} </label>
                                    <span class="form-control  cliquable" @click.prevent="editExcursion($event,item.resource_url + '/edit')">@{{item.arrive.name}}</span>
                                </div>
                                <div class="form-_label">
                                    <label for="description" class="col-form-label text-md-right col-md-3">{{trans('admin.excursion.columns.description')}} </label>
                                    <textarea class="form-control  cliquable" readonly @click.prevent="editExcursion($event,item.resource_url + '/edit')">@{{item.description}}</textarea>
                                </div>
                                <div class="form-_label">
                                    <label for="description" class="col-form-label text-md-right col-md-3">{{trans('admin.excursion.columns.calendar')}} </label>
                                    <span class="form-control  cliquable" style="padding: 0 !important; border-width: 0 !important;">
                                        <v-calendar :attributes="calendaralldates" is-expanded />
                                    </span>
                                </div>
                                <div class="form-_label">
                                    <label for="name" class="col-form-label text-md-right col-md-3">{{trans('admin.excursion.columns.fond_image')}} </label>
                                    <span class="form-control  cliquable" style="padding-right: 0.75rem !important;padding-left: 0.75rem !important;" @click.prevent="editExcursion($event,item.resource_url + '/edit')">
                                        <span v-if="item.fond_image" style="display: inline-block; width: calc((50% + 0.5em) - 0.75rem); margin: 0;padding: 5px;">
                                            <img :src="$isBase64(item.fond_image)?item.fond_image:`${urlasset}/${item.fond_image}`" alt="" style="width: 100%;height: auto; margin:auto">
                                        </span>
                                        <span v-if="!item.fond_image" style="display: flex; align-items: center;"><i class="image-no-found"></i>@{{$dictionnaire.no_image_avaible}}</span>
                                    </span>
                                </div>
                                <div class="form-_label">
                                    <label for="name" class="col-form-label text-md-right col-md-3">{{trans('admin.excursion.columns.card')}} </label>
                                    <span class="form-control  cliquable" style="padding-right: 0.75rem !important;padding-left: 0.75rem !important;" @click.prevent="editExcursion($event,item.resource_url + '/edit')">
                                        <span v-if="item.card" style="display: inline-block; width: calc((50% + 0.5em) - 0.75rem); margin: 0;padding: 5px;">
                                            <img :src="$isBase64(item.card)?item.card:`${urlasset}/${item.card}`" alt="" style="width: 100%;height: auto; margin:auto">
                                        </span>
                                        <span v-if="!item.card" style="display: flex; align-items: center;"><i class="image-no-found"></i>@{{$dictionnaire.no_image_avaible}}</span>
                                    </span>
                                </div>
                                <div class="form-_label">
                                    <label for="name" class="col-form-label text-md-right col-md-3">{{trans('admin.excursion.columns.image')}} </label>
                                    <span class="form-control  cliquable" style="padding-right: 0.75rem !important;padding-left: 0.75rem !important;" @click.prevent="editExcursion($event,item.resource_url + '/edit')">
                                        <span v-for="(_image, _index_img) in item.image" style="display: inline-block; width: calc((50% + 0.5em) - 0.75rem); margin: 0;padding: 5px;">
                                            <img :src="$isBase64(_image.name)?_image.name:`${urlasset}/${_image.name}`" alt="" style="width: 100%;height: auto; margin:auto">
                                        </span>
                                        <span v-if="item.image.length == 0" style="display: flex; align-items: center;"><i class="image-no-found"></i>@{{$dictionnaire.no_image_avaible}}</span>
                                    </span>
                                </div>
                            </div>
                            <div class="col-12" v-if="pagination_[1]" v-for="(item,index) in data_detail" :key="item.id">
                                <div class="form-_label">
                                    <label for="name" class="col-form-label text-md-right col-md-3">{{trans('admin.prestataire.columns.name')}} </label>
                                    <span class="form-control cliquable" @click.prevent="editPrestataire($event,item.prestataire.resource_url + '/edit')">@{{item.prestataire.name}}</span>
                                </div>
                                <div class="form-_label">
                                    <label for="phone" class="col-form-label text-md-right col-md-3">{{trans('admin.prestataire.columns.phone')}} </label>
                                    <span class="form-control  cliquable" @click.prevent="editPrestataire($event,item.prestataire.resource_url + '/edit')">@{{item.prestataire.phone}}</span>
                                </div>
                                <div class="form-_label">
                                    <label for="email" class="col-form-label text-md-right col-md-3">{{trans('admin.prestataire.columns.email')}} </label>
                                    <span class="form-control  cliquable" @click.prevent="editPrestataire($event,item.prestataire.resource_url + '/edit')">@{{item.prestataire.email}}</span>
                                </div>
                                <div class="form-_label">
                                    <label for="second_email" class="col-form-label text-md-right col-md-3">{{trans('admin.prestataire.columns.second_email')}} </label>
                                    <span class="form-control  cliquable" @click.prevent="editPrestataire($event,item.prestataire.resource_url + '/edit')">@{{item.prestataire.second_email}}</span>
                                </div>
                                <div class="form-_label">
                                    <label for="adresse" class="col-form-label text-md-right col-md-3">{{trans('admin.prestataire.columns.adresse')}} </label>
                                    <span class="form-control  cliquable" @click.prevent="editPrestataire($event,item.prestataire.resource_url + '/edit')">@{{item.prestataire.adresse}}</span>
                                </div>
                                <div class="form-_label">
                                    <label for="adresse" class="col-form-label text-md-right col-md-3">{{trans('admin.prestataire.columns.ville')}} </label>
                                    <span class="form-control  cliquable" @click.prevent="editPrestataire($event,item.prestataire.resource_url + '/edit')">@{{item.prestataire.ville.name}}</span>
                                </div>
                                <div class="form-_label">
                                    <label for="adresse" class="col-form-label text-md-right col-md-3">{{trans('admin.prestataire.columns.pays')}} </label>
                                    <span class="form-control  cliquable" @click.prevent="editPrestataire($event,item.prestataire.resource_url + '/edit')">@{{item.prestataire.ville.pays.nom}}</span>
                                </div>
                                <div class="form-_label">
                                    <label for="name" class="col-form-label text-md-right col-md-3">{{trans('admin.prestataire.columns.logo')}} </label>
                                    <span class="form-control  cliquable" style="padding-right: 0.75rem !important;padding-left: 0.75rem !important;" @click.prevent="editPrestataire($event,item.prestataire.resource_url + '/edit')">
                                        <span v-if="item.prestataire.logo" style="display: inline-block; width: calc((50% + 0.5em) - 0.75rem); margin: 0;padding: 5px;">
                                            <img :src="$isBase64(item.prestataire.logo)?item.prestataire.logo:`${urlasset}/${item.prestataire.logo}`" alt="" style="width: 100px;height: auto; margin:auto">
                                        </span>
                                        <span v-if="!item.prestataire.logo" style="display: flex; align-items: center;"><i class="image-no-found"></i>@{{$dictionnaire.no_image_avaible}}</span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <modal name="edit_excursion" :min-width="320" :scrollable="true" :max-width="1000" height="auto" width="100%" :draggable="false" @opened="myEvent.editExcursion()" :adaptive="true">
            @include('admin.excursion.excursion.edit-excursion')
        </modal>
        <modal name="edit_prestataire" :scrollable="true" :min-width="320" :max-width="1000" height="auto" width="100%" :draggable="true" @opened="myEvent.editPrestataire()" :adaptive="true">
            @include('admin.excursion.excursion.edit-prestataire')
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
</detail-excursion-listing>

@endsection