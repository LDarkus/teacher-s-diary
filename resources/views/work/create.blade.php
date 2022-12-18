@extends('layout')
@section('content')
    <div class="container ">
        <form action="{{ route('works.store')}}" method="post">
            @csrf
            @method('post')
            <input type="hidden" name="discipline_id" value="{{$discipline->id}}">
            <div class="row text-center">
                <h2>Формирование работы</h1>
            </div>
            <div class="row mt-3">
                <div class="col-3 me-3">
                    <div class="">
                        <label for="" class="form-label ">Наименование работы</label>
                        <input type="text" class="form-control" name="nameWork" id="" aria-describedby="helpId"
                            placeholder="Введите наименование работы">

                    </div>
                    <div class="mt-2  ">
                        <label for="" class="form-label ">Максимальное количество баллов</label>
                        <input type="text" class="form-control" name="scoreWork" id="" aria-describedby="helpId"
                            placeholder="Введите балл">

                    </div>
                </div>
                <div class="col-3 me-3">
                    <div class="d-flex flex-column">
                        <label for="" class="form-label ">Крайний срок</label>
                        <input type="date" name="deadline" />
                    </div>
                    <div class="mt-3">
                        <label for="" class="form-label ">Тип работы</label>
                        <select class="form-select form-select-sm" name="typeWork" id="">
                            <option value="Лабораторная" selected>Лабораторная</option>
                            <option value="Практическая">Практическая</option>

                        </select>
                    </div>
                </div>
                <div class="col-5">
                    <label for="" class="form-label ">Введите список задач (каждую задачу с новой строчки)</label>
                    <div class="form-floating">

                        <textarea class="form-control" style="height: 100px" name="tasks" placeholder="Задачи тут" id="floatingTextarea"></textarea>
                        <label for="floatingTextarea">Задачи</label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 mt-4 align-items-end justify-content-end d-flex">
                    <button class="btn btn-primary" type="submit">Сформировать работу</button>

                    <a href="{{ route('disciplines.show', $discipline) }}" class="btn btn-danger ms-2">Отмена</a>
                </div>

            </div>
        </form>
        <div class="row mt-5">
            <div class="">
                <div class="h5">Список сформированных работ</div>
            </div>
        </div>
        <div class="row mb-4">
            <table class="table-bordered ">
                <thead>
                    <tr class="text-center">
                        <th class="col-0 text-center" scope="col">#</th>
                        <th class="col-3" scope="col">Наименование работы</th>
                        <th class="col-2 text-center"scope="col">Тип работы</th>
                        <th class="col-1 text-center"scope="col">Плановый срок сдачи</th>
                        <th class="col-2 text-center"scope="col">Максимальный балл </th>
                        <th class="col-3 text-center"scope="col">Список задач</th>


                    </tr>
                </thead>
                <tbody>
                    @foreach ($discipline->works as $work)
                        <tr>
                            <th scope="row" class="text-center">{{ $loop->index + 1 }}</th>
                            <td>{{ $work->name }}</a></td>
                            <td class="text-center">{{ $work->typeWork }}</td>
                            <td class="text-center">{{ $work->deadline }}</td>
                            <td class="text-center">{{ $work->max_points }}</td>
                            <td class="">
                                @foreach ($work->tasks as $task)
                                    <div><b>{{ $loop->index + 1 }}</b> {{ $task->name }}</div>
                                @endforeach
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
