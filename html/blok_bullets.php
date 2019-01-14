<section class="bullets" id="<?= $unieke_bloknaam; ?>">
  <div class="container">
    <h2><?= $titel; ?></h2>

    <div class="bullets-container">
    <?php foreach($groepen as $num => $bullet): ?>
      <div class="bullet" style="background-image: url('/bestanden/<?= $bullet['afbeelding']; ?>');">
				<h3><?= $bullet['koptekst']; ?></h3>
        <p class="tekst"><?= $bullet['tekst']; ?></p>
      </div>
    <?php endforeach; ?>
  </div>
</section>
