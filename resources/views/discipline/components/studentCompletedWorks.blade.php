@foreach ($student->completedWorks as $completedWork)
    @if ($completedWork->work->discipline_id == $discipline->id && $completedWork->work->typeWork == $typeWork)
        <td class="">

            <div class="d-flex justify-content-center">
                @if ($method == 1)
                    @if ($completedWork->completed == 0)
                        <button type="button" style="color: red; border: none; background: none" data-bs-toggle="modal"
                            data-bs-target="#ModalWindows{{ $completedWork->id }}">{{ $completedWork->points }}/{{ $completedWork->work->max_points }}</button>
                    @else
                        <button type="button" style="color: green; border: none;background: none" data-bs-toggle="modal"
                            data-bs-target="#ModalWindows{{ $completedWork->id }}">{{ $completedWork->points }}/{{ $completedWork->work->max_points }}</button>
                    @endif
                @else
                    @if ($completedWork->completed == 0)
                        <button type="button"
                            style="width: 100%; color:white; padding: 0;
                    border: none;
                    background: none;
                    "
                            data-bs-toggle="modal" data-bs-target="#ModalWindows{{ $completedWork->id }}">-</button>
                    @elseif($completedWork->completed == 1)
                        <button type="button"
                            style="width: 100%;color:rgb(15, 227, 15); padding: 0;
                    border: none;
                    background: none;
                    "
                            data-bs-toggle="modal" data-bs-target="#ModalWindows{{ $completedWork->id }}"> <i
                                class="fa fa-solid fa-check"></i></button>
                    @else
                        <button type="button"
                            style="width: 100%;color:grey; padding: 0;
            border: none;
            background: none;
            "
                            data-bs-toggle="modal" data-bs-target="#ModalWindows{{ $completedWork->id }}"> <i
                                class="fa fa-regular fa-clock"></i></button>
                    @endif
                @endif
            </div>
            <!-- Модальное окно -->
            @include('discipline.components.modalWindow', [
                'completedWork' => $completedWork,
            ])
        </td>
    @endif
@endforeach
