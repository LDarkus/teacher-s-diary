@extends('layout')
@section('content')
    <div class="row">
        <div class="col-6">
            <form action="{{ route('groups.store') }}" method="post">
                @csrf
                @method('post')

                <div class="mt-3  d-flex justify-content">
                    <div class="col-8">
                        <label for="group_id" class="form-label">Наименование группы</label>
                        <select class="form-control choices-multiple" name="group_id[]" multiple>
                            @foreach ($groups as $group)
                                <option value="{{ $group->id }}">{{ $group->name }}</option>
                            @endforeach

                        </select>

                        <label for="" class="form-label mt-1">ФИО студента</label>
                        <input type="text" class="form-control" name="StudentName" id=""
                            placeholder="Введите ФИО студента">

                        <div class="d-flex justify-content-between">
                            <button type="submit" value="1" class="btn btn-primary mt-3">Добавить студента в группу

                        </div>
                    </div>

                </div>
            </form>
        </div>

    </div>
@endsection
