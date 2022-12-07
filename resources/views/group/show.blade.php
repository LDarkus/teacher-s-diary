@extends('layout')
@section('content')
    <div class="container mt-4">
        <div class="row">
            <div class="col-4">
                <h3>Наименонование группы: {{ $group->name }}</h3>
            </div>
            <div class="col-8 d-flex justify-content-end align-items-end">
                <a class="btn btn-primary " href="{{ route('students.create',$group) }}">Добавить студента</a>
            </div>
        </div>
        <div class="row">
            <h4 class="mt-4">Список cтудентов</h4>
        <table class="table">
            <thead>
                <tr>
                    <th class="col-0" scope="col">#</th>
                    <th class="col-2" scope="col">ФИО студента</th>
                    <th class="col-10 text-center"scope="col"></th>

                </tr>
            </thead>
            <tbody>
                @foreach ($group->students as $student)
                    <tr>
                        <th scope="row">{{ $loop->index + 1 }}</th>
                        <td>{{ $student->name }}</a></td>

                        <td>
                            <form class="text-center" method="POST" action="{{ route('students.destroy', $group) }}">
                                @csrf
                                @method('DELETE')
                                <input type="submit" class="btn btn-outline-danger " value="Удалить студента из группы">
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        </div>
    </div>
@endsection
