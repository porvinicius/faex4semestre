{% extends layout/adm %}

{% block title %}Quartos{% endblock %}

{% block head %}
<style>
  .container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100%;
  }

  .container h1 {
    color: white;
    text-align: center;
    font-weight: bold;
    font-size: 2rem;
  }

  .room_list {
    display: flex;
    flex-wrap: wrap;
  }

  .linkno {
    display: block;
    text-decoration: none;
    color: black;
  }

  .room {
    display: block;
    text-decoration: none;
    color: black;
    margin: 1rem;
    background-color:white;
    border-radius:8px;
    padding: 1rem;
    position: relative;
  }

  .room__img__status {
    display: block;
    position: absolute;
    top: 170px;
    left: 35%;
    margin: auto;
    width: fit-content;
    background: limegreen;
    padding: .5rem;
    border-radius: 5px;
    color: white;
    cursor: pointer;
  }


  .room .room__desc {

  }

  .room__desc__title {
    margin: 1rem 0;
  }

  .room__desc__room__group {
    margin: .5rem 0;
  }

  .btn {
    display: inline-block;
    width: fit-content;
    text-decoration: none;
    border-radius: 8px;
    border: none;
    padding: .5rem;
    cursor: pointer;
    color: white;
  }

  .destroy {
    background-color: red;
  }

  .edit {
    background-color: blue;
  }

  .status-success {
    width: fit-content;
    margin: 1rem auto;
  }

  .status-error {
    width: fit-content;
    margin: 1rem auto;
  }
</style>
{% endblock %}

{% block body %}
<div class="container">
    <div class="content">
        <h1>Quartos</h1>
        {% include components/status %}
        <div class="room_list">
            {% for {{ count }} roomFor %}
            <a href="{{ rootb }}/room/{$ rooms[roomFor]->id $}/" class="linkno">
                <div class="room">
                    <div class="room__img">
                        <img class="room__img__tag" src="{{ rootb }}/assets/img/exemplo de quarto.png" width="200px" alt="imagem do quarto">
                        <div class="room__img__status reserve_status_js {% if '{$ rooms[roomFor]->status $}' === 'Ocupado' %}bred{% endif %}" data-status="{$ rooms[roomFor]->status $}" data-id="{$ rooms[roomFor]->id $}">{$ rooms[roomFor]->status $}</div>
                    </div>
                    <div class="room__desc">
                        <h2 class="room__desc__title">Jenius Hotel Paulista</h2>
                        <div class="room__desc__reserve">
                            <p class="room__desc__room__group"><span class="room__desc__room__type">Nome: </span> <span class="room__desc__room__result"> {$ rooms[roomFor]->name $}</span></p>
                            <p class="room__desc__room__group"><span class="room__desc__reserve__type">Pessoas: </span> <span class="reserve__desc__reserve__result"> {$ rooms[roomFor]->people $} pessoas</span></p>
                            <p class="room__desc__room__group"><span class="room__desc__reserve__type">Preço: </span> <span class="reserve__desc__reserve__result"> {$ rooms[roomFor]->price $}R$</span></p>
                        </div>
                    </div>
                    <div class="room__actions">
                        <a href="{{ rootb }}/adm/room/{$ rooms[roomFor]->id $}/remove" class="btn destroy">Remover</a>
                        <a href="{{ rootb }}/adm/room/{$ rooms[roomFor]->id $}/edit" class="btn edit">Editar</a>
                    </div>
                </div>
            </a>
            {% endfor%}
        </div>
    </div>
</div>
{% endblock %}

{% block script %}
{% endblock %}
