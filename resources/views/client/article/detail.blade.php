@extends('client.master')

@section('content')
<!-- Intro -->
<section class="site-section site-section-light site-section-top themed-background-dark">
    <div class="container">
        <h3 class="animation-slideDown"><strong>{{$result->title}}</strong></h3>
        <h5 class="animation-slideUp"><i>{{$result->created_at}}</i></h5>
    </div>
</section>
<!-- END Intro -->

<!-- Content -->
<section class="site-content site-section">
    <div class="container">
        <div class="row">
            <!-- Posts -->
            <div class="col-sm-8 col-md-9">
                <!-- Blog Post -->
                <div class="site-block">
                    <div class="row">
                        {!!$result->content!!}
                    </div>
                    <div class="row">
                        <p class="pull-right">
                            <i class="fa fa-comments"></i> <a href="javascript:void(0)" class="label label-primary">Bình luận</a>
                        </p>
                        <p class="pull-left">
                            <hr/>
                        </p>
                    </div>
                </div>
                <!-- END Blog Post -->
                <ul class="media-list">
                    @foreach($comments as $key => $item)
                    <li class="media">
                        <a href="javascript:void(0)" class="pull-left">
                            {{$item->user->name}}
                        </a>
                        <div class="media-body">
                            <span class="text-muted pull-right"><small><em>{{$item->created_at}}</em></small></span>
                            <p>{!!$item->content!!}</p>
                        </div>
                    </li>
                    @endforeach
                    <li class="media">
                        <div class="media-body">
                            <span class="text-muted pull-right">
                                <small>{!!$comments->render()!!}</small>
                            </span>
                        </div>
                    </li>
                    @if(\Auth::check())
                    <li class="media">
                        <a href="javascript:void(0)" class="pull-left">
                            {{\Auth::user()->name}}
                        </a>
                        <div class="media-body">
                            <form id="article-comment" action="{{route('post_comment', ['able'=>'article', 'id'=>$result->id])}}" method="post">
                                {!! csrf_field() !!}
                                <textarea id="comment_text" name="content" class="form-control" rows="4" placeholder="Nhập bình luận.."></textarea>
                                <button type="submit" class="btn btn-primary"><i class="fa fa-pencil"></i> Đăng</button>
                            </form>
                        </div>
                    </li>
                    @else
                    <li class="media">
                        <a href="javascript:void(0)" class="pull-left">
                            Bạn chưa đăng nhập
                        </a>
                        <div class="media-body">
                            <form action="" method="post" onsubmit="return false;">
                                <textarea name="content" class="form-control" rows="4" placeholder="Vui lòng đăng nhập.." disabled></textarea>
                            </form>
                        </div>
                    </li>
                    @endif
                </ul>
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
<script type="text/javascript">
    $(document).ready(function(){
        $('body').on('submit', '#article-comment', function() {
            if ($('textarea#comment_text').val()=='') {
                return false;
            }
        });
    })
</script>
@stop