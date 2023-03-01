<!DOCTYPE HTML>
<html>

<head>
    <meta charset="utf-8"/>
    <title>Изменение задачи №{{ $task->id }}</title>
</head>
    <h2>Задание</h2>
    <table border="1">
        <tr>
            <th>ID задачи</th> <td> {{ $task->id }} </td>
        </tr><tr>
            <th>Название</th> <td> {{ $task->title }} </td>
        </tr><tr>    
            <th>Описание</th> <td> {{ $task->description }} </td>
        </tr><tr>
            <th>Приоритет</th> <td> {{ $task->priority->ru_title }} </td>
        </tr><tr>
            <th>Статус</th> <td> {{ $task->status->ru_title }} </td>
        </tr><tr>
            <th>Дата создания</th> <td> {{ $task->created_at }} </td>
        </tr><tr>
            <th>Дата изменения</th> <td> {{ $task->updated_at }} </td>
        </tr><tr>
            <th>Срок</th> <td> {{ $task->must_ended_at }} </td>
        </tr>
    </table>
    <h2>Редактируемые параметры</h2>
    <form action="/save/task" method="POST">
        @csrf
        <input value="{{ $task->id }}" required="" type="hidden" id="id" name="id">
                    <div class="form-group">
                         <label for="title">Название задачи:</label>
                         <input value="{{ $task->title }}" required type="text" class="form-control" id="title" name="title">
                    </div>
                    <div class="form-group">
                        <label>Приоритет:</label>
                        <select name="priority_id">
                            <option <?php if($task->priority->id == 1) echo "selected"; ?> value="1">высокий</option>
                            <option <?php if($task->priority->id == 2) echo "selected"; ?> value="2">средний</option>
                            <option <?php if($task->priority->id == 3) echo "selected"; ?> value="3">низкий</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="description">Описание задачи:</label><br>
                        <textarea required  style="width: 90%; height: 200px;" class="form-control" id="description" name="description">{{ $task->description }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="status">Статус задачи</label>
                        <select class="form-control" id="status" name="status_id">
                            <option <?php if($task->status->id == 1) echo "selected"; ?> value="1">к выполнению</option>
                            <option <?php if($task->status->id == 2) echo "selected"; ?> value="2">выполняется</option>
                            <option <?php if($task->status->id == 3) echo "selected"; ?>  value="3">выполнена</option>
                            <option <?php if($task->status->id == 4) echo "selected"; ?> value="4">отменена</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Дата окончания</label>
                        <input value="{{ $task->must_ended_at }}" required type="datetime-local" id="endDate" name="must_ended_at">
                    </div>
        <input type="submit" value="Сохранить"/>
    </form>
    <h2>Действия</h2>
    <form action="/delete/task" method="POST">
        @csrf
        <input value="{{ $task->id }}" required="" type="hidden" id="id" name="id">
        <input type="submit" value="Удалить"/>
    </form>
</html>