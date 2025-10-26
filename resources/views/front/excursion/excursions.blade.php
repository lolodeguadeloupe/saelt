@extends('front.layouts.layout')

@push('after-blocks-css')

@endpush

@push('after-script-js')

@endpush

@section('title', trans('front-excursion.titre'))

@section('content')

<section class="banner page banner-overlay background-cover bg-dark pb-5 position-relative pt-5 text-white" style="background-image: {{'url(\''.asset('/assets/img/maldives.jpg').'\')'}};">
    <div class="container mt-5 pt-4">
        <div class="row">
            <div class="col-md">
                <h1 class="text-uppercase">{{trans('front-excursion.titre')}}</h1>
            </div>
        </div>
    </div>
</section>
<hebergement-ile :url="'{{route('excursions')}}'" :urlbase="'{{base_url('')}}'" :urlasset="'{{asset('')}}'" :data="{{$data->toJson()}}" :aside="{{$aside}}" :sessionrequest="{{$session_request}}" :keysessionrequest="'{{app('request')->has('key_')?app('request')->key_:''}}'" inline-template>
    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4 py-3" v-for="(item,index) in collection">
                    <div class="align-items-center background-center-center background-cover d-flex h-100 justify-content-center px-2 py-5" :style="'background-image: url(\''+(item.background_image? $isBase64(item.background_image)?item.background_image:`${urlasset}/${item.background_image}`: '{{asset('/assets/img/Guadeloupe.jpg')}}' )+'\')'">
                        <div>
                            <a @contextmenu.prevent="" @click.prevent="managerRequest($event,'{{ route('excursion-all-products') }}',{ile:item.id})" href="#" class="text-center text-decoration-none text-white">
                                <div>
                                    <img :src="item.card? $isBase64(item.card)?item.card:`${urlasset}/${item.card}` : '{{asset('/assets/img/Guadeloupe_location_map-1-110x100.png')}}'" class="map-white mx-auto">
                                    <div>
                                        <h3 class="text-shadow">@{{item.name}}</h3>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</hebergement-ile>

@endsection