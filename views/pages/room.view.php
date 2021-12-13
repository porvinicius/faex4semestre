{% extends layout/site %}

{% block title %}Quarto {{ room[0]->name }}{% endblock %}

{% block head %}
<link rel="stylesheet" href="{{ rootb }}/assets/css/pages/room.css">
<style>
    .status-geral {
      margin: 1rem 0;
      color: black;
    }
</style>
{% endblock %}

{% block body %}
 <div class="container">
   <div class="content">
     <div class="product__image">
       <img src="{{ rootb }}/assets/img/exemplo de quarto.png" alt="produto">
     </div>
     <div class="details">
       <h2>Quarto {{ room[0]->name }} Hotel Jenius</h2>
       <span class="price">{{ room[0]->price }}R$</span><br><span>por dia</span>
       <form class="fill" action="{{ rootb }}/reserves/room/{{ room[0]->id }}/add" method="post">
           <div class="group">
               <label for="checkin">Check In:</label>
               <input required type="date" name="checkin">
           </div>
           <div class="separetor"></div>
           <div class="group">
               <label for="checkin">Check Out:</label>
               <input required type="date" name="checkout">
           </div>
           {% include components/status %}
           <input class="btn_reservar" type="submit" value="Reservar">
       </form>

       <div class="dec">
         <h3>Description</h3>
           <p><span>Nome: </span> <span> {{ room[0]->name }}</span></p>
           <p><span>Pessoas: </span> <span> {{ room[0]->people }} pessoas</span></p>
           <p><span>Preço por dia: </span> <span> {{ room[0]->price }}R$</span></p>
       </div>
     </div>
   </div>
 </div>
{% endblock %}

{% block script %}
{% endblock %}