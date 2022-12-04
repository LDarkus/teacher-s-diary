@extends('layout')

@section('content')
    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Наименование</th>
                <th scope="col">Список групп</th>
                <th scope="col">Удалить</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($disciplines as $discipline)
                <tr>
                    <th scope="row">{{ $loop->index + 1 }}</th>
                    <td>{{ $discipline->name }}</td>
                    <td>тут будут группы студентов</td>
                    <td><a href="{{route("disciplines.show", $discipline->id)}}" class="btn btn-primary">Удалить</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
