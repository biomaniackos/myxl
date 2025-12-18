@php
    $email = get_field('email', 'option') ?? get_bloginfo('admin_email');
    $wave = $wave ?? true;
@endphp
<section class="contact-us @if($wave !== 'no') wave wave-top @endif">
<h2>Des questions ? <br class="md:hidden"><a href="mailto:{{ $email }}"><span>Contactez-nous</span></a></h2>
</section>