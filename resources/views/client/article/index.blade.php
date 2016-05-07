@extends('client.master')

@section('content')
<!-- Intro -->
<section class="site-section site-section-light site-section-top themed-background-dark">
    <div class="container">
        <h1 class="animation-slideDown"><strong>{{isset($title)? $title->title: 'Tin Tức Mới'}}</strong></h1>
        <h2 class="h3 animation-slideUp">Chọn lọc tin tức thị trường!</h2>
    </div>
</section>
<!-- END Intro -->

<!-- Content -->
<section class="site-content site-section">
    <div class="container">
        <div class="row">
            <!-- Posts -->
            <div class="col-sm-8 col-md-9">
                @foreach($result as $key => $article)
                <!-- Blog Post -->
                <div class="site-block">
                    <div class="row">
                        <div class="col-md-4">
                            <p>
                                <a href="{{route('article_detail', ['cat' => $article->category->slug, 'slug' => $article->slug])}}">
                                    <img src="{{$article->thumb->link}}" alt="{{$article->title}}" class="img-responsive">
                                </a>
                            </p>
                        </div>
                        <div class="col-md-8">
                            <h3 class="site-heading"><strong>{{$article->title}}</strong></h3>
                            <div style="margin-bottom: 0;">
                                {!!$article->description!!}
                            </div>
                        </div>
                    </div>
                    <div class="clearfix">
                        <p class="pull-right">
                            <a href="{{route('article_detail', ['cat' => $article->category->slug, 'slug' => $article->slug])}}" class="label label-primary">Chi tiết..</a>
                        </p>
                        <ul class="list-inline pull-left">
                            <li><i class="fa fa-calendar"></i> {{date('d m Y', strtotime($article->created_at))}}</li>
                            <li><i class="fa fa-tag"></i> <a href="{{route('article_category', $article->category->slug)}}">{{$article->category->title}}</a></li>
                            <li><i class="fa fa-comments"></i> {{$article->comments->count()>0? $article->comments->count().' bình luận': 'Chưa có bình luận'}}</li>
                        </ul>
                    </div>
                </div>
                <!-- END Blog Post -->
                @endforeach

                <!-- Pagination -->
                <div class="text-right">
                    {{$result->render()}}
                </div>
                <!-- END Pagination -->
            </div>
            <!-- END Posts -->

            <!-- Sidebar -->
            <div class="col-sm-4 col-md-3">
                <aside class="sidebar site-block">
                    <!-- Categories -->
                    <div class="sidebar-block">
                        <h4 class="site-heading">Chuyên Mục</h4>
                        <ul class="fa-ul ul-breath">
                            @foreach($categories as $key => $item)
                                <li><i class="fa fa-angle-right fa-li"></i> <a href="{{route('article_category', $item->slug)}}">{{$item->title}}</a></li>
                            @endforeach
                        </ul>
                    </div>
                    <!-- END Categories -->
                </aside>
            </div>
            <!-- END Sidebar -->
        </div>
    </div>
</section>
<!-- END Content -->
@stop