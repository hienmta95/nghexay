<?php
// Keywords
$keywords = rawurldecode(request()->get('q'));

// Category
$qCategory = (isset($cat) and !empty($cat)) ? $cat->tid : request()->get('c');

// Location
if (isset($city) and !empty($city)) {
    $qLocationId = (isset($city->id)) ? $city->id : 0;
    $qLocation = $city->name;
    $qAdmin = request()->get('r');
} else {
    $qLocationId = request()->get('l');
    $qLocation = (request()->filled('r')) ? t('area:') . rawurldecode(request()->get('r')) : request()->get('location');
    //dd($qLocation);
    $qAdmin = request()->get('r');
}
//dd($qLocation);
$cities = \App\Models\City::currentCountry()->where('feature_class','P')->orderBy('name')->get();
?>
<div class="search-heading-wrapper">
    <div class="container">
        <div class="search-row-wrapper">
            <div class="container">
                <?php $attr = ['countryCode' => config('country.icode')]; ?>
                <form id="seach" name="search" action="{{ lurl(trans('routes.v-search', $attr), $attr) }}" method="GET">
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        <input name="q" class="form-control keyword" type="text" placeholder="{{ t('What?') }}"
                               value="{{ $keywords }}">
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                        <select name="c" id="catSearch" class="form-control sselecter">
                            <option value="" {{ ($qCategory=='') ? 'selected="selected"' : '' }}> {{ t('All Categories') }} </option>
                            @if (isset($cats) and $cats->count() > 0)
                                @foreach ($cats->groupBy('parent_id')->get(0) as $itemCat)
                                    <option {{ ($qCategory==$itemCat->tid) ? ' selected="selected"' : '' }} value="{{ $itemCat->tid }}"> {{ $itemCat->name }} </option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 search-col locationicon">
                        <i class="icon-location-2 icon-append"></i>

                        <select class="form-control sselecter"  id="locSearchx" name="l">
                            <option value="">Tất cả</option>
                        @foreach($cities as $city)
                            <option value="{!! $city->id !!}" @if($qLocationId == $city->id) selected @endif>{!! $city->name !!}</option>
                            @endforeach
                        </select>
                    </div>

                   {{-- <input type="hidden" id="lSearch" name="l" value="{{ $qLocationId }}">--}}
                    <input type="hidden" id="rSearch" name="r" value="{{ $qAdmin }}">

                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                        <button class="btn btn-block btn-primary">
                            <i class="fa fa-search"></i> <strong>{{ t('Search') }}</strong>
                        </button>
                    </div>
                    {!! csrf_field() !!}
                </form>
            </div>
        </div>
    </div>
</div>

<script>

</script>