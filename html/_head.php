<!DOCTYPE html>
<html lang="nl">
  <head>
    <title><?= $site['titel']; ?> - <?php foreach($pages as $p): ?><?php if($page == $p['uri']): ?><?= $p['title']; ?><?php endif; ?><?php endforeach; ?></title>

    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

  <?php if($site['icoon']): ?>
    <link rel="icon" href="/bestanden/<?= $site['icoon']; ?>" />
  <?php endif; ?>

    <link rel="stylesheet" href="/css/normalize.css" />
		<link rel="stylesheet" href="/mediaelement/mediaelementplayer.css" />
		<link rel="stylesheet" href="/mediaelement/mediaelementplayer-ccad.css" />
    <link rel="stylesheet" href="/css/style.css" />
    <link rel="stylesheet" href="/css/colors.css" />
  </head>
  <body class="">
		<div class="overlay"></div>
    <header>
      <div class="container">
				<a href="/">
	        <img src="/bestanden/<?= $kop['logo']; ?>" alt="<?= $kop['beschrijving']; ?>" class="site-logo" />

	        <h1><?= $kop['titel']; ?></h1>

	        <p class="slogan"><?= $kop['tekst']; ?></p>
				</a>

        <a href="https://www.accessibility.nl">
					<img src="/img/logo-accessibility.png" alt="Het logo van Stichting Accessibility" class="acc-logo" />
				</a>
      </div>
    </header>

		<button type="button" class="open-menu phone-only">&#9776; <p class="screenreader">Open navigatiemenu</p></button>

    <nav class="main">
			<button type="button" class="close-menu phone-only">&times; <p class="screenreader">Sluit navigatiemenu</p></button>

      <div class="container">
				<ul>
				<?php $i = 0; $uriParts = explode('/', $page); ?>
				<?php foreach($pages as $p): ?>
				<?php if($p['menu']): ?>
					<li class="<?= (reset($uriParts) == $p['uri']) ? 'active' : ''; ?>">
						<a href="<?= ($i) ? '/'.$p['uri'].'/' : '/'; ?>"><?= $p['title']; ?></a>
					</li>
					<?php $i += 1; ?>
				<?php endif; ?>
				<?php endforeach; ?>
				</ul>
      </div>
    </nav>

	<?php if($submenu): ?>
		<nav class="sub">
			<div class="container">
				<ul>
				<?php foreach($submenu as $s): ?>
					<li>
						<a href="<?= $s['link']; ?>"><?= $s['title']; ?></a>
					</li>
				<?php endforeach; ?>
				</ul>
			</div>
		</nav>
	<?php endif; ?>
