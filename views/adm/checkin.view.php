{% extends layout/adm %}

{% block title %}Check In{% endblock %}

{% block head %}
<!--    <link rel="stylesheet" href="">-->
    <style>
        .container form {
          display: flex;
          width: 100%;
          max-width: 500px;
          flex-direction: column;
          margin: auto;
          text-align: center;
        }

        .container h1 {
          font-size: 3rem;
          font-weight: bold;
          color: white;
          margin: 3rem 0;
        }

        .container .gorup-input-button {
          display: flex;
          width: 100%;
          flex-wrap: wrap;
        }

        .gorup-input-button input {
          padding: .8rem;
          border-radius: 5px;
          outline: none;
          border: none;
        }

        .gorup-input-button #search {
          width: 19rem;
        }

        .btn {
          margin-left: 2rem;
            width: 8rem;
          cursor: pointer;
          font-size: 1.3rem;
          background-color: white;
        }

        .label {
          position: absolute;
          color: rgba(0,0,0,.5);
        }

        .content {
          width: fit-content;
          margin: 3rem auto;
        }

        .error-tt- {
          display: none;
        }

        .error-tt-true {
          display: block;
          padding: 1rem;
          background-color: white;
          margin: auto;
          border-radius: 5px;
        }

        .status-success {
          width: 100px;
          margin: 1rem auto;

        }
    </style>

    <link rel="stylesheet" href="{{ rootb }}/assets/css/components/adm/reserve.css">
{% endblock %}

{% block body %}
  <div class="container">
      <form action="{{ rootb }}/adm/checkin" method="get">
          <h1>Check In</h1>
          <div class="gorup-input-button">
              <label class="label" for="search">cpf/cnpj</label>
              <input type="text" id="search" name="search">
              <input type="submit" class="btn" value="Buscar">
          </div>
          <div class="messages"></div>
      </form>

      <div class="content">
          {% for {{ number }} forNumber %}
            {% include components/adm/reserve %}
          {% endfor %}

          <div class="error-tt-{{ status }}">
                {{ message }}
          </div>
      </div>
  </div>
{% endblock %}

{% block script %}
    <script>
        let root = '{{ rootb }}';
    </script>
    <script src="{{ rootb }}/assets/js/components/reserve.js"></script>
{% endblock %}
