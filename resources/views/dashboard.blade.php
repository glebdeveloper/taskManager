<!doctype html>
<html>
<head>
    <title>Dashboard</title>
    <style>
        h3{
            text-align: center;
        }
        /*
        alerts
        */
        .alert {
  padding: 15px;
  border-radius: 4px;
  margin-bottom: 20px;
}

.alert-success {
  color: #155724;
  background-color: #d4edda;
  border-color: #c3e6cb;
}

.alert-danger {
  color: #721c24;
  background-color: #f8d7da;
  border-color: #f5c6cb;
}
        /*
        grid
        */
        table{
            width: 98%;
        }
        .wrapper  div{
            /*background-color: #eee;*/
            margin: 5px;
            margin-top: 2px;
        }
        .wrapper {
            width: 100%;
            display: grid;
            background-color: #fff;
        }
        .topLeft{
            grid-column: 1;
            grid-row: 1;
        }
        .haderGrid{
            grid-column: 2 / span 3;
            grid-row: 1;
            text-align: center;
        }
        .logoutGrid{
            grid-column: 5;
            grid-row: 1;
            text-align: right;
        }
        .menuGrid, .uplodGrid, .tableGrid, .exportGrid{
            grid-row: 2;
        }
        .tableGrid{
            grid-column: 4 / span 2;
        }
        .SubordinateAddingGrid{
            grid-column: 1;
            grid-row: 2;
        }
        .SubordinateGrid{
            grid-column: 2 / span 2;
            grid-row: 2;
        }
        .SubordinateTaskAddGrid{
            grid-column: 4 / span 2;
            grid-row: 2;
        }
        .SubordinateTasksGrid{
            grid-column: 1 / span 3;
            grid-row: 3;
        }
        .ownTaskGrid{
            grid-column: span 2;
        }
    </style>
    <script>
        function countBytes(id_) {
            var textarea = document.getElementById(id_);
            var byteCount = new Blob([textarea.value]).size;
            var byteCountElement = document.getElementById(id_+"_byteCount");
            byteCountElement.innerHTML = byteCount + " bytes";
        }
    </script>
</head>

<body>
    <div class="wrapper">
        <div>
            
        </div>
        <div></div>
        <div class="haderGrid">
            <h1>Планировщик задач</h1>
            <b style = "width:100%; text-align: justify; letter-spacing: 11px;">Делайте свою жизнь более продуктивной</b>
        </div>
        <div class="logoutGrid">
            <p>
                
                <form action="/logout" method="POST">
                    @csrf
                    <input type="submit" value="Выйти">
                </form><br>
                {{ Auth::user()->last_name." ".Auth::user()->first_name." ".Auth::user()->middle_name }} <br>
                <i>{{ Auth::user()->email }}</i> <br>
                {{ "@".Auth::user()->name }} <br>
            </p>
        </div>
        
        @if(Auth::user()->isBoss())
            <div class="SubordinateAddingGrid">
                <h3>Добавление подчинённого</h3>
                    
                    @if (session('success_created'))
                    <div class="alert alert-success">
                        {{ htmlspecialchars(session('success_created')) }}
                    </div>
                    @endif
                    
                    @if (session('error_created'))
                    <div class="alert alert-danger">
                        {{ htmlspecialchars(session('error_created')) }}
                    </div>
                    @endif
                    
                
                <form method="POST" action="/create_subordinate" autocomplete="off">
                    @csrf
                    <label for="last_name">Фамилия</label> <br>
                    <input type="text" id="last_name" name="last_name" required> <br>
                    <label for="first_name">Имя</label> <br>
                    <input type="text" id="first_name" name="first_name" required> <br>
                    <label for="middle_name">Отчество</label> <br>
                    <input type="text" id="middle_name" name="middle_name" required> <br>
                    <label for="username">Имя пользователя</label> <br>
                    <input type="text" id="username" name="name" required> <br>
                    <label for="email">Email</label> <br>
                    <input type="email" id="email" name="email" required> <br>
                    <label for="password">Пароль</label> <br>
                    <input type="text" id="password" name="password" minlength="8" required> <br><br>
                    <button type="submit">Добавить подчиненного</button><br>
                </form>
            </div>
            
            <div class="SubordinateGrid">
                <h3>Список подчинённых</h3>
                @if (session('subordinate_edit_success'))
                    <div class="alert alert-success">
                        {{ htmlspecialchars(session('subordinate_edit_success')) }}
                    </div>
                @endif
                <table border = "1">
                    <thead>
                        <tr>
                            <th rowspan="2">#</th>
                            <th rowspan="2">Фамилия</th>
                            <th rowspan="2">Имя</th>
                            <th rowspan="2">Отчество</th>
                            <th rowspan="2">Имя пользователя</th>
                            <th colspan="4">Количество задач</th>
                            <th rowspan="2">Действия</th>
                        </tr>
                        <tr>
                            <th>К выполнению</th>
                            <th>Выполняется</th>
                            <th>Выполнена</th>
                            <th>Отменена</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                        @foreach ($subordinates as $subordinate_obj)
                        <tr>
                            <td>{{ $subordinate_obj->subordinate->id }}</td>
                            <td>{{ $subordinate_obj->subordinate->last_name }}</td>
                            <td>{{ $subordinate_obj->subordinate->first_name }}</td>
                            <td>{{ $subordinate_obj->subordinate->middle_name }}</td>
                            <td>{{ $subordinate_obj->subordinate->name }}</td>
                            
                            <td>{{ $subordinate_obj->subordinate->toDoTasks->count() }}</td>
                            <td>{{ $subordinate_obj->subordinate->inProgressTasks->count() }}</td>
                            <td>{{ $subordinate_obj->subordinate->doneTasks->count() }}</td>
                            <td>{{ $subordinate_obj->subordinate->canceledTasks->count() }}</td>
                            <td> <a href="/subordinate?id={{ $subordinate_obj->subordinate->id }}">Управление</a> </td>
                        </tr>
                        @endforeach
                    </tbody>
            </table>
            </div>
            
            <div class="SubordinateTaskAddGrid">
                 <h3>Добавление задачи для подчинённого</h3>
                    @if (session('success_added'))
                    <div class="alert alert-success">
                        {{ htmlspecialchars(session('success_added')) }}
                    </div>
                    @endif
                    
                    @if (session('error_added'))
                    <div class="alert alert-danger">
                        {{ htmlspecialchars(session('error_added')) }}
                    </div>
                    @endif
                 <form method="POST" action="/subordinates/addTask" >
                     @csrf
                     <div class="form-group">
                         <label for="title">Подчинённый: </label>
                         <select name="subordinate_id">
                             @foreach ($subordinates as $subordinate_obj)
                             <option value="{{ $subordinate_obj->subordinate->id }}">
                                    {{"@". $subordinate_obj->subordinate->name }}
                            </option>
                            @endforeach
                         </select>
                    </div>
                     <div class="form-group">
                         <label for="title">Название задачи</label>
                         <input required type="text" class="form-control" id="title" name="title">
                    </div>
                    <div class="form-group">
                        <label>Приоритет:</label>
                        <select name="prio">
                            <option value="1">высокий</option>
                            <option value="2">средний</option>
                            <option value="3">низкий</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="description">Описание задачи</label>
                        <textarea required  style="width: 90%; height: 200px;" class="form-control" id="description" name="description"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="status">Статус задачи</label>
                        <select class="form-control" id="status" name="status">
                            <option value="1">к выполнению</option>
                            <option value="2">выполняется</option>
                            <option value="3">выполнена</option>
                            <option value="4">отменена</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Дата окончания</label>
                        <input required type="datetime-local" id="endDate" name="endDate">
                    </div>
                    <button type="submit" class="btn btn-primary">Добавить задачу</button>
                </form>
            </div>

            <div class="SubordinateTasksGrid">
                 <h3>Задачи подчинённых</h3>
                 <table border="1">
                     <thead>
                         <tr>
                             <th>#</th>
                             <th>Имя пользователя</th>
                             <th>Название</th>
                             <th>Описание</th>
                             <th>Приоритет</th>
                             <th>Статус</th>
                             <th>Дата создания</th>
                             <th>Дата изменения</th>
                             <th>Срок</th>
                             <th>Действия</th>
                         </tr>
                     </thead>
                     <tbody>
                         @foreach ($subordinates as $subordinate_obj)
                            @foreach ($subordinate_obj->subordinate->createdTasks as $task_obj)
                                <tr>
                                    <td> {{ $task_obj->id }}</td>
                                    <td> {{ $subordinate_obj->subordinate->name }} </td>
                                    <td> {{ $task_obj->title }}</td>
                                    <td> {{ $task_obj->description }}</td>
                                    
                                    <td> {{ $task_obj->priority->ru_title }}</td>
                                    <td> {{ $task_obj->status->ru_title }}</td>
                                    <td> {{ $task_obj->created_at }}</td>
                                    <td> {{ $task_obj->updated_at }}</td>
                                    <td> {{ $task_obj->must_ended_at }}</td>
                                    <td> 
                                        <a href="/task?id={{ $task_obj->id }}">Изменить/удалить</a>
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                     </tbody>
                 </table>
            </div>
            
            
            
            
        @endif
        
        @if(Auth::user()->isRoot())
            <div class="Grid">Пользователи</div>
            <div class="Grid">Добавление пользователя</div>
            <div class="Grid">Управление профилем пользователя</div>
        @endif
        
        
        <div class="ownTaskGrid">
            @if (session('task_edit_success'))
                <div class="alert alert-success">
                    {{ htmlspecialchars(session('task_edit_success')) }}
                </div>
            @endif
            
            <h3>Мои задачи</h3>
            <table border="1">
                     <thead>
                         <tr>
                             <th>#</th>
                             <th>Название</th>
                             <th>Описание</th>
                             <th>Приоритет</th>
                             <th>Статус</th>
                             <th>Дата создания</th>
                             <th>Дата изменения</th>
                             <th>Срок</th>
                             <th>Действия</th>
                         </tr>
                     </thead>
                 <tbody>
                    @foreach (Auth::user()->createdTasks as $task_obj)
                                <tr>
                                    <td> {{ $task_obj->id }}</td>
                                    <td> {{ $task_obj->title }}</td>
                                    <td> {{ $task_obj->description }}</td>
                                    
                                    <td> {{ $task_obj->priority->ru_title }}</td>
                                    <td> {{ $task_obj->status->ru_title }}</td>
                                    <td> {{ $task_obj->created_at }}</td>
                                    <td> {{ $task_obj->updated_at }}</td>
                                    <td> {{ $task_obj->must_ended_at }}</td>
                                    <td> 
                                        <a href="/task?id={{ $task_obj->id }}">Изменить/удалить</a>
                                    </td>
                                </tr>
                    @endforeach
                 </tbody>
            </table>
        </div>
        <div>
            <h3>Добавление задачи для себя</h3>
            @if (session('success_added_myself'))
                    <div class="alert alert-success">
                        {{ htmlspecialchars(session('success_added_myself')) }}
                    </div>
            @endif
            
            @if (session('error_added_myself'))
                    <div class="alert alert-danger">
                        {{ htmlspecialchars(session('error_added_myself')) }}
                    </div>
            @endif
            <form method="POST" action="/addTask" >
                     @csrf
                     <div class="form-group">
                         <label for="title">Название задачи</label>
                         <input required type="text" class="form-control" id="title" name="title">
                    </div>
                    <div class="form-group">
                        <label>Приоритет:</label>
                        <select name="prio">
                            <option value="1">высокий</option>
                            <option value="2">средний</option>
                            <option value="3">низкий</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="description">Описание задачи</label>
                        <textarea required  style="width: 90%; height: 200px;" class="form-control" id="description" name="description"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="status">Статус задачи</label>
                        <select class="form-control" id="status" name="status">
                            <option value="1">к выполнению</option>
                            <option value="2">выполняется</option>
                            <option value="3">выполнена</option>
                            <option value="4">отменена</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Дата окончания</label>
                        <input required type="datetime-local" id="endDate" name="endDate">
                    </div>
                    <button type="submit" class="btn btn-primary">Добавить задачу</button>
            </form>
        </div>
        <div>
            @if(Auth::user()->isBoss())
                <ul>
                    <li>Кол-во подчинённых: {{ $subordinates->count() }}</li>
                </ul>
            @endif
            <h4>Мои задачи(статистика): </h4>
            @if(Auth::user()->isSubordinate())
            <li>Создано руководителем: {{ Auth::user()->createdTasks->where("mode_id", 1)->count() }}
            <ul>
            <li>К выполнению: {{ Auth::user()->toDoTasks->where("mode_id", 1)->count() }}</li>
            <li>Выполняется: {{ Auth::user()->inProgressTasks->where("mode_id", 1)->count() }}</li>
            <li>Выполнено: {{ Auth::user()->doneTasks->where("mode_id", 1)->count() }}</li>
            <li>Отменено: {{ Auth::user()->canceledTasks->where("mode_id", 1)->count() }}</li>
            </ul>
            </li>
            @endif
            <li>Создано мной: {{ Auth::user()->createdTasks->where("mode_id", 2)->count() }}
            <ul>
            <li>К выполнению: {{ Auth::user()->toDoTasks->where("mode_id", 2)->count() }}</li>
            <li>Выполняется: {{ Auth::user()->inProgressTasks->where("mode_id", 2)->count() }}</li>
            <li>Выполнено: {{ Auth::user()->doneTasks->where("mode_id", 2)->count() }}</li>
            <li>Отменено: {{ Auth::user()->canceledTasks->where("mode_id", 2)->count() }}</li>
            </ul>
            </li>
        </div>
    </div>
</body>

</html>