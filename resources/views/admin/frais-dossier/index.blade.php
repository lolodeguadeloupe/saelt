@extends('admin.customer-layout.layout.default')

@section('title', trans('admin.frais-dossier.title'))

@section('body')

<frais-dossier-listing :data="{{ $data->toJson() }}" :url="'{{ url('admin/frais-dossiers') }}'" :action="'{{ url('admin/frais-dossiers') }}'" :urlbase="'{{base_url('')}}'" :urlasset="'{{asset('')}}'" inline-template>
    <diV style="display:contents; position:relative">
        <div class="row">
            <div class="col">
                <div class="card position-relative">
                    <div class="card-header">
                        <h3>Info supplémentaire</h3>
                    </div>
                    <div class="card-body" v-cloak>
                        <div class="card-block">
                            <div class="row">
                                <div class="col-12">
                                    <form action="#" class="d-flex align-items-center">
                                        <div><i class="fa fa-ticket"></i> &nbsp;<span class="font-italic">Frais de dossier</span></div>
                                        <div class="mr-0 ml-auto">
                                            <i class="text-info fa fa-pencil"></i>
                                            <i class="text-success fa fa-save"></i>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </diV>
</frais-dossier-listing>

@endsection