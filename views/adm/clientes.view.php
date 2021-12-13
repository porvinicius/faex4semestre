{% extends layout/adm %}


{% block title %}Clientes{% endblock %}

{% block head %}
<style>

    .container {
        padding: 1rem;
    }

    .clients {
      background-color:white;
      padding: 1rem;
      margin: 5rem;
      width: fit-content;
      border-radius: 5px;
    }

    .clients h2 {
      line-height: 1.5;
    }

    .clients .image {
      font-size: 3rem;
      margin: 1rem auto;
      width: fit-content;
      color: rgba(0, 0, 0,.5);
    }
</style>
{% endblock %}

{% block body %}
<div class="container">
  {% for {{ clientsNumber }} clFor %}
    <div class="clients">
      <div class="image"><i class="fas fa-user"></i></div>
      <h2>Nome: {$ clients[clFor]->name $}</h2>
      <h2>Cpf/Cnpj: {$ clients[clFor]->cpf_cnpj $}</h2>
      <h2>Email: {$ clients[clFor]->email $}</h2>
      <h2>Número de telefone: {$ clients[clFor]->phone_number $}</h2>
      <h2>rg: {$ clients[clFor]->rg $}</h2>
      <h2>Cep: {$ clients[clFor]->cep $}</h2>
      <h2>Cargo: {$ clients[clFor]->role $}</h2>
    </div>
  {% endfor %}
</div>
{% endblock %}

{% block script %}
{% endblock %}
