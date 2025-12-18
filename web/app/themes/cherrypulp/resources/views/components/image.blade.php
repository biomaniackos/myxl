{{--
@example Give a width to adjust the height of image
<div class="w-96">
  <x-image
      image="https://pixabay.com/get/g3b015eccf776a5dbd497250775cdfaeb9846ad5b6f2828a69ae591385ad13fa5344f02279549c74909e2d1429158af0f3565a3384da23ed1ff7fcd9f5b8a26d132cdc60aad5e4795970a71d990e82d6b_640.jpg"
      image-aspect-ratio="16:9" // Aspect Ratio 1:1, 4:3, 2:1
  />
</div>
--}}
<div
    class="relative border border-gray-100 overflow-hidden {{ $rounded ? 'rounded-md' : '' }} {{ $classes }}"
    @if ($aspectRatio)
        style="{{ $aspectRatio }}"
    @endif
>
    @if ($image)
        <img
            alt="{{ $alt }}"
            class="absolute object-cover h-full w-full"
            data-src="{{ $image }}"
            loading="lazy"
            onload="if(this.src !== this.getAttribute('data-src')) this.src=this.getAttribute('data-src');"
            src="{{ $defaultImage }}"

            @if (! is_null($srcsets))
                sizes="{{ $sizes }}"
                srcset="{{ $srcsets }}"
            @endif
        />
    @else
        <img
            alt="{{ $alt }}"
            class="absolute object-cover h-full w-full"
            loading="lazy"
            src="{{ $defaultImage }}"
        />
    @endif
</div>
