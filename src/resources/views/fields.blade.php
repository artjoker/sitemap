<div class="col-12 col-sm-12 col-md-12 col-lg-12">
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item active">
            <a class="nav-link" id="base-tab" data-toggle="tab" href="#base" data-tab="#base" role="tab"
               aria-controls="home" aria-selected="true">
                @lang('sitemap::sitemap.base') </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane fade active in" id="base" role="tabpanel"
             aria-labelledby="home-tab">
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <div>
                        <div class="form-group">
                            <label for="sitemapLastMod">@lang('sitemap::sitemap.url')</label>
                            {!! Form::text('alias',old('alias', null),['class'=>'form-control','id'=>'sitemapLastMod']) !!}
                        </div>
                        <div class="form-group">
                            <label for="sitemapPriority">@lang('sitemap::sitemap.priority')</label>
                            {!! Form::number('priority',old('priority', null),['class'=>'form-control','id'=>'sitemapPriority','min'=>0,'max'=>1,'step'=>0.1]) !!}
                        </div>
                        <div class="form-group">
                            <label for="sitemapChangeFreq">@lang('sitemap::sitemap.changefreq')</label>
                            {!! Form::select('changefreq',$changefreq,(isset($sitemap)) ? $sitemap->getOriginal('changefreq') : old('changefreq', null),['class'=>'form-control','id'=>'sitemapChangeFreq']) !!}
                        </div>
                        <div class="form-group">
                            <label for="sitemapLastMod">@lang('sitemap::sitemap.lastmod')</label>
                            {!! Form::text('lastmod',old('lastmod', null),['class'=>'form-control','id'=>'sitemapLastMod']) !!}
                        </div>
                        <div class="form-group">
                            <div class="checkbox">
                                {!! Form::checkbox('is_active', 'yes', old('is_active', null), ['class' => 'iswitch iswitch-secondary']) !!}
                                @lang('sitemap::sitemap.active')
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<div class="col-12 col-sm-12 col-md-12 col-lg-12">
    <button type="submit" class="btn btn-primary text-uppercase pull-right"> @lang('sitemap::sitemap.save')</button>
    <a href="{{ route(config('sitemap.route_prefix') . '.sitemap.index') }}" data-dialog="@lang('sitemap::sitemap.want_to_go_back')" data-do="link"
       class="btn btn-dark text-uppercase pull-right"> @lang('sitemap::sitemap.back')</a>
</div>