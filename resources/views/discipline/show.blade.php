@extends('layout')
@section('content')
    <div class="container mt-4">
        <h3>Наименонование дисциплины: {{ $discipline->name }}</h3>
        <h4 class="mt-4">Список групп</h4>
        <table class="table">
            <thead>
                <tr>
                    <th class="col-0" scope="col">#</th>
                    <th class="col-2" scope="col">Наименование группы</th>
                    <th class="col-10 text-center"scope="col"></th>

                </tr>
            </thead>
            <tbody>
                @foreach ($discipline->groups as $group)
                    <tr>
                        <th scope="row">{{ $loop->index + 1 }}</th>
                        <td>{{ $group->name }}</a></td>

                        <td>
                            <form class="text-center" method="POST" action="{{ route('disciplines.destroyGroup', [$discipline,"group"=>$group]) }}">
                                @csrf
                                @method('DELETE')
                                <input type="submit" class="btn btn-outline-danger " value="Отвязать группу от дисциплины">
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
