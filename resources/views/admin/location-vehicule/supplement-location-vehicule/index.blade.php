@extends('admin.customer-layout.layout.default')

@section('title', trans('admin.supplement-location-vehicule.title'))

@section('body')

<supplement-location-vehicule-listing :data="{{ $data->toJson() }}" :url="'{{ url('admin/supplement-location-vehicules') }}'" :urlbase="'{{base_url('')}}'" :urlasset="'{{asset('')}}'" inline-template>
    <diV style="display:contents; position:relative">
        <div class="row">
            <div class="col">
                <div class="card position-relative">
                    <div class="card-header">
                        <h3>{{trans('admin.supplement-location-vehicule.title')}}</h3>
                    </div>
                    <div class="card-body" v-cloak>
                        <div class="card-block">
                            <div class="b-a-1 py-3 row position-relative">
                                <div class="bg-white left-0 m-0 ml-3 position-absolute px-2 py-1" style="top: -16px;">
                                    <span>{{trans('admin.supplement-location-vehicule.supplement_jeune_conducteur_location_vehicule')}}</span>
                                </div>
                                <div class="col-12 mt-3 mb-1" v-for="(item_jeune_conducteur,index_jeune_conducteur) in jeune_conducteur">
                                    <form @submit.prevent="storeJeuneConducteur" :action="item_jeune_conducteur.resource_url" class="d-flex align-items-center">
                                        <div style="width: 80%;">
                                            <div class="d-flex align-items-center position-relative" style="height: 40px;">
                                                <i class="fa fa-dot-circle-o"></i>
                                                &nbsp;
                                                <span class="font-lg font-weight-bold">{{trans('admin.supplement-location-vehicule.columns.min_age')}}</span>
                                                <span class="mr-0 ml-auto position-relative">
                                                    @{{item_jeune_conducteur.min_age}} Ans
                                                    <div class="value-edit position-absolute right-0 top-0" :class="(item_jeune_conducteur.isEdit == undefined || item_jeune_conducteur.isEdit == false) ? 'd-none':''">
                                                        <input type="number" inputmode="decimal" step="any" min="0" required class="with-unite outline-0 text-center" name="min_age" required>
                                                        <span style="position: absolute; left: 20px; top: 0; width:auto; height: 100%;display: flex;align-items: center; font-weight: 500; text-decoration: underline;font-size: 18px;">Ans</span>
                                                    </div>
                                                </span>
                                            </div>
                                            <div class="d-flex align-items-center position-relative" style="height: 40px;">
                                                <i class="fa fa-dot-circle-o"></i>
                                                &nbsp;
                                                <span class="font-lg font-weight-bold">{{trans('admin.supplement-location-vehicule.columns.max_age')}}</span>
                                                <span class="mr-0 ml-auto position-relative">
                                                    @{{item_jeune_conducteur.max_age}} Ans
                                                    <div class="value-edit position-absolute right-0 top-0" :class="(item_jeune_conducteur.isEdit == undefined || item_jeune_conducteur.isEdit == false) ? 'd-none':''">
                                                        <input type="number" inputmode="decimal" step="any" min="0" required class="with-unite outline-0 text-center" name="max_age" required>
                                                        <span style="position: absolute; left: 20px; top: 0; width:auto; height: 100%;display: flex;align-items: center; font-weight: 500; text-decoration: underline;font-size: 18px;">Ans</span>
                                                    </div>
                                                </span>
                                            </div>
                                            <div class="d-flex align-items-center position-relative" style="height: 40px;">
                                                <i class="fa fa-dot-circle-o"></i>
                                                &nbsp;
                                                <span class="font-lg font-weight-bold">{{trans('admin.supplement-location-vehicule.columns.valeur_devises')}}</span>
                                                <span class="mr-0 ml-auto position-relative">
                                                    <div class="relative justify-content-between d-flex" style="min-width: 187px;">
                                                        <div class="d-flex flex-row align-items-center mr-4"><input :disabled="(item_jeune_conducteur.isEdit == undefined || item_jeune_conducteur.isEdit == false)" type="radio" class="mr-1" style="width: 20px;height: 20px;" name="valeur_appliquer" :value="'1'" :checked="item_jeune_conducteur.valeur_appliquer=='1'" @input="checkValeurAppliquer($event,jeune_conducteur,index_jeune_conducteur,`#valeur_devises${item_jeune_conducteur.sigle}`)" id="desactive_supp_jeune"><label class="flex-grow-1 m-0" for="desactive_supp_jeune">(€)</label></div>
                                                        <div class="d-flex flex-row align-items-center"><input :disabled="(item_jeune_conducteur.isEdit == undefined || item_jeune_conducteur.isEdit == false)" type="radio" class="mr-1" style="width: 20px;height: 20px;" name="valeur_appliquer" :value="'0'" :checked="item_jeune_conducteur.valeur_appliquer=='0'" @input="checkValeurAppliquer($event,jeune_conducteur,index_jeune_conducteur,`#valeur_pourcent${item_jeune_conducteur.sigle}`)" id="active_supp_jeune"><label class="flex-grow-1 m-0" for="active_supp_jeune">(%)</label></div>
                                                    </div>
                                                </span>
                                            </div>
                                            <div class="align-items-center position-relative" style="height: 40px;" :class="item_jeune_conducteur.valeur_appliquer=='0'?'d-flex':'d-none'">
                                                <i class="fa fa-dot-circle-o"></i>
                                                &nbsp;
                                                <span class="font-lg font-weight-bold">{{trans('admin.supplement-location-vehicule.columns.valeur_pourcent')}}</span>
                                                <span class="mr-0 ml-auto position-relative">
                                                    @{{item_jeune_conducteur.valeur_pourcent}} %
                                                    <div class="value-edit position-absolute right-0 top-0" :class="(item_jeune_conducteur.isEdit == undefined || item_jeune_conducteur.isEdit == false) ? 'd-none':''">
                                                        <input type="number" inputmode="decimal" step="any" min="0" required class="with-unite outline-0 text-center" name="valeur_pourcent" :id="`valeur_pourcent${item_jeune_conducteur.sigle}`" required>
                                                        <span style="position: absolute; left: 20px; top: 0; width:auto; height: 100%;display: flex;align-items: center; font-weight: 500; text-decoration: underline;font-size: 18px;">%</span>
                                                    </div>
                                                </span>
                                            </div>
                                            <div class="align-items-center position-relative" style="height: 40px;" :class="item_jeune_conducteur.valeur_appliquer=='1'?'d-flex':'d-none'">
                                                <i class="fa fa-dot-circle-o"></i>
                                                &nbsp;
                                                <span class="font-lg font-weight-bold">{{trans('admin.supplement-location-vehicule.columns.valeur_devises')}}</span>
                                                <span class="mr-0 ml-auto position-relative">
                                                    @{{item_jeune_conducteur.valeur_devises}} €
                                                    <div class="value-edit position-absolute right-0 top-0" :class="(item_jeune_conducteur.isEdit == undefined || item_jeune_conducteur.isEdit == false) ? 'd-none':''">
                                                        <input type="number" inputmode="decimal" step="any" min="0" required class="with-unite outline-0 text-center" name="valeur_devises" :id="`valeur_devises${item_jeune_conducteur.sigle}`" required>
                                                        <span style="position: absolute; left: 20px; top: 0; width:auto; height: 100%;display: flex;align-items: center; font-weight: 500; text-decoration: underline;font-size: 18px;">€</span>
                                                    </div>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="mr-0 ml-auto">
                                            <button type="button" class="border-info b-a-1" v-if="(item_jeune_conducteur.isEdit == undefined || item_jeune_conducteur.isEdit == false)" @click.prevent="editJeuneConducteur($event,item_jeune_conducteur.resource_url,index_jeune_conducteur)"><i class="text-info fa fa-pencil"></i></button>
                                            <button type="submit" v-if="(item_jeune_conducteur.isEdit != undefined && item_jeune_conducteur.isEdit == true)" class="border-success b-a-1"><i class="text-success fa fa-save"></i></button>
                                            <button type="button" class="border-danger b-a-1" v-if="(item_jeune_conducteur.isEdit != undefined && item_jeune_conducteur.isEdit == true)" @click.prevent="annulerEdit($event,jeune_conducteur,index_jeune_conducteur)"><i class="text-danger fa fa-times"></i></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- -->
                            <!--<div class="b-a-1 py-3 row position-relative mt-4">
                                <div class="bg-white left-0 m-0 ml-1 position-absolute px-2 py-1" style="top: -16px;">
                                    <h4>{{trans('admin.supplement-location-vehicule.supplement_conducteur_supplementaire_location_vehicule')}}</h4>
                                </div>
                                <div class="col-12 mt-1 mb-1" v-for="(item_jeune_conducteur,index_jeune_conducteur) in jeune_conducteur">
                                    <form @submit.prevent="storeJeuneConducteur" :action="item_jeune_conducteur.resource_url" class="d-flex align-items-center">
                                        <div style="width: 80%;">
                                            <div class="d-flex align-items-center position-relative" style="height: 40px;">
                                                <i class="fa fa-dot-circle-o"></i>
                                                &nbsp;
                                                <span class="font-lg font-weight-bold">{{trans('admin.supplement-location-vehicule.columns.min_age')}}</span>
                                                <span class="mr-0 ml-auto position-relative">
                                                    @{{item_jeune_conducteur.min_age}} Ans
                                                    <div class="value-edit position-absolute right-0 top-0" :class="(item_jeune_conducteur.isEdit == undefined || item_jeune_conducteur.isEdit == false) ? 'd-none':''">
                                                        <input type="number" inputmode="decimal" step="any" min="0" required class="with-unite outline-0 text-center" name="min_age" required>
                                                        <span style="position: absolute; left: 20px; top: 0; width:auto; height: 100%;display: flex;align-items: center; font-weight: 500; text-decoration: underline;font-size: 18px;">Ans</span>
                                                    </div>
                                                </span>
                                            </div>
                                            <div class="d-flex align-items-center position-relative" style="height: 40px;">
                                                <i class="fa fa-dot-circle-o"></i>
                                                &nbsp;
                                                <span class="font-lg font-weight-bold">{{trans('admin.supplement-location-vehicule.columns.max_age')}}</span>
                                                <span class="mr-0 ml-auto position-relative">
                                                    @{{item_jeune_conducteur.max_age}} Ans
                                                    <div class="value-edit position-absolute right-0 top-0" :class="(item_jeune_conducteur.isEdit == undefined || item_jeune_conducteur.isEdit == false) ? 'd-none':''">
                                                        <input type="number" inputmode="decimal" step="any" min="0" required class="with-unite outline-0 text-center" name="max_age" required>
                                                        <span style="position: absolute; left: 20px; top: 0; width:auto; height: 100%;display: flex;align-items: center; font-weight: 500; text-decoration: underline;font-size: 18px;">Ans</span>
                                                    </div>
                                                </span>
                                            </div>
                                            <div class="d-flex align-items-center position-relative" style="height: 40px;">
                                                <i class="fa fa-dot-circle-o"></i>
                                                &nbsp;
                                                <span class="font-lg font-weight-bold">{{trans('admin.supplement-location-vehicule.columns.valeur_devises')}}</span>
                                                <span class="mr-0 ml-auto position-relative">
                                                    <div class="relative justify-content-between d-flex" style="min-width: 187px;">
                                                        <div class="d-flex flex-row align-items-center mr-4"><input :disabled="(item_jeune_conducteur.isEdit == undefined || item_jeune_conducteur.isEdit == false)" type="radio" class="mr-1" style="width: 20px;height: 20px;" name="valeur_appliquer" :value="'1'" :checked="item_jeune_conducteur.valeur_appliquer=='1'" @input="checkValeurAppliquer($event,jeune_conducteur,index_jeune_conducteur,`#valeur_devises${item_jeune_conducteur.sigle}`)" id="desactive_supp_jeune"><label class="flex-grow-1 m-0" for="desactive_supp_jeune">(€)</label></div>
                                                        <div class="d-flex flex-row align-items-center"><input :disabled="(item_jeune_conducteur.isEdit == undefined || item_jeune_conducteur.isEdit == false)" type="radio" class="mr-1" style="width: 20px;height: 20px;" name="valeur_appliquer" :value="'0'" :checked="item_jeune_conducteur.valeur_appliquer=='0'" @input="checkValeurAppliquer($event,jeune_conducteur,index_jeune_conducteur,`#valeur_pourcent${item_jeune_conducteur.sigle}`)" id="active_supp_jeune"><label class="flex-grow-1 m-0" for="active_supp_jeune">(%)</label></div>
                                                    </div>
                                                </span>
                                            </div>
                                            <div class="align-items-center position-relative" style="height: 40px;" :class="item_jeune_conducteur.valeur_appliquer=='0'?'d-flex':'d-none'">
                                                <i class="fa fa-dot-circle-o"></i>
                                                &nbsp;
                                                <span class="font-lg font-weight-bold">{{trans('admin.supplement-location-vehicule.columns.valeur_pourcent')}}</span>
                                                <span class="mr-0 ml-auto position-relative">
                                                    @{{item_jeune_conducteur.valeur_pourcent}} %
                                                    <div class="value-edit position-absolute right-0 top-0" :class="(item_jeune_conducteur.isEdit == undefined || item_jeune_conducteur.isEdit == false) ? 'd-none':''">
                                                        <input type="number" inputmode="decimal" step="any" min="0" required class="with-unite outline-0 text-center" name="valeur_pourcent" :id="`valeur_pourcent${item_jeune_conducteur.sigle}`" required>
                                                        <span style="position: absolute; left: 20px; top: 0; width:auto; height: 100%;display: flex;align-items: center; font-weight: 500; text-decoration: underline;font-size: 18px;">%</span>
                                                    </div>
                                                </span>
                                            </div>
                                            <div class="align-items-center position-relative" style="height: 40px;" :class="item_jeune_conducteur.valeur_appliquer=='1'?'d-flex':'d-none'">
                                                <i class="fa fa-dot-circle-o"></i>
                                                &nbsp;
                                                <span class="font-lg font-weight-bold">{{trans('admin.supplement-location-vehicule.columns.valeur_devises')}}</span>
                                                <span class="mr-0 ml-auto position-relative">
                                                    @{{item_jeune_conducteur.valeur_devises}} €
                                                    <div class="value-edit position-absolute right-0 top-0" :class="(item_jeune_conducteur.isEdit == undefined || item_jeune_conducteur.isEdit == false) ? 'd-none':''">
                                                        <input type="number" inputmode="decimal" step="any" min="0" required class="with-unite outline-0 text-center" name="valeur_devises" :id="`valeur_devises${item_jeune_conducteur.sigle}`" required>
                                                        <span style="position: absolute; left: 20px; top: 0; width:auto; height: 100%;display: flex;align-items: center; font-weight: 500; text-decoration: underline;font-size: 18px;">€</span>
                                                    </div>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="mr-0 ml-auto">
                                            <button type="button" class="border-info b-a-1" v-if="(item_jeune_conducteur.isEdit == undefined || item_jeune_conducteur.isEdit == false)" @click.prevent="editJeuneConducteur($event,item_jeune_conducteur.resource_url,index_jeune_conducteur)"><i class="text-info fa fa-pencil"></i></button>
                                            <button type="submit" v-if="(item_jeune_conducteur.isEdit != undefined && item_jeune_conducteur.isEdit == true)" class="border-success b-a-1"><i class="text-success fa fa-save"></i></button>
                                            <button type="button" class="border-danger b-a-1" v-if="(item_jeune_conducteur.isEdit != undefined && item_jeune_conducteur.isEdit == true)" @click.prevent="annulerEdit($event,jeune_conducteur,index_jeune_conducteur)"><i class="text-danger fa fa-times"></i></button>
                                        </div>
                                    </form>
                                </div>
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>
        </diV>
</supplement-location-vehicule-listing>

@endsection