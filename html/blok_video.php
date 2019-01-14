<section class="video" id="<?= $unieke_bloknaam; ?>">
	<div class="container">
		<h2><?= $titel; ?></h2>

		<div class="accplayer">
			<video data-playtxt="Afspelen" data-pauzetxt="Pauzeren" data-enablead="Audiodescriptie inschakelen" data-disablead="Audiodescriptie uitschakelen" data-enablevolume="Geluid inschakelen" data-disablevolume="Geluid uitschakelen" data-enablecc="Ondertiteling inschakelen" data-disablecc="Ondertiteling uitschakelen" data-enablefullscreen="Volledige schermweergave inschakelen" data-disablefullscreen="Volledige schermweergave uitschakelen"
			<?php if($videostill): ?>poster="/bestanden/<?= $videostill; ?>"<?php endif; ?>
			<?php if($audiodescriptie): ?>data-ad="/bestanden/<?= $audiodescriptie; ?>"<?php endif; ?> preload="auto" crossorigin="anonymous" style="width: 100%; height: 100%;">
  			<source src="/bestanden/<?= $video; ?>" type="video/mp4" />
			<?php if($ondertitel): ?>
  			<track kind="subtitles" src="/bestanden/<?= $ondertitel; ?>" srclang="nl" />
			<?php endif; ?>
			</video>

			<dl role="presentation" class="Accordion" data-allow-toggle="" data-allow-multiple="">
		    <dt role="heading" aria-level="3">
		      <button aria-expanded="false" class="Accordion-trigger" aria-controls="video_download_<?= $unieke_bloknaam; ?>" id="video_download_trigger_<?= $unieke_bloknaam; ?>" type="button">
		        <span class="Accordion-title">
		          Download video
		        </span>
		        <span class="Accordion-icon"></span>
		      </button>
		    </dt>
		    <dd id="video_download_<?= $unieke_bloknaam; ?>" role="region" aria-labelledby="video_download_trigger_<?= $unieke_bloknaam; ?>" class="Accordion-panel" hidden="">
					<ul class="video_download">
						<li>
							<a href="/bestanden/<?= $video; ?>">Originele video</a>
							<p class="download_description">MP4 | <?= $this->hrFilesize(filesize(FILE_DIR.$video)); ?></p>
						</li>

						<?php if($downloadalternatief): ?>
							<li>
								<a href="/bestanden/<?= $downloadalternatief; ?>">Toegankelijke video</a>
								<p class="download_description">MP4 |  <?= $this->hrFilesize(filesize(FILE_DIR.$downloadalternatief)); ?></p>
							</li>
						<?php endif; ?>
					</ul>
    		</dd>
			<?php if($tekstalternatief): ?>
    		<dt role="heading" aria-level="3">
      		<button aria-expanded="false" class="Accordion-trigger" aria-controls="video_text_<?= $unieke_bloknaam; ?>" id="video_text_trigger_<?= $unieke_bloknaam; ?>" type="button">
		        <span class="Accordion-title">
		          Tekstalternatief
		        </span>
		        <span class="Accordion-icon"></span>
      		</button>
    		</dt>
    		<dd id="video_text_<?= $unieke_bloknaam; ?>" role="region" aria-labelledby="video_text_trigger_<?= $unieke_bloknaam; ?>" class="Accordion-panel" hidden="">
					<pre class="video_text"><?= file_get_contents(FILE_DIR.$tekstalternatief); ?></pre>
    		</dd>
			<?php endif; ?>
			</dl>
		</div>
	</div>
</section>
