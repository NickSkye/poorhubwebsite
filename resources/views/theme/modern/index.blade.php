@extends('layout.main')

@section('page-css')
    <link rel="stylesheet" href="{{ asset('assets/plugins/owl.carousel/assets/owl.carousel.css') }}">
@endsection

@section('main')
    <div class="modern-top-intoduce-section">

        <div class="container">
            <div class="row">
                <div class="col-md-5">

                    <div class="mdern-top-introduce-left">
                        <div class="alert alert-warning">
                            <h2>{{ get_option('modern_home_left_title') }} </h2>
                            <?php
                                $modern_home_left_content = get_option('modern_home_left_content');
                            if ($modern_home_left_content){
                                $modern_home_left_content = explode("\n", $modern_home_left_content);
                                foreach ($modern_home_left_content as $mhlc_value){
                                    echo "<p><i class='fa fa-check'></i> {$mhlc_value} </p>";
                                }
                            }
                            ?>
                        </div>
                    </div>

                    </div>

                <div class="col-md-7">

                    <div class="mdern-top-introduce-left">
                        <h1>{{ get_option('modern_home_right_title') }}</h1>

                        <p>{{ get_option('modern_home_right_content') }}</p>
                        <a href="" class="btn btn-info btn-lg"> @lang('app.post_an_ad') </a>
                    </div>

                </div>
            </div>
        </div>
    </div>


    <div class="modern-top-hom-cat-section">

        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="modern-home-search-bar-wrap">
                        <div class="search-wrapper">
                            <form class="form-inline" action="{{ route('listing') }}" method="get">
                                <div class="form-group">
                                    <input type="text"  class="form-control" id="searchTerms" name="q" value="{{ request('q') }}" placeholder="@lang('app.search___')" />
                                </div>

                                <div class="form-group">
                                    <select class="form-control select2" name="sub_category">
                                        <option value="">@lang('app.select_a_category')</option>
                                        @foreach($top_categories as $category)
                                            @if($category->sub_categories->count() > 0)
                                                <optgroup label="{{ $category->category_name }}">
                                                    @foreach($category->sub_categories as $sub_category)
                                                        <option value="{{ $sub_category->id }}" {{ old('category') == $sub_category->id ? 'selected': '' }}>{{ $sub_category->category_name }}</option>
                                                    @endforeach
                                                </optgroup>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>

                                @php $country_usage = get_option('countries_usage'); @endphp
                                @if($country_usage == 'all_countries')
                                    <div class="form-group">
                                        <select class="form-control select2" name="country">
                                            <option value="">@lang('app.select_a_country')</option>
                                            @foreach($countries as $country)
                                                <option value="{{ $country->id }}" {{ request('country') == $country->id ? 'selected' :'' }}>{{ $country->country_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endif

                                <div class="form-group">
                                    <select class="form-control select2" id="state_select" name="state">
                                        <option value=""> @lang('app.select_state') </option>
                                        @foreach($countries as $country)
                                        @foreach($country->states as $state)
                                            <option value="{{ $state->id }}" {{ request('state') ==  $state->id ? 'selected':'' }} >{{ $state->state_name }}</option>
                                        @endforeach
                                        @endforeach

                                    </select>
                                </div>

                                <button type="submit" class="btn theme-btn"> <i class="fa fa-search"></i> Search Ads</button>
                            </form>
                        </div>

                    </div>

                    <div class="clearfix"></div>

                    @if(get_option('modern_category_display_style') == 'show_top_category')
                    <div class="modern-home-cat-wrap">
                        <ul class="modern-home-cat-ul">
                            @foreach($top_categories as $category)
                                <li><a href="{{ route('listing') }}?category={{$category->id}}">
                                        <i class="fa {{ $category->fa_icon }}"></i>
                                        <span class="category-name">{{ $category->category_name }} </span>
                                        <p class="count text-muted">({{ number_format($category->product_count) }})</p>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    @else
                        <div class="modern-home-cat-with-sub-wrap">

                            @foreach($top_categories as $category)
                                <div class="modern-cat-list-with-sub-wrap">
                                    <div class="modern-home-cat-top-item">
                                        <a href="{{ route('listing') }}?category={{$category->id}}">
                                            <i class="fa {{ $category->fa_icon }}"></i>
                                            <span class="category-name"><strong>{{ $category->category_name }}</strong> </span>
                                        </a>
                                    </div>

                                    <div class="modern-home-cat-sub-item">
                                        @if($category->sub_categories->count())
                                            <ul class="list-unstyled">

                                                @foreach($category->sub_categories as $s_cat)

                                                    <li><a href="{{ route('listing') }}?category={{$category->id}}&sub_category={{$s_cat->id}}">
                                                            <i class="fa fa-arrow-right"></i> {{ $s_cat->category_name }}
                                                        </a></li>
                                                @endforeach
                                            </ul>

                                        @endif
                                    </div>
                                    <div class="clearfix"></div>
                                </div>

                            @endforeach

                        </div>
                    @endif

                </div>
            </div>
        </div>

    </div>

    @if($enable_monetize)
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    {!! get_option('monetize_code_below_categories') !!}
                </div>
            </div>
        </div>
    @endif


    @if($urgent_ads->count() > 0)
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="carousel-header">
                        <h4><a href="{{ route('listing') }}">
                                @lang('app.new_urgent_ads')
                            </a>
                        </h4>
                    </div>
                    <hr />
                    <div class="themeqx_new_regular_ads_wrap themeqx-carousel-ads owl-carousel owl-theme owl-responsive-1000 owl-loaded">
                        @foreach($urgent_ads as $ad)
                            <div class="owl-stage-outer"><div class="owl-stage" style="transform: translate3d(0px, 0px, 0px); transition: 0s; width: 2300px;"><div class="owl-item active" style="width: 277.5px; margin-right: 10px;"><div>
                            <div itemscope="" itemtype="http://schema.org/Product" class="ads-item-thumbnail ad-box-regular">
                            <div>
                                <div itemscope itemtype="http://schema.org/Product" class="ads-item-thumbnail ad-box-{{$ad->price_plan}}">
                                    <div class="ads-thumbnail">
                                        <a href="{{ route('single_ad', [$ad->id, $ad->slug]) }}">
                                            <img itemprop="image"  src="{{ media_url($ad->feature_img) }}" class="img-responsive" alt="{{ $ad->title }}">

                                            <span class="modern-img-indicator">
                                                @if(! empty($ad->video_url))
                                                    <i class="fa fa-file-video-o"></i>
                                                @else
                                                    <i class="fa fa-file-image-o"> {{ $ad->media_img->count() }}</i>
                                                @endif
                                            </span>
                                        </a>
                                    </div>
                                    <div class="caption">
                                        <h4><a href="{{ route('single_ad', [$ad->id, $ad->slug]) }}" title="{{ $ad->title }}"><span itemprop="name">{{ str_limit($ad->title, 40) }} </span></a></h4>
                                        @if($ad->category)
                                        <a class="price text-muted" href="{{ route('listing', ['category' => $ad->category->id]) }}"> <i class="fa fa-folder-o"></i> {{ $ad->category->category_name }} </a>
                                        @endif

                                        @if($ad->city)
                                            <a class="location text-muted" href="{{ route('listing', ['city' => $ad->city->id]) }}"> <i class="fa fa-location-arrow"></i> {{ $ad->city->city_name }} </a>
                                        @endif
                                        <p class="date-posted text-muted"> <i class="fa fa-clock-o"></i> {{ $ad->created_at->diffForHumans() }}</p>
                                        <p class="price"> <span itemprop="price" content="{{$ad->price}}"> {{ themeqx_price_ng($ad->price, $ad->is_negotiable) }} </span></p>
                                        <link itemprop="availability" href="http://schema.org/InStock" />
                                    </div>

                                    @if($ad->price_plan == 'premium')
                                        <div class="ribbon-wrapper-green"><div class="ribbon-green">{{ ucfirst($ad->price_plan) }}</div></div>
                                    @endif
                                    @if($ad->mark_ad_urgent == '1')
                                        <div class="ribbon-wrapper-red"><div class="ribbon-red">@lang('app.urgent')</div></div>
                                    @endif
                                </div>
                            </div>
                    </div>
                </div>
                        @endforeach
                    </div> <!-- themeqx_new_premium_ads_wrap -->
                </div>
            </div>
        </div>
    @endif


    @if($premium_ads->count() > 0)
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="carousel-header">
                        <h4><a href="{{ route('listing') }}">
                                @lang('app.new_premium_ads')
                            </a>
                        </h4>
                    </div>
                    <hr />
                    {{--<div class="themeqx_new_regular_ads_wrap themeqx-carousel-ads owl-carousel owl-theme owl-responsive-1000 owl-loaded">--}}





                        {{--<div class="owl-stage-outer"><div class="owl-stage" style="transform: translate3d(0px, 0px, 0px); transition: 0s; width: 1187.5px;"><div class="owl-item active" style="width: 227.5px; margin-right: 10px;"><div>--}}
                                        {{--<div itemscope="" itemtype="http://schema.org/Product" class="ads-item-thumbnail ad-box-regular">--}}
                                            {{--<div class="ads-thumbnail">--}}
                                                {{--<a href="https://demo.themeqx.com/classifieds/ad/33/android-smart-watches">--}}
                                                    {{--<img itemprop="image" src="https://demo.themeqx.com/classifieds/uploads/images/thumbs/1478355882adsux-151208182848-smartwatch-apps-screens-780x439.jpg" class="img-responsive" alt="Android Smart watches">--}}

                                                    {{--<span class="modern-img-indicator">--}}
                                                                                                    {{--<i class="fa fa-file-image-o"> 2</i>--}}
                                                                                            {{--</span>--}}
                                                {{--</a>--}}
                                            {{--</div>--}}
                                            {{--<div class="caption">--}}
                                                {{--<h4><a href="https://demo.themeqx.com/classifieds/ad/33/android-smart-watches" title="Android Smart watches"><span itemprop="name">Android Smart watches </span></a></h4>--}}
                                                {{--<a class="price text-muted" href="https://demo.themeqx.com/classifieds/listing?category=18"> <i class="fa fa-folder-o"></i> Clothing </a>--}}

                                                {{--<a class="location text-muted" href="https://demo.themeqx.com/classifieds/listing?city=42675"> <i class="fa fa-location-arrow"></i> Homer </a>--}}
                                                {{--<p class="date-posted text-muted"> <i class="fa fa-clock-o"></i> 1 year ago</p>--}}
                                                {{--<p class="price"> <span itemprop="price" content="1200.00"> EUR 1200.00 </span></p>--}}
                                                {{--<link itemprop="availability" href="http://schema.org/InStock">--}}
                                            {{--</div>--}}

                                            {{--<div class="ribbon-wrapper-red"><div class="ribbon-red">Urgent</div></div>--}}
                                        {{--</div>--}}
                                    {{--</div></div><div class="owl-item active" style="width: 227.5px; margin-right: 10px;"><div>--}}
                                        {{--<div itemscope="" itemtype="http://schema.org/Product" class="ads-item-thumbnail ad-box-premium">--}}
                                            {{--<div class="ads-thumbnail">--}}
                                                {{--<a href="https://demo.themeqx.com/classifieds/ad/31/modern-sofa-set">--}}
                                                    {{--<img itemprop="image" src="https://demo.themeqx.com/classifieds/uploads/images/thumbs/1478336094u5i66-a7394d36be6aa3ef664831cedc3fa0dd.jpg" class="img-responsive" alt="Modern sofa set">--}}

                                                    {{--<span class="modern-img-indicator">--}}
                                                                                                    {{--<i class="fa fa-file-image-o"> 2</i>--}}
                                                                                            {{--</span>--}}
                                                {{--</a>--}}
                                            {{--</div>--}}
                                            {{--<div class="caption">--}}
                                                {{--<h4><a href="https://demo.themeqx.com/classifieds/ad/31/modern-sofa-set" title="Modern sofa set"><span itemprop="name">Modern sofa set </span></a></h4>--}}
                                                {{--<a class="price text-muted" href="https://demo.themeqx.com/classifieds/listing?category=6"> <i class="fa fa-folder-o"></i> Home &amp; Garden </a>--}}

                                                {{--<a class="location text-muted" href="https://demo.themeqx.com/classifieds/listing?city=42802"> <i class="fa fa-location-arrow"></i> Alameda </a>--}}
                                                {{--<p class="date-posted text-muted"> <i class="fa fa-clock-o"></i> 1 year ago</p>--}}
                                                {{--<p class="price"> <span itemprop="price" content="1200.00"> EUR 1200.00 </span></p>--}}
                                                {{--<link itemprop="availability" href="http://schema.org/InStock">--}}
                                            {{--</div>--}}

                                            {{--<div class="ribbon-wrapper-green"><div class="ribbon-green">Premium</div></div>--}}
                                            {{--<div class="ribbon-wrapper-red"><div class="ribbon-red">Urgent</div></div>--}}
                                        {{--</div>--}}
                                    {{--</div></div><div class="owl-item active" style="width: 227.5px; margin-right: 10px;"><div>--}}
                                        {{--<div itemscope="" itemtype="http://schema.org/Product" class="ads-item-thumbnail ad-box-regular">--}}
                                            {{--<div class="ads-thumbnail">--}}
                                                {{--<a href="https://demo.themeqx.com/classifieds/ad/30/toyota-avalon-2016">--}}
                                                    {{--<img itemprop="image" src="https://demo.themeqx.com/classifieds/uploads/images/thumbs/1478294001r32mf-toyota-vios-827-827x510-81450185176.jpg" class="img-responsive" alt="Toyota Avalon 2016">--}}

                                                    {{--<span class="modern-img-indicator">--}}
                                                                                                    {{--<i class="fa fa-file-image-o"> 3</i>--}}
                                                                                            {{--</span>--}}
                                                {{--</a>--}}
                                            {{--</div>--}}
                                            {{--<div class="caption">--}}
                                                {{--<h4><a href="https://demo.themeqx.com/classifieds/ad/30/toyota-avalon-2016" title="Toyota Avalon 2016"><span itemprop="name">Toyota Avalon 2016 </span></a></h4>--}}
                                                {{--<a class="price text-muted" href="https://demo.themeqx.com/classifieds/listing?category=7"> <i class="fa fa-folder-o"></i> Car &amp; Vehicles  </a>--}}

                                                {{--<a class="location text-muted" href="https://demo.themeqx.com/classifieds/listing?city=17000"> <i class="fa fa-location-arrow"></i> Saint-Quentin </a>--}}
                                                {{--<p class="date-posted text-muted"> <i class="fa fa-clock-o"></i> 1 year ago</p>--}}
                                                {{--<p class="price"> <span itemprop="price" content="57000.00"> EUR 57000.00 </span></p>--}}
                                                {{--<link itemprop="availability" href="http://schema.org/InStock">--}}
                                            {{--</div>--}}

                                            {{--<div class="ribbon-wrapper-red"><div class="ribbon-red">Urgent</div></div>--}}
                                        {{--</div>--}}
                                    {{--</div></div><div class="owl-item active" style="width: 227.5px; margin-right: 10px;"><div>--}}
                                        {{--<div itemscope="" itemtype="http://schema.org/Product" class="ads-item-thumbnail ad-box-regular">--}}
                                            {{--<div class="ads-thumbnail">--}}
                                                {{--<a href="https://demo.themeqx.com/classifieds/ad/29/honda-motorcycle">--}}
                                                    {{--<img itemprop="image" src="https://demo.themeqx.com/classifieds/uploads/images/thumbs/1478293642gx2lp-c3.png" class="img-responsive" alt="Honda motorcycle">--}}

                                                    {{--<span class="modern-img-indicator">--}}
                                                                                                    {{--<i class="fa fa-file-image-o"> 1</i>--}}
                                                                                            {{--</span>--}}
                                                {{--</a>--}}
                                            {{--</div>--}}
                                            {{--<div class="caption">--}}
                                                {{--<h4><a href="https://demo.themeqx.com/classifieds/ad/29/honda-motorcycle" title="Honda motorcycle"><span itemprop="name">Honda motorcycle </span></a></h4>--}}
                                                {{--<a class="price text-muted" href="https://demo.themeqx.com/classifieds/listing?category=7"> <i class="fa fa-folder-o"></i> Car &amp; Vehicles  </a>--}}

                                                {{--<a class="location text-muted" href="https://demo.themeqx.com/classifieds/listing?city=16999"> <i class="fa fa-location-arrow"></i> Laon </a>--}}
                                                {{--<p class="date-posted text-muted"> <i class="fa fa-clock-o"></i> 1 year ago</p>--}}
                                                {{--<p class="price"> <span itemprop="price" content="4530.00"> EUR 4530.00 </span></p>--}}
                                                {{--<link itemprop="availability" href="http://schema.org/InStock">--}}
                                            {{--</div>--}}

                                            {{--<div class="ribbon-wrapper-red"><div class="ribbon-red">Urgent</div></div>--}}
                                        {{--</div>--}}
                                    {{--</div></div><div class="owl-item" style="width: 227.5px; margin-right: 10px;"><div>--}}
                                        {{--<div itemscope="" itemtype="http://schema.org/Product" class="ads-item-thumbnail ad-box-premium">--}}
                                            {{--<div class="ads-thumbnail">--}}
                                                {{--<a href="https://demo.themeqx.com/classifieds/ad/28/giant-bicycle">--}}
                                                    {{--<img itemprop="image" src="https://demo.themeqx.com/classifieds/uploads/images/thumbs/14782934505q7i2-recall201313261sl29er1large.jpg" class="img-responsive" alt="Giant bicycle">--}}

                                                    {{--<span class="modern-img-indicator">--}}
                                                                                                    {{--<i class="fa fa-file-image-o"> 1</i>--}}
                                                                                            {{--</span>--}}
                                                {{--</a>--}}
                                            {{--</div>--}}
                                            {{--<div class="caption">--}}
                                                {{--<h4><a href="https://demo.themeqx.com/classifieds/ad/28/giant-bicycle" title="Giant bicycle"><span itemprop="name">Giant bicycle </span></a></h4>--}}
                                                {{--<a class="price text-muted" href="https://demo.themeqx.com/classifieds/listing?category=7"> <i class="fa fa-folder-o"></i> Car &amp; Vehicles  </a>--}}

                                                {{--<a class="location text-muted" href="https://demo.themeqx.com/classifieds/listing?city=42691"> <i class="fa fa-location-arrow"></i> Bouse </a>--}}
                                                {{--<p class="date-posted text-muted"> <i class="fa fa-clock-o"></i> 1 year ago</p>--}}
                                                {{--<p class="price"> <span itemprop="price" content="800.00"> EUR 800.00 </span></p>--}}
                                                {{--<link itemprop="availability" href="http://schema.org/InStock">--}}
                                            {{--</div>--}}

                                            {{--<div class="ribbon-wrapper-green"><div class="ribbon-green">Premium</div></div>--}}
                                            {{--<div class="ribbon-wrapper-red"><div class="ribbon-red">Urgent</div></div>--}}
                                        {{--</div>--}}
                                    {{--</div></div></div></div><div class="owl-controls"><div class="owl-nav"><div class="owl-prev" style=""><i class="fa fa-arrow-circle-o-left"></i></div><div class="owl-next" style=""><i class="fa fa-arrow-circle-o-right"></i></div></div><div class="owl-dots" style=""><div class="owl-dot active"><span></span></div><div class="owl-dot"><span></span></div></div></div></div>--}}
                    {{----}}
                    {{--ORIGINAL below V--}}
                    <div class="themeqx_new_regular_ads_wrap themeqx-carousel-ads owl-carousel owl-theme owl-responsive-1000 owl-loaded">
                        @foreach($premium_ads as $ad)
                            <div>
                                <div itemscope itemtype="http://schema.org/Product" class="ads-item-thumbnail ad-box-{{$ad->price_plan}}">
                                    <div class="ads-thumbnail">
                                        <a href="{{ route('single_ad', [$ad->id, $ad->slug]) }}">
                                            <img itemprop="image"  src="{{ media_url($ad->feature_img) }}" class="img-responsive" alt="{{ $ad->title }}">

                                            <span class="modern-img-indicator">
                                                @if(! empty($ad->video_url))
                                                    <i class="fa fa-file-video-o"></i>
                                                @else
                                                    <i class="fa fa-file-image-o"> {{ $ad->media_img->count() }}</i>
                                                @endif
                                            </span>
                                        </a>
                                    </div>
                                    <div class="caption">
                                        <h4><a href="{{ route('single_ad', [$ad->id, $ad->slug]) }}" title="{{ $ad->title }}"><span itemprop="name">{{ str_limit($ad->title, 40) }} </span></a></h4>
                                        @if($ad->category)
                                        <a class="price text-muted" href="{{ route('listing', ['category' => $ad->category->id]) }}"> <i class="fa fa-folder-o"></i> {{ $ad->category->category_name }} </a>
                                        @endif

                                        @if($ad->city)
                                            <a class="location text-muted" href="{{ route('listing', ['city' => $ad->city->id]) }}"> <i class="fa fa-location-arrow"></i> {{ $ad->city->city_name }} </a>
                                        @endif
                                        <p class="date-posted text-muted"> <i class="fa fa-clock-o"></i> {{ $ad->created_at->diffForHumans() }}</p>
                                        <p class="price"> <span itemprop="price" content="{{$ad->price}}"> {{ themeqx_price_ng($ad->price, $ad->is_negotiable) }} </span></p>
                                        <link itemprop="availability" href="http://schema.org/InStock" />
                                    </div>

                                    @if($ad->price_plan == 'premium')
                                        <div class="ribbon-wrapper-green"><div class="ribbon-green">{{ ucfirst($ad->price_plan) }}</div></div>
                                    @endif
                                    @if($ad->mark_ad_urgent == '1')
                                        <div class="ribbon-wrapper-red"><div class="ribbon-red">@lang('app.urgent')</div></div>
                                    @endif


                                </div>
                            </div>
                        @endforeach
                    </div> <!-- themeqx_new_premium_ads_wrap -->
                </div>


            </div>
        </div>
        @if($enable_monetize)
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        {!! get_option('monetize_code_below_premium_ads') !!}
                    </div>
                </div>
            </div>
        @endif
    @endif



    @if($regular_ads->count() > 0)

        <div class="container">
            <div class="row">

                <div class="col-sm-12">

                    <div class="carousel-header">
                        <h4><a href="{{ route('listing') }}">
                                @lang('app.new_regular_ads')
                            </a>
                        </h4>
                    </div>
                    <hr />
                    {{--<div class="themeqx_new_premium_ads_wrap themeqx-carousel-ads owl-carousel owl-theme owl-loaded owl-responsive-1000">--}}








                        {{--<div class="owl-stage-outer"><div class="owl-stage" style="transform: translate3d(0px, 0px, 0px); transition: 0s; width: 2300px;"><div class="owl-item active" style="width: 277.5px; margin-right: 10px;"><div>--}}
                                        {{--<div itemscope="" itemtype="http://schema.org/Product" class="ads-item-thumbnail ad-box-regular">--}}
                                            {{--<div class="ads-thumbnail">--}}
                                                {{--<a href="https://demo.themeqx.com/classifieds/ad/33/android-smart-watches">--}}
                                                    {{--<img itemprop="image" src="https://demo.themeqx.com/classifieds/uploads/images/thumbs/1478355882adsux-151208182848-smartwatch-apps-screens-780x439.jpg" class="img-responsive" alt="Android Smart watches">--}}

                                                    {{--<span class="modern-img-indicator">--}}
                                                                                                    {{--<i class="fa fa-file-image-o"> 2</i>--}}
                                                                                            {{--</span>--}}
                                                {{--</a>--}}
                                            {{--</div>--}}
                                            {{--<div class="caption">--}}
                                                {{--<h4><a href="https://demo.themeqx.com/classifieds/ad/33/android-smart-watches" title="Android Smart watches"><span itemprop="name">Android Smart watches </span></a></h4>--}}
                                                {{--<a class="price text-muted" href="https://demo.themeqx.com/classifieds/listing?category=18"> <i class="fa fa-folder-o"></i> Clothing </a>--}}

                                                {{--<a class="location text-muted" href="https://demo.themeqx.com/classifieds/listing?city=42675"> <i class="fa fa-location-arrow"></i> Homer </a>--}}
                                                {{--<p class="date-posted text-muted"> <i class="fa fa-clock-o"></i> 1 year ago</p>--}}
                                                {{--<p class="price"> <span itemprop="price" content="1200.00"> EUR 1200.00 </span></p>--}}
                                                {{--<link itemprop="availability" href="http://schema.org/InStock">--}}
                                            {{--</div>--}}

                                            {{--<div class="ribbon-wrapper-red"><div class="ribbon-red">Urgent</div></div>--}}
                                        {{--</div>--}}
                                    {{--</div></div><div class="owl-item active" style="width: 277.5px; margin-right: 10px;"><div>--}}
                                        {{--<div itemscope="" itemtype="http://schema.org/Product" class="ads-item-thumbnail ad-box-regular">--}}
                                            {{--<div class="ads-thumbnail">--}}
                                                {{--<a href="https://demo.themeqx.com/classifieds/ad/32/classic-home-decor">--}}
                                                    {{--<img itemprop="image" src="https://demo.themeqx.com/classifieds/uploads/images/thumbs/1478336386fv5x6-modern-home-decoration-with-area-rugs-sofa-620x465.jpg" class="img-responsive" alt="Classic home decor">--}}

                                                    {{--<span class="modern-img-indicator">--}}
                                                                                                    {{--<i class="fa fa-file-image-o"> 2</i>--}}
                                                                                            {{--</span>--}}
                                                {{--</a>--}}
                                            {{--</div>--}}
                                            {{--<div class="caption">--}}
                                                {{--<h4><a href="https://demo.themeqx.com/classifieds/ad/32/classic-home-decor" title="Classic home decor"><span itemprop="name">Classic home decor </span></a></h4>--}}
                                                {{--<a class="price text-muted" href="https://demo.themeqx.com/classifieds/listing?category=6"> <i class="fa fa-folder-o"></i> Home &amp; Garden </a>--}}

                                                {{--<a class="location text-muted" href="https://demo.themeqx.com/classifieds/listing?city=42751"> <i class="fa fa-location-arrow"></i> Batesville </a>--}}
                                                {{--<p class="date-posted text-muted"> <i class="fa fa-clock-o"></i> 1 year ago</p>--}}
                                                {{--<p class="price"> <span itemprop="price" content="980.00"> EUR 980.00 (Negotiable)  </span></p>--}}
                                                {{--<link itemprop="availability" href="http://schema.org/InStock">--}}
                                            {{--</div>--}}

                                        {{--</div>--}}
                                    {{--</div></div><div class="owl-item active" style="width: 277.5px; margin-right: 10px;"><div>--}}
                                        {{--<div itemscope="" itemtype="http://schema.org/Product" class="ads-item-thumbnail ad-box-regular">--}}
                                            {{--<div class="ads-thumbnail">--}}
                                                {{--<a href="https://demo.themeqx.com/classifieds/ad/30/toyota-avalon-2016">--}}
                                                    {{--<img itemprop="image" src="https://demo.themeqx.com/classifieds/uploads/images/thumbs/1478294001r32mf-toyota-vios-827-827x510-81450185176.jpg" class="img-responsive" alt="Toyota Avalon 2016">--}}

                                                    {{--<span class="modern-img-indicator">--}}
                                                                                                    {{--<i class="fa fa-file-image-o"> 3</i>--}}
                                                                                            {{--</span>--}}
                                                {{--</a>--}}
                                            {{--</div>--}}
                                            {{--<div class="caption">--}}
                                                {{--<h4><a href="https://demo.themeqx.com/classifieds/ad/30/toyota-avalon-2016" title="Toyota Avalon 2016"><span itemprop="name">Toyota Avalon 2016 </span></a></h4>--}}
                                                {{--<a class="price text-muted" href="https://demo.themeqx.com/classifieds/listing?category=7"> <i class="fa fa-folder-o"></i> Car &amp; Vehicles  </a>--}}

                                                {{--<a class="location text-muted" href="https://demo.themeqx.com/classifieds/listing?city=17000"> <i class="fa fa-location-arrow"></i> Saint-Quentin </a>--}}
                                                {{--<p class="date-posted text-muted"> <i class="fa fa-clock-o"></i> 1 year ago</p>--}}
                                                {{--<p class="price"> <span itemprop="price" content="57000.00"> EUR 57000.00 </span></p>--}}
                                                {{--<link itemprop="availability" href="http://schema.org/InStock">--}}
                                            {{--</div>--}}

                                            {{--<div class="ribbon-wrapper-red"><div class="ribbon-red">Urgent</div></div>--}}
                                        {{--</div>--}}
                                    {{--</div></div><div class="owl-item active" style="width: 277.5px; margin-right: 10px;"><div>--}}
                                        {{--<div itemscope="" itemtype="http://schema.org/Product" class="ads-item-thumbnail ad-box-regular">--}}
                                            {{--<div class="ads-thumbnail">--}}
                                                {{--<a href="https://demo.themeqx.com/classifieds/ad/29/honda-motorcycle">--}}
                                                    {{--<img itemprop="image" src="https://demo.themeqx.com/classifieds/uploads/images/thumbs/1478293642gx2lp-c3.png" class="img-responsive" alt="Honda motorcycle">--}}

                                                    {{--<span class="modern-img-indicator">--}}
                                                                                                    {{--<i class="fa fa-file-image-o"> 1</i>--}}
                                                                                            {{--</span>--}}
                                                {{--</a>--}}
                                            {{--</div>--}}
                                            {{--<div class="caption">--}}
                                                {{--<h4><a href="https://demo.themeqx.com/classifieds/ad/29/honda-motorcycle" title="Honda motorcycle"><span itemprop="name">Honda motorcycle </span></a></h4>--}}
                                                {{--<a class="price text-muted" href="https://demo.themeqx.com/classifieds/listing?category=7"> <i class="fa fa-folder-o"></i> Car &amp; Vehicles  </a>--}}

                                                {{--<a class="location text-muted" href="https://demo.themeqx.com/classifieds/listing?city=16999"> <i class="fa fa-location-arrow"></i> Laon </a>--}}
                                                {{--<p class="date-posted text-muted"> <i class="fa fa-clock-o"></i> 1 year ago</p>--}}
                                                {{--<p class="price"> <span itemprop="price" content="4530.00"> EUR 4530.00 </span></p>--}}
                                                {{--<link itemprop="availability" href="http://schema.org/InStock">--}}
                                            {{--</div>--}}

                                            {{--<div class="ribbon-wrapper-red"><div class="ribbon-red">Urgent</div></div>--}}
                                        {{--</div>--}}
                                    {{--</div></div><div class="owl-item" style="width: 277.5px; margin-right: 10px;"><div>--}}
                                        {{--<div itemscope="" itemtype="http://schema.org/Product" class="ads-item-thumbnail ad-box-regular">--}}
                                            {{--<div class="ads-thumbnail">--}}
                                                {{--<a href="https://demo.themeqx.com/classifieds/ad/24/cute-dog">--}}
                                                    {{--<img itemprop="image" src="https://demo.themeqx.com/classifieds/uploads/images/thumbs/1473355793kivfp-dogs-71.jpg" class="img-responsive" alt="Cute dog">--}}

                                                    {{--<span class="modern-img-indicator">--}}
                                                                                                    {{--<i class="fa fa-file-image-o"> 1</i>--}}
                                                                                            {{--</span>--}}
                                                {{--</a>--}}
                                            {{--</div>--}}
                                            {{--<div class="caption">--}}
                                                {{--<h4><a href="https://demo.themeqx.com/classifieds/ad/24/cute-dog" title="Cute dog"><span itemprop="name">Cute dog </span></a></h4>--}}
                                                {{--<a class="price text-muted" href="https://demo.themeqx.com/classifieds/listing?category=9"> <i class="fa fa-folder-o"></i> Pets &amp; Animals </a>--}}

                                                {{--<a class="location text-muted" href="https://demo.themeqx.com/classifieds/listing?city=5747"> <i class="fa fa-location-arrow"></i> Alawalpur </a>--}}
                                                {{--<p class="date-posted text-muted"> <i class="fa fa-clock-o"></i> 1 year ago</p>--}}
                                                {{--<p class="price"> <span itemprop="price" content="230.00"> EUR 230.00 </span></p>--}}
                                                {{--<link itemprop="availability" href="http://schema.org/InStock">--}}
                                            {{--</div>--}}

                                        {{--</div>--}}
                                    {{--</div></div><div class="owl-item" style="width: 277.5px; margin-right: 10px;"><div>--}}
                                        {{--<div itemscope="" itemtype="http://schema.org/Product" class="ads-item-thumbnail ad-box-regular">--}}
                                            {{--<div class="ads-thumbnail">--}}
                                                {{--<a href="https://demo.themeqx.com/classifieds/ad/23/used-sofa-set">--}}
                                                    {{--<img itemprop="image" src="https://demo.themeqx.com/classifieds/uploads/images/thumbs/1473353504hltgq-medeline-sofa-set.jpg" class="img-responsive" alt="Used Sofa Set">--}}

                                                    {{--<span class="modern-img-indicator">--}}
                                                                                                    {{--<i class="fa fa-file-image-o"> 1</i>--}}
                                                                                            {{--</span>--}}
                                                {{--</a>--}}
                                            {{--</div>--}}
                                            {{--<div class="caption">--}}
                                                {{--<h4><a href="https://demo.themeqx.com/classifieds/ad/23/used-sofa-set" title="Used Sofa Set"><span itemprop="name">Used Sofa Set </span></a></h4>--}}
                                                {{--<a class="price text-muted" href="https://demo.themeqx.com/classifieds/listing?category=6"> <i class="fa fa-folder-o"></i> Home &amp; Garden </a>--}}

                                                {{--<a class="location text-muted" href="https://demo.themeqx.com/classifieds/listing?city=6488"> <i class="fa fa-location-arrow"></i> Puerto Madryn </a>--}}
                                                {{--<p class="date-posted text-muted"> <i class="fa fa-clock-o"></i> 1 year ago</p>--}}
                                                {{--<p class="price"> <span itemprop="price" content="400.00"> EUR 400.00 </span></p>--}}
                                                {{--<link itemprop="availability" href="http://schema.org/InStock">--}}
                                            {{--</div>--}}

                                        {{--</div>--}}
                                    {{--</div></div><div class="owl-item" style="width: 277.5px; margin-right: 10px;"><div>--}}
                                        {{--<div itemscope="" itemtype="http://schema.org/Product" class="ads-item-thumbnail ad-box-regular">--}}
                                            {{--<div class="ads-thumbnail">--}}
                                                {{--<a href="https://demo.themeqx.com/classifieds/ad/22/segun-wooden-dinning-6-chair">--}}
                                                    {{--<img itemprop="image" src="https://demo.themeqx.com/classifieds/uploads/images/thumbs/1473351093jeu3m-205935405-2-1000x700-new-teak-segun-wood-dining-table-set-upload-photos-rev001.jpg" class="img-responsive" alt="Segun wooden dinning, 6 chair">--}}

                                                    {{--<span class="modern-img-indicator">--}}
                                                                                                    {{--<i class="fa fa-file-image-o"> 2</i>--}}
                                                                                            {{--</span>--}}
                                                {{--</a>--}}
                                            {{--</div>--}}
                                            {{--<div class="caption">--}}
                                                {{--<h4><a href="https://demo.themeqx.com/classifieds/ad/22/segun-wooden-dinning-6-chair" title="Segun wooden dinning, 6 chair"><span itemprop="name">Segun wooden dinning, 6 chair </span></a></h4>--}}
                                                {{--<a class="price text-muted" href="https://demo.themeqx.com/classifieds/listing?category=6"> <i class="fa fa-folder-o"></i> Home &amp; Garden </a>--}}

                                                {{--<a class="location text-muted" href="https://demo.themeqx.com/classifieds/listing?city=10204"> <i class="fa fa-location-arrow"></i> Boissevain </a>--}}
                                                {{--<p class="date-posted text-muted"> <i class="fa fa-clock-o"></i> 1 year ago</p>--}}
                                                {{--<p class="price"> <span itemprop="price" content="400.00"> EUR 400.00 (Negotiable)  </span></p>--}}
                                                {{--<link itemprop="availability" href="http://schema.org/InStock">--}}
                                            {{--</div>--}}

                                        {{--</div>--}}
                                    {{--</div></div><div class="owl-item" style="width: 277.5px; margin-right: 10px;"><div>--}}
                                        {{--<div itemscope="" itemtype="http://schema.org/Product" class="ads-item-thumbnail ad-box-regular">--}}
                                            {{--<div class="ads-thumbnail">--}}
                                                {{--<a href="https://demo.themeqx.com/classifieds/ad/21/canon-600d-full-fresh-18-135-lens">--}}
                                                    {{--<img itemprop="image" src="https://demo.themeqx.com/classifieds/uploads/images/thumbs/1473350765duyca-camera.jpg" class="img-responsive" alt="canon 600d full fresh... 18-135 lens..">--}}

                                                    {{--<span class="modern-img-indicator">--}}
                                                                                                    {{--<i class="fa fa-file-image-o"> 1</i>--}}
                                                                                            {{--</span>--}}
                                                {{--</a>--}}
                                            {{--</div>--}}
                                            {{--<div class="caption">--}}
                                                {{--<h4><a href="https://demo.themeqx.com/classifieds/ad/21/canon-600d-full-fresh-18-135-lens" title="canon 600d full fresh... 18-135 lens.."><span itemprop="name">canon 600d full fresh... 18-135 lens.. </span></a></h4>--}}
                                                {{--<a class="price text-muted" href="https://demo.themeqx.com/classifieds/listing?category=1"> <i class="fa fa-folder-o"></i> Electronics </a>--}}

                                                {{--<a class="location text-muted" href="https://demo.themeqx.com/classifieds/listing?city=8157"> <i class="fa fa-location-arrow"></i> Aiquile </a>--}}
                                                {{--<p class="date-posted text-muted"> <i class="fa fa-clock-o"></i> 1 year ago</p>--}}
                                                {{--<p class="price"> <span itemprop="price" content="800.00"> EUR 800.00 </span></p>--}}
                                                {{--<link itemprop="availability" href="http://schema.org/InStock">--}}
                                            {{--</div>--}}

                                        {{--</div>--}}
                                    {{--</div></div></div></div><div class="owl-controls"><div class="owl-nav"><div class="owl-prev" style=""><i class="fa fa-arrow-circle-o-left"></i></div><div class="owl-next" style=""><i class="fa fa-arrow-circle-o-right"></i></div></div><div class="owl-dots" style=""><div class="owl-dot active"><span></span></div><div class="owl-dot"><span></span></div></div></div></div>--}}
                    {{--ORIGINAL BELOW HERE V--}}
                    <div class="themeqx_new_premium_ads_wrap themeqx-carousel-ads owl-carousel owl-theme owl-loaded owl-responsive-1000">
                        @foreach($regular_ads as $ad)
                            {{--<div class="owl-stage-outer"><div class="owl-stage" style="transform: translate3d(0px, 0px, 0px); transition: 0s; width: 2300px;"><div class="owl-item active" style="width: 277.5px; margin-right: 10px;"><div>--}}
                            {{--<div itemscope="" itemtype="http://schema.org/Product" class="ads-item-thumbnail ad-box-regular">--}}
                            <div>
                                <div itemscope itemtype="http://schema.org/Product" class="ads-item-thumbnail ad-box-{{$ad->price_plan}}">
                                    <div class="ads-thumbnail">
                                        <a href="{{ route('single_ad', [$ad->id, $ad->slug]) }}">
                                            <img itemprop="image"  src="{{ media_url($ad->feature_img) }}" class="img-responsive" alt="{{ $ad->title }}">

                                            <span class="modern-img-indicator">
                                                @if(! empty($ad->video_url))
                                                    <i class="fa fa-file-video-o"></i>
                                                @else
                                                    <i class="fa fa-file-image-o"> {{ $ad->media_img->count() }}</i>
                                                @endif
                                            </span>
                                        </a>
                                    </div>
                                    <div class="caption">
                                        <h4><a href="{{ route('single_ad', [$ad->id, $ad->slug]) }}" title="{{ $ad->title }}"><span itemprop="name">{{ str_limit($ad->title, 40) }} </span></a></h4>
                                        @if($ad->category)
                                        <a class="price text-muted" href="{{ route('listing', ['category' => $ad->category->id]) }}"> <i class="fa fa-folder-o"></i> {{ $ad->category->category_name }} </a>
                                        @endif

                                        @if($ad->city)
                                            <a class="location text-muted" href="{{ route('listing', ['city' => $ad->city->id]) }}"> <i class="fa fa-location-arrow"></i> {{ $ad->city->city_name }} </a>
                                        @endif
                                        <p class="date-posted text-muted"> <i class="fa fa-clock-o"></i> {{ $ad->created_at->diffForHumans() }}</p>
                                        <p class="price"> <span itemprop="price" content="{{$ad->price}}"> {{ themeqx_price_ng($ad->price, $ad->is_negotiable) }} </span></p>
                                        <link itemprop="availability" href="http://schema.org/InStock" />
                                    </div>

                                    @if($ad->price_plan == 'premium')
                                        <div class="ribbon-wrapper-green"><div class="ribbon-green">{{ ucfirst($ad->price_plan) }}</div></div>
                                    @endif
                                    @if($ad->mark_ad_urgent == '1')
                                        <div class="ribbon-wrapper-red"><div class="ribbon-red">@lang('app.urgent')</div></div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div> <!-- themeqx_new_premium_ads_wrap -->
                </div>

            </div>
        </div>

    @endif

    @if($enable_monetize)
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    {!! get_option('monetize_code_below_regular_ads') !!}
                </div>
            </div>
        </div>
    @endif

    @if(get_option('show_latest_blog_in_homepage') ==1)
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="carousel-header">
                        <h4><a href="{{ route('blog') }}">
                                @lang('app.latest_post_from_blog')
                            </a>
                        </h4>
                    </div>
                    <hr />

                    <div class="home-latest-blog themeqx-carousel-blog-post">
                        @foreach($posts as $post)
                            <div>
                                <div class="image">
                                    <a href="{{ route('blog_single', $post->slug) }}">
                                        @if($post->feature_img)
                                            <img alt="{{ $post->title }}" src="{{ media_url($post->feature_img) }}">
                                        @else
                                            <img  alt="{{ $post->title }}" src="{{ asset('uploads/placeholder.png') }}">
                                        @endif
                                    </a>
                                </div>

                                <h2><a href="{{ route('blog_single', $post->slug) }}" class="blog-title">{{ $post->title }}</a></h2>

                                <div class="blog-post-carousel-meta-info">
                                    @if($post->author)
                                        <span class="pull-left">By <a href="{{ route('author_blog_posts', $post->author->id) }}">{{ $post->author->name }}</a></span>
                                    @endif
                                    <span class="pull-right">
                                        <i class="fa fa-calendar"></i> {{ $post->created_at_datetime() }}
                                    </span>
                                    <div class="clearfix"></div>
                                </div>
                                <p class="intro"> {{ str_limit(strip_tags($post->post_content), 80) }}</p>
                                <a class="btn btn-default" href="{{ route('blog_single', $post->slug) }}" >@lang('app.continue_reading')  <i class="fa fa-external-link"></i> </a>

                            </div>
                        @endforeach
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="modern-post-ad-call-to-cation">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <h1>@lang('app.want_something_sell_quickly')</h1>
                    <p>@lang('app.post_your_ad_quicly')</p>
                    <a href="{{route('create_ad')}}" class="btn btn-info btn-lg">@lang('app.post_an_ad')</a>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('page-js')
    <script src="{{ asset('assets/plugins/owl.carousel/owl.carousel.min.js') }}"></script>
    <script>
        $(document).ready(function(){
            $(".themeqx_new_premium_ads_wrap").owlCarousel({
                loop:true,
                margin:10,
                responsiveClass:true,
                responsive:{
                    0:{
                        items:1,
                        nav:true
                    },
                    600:{
                        items:3,
                        nav:false
                    },
                    1000:{
                        items:4,
                        nav:true,
                        loop:false
                    }
                },
                navText : ['<i class="fa fa-arrow-circle-o-left"></i>','<i class="fa fa-arrow-circle-o-right"></i>']
            });
        });

        $(document).ready(function(){
            $(".themeqx_new_regular_ads_wrap").owlCarousel({
                loop:true,
                margin:10,
                responsiveClass:true,
                responsive:{
                    0:{
                        items:1,
                        nav:true
                    },
                    600:{
                        items:3,
                        nav:false
                    },
                    1000:{
                        items:4,
                        nav:true,
                        loop:false
                    }
                },
                navText : ['<i class="fa fa-arrow-circle-o-left"></i>','<i class="fa fa-arrow-circle-o-right"></i>']
            });
        });
        $(document).ready(function(){
            $(".home-latest-blog").owlCarousel({
                loop:true,
                margin:10,
                responsiveClass:true,
                responsive:{
                    0:{
                        items:1,
                        nav:true
                    },
                    600:{
                        items:3,
                        nav:false
                    },
                    1000:{
                        items:4,
                        nav:true,
                        loop:false
                    }
                },
                navText : ['<i class="fa fa-arrow-circle-o-left"></i>','<i class="fa fa-arrow-circle-o-right"></i>']
            });
        });

    </script>
    <script>
        function generate_option_from_json(jsonData, fromLoad){
            //Load Category Json Data To Brand Select
            if(fromLoad === 'country_to_state'){
                var option = '';
                if (jsonData.length > 0) {
                    option += '<option value="" selected> @lang('app.select_state') </option>';
                    for ( i in jsonData){
                        option += '<option value="'+jsonData[i].id+'"> '+jsonData[i].state_name +' </option>';
                    }
                    $('#state_select').html(option);
                    $('#state_select').select2();
                }else {
                    $('#state_select').html('<option value="" selected> @lang('app.select_state') </option>');
                    $('#state_select').select2();
                }
                $('#loaderListingIcon').hide('slow');
            }
        }

        $(document).ready(function(){
            $('[name="country"]').change(function(){
                var country_id = $(this).val();
                $('#loaderListingIcon').show();
                $.ajax({
                    type : 'POST',
                    url : '{{ route('get_state_by_country') }}',
                    data : { country_id : country_id,  _token : '{{ csrf_token() }}' },
                    success : function (data) {
                        generate_option_from_json(data, 'country_to_state');
                    }
                });
            });
        });

        $(document).ready(function(){
            @if($country_usage == 'single_country')
                $('#loaderListingIcon').show();
            var country_id = {{get_option('usage_single_country_id')}};
                $.ajax({
                    type : 'POST',
                    url : '{{ route('get_state_by_country') }}',
                    data : { country_id : country_id,  _token : '{{ csrf_token() }}' },
                    success : function (data) {
                        generate_option_from_json(data, 'country_to_state');
                    }
                });
            @endif
        });

    </script>
@endsection