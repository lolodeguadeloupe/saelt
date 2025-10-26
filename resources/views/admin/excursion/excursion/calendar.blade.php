<div class="card" style="max-width: max-content;">
    <form class="form-horizontal form-create" id="calendar" method="post" @submit.prevent="addCalendar($event)" action="{{url('admin/event-date-heures')}}" novalidate>

        <div class="card-header">
            <i class="fa fa-calendar"></i>
            <h3>{{ trans('admin.event-date-heure.actions.index') }}</h3>
            <a class="float-right text-danger" style="cursor:pointer;" @click.prevent="closeModal('calendar')"><i class="fa fa-times"></i></a>
        </div>

        <div class="card-body">

            <div style="width: 100%;height: 100%;display: grid; grid-template-columns: 40% 60%;">
                <div style="display: flex;align-items: center;flex-direction: column;">
                    <div style="margin: auto; width: max-content; height: max-content;position:relative;margin-bottom: auto !important;" class="form-group">
                    <div style="width: 100%;display: flex;cursor: pointer;padding:5px">
                        <span :class="calendar_btn_action[0]?'active-item-calendar calendar-item-tab':'calendar-item-tab'" @click.prevent="changeCalendarBtn([false,true])" style="margin-right: 5px;" >{{ trans('admin.event-date-heure.actions.btn_edit') }}</span>
                        <span :class="calendar_btn_action[1]?'active-item-calendar calendar-item-tab':'calendar-item-tab'" @click.prevent="changeCalendarBtn([true,false])" style="margin-left:5px;">{{ trans('admin.event-date-heure.actions.btn_add') }}</span>
                    </div>
                        <div>
                            <v-calendar :attributes="attributes" :min-date='new Date()' @dayclick="onDayClick"/>
                        </div>
                        <input type="text" required name="date" :value="modelcalendardates" style="display: none;">

                    </div>
                </div>
                <div style=" padding: 15px 30px;" class="calendar-form">

                    <div class="form-group row align-items-center">
                        <label for="status" class="col-form-label text-md-right col-12" style="text-align: left !important;">{{ trans('admin.event-date-heure.columns.status') }}</label>
                        <div class="relative col-12" style="display: flex;">
                            <div class="form-control-_chekbox"><input type="radio" class="form-control" name="status" :value="'1'" checked><label for="stauts_active">{{trans('admin.event-date-heure.columns.active')}}</label></div>
                            <div class="form-control-_chekbox"><input type="radio" class="form-control" name="status" :value="'0'"><label style="margin-bottom: 0; padding-left: 10px" for="stauts_desactive">{{trans('admin.event-date-heure.columns.desactive')}}</label></div>
                        </div>
                    </div>

                    <div class="form-group row align-items-center">
                        <label for="time_start" class="col-form-label text-md-right col-12" style="text-align: left !important;">{{ trans('admin.event-date-heure.columns.time_start') }} *</label>
                        <div class="col-12">
                            <input type="time" required name="time_start" value="00:00" class="form-control">
                        </div>
                    </div>


                    <div class="form-group row align-items-center">
                        <label for="time_end" class="col-form-label text-md-right col-12" style="text-align: left !important;">{{ trans('admin.event-date-heure.columns.time_end') }} *</label>
                        <div class="col-12">
                            <input type="time" required name="time_end" value="23:00" class="form-control">
                        </div>
                    </div>

                    <div class="form-group row align-items-center">
                        <label for="description" class="col-form-label text-md-right col-12" style="text-align: left !important;">{{ trans('admin.event-date-heure.columns.description') }} *</label>
                        <div class="col-12">
                            <textarea required name="description" id="" cols="30" rows="2" class="form-control"></textarea>
                        </div>
                    </div>

                    <div class="form-group row align-items-center">
                        <label for="description" class="col-form-label text-md-right col-12" style="text-align: left !important;">{{ trans('admin.event-date-heure.columns.style') }} </label>
                        <div class="col-12" style="display: grid; grid-template-columns: 40% 60%;">
                            <div style="display: flex; align-items: center;">
                                <input type="color" v-model="style_color_calendar" name="color" style="width: 100%; padding: 0;">
                            </div>
                            <div style="display: flex; align-items: center;flex-direction: column;">
                                <div style="position: relative;">
                                    <input type="radio" name="ui_event" :value="'bar'" checked class="style-calendar">
                                    <span class="style-calendar-line" :style="'background-color:'+style_color_calendar"></span>
                                </div>
                                <div style="position:relative;">
                                    <input type="radio" name="ui_event" :value="'highlight'" class="style-calendar">
                                    <span class="style-calendar-circle" :style="'border-color:'+style_color_calendar"></span>
                                </div>
                                <div style="position:relative;">
                                    <input type="radio" name="ui_event" :value="'dot'" class="style-calendar">
                                    <span class="style-calendar-point" :style="'background-color:'+style_color_calendar"></span>
                                </div>
                            </div>

                        </div>
                    </div>

                    <input type="text" style="display: none;" name="model_event">

                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-download"></i>
                        {{ trans('admin-base.btn.save') }}
                    </button>

                </div>
            </div>

        </div>

    </form>
</div>