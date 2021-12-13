<div class="reserve">
    <div class="reserve__img">
        <img class="reserve__img__tag" src="{{ rootb }}/assets/img/exemplo de quarto.png" width="200px" alt="imagem do quarto">
        <div class="reserve__img__status reserve_status_js {% if '{{ checkout }}' === 'checkout'%}ch{% endif %} {% if '{$ reserves[forNumber]['room']['status'] $}' === 'Ocupado' %}bred{% endif %}" data-status="{$ reserves[forNumber]['room']['status'] $}" data-id="{$ reserves[forNumber]['room']['id'] $}">{$ reserves[forNumber]['room']['status'] $}</div>
        {% if '{{ checkout }}' === 'checkout'%}
        <a href="{{ rootb }}/adm/reserve/{$ reserves[forNumber]['id'] $}/remove" class="reserve__remove nolink bred" style="left: 50px; top: -15px">Remover</a>
        {% endif %}

    </div>
    <div class="reserve__desc">
        <h2 class="reserve__desc__title">Jenius Hotel Paulista</h2>
        <span class="reserve__desc__rooms">quarto duplo</span>
        <div class="reserve__desc__reserve">
            <p class="reserve__desc__reserve__group"><span class="reserve__desc__reserve__type">Pessoas: </span> <span class="reserve__desc__reserve__result"> {$ reserves[forNumber]['room']['people'] $} pessoas</span></p>
            <p class="reserve__desc__reserve__group"><span class="reserve__desc__reserve__type">Diaria: </span> <span class="reserve__desc__reserve__result"> {$ reserves[forNumber]['days'] $} dias</span></p>
            <p class="reserve__desc__reserve__group"><span class="reserve__desc__reserve__type">Local: </span> <span class="reserve__desc__reserve__result"> {$ reserves[forNumber]['room']['local'] $}</span></p>
            <p class="reserve__desc__reserve__group"><span class="reserve__desc__reserve__type">CPF/CNPJ: </span> <span class="reserve__desc__reserve__result"> {$ reserves[forNumber]['user']['cpf_cnpj'] $}</span></p>
        </div>
        <div class="reserve__desc__check">
            <div class="reserve__dev__check__group">
                <span class="reserve__desc__check__type">Check In</span>
                <span class="reserve__desc__check__in">{$ reserves[forNumber]['check_in'] $}</span>
            </div>
            <div class="reserve__dev__check__group">
                <span class="reserve__desc__check__type">Check Out</span>
                <span class="reserve__desc__check__out">{$ reserves[forNumber]['check_out'] $}</span>
            </div>
        </div>
    </div>
</div>