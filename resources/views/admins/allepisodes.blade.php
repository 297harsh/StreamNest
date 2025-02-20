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
                    <h5 class="card-title mb-4 d-inline">Episodes</h5>
                    <a href="{{ route('create.episodes') }}" class="btn btn-primary mb-4 text-center float-right">Create
                        Episodes</a>

                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Show Id</th>
                                <th scope="col">Episode Name</th>
                                <th scope="col">video</th>
                                <th scope="col">thumbnail</th>
                                <th scope="col">delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($episodes as $episode)
                                <tr>
                                    <th scope="row">{{ $episode->id }}</th>
                                    <td>{{ $episode->show_id }}</td>
                                    <td>ep {{ $episode->episode_name }}</td>
                                    <td> <video id="player" style="height: 150px; width: 150px" playsinline controls>
                                            <source src="{{ asset('videos/' . $episode->video . '') }}" type="video/mp4" />
                                            <!-- Captions are optional -->
                                            <track kind="captions" label="English captions" src="#" srclang="en"
                                                default />
                                        </video></td>
                                    <td><img style="width: 100px; height: 100px;"
                                            src="{{ asset('thumbnail/' . $episode->thumbnail . '') }}" alt=""></td>
                                    <td><a href="{{ route('delete.episodes', $episode->id) }}"
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
