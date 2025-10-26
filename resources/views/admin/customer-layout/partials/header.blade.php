<div id="app_nav" style="display: contents;">
    <nav class="main-header navbar navbar-expand navbar-white navbar-light" style="z-index: 99;">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
            <!--<li class="nav-item d-none d-sm-inline-block">
                <a href="index3.html" class="nav-link">Home</a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="#" class="nav-link">Contact</a>
            </li>-->
        </ul>
        <ul class="nav navbar-nav ml-auto">
            <!--<li class="d-flex align-items-center position-relative justify-content-center nav-item dropdown">
                <div class="spinner-grow text-success" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                <div class="dropdown-toggle no-carret d-flex align-items-center h-100 justify-content-center left-0 position-absolute top-0 w-100">
                    <i class="fa fa-bell font-xl text-primary"></i>
                    <span class="text-success position-absolute top-0 right-0 mr-1 font-weight-bold">2</span>
                </div>
                <div class="dropdown-menu dropdown-menu-right">
                    <div class="dropdown-header text-center"><strong>{{ trans('admin-base.notification.title') }}</strong></div>
                    <div style="width: 300px;max-height: 400px;overflow: auto;">
                        <a href="#" class="dropdown-item text-wrap">
                            <p>
                                <i class="fa fa-ellipsis-h"></i>
                                We use this extra class to reduce the horizontal padding
                                on either side of the caret by 25% and remove the margin-left
                                that’s added for regular button dropdowns. Those extra changes
                                keep the caret centered in the split button and provide a more
                                appropriately sized hit area next to the main button.
                            </p>
                        </a>
                        <a href="#" class="dropdown-item text-wrap">
                            <p>
                                <i class="fa fa-ellipsis-h"></i>
                                We use this extra class to reduce the horizontal padding
                                on either side of the caret by 25% and remove the margin-left
                                that’s added for regular button dropdowns. Those extra changes
                                keep the caret centered in the split button and provide a more
                                appropriately sized hit area next to the main button.
                            </p>
                        </a>
                        <a href="#" class="dropdown-item text-wrap">
                            <p>
                                <i class="fa fa-ellipsis-h"></i>
                                We use this extra class to reduce the horizontal padding
                                on either side of the caret by 25% and remove the margin-left
                                that’s added for regular button dropdowns. Those extra changes
                                keep the caret centered in the split button and provide a more
                                appropriately sized hit area next to the main button.
                            </p>
                        </a>
                        <a href="#" class="dropdown-item text-wrap">
                            <p>
                                <i class="fa fa-ellipsis-h"></i>
                                We use this extra class to reduce the horizontal padding
                                on either side of the caret by 25% and remove the margin-left
                                that’s added for regular button dropdowns. Those extra changes
                                keep the caret centered in the split button and provide a more
                                appropriately sized hit area next to the main button.
                            </p>
                        </a>
                    </div>
                </div>
            </li>-->
            <li class="nav-item dropdown">
                <a role="button" class="dropdown-toggle no-carret nav-link pt-0 pb-0">
                    <span>
                        @if(Auth::check() && Auth::user()->avatar_thumb_url)
                        <img src="{{ Auth::user()->avatar_thumb_url }}" class="avatar-photo">
                        @elseif(Auth::check() && Auth::user()->first_name && Auth::user()->last_name)
                        <span class="avatar-initials">{{ mb_substr(Auth::user()->first_name, 0, 1) }}{{ mb_substr(Auth::user()->last_name, 0, 1) }}</span>
                        @elseif(Auth::check() && Auth::user()->name)
                        <span class="avatar-initials">{{ mb_substr(Auth::user()->name, 0, 1) }}</span>
                        @elseif(Auth::guard(config('admin-auth.defaults.guard'))->check() && Auth::guard(config('admin-auth.defaults.guard'))->user()->first_name && Auth::guard(config('admin-auth.defaults.guard'))->user()->last_name)
                        <span class="avatar-initials">{{ mb_substr(Auth::guard(config('admin-auth.defaults.guard'))->user()->first_name, 0, 1) }}{{ mb_substr(Auth::guard(config('admin-auth.defaults.guard'))->user()->last_name, 0, 1) }}</span>
                        @else
                        <span class="avatar-initials"><i class="fa fa-user"></i></span>
                        @endif

                        @if(!is_null(config('admin-auth.defaults.guard')))
                        <span class="hidden-md-down">{{ Auth::guard(config('admin-auth.defaults.guard'))->check() ? Auth::guard(config('admin-auth.defaults.guard'))->user()->full_name : 'Anonymous' }}</span>
                        @else
                        <span class="hidden-md-down">{{ Auth::check() ? Auth::user()->full_name : 'Anonymous' }}</span>
                        @endif

                    </span>
                    <span class="caret"></span>
                </a>
                @if(View::exists('admin.layout.profile-dropdown'))
                @include('admin.layout.profile-dropdown')
                @endif
            </li>
        </ul>

    </nav>
</div>