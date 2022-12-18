@extends('layout')
@section('content')
    <div class="container mt-4 ">
        <div class="row">
            <div class="col-5">
                <h3>Наименонование группы: {{ $group->name }}</h3>
            </div>
            <div class="col-7 d-flex justify-content-end align-items-end">
                <a class="btn btn-primary " href="{{ route('disciplines.show', $discipline) }}">Вернуться к дисциплине</a>
            </div>

        </div>
        <div class="row ">
            <form action="{{ route('disciplines.showWorks', [$discipline, 'group' => $group]) }}" method="get">
                <div class="col-3">
                    <label for="" class="form-label">Способ вывода</label>
                    <div class="">
                        <select class="form-select form-select" name="method" id="">
                            <option value="0" @if ($method == 0) selected @endif>По умолчанию</option>
                            <option value="1" @if ($method == 1) selected @endif>В баллах</option>
                        </select>
                        <div class="d-grid gap-2 mt-2">
                            <button type="submit" name="" id="" class="btn btn-primary">Выбрать</button>
                        </div>
                    </div>

                </div>
            </form>

        </div>
        <div class="row">
            <h4 class="mt-4">Оценивание работ</h4>
            <table class="table-bordered">
                <thead>
                    <tr>
                        <th rowspan="2">#</th>
                        <th rowspan="2">ФИО студента</th>

                        @if (count($labWorks) != 0)
                            <th colspan="{{ count($labWorks) }}" class="text-center">Лабораторные работы</th>
                        @endif
                        @if (count($practWorks) != 0)
                            <th colspan="{{ count($practWorks) }}" class="text-center">Практические работы</th>
                        @endif




                    </tr>
                    <tr>
                        @foreach ($discipline->works->sortBy(['typeWork']) as $work)
                            <th class="text-center"scope="col"  ><button type="button" data-bs-toggle="tooltip" data-bs-html="true" title="{{$work->name}}" class="btn btn-secondary " style="width: 100%;color:black;font-weight: 700; padding: 0;

                                border: none;
                                background: none;"> {{ $loop->index + 1 }}</button></th>

                        @endforeach

                    </tr>
                </thead>
                <tbody>
                    @foreach ($group->students as $student)
                        <tr>
                            <th scope="row">{{ $loop->index + 1 }}</th>
                            <td class="">{{ $student->name }}</td>
                            @include('discipline.components.studentCompletedWorks', [
                                'group' => $group,
                                'typeWork' => 'Лабораторная',
                            ])
                            @include('discipline.components.studentCompletedWorks', [
                                'group' => $group,
                                'typeWork' => 'Практическая',
                            ])
                        </tr>
                    @endforeach
                </tbody>
            </table>


    </div>
@endsection
