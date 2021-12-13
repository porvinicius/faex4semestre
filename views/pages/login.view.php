{% extends layout/default %}


{% block title %}Login{% endblock %}

{% block head %}
    <link rel="stylesheet" href="{{ rootb }}/assets/css/pages/login.css">
    <link rel="stylesheet" href="{{ rootb }}/assets/css/components/form.css">
{% endblock %}

{% block body %}
<div class="login">
    <div class="container">
        <div class="content">
            <form action="{{ rootb }}/login" method="post">

                <div class="profile">
                    <div class="image"><i class="fas fa-user-circle"></i></div>
                    <p>LOGIN</p>
                </div>
                {% include components/status %}
                <div class="form_input">
                    <label for="">CPF:</label>
                    <input name="cpf_cnpj" required type="text">
                    <span class="form_error"></span>
                </div>
                <div class="form_input">
                    <label for="pass">Password:</label>
                    <input id="pass" name="password" required type="password">
                    <span class="form_error"></span>
                </div>
                <a href="{{ rootb }}/register" class="form_has">Não tenho conta.</a>
                <input type="submit" class="form_button" value="LOGIN">
            </form>
        </div>

        <div class="photo" style="background-image: url('{{ rootb }}/assets/img/tela_do_login.png')">
        </div>
    </div>
</div>

{% endblock %}

{% block script %}
    <script src="{{ rootb }}/assets/js/components/validation.js"></script>
    <script>
        new ValidationForm(false);
    </script>
{% endblock %}
