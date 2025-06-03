<header class="flex-c">

<div>
    <nav>

        <ul>
            <li><x-link>Домой</x-link></li>
            <li><x-link>Контакты</x-link></li>
        </ul>

        {{-- TODO: Удалить, временный блок --}}
        @if ($user = auth()->user())
            <div style="display: flex;" class="flex-c"> Пользователь:{{" $user->firstname $user->lastname "}} </div>
        @endif

        <ul class="auth-ul">

            <li>
                {{-- TODO: Добавить разные роуты --}}
                <x-link route='login'>Личный кабинет</x-link>
            </li>
        </ul>
    </nav>
</div>

</header>
