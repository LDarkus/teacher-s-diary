@extends('layout')
@section('content')
    <div class="container ">
        <form action="{{ route('works.store')}}" method="post">
            @csrf
            @method('post');
            <input type="hidden" name="discipline_id" value="{{$discipline_id}}">
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
                    <label for="" class="form-label ">Введите список задач(каждую задачу с новой строчки)</label>
                    <div class="form-floating">

                        <textarea class="form-control" style="height: 100px" name="tasks" placeholder="Задачи тут" id="floatingTextarea"></textarea>
                        <label for="floatingTextarea">Задачи</label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-4 mt-4">
                    <button class="btn btn-primary" type="submit">Сформировать работу</button>
                </div>

            </div>
        </form>
    </div>
@endsection
