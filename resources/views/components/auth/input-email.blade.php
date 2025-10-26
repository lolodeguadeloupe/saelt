@props(['email' => ''])

<div class="input-group mb-3">
    <input type="email" class="form-control" placeholder="@lang('Email')" id="email"
           name="email" autofocus required
           value="{{ old('email', $email) }}">
    <div class="input-group-append">
        <div class="input-group-text">
            <span class="fas fa-envelope"></span>
        </div>
    </div>
</div>
