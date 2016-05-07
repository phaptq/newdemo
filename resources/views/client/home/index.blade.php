@extends('client.master')

@section('content')
<!-- Media Container -->
    @include('client.layouts.media-container')
<!-- END Media Container -->
<!-- Products -->
    <section class="site-content site-section">
        <div class="container">
            <!-- Seach Form -->
            <div class="site-block">
                <form action="ecom_search_results.html" method="post">
                    <div class="input-group input-group-lg">
                        <input type="text" id="ecom-search" name="ecom-search" class="form-control text-center" placeholder="Search Store..">
                        <div class="input-group-btn">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- END Seach Form -->
            <hr>
            <!-- Advanced Gallery Widgets Row -->
            <div class="row">
                @include('client.block.home-recent')
                @include('client.block.home-popular')
                @include('client.block.home-static')
            </div>
            <!-- END Advanced Gallery Widgets Row -->
            <hr/>
            <div class="row">
                <!-- Posts -->
                @include('client.block.home-article')
                <!-- END Posts -->
            </div>
        </div>
    </section>
    <!-- END Products -->
@stop