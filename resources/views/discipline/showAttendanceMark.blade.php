@extends('layout')
@section('content')

    <div class="container mt-4">
        <div class="row">

            <div class="col-5">
                <h3>Наименонование группы: {{ $group->name }}</h3>
            </div>
            <div class="col-7 d-flex justify-content-end align-items-end">
                <a class="btn btn-primary " href="{{ route('disciplines.show', $discipline) }}">Вернуться к дисциплине</a>
            </div>

        </div>

        <div class="row">
            <h4 class="mt-4">Отметка посещаемости студентов </h4>
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home"
                        type="button" role="tab" aria-controls="home" aria-selected="false ">Лабораторные работы</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button"
                        role="tab" aria-controls="profile" aria-selected="true">Практические работы</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button"
                        role="tab" aria-controls="contact" aria-selected="{{$tab == 3 ? "true": "false"}}">Лекции</button>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    @include('discipline.components.AttendanceMark', [
                        $group,
                        $discipline,
                        'typeWork' => 'Лабораторная',
                        "tab"=>1,
                    ])
                </div>
                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    @include('discipline.components.AttendanceMark', [
                        $group,
                        $discipline,
                        'typeWork' => 'Практика',
                        "tab"=>2,
                    ])</div>
                <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                    @include('discipline.components.AttendanceMark', [
                        $group,
                        $discipline,
                        'typeWork' => 'Лекции',
                        "tab"=>3,
                    ])
                </div>
            </div>

        </div>
    </div>
@endsection
