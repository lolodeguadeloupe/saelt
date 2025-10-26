@extends('admin.customer-layout.layout.default')

@section('title', trans('admin.nav.parametre.title'))

@section('body')

<app-all-config-listing :data="{{ $data->toJson() }}" :url="'{{url('/admin/app-supplements')}}'" :urlfraisdossier="'{{url('/admin/frais-dossiers')}}'" :urlproduit="'{{url('/admin/produits')}}'" :urlbase="'{{base_url('')}}'" :lang="{{json_encode(trans('admin.app-module'))}}" :urlasset="'{{asset('')}}'" inline-template>
    <diV style="display:contents; position:relative">
        <div class="row">
            <div class="col">
                <div class="card position-relative">
                    <div class="card-header">
                        <h3>{{trans('admin.nav.parametre.title')}}</h3>
                    </div>
                    <div class="card-body" v-cloak>
                        <div class="card-block">
                            <div class="b-a-1 py-3 row position-relative">
                                <div class="bg-white left-0 m-0 ml-1 position-absolute px-2 py-1" style="top: -16px;">
                                    {{trans('admin.frais-dossier.actions.index')}}
                                </div>
                                <div class="col-12 mt-1 mb-1" v-for="(item_frais_dossier,index_frais_dossier) in frais_dossier">
                                    <form @submit.prevent="storeFraisDossier" :action="item_frais_dossier.resource_url" class="d-flex align-items-center">
                                        <div style="width: 80%;height: 27px;">
                                            <i class="fa fa-ticket"></i>
                                            &nbsp;
                                            <span class="font-italic">@{{lang[item_frais_dossier.sigle]}}</span>
                                            <span class="float-right position-relative">
                                                @{{item_frais_dossier.prix}}€
                                                <div class="value-edit position-absolute right-0 top-0" :class="(item_frais_dossier.isEdit == undefined || item_frais_dossier.isEdit == false) ? 'd-none':''">
                                                    <input type="number" inputmode="decimal" step="any" min="0" required class="with-unite outline-0" name="prix" required placeholder="{{ trans('admin.frais-dossier.columns.prix') }}">
                                                    <span style="position: absolute; left: 20px; top: 0; width:auto; height: 100%;display: flex;align-items: center; font-weight: 500; text-decoration: underline;font-size: 18px;">€</span>
                                                </div>
                                            </span>
                                        </div>
                                        <div class="mr-0 ml-auto">
                                            <button type="button" class="border-info b-a-1" v-if="(item_frais_dossier.isEdit == undefined || item_frais_dossier.isEdit == false)" @click.prevent="editFraisDossier($event,item_frais_dossier.resource_url,index_frais_dossier)"><i class="text-info fa fa-pencil"></i></button>
                                            <button type="submit" v-if="(item_frais_dossier.isEdit != undefined && item_frais_dossier.isEdit == true)" class="border-success b-a-1"><i class="text-success fa fa-save"></i></button>
                                        </div>
                                    </form>
                                </div>
                                <!--<div class="col-12 mt-1 mb-1">
                                    <form action="#" class="d-flex align-items-center">
                                        <div style="width: 80%;">
                                            <i class="fa fa-money-bill"></i>
                                            &nbsp;<span class="font-italic">Dévise</span>
                                            <span class="value-item float-right">Euro(€)</span>

                                        </div>
                                        <div class="mr-0 ml-auto">
                                            <i class="text-info fa fa-pencil"></i>
                                            <i class="text-success fa fa-save"></i>
                                        </div>
                                    </form>
                                </div>-->
                            </div>
                            <div class="b-a-1 py-3 row position-relative mt-4">
                                <div class="bg-white left-0 m-0 ml-1 position-absolute px-2 py-1" style="top: -16px;">
                                    {{trans('admin.produit.actions.index')}}
                                </div>
                                <div class="col-12 mt-1 mb-1" v-for="(item_produit,index_produit) in produit">
                                    <form @submit.prevent="" :action="item_produit.resource_url" class="d-flex align-items-center">
                                        <div style="width: 80%;height: 27px;">
                                            <i class="fa fa-dot-circle"></i>
                                            &nbsp;
                                            <span class="font-italic">@{{lang[item_produit.sigle]}}</span>
                                            <span class="float-right position-relative">
                                                @{{item_produit.status == 0 ?lang['options']['off']:lang['options']['on']}}
                                            </span>
                                        </div>
                                        <div class="mr-0 ml-auto" @click.prevent="changerStatusProduit($event,item_produit)">
                                            <div class="my-switch">
                                                <input type="checkbox" class="d-none" :id="`switch-${item_produit.id}`" v-model="item_produit.status">
                                                <label :for="`switch-${item_produit.id}`"></label>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </diV>
</app-all-config-listing>

@endsection