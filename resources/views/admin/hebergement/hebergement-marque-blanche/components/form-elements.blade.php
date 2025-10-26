<div class="form-group row align-items-center required">
    <label for="liens" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.hebergement-marque-blanche.columns.liens') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" required class="form-control" name="liens" placeholder="{{ trans('admin.hebergement-marque-blanche.columns.liens') }}">
    </div>
</div>

<div class="form-group row align-items-center">
    <label for="type_hebergement_id" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.hebergement-marque-blanche.columns.type_hebergement_id') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'" class="relative">
        <select required class="form-control" name="type_hebergement_id">
            <option v-for="type in types" :value="type.id">@{{ type.name }}</option>
        </select>
        <div class="form-btn-inline-new" @click.prevent="createTypeHeb($event,'{{url('admin/type-hebergements/create')}}')"><i class="fa fa-plus"></i>
            <div class="info--btn">&nbsp;{{trans('admin.type-hebergement.actions.create')}}</div>
        </div>
    </div>
</div>


<div class="form-group row align-items-center">
    <label for="description" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.hebergement-marque-blanche.columns.description') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <textarea class="form-control" name="description" cols="30" rows="3" placeholder="{{ trans('admin.hebergement-marque-blanche.columns.description') }}"></textarea>
    </div>
</div>


<div class="form-group row align-items-center">
    <label for="description" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.hebergement-marque-blanche.columns.image') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'" style="background-color: white;">
        <figure class="figure-form" v-for="(_image, _index) in imageServeur" :key="_index+'serveur'">
            <img :src="$isBase64(_image.name)?_image.name:`${urlasset}/${_image.name}`" alt="Image" style="height: 100%;width: 100%;">
            <span class="my-_btn-remove" @click.prevent="deleteImageServeur($event,_image.resource_url,_index)">
                {{trans('admin.hebergement-marque-blanche.actions.removeImage')}}
            </span>
        </figure>

        <!--  -->

        <figure class="figure-form" v-for="(_image,_index) in imageUploads" :key="_index+'local'">
            <img :src="$isBase64(_image)?_image:`${urlasset}/${_image}`" alt="Image" style="height: 100%;width: auto;">
            <span class="my-_btn-remove" @click.prevent="removeUploadImage(_index)">
                {{trans('admin.hebergement-marque-blanche.actions.removeImage')}}
            </span>
        </figure>
        <figure class="figure-form" @drop.prevent="imageUpload($event,true)" @dragover.prevent >
            <span class="my-_btn-add">
                {{trans('admin.hebergement-marque-blanche.actions.uploadImage')}}
                <input type="file" multiple accept=".jpg, .jpeg, .png" id="" @change="imageUpload">
            </span>
        </figure>
    </div>
</div>