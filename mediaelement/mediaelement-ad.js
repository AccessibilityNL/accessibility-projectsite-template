(function($) {
    $.extend(mejs.MepDefaults, {
        adFile: null,
        adSyncTolerance: 0.5,
        useFakeFullscreen: true
    });

    MediaElementPlayer.prototype.buildaudiodescription = function(player, controls, layers, media) {
        if (!player.isVideo || !player.options.adFile) {
            return;
        }

        var adPlayer = null;
        var isActive = false;
        $adBtn = $('<div class="mejs__button mejs__audiodescription-button mejs__audiodescription-inactive"><button></button></div>');
        $adBtn.appendTo(controls);
        $adBtn.on('click', function(e){
            e.preventDefault();
            if (adPlayer === null){
                loadAudio();
            }else{
                toggleState();
            }
        });

        function loadAudio(){
            $('<audio preload="auto" height="0" id="'+player.id+'-ad" width="0">' + ' <source src="' + player.options.adFile + '" type="audio/mp3" />' + '</audio>').appendTo(player.container);
                adPlayer = new MediaElement(player.id+'-ad', {
                    pluginWidth: 0,
                    pluginHeight: 0,
                    success: function(element) {
                        element.addEventListener('loadeddata', function(){
                            syncWithVideo();
                            toggleState();
                        }, false);
                    }
                });
        }

        function toggleState(){
            if ($adBtn.hasClass('mejs__audiodescription-inactive')){
                $adBtn.addClass('mejs__audiodescription-active');
                $adBtn.removeClass('mejs__audiodescription-inactive');
                isActive = true;
            }else{
                $adBtn.addClass('mejs__audiodescription-inactive');
                $adBtn.removeClass('mejs__audiodescription-active');
                isActive = false;
                adPlayer.pause();
            }
        }

        function syncWithVideo(){
            media.addEventListener('play', function() {
                if (isActive){
                    adPlayer.play();
                }
            }, false);
            media.addEventListener('pause', function() {
                if (isActive){
                    adPlayer.pause();
                }
            }, false);
            media.addEventListener('timeupdate', function() {
                var diff = 0;
                if (adPlayer !== null){
                    diff = Math.abs(media.currentTime - adPlayer.currentTime);
                    if (diff > player.options.adSyncTolerance) {
                        if (isActive){
                            if (!media.paused){
                                adPlayer.play();
                            }
                            adPlayer.setCurrentTime(media.currentTime);
                        }else{
                            adPlayer.pause();
                        }
                    }
                }
            }, false);
        }

    };
})(jQuery);
