@extends('admin.customer-layout.layout.master')

@section('header')
@include('admin.customer-layout.partials.header')
@endsection

@section('content')

<div class="app-body">

    @if(View::exists('admin.layout.sidebar'))
    @include('admin.layout.sidebar')
    @endif

    <div class="content-wrapper main" id="app"> 
        <layout-header-listing :liens="{{json_encode(session('utilisateur_liens', []))}}" inline-template>
            <div class="content-header">
                <!-- here -->
                <div v-if="liens.parent" class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-12">
                            <ol class="breadcrumb float-sm-left">
                                <li class="breadcrumb-item" :class="liens.parent.class">
                                    <a :href=" (liens.childres && liens.childres.length>0)?liens.parent.href:'#'">@{{liens.parent.name}}</a>
                                </li>
                                <li v-for="(_lien, index) in liens.childres" class="breadcrumb-item" :class="_lien.class"><a :href="_lien.href">@{{_lien.name}}</a></li> <!--<a :href="(index == liens.childres.length-1)?'#':_lien.href">-->
                            </ol>
                        </div>
                    </div>
                </div> 
                <!-- -->
            </div>
        </layout-header-listing>

        <div class="container-fluid" id="custom-app-style" :class="{'loading': loading}">

            <div class="content">
                <section class="content">
                    <div class="container-fluid">
                        @yield('body')
                    </div>
                </section>
            </div>
            <div class="modals">
                <v-dialog />
            </div>
            <div> 
                <notifications position="bottom right" :duration="2000" />
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer')
@include('admin.customer-layout.partials.footer')
@endsection

@section('bottom-scripts')
@parent
@endsection