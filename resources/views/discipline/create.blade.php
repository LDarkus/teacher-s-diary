@extends('layout')
@section('content')
    <div class="container mt-4">
        <form action="{{ route('disciplines.store') }}" class="needs-validation" method="post">
            @csrf
            @method('post')
            <div class="mt-3 w-50">
                <label for="" class="form-label">Наименование дисциплины</label>
                <input type="text" class="form-control" name="name" id="" aria-describedby="helpId"
                    placeholder="Введите наименование дисциплины">


                <div class="select mt-2">
                    <div>
                        <label for="group_id" class="form-label">Список групп</label>
                    </div>
                    <div>
                        <select class="selectpicker" name="groups[]" multiple
                            aria-placeholder="Выберите группы для добавления">
                            @foreach ($groups as $group)
                                <option value="{{ $group->id }}">{{ $group->name }}</option>
                            @endforeach

                        </select>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-primary mt-3">Добавить</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
