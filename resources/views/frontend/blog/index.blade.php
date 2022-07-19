@extends('layouts.frontend.app')
@section('content')
<section class="breadcrumb-blog set-bg" data-setbg="/images/blog-image.jpeg">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h2>Our Blog</h2>
            </div>
        </div>
    </div>
</section>

<section class="blog spad">
    <div class="container">
        <div class="row justify-content-center">
            @foreach ($blogs as $blog)
            <div class="col-lg-4 col-md-6 col-12">
                <div class="blog__item">
                    <div class="blog__item__pic set-bg" data-setbg="/{{ $blog->image_path }}"></div>
                    <div class="blog__item__text">
                        <span><i class="far fa-calendar"></i> {{ $blog->created_at->format('d F Y') }}</span>
                        <h5>{{ $blog->title }}</h5>
                        <a href="{{ route('blog-details', ['blog' => $blog->id]) }}">Read More</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="row">
            <div class="col-lg-12">
                {{ $blogs->links() }}
            </div>
        </div>
    </div>
</section>
@endsection