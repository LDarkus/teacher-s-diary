@extends('layout')
@section('content')
    <div class="container mt-4 ">
        <div class="row">
            <div class="col-4">
                <p class="h3">Список групп</p>
            </div>
            <div class="col-8 d-flex justify-content-end align-items-end">
                <form action="{{ route("groups.store")}}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method("post")
                    <div class="input-group">
                        <input type="file" class="form-control" name="file"  >
                        <button class="btn btn-primary " id="inputGroupFileAddon04">Добавить группу</button>
                      </div>
                </form>

            </div>
        </div>
        <div class="row">
            <table class="table">
                <thead>
                    <tr>
                        <th class="col-0" scope="col">#</th>
                        <th class="col-3" scope="col">Наименование группы</th>
                        <th class="col-5 " scope="col">Список закрепленных дисциплин</th>
                        <th class="col-4 "scope="col"></th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($groups as $group)
                        <tr>
                            <th scope="row">{{ $loop->index + 1 }}</th>
                            <td><a href="{{ route('groups.show', $group) }}">{{ $group->name }}</a></td>
                            <td>

                                @foreach ($group->disciplines as $discipline)
                                    <div class=" me-3 text-nowrap "><a href="{{ route('disciplines.show', $discipline->id) }}">{{ $discipline->name }}</div>
                                @endforeach



                            </td>
                            <td>
                                <form class="text-center" method="POST" action="{{ route('groups.destroy', $group) }}">
                                    @csrf
                                    @method('DELETE')
                                    <div class="form-group text-end">
                                        <a href="{{ route('groups.show', $group) }}"
                                            class="btn btn-outline-primary">Подробнее</a>

                                        <input type="submit" class="btn btn-outline-danger " value="Удалить">


                                    </div>
                                </form>
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
