{% extends layout/site %}

{% block title %}Hotel Jenius{% endblock %}

{% block head %}
<link rel="stylesheet" href="{{ rootb }}/assets/css/components/pages/carrossel.css">
<link rel="stylesheet" href="{{ rootb }}/assets/css/pages/home.css">
{% endblock %}

{% block body %}

    <div class="container">
        {% include components/pages/carrossel %}

        <div class="content">
            <h2 class="content__title">Nossos Melhores quartos</h2>

            <div class="room__list">
                {% for {{ countRoom }} cRoom %}
                    <a href="{{ rootb }}/room/{$ rooms[cRoom]->id $}" class="room">
                        <div class="room__img">
                            <img class="room__img__tag" src="{{ rootb }}/assets/img/exemplo de quarto.png" width="200px" alt="imagem do quarto">
                        </div>
                        <div class="room__desc">
                            <h2 class="room__desc__title">Jenius Hotel Paulista</h2>
                            <div class="room__desc__reserve">
                                <p class="room__desc__room__group"><span class="room__desc__room__type">Nome: </span> <span class="room__desc__room__result"> {$ rooms[cRoom]->name $}</span></p>
                                <p class="room__desc__room__group"><span class="room__desc__reserve__type">Pessoas: </span> <span class="reserve__desc__reserve__result"> {$ rooms[cRoom]->people $} pessoas</span></p>
                            </div>
                        </div>
                    </a>
                {% endfor %}
            </div>
        </div>

    </div>
{% endblock %}

{% block script %}
<script src="{{ rootb }}/assets/js/components/pages/carrossel.js"></script>
{% endblock %}

