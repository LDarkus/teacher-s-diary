@extends('layout')

@section('content')
    <div class="container mt-4 ">
        <div class="row">
            <div class="col-4">
                <p class="h4">Список дисциплин преподавателя</p>
            </div>
            <div class="col-8 d-flex justify-content-end align-items-end">
                <a class="btn btn-primary " href="{{ route('disciplines.create') }}">Добавить дисциплину</a>
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
                                    <a href="{{ route('disciplines.edit', $discipline) }}"
                                        class="btn btn-outline-success">Изменить</a>
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
