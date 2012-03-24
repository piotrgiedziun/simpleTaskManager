<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>Simple Task Manager</title>
	<link rel="stylesheet" href="<?=base_url();?>assets/css/style.css" type="text/css" media="screen" />
        <link  href="http://fonts.googleapis.com/css?family=Copse:regular" rel="stylesheet" type="text/css" >
	<!--[if IE]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
        <script>
            <? foreach($javascript_code as $code): ?>
                <?=$code;?>
            <? endforeach; ?>
        </script>
</head>
<body>
<div id="wrapper"><!-- #wrapper -->

	<nav><!-- top nav -->
		<div class="menu">
                        <? if(is_logged()): ?>
                        <ul>
                            <li><a class="menu_item" href="<?=base_url();?>">Home</a></li>
                            <li><a class="menu_item" href="<?=base_url();?>user/profile">My Account</a></li>
                            <li><a target="_blank" class="menu_item" href="http://code.google.com/p/simple-task-manager-project/">Project</a></li>
                            <li><a target="_blank" class="menu_item" href="http://code.google.com/p/simple-task-manager-project/issues/list">Issues</a></li>
                            <li><a class="menu_item" href="<?=base_url();?>user/logout">Logout</a></li>
                        </ul>
                        <? else: ?>
			<ul>
                            <li><a class="menu_item" href="<?=base_url();?>">Home</a></li>
                            <li><a class="menu_item" href="<?=base_url();?>user/login">Login</a></li>
                            <li><a class="menu_item" href="<?=base_url();?>signup">Join Us!</a></li>
                            <li><a target="_blank" class="menu_item" href="http://code.google.com/p/simple-task-manager-project/">Project</a></li>
                            <li><a target="_blank" class="menu_item" href="http://code.google.com/p/simple-task-manager-project/issues/list">Issues</a></li>
			</ul>
                        <? endif; ?>
		</div>
	</nav><!-- end of top nav -->
	
        <header><!-- header -->
            <h1>Simple Task Manager</h1>
	</header><!-- end of header -->
	
	<section id="main"><!-- #main content area -->
            <section id="singlecol">
                <article>
                    <?=$body;?>
                </article>
            </section>
<!-- Triple columns with images, captions, and info blocks -->
			<article id="triplecols">
						<section class="tripleblocks tripleleftblock"> 
							<h2>How it works?</h2>
                            <p>This being said, the ownership issues inherent in dominant thematic implementations cannot be understated vis-a vis</p>
						</section>
						<section class="tripleblocks triplemiddleblock"> 
                            <h2>Mobility</h2>
                            <p>This being said, the ownership issues inherent in dominant thematic implementations cannot be understated vis-a vis</p>			</section>
						<section class="tripleblocks triplerightblock"> 
							<h2>Open Source</h2>
                            
						 <p>This being said, the ownership issues inherent in dominant thematic implementations cannot be understated vis-a vis</p></section>
				</article>
	</section><!-- end of #main content -->

		<footer>
		<section id="footer-area">

			<section id="footer-outer-block">
					<aside class="footer-segment first">
							<h3>License</h3>
					<p>
                                        This content is released under the terms of either the <a href="http://en.wikipedia.org/wiki/MIT_License">MIT License</a> or the <a href="http://www.gnu.org/licenses/gpl-2.0.html">GNU General Public License (GPL) Version 2</a>.<br />
                                        Template by <a href="http://freehtml5templates.com">HTML5fan</a> is released under <a href="http://creativecommons.org/licenses/by/3.0/us/">Creative Commons Attribution 3.0 United States</a>
                                        </p>
                                        <p id="copyright">
                                        &copy; <?=date('Y');?> <a target="_blank" href="http://code.google.com/p/simple-task-manager-project/">Simple Task Manager</a>
                                        </p>
					</aside><!-- end of #first footer segment -->

			</section><!-- end of footer-outer-block -->

		</section><!-- end of footer-area -->
	</footer>
	
</div><!-- #wrapper -->
<script type="text/javascript">
  var uvOptions = {};
  (function() {
    var uv = document.createElement('script'); uv.type = 'text/javascript'; uv.async = true;
    uv.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'widget.uservoice.com/glgUBoOCAR6qMoe36ilnA.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(uv, s);
  })();
</script>
<!-- Free template created by http://freehtml5templates.com and modified by http://dedide.info 19/03/2011 -->
</body>
</html>