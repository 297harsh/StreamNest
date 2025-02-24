@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-5 d-inline">Create Episodes</h5>
                    <form method="POST" action="{{ route('store.episodes') }}" enctype="multipart/form-data">
                        <!-- Email input -->
                        @csrf
                        <div class="form-outline mb-4 mt-4">
                            <label>name</label>
                            <input type="text" name="episode_name" id="form2Example1" class="form-control"
                                placeholder="name" />
                            @if ($errors->has('episode_name'))
                                <p class="alert alert-danger">{{ $errors->first('episode_name') }}</p>
                            @endif
                        </div>
                        <div class="form-outline mb-4 mt-4">
                            <label>thumbnail</label>
                            <input type="file" name="thumbnail" id="form2Example1" class="form-control" />
                            @if ($errors->has('thumbnail'))
                                <p class="alert alert-danger">{{ $errors->first('thumbnail') }}</p>
                            @endif
                        </div>
                        <div class="form-outline mb-4 mt-4">
                            <label>video</label>
                            <input type="file" name="video" id="form2Example1" class="form-control">
                            @if ($errors->has('video'))
                                <p class="alert alert-danger">{{ $errors->first('video') }}</p>
                            @endif
                        </div>
                        <div class="form-outline mb-4 mt-4">
                            <label>Shows</label>
                            <select name="show_id" class="form-select  form-control" aria-label="Default select example">
                                <option selected>Choose Shows</option>
                                @foreach ($shows as $show)
                                    <option value="{{ $show->id }}">{{ $show->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @if ($errors->has('show_id'))
                            <p class="alert alert-danger">{{ $errors->first('show_id') }}</p>
                        @endif




                        <!-- Submit button -->
                        <button type="submit" name="submit" class="btn btn-primary  mb-4 text-center">create</button>


                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
