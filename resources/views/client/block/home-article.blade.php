<div class="">
    @if(count($articles) > 0)
        @foreach($articles as $key => $item)
            <!-- Blog Post -->
            <div class="site-block">
                <div class="row">
                    <div class="col-sm-4">
                        <p>
                            <a href="blog_post.php">
                                <img src="{{$item->thumb->link}}" alt="image" class="img-responsive">
                            </a>
                        </p>
                    </div>
                    <div class="col-sm-8">
                        <h3 class="site-heading"><strong>{{$item->title}}</strong></h3>
                        <p>{{$item->description}}</p>
                    </div>
                </div>
                <div class="clearfix">
                    <p class="pull-right">
                        <a href="blog_post.php" class="label label-primary">Xem tiếp..</a>
                    </p>
                    <ul class="list-inline pull-left">
                        <li><i class="fa fa-calendar"></i> {{$item->created_at}}</li>
                        <li><i class="fa fa-user"></i> by <a href="javascript:void(0)">Admin</a></li>
                        <li><i class="fa fa-comments"></i> <a href="javascript:void(0)">3 comments</a></li>
                    </ul>
                </div>
            </div>
            <!-- END Blog Post -->
        @endforeach
    @endif
</div>