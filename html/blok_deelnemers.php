<section class="deelnemers" id="<?= $unieke_bloknaam; ?>">
  <div class="container">
    <h2><?= $titel; ?></h2>

    <ul class="deelnemers-items col<?= $kolommen; ?>">
		<?php foreach($groepen as $deelnemer): ?>
			<li class="deelnemer">
				<img src="/bestanden/<?= $deelnemer['logo']; ?>" alt="<?= $deelnemer['beschrijving']; ?>" />
			</li>
		<?php endforeach; ?>
		</ul>
  </div>
</section>
