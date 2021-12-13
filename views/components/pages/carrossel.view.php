<div id="items-wrapper">
  <div id="items" data-count="{{ countRoom }}">
      {% for {{ countRoom }} roomFor %}
          <a href="{{ rootb }}/room/{$ rooms[roomFor]->id $}" class="item">
              <div class="img" style="background-image: url('{{ rootb }}/assets/img/home 8.png');">
                  <div class="desc">
                      <h2>Quarto: {$ rooms[roomFor]->name $}</h2>
                      <p><span>Numero de pessoas: </span> {$ rooms[roomFor]->people $} pessoas</p>
                    <p><span>Localidade: </span> {$ rooms[roomFor]->local $}</p>
                </div>
              </div>
          </a>
      {% endfor %}
    </div>
</div>