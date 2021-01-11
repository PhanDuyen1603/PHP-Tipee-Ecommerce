<title><?php echo e($seo['title']); ?></title>
<meta name="keywords" content="<?php echo e($seo['keywords']); ?>" />
<meta name="description" content="<?php echo e($seo['description']); ?>" />
<!--Facebook Seo-->
<meta property="og:title" content="<?php echo e($seo['og_title']); ?>" />
<meta property="og:description" content="<?php echo e($seo['og_description']); ?>" />
<meta property="og:url" content="<?php echo e($seo['og_url']); ?>" />
<meta property="og:type" content="article" />
<meta property="og:image" content="<?php echo e($seo['og_img']); ?>" />
<link rel="canonical" href="<?php echo e($seo['current_url']); ?>" />
<?php if($seo['current_url_amp'] !=''): ?>
	<?php /* <link rel="amphtml"  href="{{ $seo['current_url_amp'] }}" /> */ ?>
<?php 
/* <link rel="alternate" media="handheld" href="{{ $seo['current_url'] }}" />
<link rel="alternate" media="only screen and (max-width: 761px)" href="{{ $seo['current_url'] }}" />
<link rel="amphtml"  href="{{ $seo['current_url_amp'] }}" />*/
 ?>
<?php endif; ?>	
<?php /*
<!--<link rel="alternate" media="handheld" href="{{ $seo['current_url'] }}" />
<link rel="alternate" media="only screen and (max-width: 761px)" href="{{ $seo['current_url'] }}" />-->
@if($seo['current_url_amp'] !='')
<!--<link rel="amphtml"  href="{{ $seo['current_url_amp'] }}" />-->
@endif
<!--End-->
*/ ?>
<link href='//fonts.googleapis.com' rel='dns-prefetch'/>
<link href='//ajax.googleapis.com' rel='dns-prefetch'/>
<link href='//apis.google.com' rel='dns-prefetch'/>
<link href='//connect.facebook.net' rel='dns-prefetch'/>
<link href='//www.facebook.com' rel='dns-prefetch'/>
<link href='//twitter.com' rel='dns-prefetch'/>
<link href='//www.google-analytics.com' rel='dns-prefetch'/>
<link href='//www.googletagservices.com' rel='dns-prefetch'/>
<link href='//pagead2.googlesyndication.com' rel='dns-prefetch'/>
<link href='//googleads.g.doubleclick.net' rel='dns-prefetch'/>
<link href='//static.xx.fbcdn.net' rel='dns-prefetch'/>
<link href='//platform.twitter.com' rel='dns-prefetch'/>
<link href='//syndication.twitter.com' rel='dns-prefetch'/>
<base href="<?php echo e(route('index')); ?>"/>
<meta name="robots" content="index,follow,noodp" />
<meta name="author" content="E-Bike" />
<meta name="copyright" content="Copyright&copy;2020 E-Bike.　All Right Reserved." />
<meta http-equiv="content-script-type" content="text/javascript" />
<meta http-equiv="content-style-type" content="text/css" />
<meta http-equiv="content-language" content="vi" />
<meta name="robots" content="notranslate"/>
<link rev="made" href="mailto:custom-e-bike@g-s-m.co.jp" />
<meta name="distribution" content="global" />
<meta name="rating" content="general" />
<meta property="og:site_name" content="E-Bike" />
<link rel="index" href="<?php echo e(asset('/')); ?>" /><?php /**PATH C:\xampp\htdocs\Lap-Trinh-Web-Team-Official\resources\views/admin/partials/seo.blade.php ENDPATH**/ ?>