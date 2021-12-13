<!doctype html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
  <link rel="stylesheet" href="{{ rootb }}/assets/css/components/pages/header.css">
  <link rel="stylesheet" href="{{ rootb }}/assets/css/global.css">
  <script src="https://kit.fontawesome.com/9dfe5f8b66.js" crossorigin="anonymous"></script>
  <title>{% block title %}{% endblock %}</title>
  {% block head %}{% endblock %}

</head>
<body>

{% include components/pages/header %}

{% block body %}{% endblock %}

{% block script %}{% endblock %}
</body>
</html>
