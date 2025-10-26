<div class="form-group row align-items-center">
    <label for="name" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.ile.columns.name') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" required class="form-control" name="name" placeholder="{{ trans('admin.ile.columns.name') }}">
    </div>
</div>

<div class="form-group row align-items-center">
    <label for="pays_id" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.ile.columns.pays_id') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" name="pays_id" style="display: none;">
        <input type="text" name="pays_name" class="form-control" placeholder="{{ trans('admin.ile.columns.pays_id') }}" v-autocompletion="autocompletePays" :action="urlbase+'/admin/autocompletion/pays'" :autokey="'id'" :label="'nom'" :inputkey="'pays_id'" :inputlabel="'pays_name'">
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
    <label for="background_image" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.ile.columns.background_image') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <figure class="figure-form" v-for="(_image,_index) in backgroundCardImage" :key="_index+'carte'">
            <img :src="$isBase64(_image)?_image: `${urlasset}/${_image}`" alt="" style="height: 100%;width: auto;">
            <span class="my-_btn-remove" @click.prevent="removeBackGroundCart(_index)">
                {{trans('admin.ile.actions.removeImage')}}
            </span>
            <input type="text" required class="form-control" name="background_image" style="display: none;" :value="_image">
        </figure>
        <figure v-if="backgroundCardImage.length == 0" class="figure-form" @drop.prevent="uploadBackGroundCart($event,true)" @dragover.prevent>
            <span class="my-_btn-add">
                {{trans('admin.ile.actions.uploadBackgroundCard')}}
                <input type="file" multiple accept=".jpg, .jpeg, .png" @change="uploadBackGroundCart">
            </span>
        </figure>
    </div>
</div>