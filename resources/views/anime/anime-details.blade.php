@extends('layouts.app')

@section('content')
    <!-- Breadcrumb Begin -->
    <div class="breadcrumb-option" style="background-color: #0b0c2a; margin-top: -25px">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__links">
                        <a href="{{ route('home') }}"><i class="fa fa-home"></i> Home</a>
                        <a href="./categories.html">Categories</a>
                        <span>{{ $show->genres }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->
    <div class="container">
        @if (session()->has('follow'))
            <div class="alert alert-success" role="alert">
                {{ session()->get('follow') }}
            </div>
        @endif
    </div>

    <!-- Anime Section Begin -->
    <section class="anime-details spad" style="background-color: #0b0c2a">
        <div class="container">
            <div class="anime__details__content">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="anime__details__pic set-bg" data-setbg="{{ asset('img/' . $show->image . '') }}">
                            <div class="comment"><i class="fa fa-comments"></i> {{ $numberComments }}</div>
                            <div class="view"><i class="fa fa-eye"></i> {{ $numberViews }}</div>
                        </div>
                    </div>
                    <div class="col-lg-9">
                        <div class="anime__details__text">
                            <div class="anime__details__title">
                                <h3>{{ $show->name }}</h3>
                            </div>

                            <p>{{ $show->description }}</p>
                            <div class="anime__details__widget">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6">
                                        <ul>
                                            <li><span>Type:</span>{{ $show->type }}</li>
                                            <li><span>Studios:</span>{{ $show->studios }}</li>
                                            <li><span>Date aired:</span> {{ $show->date_aired }}</li>
                                            <li><span>Status:</span> {{ $show->status }}</li>
                                        </ul>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <ul>
                                            <li><span>Genre:</span> {{ $show->genres }}</li>

                                            <li><span>Duration:</span> {{ $show->duration }}</li>
                                            <li><span>Quality:</span>{{ $show->quality }}</li>
                                            <li><span>Views:</span>{{ $numberViews }}</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="anime__details__btn">
                                @if (isset(Auth::user()->id))
                                    @if ($validateFollowing > 0)
                                        <button type="submit" name="submit" class="follow-btn"><i class="fa fa-heart"></i>
                                            Unfollow</button>
                                    @else
                                        <form action="{{ route('anime.follow', $show->id) }}" method="POST">
                                            @csrf

                                            <input type="hidden" name="show_image" value="{{ $show->image }}">
                                            <input type="hidden" name="show_name" value="{{ $show->name }}">
                                            <button type="submit" name="submit" class="follow-btn"><i
                                                    class="fa fa-heart-o"></i>
                                                Follow</button>
                                        </form>
                                    @endif
                                @endif
                                <a href="{{ route('anime.watching', ['show_id' => $show->id, 'episode_id' => 1]) }}"
                                    class="watch-btn"><span>Watch Now</span>
                                    <i class="fa fa-angle-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                @if (session()->has('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session()->get('success') }}
                    </div>
                @endif
            </div>
            <div class="row">
                <div class="col-lg-8 col-md-8">
                    <div class="anime__details__review">
                        <div class="section-title">
                            <h5>Reviews</h5>
                        </div>
                        @foreach ($comments as $comment)
                            <div class="anime__review__item">
                                <div class="anime__review__item__pic">
                                    <img src="{{ asset('img/users_image/' . $comment->image . '') }}" alt="">
                                </div>
                                <div class="anime__review__item__text">
                                    <h6>{{ $comment->user_name }} - <span>{{ $comment->created_at }}</span></h6>
                                    <p>{{ $comment->comment }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="anime__details__form">
                        <div class="section-title">
                            <h5>Your Comment</h5>
                        </div>
                        @if (isset(Auth::user()->id))
                            <form action="{{ route('anime.comments.store', $show->id) }}" method="POST">
                                @csrf
                                <textarea placeholder="Your Comment" name="comment" required></textarea>
                                <button name="submit" type="submit"><i class="fa fa-location-arrow"></i>
                                    Review</button>
                            </form>
                        @else
                            <p class="alert alert-success">Log in to comment</p>
                        @endif
                    </div>
                </div>
                <div class="col-lg-4 col-md-4">
                    <div class="anime__details__sidebar">
                        <div class="section-title">
                            <h5>you might like...</h5>
                        </div>
                        @foreach ($randomShows as $show)
                            <div class="product__sidebar__view__item set-bg"
                                data-setbg="{{ asset('img/' . $show->image . '') }}">
                                {{-- <div class="ep">{{ $show->episodes }} Episodes</div>
                                <div class="view"><i class="fa fa-eye"></i>{{ $show->views }} Views</div> --}}
                                <h5><a href="{{ route('anime.details', $show->id) }}">{{ $show->name }}</a></h5>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Anime Section End -->
@endsection
