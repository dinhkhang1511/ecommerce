@extends('layouts.frontend.app')
@section('content')
<section class="blog-hero spad">
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="col-lg-9 text-center">
                <div class="blog__hero__text">
                    <h2>{{ $blog->title }}</h2>
                    <ul>
                        <li>By Admin</li>
                        <li>{{ $blog->created_at->format('d F Y') }}</li>
                        <li>8 Comments</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="blog-details spad">
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="col-lg-12">
                <div class="blog__details__pic">
                    <img src="/{{ $blog->image_path }}" alt="">
                </div>
            </div>
            <div class="col-lg-8">
                <div class="blog__details__content">
                    <div class="blog__details__share">
                        <span>share</span>
                        <ul>
                            <li>
                                <a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u={{ url('blog-details')."/".$blog->id }}">
                                    <i class="fa fa-facebook"></i>
                                </a>
                            </li>
                            <li>
                                <a href="https://twitter.com/share?text=&url={{ url('blog-details')."/".$blog->id }}" target="_blank">
                                    <i class="fa fa-twitter"></i>
                                </a>
                            </li>
                            <li><a href="#" class="youtube"><i class="fa fa-youtube-play"></i></a></li>
                            <li><a href="#" class="linkedin"><i class="fa fa-linkedin"></i></a></li>
                        </ul>
                    </div>
                    <div class="blog__details__text text-justify">
                        {!! $blog->body !!}
                    </div>
                    <div class="blog__details__option">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="blog__details__author">
                                    <div class="blog__details__author__pic">
                                        <img src="/images/avatar-default.svg" alt="">
                                    </div>
                                    <div class="blog__details__author__text">
                                        <h5>Admin</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="blog__details__tags">
                                    @foreach ($blog->tags as $tag)
                                        <a href="#">#{{ $tag->name }}</a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="blog__details__btns">
                        <div class="row">
                            @if ($relatedPost->count() > 0)
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <a href="{{ route('blog-details', ['blog' => $relatedPost[0]->id]) }}" class="blog__details__btns__item">
                                    <p><i class="fa fa-arrow-circle-o-left" aria-hidden="true"></i> Previous Pod</p>
                                    <h5>{{ $relatedPost[0]->title }}</h5>
                                </a>
                            </div>
                            @endif

                            @if ($relatedPost->count() > 1)
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <a href="{{ route('blog-details', ['blog' => $relatedPost[1]->id]) }}" class="blog__details__btns__item blog__details__btns__item--next">
                                    <p>Next Pod <i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i></p>
                                    <h5>{{ $relatedPost[1]->title }}</h5>
                                </a>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
