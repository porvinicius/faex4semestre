{% extends layout/site %}

{% block title %}Minhas reservas{% endblock %}

{% block head %}
<link rel="stylesheet" href="{{ rootb }}/assets/css/components/adm/reserve.css">
<style>
  .content {
    width: fit-content;
    margin: auto;
  }

  h1 {
    text-align: center;
    font-size: 2.3rem;
    font-weight: bold;
    margin: 3rem;
  }

    .reserve {
      border-radius: 8px;
      border: 1px solid rgba(0,0,0,.1);
      box-shadow: 2px 2px 10px rgba(0,0,0,.1);
    }
</style>
{% endblock %}

{% block body %}
<div class="container">
    <h1>Minhas Reservas</h1>
    <div class="content">
        {% for {{ number }} forNumber %}
        {% include components/adm/reserve %}
        {% endfor %}
    </div>
</div>
{% endblock %}

{% block script %}
{% endblock %}
