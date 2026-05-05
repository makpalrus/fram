@php $locale = session()->get('locale', 'ru'); @endphp

<div class="lang-switcher">
    <a href="/lang/en" class="{{ $locale === 'en' ? 'active' : '' }}">EN</a>
    <a href="/lang/kz" class="{{ $locale === 'kz' ? 'active' : '' }}">KZ</a>
    <a href="/lang/ru" class="{{ $locale === 'ru' ? 'active' : '' }}">RU</a>
</div>