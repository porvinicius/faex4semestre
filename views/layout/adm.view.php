<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
    <link rel="stylesheet" href="{{ rootb }}/assets/css/global.css">
    <link rel="stylesheet" href="{{ rootb }}/assets/css/components/adm/header.css">
    <link rel="stylesheet" href="{{ rootb }}/assets/css/components/adm/menu.css">
    <script src="https://kit.fontawesome.com/9dfe5f8b66.js" crossorigin="anonymous"></script>
    <title>{% block title %}{% endblock %}</title>

    {% block head %}{% endblock %}

    <style>
        body {
          height: 100%;
          min-height: 100vh;
          display: flex;
          flex-direction: column;
        }

        .container_layout {
            display: flex;
          flex-grow: 1;
            width: 100%;
        }

        .content_layout {
          background-color: #003469;
          width: 100%;
          flex-grow: 1;
          overflow: hidden;
        }
    </style>

</head>
<body>

    {% include components/adm/header %}

    <div class="container_layout">

        {% include components/adm/menu %}

        <div class="content_layout other_active">
            {% block body %}{% endblock %}
        </div>

    </div>
    <script src="{{ rootb }}/assets/js/components/mobile-navbar.js"></script>
    <script>
        new MobileNavbar('#bars', ['.menu_adm', '.other_active'], '.menu_adm__list');
    </script>
    {% block script %}{% endblock %}
</body>
</html>