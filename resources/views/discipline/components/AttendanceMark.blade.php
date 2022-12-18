<div class="row mt-3">
    <div class="d-flex justify-content-end">
        <form action="{{ route('studentAttendances.addDateInTable', [$discipline, $group]) }}" method="post">
            @method('post')
            @csrf
            <input type="hidden" value="{{ $typeWork }}" name="typeWork">

            <div class="d-grid gap-2 mt-2 me-3">
                <button type="submit" name="" id="" class="btn btn-primary">Добавить
                    занятие</button>
            </div>
        </form>

        <div class="d-grid gap-2 mt-2">
            <input type="submit" form="formSave{{ $typeWork }}" name="" value="Сохранить"
                class="btn btn-primary" />
        </div>

    </div>

</div>
<div class="row mt-3">
    <table class="table-bordered">
        <thead>
            <tr>
                <th class="" scope="col">#</th>
                <th class=" " scope="col">ФИО студента</th>


                @foreach ($group->students()->first()->student_attendances->filter(function ($a) use ($typeWork) {
            if ($a->typeWork == $typeWork) {

                return $a;
            }
        })->unique('date_visit') as $atendance)
                    @if ($atendance->typeWork == $typeWork)
                        <th class="text-center"scope="col">
                            {{ Str::remove(date('Y-'), $atendance->date_visit) }}</th>
                    @endif
                @endforeach
            </tr>
        </thead>
        <tbody>
            <form id="formSave{{ $typeWork }}"
                action="{{ route('disciplines.updateStudentAttendances', [$discipline, 'group' => $group]) }}"
                method="post">
                <input type="hidden" name="tab" value="{{ $tab }}">
                @csrf
                @method('put')
                <input type="hidden" name="type" value="{{ $typeWork }}">
                @foreach ($group->students as $student)
                    <tr>
                        <th scope="row">{{ $loop->index + 1 }}</th>
                        <td class="">{{ $student->name }}</td>



                        @foreach ($student->student_attendances as $attendance)
                            @if ($attendance->typeWork == $typeWork && $attendance->discipline_id == $discipline->id)
                                <td>

                                    <div class="d-flex justify-content-center">

                                        @if ($attendance->visit)
                                            <input class="form-check-input" type="checkbox"
                                                value="{{ $attendance->id }}" name="mark[]" checked>
                                        @else
                                            <input class="form-check-input" type="checkbox"
                                                value="{{ $attendance->id }}" name="mark[]">
                                        @endif

                                    </div>




                                </td>
                            @endif
                        @endforeach

                    </tr>
                @endforeach
            </form>


        </tbody>
    </table>
</div>
