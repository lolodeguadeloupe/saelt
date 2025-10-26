<div class="dropdown-menu dropdown-menu-right">
    <div class="dropdown-header text-center"><strong>{{ trans('admin-base.profile_dropdown.account') }}</strong></div>
    <a href="{{ url('admin/profile') }}" class="dropdown-item"><i class="fa fa-user"></i>  {{ trans('admin-base.profile_dropdown.profile') }}</a>
    <a href="{{ url('admin/password') }}" class="dropdown-item"><i class="fa fa-key"></i>  {{ trans('admin-base.profile_dropdown.password') }}</a>
    {{-- Do not delete me :) I'm used for auto-generation menu items --}}
    <a href="{{ url('admin/logout') }}" class="dropdown-item"><i class="fa fa-lock"></i> {{ trans('admin-base.profile_dropdown.logout') }}</a>
</div>