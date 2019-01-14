<section class="quiz" id="<?= $unieke_bloknaam; ?>">
	<div class="container">
		<h2><?= $titel; ?></h2>

		<div class="quiz-container" aria-live="polite">
		<?php shuffle($groepen); foreach($groepen as $i => $quiz): ?>
			<div class="quiz-entry <?= ($i == 0) ? 'active' : ''; ?>">
				<h3><?= $quiz['stelling']; ?></h3>

				<div class="action">
					<button type="button" data-antwoord="waar">Waar</button>
					<button type="button" data-antwoord="niet_waar">Niet waar</button>
				</div>

				<p class="quiz-answer waar"><?= $quiz['waar']; ?></p>
				<p class="quiz-answer niet_waar"><?= $quiz['niet_waar']; ?></p>

				<button type="button" class="next">Volgende</button>
			</div>
		<?php endforeach; ?>
		</div>
	</div>
</section>
