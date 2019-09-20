<!-- this (.mobile-filter-sidebar) part will be position fixed in mobile version -->
<?php
	$fullUrl = url(request()->getRequestUri());
    $tmpExplode = explode('?', $fullUrl);
    $fullUrlNoParams = current($tmpExplode);

	$inputPostType = [];
	if (request()->filled('type')) {
        $types = request()->get('type');
        if (is_array($types)) {
            foreach ($types as $type) {
                $inputPostType[] = $type;
            }
        } else {
            $inputPostType[] = $types;
        }
	}
?>
<div class="col-sm-3 page-sidebar mobile-filter-sidebar" style="padding-bottom: 20px;">
	<aside>
		<div class="inner-box enable-long-words">
			<!-- Date -->
			<?php /* <div class="list-filter">
				<h5 class="list-title"><strong><a href="#"> {{ t('Date Posted') }} </a></strong></h5>
				<div class="filter-date filter-content">
					<ul>
						@if (isset($dates) and !empty($dates))
							@foreach($dates as $key => $value)
							<li>
								<input type="radio" name="postedDate" value="{{ $key }}" id="postedDate_{{ $key }}" {{ (request()->get('postedDate')==$key) ? 'checked="checked"' : '' }}>
								<label for="postedDate_{{ $key }}">{{ $value }}</label>
							</li>
							@endforeach
						@endif
						<input type="hidden" id="postedQueryString" value="{{ httpBuildQuery(request()->except(['postedDate'])) }}">
					</ul>
				</div>
			</div>
			
			<!-- PostType -->
			<div class="list-filter">
				<h5 class="list-title"><strong><a href="#">{{ t('Job Type') }}</a></strong></h5>
				<div class="filter-content filter-employment-type">
					<ul id="blocPostType" class="browse-list list-unstyled">
						@if (isset($postTypes) and !empty($postTypes))
							@foreach($postTypes as $key => $postType)
								<li>
									<input type="checkbox" name="type[{{ $key }}]" id="employment_{{ $postType->tid }}" value="{{ $postType->tid }}" class="emp emp-type" {{ (in_array($postType->tid,  $inputPostType)) ? 'checked="checked"' : '' }}>
									<label for="employment_{{ $postType->tid }}">{{ $postType->name }}</label>
								</li>
							@endforeach
						@endif
						<input type="hidden" id="postTypeQueryString" value="{{ httpBuildQuery(request()->except(['type'])) }}">
					</ul>
				</div>
			</div>

			*/?>
			<!-- Salary -->
			<form role="form" class="form-inline" action="{{ $fullUrlNoParams }}" method="GET">
			<div class="list-filter">
				<p><strong><a href="#">{{ t('Salary Pay Range') }}</a></strong></h5>
				<div class="filter-salary filter-content ">
						{!! csrf_field() !!}
						<?php $i = 0; ?>
						@foreach(request()->except(['minSalary', 'maxSalary', '_token']) as $key => $value)
							@if (is_array($value))
								@foreach($value as $k => $v)
									@if (is_array($v))
										@foreach($v as $ik => $iv)
											@continue(is_array($iv))
											<input type="hidden" name="{{ $key.'['.$k.']['.$ik.']' }}" value="{{ $iv }}">
										@endforeach
									@else
										<input type="hidden" name="{{ $key.'['.$k.']' }}" value="{{ $v }}">
									@endif
								@endforeach
							@else
								<input type="hidden" name="{{ $key }}" value="{{ $value }}">
							@endif
						@endforeach
					<?php
						$salaries = [
								null => '',
							'5000000' => '5 triá»‡u',
							'10000000' => '10 triá»‡u',
							'15000000' => '15 triá»‡u',
							'20000000' => '20 triá»‡u',
							'50000000' => '50 triá»‡u',
						]
					?>
						<div class="form-group col-sm-5 no-padding">
							<select name="minSalary" id="minSalary" class="form-control">
								@foreach($salaries as $key => $val)
									<option value="{!! $key !!}" @if(request()->get('minSalary') == $key) selected  @endif >{!! $val !!}</option>
									@endforeach
							</select>
						</div>
					<div class="form-group col-sm-2 no-padding text-center hidden-xs">
						tá»›i
					</div>
						<div class="form-group col-sm-5 no-padding">
							<select name="maxSalary" id="maxSalary" class="form-control">
								@foreach($salaries as $key => $val)
									<option value="{!! $key !!}" @if(request()->get('maxSalary') == $key) selected  @endif >{!! $val !!}</option>
								@endforeach
							</select>




						</div>

					<div class="clearfix"></div>
				</div>
				<div style="clear:both"></div>
			</div>

			@if (isset($cat))
				<?php $parentId = ($cat->parent_id == 0) ? $cat->tid : $cat->parent_id; ?>
				<!-- SubCategory -->
				<div id="subCatsList" class="form-group w100 mt-10 mb-3">
					<p>
						<strong><a href="{!! url('latest-jobs') !!}"><i class="fa fa-angle-left"></i> {{ t('Others Categories') }}</a></strong>
					</p>
					@if ($cats->has($parentId))
						<?php $attr = [
								'countryCode' => config('country.icode'),
								'catSlug'     => $cats->get($parentId)->slug
						]; ?>
						<a href="{{ lurl(trans('routes.v-search-cat', $attr), $attr) }}" title="{{ $cats->get($parentId)->name }}">
									<span class="title"><strong>{{ $cats->get($parentId)->name }}</strong>
									</span><span class="count">&nbsp;{{ $countCatPosts->get($parentId)->total ?? 0 }}</span>
						</a>
					@endif
					<div class="clearfix"></div>
					@if ($cats->groupBy('parent_id')->has($parentId))
					<select name="sc" class="form-control">

							@foreach ($cats->groupBy('parent_id')->get($parentId) as $iSubCat)
								@continue(!$cats->has($iSubCat->parent_id))
								<option value="{!! $iSubCat->id !!}" 	@if ((isset($uriPathSubCatSlug) and $uriPathSubCatSlug == $iSubCat->slug) or (request()->input('sc') == $iSubCat->tid)) selected @endif>
									{!! $iSubCat->name !!}
								</option>
							@endforeach


					</select>
					@endif
						<?php /*<ul class="list-unstyled">
						<li>
							@if ($cats->has($parentId))
								<?php $attr = [
										'countryCode' => config('country.icode'),
										'catSlug'     => $cats->get($parentId)->slug
									]; ?>
								<a href="{{ lurl(trans('routes.v-search-cat', $attr), $attr) }}" title="{{ $cats->get($parentId)->name }}">
									<span class="title"><strong>{{ $cats->get($parentId)->name }}</strong>
									</span><span class="count">&nbsp;{{ $countCatPosts->get($parentId)->total ?? 0 }}</span>
								</a>
							@endif
							<ul class="list-unstyled long-list">
								@if ($cats->groupBy('parent_id')->has($parentId))
									@foreach ($cats->groupBy('parent_id')->get($parentId) as $iSubCat)
										@continue(!$cats->has($iSubCat->parent_id))
										<li>
											<?php $attr = [
												'countryCode' => config('country.icode'),
												'catSlug'     => $cats->get($iSubCat->parent_id)->slug,
												'subCatSlug'  => $iSubCat->slug
											]; ?>
											@if ((isset($uriPathSubCatSlug) and $uriPathSubCatSlug == $iSubCat->slug) or (request()->input('sc') == $iSubCat->tid))
												<strong>
													<a href="{{ lurl(trans('routes.v-search-subCat', $attr), $attr) }}" title="{{ $iSubCat->name }}">
														{{ str_limit($iSubCat->name, 100) }}
														<span class="count">({{ $countSubCatPosts->get($iSubCat->tid)->total ?? 0 }})</span>
													</a>
												</strong>
											@else
												<a href="{{ lurl(trans('routes.v-search-subCat', $attr), $attr) }}" title="{{ $iSubCat->name }}">
													{{ str_limit($iSubCat->name, 100) }}
													<span class="count">({{ $countSubCatPosts->get($iSubCat->tid)->total ?? 0 }})</span>
												</a>
											@endif
										</li>
									@endforeach
								@endif
							</ul>
						</li>
					</ul> */?>
				</div>
				<?php $style = 'style="display: none;"'; ?>
			@endif
			
			<!-- Category -->
			<div id="catsList" class="form-group  w100 mt-10" <?php echo (isset($style)) ? $style : ''; ?>>
				<p>
					<strong><a href="#">{{ t('All Categories') }}</a></strong>
				</p>
				@if ($cats->groupBy('parent_id')->has(0))
					<select name="c" class="form-control sselecter">
						@foreach ($cats->groupBy('parent_id')->get(0) as $iCat)
							<option value="{!! $iCat->id !!}" @if ((isset($uriPathCatSlug) and $uriPathCatSlug == $iCat->slug) or (request()->input('c') == $iCat->tid)) selected @endif>{!! $iCat->name !!}</option>
						@endforeach

					</select>
				@endif


				<?php /*<ul class="list-unstyled">
					@if ($cats->groupBy('parent_id')->has(0))
						@foreach ($cats->groupBy('parent_id')->get(0) as $iCat)
							<li>
								<?php $attr = ['countryCode' => config('country.icode'), 'catSlug' => $iCat->slug]; ?>
								@if ((isset($uriPathCatSlug) and $uriPathCatSlug == $iCat->slug) or (request()->input('c') == $iCat->tid))
									<strong>
										<a href="{{ lurl(trans('routes.v-search-cat', $attr), $attr) }}" title="{{ $iCat->name }}">
											<span class="title">{{ $iCat->name }}</span>
											<span class="count">&nbsp;{{ $countCatPosts->get($iCat->tid)->total ?? 0 }}</span>
										</a>
									</strong>
								@else
									<a href="{{ lurl(trans('routes.v-search-cat', $attr), $attr) }}" title="{{ $iCat->name }}">
										<span class="title">{{ $iCat->name }}</span>
										<span class="count">&nbsp;{{ $countCatPosts->get($iCat->tid)->total ?? 0 }}</span>
									</a>
								@endif
							</li>
						@endforeach
					@endif
				</ul>*/?>
			</div>
			
			<!-- City -->
			<div class="form-group w100">
				<p><strong><a href="#">{{ t('Location') }}</a></strong></p>
				<select name="l" class="form-control sselecter">
					@if (isset($cities) and $cities->count() > 0)
						@foreach ($cities as $city)
							<?php
							$attr = ['countryCode' => config('country.icode')];
							$fullUrlLocation = lurl(trans('routes.v-search', $attr), $attr);
							$locationParams = [
									'l'  => $city->id,
									'r'  => '',
									'c'  => (isset($cat)) ? $cat->tid : '',
									'sc' => (isset($subCat)) ? $subCat->tid : '',
							];
							?>
							<option value="{!! $city->id !!}"
								@if ((isset($uriPathCityId) and $uriPathCityId == $city->id) or (request()->input('l')==$city->id)) selected @endif>
								{{ $city->name }}
							</option>
						@endforeach
					@endif
				</select>
				<?php /*<ul class="browse-list list-unstyled long-list">
					@if (isset($cities) and $cities->count() > 0)
						@foreach ($cities as $city)
							<?php
								$attr = ['countryCode' => config('country.icode')];
								$fullUrlLocation = lurl(trans('routes.v-search', $attr), $attr);
								$locationParams = [
									'l'  => $city->id,
									'r'  => '',
									'c'  => (isset($cat)) ? $cat->tid : '',
									'sc' => (isset($subCat)) ? $subCat->tid : '',
								];
							?>
							<li>
								@if ((isset($uriPathCityId) and $uriPathCityId == $city->id) or (request()->input('l')==$city->id))
									<strong>
										<a href="{!! qsurl($fullUrlLocation, array_merge(request()->except(array_keys($locationParams)), $locationParams)) !!}" title="{{ $city->name }}">
											{{ $city->name }}
										</a>
									</strong>
								@else
									<a href="{!! qsurl($fullUrlLocation, array_merge(request()->except(array_keys($locationParams)), $locationParams)) !!}" title="{{ $city->name }}">
										{{ $city->name }}
									</a>
								@endif
							</li>
						@endforeach
					@endif
				</ul> */?>
			</div>

			<div style="clear:both"></div>
				<div class="mt-3">
					<button class="btn btn-success btn-block" type="submit">{{ t('GO') }}</button>
				</div>
			</form>

		</div>
		
	</aside>



<a href="https://nghexay.com/danh-muc/kien-truc-noi-that" target="_blank" title="Tuy?n d?ng tháng 12" data-v-d78bfeb6=""><img width="100%" alt="Tuy?n d?ng tháng 12" class="lazy-load img-rounded" data-v-d78bfeb6="" src="https://i.imgur.com/QpDEmx5.png" lazy="loaded"></a>

</br></br>
<a href="https://phanmemdutoaneta.com/" target="_blank" title="Tuy?n d?ng tháng 12" data-v-d78bfeb6=""><img width="100%" alt="Tuy?n d?ng tháng 12" class="lazy-load img-rounded" data-v-d78bfeb6="" src="https://i.imgur.com/9m0cWjD.gif" lazy="loaded"></a>














</div>






@section('after_scripts')
	@parent
	<script>
		var baseUrl = '{{ $fullUrlNoParams }}';

		$(document).ready(function ()
		{
			$('input[type=radio][name=postedDate]').click(function() {
				var postedQueryString = $('#postedQueryString').val();
				
				if (postedQueryString != '') {
					postedQueryString = postedQueryString + '&';
				}
				postedQueryString = postedQueryString + 'postedDate=' + $(this).val();

				var searchUrl = baseUrl + '?' + postedQueryString;
				redirect(searchUrl);
			});

			$('#blocPostType input[type=checkbox]').click(function() {
				var postTypeQueryString = $('#postTypeQueryString').val();

				if (postTypeQueryString != '') {
					postTypeQueryString = postTypeQueryString + '&';
				}
				var tmpQString = '';
				$('#blocPostType input[type=checkbox]:checked').each(function(){
					if (tmpQString != '') {
						tmpQString = tmpQString + '&';
					}
					tmpQString = tmpQString + 'type[]=' + $(this).val();
				});
				postTypeQueryString = postTypeQueryString + tmpQString;

				var searchUrl = baseUrl + '?' + postTypeQueryString;
				redirect(searchUrl);
			});
		});
	</script>
@endsection