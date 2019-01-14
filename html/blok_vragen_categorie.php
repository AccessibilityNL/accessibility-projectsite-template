<section class="vragen_categorie" id="<?= $unieke_bloknaam; ?>">
	<div class="container">
		<nav class="filter">
			<ul>
			<?php foreach($groepen['cat'] as $cat): ?>
				<li>
					<button type="button" data-cat="<?= $cat; ?>"><?= $cat; ?></button>
				</li>
			<?php endforeach; ?>
			</ul>
		</nav>

		<div class="vragen-container" ara-live="polite">
		<?php foreach($groepen as $i => $groep): ?>
		<?php if(is_numeric($i)): ?>
			<div class="vraag" data-cat="<?= strtolower($groep['categorie']); ?>">
				<h3><?php if($groep['link']): ?><a href="<?= $groep['link']; ?>"><?php endif; ?><?= $groep['vraag']; ?><?php if($groep['link']): ?></a><?php endif; ?></h3>
				<p class="tekst"><?= $groep['antwoord']; ?></p>
			</div>
		<?php endif; ?>
		<?php endforeach; ?>
		</div>
	</div>
</section>
