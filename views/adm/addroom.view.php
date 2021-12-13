{% extends layout/adm %}

{% block title %}Form Quarto{% endblock %}

{% block head %}
<link rel="stylesheet" href="{{ rootb }}/assets/css/components/form.css">

<style>
    .container {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100%;
      padding: 3rem 0;
    }

    .content {
      color: white;

    }

    .content h2 {
      text-align: center;
      font-weight: bold;
      font-size: 2rem;
      margin-bottom: 3rem;
    }

    input.form_button {
      margin: auto;
    }

</style>
{% endblock %}

{% block body %}
<div class="container">
    <form action="{{ rootb }}/adm/rooms/{{ action }}" method="post" class="content">
        <h2>{{ title }}</h2>
        {% include components/status %}
        <div class="form_input">
            <label for="">nome:</label>
            <input name="nome" value="{{ room[0]->name }}" required type="text">
            <span class="form_error"></span>
        </div>
        <div class="form_input">
            <label for="">Pessoas:</label>
            <input name="pessoas" value="{{ room[0]->people }}" required type="number" max="5" min="2">
            <span class="form_error"></span>
        </div>
        <div class="form_input">
            <label for="">Local:</label>
            <input name="local" value="{{ room[0]->local }}" required type="text">
            <span class="form_error"></span>
        </div>
        <div class="form_input">
            <label for="">Preço por dia:</label>
            <input name="price" value="{{ room[0]->price }}" required type="text">
            <span class="form_error"></span>
        </div>
        <div class="form_input">
            <label for="">Status:</label>
            <input name="status" value="{{ room[0]->status }}" required type="text">
            <span class="form_error"></span>
        </div>

        <input type="submit" class="form_button" value="Enviar">
    </form>
</div>
{% endblock %}

{% block script %}
<script src="{{ rootb }}/assets/js/components/validation.js"></script>
<script>
    new ValidationForm(false);
</script>
{% endblock %}

