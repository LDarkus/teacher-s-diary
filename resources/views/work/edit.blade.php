@extends('layout')
@section('content')
    <div class="container ">

        <form action="{{ route('works.update',$work) }}" method="post">
            @csrf
            @method('put')
            <input type="hidden" name="discipline_id" value="{{ $work->discipline_id }}  ">
            <div class="row text-center">
                <h2>Редактирование работы</h1>
            </div>
            <div class="row mt-3">
                <div class="col-3 me-3">
                    <div class="">
                        <label class="form-label ">Наименование работы</label>
                        <input type="text" class="form-control" value="{{ $work->name }}" name="nameWork"
                            id="" aria-describedby="helpId" placeholder="Введите наименование работы">

                    </div>
                    <div class="mt-2  ">
                        <label for="" class="form-label ">Максимальное количество баллов</label>
                        <input type="text" class="form-control" value=" {{ $work->max_points }} "name="scoreWork"
                            id="" aria-describedby="helpId" placeholder="Введите балл">

                    </div>
                </div>
                <div class="col-3 me-3">
                    <div class="d-flex flex-column">
                        <label for="" class="form-label ">Крайний срок</label>
                        <input type="date" name="deadline" value="{{ $work->deadline }}" />
                    </div>
                    <div class="mt-3">
                        <label for="" class="form-label ">Тип работы</label>
                        <select class="form-select form-select-sm" name="typeWork" id="">
                            <option value="Лабараторная" {{ $work->typeWork == 'Лабораторная' ? 'selected' : '' }}>
                                Лабораторная</option>
                            <option value="Практическая" {{ $work->typeWork == 'Практическая' ? 'selected' : '' }}>
                                Практическая</option>

                        </select>
                    </div>
                </div>
                <div class="col-5">
                    <label for="" class="form-label ">Введите список задач(каждую задачу с новой строчки)</label>
                    <div class="form-floating">

                        <textarea class="form-control" style="height: 100px" name="tasks" placeholder="Задачи тут" id="floatingTextarea">
@foreach ($work->tasks as $task)
{{ $task->name }}
@endforeach
</textarea>
                        <label for="floatingTextarea">Задачи</label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-4 mt-4">
                    <button class="btn btn-success" type="submit">Сохранить работу</button>
                </div>

            </div>
        </form>
    </div>
@endsection
