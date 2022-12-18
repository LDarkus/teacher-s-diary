<form action="{{ route('disciplines.updateWork', $completedWork->id) }}"
    method="post">
    @csrf
    @method('put')
    <div class="modal fade" id="ModalWindows{{ $completedWork->id }}"
        data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">
                        {{ $completedWork->work->name }}
                        ({{ $completedWork->work->typeWork }})
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
                                    @foreach ($completedWork->tasksProgress as $task)
                                        <div class="">
                                            <input type="checkbox"
                                                id="gridCheck{{ $task->id }}"
                                                class="form-check-input"
                                                name="tasks[]"
                                                value="{{ $task->task_id }}"
                                                @if ($task->completed == 1) checked @endif>
                                            <label
                                                for="gridCheck{{ $task->id }}"
                                                class="form-check-label">{{ $task->task->name }}</label>
                                        </div>
                                    @endforeach

                                </div>

                            </div>
                        </fieldset>
                        <div class="row mb-3">
                            <label for="inputDate"
                                class="col-6 col-form-label">Плановый
                                срок
                                сдачи</label>
                            <div class="col-6">
                                <input disabled type="date" class="form-control"
                                    id="inputDate"
                                    value="{{ $completedWork->work->deadline }}">
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label for="date_of_completion"
                                class="col-6 col-form-label">Дата
                                сдачи работы</label>
                            <div class="col-6">
                                <input type="date" class="form-control"
                                    id="date_of_completion"
                                    @if ($completedWork->date_of_completion != null) value="{{ $completedWork->date_of_completion }}"
                                @else
                                value="{{ date('Y-m-d') }}" @endif
                                    name="date_of_completion">
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label for="points"
                                class="col-12 col-form-label">Максимальный балл за
                                работу:
                                <b>{{ $completedWork->work->max_points }}</b></label>
                        </div>
                        <div class="row mb-2">
                            <div class="col-6"><label for="points"
                                    class="col-12 col-form-label">Балл за работу
                                    студента:</label></div>
                            <div class="col-6"><input type="text"
                                    class="form-control" id="points"
                                    value="{{ $completedWork->points }}"
                                    name="points"></div>
                        </div>
                        <div class="row mb-2">
                            <div class="">
                                <label for="comment"
                                    class="form-label">Коментарий
                                    к
                                    работе:</label>
                                <textarea class="form-control" name="comment" id="comment" rows="3">{{ $completedWork->comment }}</textarea>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger"
                        data-bs-dismiss="modal">Закрыть</button>
                    <button type="submit" class="btn btn-primary">Оценить
                        работу</button>
                </div>
            </div>
        </div>
    </div>
</form>
