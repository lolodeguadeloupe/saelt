<div style="width: 100%;" id="condition-transport-loading" :class="condition_vol?'_is_show':'_is_hide'">
    <div id="condition-transport-loading-create" style="position: absolute;width: 100%;height: 100%;top: 0;left: 0;display: none;align-items: center;background-color: transparent;z-index:13;">
        <i class="fa fa-spinner" style="font-size: 50px;margin: auto;-webkit-animation: fa-spin 2s infinite linear;animation: fa-spin 2s infinite linear;color: #0da3d8;"></i>
    </div>

    <div class="form-group row align-items-center">
        <label for="allotement_id" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.hebergement-vol.columns.allotement_id') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
            <select required class="form-control" name="allotement_id" @change="changeAllotementVol($event)">
                <option value="">-- sélectionner l'allotement --</option>
                <option v-for="allotement in allotements" :value="allotement.id">@{{ allotement.titre }}</option>
            </select>
            <a data-range="2" data-parent="hebergement" style="position: absolute; left: 100%; top: 0; width:fit-content;height: 100%;display: flex;align-items: center;" class="h-style-none" :href="urlallotement"><i class="fa fa-arrow-circle-right pointer" style="font-size: 20px;"></i>
                <p style="display: none;">{{trans('admin.allotement.title')}}</p>
            </a>
        </div>
    </div>

    <div class="form-group row align-items-center">
        <label for="depart" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.hebergement-vol.columns.depart') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
            <div class="form-control display-grid-date-heure">
                <input type="date" required name="depart" placeholder="{{ trans('admin.hebergement-vol.columns.depart') }}">
                <span>{{ trans('admin.hebergement-vol.columns.heure') }} </span>
                <input type="time" required name="heure_depart">
            </div>
        </div>
    </div>


    <div class="form-group row align-items-center">
        <label for="lieu_depart" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.hebergement-vol.columns.lieu_depart') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
            <input type="text" required class="form-control" readonly name="lieu_depart" placeholder="{{ trans('admin.hebergement-vol.columns.lieu_depart') }}">
        </div>
    </div>


    <div class="form-group row align-items-center">
        <label for="arrive" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.hebergement-vol.columns.arrive') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
            <div class="form-control display-grid-date-heure">
                <input type="date" required name="arrive" placeholder="{{ trans('admin.hebergement-vol.columns.arrive') }}">
                <span>{{ trans('admin.hebergement-vol.columns.heure') }} </span>
                <input type="time" required name="heure_arrive">
            </div>
        </div>
    </div>


    <div class="form-group row align-items-center">
        <label for="lieu_arrive" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.hebergement-vol.columns.lieu_arrive') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
            <input type="text" required readonly class="form-control" name="lieu_arrive" placeholder="{{ trans('admin.hebergement-vol.columns.lieu_arrive') }}">
        </div>
    </div>

    <div class="form-group row align-items-center">
        <label for="nombre_jour" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.hebergement-vol.columns.nombre_jour') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
            <input type="number" min="0" required class="form-control" name="nombre_jour" placeholder="{{ trans('admin.hebergement-vol.columns.nombre_jour') }}">
        </div>
    </div>

    <div class="form-group row align-items-center">
        <label for="nombre_nuit" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.hebergement-vol.columns.nombre_nuit') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
            <input type="number" min="0" required class="form-control" name="nombre_nuit" placeholder="{{ trans('admin.hebergement-vol.columns.nombre_nuit') }}">
        </div>
    </div>
</div>

<input type="text" style="display: none;" class="form-control" name="tarif_id" placeholder="{{ trans('admin.hebergement-vol.columns.lien_arrive') }}">