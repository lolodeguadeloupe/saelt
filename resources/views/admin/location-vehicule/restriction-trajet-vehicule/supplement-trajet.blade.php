<div class="card">
    <div class="card-header">
        <h3>{{trans('admin.vehicule-categorie-supplement.actions.index')}}</h3>
        <a class="float-right text-danger" style="cursor:pointer" href="#" @click.prevent="closeModal('supplement_trajet')"><i class="fa fa-times"></i></a>
    </div>
    <div class="card-body">
        <div class="flex-column w-100 position-relative" :class="categorie_index != 0?'d-none':'d-flex'" :id="`categorie_${categorie_item.id}`" v-for="(categorie_item,categorie_index) in categories">
            <div class="w-100 my-3 d-flex flex-row">
                <div class="position-relative">
                    <button @click="changeFormCategorieTraje($getKey(categories,'id'),-1)" type="button" class="btn btn-primary"><i class="fa fa-arrow-left"></i></button>
                    <div class="position-absolute w-100 h-100 top-0 left-0 bg-white" style="opacity: 0.5;" v-if="categorie_index <= 0">
                    </div>
                </div>
                <div class="flex-grow-1">
                    <h4 class="m-0 p-0 text-center">@{{categorie_item.titre}}</h4>
                </div>
                <div class="position-relative">
                    <button @click="changeFormCategorieTraje($getKey(categories,'id'),1)" type="button" class="btn btn-primary"><i class="fa fa-arrow-right"></i></button>
                    <div class="position-absolute w-100 h-100 top-0 left-0 bg-white" style="opacity: 0.5;" v-if="categorie_index >= categories.length -1">
                    </div>
                </div>
            </div>
            <div class="w-100">
                <form :id="`form_categorie_${categorie_item.id}`">
                    <table class="table-listing table table-outline">
                        <thead>
                            <tr>
                                <th>{{ trans('admin.vehicule-categorie-supplement.columns.trajet') }}</th>
                                <th>{{ trans('admin.vehicule-categorie-supplement.columns.tarif') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="restrictionTrajetVehicule_item of restrictionTrajetVehicule">
                                <td>@{{restrictionTrajetVehicule_item.titre}}</td>
                                <td style="text-align: unset;">
                                    <input type="text" :name="`categorie_vehicule_id_${categorie_index}`" style="display: none;" :value="categorie_item.id">
                                    <input type="text" :name="`restriction_trajet_id_${categorie_index}`" :value="restrictionTrajetVehicule_item.id" style="display: none;">
                                    <input type="number" inputmode="decimal" step="any" required class="form-control with-unite" required :name="`tarif_${categorie_index}`">
                                    <span style="position: absolute; left: 20px; top: 0; width:auto; height: 100%;display: flex;align-items: center; font-weight: 500; text-decoration: underline;font-size: 18px;">€</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </form>
            </div>
            <div class="d-flex flex-row justify-content-between my-3 w-100">
                <div class="my-3 w-100 d-flex position-relative">
                    <button type="button" class="btn btn-primary mr-auto ml-0" @click="changeFormCategorieTraje($getKey(categories,'id'),-1)"> {{trans('admin-base.btn.prev')}}</button>
                    <div class="position-absolute w-100 h-100 top-0 left-0 bg-white" style="opacity: 0.5;" v-if="categorie_index <= 0">
                    </div>
                </div>
                <div class="my-3 w-100 d-flex position-relative" v-if="categorie_index < categories.length -1">
                    <button type="button" class="btn btn-primary ml-auto mr-0" @click="changeFormCategorieTraje($getKey(categories,'id'),1)"> {{trans('admin-base.btn.next')}}</button>
                    <div class="position-absolute w-100 h-100 top-0 left-0 bg-white" style="opacity: 0.5;" v-if="categorie_index >= categories.length -1">
                    </div>
                </div>
                <div class="my-3 w-100 d-flex" v-if="categorie_index == categories.length -1">
                    <button type="button" class="btn btn-success ml-auto mr-0" @click="saveFormCategorieTrajet($event,$getKey(categories,'id'),'{{url('admin/vehicule-categorie-supplements/store-all')}}')"> {{trans('admin-base.btn.save')}}</button>
                </div>
            </div>
        </div>
    </div>
</div>