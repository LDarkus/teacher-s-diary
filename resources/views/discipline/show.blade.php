@extends('layout')
@section('content')
    <div class="container mt-4">
        <div class="row">
            <div class="">
                <p class="h3">Наименование дисциплины: <u>{{ $discipline->name }}</u></p>
            </div>

        </div>
        <div class="row mt-4">

            <div class="col-5">
                <div class="h5">Список сформированных работ</div>
            </div>
            <div class="col-7 d-flex justify-content-end align-items-end">
                <a class="btn btn-primary " href="{{ route('works.create', ['discipline' => $discipline]) }}">Сформировать
                    работу</a>
            </div>
        </div>
        <div class="row">
            <table class="table">
                <thead>
                    <tr>
                        <th class="col-0" scope="col">#</th>
                        <th class="col-3" scope="col">Наименование работы</th>
                        <th class="col-2 text-center"scope="col">Тип работы</th>
                        <th class="col-1 text-center"scope="col">Плановый срок сдачи</th>
                        <th class="col-2 text-center"scope="col">Максимальный балл </th>
                        <th class="col-3 text-center"scope="col">Список задач</th>
                        <th class="col-1 text-center"scope="col"></th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($discipline->works as $work)
                        <tr>
                            <th scope="row">{{ $loop->index + 1 }}</th>
                            <td>{{ $work->name }}</a></td>
                            <td class="text-center">{{ $work->typeWork }}</td>
                            <td class="text-center">{{ $work->deadline }}</td>
                            <td class="text-center">{{ $work->max_points }}</td>
                            <td class="">
                                @foreach ($work->tasks as $task)
                                    <div><b>{{ $loop->index + 1 }}</b> {{ $task->name }}</div>
                                @endforeach
                            </td>
                            <td class="">
                                <form class="text-center" method="POST"
                                    action="{{ route('works.destroy', ['work' => $work->id]) }}">
                                    @csrf
                                    @method('DELETE')
                                    <div class="btn-group-vertical">
                                        <a href="{{ route('works.destroy', ['work' => $work->id]) }}"
                                            class="btn btn-outline-primary btn-block ">Оценить</a>
                                        <a href="{{ route('works.edit', ['work' => $work->id]) }}"
                                            class="btn btn-outline-success  btn-block ">Изменить</a>
                                        <input type="submit" class="btn btn-outline-danger btn-block " value="Удалить">
                                    </div>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>


        <div class="row mt-4">

            <div class="col-5">
                <div class="h5">Список привязанных групп к дисциплине</div>
            </div>
            <div class="col-7 d-flex justify-content-end align-items-end">
                <a class="btn btn-primary " href="{{ route('groups.index') }}">Добавить группу</a>
            </div>
        </div>
        <div class="row">
            <table class="table">
                <thead>
                    <tr>
                        <th class="col-0" scope="col">#</th>
                        <th class="col-3" scope="col">Наименование группы</th>
                        <th class="col-9 text-center"scope="col"></th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($discipline->groups as $group)
                        <tr>
                            <th scope="row">{{ $loop->index + 1 }}</th>
                            <td>{{ $group->name }}</td>

                            <td>
                                <div class="d-flex">
                                    <form class="me-3" class="text-center" method="GET"
                                    action="{{ route('disciplines.showWorks', [$discipline, 'group' => $group])}}">
                                    @method('GET')
                                    <input type="submit" class="btn btn-outline-primary "
                                        value="Оценить группу">
                                </form>
                                <form class="text-center" method="POST"
                                    action="{{ route('disciplines.destroyGroup', [$discipline, 'group' => $group]) }}">
                                    @csrf
                                    @method('DELETE')
                                    <input type="submit" class="btn btn-outline-danger "
                                        value="Отвязать группу от дисциплины">
                                </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>



    </div>
@endsection
