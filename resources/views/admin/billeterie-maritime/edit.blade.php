<div class="card">

    <div class="card-header">
        <i class="fa fa-pencil"></i>
        <h3>
            {{ trans('admin.billeterie-maritime.actions.edit') }}
        </h3>
        <a class="float-right text-danger" style="cursor:pointer;" @click.prevent="closeModal('edit_billeterie')"><i class="fa fa-times"></i></a>
    </div>

    <div class="card-body">
        <div class="content-_progres">
            <div class="line"></div>
            <div :class="billeterie_form[0]?'progres active':'progres pointer'" @click.prevent="changeFormBilleterie($event,[false,true,true])">1 <span class="title">{{ trans('admin.billeterie-maritime.columns.titre')}}</span> </div>
            <div :class="billeterie_form[1]?'progres active':'progres pointer'" @click.prevent="changeFormBilleterie($event,[true,false,true])">2 <span class="title">{{ trans('admin.billeterie-maritime.columns.tarif')}}</span></div>
            <div :class="billeterie_form[2]?'progres active':'progres pointer'" @click.prevent="changeFormBilleterie($event,[true,true,false])">3 <span class="title">{{ trans('admin.billeterie-maritime.columns.planing_time')}}</span></div>
        </div>
        <form class="form-horizontal form-edit" :class="(billeterie_form[0] || billeterie_form[1])?'_is_show' : '_is_hide'" id="edit-billeterie" method="post" @submit.prevent="storeBilleterie($event,'edit_billeterie')" :action="actionEditBilleterie" novalidate>
            @include('admin.billeterie-maritime.components.form-elements')
            <input type="submit" style="display: none;" ref="submitBilleterie">
        </form>
        <form class="form-horizontal form-create" :class="billeterie_form[2]?'_is_show' : '_is_hide'" id="planing_time" method="post" @submit.prevent="storePlaningTime($event)" :action="url_item_time" novalidate>
            <table class="table table-hover table-listing">
                <thead>
                    <tr>
                        <th>{{trans('admin.billeterie-maritime.columns.heure-debut')}}</th>
                        <th>{{trans('admin.billeterie-maritime.columns.heure-fin')}}</th>
                        <th>{{trans('admin.excursion.columns.availability')}}</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="time of trierPlaningTime(times)">
                        <td v-if="time.debut != null">@{{time.debut | formatTime}}</td>
                        <td v-if="time.debut == null"></td>
                        <td v-if="time.fin != null">@{{time.fin | formatTime}}</td>
                        <td v-if="time.fin == null"></td>
                        <td>
                            <div class="link"></div>
                            <div class="list-week">
                                <span class="list-week-item" v-for="(week ,index) in $dictionnaire.short_week_list">
                                    <input type="checkbox" :checked='$splite(time.availability,",").findIndex(__val => __val == index ) >= 0'> @{{week}}
                                </span>
                            </div>
                        </td>
                        <td>
                            <div class="row">
                                <div class="col-auto">
                                    <button type="button" class="btn btn-sm btn-success" title="{{ trans('admin-base.btn.edit') }}" @click.prevent="editPlaningTime(time)"><i class="fa fa-edit"></i></button>
                                </div>
                                <div class="col-auto">
                                    <button type="button" class="btn btn-sm btn-danger" title="{{ trans('admin-base.btn.delete') }}" @click.prevent="deletePlaningTime(time.resource_url)"><i class="fa fa-trash-o"></i></button>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr style="border: 2px solid #1a91bd;" :class="(has_create_time == true || has_edit_time == true)?'':'d-none'">
                        <td>
                            <div class="form-group" style="margin-bottom: 0 !important;">
                                <input type="time" name="debut" class="form-control">
                            </div>
                        </td>
                        <td>
                            <div class="form-group" style="margin-bottom: 0 !important;">
                                <input type="time" name="fin" class="form-control">
                            </div>
                        </td>
                        <td>
                            <div class="list-week" id="billeterie-list-week">
                                <span class="list-week-item" v-for="(week ,index) in $dictionnaire.short_week_list">
                                    <input type="checkbox" :data-value="index" :checked='weeksAvailability.length && weeksAvailability.findIndex(_val => _val == index ) >= 0' @change="changeWeekAvailableDate"> @{{week}}
                                </span>
                            </div>
                        </td>
                        <td>
                            <div class="row">
                                <div class="col-auto">
                                    <div class="form-group" style="margin-bottom: 0 !important;" v-if="has_create_time==true">
                                        <input type="submit" style="background-color: #1a91bd; border: none; border-radius: 5px; color: white;padding: 5px 15px;" value="{{trans('admin-base.btn.create')}}">
                                    </div>
                                    <div class="form-group" style="margin-bottom: 0 !important;" v-if="has_edit_time==true">
                                        <input type="submit" style="background-color: #1a91bd; border: none; border-radius: 5px; color: white;padding: 5px 15px;" value="{{trans('admin-base.btn.save')}}">
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <button type="button" class="btn btn-sm btn-danger" @click.prevent="has_edit_time=false;has_create_time=false;"><i class="fa fa-times"></i></button>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4" style="margin: 0 0 0 auto;" v-if="has_create_time == false && has_edit_time == false">
                            <div class="form-group" style="margin-bottom: 0 !important;">
                                <input type="button" style="background-color: #1a91bd; border: none; border-radius: 5px; color: white;padding: 5px 15px;" value="{{trans('admin-base.btn.new')}}" @click.prevent="createPlaningTime">
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>


    <div class="card-footer" v-if="billeterie_form[0]">
        <button type="button" class="btn btn-primary" @click.prevent="changeFormBilleterie($event,[true,false,true])">
            <i class="fa fa-arrow-circle-right"></i>
            {{ trans('admin-base.btn.next') }}
        </button>
    </div>
    <div class="card-footer" v-if="billeterie_form[1]">
        <button type="button" class="btn btn-primary" @click.prevent="$refs.submitBilleterie.click()">
            <i class="fa fa-arrow-circle-right"></i>
            {{ trans('admin-base.btn.next') }}
        </button>
    </div>
    <div class="card-footer" v-if="billeterie_form[2]">
        <button type="button" class="btn btn-primary" @click.prevent="$modal.hide('edit_billeterie')">
            {{ trans('admin-base.btn.exit') }}
        </button>
    </div>
</div>