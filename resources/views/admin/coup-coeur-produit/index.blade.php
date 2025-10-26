@extends('admin.customer-layout.layout.default')

@section('title', trans('admin.coup-coeur-produit.actions.index'))

@section('body')

<coup-coeur-produit-listing :produits="{{ $data->toJson() }}" :url="'{{ url('admin/coup-coeur-produits') }}'" :action="'{{ url('admin/coup-coeur-produits') }}'" :options="{{$options->toJson()}}" :lang="{{json_encode(trans('admin.app-module'))}}" :urlbase="'{{base_url('')}}'" :urlasset="'{{asset('')}}'" inline-template>

    <diV style="display:contents; position:relative">
        <div class="row">
            <div class="col">
                <div class="card position-relative">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i>
                        <h3>
                            {{ trans('admin.coup-coeur-produit.actions.index') }}
                        </h3>
                    </div>
                    <div class="card-body" v-cloak>
                        <div class="card-block">
                            <form @submit.prevent="">
                                <div class="card">
                                    <div class="card-header border py-2">
                                        <div class="row">
                                            <div class="align-items-center col-lg-auto col-md-2 d-flex">
                                                <span style="color: black;">Filtre par </span>
                                            </div>
                                            <div class="col-9">
                                                <div class="row">
                                                    <div class="col-auto border ml-4 d-flex align-items-center p-0 my-2">
                                                        <span class="pr-3 pl-2">Produit : </span>
                                                        <select v-model="produit" class="outline-0 border-0 flex-grow-1" style="height: 30px;">
                                                            <option :value="$getKey(options,'id')"> {{trans('admin-base.filter.all')}} </option>
                                                            <option :value="item_option.id" v-for="(item_option, index_option) in options">@{{lang[item_option.sigle]}}</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-auto border ml-4 d-flex align-items-center p-0 custom-planing-autoccomple my-2">
                                                        <span class="pr-3 pl-2">Recherche : <b style="color: black;width: 13px;display: inline-block;text-align: center; cursor:help" data-toggle="tooltip" data-placement="top" title="{{ trans('admin.coup-coeur-produit.search') }}">?</b> </span>
                                                        <input type="text" required class="outline-0 border-0 flex-grow-1" style="height: 30px;" v-model="mot_cles">
                                                    </div>
                                                    <div class="col-auto border ml-4 d-flex align-items-center p-0 my-2">
                                                        <span class="pr-3 pl-2">{{trans('admin-base.filter.item_selectionner')}} : </span>
                                                        <select v-model="item_limit" class="outline-0 border-0 flex-grow-1" style="height: 30px;">
                                                            <option value="5">5</option>
                                                            <option value="10">10</option>
                                                            <option value="50">50</option>
                                                            <option value="100">100</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-auto ml-4 d-flex align-items-center p-0 d-flex align-items-center my-2">
                                                        <input v-model="all_coup_coeur" type="checkbox" id="allData">
                                                        <label for="allData" class="m-0">{{trans('admin.coup-coeur-produit.actions.all_coup_coeur')}}</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body" id="coup-coeur">
                                        <div class="row py-2" v-if="(data_loaded.hebergement && data_loaded.hebergement.length)">
                                            <div class="col-12">
                                                <h3>@{{lang.hebergement}}</h3>
                                            </div>
                                        </div>
                                        <div class="row" v-if="(data_loaded.hebergement && data_loaded.hebergement.length)">
                                            <div class="col-md-3 col-lg-3 mb-4" v-for="(item_row,index_row) in data_loaded.hebergement">
                                                <div class="d-flex flex-column h-100 shadow">
                                                    <a href="#" class="border-bottom d-block flex-grow-1 position-relative d-flex">
                                                        <img :src="item_row.image ? ($isBase64(item_row.image)?item_row.image:`${urlasset}/${item_row.image}`) : ''" class="img-fluid w-100" style="max-height: 215px;">
                                                    </a>
                                                    <div class="pb-3 pl-4 pr-4 pt-4">
                                                        <div>
                                                            <div class="pb-1 pt-1"><a href="#" class="text-dark text-decoration-none">
                                                                    <h4 class="mb-1 text-yellow text-overflow-ellipsis"> @{{item_row.titre}} </h4>
                                                                </a>
                                                                <div class="d-flex" style="min-height: 30px;">
                                                                    <div class="flex-fill font-size-0-8-em mt-2"><i class="fa-map-marker-alt fas text-yellow mr-1"></i> <span> @{{item_row.ile}}</span></div>
                                                                    <div class="flex-fill font-size-0-8-em mt-2 border-left text-center"> <span>@{{item_row.ville}}</span></div>
                                                                </div>
                                                                <hr>
                                                                <div class="d-flex position-relative desc-coup-coeur" style="height: 50px;">
                                                                    @{{item_row.description?$textDescription(item_row.description,80):''}}
                                                                    <div class="bg-white border p-2 position-absolute w-100 long-text-desc" style="top: 0;left: 0;z-index: 9;" v-if="item_row.description">
                                                                        <p> @{{item_row.description?$textDescription(item_row.description,300):''}}</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex align-items-center">
                                                        <div v-if="item_row.coup_coeur == true" class="m-auto border btn btn-danger px-3 py-1 font-weight-bold" style="border: 1px solid white !important" @click.prevent="deleteItem($event,item_row,index_row,'hebergement')">
                                                            <span>{{ trans('admin.coup-coeur-produit.actions.delete') }}</span>
                                                        </div>

                                                        <div v-if="item_row.coup_coeur == false" class="m-auto border btn btn-success px-3 py-1 font-weight-bold" style="border: 1px solid white !important" @click.prevent="ajouterItem($event,item_row,index_row,'hebergement')">
                                                            <span>{{ trans('admin.coup-coeur-produit.actions.ajouter') }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row py-2" v-if="(data_loaded.excursion && data_loaded.excursion.length)">
                                            <div class="col-12">
                                                <h3>@{{lang.excursion}}</h3>
                                            </div>
                                        </div>
                                        <div class="row" v-if="(data_loaded.excursion && data_loaded.excursion.length)">
                                            <div class="col-md-3 col-lg-3 mb-4" v-for="(item_row,index_row) in data_loaded.excursion">
                                                <div class="d-flex flex-column h-100 shadow">
                                                    <a href="#" class="border-bottom d-block flex-grow-1 position-relative d-flex">
                                                        <img :src="item_row.image ? ($isBase64(item_row.image)?item_row.image:`${urlasset}/${item_row.image}`) : ''" class="img-fluid w-100" style="max-height: 215px;">
                                                    </a>
                                                    <div class="pb-3 pl-4 pr-4 pt-4">
                                                        <div>
                                                            <div class="pb-1 pt-1"><a href="#" class="text-dark text-decoration-none">
                                                                    <h4 class="mb-1 text-yellow text-overflow-ellipsis"> @{{item_row.titre}} </h4>
                                                                </a>
                                                                <div class="d-flex" style="min-height: 30px;">
                                                                    <div class="flex-fill font-size-0-8-em mt-2"><i class="fa-map-marker-alt fas text-yellow mr-1"></i> <span> @{{item_row.ile}}</span></div>
                                                                    <div class="flex-fill font-size-0-8-em mt-2 border-left text-center"> <span>@{{item_row.ville}}</span></div>
                                                                </div>
                                                                <hr>
                                                                <div class="d-flex position-relative desc-coup-coeur" style="height: 50px; overflow: hidden;">
                                                                    @{{item_row.description?$textDescription(item_row.description,80):''}}
                                                                    <div class="bg-white border p-2 position-absolute w-100 long-text-desc" style="top: 0;left: 0;z-index: 9;" v-if="item_row.description">
                                                                        <p> @{{item_row.description?$textDescription(item_row.description,300):''}}</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex align-items-center">
                                                        <div v-if="item_row.coup_coeur == true" class="m-auto border btn btn-danger px-3 py-1 font-weight-bold" style="border: 1px solid white !important" @click.prevent="deleteItem($event,item_row,index_row,'excursion')">
                                                            {{ trans('admin.coup-coeur-produit.actions.delete') }}
                                                        </div>

                                                        <div v-if="item_row.coup_coeur == false" class="m-auto border btn btn-success px-3 py-1 font-weight-bold" style="border: 1px solid white !important" @click.prevent="ajouterItem($event,item_row,index_row,'excursion')">
                                                            {{ trans('admin.coup-coeur-produit.actions.ajouter') }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row py-2" v-if="(data_loaded.transfert && data_loaded.transfert.length)">
                                            <div class="col-12">
                                                <h3>@{{lang.transfert}}</h3>
                                            </div>
                                        </div>
                                        <div class="row" v-if="(data_loaded.transfert && data_loaded.transfert.length)">
                                            <div class="col-md-3 col-lg-3 mb-4" v-for="(item_row,index_row) in data_loaded.transfert">
                                                <div class="d-flex flex-column h-100 shadow">
                                                    <a href="#" class="border-bottom d-block flex-grow-1 position-relative d-flex">
                                                        <img :src="item_row.image ? ($isBase64(item_row.image)?item_row.image:`${urlasset}/${item_row.image}`) : ''" class="img-fluid w-100" style="max-height: 215px;">
                                                    </a>
                                                    <div class="pb-3 pl-4 pr-4 pt-4">
                                                        <div>
                                                            <div class="pb-1 pt-1"><a href="#" class="text-dark text-decoration-none">
                                                                    <h4 class="mb-1 text-yellow text-overflow-ellipsis"> @{{item_row.titre}} </h4>
                                                                </a>
                                                                <hr>
                                                                <div class="d-flex position-relative desc-coup-coeur" style="height: 50px; overflow: hidden;">
                                                                    @{{item_row.description?$textDescription(item_row.description,80):''}}
                                                                    <div class="bg-white border p-2 position-absolute w-100 long-text-desc" style="top: 0;left: 0;z-index: 9;" v-if="item_row.description">
                                                                        <p> @{{item_row.description?$textDescription(item_row.description,300):''}}</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex align-items-center">
                                                        <div v-if="item_row.coup_coeur == true" class="m-auto border btn btn-danger px-3 py-1 font-weight-bold" style="border: 1px solid white !important" @click.prevent="deleteItem($event,item_row,index_row,'transfert')">
                                                            {{ trans('admin.coup-coeur-produit.actions.delete') }}
                                                        </div>

                                                        <div v-if="item_row.coup_coeur == false" class="m-auto border btn btn-success px-3 py-1 font-weight-bold" style="border: 1px solid white !important" @click.prevent="ajouterItem($event,item_row,index_row,'transfert')">
                                                            {{ trans('admin.coup-coeur-produit.actions.ajouter') }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row py-2" v-if="(data_loaded.location && data_loaded.location.length)">
                                            <div class="col-12">
                                                <h3>@{{lang.location}}</h3>
                                            </div>
                                        </div>
                                        <div class="row" v-if="(data_loaded.location && data_loaded.location.length)">
                                            <div class="col-md-3 col-lg-3 mb-4" v-for="(item_row,index_row) in data_loaded.location">
                                                <div class="d-flex flex-column h-100 shadow">
                                                    <a href="#" class="border-bottom d-block flex-grow-1 position-relative d-flex">
                                                        <img :src="item_row.image ? ($isBase64(item_row.image)?item_row.image:`${urlasset}/${item_row.image}`) : ''" class="img-fluid w-100" style="max-height: 215px;">
                                                    </a>
                                                    <div class="pb-3 pl-4 pr-4 pt-4">
                                                        <div>
                                                            <div class="pb-1 pt-1"><a href="#" class="text-dark text-decoration-none">
                                                                    <h4 class="mb-1 text-yellow text-overflow-ellipsis"> @{{item_row.titre}} </h4>
                                                                </a>
                                                                <hr>
                                                                <div class="d-flex position-relative desc-coup-coeur" style="height: 50px; overflow: hidden;">
                                                                    @{{item_row.description?$textDescription(item_row.description,80):''}}
                                                                    <div class="bg-white border p-2 position-absolute w-100 long-text-desc" style="top: 0;left: 0;z-index: 9;" v-if="item_row.description">
                                                                        <p> @{{item_row.description?$textDescription(item_row.description,300):''}}</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex align-items-center">
                                                        <div v-if="item_row.coup_coeur == true" class="m-auto border btn btn-danger px-3 py-1 font-weight-bold" style="border: 1px solid white !important" @click.prevent="deleteItem($event,item_row,index_row,'location')">
                                                            {{ trans('admin.coup-coeur-produit.actions.delete') }}
                                                        </div>

                                                        <div v-if="item_row.coup_coeur == false" class="ml-auto border btn btn-success px-3 py-1 font-weight-bold" style="border: 1px solid white !important" @click.prevent="ajouterItem($event,item_row,index_row,'location')">
                                                            {{ trans('admin.coup-coeur-produit.actions.ajouter') }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row py-2" v-if="(data_loaded.billetterie && data_loaded.billetterie.length)">
                                            <div class="col-12">
                                                <h3>@{{lang.billetterie}}</h3>
                                            </div>
                                        </div>
                                        <div class="row" v-if="(data_loaded.billetterie && data_loaded.billetterie.length)">
                                            <div class="col-md-3 col-lg-3 mb-4" v-for="(item_row,index_row) in data_loaded.billetterie">
                                                <div class="d-flex flex-column h-100 shadow">
                                                    <a href="#" class="border-bottom d-block flex-grow-1 position-relative d-flex">
                                                        <img :src="item_row.image ? ($isBase64(item_row.image)?item_row.image:`${urlasset}/${item_row.image}`) : ''" class="img-fluid w-100" style="max-height: 215px;">
                                                    </a>
                                                    <div class="pb-3 pl-4 pr-4 pt-4">
                                                        <div>
                                                            <div class="pb-1 pt-1"><a href="#" class="text-dark text-decoration-none">
                                                                    <h4 class="mb-1 text-yellow text-overflow-ellipsis"> @{{item_row.titre}} </h4>
                                                                </a>
                                                                <div class="d-flex" style="min-height: 30px;">
                                                                    <div class="flex-fill font-size-0-8-em mt-2"><i class="fa-map-marker-alt fas text-yellow mr-1"></i> <span> @{{item_row.ile}}</span></div>
                                                                    <div class="flex-fill font-size-0-8-em mt-2 border-left text-center"> <span>@{{item_row.ville}}</span></div>
                                                                </div>
                                                                <hr>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex align-items-center">
                                                        <div v-if="item_row.coup_coeur == true" class="m-auto border btn btn-danger px-3 py-1 font-weight-bold" style="border: 1px solid white !important" @click.prevent="deleteItem($event,item_row,index_row,'billetterie')">
                                                            {{ trans('admin.coup-coeur-produit.actions.delete') }}
                                                        </div>

                                                        <div v-if="item_row.coup_coeur == false" class="m-auto border btn btn-success px-3 py-1 font-weight-bold" style="border: 1px solid white !important" @click.prevent="ajouterItem($event,item_row,index_row,'billetterie')">
                                                            {{ trans('admin.coup-coeur-produit.actions.ajouter') }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </diV>
</coup-coeur-produit-listing>

@endsection


<!--

 'sigle' => 'billetterie',
                                'titre' => $data->titre,
                                'port_depart' => $data->depart ? $data->depart->name : null,
                                'port_arrivee' => $data->arrive ? $data->arrive->name : null,
                                'ville' => $data->depart->ville ? $data->depart->ville->name : null,
                                'ile' => null,
                                'image' => $data->image,
                                'coup_coeur' => CoupCoeurProduit::where(['model' => BilleterieMaritime::class, 'model_id' => $data->id])->count() == 1
-->

<!--<div class="card" style="height: 450px; overflow: hidden; background: #b8bfbe0f;">
                                                <div class="card-header py-2 text-center border-bottom">
                                                    <h4>@{{lang[item_row.sigle]}}</h4>
                                                </div>
                                                <div class="card-header py-1 d-flex alin-items-center justify-content-around position-relative border-bottom">
                                                    <div class="text-center" style="width: 45%;">
                                                        @{{item_row.titre}}
                                                    </div>
                                                    <div class="text-center" style="width: 45%;">
                                                        Id : @{{item_row.id}}
                                                    </div>
                                                </div>
                                                <div class="card-header py-1 d-flex alin-items-center justify-content-around position-relative border-bottom">
                                                    <div class="text-center" style="width: 45%;"> @{{item_row.il}}</div>
                                                    <div class="text-center" style="width: 45%;"> @{{item_row.ville}}</div>
                                                </div>
                                                <div class="card-body position-relative d-flex flex-column justify-content-around">
                                                    <img :src="item_row.image ? ($isBase64(item_row.image)?item_row.image:`${urlasset}/${item_row.image}`) : ''" class="w-100" alt="image">
                                                    <div>
                                                        @{{$textDescription(item_row.description?item_row.description:'',200)}}
                                                    </div>
                                                    <div v-if="item_row.coup_coeur == false" class="btn btn-success align-items-center bottom d-flex flex-row mb-2 ml-auto mr-0 mr-3 p-2 position-absolute px-4 right right-0 bg-white shadow-lg" style="border-width: 2px !important;" @click.prevent="ajouterItem($event,item_row,index_row)">
                                                        <span>
                                                            <i class="fa fa-plus" style="color: black"></i> &nbsp; {{ trans('admin.coup-coeur-produit.actions.ajouter') }}
                                                        </span>
                                                    </div>
                                                    <div v-if="item_row.coup_coeur == true" class="btn btn-danger align-items-center bottom d-flex flex-row mb-2 ml-auto mr-0 mr-3 p-2 position-absolute px-4 right right-0 bg-white shadow-lg" style="border-width: 2px !important;" @click.prevent="deleteItem($event,item_row,index_row)">
                                                        <span>
                                                            <i class="fa fa-times" style="color: red"></i> &nbsp; {{ trans('admin.coup-coeur-produit.actions.delete') }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
-->

<!--
    <div class="h-100 w-100 d-flex align-items-center position-absolute bg-transparent top-0 left-0" style="background-color: rgb(243 243 243 / 29%) !important;">
                                                            <div v-if="item_row.coup_coeur == true" class="font-5xl m-auto d-flex align-items-center border" style="height: 80px; width: 80px; border-radius: 50%;background-color: #ff000033;border-color: #9c7277 !important" @click.prevent="deleteItem($event,item_row,index_row)">
                                                                <i class="fa fa-times m-auto" style="color: red"></i>
                                                            </div>

                                                            <div v-if="item_row.coup_coeur == false" class="font-5xl m-auto d-flex align-items-center border" style="height: 80px; width: 80px; border-radius: 50%;background-color: #00800033;border-color: #cae4ca !important" @click.prevent="ajouterItem($event,item_row,index_row)">
                                                                <i class="fa fa-plus m-auto" style="color: green"></i>
                                                            </div>
                                                        </div>
-->