@extends('layout')
@section('content')
    <div class="container mt-4">
        <div class="row">
            <div class="col-4">
                <h3>Наименонование группы: </h3>
            </div>

        </div>
        <div class="row">
            <h4 class="mt-4">Оценивание работ</h4>
            <table class="table">
                <thead>
                    <tr>
                        <th class="" scope="col">#</th>
                        <th class=" " scope="col">ФИО студента</th>
                        @foreach ($discipline->works as $work)
                            <th class=""scope="col">{{ $work->name }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($group->students as $student)
                        <tr>
                            <th scope="row">{{ $loop->index + 1 }}</th>
                            <td class="">{{ $student->name }}</td>
                            @foreach ($student->completedWorks as $work)

                                <td class="">

                                    @if ($work->completed == 0)
                                        <button type="button" class="btn btn-secondary" data-bs-toggle="modal"
                                            data-bs-target="#ModalWindows{{$work->id}}"> Не сдано</button>
                                    @else
                                        <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                            data-bs-target="#ModalWindows{{$work->id}}"> Cдано</button>
                                    @endif


                                    <!-- Модальное окно -->
                                    <!-- Модальное окно -->
                                    <form action="{{ route('disciplines.updateWork', $work->id) }}" method="post">
                                        @csrf
                                        @method('put')
                                        <div class="modal fade" id="ModalWindows{{$work->id}}" data-bs-backdrop="static"
                                            data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
                                            aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="staticBackdropLabel">
                                                            {{ $work->work->name }}
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Закрыть"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="container-fluid">

                                                            <fieldset>
                                                                <div class="border ps-3 pt-1 mb-3">
                                                                    <div class="row mb-3">
                                                                        <div class="col-form label ">Список задач:
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-check d-flex flex-column">
                                                                        @foreach ($work->tasks as $task)

                                                                            <div class="">
                                                                                <input type="checkbox" id="gridCheck{{$task->taskProgress->id}}"
                                                                                    class="form-check-input" name="tasks[]"
                                                                                    value="{{ $task->id }}"
                                                                                    @if ($task->taskProgress->completed == 1) checked @endif>
                                                                                <label for="gridCheck{{$task->taskProgress->id}}"
                                                                                    class="form-check-label">{{ $task->name }}</label>
                                                                            </div>
                                                                        @endforeach

                                                                    </div>

                                                                </div>
                                                            </fieldset>
                                                            <div class="row mb-3">
                                                                <label for="inputDate" class="col-6 col-form-label">Плановый
                                                                    срок
                                                                    сдачи</label>
                                                                <div class="col-6">
                                                                    <input disabled type="date" class="form-control"
                                                                        id="inputDate" value="{{ $work->work->deadline }}">
                                                                </div>
                                                            </div>
                                                            <div class="row mb-2">
                                                                <label for="date_of_completion"
                                                                    class="col-6 col-form-label">Дата
                                                                    сдачи работы</label>
                                                                <div class="col-6">
                                                                    <input type="date" class="form-control"
                                                                        id="date_of_completion"
                                                                        @if ($work->date_of_completion != null) value="{{ $work->date_of_completion }}"
                                                                            @else
                                                                            value="{{ date('Y-m-d') }}" @endif
                                                                        name="date_of_completion">
                                                                </div>
                                                            </div>
                                                            <div class="row mb-2">
                                                                <label for="points"
                                                                    class="col-12 col-form-label">Максимальный балл за
                                                                    работу: <b>{{ $work->work->max_points }}</b></label>
                                                            </div>
                                                            <div class="row mb-2">
                                                                <div class="col-6"><label for="points"
                                                                        class="col-12 col-form-label">Балл за работу
                                                                        студента:</label></div>
                                                                <div class="col-6"><input type="text"
                                                                        class="form-control" id="points"
                                                                        value="{{ $work->points }}" name="points"></div>
                                                            </div>
                                                            <div class="row mb-2">
                                                                <div class="">
                                                                    <label for="comment" class="form-label">Коментарий к
                                                                        работе:</label>
                                                                    <textarea class="form-control" name="comment" id="comment" rows="3">{{ $work->comment }}</textarea>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Закрыть</button>
                                                        <button type="submit" class="btn btn-primary">Понял</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </td>
                            @endforeach
                        </tr>
                    @endforeach


                </tbody>
            </table>
        </div>
    </div>
@endsection
