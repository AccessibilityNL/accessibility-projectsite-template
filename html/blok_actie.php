<section class="actie" id="<?= $unieke_bloknaam; ?>">
	<div class="container">
		<h2><?= $titel; ?></h2>
	</div>

	<div class="actie-container">
		<div class="container" style="background-image: url('/bestanden/<?= $afbeelding; ?>');">

			<img src="/bestanden/<?= $afbeelding; ?>" alt="" class="phone-only actie" />

			<div class="inhoud">
				<h3><?= $koptekst; ?></h3>

				<div class="tekst"><?= $tekst; ?></div>

			<?php if($knoptekst && $knoplink): ?>
	      <div class="button">
	        <a href="<?= $knoplink; ?>"><?= $knoptekst; ?></a>
	      </div>
	    <?php endif; ?>
			</div>
		</div>
	</div>
</section>
