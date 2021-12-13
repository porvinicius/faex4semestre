<header class="header">
    <div class="header__content">
        <div class="logo">
            <a href="{{ rootb }}/"><img src="{{ rootb }}/assets/img/icons/LOGO JENIUS.png" class="header__content__logo"></a>
        </div>
        <ul class="header__content__list">
            {% if '{{ isLogged }}' == 'false' %}
            <li class="header__content__list__item"><a class="header__content__list__item__link" href="{{ rootb }}/login">Logar</a></li>
            {% endif %}
            {% if '{{ role }}' == 'ADM' %}
            <li class="header__content__list__item"><a class="header__content__list__item__link" href="{{ rootb }}/adm">Painel</a></li>
            {% endif %}
            {% if '{{ isLogged }}' == 1 %}
            <li class="header__content__list__item"><a class="header__content__list__item__link" href="{{ rootb }}/reserves">Minhas Reservas</a></li>
            <li class="header__content__list__item"><a class="header__content__list__item__link" href="{{ rootb }}/logout">Logout</a></li>
            {% endif %}
        </ul>
    </div>
</header>