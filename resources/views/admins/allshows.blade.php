@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col">
            <div class="container">
                @if (session()->has('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session()->get('success') }}
                    </div>
                @endif
            </div>
            <div class="container">
                @if (session()->has('delete'))
                    <div class="alert alert-success" role="alert">
                        {{ session()->get('delete') }}
                    </div>
                @endif
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-4 d-inline">Shows</h5>
                    <a href="{{ route('create.shows') }}" class="btn btn-primary mb-4 text-center float-right">Create
                        Shows</a>

                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">name</th>
                                <th scope="col">image</th>
                                <th scope="col">description</th>
                                <th scope="col">type</th>
                                <th scope="col">studios</th>
                                <th scope="col">date_aired</th>
                                <th scope="col">status</th>
                                <th scope="col">genres</th>
                                <th scope="col">duration</th>
                                <th scope="col">quality</th>
                                <th scope="col">delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($shows as $show)
                                <tr>
                                    <th scope="row">{{ $show->id }}</th>
                                    <td>{{ $show->name }}</td>
                                    <td><img style="width: 100px; height: 130px;"
                                            src="{{ asset('img/' . $show->image . '') }}" alt=""></td>
                                    <td>{{ $show->description }}</td>
                                    <td>{{ $show->type }}</td>
                                    <td>{{ $show->studios }}</td>
                                    <td>{{ $show->date_aired }}</td>
                                    <td>{{ $show->status }}</td>
                                    <td>{{ $show->genres }}</td>
                                    <td>{{ $show->duration }}</td>
                                    <td>{{ $show->quality }}</td>
                                    <td><a href="{{ route('delete.shows', $show->id) }}"
                                            class="btn btn-danger  text-center ">delete</a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
