<div class="col-sm-6 col-md-5 col-lg-4">
    <aside class="sidebar site-block">
        <!-- Store Menu -->
        <!-- Store Menu functionality is initialized in js/app.js -->
        <div class="sidebar-block" style="min-height: 400px;">
            <ul class="store-menu">
                @foreach($categories as $category)
                        <li><a href="javascript:void(0)">{{$category->title}}</a></li>
                        <li class="open">
                            <ul>
                                <li>
                                    <div class="submenu-item">
                                        Mã công ty
                                    </div>
                                </li>
                                <li>
                                    <div class="submenu-item">
                                        <select name="ticker" class="form-control">
                                            @foreach($category->posts as $key => $item)
                                            <option value="{{$item->id}}" {{(isset($result->id) and $result->id == $item->id)? 'selected': ''}}>{{$item->title}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </li>
                                <li>
                                    <div class="submenu-item">
                                        Chọn số liệu:
                                    </div>
                                </li>
                                <li>
                                    <div class="submenu-item">
                                        <select name="time" class="form-control">
                                        </select>
                                    </div>
                                </li>
                            </ul>
                        </li>
                @endforeach
            </ul>
        </div>
        <div class="sidebar-block">
            <div class="table-responsive">
                <table class="table table-vcenter">
                    <thead class="store-menu">
                        <tr>
                            <th colspan="2"><b><small>Thị trường thế giới</small></b></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><i>Mã</i></td>
                            <td><i>Chỉ số cuối</i></td>
                        </tr>
                        <?php
                            if(\Cache::has('live_data')){
                                $live_data = \Cache::get('live_data');
                            }
                         ?>
                        @if(!is_null($keys))
                            @foreach($keys as $key)
                                <tr class="hover-pointer live-data" key="{{$key['slug']}}">
                                    <td id="{{$key['slug']}}">{!!$key['title']!!}</td>
                                    <td><span class="value-{{str_slug($key['title'])}}">{{isset($live_data)? $live_data[$key['title']]: 'n/a'}}</span></td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </aside>
</div>