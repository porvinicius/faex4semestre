{% extends layout/default %}

{% block title %}Registro de usuario{% endblock %}

{% block head %}
    <link rel="stylesheet" href="{{ rootb }}/assets/css/pages/register.css">
    <link rel="stylesheet" href="{{ rootb }}/assets/css/components/form.css">
{% endblock %}

{% block body %}
    <div class="container">
        <div class="content">
            <form action="{{ rootb }}/register" method="post" class="form_register">
                <h1>Registro</h1>
                {% include components/status %}
                <div class="core_input">
                    <div class="form_group">
                        <div class="form_input input_name">
                            <label for="">Nome</label>
                            <input required type="text" name="name">
                            <span class="form_error"></span>
                        </div>
                        <div class="form_input input_birthday">
                            <label for="">Data de aniversario</label>
                            <input required type="date" name="birthday">
                            <span class="form_error"></span>
                        </div>
                    </div>
                    <div class="form_group">
                        <div class="form_input input_rg">
                            <label for="">RG</label>
                            <input required name="rg" type="text">
                            <span class="form_error"></span>
                        </div>
                        <div class="form_input input_cpf_cnpj">
                            <label for="">CPF/CNPJ</label>
                            <input required name="cpf_cnpj" type="text">
                            <span class="form_error"></span>
                        </div>
                    </div>
                    <div class="form_group">
                        <div class="form_input input_cep">
                            <label for="">CEP</label>
                            <input required name="cep" type="text">
                            <span class="form_error"></span>
                        </div>
                        <div class="form_input input_streat_number">
                            <label for="">N° da rua</label>
                            <input required name="street_number" type="text">
                            <span class="form_error"></span>
                        </div>
                    </div>
                    <div class="form_group">
                        <div class="form_input">
                            <label for="">Telefone</label>
                            <input required name="phone_number" type="text">
                            <span class="form_error"></span>
                        </div>
                        <div class="form_input">
                            <label for="">WhatsApp</label>
                            <input required name="whatsapp_number" type="text">
                            <span class="form_error"></span>
                        </div>
                    </div>
                    <div class="form_input">
                        <label for="">Email</label>
                        <input required name="email" type="email">
                        <span class="form_error"></span>
                    </div>
                    <div class="form_input">
                        <label for="">Senha</label>
                        <input required name="password" type="password">
                        <span class="form_error"></span>
                    </div>
                    <div class="form_input">
                        <label for="">Confirma Senha</label>
                        <input required class="confirm" type="password">
                        <span class="form_error"></span>
                    </div>
                    <a href="{{ rootb }}/login" class="form_has">já tenho login</a>
                </div>
                <input type="submit" value="Registrar" class="form_button">
            </form>
        </div>
    </div>
{% endblock %}

{% block script %}
<script src="{{ rootb }}/assets/js/components/validation.js"></script>
<script>
    new ValidationForm(false, {
        confirmPass: (field) => {
            if (field.type === 'password' && field.classList.contains('confirm')) {
                const pass = document.querySelectorAll('input[type=password]');
                if (pass[0].value !== pass[1].value) {
                    return true;
                }
            }
            return false;
        }
    }, {
        confirmPass: (field) => 'As senhas não se condizem'
    });
</script>
{% endblock %}