@extends('admin.customer-layout.layout.default')

@section('title', trans('admin.vehicule-location.actions.index'))

@section('body')
<detail-vehicule-location-listing :detail="{{$data}}" :datacalendar="{{$vehiculeLocation->calendar->toJson()}}" :url="'{{ $vehiculeLocation->resource_url }}'" :action="'{{url('admin/vehicule-locations') }}'" :urlbase="'{{base_url('')}}'" :urlasset="'{{asset('')}}'" :urlcalendar="'{{url('admin/event-date-heures')}}'" inline-template>
    <div style="display: contents;position:relative">
        <div class="row">
            @include('admin.location-vehicule.view-header.header')
        </div>
        <div class="row has--child-nav">
            <div class="col-2 child-_nav" style="height: auto !important;">
                @include('admin.location-vehicule.view-header.nav-child')
            </div>
            <div class="col-10 content-_nav">
                <div class="card position-relative">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i>
                        <h3>{{ trans('admin.vehicule-location.actions.index') }} / {{ trans('admin.prestataire.actions.index') }}</h3>
                    </div>
                    <div class="card-body" v-cloak style="position: relative;" v-for="(item,index) in data_detail" :key="item.id">
                        <div class="my--tab">
                            <div class="item--tab" :class="pagination_[0]?'active':''" @click.prevent="nextPage([true,false,false])"><span>{{ trans('admin.vehicule-location.actions.index') }} </span> <i v-if="pagination_[0]" class="fa fa-pencil edit" @click.prevent="editVehicule($event,item.resource_url + '/edit')"></i> </div>
                            <div class="item--tab" :class="pagination_[1]?'active':''" @click.prevent="nextPage([false,true,false])"><span>{{ trans('admin.vehicule-location-info-tech.actions.index') }} </span> <i v-if="pagination_[1]" class="fa fa-pencil edit" @click.prevent="editInfoTech($event,item.info_tech.resource_url + '/edit')"></i> </div>
                            <div class="item--tab" :class="pagination_[2]?'active':''" @click.prevent="nextPage([false,false,true])"><span>{{ trans('admin.prestataire.actions.index') }}</span> <i v-if="pagination_[2]" class="fa fa-pencil edit" @click.prevent="editPrestataire($event,item.prestataire.resource_url + '/edit')"></i> </div>
                        </div>
                        <div class="row">
                            <div class="col-12" v-if="pagination_[0]">
                                <div class="form-_label">
                                    <label for="type" class="col-form-label text-md-right col-md-3">{{trans('admin.vehicule-location.columns.status')}} </label>
                                    <span class="form-control  cliquable" @click.prevent="editVehicule($event,item.resource_url + '/edit')">
                                        <div v-if="item.status == '1'"> {{trans('admin.vehicule-location.columns.ouverte')}}</div>
                                        <div v-if="item.status == '0'"> {{trans('admin.vehicule-location.columns.fermet')}}</div>
                                    </span>
                                </div>

                                <div class="form-_label">
                                    <label for="title" class="col-form-label text-md-right col-md-3">{{trans('admin.vehicule-location.columns.titre')}} </label>
                                    <span class="form-control cliquable" @click.prevent="editVehicule($event,item.resource_url + '/edit')">@{{item.titre}}</span>
                                </div>

                                <div class="form-_label">
                                    <label for="immatriculation" class="col-form-label text-md-right col-md-3">{{trans('admin.vehicule-location.columns.immatriculation')}} </label>
                                    <span class="form-control cliquable" @click.prevent="editVehicule($event,item.resource_url + '/edit')">@{{item.immatriculation}}</span>
                                </div>
                                <div class="form-_label">
                                    <label for="marque" class="col-form-label text-md-right col-md-3">{{trans('admin.vehicule-location.columns.marque')}} </label>
                                    <span class="form-control cliquable" @click.prevent="editVehicule($event,item.resource_url + '/edit')">@{{item.marque.titre}}</span>
                                </div>
                                <div class="form-_label">
                                    <label for="modele" class="col-form-label text-md-right col-md-3">{{trans('admin.vehicule-location.columns.modele')}} </label>
                                    <span class="form-control cliquable" @click.prevent="editVehicule($event,item.resource_url + '/edit')">@{{item.modele.titre}}</span>
                                </div>

                                <div class="form-_label">
                                    <label for="categorie_vehicule_id" class="col-form-label text-md-right col-md-3">{{trans('admin.vehicule-location.columns.categorie_vehicule_id')}} </label>
                                    <span class="form-control cliquable" @click.prevent="editVehicule($event,item.resource_url + '/edit')">@{{item.categorie.titre}}</span>
                                </div>

                                <div class="form-_label">
                                    <label for="duration_min" class="col-form-label text-md-right col-md-3">{{trans('admin.vehicule-location.columns.duration_min')}} </label>
                                    <span class="form-control cliquable" @click.prevent="editVehicule($event,item.resource_url + '/edit')">@{{item.duration_min}}</span>
                                </div>

                                <div class="form-_label">
                                    <label for="franchise" class="col-form-label text-md-right col-md-3">{{trans('admin.vehicule-location.columns.franchise')}} </label>
                                    <span class="form-control cliquable" @click.prevent="editVehicule($event,item.resource_url + '/edit')">@{{item.franchise}}</span>
                                </div>

                                <div class="form-_label">
                                    <label for="franchise_non_rachatable" class="col-form-label text-md-right col-md-3">{{trans('admin.vehicule-location.columns.franchise_non_rachatable')}} </label>
                                    <span class="form-control cliquable" @click.prevent="editVehicule($event,item.resource_url + '/edit')">@{{item.franchise_non_rachatable}}</span>
                                </div>

                                <div class="form-_label">
                                    <label for="caution" class="col-form-label text-md-right col-md-3">{{trans('admin.vehicule-location.columns.caution')}} </label>
                                    <span class="form-control cliquable" @click.prevent="editVehicule($event,item.resource_url + '/edit')">@{{item.caution}}</span>
                                </div>

                                <div class="form-_label">
                                    <label for="description" class="col-form-label text-md-right col-md-3">{{trans('admin.vehicule-location.columns.description')}} </label>
                                    <span class="form-control  cliquable" @click.prevent="editVehicule($event,item.resource_url + '/edit')" v-parsehtml="item.description"></span>
                                </div>
                                <div class="form-_label">
                                    <label for="description" class="col-form-label text-md-right col-md-3">{{trans('admin.vehicule-location.columns.calendar')}} </label>
                                    <span class="form-control  cliquable" style="padding: 0 !important; border-width: 0 !important;">
                                        <v-calendar :attributes="calendaralldates" is-expanded />
                                    </span>
                                </div>

                                <div class="form-_label">
                                    <label for="name" class="col-form-label text-md-right col-md-3">{{trans('admin.vehicule-location.columns.image')}} </label>
                                    <span class="form-control  cliquable" style="padding-right: 0.75rem !important;padding-left: 0.75rem !important;" @click.prevent="editHeb($event,item.resource_url + '/edit')">
                                        <span v-for="(_image, _index_img) in item.image" style="display: inline-block; width: calc((50% + 0.5em) - 0.75rem); margin: 0;padding: 5px;">
                                            <img :src="$isBase64(_image.name)?_image.name:`${urlasset}/${_image.name}`" alt="image" style="width: 100%;height: auto; margin:auto">
                                        </span>
                                        <span v-if="item.image.length == 0" style="display: flex; align-items: center;"><i class="image-no-found"></i>@{{$dictionnaire.no_image_avaible}}</span>
                                    </span>
                                </div>
                            </div>
                            <div class="col-12" v-if="pagination_[1]">

                                <div class="form-_label">
                                    <label for="nombre_place" class="col-form-label text-md-right col-md-3">{{trans('admin.vehicule-location-info-tech.columns.nombre_place')}} </label>
                                    <span class="form-control cliquable" @click.prevent="editInfoTech($event,item.info_tech.resource_url + '/edit')">@{{item.info_tech.nombre_place}}</span>
                                </div>

                                <div class="form-_label">
                                    <label for="nombre_porte" class="col-form-label text-md-right col-md-3">{{trans('admin.vehicule-location-info-tech.columns.nombre_porte')}} </label>
                                    <span class="form-control cliquable" @click.prevent="editInfoTech($event,item.info_tech.resource_url + '/edit')">@{{item.info_tech.nombre_porte}}</span>
                                </div>

                                <div class="form-_label">
                                    <label for="type_carburant" class="col-form-label text-md-right col-md-3">{{trans('admin.vehicule-location-info-tech.columns.type_carburant')}} </label>
                                    <span class="form-control cliquable" @click.prevent="editInfoTech($event,item.info_tech.resource_url + '/edit')">@{{item.info_tech.type_carburant}}</span>
                                </div>

                                <div class="form-_label">
                                    <label for="nombre_vitesse" class="col-form-label text-md-right col-md-3">{{trans('admin.vehicule-location-info-tech.columns.nombre_vitesse')}} </label>
                                    <span class="form-control cliquable" @click.prevent="editInfoTech($event,item.info_tech.resource_url + '/edit')">@{{item.info_tech.nombre_vitesse}}</span>
                                </div>

                                <div class="form-_label">
                                    <label for="vitesse_maxi" class="col-form-label text-md-right col-md-3">{{trans('admin.vehicule-location-info-tech.columns.vitesse_maxi')}} </label>
                                    <span class="form-control cliquable" @click.prevent="editInfoTech($event,item.info_tech.resource_url + '/edit')">@{{item.info_tech.vitesse_maxi}}</span>
                                    <span style="position: absolute; right: 25px; top: 0; width:auto; height: 100%;display: flex;align-items: center; font-weight: 500; font-size: 18px;">Km/h</span>
                                </div>

                                <div class="form-_label">
                                    <label for="kilometrage" class="col-form-label text-md-right col-md-3">{{trans('admin.vehicule-location-info-tech.columns.kilometrage')}} </label>
                                    <span class="form-control cliquable" @click.prevent="editInfoTech($event,item.info_tech.resource_url + '/edit')">@{{item.info_tech.kilometrage}}</span>
                                    <span style="position: absolute; right: 25px; top: 0; width:auto; height: 100%;display: flex;align-items: center; font-weight: 500; font-size: 18px;">Km</span>
                                </div>

                                <div class="form-_label">
                                    <label for="boite_vitesse" class="col-form-label text-md-right col-md-3">{{trans('admin.vehicule-location-info-tech.columns.boite_vitesse')}} </label>
                                    <span class="form-control cliquable" @click.prevent="editInfoTech($event,item.info_tech.resource_url + '/edit')">@{{item.info_tech.boite_vitesse}}</span>
                                </div>

                                <div class="form-_label">
                                    <label for="fiche_technique" class="col-form-label text-md-right col-md-3">{{trans('admin.vehicule-location-info-tech.columns.fiche_technique')}} </label>
                                    <span class="form-control  cliquable" style="padding-right: 0.75rem !important;padding-left: 0.75rem !important;" @click.prevent="editInfoTech($event,item.info_tech.resource_url + '/edit')">
                                        <span v-if="item.info_tech.fiche_technique" style="display: inline-block; width: 100%; margin: 0;padding: 5px;">
                                            <embed :src="$isBase64(item.info_tech.fiche_technique)?item.info_tech.fiche_technique:`${urlasset}/${item.info_tech.fiche_technique}`" alt="File" style="height: 100%;width: 100%;">
                                        </span>
                                        <span v-if="!item.info_tech.fiche_technique" style="display: flex; align-items: center;"><i class="image-no-found"></i>@{{$dictionnaire.no_file_avaible}}</span>
                                    </span>
                                </div>
                            </div>
                            <div class="col-12" v-if="pagination_[2]" v-for="(item,index) in data_detail" :key="item.id">
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
                                    <label for="ville" class="col-form-label text-md-right col-md-3">{{trans('admin.prestataire.columns.ville')}} </label>
                                    <span class="form-control  cliquable" @click.prevent="editPrestataire($event,item.prestataire.resource_url + '/edit')">@{{item.prestataire.ville.name}}</span>
                                </div>
                                <div class="form-_label">
                                    <label for="pays" class="col-form-label text-md-right col-md-3">{{trans('admin.prestataire.columns.pays')}} </label>
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
        <modal name="edit_vehicule" :min-width="320" :scrollable="true" :max-width="1000" height="auto" width="100%" :draggable="false" @opened="myEvent.editVehicule()" :adaptive="true">
            @include('admin.location-vehicule.vehicule-location.edit-vehicule')
        </modal>
        <modal name="edit_vehicule_info_tech" :min-width="320" :scrollable="true" :max-width="1000" height="auto" width="100%" :draggable="false" @opened="myEvent.editInfoTech()" :adaptive="true">
            @include('admin.location-vehicule.vehicule-location.edit-info-tech')
        </modal>
        <modal name="edit_prestataire" :scrollable="true" :min-width="320" :max-width="1000" height="auto" width="100%" :draggable="true" @opened="myEvent.editPrestataire()" :adaptive="true">
            @include('admin.location-vehicule.vehicule-location.edit-prestataire')
        </modal>
        <modal name="create_prestataire" :scrollable="true" :min-width="320" :max-width="1000" height="auto" width="100%" :draggable="true" :adaptive="true">
            @include('admin.location-vehicule.vehicule-location.create-prestataire')
        </modal>
        <modal name="create_ville" :scrollable="true" :min-width="320" :max-width="600" height="auto" width="100%" :draggable="true" :adaptive="true">
            @include('admin.location-vehicule.vehicule-location.ville')
        </modal>

        <modal name="create_pays" :scrollable="true" :min-width="320" :max-width="500" height="auto" width="100%" :draggable="true" :adaptive="true">
            @include('admin.location-vehicule.vehicule-location.pays')
        </modal>
        <modal name="calendar" :class="'min-width'" :click-to-close="false" :scrollable="true" :min-width="320" :max-width="1000" height="auto" width="100%" :draggable="true" :adaptive="true">
            @include('admin.location-vehicule.vehicule-location.calendar')
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
</detail-vehicule-location-listing>

@endsection