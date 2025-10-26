<div style="width: 100%; height: 100%; align-items: center;background-color:#e4e5e68c; padding: 15px;">
    <div class="form-group row align-items-center">
        <label for="lieu_depart" class="col-form-label text-md-lelft required col-md-3">{{ trans('admin.excursion.columns.lieu_depart') }}</label>
        <div class="col-md-9">
            <input type="text" name="lieu_depart_id" style="display: none;">
            <input type="text" required class="form-control" name="lieu_depart" placeholder="{{ trans('admin.excursion.columns.lieu_depart') }}" v-autocompletion="autocompletePort" :action="urlbase+'/admin/autocompletion/service-port'" :autokey="'id'" :label="'name'" :inputkey="'lieu_depart_id'" :inputlabel="'lieu_depart'">
        </div>
    </div>

    <div class="form-group row align-items-center">
        <label for="lieu_arrive" class="col-form-label text-md-left required col-md-3">{{ trans('admin.excursion.columns.lieu_arrive') }}</label>
        <div class="col-md-9">
            <input type="text" name="lieu_arrive_id" style="display: none;">
            <input type="text" required class="form-control" name="lieu_arrive" placeholder="{{ trans('admin.excursion.columns.lieu_arrive') }}" v-autocompletion="autocompletePort" :action="urlbase+'/admin/autocompletion/service-port'" :autokey="'id'" :label="'name'" :inputkey="'lieu_arrive_id'" :inputlabel="'lieu_arrive'">
        </div>
    </div>
</div>

<div style="width: 100%; height: 100%; align-items: center; background-color:#e4e5e68c; padding: 15px;margin-top:5px">

    <div class="row">
        <div class="col-md pb-3">
            <h5 class="text-center">{{ trans('admin.compagnie-liaison-excursion.tous_compagnie') }}</h5>
        </div>
    </div>
    <div style="margin-left: 20px; margin-right: 20px; width: calc(33.333% - 40px); display: inline-block;" v-for="(compagnie, _index) in compagnies">
        <div class="multiple-option-checkbox" style="position: relative; height: 28px;">
            <input type="checkbox" :name="'compagnie_'+compagnie.id" :value="compagnie.id">
            <label :class="compagnie.logo?'logo':''" for="checkbox" style="height: 100%;">
                <img v-if="compagnie.logo" :src="$isBase64(compagnie.logo)?compagnie.logo:`${urlasset}/${compagnie.logo}`" :alt="'logo'+compagnie.nom" style="height: 100%;">
                @{{compagnie.nom}}
            </label>
        </div>
    </div>
    <div style="margin-left: 47px;">
        <div v-if="compagnies.length == 0">
            <a data-parent="excursion" data-range="2" :href="urlbase+'/admin/maritime-compagnie-transports?transport=Maritime'"><i class="fa fa-plus"></i> {{trans('admin.compagnie-transport.actions.create')}}</a>
        </div>
    </div>
</div>

<input type="text" name="excursion_id" :value="excursion.id" style="display: none;">