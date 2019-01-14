<section class="tabel" id="<?= $unieke_bloknaam; ?>">
	<div class="container">
		<table class="sortable" aria-live="polite">
			<thead>
				<tr>
					<td></td>
				<?php foreach($groepen['kolommen'] as $kolom): ?>
					<th>
						<button type="button">
							<?= $kolom; ?>

							<p class="screenreader sort-asc">Sorteer tabel op deze kolom (oplopend)</p>
							<p class="screenreader sort-desc">Sorteer tabel op deze kolom (aflopend)</p>
						</button>
					</th>
				<?php endforeach; ?>
				</tr>
			</thead>
			<tbody>
			<?php foreach($groepen['rijen'] as $rij): ?>
				<tr>
					<th scope="row"><?php if($rij['link']): ?><a href="<?= $rij['link']; ?>"><?php endif; ?><?= $rij['koptekst']; ?><?php if($rij['link']): ?></a><?php endif; ?></th>
				<?php foreach($rij['inhoud'] as $cel): ?>
					<td><?= $cel; ?></td>
				<?php endforeach; ?>
				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</section>
