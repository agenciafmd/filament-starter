@props([
'color' => '',
'swiperButtonClass' => 'hstack gap-2 justify-content-center',
'swiperButtonElementClass' => '',
'swiperPaginationCustomClassElement' => '',
])
<div class="{{ $swiperButtonClass }} pe-none">
    <div class="swiper-button-prev pe-auto {{ $color }} {{ $swiperPaginationCustomClassElement ? $swiperPaginationCustomClassElement . '-prev' : '' }} {{ $swiperButtonElementClass }}">
        <div class="position-relative">
            <x-icon
                    name="frontend-ic-ui-arrow-right"
                    class="ic {{ $color }} ic-inverse-x ic-slider-button-disabled"
            />
        </div>
    </div>
    <div class="swiper-button-next pe-auto {{ $color }} {{ $swiperPaginationCustomClassElement ? $swiperPaginationCustomClassElement . '-next' : '' }} {{ $swiperButtonElementClass }}">
        <div class="position-relative">
            <x-icon
                    name="frontend-ic-ui-arrow-right"
                    class="ic {{ $color }}"
            />
        </div>
    </div>
</div>
