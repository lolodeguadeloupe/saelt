<div class="form-group row align-items-center">
    <label for="point_depart" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.trajet-transfert-voyage.columns.point_depart') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'" class="relative">
        <input type="text" name="point_depart" style="display: none;">
        <input type="text" required name="point_depart_titre" class="form-control" placeholder="{{ trans('admin.trajet-transfert-voyage.columns.point_depart') }}" v-autocompletion="autocompleteLieuTransfert" :action="urlbase+'/admin/autocompletion/lieu-transferts'" :autokey="'id'" :label="'titre'" :inputkey="'point_depart'" :inputlabel="'point_depart_titre'">
    </div>
</div>

<div class="form-group row align-items-center">
    <label for="point_arrive" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.trajet-transfert-voyage.columns.point_arrive') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'" class="relative">
        <input type="text" name="point_arrive" style="display: none;">
        <input type="text" required name="point_arrive_titre" class="form-control" placeholder="{{ trans('admin.trajet-transfert-voyage.columns.point_arrive') }}" v-autocompletion="autocompleteLieuTransfert" :action="urlbase+'/admin/autocompletion/lieu-transferts'" :autokey="'id'" :label="'titre'" :inputkey="'point_arrive'" :inputlabel="'point_arrive_titre'">
    </div>
</div>

<div class="form-group row align-items-center">
    <label for="titre" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.trajet-transfert-voyage.columns.titre') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" class="form-control" name="titre" placeholder="{{ trans('admin.trajet-transfert-voyage.columns.titre') }}">
    </div>
</div>

<div class="form-group row align-items-center">
    <label for="card" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.trajet-transfert-voyage.columns.card') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <figure class="figure-form" v-for="(_image,_index) in cardImage" :key="_index+'carte'">
            <img :src="$isBase64(_image)?_image:`${urlasset}/${_image}`" alt="image" style="height: 100%;width: auto;">
            <span class="my-_btn-remove" @click.prevent="removeCart(_index)">
                {{trans('admin.trajet-transfert-voyage.actions.removeImage')}}
            </span>
            <input type="text" required class="form-control" name="card" style="display: none;" :value="_image">
        </figure>
        <figure v-if="cardImage.length == 0" class="figure-form" @drop.prevent="uploadCart($event,true)" @dragover.prevent>
            <span class="my-_btn-add">
                {{trans('admin.trajet-transfert-voyage.actions.uploadCard')}}
                <input type="file" multiple accept=".jpg, .jpeg, .png" @change="uploadCart">
            </span>
        </figure>
    </div>
</div>
<div class="form-group row align-items-center">
    <label for="description" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.trajet-transfert-voyage.columns.description') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <div>
            <wysiwyg v-model="form.description" id="description" name="description" :config="mediaWysiwygConfig"></wysiwyg>
        </div>
    </div>
</div>