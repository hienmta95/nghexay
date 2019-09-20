<?php
if (
	config('settings.other.ios_app_url') ||
	config('settings.other.android_app_url') ||
	config('settings.social_link.facebook_page_url') ||
	config('settings.social_link.twitter_url') ||
	config('settings.social_link.google_plus_url') ||
	config('settings.social_link.linkedin_url') ||
	config('settings.social_link.pinterest_url')
) {
	$colClass1 = 'col-lg-3 col-md-3 col-sm-3 col-xs-6';
	$colClass2 = 'col-lg-3 col-md-3 col-sm-3 col-xs-6';
	$colClass3 = 'col-lg-2 col-md-2 col-sm-2 col-xs-12';
	$colClass4 = 'col-lg-4 col-md-4 col-sm-4 col-xs-12';
} else {
	$colClass1 = 'col-lg-4 col-md-4 col-sm-4 col-xs-6';
	$colClass2 = 'col-lg-4 col-md-4 col-sm-4 col-xs-6';
	$colClass3 = 'col-lg-4 col-md-4 col-sm-4 col-xs-12';
	$colClass4 = 'col-lg-4 col-md-4 col-sm-4 col-xs-12';
}
?>

<script>
        var link_image = 'https://i.imgur.com/kdB691T.png';
        var link = 'https://nghexay.com/posts/create';
        var icon_close = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGQAAABkCAMAAABHPGVmAAAABGdBTUEAALGPC/xhBQAAAAFzUkdCAK7OHOkAAABjUExURQAAAHoqKJETEsAWFYwNDZQICYMlI0dFQdkREXcuK9QSEoMcG5gbGoYSEpYYGNcSEZkaGYsREcgVFagWFZgICNITEskSEtsREHIuLMEZGMAaGYYSEr0bGscZGM8VFH8SEqQWFrMI1wgAAAAadFJOUwBFwNP+/iYE/Q85l3jxWLE33aii6n1a4W/rvkm7xQAABJlJREFUaN61mueaqyAQhlFRwJpo1EQs5/6v8qBrpShY5nn2z+4mb4YpfDMGgDOG0N+P1GL3DW6wPYZnQ/pG4BZDRPZLAL4upDQEN0Gkv+vdoNQGjxnDBrS3DwHoMQZ5DwzoPcZgSQUHhvt6hjG8aTAwOtd7LBiA2H9+fJ45q6FeLHdAdJ9n/BgYgS5jr1EcvMxeGMi4uPQY3luXwewVpkmWJWkW+iZEC44M95BBcqfCTd3gqm7a5pcWRJMx9KqBcVgfOa6rtTVV7eQ6/gQzwz9geGW7ZQycps78I8ZYHbSD8dGpYgmjGs7NifdSYmxWPeOouXutlDFyfl8kx7C+Ho0MesgAiZIxcNoyljNeCyM7Yvi7jMEcX8KI6cw4vqSKQwbLtUzoF+HMoO/jdI+bQ0gfmz6hkZSh09w9XGlYXZW+3A/X0qnZpKn0LJs9iVcMPWXiNa0epMXjh46jhRFo9lGvbOpK78zS3plwYcA30e7XOW71MM3vNeqeP4bRjU5CR4tTV9jpVgH5Gl4/Lz1O868zDQiXAt8Et/oQeFaOEivFu2mwQLrogjTZ56wgxTWdQ6xExZkhXQYuGwpLKWeCdJ97lOIrw0xXKCDsvr1Jj7LyaTl3Zoh9oyL1U1XgP68b1a7vKOoksm6kgMJZQrOCdLC4DdHLcEfaVigNzql0uRZt5JDOzW7zxWoVkL9xGpmey6H64yHQbLhSMYizvgF4CEsykzFR9Z/ZRvGLEAqvp3K8nSokEEqvthhOltWtE4kU95ovpOS6SklQ5lKBc2kNwSs/HA4rrXG+WsmWC77kXA9unT9JbAlnBk+3S2GsaOMp1UOXg8BTrR8Bwo2rVZ0uJTVtUxaMd4YBEuH69dZ/jq/7gkDOM+p8u4IkmcvXvinDFxiYrB0hq5WH/szFmdPwI2ohrG034xBr/bZhtYS8YG1K6Tt4n1UCQDOKhfkBDKuWDsGKEhlpcIdP31Ytr5eJnmmYUD/qIRZU3U7jQMEc/ygKdRniSDzVoep0Z2eiT6wJESfi+mBjtDSA6K3TLAkoBKldJxqrr9kXT4MBSrEOfY2EnI4sso+29ayQxXVLm2rdom84UcARg/yEiGBLr6UGWuXSN6SvkFpYewSNx8DAYF97SRxp9C9X773IZKXHsjqsHRMtatNpFNuhlOKkWBhpkTGXlX2f3UW5uOsoTZ4foXlzmCk2pGQ9isz5m5uKKmuQTPCryi1fnKqx2a2K0PR4C8okX59bgZi/pmua/o3R0MpkYVHkr7ls6z+trcpjxGv4Puy/MyqXvSZjvrii3mdxT8WQ5Gen2f5aFicklqk/sf+eFLmDLx2bKRFPt6pz/VfVL6EsjyW98QsuWEo7/kkwApm4Hby2p7Eht6hkx+WcuHYPpBXtXpxIERhVfnHmJDZ1uKFHzK3rz3IdbtSz2ttya+VL4HEC+Grf0lhCCMdV+eCGVeP2Hby6uXDvai5tED/4pHcw+H6/HUVP9639xVAorgbut216tSF4xDbn9SPPQIrmxr6lHn9Wl3sBHrJVPZbPfVunmGKPX+A5G0agWj2232Ne8qt/yZ3fpfkPLjkNSsPf3E8AAAAASUVORK5CYII=';
        function closePopupBeta(){document.getElementById("popup_banner_beta").remove(),setCookie("showPopupBannerBeta",1,1)}function setCookie(e,n,o){var t="";if(o){var i=new Date;i.setTime(i.getTime()+24*60*60*1000),t="; expires="+i.toUTCString()}document.cookie=e+"="+(n||"")+t+"; path=/"}function getCookie(e){for(var n=e+"=",o=document.cookie.split(";"),t=0;t<o.length;t++){for(var i=o[t];" "==i.charAt(0);)i=i.substring(1,i.length);if(0==i.indexOf(n))return i.substring(n.length,i.length)}return null}1!=getCookie("showPopupBannerBeta")&&(document.addEventListener("DOMContentLoaded", function(event) { var e='<div id="popup_banner_beta"><div onclick="closePopupBeta()" class="mask_popup_banner_beta"></div><div class="content_popup_banner_beta"><img src="'+icon_close+'" class="close_icon" onclick="closePopupBeta()" alt="Close Image"><a href="'+link+'"><img src="'+link_image+'" alt="Image Popup Banner"/></a></div></div>';setTimeout(function(){document.body.innerHTML+=e},3000)}));
    </script>
    <style>
        #popup_banner_beta{position:fixed;width:100%;height:100vh;z-index:99999;top:0;left:0}.mask_popup_banner_beta{background:rgba(0,0,0,.38);cursor:pointer;position:absolute;width:100%;height:100vh;top:0;z-index:9;left:0}.content_popup_banner_beta{position:absolute;top:50%;left:50%;z-index:10;transform:translate(-50%,-50%);-moz-transform:translate(-50%,-50%);-o-transform:translate(-50%,-50%);-webkit-transform:translate(-50%,-50%)}.close_icon{position:absolute;top:-70px;right:-60px;width:70px;cursor:pointer}@media only screen and (max-width:480px){.content_popup_banner_beta{width:300px}.content_popup_banner_beta a img:nth-of-type(1){width:100%}.close_icon{top:-60px;right:-20px;width:50px}}
    </style>


<div class="ppocta-ft-fix">
    <div id="callNowButton"><a href="tel:0919600605"><i></i></a></div>
    <div id="zaloButton"><a href="https://zalo.me/0935780999" target="_blank"><i></i></a></div>
    <div id="messengerButton"><a href="https://m.me/tuyendungksxd" target="_blank"><i></i></a></div>
    <a id="registerNowButton" href="  </div>" target="_blank"><i></i></a>
</div>
<style type="text/css">
.ppocta-ft-fix {
    position: fixed;
    bottom: 5px;
    left: 5px;
    min-width: 120px;
    text-align: center;
    z-index: 9999;
}
#callNowButton {
    display: inline-block;
    position: relative;
    border-radius: 50%;
    color: #fff;
    width: 50px;
    height: 50px;
    line-height: 50px;
    box-shadow: 0px 0px 10px -2px rgba(0,0,0,.7);
}
#zaloButton {
    display: inline-block;
    width: 50px;
    height: 50px;
    background: #5ac5ef;
    border-radius: 50%;
    box-shadow: 0px 0px 10px -2px rgba(0,0,0,.7);
}
#messengerButton {
    display: inline-block;
    width: 50px;
    height: 50px;
    background: #4267b2;
    border-radius: 50%;
    box-shadow: 0px 0px 10px -2px rgba(0,0,0,.7);
}

#callNowButton a {
    display: block;
    text-decoration: none;
    outline: none;
    color: #fff;
    text-align: center;
}
#registerNowButton {
    display: inline-block;
    color: #fff;
    height: 50px;
    width: 50px;
    border-radius: 50%;
    margin-right: 5px;
    background: url(https://congtyweb.vn/wp-content/uploads/atp-support.png) center center no-repeat red;
    box-shadow: 0px 0px 10px -2px rgba(0,0,0,.7);
    text-decoration: none;
}
#callNowButton i {
    border-radius: 50%;
    display: inline-block;
    width: 50px;
    height: 50px;
    background: url(https://congtyweb.vn/wp-content/uploads/callbutton.png) center center no-repeat #090;
}
#zaloButton>a>i {
    background: url(https://congtyweb.vn/wp-content/uploads/zalo.png) center center no-repeat;
    background-size: 57%;
    width: 50px;
    height: 50px;
    display: inline-block;
}
#messengerButton>a>i {
    background: url(https://congtyweb.vn/wp-content/uploads/messenger.png) center center no-repeat;
    background-size: 57%;
    width: 50px;
    height: 50px;
    display: inline-block;
}
</style>
<style>@media only screen and (min-width: 1080px) {
  .ppocta-ft-fix {
    display: none !important;
  }
}</style>
  
    <div class="support-online">
<div class="support-content">
<a href="tel:0919600605" class="call-now" rel="nofollow">
<i class="fa fa-phone" aria-hidden="true"></i>
<div class="animated infinite zoomIn kenit-alo-circle"></div>
<div class="animated infinite pulse kenit-alo-circle-fill"></div>
<span>Hotline: 0919.600.605</span>
</a>
<a class="mes" href="https://m.me/tuyendungksxd" target="_blank" rel="nofollow" >
<i class="fa fa-facebook-official" aria-hidden="true"></i>
<span>Nhắn tin facebook</span>
</a>
<a class="zalo"  href="http://zalo.me/0935780999" target="_blank" rel="nofollow">
<i class="fa fa-comments"></i>
<span>Nhắn tin Zalo</span>
</a>
<a class="group" href="https://www.facebook.com/groups/tuyendungkysuxaydung/" target="_blank" rel="nofollow">
<i class="fa fa-users" aria-hidden="true"></i>
<span>Group Fanpage</span>
</a>
</div>
<a class="btn-support">
<div class="animated infinite zoomIn kenit-alo-circle"></div>
<div class="animated infinite pulse kenit-alo-circle-fill"></div>
<i class="fa fa-user-circle" aria-hidden="true"></i>
</a>
</div>
<style>
    .support-online { position: fixed; z-index: 999; left: 0; bottom: 50px; }
.support-online a { position: relative; margin: 20px 10px; text-align: left; width: 40px; height: 40px; }
.support-online i { width: 50px; height: 50px; background: #0e47b8; color: #fff; border-radius: 100%; font-size: 25px; text-align: center; line-height: 1.9; position: relative; z-index: 999; }
.support-online a span { border-radius: 2px; text-align: center; background: rgb(103, 182, 52); padding: 9px; display: none; width: 180px; margin-left: 10px; position: absolute; color: #ffffff; z-index: 999; top: 0px; left: 40px; transition: all 0.2s ease-in-out 0s; -moz-animation: headerAnimation 0.7s 1; -webkit-animation: headerAnimation 0.7s 1; -o-animation: headerAnimation 0.7s 1; animation: headerAnimation 0.7s 1; }
.support-online a:hover span { display: block; }
.support-online a { display: block; }
.support-online a span:before { content: “”; width: 0; height: 0; border-style: solid; border-width: 10px 10px 10px 0; border-color: transparent rgb(52, 73, 182) transparent transparent; position: absolute; left: -10px; top: 10px; }
.kenit-alo-circle-fill { width: 60px; height: 60px; top: -5px; position: absolute; -webkit-transition: all 0.2s ease-in-out; -moz-transition: all 0.2s ease-in-out; -ms-transition: all 0.2s ease-in-out; -o-transition: all 0.2s ease-in-out; transition: all 0.2s ease-in-out; -webkit-border-radius: 100%; -moz-border-radius: 100%; border-radius: 100%; border: 2px solid transparent; -webkit-transition: all .5s; -moz-transition: all .5s; -o-transition: all .5s; transition: all .5s; background-color: rgba(242, 112, 0, 0.78); opacity: .75; right: -15px; }
.kenit-alo-circle { width: 55px; height: 55px; top: -3px; right: -12px; position: absolute; background-color: transparent; -webkit-border-radius: 100%; -moz-border-radius: 100%; border-radius: 100%; border: 2px solid rgba(30, 30, 30, 0.4); opacity: .1; border-color: #fa6018ba; opacity: .5; }
.support-online .btn-support { cursor: pointer; }
</style>
<style>@media only screen and (max-width: 600px) {
  .support-online {
    display: none !important;
  }
}</style>
<script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
<script type="text/javascript">
$( document ).ready(function() {
        $('a.btn-support').click(function(e){
      e.stopPropagation();
      $('.support-content').slideToggle();
    });
    $('.support-content').click(function(e){
      e.stopPropagation();
    });
    $(document).click(function(){
      $('.support-content').slideUp();
    });
    });
</script>
		



<footer class="main-footer">
	<div class="footer-content">
		<div class="container">
			<div class="row">

				<div class="col-md-4">
					<div class="company-info">
					<p><strong>CÔNG TY TNHH XÂY DỰNG VÀ CÔNG NGHỆ BẢO AN</strong></p>
					<li>Địa chỉ trụ sở chính: Số 1, Ngách 80 Ngõ 592 Đường Trường Chinh, Phường Khương Thượng, Quận Đống Đa, Thành phố Hà Nội</li>
					<li>Giấy chứng nhận ĐKKD số 0108083227 do Phòng ĐKKD Sở KH&ĐT Hà Nội cấp lần đầu ngày 06/12/2017.</li>
					<li>Số điện thoại: 0246 66 625 256</li>
					<li>Email: contact@nghexay.com</li>
					</div>
				</div>

				@if (!config('settings.footer.hide_links'))
					<div class="{{ $colClass1 }}">
						<div class="footer-col">
							<h4 class="footer-title">{{ t('About us') }}</h4>
							<ul class="list-unstyled footer-nav">
								@if (isset($pages) and $pages->count() > 0)
									@foreach($pages as $page)
										<li>
											<?php
												$linkTarget = '';
												if ($page->target_blank == 1) {
													$linkTarget = 'target="_blank"';
												}
											?>
											@if (!empty($page->external_link))
												<a href="{!! $page->external_link !!}" rel="nofollow" {!! $linkTarget !!}> {{ $page->name }} </a>
											@else
												<?php $attr = ['slug' => $page->slug]; ?>
												<a href="{{ lurl(trans('routes.v-page', $attr), $attr) }}" {!! $linkTarget !!}> {{ $page->name }} </a>
											@endif
										</li>
									@endforeach
								@endif
							</ul>
						</div>
					</div>

					<div class="{{ $colClass2 }}">
						<div class="footer-col">
							<h4 class="footer-title">{{ t('Contact & Sitemap') }}</h4>
							<ul class="list-unstyled footer-nav">
								<li><a href="{{ lurl(trans('routes.contact')) }}"> {{ t('Contact') }} </a></li>
								<?php $attr = ['countryCode' => config('country.icode')]; ?>
								<li><a href="{{ lurl(trans('routes.v-companies-list', $attr), $attr) }}"> {{ t('Companies') }} </a></li>
								<li><a href="{{ lurl(trans('routes.v-sitemap', $attr), $attr) }}"> {{ t('Sitemap') }} </a></li>
								@if (\App\Models\Country::where('active', 1)->count() > 1)
									<li><a href="{{ lurl(trans('routes.countries')) }}"> {{ t('Countries') }} </a></li>
								@endif
							</ul>
						</div>
					</div>

					<div class="{{ $colClass3 }}">
						<div class="footer-col">
							<h4 class="footer-title">{{ t('My Account') }}</h4>
							<ul class="list-unstyled footer-nav">
								@if (!auth()->user())
									<li>
										@if (config('settings.security.login_open_in_modal'))
											<a href="#quickLogin" data-toggle="modal"> {{ t('Log In') }} </a>
										@else
											<a href="{{ lurl(trans('routes.login')) }}"> {{ t('Log In') }} </a>
										@endif
									</li>
									<li><a href="{{ lurl(trans('routes.register')) }}"> {{ t('Register') }} </a></li>
								@else
									<li><a href="{{ lurl('account/dashboard') }}"> {{ t('Personal Home') }} </a></li>
									@if (isset(auth()->user()->user_type_id))
										@if (in_array(auth()->user()->user_type_id, [1]))
											<li><a href="{{ lurl('account/my-posts') }}"> {{ t('My ads') }} </a></li>
											<li><a href="{{ lurl('account/companies') }}"> {{ t('My companies') }} </a></li>
										@endif
										@if (in_array(auth()->user()->user_type_id, [2]))
											<li><a href="{{ lurl('account/resumes') }}"> {{ t('My resumes') }} </a></li>
											<li><a href="{{ lurl('account/favourite') }}"> {{ t('Favourite jobs') }} </a></li>
										@endif
									@endif
								@endif
							</ul>
						</div>
					</div>

					@if (
						config('settings.other.ios_app_url') or
						config('settings.other.android_app_url') or
						config('settings.social_link.facebook_page_url') or
						config('settings.social_link.twitter_url') or
						config('settings.social_link.google_plus_url') or
						config('settings.social_link.linkedin_url') or
						config('settings.social_link.pinterest_url')
						)
						<div class="{{ $colClass4 }}">
							<div class="footer-col row">
								<?php
									$footerSocialClass = '';
									$footerSocialTitleClass = '';
								?>
								{{-- @todo: API Plugin --}}
								@if (config('settings.other.ios_app_url') or config('settings.other.android_app_url'))
									<div class="col-sm-12 col-xs-6 col-xxs-12 no-padding-lg">
										<div class="mobile-app-content">
											<h4 class="footer-title">{{ t('Mobile Apps') }}</h4>
											<div class="row ">
												@if (config('settings.other.ios_app_url'))
													<div class="col-xs-12 col-sm-6">
														<a class="app-icon" target="_blank" href="{{ config('settings.other.ios_app_url') }}">
															<span class="hide-visually">{{ t('iOS app') }}</span>
															<img src="{{ url('images/site/app-store-badge.svg') }}" alt="{{ t('Available on the App Store') }}">
														</a>
													</div>
												@endif
												@if (config('settings.other.android_app_url'))
													<div class="col-xs-12 col-sm-6">
														<a class="app-icon" target="_blank" href="{{ config('settings.other.android_app_url') }}">
															<span class="hide-visually">{{ t('Android App') }}</span>
															<img src="{{ url('images/site/google-play-badge.svg') }}" alt="{{ t('Available on Google Play') }}">
														</a>
													</div>
												@endif
											</div>
										</div>
									</div>
									<?php
										$footerSocialClass = 'hero-subscribe';
										$footerSocialTitleClass = 'no-margin';
									?>
								@endif


							</div>
						</div>
					@endif

					<div style="clear: both"></div>
				@endif

				<div class="col-lg-12">
					@if (!config('settings.footer.hide_payment_plugins_logos') and isset($paymentMethods) and $paymentMethods->count() > 0)
						<div class="text-center paymanet-method-logo">
							{{-- Payment Plugins --}}
							@foreach($paymentMethods as $paymentMethod)
								@if (file_exists(plugin_path($paymentMethod->name, 'public/images/payment.png')))
									<img src="{{ url('images/' . $paymentMethod->name . '/payment.png') }}" alt="{{ $paymentMethod->display_name }}" title="{{ $paymentMethod->display_name }}">
								@endif
							@endforeach
						</div>
					@else
						@if (!config('settings.footer.hide_links'))
							<hr>
						@endif
					@endif

					<div class="copy-info pull-left">
						© {{ date('Y') }} {{ config('settings.app.app_name') }}. {{ t('All Rights Reserved') }}.
						@if (!config('settings.footer.hide_powered_by'))
							@if (config('settings.footer.powered_by_info'))
								{{ t('Powered by') }} {!! config('settings.footer.powered_by_info') !!}
							@endif
						@endif
					</div>

						@if (config('settings.social_link.facebook_page_url') or
                                       config('settings.social_link.twitter_url') or
                                        config('settings.social_link.google_plus_url') or
                                        config('settings.social_link.linkedin_url') or
                                        config('settings.social_link.pinterest_url')
                                        )
							<div class="pull-right">
								<div class="{!! $footerSocialClass !!}">
									<ul class="list-unstyled list-inline footer-nav social-list-footer social-list-color footer-nav-inline">
										@if (config('settings.social_link.facebook_page_url'))
											<li>
												<a class="icon-color fb" title="" data-placement="top" data-toggle="tooltip" href="{{ config('settings.social_link.facebook_page_url') }}" data-original-title="Facebook">
													<i class="fa fa-facebook"></i>
												</a>
											</li>
										@endif
										@if (config('settings.social_link.twitter_url'))
											<li>
												<a class="icon-color tw" title="" data-placement="top" data-toggle="tooltip" href="{{ config('settings.social_link.twitter_url') }}" data-original-title="Twitter">
													<i class="fa fa-twitter"></i>
												</a>
											</li>
										@endif
										@if (config('settings.social_link.google_plus_url'))
											<li>
												<a class="icon-color gp" title="" data-placement="top" data-toggle="tooltip" href="{{ config('settings.social_link.google_plus_url') }}" data-original-title="Google+">
													<i class="fa fa-google-plus"></i>
												</a>
											</li>
										@endif
										@if (config('settings.social_link.linkedin_url'))
											<li>
												<a class="icon-color lin" title="" data-placement="top" data-toggle="tooltip" href="{{ config('settings.social_link.linkedin_url') }}" data-original-title="Linkedin">
													<i class="fa fa-linkedin"></i>
												</a>
											</li>
										@endif
										@if (config('settings.social_link.pinterest_url'))
											<li>
												<a class="icon-color pin" title="" data-placement="top" data-toggle="tooltip" href="{{ config('settings.social_link.pinterest_url') }}" data-original-title="Pinterest">
													<i class="fa fa-pinterest-p"></i>
												</a>
											</li>
										@endif
									</ul>
								</div>
							</div>
						@endif
				</div>

			</div>
		</div>
	</div>
</footer>
