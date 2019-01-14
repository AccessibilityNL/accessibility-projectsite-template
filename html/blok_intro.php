<section class="intro" id="<?= $unieke_bloknaam; ?>">
  <div class="container" style="background-image: url('/bestanden/<?= $afbeelding; ?>');">

		<img src="/bestanden/<?= $afbeelding; ?>" alt="" class="phone-only intro" />

    <div class="col">
      <h2><?= $titel; ?></h2>

      <div class="body"><?= $tekst; ?></div>

    <?php if($knoptekst && $knoplink): ?>
      <div class="button">
        <a href="<?= $knoplink; ?>"><?= $knoptekst; ?></a>
      </div>
    <?php endif; ?>
    </div>
  </div>
</section>
