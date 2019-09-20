<div id="vip-list" class="jobs-list   owl-carousel">
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