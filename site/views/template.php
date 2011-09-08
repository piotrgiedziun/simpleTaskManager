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
                            <li><a class="menu_item" href="#">More</a></li>
                            <li><a class="menu_item" href="#">Contact</a></li>
                            <li><a class="menu_item" href="<?=base_url();?>user/logout">Logout</a></li>
                        </ul>
                        <? else: ?>
			<ul>
				<li><a class="menu_item" href="<?=base_url();?>">Home</a></li>
				<li><a class="menu_item" href="<?=base_url();?>user/login">Login</a></li>
				<li><a class="menu_item" href="<?=base_url();?>user/create_account">Join Us!</a></li>
				<li><a class="menu_item" href="#">More</a></li>
                                <li><a class="menu_item" href="#">Contact</a></li>
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
<!-- 
				<section id="doublecols">
				  <article class="doubleblocks doubleleftblock">
				    <h2>What we do</h2>
				    <p>Perhaps a re-engineering of your current world view will re-energize your online nomenclature to enable a new holistic interactive enterprise internet communication solution. </p>
<p>Upscaling the resurgent networking exchange solutions, achieving a breakaway systemic electronic data interchange system synchronization, thereby exploiting technical environments for mission critical broad based capacity constrained systems. </p>
<p>Fundamentally we transform well designed actionable information whose semantic content is virtually null. </p>
<p>To more fully clarify the current exchange, a few aggregate issues will require addressing to facilitate this distributed communication venue. </p>
<p>In integrating non-aligned structures into existing legacy systems, a holistic gateway blueprint is a backward compatible packaging tangible of immeasurable strategic value in right-sizing conceptual frameworks when thinking outside the box. </p>

				  </article>
				  <article class="doubleblocks doublerightblock">
				    <h2>Why you need us</h2>

<p>In order to properly merge and articulate these core assets, an acquisition statement outlining the information architecture, leading to a racheting up of convergence across the organic platform.</p><p>This creates an opportunity without precedent in current applicability transactional modeling. </p>
<p>Implementing these goals requires a careful examination to encompass an increasing complex out sourcing disbursement to ensure the extant parameters are not exceeded while focusing on infrastructure cohesion. </p>
<p>Dynamic demand forecasting indicates that a mainstream approach may establish a basis for leading-edge information processing to insure the diversity of granularity in encompassing expansion of content provided within the multimedia framework under examination. </p>
<p>Empowerment in information design literacy demands the immediate and complete disregard of the entire contents of this cyberspace communication. </p>

				  </article>
				</section>
-->
<!-- Triple columns with images, captions, and info blocks -->
			<article id="triplecols">
						<section class="tripleblocks tripleleftblock"> 
							<h2>How it works?</h2>
                            <p>This being said, the ownership issues inherent in dominant thematic implementations cannot be understated vis-a vis</p>
						</section>
						<section class="tripleblocks triplemiddleblock"> 
                            <h2>Bolder</h2>
                            <p>This being said, the ownership issues inherent in dominant thematic implementations cannot be understated vis-a vis</p>			</section>
						<section class="tripleblocks triplerightblock"> 
							<h2>Boldest</h2>
                            
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
					</aside><!-- end of #first footer segment -->



					
					<aside class="footer-segment last">
							<h3>Legalese</h3>
								<p>
                                                                    &copy; <?=date('Y');?> <a target="_blank" href="https://github.com/piotrgiedziun/simple-task-manager">Simple Task Manager</a>
                                                                </p>
					</aside><!-- end of #last footer segment -->

			</section><!-- end of footer-outer-block -->

		</section><!-- end of footer-area -->
	</footer>
	
</div><!-- #wrapper -->
<!-- Free template created by http://freehtml5templates.com and modified by http://dedide.info 19/03/2011 -->
</body>
</html>