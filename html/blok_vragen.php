<section class="vragen" id="<?= $unieke_bloknaam; ?>">
	<div class="container">
		<h2><?= $titel; ?></h2>

		<div class="vragen-container">
		<?php foreach($groepen as $i => $groep): ?>
			<div class="vraag">
				<h3><?= $groep['vraag']; ?></h3>
				<p class="tekst"><?= $groep['antwoord']; ?></p>
			</div>
		<?php endforeach; ?>
		</div>

		<button type="button" class="faq-expand" hidden>
			<?= $knoptekst; ?>
		</button>
	</div>
</section>
