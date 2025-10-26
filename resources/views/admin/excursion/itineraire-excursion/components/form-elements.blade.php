<div class="form-group row align-items-center">
    <label for="nom" class="col-form-label text-md-right reauired" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.itineraire-excursion.columns.titre') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" required class="form-control" name="titre" placeholder="{{ trans('admin.itineraire-excursion.columns.titre') }}">
    </div>
</div>

<div class="form-group row align-items-center">
    <label for="rang" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.itineraire-excursion.columns.rang') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="number" class="form-control" name="rang" placeholder="{{ trans('admin.itineraire-excursion.columns.rang') }}">
    </div>
</div>

<div class="form-group row align-items-center">
    <label for="image" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.itineraire-excursion.columns.image') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <figure style="width: 100px;height: 100px;" class="figure-form" v-for="(_image,_index) in image" :key="_index+'image'">
            <img :src="$isBase64(_image)?_image:`${urlasset}/${_image}`" alt="image" style="height: 100%;width: auto;">
            <span class="my-_btn-remove" @click.prevent="removeImage(_index)">
                {{trans('admin.itineraire-excursion.actions.removeImage')}}
            </span>
            <input type="text" required class="form-control" name="image" style="display: none;" :value="_image">
        </figure>
        <figure v-if="image.length == 0" style="width: 100px;height: 100px;" class="figure-form" @drop.prevent="uploadImage($event,true)" @dragover.prevent>
            <span class="my-_btn-add">
                {{trans('admin.itineraire-excursion.actions.uploadImage')}}
                <input type="file" multiple accept=".jpg, .jpeg, .png" @change="uploadImage">
            </span>
        </figure>
    </div>
</div>

<div class="form-group row align-items-center">
    <label for="description" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.itineraire-excursion.columns.description') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <wysiwyg v-model="form.description" :config="mediaWysiwygConfig" />
    </div>
</div>

<input type="text" style="display: none;" value="{{$excursion->id}}" name="excursion_id">