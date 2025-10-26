<div class="form-group row align-items-center">
    <label for="nuit" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.saison.columns.titre') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" required class="form-control" name="titre" placeholder="{{ trans('admin.saison.columns.titre') }}">
    </div>
</div>
<div class="form-group row align-items-center no-vc-popover-caret no-year">
    <label for="jour" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.saison.columns.debut') }}</label>
    <v-date-picker class="custom-css-calendar" :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'" :value="debut_saison" :popover="{ placement: $screens({ default: 'bottom', md: 'left-start' })}" :min-date="min_date" :max-date="max_date">
        <template v-slot="{ inputValue, inputEvents}">
            <input class="bg-white border px-2 py-1 rounded outline-0" name="debut" type="text" required :value="dateToString(inputValue)" v-on="inputEvents" style="display: none;" />
            <input class="bg-white border px-2 py-1 rounded outline-0 w-100" name="debut_format" placeholder="jj/mm" required :value="formatSaison(inputValue)" v-on="inputEvents" />
        </template>
        <template v-slot:header-title="{title}">
            <div>@{{$splite(title,' ')[0]}}</div>
        </template>
    </v-date-picker>
</div>

<div class="form-group row align-items-center no-vc-popover-caret no-year">
    <label for="jour" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.saison.columns.fin') }}</label>
    <v-date-picker class="custom-css-calendar" :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'" :value="fin_saison" :popover="{ placement: $screens({ default: 'bottom', md: 'left-start' })}" :min-date="min_date" :max-date="max_date">
        <template v-slot="{ inputValue, inputEvents}">
            <input class="bg-white border px-2 py-1 rounded outline-0" name="fin" type="text" required :value="dateToString(inputValue)" v-on="inputEvents" style="display: none;" />
            <input class="bg-white border px-2 py-1 rounded outline-0 w-100" name="fin_format" placeholder="jj/mm" required :value="formatSaison(inputValue)" v-on="inputEvents" />
        </template>
        <template v-slot:header-title="{title}">
            <div>@{{$splite(title,' ')[0]}}</div>
        </template>
    </v-date-picker>
</div>
<div class="form-group row align-items-center">
    <label for="description" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.chambre.columns.description') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <textarea class="form-control" name="description" cols="30" rows="3" placeholder="{{ trans('admin.chambre.columns.description') }}"></textarea>
    </div>
</div>

<input type="text" name="model_saison" value="hebergement" style="display: none;">
<!--@{{$dictionnaire.short_month[$parseDate(debut_saison).getMonth()]}}-->