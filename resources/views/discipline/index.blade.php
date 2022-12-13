@extends('layout')

@section('content')
    <div class="container mt-4 ">
        <div class="row">
            <div class="col-4">
                <p class="h4">Список дисциплин преподавателя</p>
            </div>
            <div class="col-8 d-flex justify-content-end align-items-end">

                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ModalWindows"> Добавить
                    дисциплину</button>

                <form action="{{ route('disciplines.store') }}" method="post">
                    @csrf
                    @method('post')
                    <div class="modal fade" id="ModalWindows" data-bs-backdrop="static" data-bs-keyboard="false"
                        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="staticBackdropLabel">
                                        Формирование новой дисциплины
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Закрыть"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="container-fluid">
                                        <div class="row">
                                            <label for="inputName" class="col-form-label">Наименование дисциплины
                                            </label>
                                        </div>
                                        <div class="row ms-1">
                                            <input type="text" class="form-control" name="name" id="inputName"
                                                aria-describedby="helpId" placeholder="Введите наименование дисциплины">
                                        </div>
                                        <div class="select mt-2">
                                            <div>
                                                <label for="group_id" class="form-label">Список групп</label>
                                            </div>
                                            <div>
                                                <select class="selectpicker" name="groups[]" multiple
                                                    placeholder="Выберете группы">>
                                                    @foreach ($groups as $group)
                                                        <option value="{{ $group->id }}">{{ $group->name }}</option>
                                                    @endforeach

                                                </select>
                                            </div>

                                        </div>


                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Закрыть</button>
                                    <button type="submit" class="btn btn-primary">Сформировать дисциплину</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <table class="table">
                <thead>
                    <tr>
                        <th class="col-0" scope="col">#</th>
                        <th class="col-3" scope="col">Наименование</th>
                        <th class="col-5 " scope="col">Список групп</th>
                        <th class="col-4 "scope="col"></th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($disciplines as $discipline)
                        <tr>
                            <th scope="row">{{ $loop->index + 1 }}</th>
                            <td><a href="{{ route('disciplines.show', $discipline->id) }}">{{ $discipline->name }}</a></td>
                            <td>

                                @foreach ($discipline->groups as $group)
                                    <span class="me-3 text-nowrap">{{ $group->name }}</span>
                                @endforeach


                            </td>
                            <td>
                                <form class="text-center" method="POST"
                                    action="{{ route('disciplines.destroy', $discipline) }}">
                                    @csrf
                                    @method('DELETE')
                                    <div class="form-group text-center">
                                        <a href="{{ route('disciplines.show', $discipline) }}"
                                            class="btn btn-outline-primary">Подробнее</a>

                                        <button type="button" class="btn btn-outline-success" data-bs-toggle="modal"
                                            data-bs-target="#ModalWindows{{$discipline->id}}"> Изменить
                                            </button>

                                        <form action="{{ route('disciplines.update', $discipline->id) }}" method="post">
                                            @csrf
                                            @method('put')
                                            <div class="modal fade text-start" id="ModalWindows{{$discipline->id}}" data-bs-backdrop="static"
                                                data-bs-keyboard="false" tabindex="-1"
                                                aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="staticBackdropLabel">
                                                                Редактирование дисциплины
                                                            </h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Закрыть"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="container-fluid">
                                                                <div class="row">
                                                                    <label for="inputName"
                                                                        class="col-form-label">Наименование дисциплины
                                                                    </label>
                                                                </div>
                                                                <div class="row ms-1">
                                                                    <input type="text" class="form-control"
                                                                        name="name" id="inputName"
                                                                        value="{{ $discipline->name }}"
                                                                        aria-describedby="helpId"
                                                                        placeholder="Введите наименование дисциплины">
                                                                </div>
                                                                <div class="select mt-2">
                                                                    <div>
                                                                        <label for="group_id" class="form-label">Список
                                                                            групп</label>
                                                                    </div>
                                                                    <div>
                                                                        <select class="selectpicker" name="groups[]"
                                                                            multiple id="{{$discipline->id}}"
                                                                            aria-placeholder="Выберите группы для добавления">
                                                                            @foreach ($groups as $group)
                                                                                <option
                                                                                    @if ($discipline->groups->contains($group->id)) selected @endif
                                                                                    value="{{ $group->id }}">
                                                                                    {{ $group->name }}</option>
                                                                            @endforeach

                                                                        </select>
                                                                    </div>

                                                                </div>


                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-danger"
                                                                data-bs-dismiss="modal">Закрыть</button>
                                                            <button type="submit" class="btn btn-success">Изменить</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                        <input type="submit" class="btn btn-outline-danger " value="Удалить">


                                    </div>
                                </form>
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
