<div class="form-group row align-items-center">
    <label for="title" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.excursion.columns.title') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" required class="form-control" name="title" placeholder="{{ trans('admin.excursion.columns.title') }}">
    </div>
</div>

<div class="form-group row align-items-center">
    <label for="duration" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.excursion.columns.duration') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <select required class="form-control" name="duration">
            <option v-for="duree in ['Journée', 'Demi-journée']" :value="duree">@{{ duree }}</option>
        </select>
    </div>
</div>

<div class="form-group row align-items-center d-none">
    <label for="adresse_depart" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.excursion.columns.adresse_depart') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" class="form-control" name="adresse_depart" placeholder="{{ trans('admin.excursion.columns.adresse_depart') }}">
    </div>
</div>

<div class="form-group row align-items-center d-none">
    <label for="adresse_arrive" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.excursion.columns.adresse_arrive') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" class="form-control" name="adresse_arrive" placeholder="{{ trans('admin.excursion.columns.adresse_arrive') }}">
    </div>
</div>

<div class="form-group row align-items-center">
    <label for="heure_depart" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.excursion.columns.heure_depart') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="time" required class="form-control" name="heure_depart" placeholder="{{ trans('admin.excursion.columns.heure_depart') }}">
    </div>
</div>


<div class="form-group row align-items-center">
    <label for="heure_arrive" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.excursion.columns.heure_arrive') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="time" class="form-control" name="heure_arrive" placeholder="{{ trans('admin.excursion.columns.heure_arrive') }}">
    </div>
</div>

<div class="form-group row align-items-center">
    <label class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.excursion.columns.availability') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <div class="list-week" id="excursion-list-week">
            <span class="list-week-item" v-for="(week ,index) in $dictionnaire.week_list">
                <input type="checkbox" :data-value="index" @click="changeWeekAvailableDate"> @{{week}}
            </span>
        </div>
        <input type="text" style="display: none;" required class="form-control" name="availability" :value="availability" placeholder="{{ trans('admin.excursion.columns.availability') }}">
    </div>
</div>

<div class="form-group row align-items-center">
    <label for="participant_min" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.excursion.columns.participant_min') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="number" required class="form-control" value="0" name="participant_min" placeholder="{{ trans('admin.excursion.columns.participant_min') }}">
    </div>
</div>

<div class="form-group row align-items-center">
    <label for="ville_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.prestataire.columns.ville_id') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'" class="relative">
        <input type="text" name="ville_id" style="display: none;">
        <input type="text" name="ville_name" class="form-control" placeholder="{{ trans('admin.prestataire.columns.ville_id') }}" v-autocompletion="autocompleteVille" :action="urlbase+'/admin/autocompletion/villes'" :autokey="'id'" :label="'name'" :inputkey="'ville_id'" :inputlabel="'ville_name'">
    </div>
</div>

<div class="form-group row align-items-center">
    <label for="ile_id" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.excursion.columns.ile_id') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'" class="relative">
        <input type="text" name="ile_id" style="display: none;">
        <input type="text" name="ile_name" class="form-control" placeholder="{{ trans('admin.excursion.columns.ile_id') }}" v-autocompletion="autocompleteIle" :action="urlbase+'/admin/autocompletion/iles'" :autokey="'id'" :label="'name'" :inputkey="'ile_id'" :inputlabel="'ile_name'">
    </div>
</div>

<div class="form-group row align-items-center">
    <label for="lunch" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.excursion.columns.lunch') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'" class="relative d-flex" @change="checkLunch">
        <div class="form-control-_chekbox"><input type="radio" class="form-control" id="lunch_non" name="lunch" :value="'0'" checked><label for="lunch_non">{{trans('admin.excursion.options.no')}}</label></div>
        <div class="form-control-_chekbox"><input type="radio" class="form-control" id="lunch_oui" name="lunch" :value="'1'"><label style="margin-bottom: 0; padding-left: 10px" for="lunch_oui">{{trans('admin.excursion.options.yes')}}</label></div>
    </div>
</div>

<div class="form-group row align-items-center" v-if="isLunch == true">
    <label for="lunch_prest" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.excursion.columns.lunch_prestataire') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'" class="relative">
        <div class="col-12 px-0 mb-3 border-form-control container-auto-complete-multiple-choix">
            <div class="d-inline-block multiple-select-info" :id="`restaurant-${_item_restaurant.id}`" v-for="(_item_restaurant,_index_restaurant) in all_restaurant">@{{_item_restaurant.name}}<i class="text-danger fa fa-times fa-btn-action" @click.prevent="removeIndexRestaurant($event,_index_restaurant)"></i></div>
            <div class="col px-0"><input type="text" required class="form-control border-0" placeholder="Sélectionner restaurant" v-autocompletion="autocompleteRestaurant" :action="urlbase+'/admin/autocompletion/prestataires'" :autokey="'id'" :label="'name'"></div>
        </div>
        <input type="text" name="lunch_prestataire_id" :value="allRestaurantValue" class="d-none">
    </div>
</div>

<div class="form-group row align-items-center">
    <label for="ticket" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.excursion.columns.ticket') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'" class="relative" style="display: flex;" @change="checkTicket">
        <div class="form-control-_chekbox"><input type="radio" id="ticket_non" class="form-control" name="ticket" :value="'0'" checked><label for="ticket_non">{{trans('admin.excursion.options.no')}}</label></div>
        <div class="form-control-_chekbox"><input type="radio" id="ticket_oui" class="form-control" name="ticket" :value="'1'"><label style="margin-bottom: 0; padding-left: 10px" for="ticket_oui">{{trans('admin.excursion.options.yes')}}</label></div>
    </div>
</div>

<div class="form-group row align-items-center" v-if="isTicket == true">
    <label for="ticket_billet" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.excursion.columns.ticket_billeterie') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'" class="relative">
        <div class="col-12 px-0 mb-3 border-form-control container-auto-complete-multiple-choix">
            <div class="d-inline-block multiple-select-info" :id="`billeterie-${_item_billeterie.id}`" v-for="(_item_billeterie,_index_billeterie) in all_billeterie">@{{_item_billeterie.titre}}<i class="text-danger fa fa-times fa-btn-action" @click.prevent="removeIndexBilleterie($event,_index_billeterie)"></i></div>
            <div class="col px-0"><input type="text" required class="form-control border-0" placeholder="Sélectionner billeterie" v-autocompletion="autocompleteBilleterie" :action="urlbase+'/admin/autocompletion/billeteries'" :autokey="'id'" :label="'titre'"></div>
        </div>
        <input type="text" name="ticket_billeterie_id" :value="allBilleterieValue" class="d-none">
    </div>
</div>

<div class="form-group row align-items-center" v-if="isTicket && false">
    <label for="lieu_depart" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.excursion.columns.lieu_depart') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" name="lieu_depart_id" style="display: none;">
        <input type="text" required class="form-control" name="lieu_depart" placeholder="{{ trans('admin.excursion.columns.lieu_depart') }}" v-autocompletion="autocompletePort" :action="urlbase+'/admin/autocompletion/service-port'" :autokey="'id'" :label="'name'" :inputkey="'lieu_depart_id'" :inputlabel="'lieu_depart'">
    </div>
</div>

<div class="form-group row align-items-center" v-if="isTicket && false">
    <label for="lieu_arrive" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.excursion.columns.lieu_arrive') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" name="lieu_arrive_id" style="display: none;">
        <input type="text" required class="form-control" name="lieu_arrive" placeholder="{{ trans('admin.excursion.columns.lieu_arrive') }}" v-autocompletion="autocompletePort" :action="urlbase+'/admin/autocompletion/service-port'" :autokey="'id'" :label="'name'" :inputkey="'lieu_arrive_id'" :inputlabel="'lieu_arrive'">
    </div>
</div>

<!--
<div class="form-group row align-items-center">
    <label for="description" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.excursion.columns.description') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <textarea class="form-control" name="description" cols="30" rows="3" placeholder="{{ trans('admin.excursion.columns.description') }}"></textarea>
    </div>
</div>
-->

<div class="form-group row align-items-center">
    <label for="description" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.excursion.columns.description') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <textarea class="form-control" name="description" rows="5"></textarea>
    </div>
</div>

<div class="form-group row align-items-center">
    <label for="status" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.excursion.columns.status') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'" class="relative" style="display: flex;">
        <div class="form-control-_chekbox"><input type="radio" class="form-control" name="status" :value="'1'" checked><label for="stauts_active">{{trans('admin.excursion.columns.ouverte')}}</label></div>
        <div class="form-control-_chekbox"><input type="radio" class="form-control" name="status" :value="'0'"><label style="margin-bottom: 0; padding-left: 10px" for="stauts_desactive">{{trans('admin.excursion.columns.fermet')}}</label></div>
    </div>
</div>


<div class="form-group row align-items-center" style="display: none !important;">
    <label for="taxes" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.excursion.columns.taxe') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <multiselect v-model="form.taxes" :options="taxes" label="titre" track-by="id" placeholder="..." :limit="5" :multiple="true">
        </multiselect>
        <div class="form-btn-inline-new" @click.prevent="createTaxe($event,'{{ url('admin/taxes/create')}}')"><i class="fa fa-plus"></i>
            <div class="info--btn">&nbsp;{{trans('admin.taxe.actions.create')}}</div>
        </div>
    </div>
</div>

<div class="form-group row align-items-center">
    <label for="calendar" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.excursion.columns.calendar') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'" class="relative" style="display: flex;">
        <button type="button" class="btn btn-primary" @click.prevent="calendar"><i class="fa fa-calendar"></i>&nbsp;{{ trans('admin.excursion.columns.calendar') }}</button>
    </div>
</div>

<div class="form-group row align-items-center">
    <label for="fond_image" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.excursion.columns.fond_image') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <figure class="figure-form" v-for="(_image,_index) in fond_image" :key="_index+'fond_image'">
            <img :src="$isBase64(_image)?_image:`${urlasset}/${_image}`" alt="" style="height: 100%;width: auto;">
            <span class="my-_btn-remove" @click.prevent="removeFondImage(_index)">
                {{trans('admin.excursion.actions.removeImage')}}
            </span>
            <input type="text" required class="form-control" name="fond_image" style="display: none;" :value="_image">
        </figure>
        <figure v-if="fond_image.length == 0" class="figure-form" @drop.prevent="uploadFondImage($event,true)" @dragover.prevent>
            <span class="my-_btn-add">
                {{trans('admin.excursion.actions.uploadFondImage')}}
                <input type="file" multiple accept=".jpg, .jpeg, .png" @change="uploadFondImage">
            </span>
        </figure>
    </div>
</div>

<div class="form-group row align-items-center">
    <label for="card" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.excursion.columns.card') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <figure class="figure-form" v-for="(_image,_index) in cardImage" :key="_index+'carte'">
            <img :src="$isBase64(_image)?_image:`${urlasset}/${_image}`" alt="" style="height: 100%;width: auto;">
            <span class="my-_btn-remove" @click.prevent="removeCart(_index)">
                {{trans('admin.excursion.actions.removeImage')}}
            </span>
            <input type="text" required class="form-control" name="card" style="display: none;" :value="_image">
        </figure>
        <figure v-if="cardImage.length == 0" class="figure-form" @drop.prevent="uploadCart($event,true)" @dragover.prevent>
            <span class="my-_btn-add">
                {{trans('admin.excursion.actions.uploadCard')}}
                <input type="file" multiple accept=".jpg, .jpeg, .png" @change="uploadCart">
            </span>
        </figure>
    </div>
</div>

<div class="form-group row align-items-center">
    <label for="image" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.excursion.columns.image') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'" style="background-color: white;">
        <figure class="figure-form" v-for="(_image, _index) in imageServeur" :key="_index+'serveur'">
            <img :src="$isBase64(_image.name)?_image.name:`${urlasset}/${_image.name}`" :alt="_image.name" style="height: 100%;width: auto;">
            <span class="my-_btn-remove" @click.prevent="deleteImageServeur($event,_image.resource_url,_index)">
                {{trans('admin.excursion.actions.removeImage')}}
            </span>
        </figure>

        <!--  -->

        <figure class="figure-form" v-for="(_image,_index) in imageUploads" :key="_index+'local'">
            <img :src="$isBase64(_image)?_image:`${urlasset}/${_image}`" alt="" style="height: 100%;width: auto;">
            <span class="my-_btn-remove" @click.prevent="removeUploadImage(_index)">
                {{trans('admin.excursion.actions.removeImage')}}
            </span>
        </figure>
        <figure class="figure-form" @drop.prevent="imageUpload($event,true)" @dragover.prevent>
            <span class="my-_btn-add">
                {{trans('admin.excursion.actions.uploadImage')}}
                <input type="file" multiple accept=".jpg, .jpeg, .png" @change="imageUpload">
            </span>
        </figure>
    </div>
</div>

<input type="text" style="display: none;" class="form-control" name="prestataire_id" placeholder="{{ trans('admin.excursion.columns.prestataire_id') }}">