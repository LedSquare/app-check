@props([
    'route' => '#',
    'class' => 'link',
])

<a class="{{ $class }}" href="{{ $route != '#' ? route($route) : $route }}">
    {{ $slot }}
</a>
