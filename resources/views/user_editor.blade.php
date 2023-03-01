<!DOCTYPE HTML>
<html>

<head>
    <meta charset="utf-8"/>
    <title>Пользователь №{{ $edit_user->id }}</title>
</head>
    <h2>Пользователь</h2>
    <table border="1">
        <tr>
            <th>ID позьзователя</th> <td> {{ $edit_user->id }} </td>
        </tr><tr>
            <th>Фамилия</th> <td> {{ $edit_user->last_name}} </td>
        </tr><tr>
            <th>Имя</th> <td> {{ $edit_user->first_name}} </td>
        </tr><tr>
            <th>Отчество</th> <td> {{ $edit_user->middle_name }} </td>
        </tr><tr>
            <th>Имя пользователя</th> <td> {{ $edit_user->name}} </td>
        </tr><tr>
            <th>Email</th> <td> {{ $edit_user->email}} </td>
        </tr><tr>
            <th>Дата создания</th> <td> {{ $edit_user->created_at }} </td>
        </tr><tr>
            <th>Дата изменения</th> <td> {{ $edit_user->updated_at }} </td>
        </tr>
    </table>
    <h2>Редактируемые параметры</h2>
    <form action="/save/user" method="POST">
        @csrf
        <input value="{{ $edit_user->id }}" required="" type="hidden" id="id" name="id">
        <label for="last_name">Фамилия</label> <br>
            <input value="{{ $edit_user->last_name}}" type="text" id="last_name" name="last_name" required> <br>
            <label for="first_name">Имя</label> <br>
            <input value="{{ $edit_user->first_name}}" type="text" id="first_name" name="first_name" required> <br>
            <label for="middle_name">Отчество</label> <br>
            <input value="{{ $edit_user->middle_name }}" type="text" id="middle_name" name="middle_name" required> <br>
            <label for="username">Имя пользователя</label> <br>
            <input value="{{ $edit_user->name}}" type="text" id="username" name="name" required> <br>
            <label for="email">Email</label> <br>
            <input value="{{ $edit_user->email}}" type="email" id="email" name="email" required> <br>
        <input type="submit" value="Сохранить"/>
    </form>
    <h2>Действия</h2>
    <form action="/delete/user" method="POST">
        @csrf
        <input value="{{ $edit_user->id }}" required="" type="hidden" id="id" name="id">
        <input type="submit" value="Удалить"/>
    </form>
</html>