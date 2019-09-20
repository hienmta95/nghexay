<?php
if (!isset($cacheExpiration)) {
    $cacheExpiration = (int)config('settings.other.cache_expiration');
}
?>

@include('home.inc.spacer')
<div class="container">
    <div class="row">
        <div class="col-md-12 page-content col-thin-right">
            <div class="content-box col-lg-12 layout-section">
                <div class="row row-featured row-featured-category section-tabs" style="padding-bottom: 15px">
               
			   <div class="col-lg-12 box-title no-border">
					<div class="inner">
						<h2>
							<span class="title-3">Việc <span style="font-weight: bold;">hấp dẫn</span></span>
													
													
							</a>
						</h2>
					</div>
				</div>
                    <div class="clearfix"></div>
                    
					
                            @if (isset($featured) and !empty($featured) and !empty($featured->posts))
                                <div id="featured-list" class="jobs-list ">
                                    <?php
                                    $groups = collect($featured->posts)->chunk(12);
                                    //dd($groups);
                                    foreach ($groups as $group):
                                    ?>
                                    <div class="row page-wrap">
                                        <?php
                                        foreach($group as $key => $post):

                                        // Get the Post's City
                                        $cacheId = config('country.code') . '.city.' . $post->city_id;
                                        $city = \Illuminate\Support\Facades\Cache::remember($cacheId, $cacheExpiration, function () use ($post) {
                                            $city = \App\Models\City::find($post->city_id);
                                            return $city;
                                        });
                                        if (empty($city)) continue;

                                        // Get the Post's Type
                                        $cacheId = 'postType.' . $post->post_type_id . '.' . config('app.locale');
                                        $postType = \Illuminate\Support\Facades\Cache::remember($cacheId, $cacheExpiration, function () use ($post) {
                                            $postType = \App\Models\PostType::findTrans($post->post_type_id);
                                            return $postType;
                                        });
                                        if (empty($postType)) continue;

                                        // Get the Post's Salary Type
                                        $cacheId = 'salaryType.' . $post->salary_type_id . '.' . config('app.locale');
                                        $salaryType = \Illuminate\Support\Facades\Cache::remember($cacheId, $cacheExpiration, function () use ($post) {
                                            $salaryType = \App\Models\SalaryType::findTrans($post->salary_type_id);
                                            return $salaryType;
                                        });
                                        if (empty($salaryType)) continue;

                                        // Convert the created_at date to Carbon object
                                        /*$post->created_at = \Date::parse($post->created_at)->timezone(config('timezone.id'));
                                        $post->created_at = $post->created_at->ago();*/
                                        ?>
                                        <div class="col-md-4">
                                            @include('home.inc.item-grid')
                                        </div>
                                        <!--/.job-item-->
                                        <?php endforeach;?>
                                    </div>
                                    <?php endforeach;?>
                                </div>

                            @endif
                    


             
			 
			 
                </div>
				
				
				
		
                       	  <div class="row row-featured row-featured-category section-tabs" style="padding-bottom: 15px">		
	
	
<div class="col-lg-12 box-title no-border">
					<div class="inner">
						<h2>
							<span class="title-3">Việc làm <span style="font-weight: bold;">Tuyển gấp</span></span>
													
													
							</a>
						</h2>
					</div>
				</div>
				
                          
						  <div id="vip-list" class="jobs-list ">
    @if (isset($vipJobs) and !empty($vipJobs))
        <?php
        $fgroups = collect($vipJobs)->chunk(12);
        //dd($groups);
        foreach ($fgroups as $fgroup):
        ?>
        <div class="row page-wrap">
            <?php
            foreach($fgroup as $key => $post):

            // Get the Post's City
            $cacheId = config('country.code') . '.city.' . $post->city_id;
            $city = \Illuminate\Support\Facades\Cache::remember($cacheId, $cacheExpiration, function () use ($post) {
                $city = \App\Models\City::find($post->city_id);
                return $city;
            });
            if (empty($city)) continue;

            // Get the Post's Type
            $cacheId = 'postType.' . $post->post_type_id . '.' . config('app.locale');
            $postType = \Illuminate\Support\Facades\Cache::remember($cacheId, $cacheExpiration, function () use ($post) {
                $postType = \App\Models\PostType::findTrans($post->post_type_id);
                return $postType;
            });
            if (empty($postType)) continue;

            // Get the Post's Salary Type
            $cacheId = 'salaryType.' . $post->salary_type_id . '.' . config('app.locale');
            $salaryType = \Illuminate\Support\Facades\Cache::remember($cacheId, $cacheExpiration, function () use ($post) {
                $salaryType = \App\Models\SalaryType::findTrans($post->salary_type_id);
                return $salaryType;
            });
            if (empty($salaryType)) continue;

            // Convert the created_at date to Carbon object
            /*$post->created_at = \Date::parse($post->created_at)->timezone(config('timezone.id'));
            $post->created_at = $post->created_at->ago();*/
            ?>
            <div class="col-md-4">
                @include('home.inc.item-grid')
            </div>
            <!--/.job-item-->
            <?php endforeach;?>
        </div>
        <?php endforeach;?>
    @endif




                        </div>
               
  </div>



            </div>
        </div>


    </div>
</div>



@section('modal_location')
    @parent
    @include('layouts.inc.modal.send-by-email')
@endsection

@push('css-stack')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.css">
    <style>
        .job-item img {
            display: block;
            width: 100%;
            height: auto;

        }
        .owl-nav {display: none}
    </style>
@endpush
@section('after_scripts')
    @parent
    <script src="https://cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.min.js"></script>
  
@endsection
