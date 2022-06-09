<!--
=========================================================
*  Argon Dokuwiki Template
*  Based on the Argon Design System by Creative Tim
*  Ported to Dokuwiki by Anchit (@IceWreck)
=========================================================
 -->

<?php
if (!defined('DOKU_INC')) {
    die();
}
/* must be run from within DokuWiki */
@require_once dirname(__FILE__) . '/tpl_functions.php'; /* include hook for template functions */

$showTools = !tpl_getConf('hideTools') || (tpl_getConf('hideTools') && !empty($_SERVER['REMOTE_USER']));
$showSidebar = page_findnearest($conf['sidebar']) && ($ACT == 'show');
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
		<link rel="icon" type="image/png" href="<?php echo tpl_basedir(); ?>images/favicon<?php echo tpl_getConf('favicon')?>.ico">
		<title>
			<?php tpl_pagetitle()?> [
			<?php echo strip_tags($conf['title']) ?>]</title>
		<?php tpl_metaheaders()?>
		<?php echo tpl_favicon(array(
			'favicon',
			'mobile',
		))
		?>

		<?php tpl_includeFile('meta.html')?>

		<!-- 
		I know the CSS and JS imports can be done within the style.ini and script.js files,
		but I had some issues with styling (and import order) there, so I'm doing those imports here. 
		-->
		<!--     Fonts and icons  -->
		<!-- <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet"> -->
		<link href="<?php echo tpl_basedir(); ?>assets/css/fonts.css" rel="stylesheet">
		<!-- CSS Files -->
		<link href="<?php echo tpl_basedir(); ?>assets/css/doku.css" rel="stylesheet" />
		<!-- JS -->
		<script defer="defer" src="<?php echo tpl_basedir(); ?>assets/js/core/bootstrap.min.js" type="text/javascript"></script>
		<script defer="defer" src="<?php echo tpl_basedir(); ?>assets/js/argon-design-system.min.js" type="text/javascript"></script>

	</head>

	<body class="docs ">
		<div id="dokuwiki__site">
			<header
				class="navbar navbar-horizontal navbar-expand navbar-dark flex-row align-items-md-center ct-navbar bg-primary py-2">


				<div class="header-title">
                    <?php
                    $showIcon = tpl_getConf('showIcon');
                    if ($showIcon):
                    ?>
                    <img width="30px" src="<?php echo tpl_basedir(); ?>/images/doku-icon<?php echo tpl_getConf('icon')?>.png"/>
                    <?php endif; ?>
                    <?php tpl_link(wl(), $conf['title'], 'accesskey="h" title="[H]"')?>
				</div>


				<div class="d-none d-sm-block ml-auto">
					<ul class="navbar-nav ct-navbar-nav flex-row align-items-center">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <?php
                                if (!empty($_SERVER['REMOTE_USER'])) {
//                            $loggedinas = tpl_getLang('loggedinas');
                                    ob_start();
                                    tpl_userinfo();
                                    $value = ob_get_contents();
                                    ob_end_clean();
                                    echo str_replace('Logged in as: ', '', $value);
                                }
                                ?>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                <?php
                                $menu_items = (new \dokuwiki\Menu\UserMenu())->getItems();
                                foreach($menu_items as $item) {
                                    echo '<a class="dropdown-item" href="'.$item->getLink().'" title="'.$item->getTitle().'">'
                                        .'<i class="argon-doku-navbar-icon">'.inlineSVG($item->getSvg()).'</i>'
                                        .$item->getLabel()
                                        . '<span class="a11y">'.$item->getLabel().'</span>'
                                        . '</a>';
                                }
                                ?>
                            </div>
                        </li>

						<li class="nav-item">
							<div class="search-form">
								<?php tpl_searchform()?>
							</div>
						</li>


					</ul>
				</div>
				<button class="navbar-toggler ct-search-docs-toggle d-block d-md-none ml-auto ml-sm-0" type="button"
					data-toggle="collapse" data-target="#ct-docs-nav" aria-controls="ct-docs-nav" aria-expanded="false"
					aria-label="Toggle docs navigation">
					<span class="navbar-toggler-icon"></span>
				</button>

			</header>



			<div class="container-fluid">
				<div class="row flex-xl-nowrap">


					<?php
					// Render the content initially
					ob_start();
					tpl_content(false);
					$buffer = ob_get_clean();
					?>

					<!-- left sidebar -->
					<div class="col-12 col-md-3 col-xl-2 ct-sidebar">
						<nav class="collapse ct-links" id="ct-docs-nav">
							<?php if ($showSidebar): ?>
							<div id="dokuwiki__aside" class="ct-toc-item active">
								<div class="leftsidebar">
									<?php tpl_includeFile('sidebarheader.html')?>
									<?php tpl_include_page($conf['sidebar'], 1, 1)?>
                                    <a class="ct-toc-link">
                                        <?php echo $lang['site_tools'] ?>
                                    </a>
									<?php tpl_includeFile('sidebarfooter.html')?>
								</div>
							</div>
							<?php endif;?>

                            <div class="ct-toc-item active">
                                <ul class="nav ct-sidenav">
                                    <?php
                                    $menu_items = (new \dokuwiki\Menu\SiteMenu())->getItems();
                                    foreach($menu_items as $item) {
                                        echo '<li>'
                                            .'<a class="" href="'.$item->getLink().'" title="'.$item->getTitle().'">'
                                            . $item->getLabel()
                                            . '</a></li>';
                                    }

                                    ?>
                                </ul>
                            </div>
						</nav>
					</div>


					<!-- center content -->

					<main class="col-12 col-md-9 col-xl-8 py-md-3 pl-md-5 ct-content" role="main">

						<div id="dokuwiki__top" class="site
						<?php echo tpl_classes(); ?>
						<?php echo ($showSidebar) ? 'hasSidebar' : ''; ?>">
						</div>

						<?php html_msgarea()?>
						<?php tpl_includeFile('header.html')?>


						<!-- Trace/Navigation -->
						<nav aria-label="breadcrumb" role="navigation">
							<ol class="breadcrumb">
								<?php if ($conf['breadcrumbs']) {?>
								<div class="breadcrumbs"><?php tpl_breadcrumbs()?></div>
								<?php }?>
								<?php if ($conf['youarehere']) {?>
								<div class="breadcrumbs"><?php tpl_youarehere()?></div>
								<?php }?>
							</ol>
						</nav>

                        <!-- Page Menu -->
                        <div class="argon-doku-page-menu">
                            <?php
                            $menu_items = (new \dokuwiki\Menu\PageMenu())->getItems();
                            foreach($menu_items as $item) {
                                echo '<li>'
                                    .'<a class="page-menu__link" href="'.$item->getLink().'" title="'.$item->getTitle().'">'
                                    .'<i class="">'.inlineSVG($item->getSvg()).'</i>'
                                    . '<span class="a11y">'.$item->getLabel().'</span>'
                                    . '</a></li>';
                            }
                            ?>
                        </div>

                        <!-- Floating Top Button -->
                        <div class="floating-top-button">
                            <?php
                            $menu_items = (new \dokuwiki\Menu\PageMenu())->getItems();
                            foreach($menu_items as $item) {
                                if ($item->getType() != "top") continue;
                                echo '<a class="btn" href="'.$item->getLink().'" title="'.$item->getTitle().'">'
                                    .'<i class="">'.inlineSVG($item->getSvg()).'</i>'
                                    . '<span class="a11y">'.$item->getLabel().'</span>'
                                    . '</a>';
                            }
                            ?>
                        </div>


						<!-- Wiki Contents -->
						<div id="dokuwiki__content">
							<div class="pad">
								<div class="page">
									<?php echo $buffer ?>
								</div>
							</div>							
						</div>

						<hr />

                        <!-- Footer -->
                        <footer>
                            <div class="row">
                                <p class="page-info"><?php tpl_pageinfo() /* 'Last modified' etc */ ?></p>
                            </div>

                            <?php
                                ob_start();
                                tpl_license('0');
                                $buffer = ob_get_clean();
                                if ($buffer):
                                ?>
                            <div class="card footer-card">
                                <div class="card-body">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col">
                                                <div id="dokuwiki__footer">
                                                    <div class="pad">
                                                        <div class="doc">
                                                        </div>
                                                        <?php tpl_license('0') /* content license, parameters: img=*badge|button|0, imgonly=*0|1, return=*0|1 */ ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endif;?>
                            <?php tpl_includeFile('footer.html') ?>
                            <?php tpl_indexerWebBug(); ?>
                        </footer>
					</main>

					<!-- Right Sidebar -->
					<div class="d-none d-xl-block col-xl-2 ct-toc">
						<div>
							<?php tpl_toc()?>
						</div>
					</div>

				</div>
			</div>
		</div>
	</body>

</html>
