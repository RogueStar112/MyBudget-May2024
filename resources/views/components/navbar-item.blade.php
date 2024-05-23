
<li class="flex nav-item m-1 relative justify-around" style="background-color: {{ $color }};">
    <a class="nav-link flex relative justify-around w-full" aria-current="page" href="{{ $url }}"><i class="fas fa-{{ $icon }}"></i><p></p><div class="collapse md:visible label-bottom">{{ $title }}</div>
    
        <span class="visible md:invisible">{{ $title }}</span>

    </a>
</li>