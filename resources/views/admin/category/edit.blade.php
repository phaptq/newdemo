@extends('admin.master')

@section('content')
<?php $content = 'general_form'; ?>
<ul class="breadcrumb breadcrumb-top">
    <li><a href="{{route('admin')}}">Dashboard</a></li>
    <li><a href="{{route('backend_category')}}">Category</a></li>
</ul>
<div class="row">
    <!-- Table Styles Block -->
    <div class="block">
        <!-- Table Styles Title -->
        <div class="block-title">
            <h2>Edit Category</h2>
        </div>
        <!-- END Table Styles Title -->
        <p>
            @if (Session::has('message'))
            {!! Session::get('message') !!}
            @endif
        </p>
        <div class="table-options clearfix"></div>
        <form action="{{ route('update_category', $result->id) }}" method="post" enctype="multipart/form-data" class="form-horizontal">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="col-md-3 control-label" for="example-text-input">Title</label>
                    <div class="col-md-9">
                        <input type="text" id="title" name="title" class="form-control" placeholder="" value="<?php echo old('title')? old('title'): $result->title; ?>">
                        <span class="help-block">{!! $errors->first('title') !!}<?php echo Session::has('title_err')? Session::get('title_err'): ''; ?></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label" for="example-email-input">Parent</label>
                    <div class="col-md-9">
                        <select style="width: 100%;" name="parent_id" class="select-select2" data-placeholder="None">
                            <option></option><!-- Required for data-placeholder attribute to work with Select2 plugin -->
                            @foreach($parents as $parent)
                            <option value="{{$parent->id}}" <?php if(old('parent_id')){ echo old('parent_id')==$parent->id? 'selected': '';}else{ echo $result->parent_id==$parent->id? 'selected': '';} ?>>{{$parent->title}}</option>
                            @endforeach
                        </select>
                        <span class="help-block">{!! $errors->first('status') !!}</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label" for="example-email-input">Status</label>
                    <div class="col-md-9">
                        <select style="width: 100%;" name="status" class="select-select2" data-placeholder="Choose one..">
                            <option></option><!-- Required for data-placeholder attribute to work with Select2 plugin -->
                            <option value="hidden" <?php if(old('status')){ echo old('status')=='hidden'? 'selected': '';}else{ echo $result->status=='hidden'? 'selected': '';} ?>>Hidden</option>
                            <option value="highlight" <?php if(old('status')){ echo old('status')=='highlight'? 'selected': '';}else{ echo $result->status=='highlight'? 'selected': '';} ?>>Highlight</option>
                        </select>
                        <span class="help-block">{!! $errors->first('status') !!}</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label" for="example-multiple-select">Online</label>
                    <div class="col-md-9">
                        <label class="switch switch-primary">
                            <input type="checkbox" <?php if(old('online')){ echo old('online')==1? 'checked': '';}else{ echo $result->online==1? 'checked': '';} ?> name="online" value="1">
                            <span data-toggle="tooltip" title="" data-original-title="ON/OFF"></span>
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label" for="example-text-input">Order</label>
                    <div class="col-md-9">
                        <input type="text" name="order" class="form-control" placeholder="Digits value" value="<?php echo old('order')? old('order'): $result->order; ?>">
                        <span class="help-block">{!! $errors->first('order') !!}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="col-md-3 control-label" for="example-text-input">Slug</label>
                    <div class="col-md-9">
                        <input type="text" name="slug" class="form-control" placeholder="" value="<?php echo old('slug')? old('slug'): $result->slug; ?>">
                        <span class="help-block">{!! $errors->first('slug') !!}<?php echo Session::has('slug_err')? Session::get('slug_err'): ''; ?></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label" for="example-text-input">Seo - title</label>
                    <div class="col-md-9">
                        <input type="text" name="seo[title]" class="form-control" placeholder="" value="<?php echo old('seo')['title']? old('seo')['title']:json_decode($result->seo)->title; ?>">
                        <span class="help-block">{!! $errors->first('seo[title]') !!}</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label" for="example-text-input">Seo - keyword</label>
                    <div class="col-md-9">
                        <input type="text" name="seo[keyword]" class="form-control" placeholder="" value="<?php echo old('seo')['keyword']? old('seo')['keyword']:json_decode($result->seo)->keyword; ?>">
                        <span class="help-block">{!! $errors->first('seo[keyword]') !!}</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label" for="example-email-input">Description</label>
                    <div class="col-md-9">
                        <textarea style="height: 100px;" class="form-control" name="description"><?php echo old('description')? old('description'): $result->description; ?></textarea>
                        <span class="help-block">{!! $errors->first('description') !!}</span>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="form-group form-actions">
                <div class="text-center">
                    <input type="submit" class="btn btn-primary" value="Save">
                    <input type="reset" class="btn btn-danger" value="Reset">
                </div>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript">
</script>
@stop