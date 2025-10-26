<li class="nav-item {{ $open }}">
    <a href="#" class="nav-link {{ $active }}">
        <i class="nav-icon {{ $icon }}"></i>
        <p>
            {{ $label }}
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        @foreach($items as $item)
            <x-back.menu-item route="{{ $item['route'] }}" icon="{{ $item['icon'] ?? null }}" label="{{ $item['label'] }}"/>
        @endforeach
    </ul>
</li>
