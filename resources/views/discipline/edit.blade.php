@extends('layout')
@section('content')
    <div class="container mt-4">
        <form action="{{ route('disciplines.update', $discipline->id) }}" method="post">
            @csrf
            @method('put')
            <div class="mt-3 w-50">
                <label for="" class="form-label">Наименование дисциплины</label>
                <input type="text" class="form-control" value="{{ $discipline->name }}" name="name" id=""
                    aria-describedby="helpId" placeholder="Введите наименование дисциплины">


                <div class="select mt-2">
                    <div>
                        <label for="group_id" class="form-label">Список групп</label>
                    </div>
                    <div>
                        <select class="selectpicker" name="groups[]" multiple
                            aria-placeholder="Выберите группы для добавления">
                            @foreach ($groups as $group)
                                <option @if ($discipline->groups->contains($group->id)) selected @endif value="{{ $group->id }}">
                                    {{ $group->name }}</option>
                            @endforeach

                        </select>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-success mt-3">Изменить</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
