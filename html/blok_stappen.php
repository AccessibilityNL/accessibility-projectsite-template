<section class="stappen" id="<?= $unieke_bloknaam; ?>">
  <div class="container">
    <h2><?= $titel; ?></h2>

    <div class="stappen-container col<?= $this->clamp(count($groepen), 2, 4); ?>">
    <?php foreach($groepen as $num => $stap): ?>
      <div class="stap col">
        <img src="/bestanden/<?= $stap['afbeelding']; ?>" alt="<?= $stap['beschrijving']; ?>" class="afbeelding" />

        <div class="inhoud">
          <p class="nummer"><?= ($num + 1); ?></p>
          <p class="tekst"><?= $stap['tekst']; ?></p>
        </div>
      </div>
    <?php endforeach; ?></div>
  </div>
</section>
