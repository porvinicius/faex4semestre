{% extends layout/adm %}

{% block title %}Reservas{% endblock %}

{% block head %}
    <style>
        .container_reserves {
          padding: 2rem;
          display: flex;
          flex-wrap: wrap;
        }

        @media (max-width: 500px) {
            .container_reserves {
              padding: .5rem;
            }
        }
    </style>

    <link rel="stylesheet" href="{{ rootb }}/assets/css/components/adm/reserve.css">
{% endblock %}

{% block body %}
<div class="container_reserves">


    {% for {{ number }} forNumber %}
        {% include components/adm/reserve %}
    {% endfor %}

</div>
{% endblock %}