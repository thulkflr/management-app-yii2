<?php

use yii\helpers\Url;

if (empty($config->api_key)) { ?>
    <div class="row">
        <div class="col-md-12">
            <div class="mb-3 card text-white card-body bg-info setting-alert" role="alert">
                <div class="d-flex">
                    <div class="align-content-center">
                        <strong>
                            <i class="pe-7s-attention font-size-xlg fs-6"></i>
                        </strong>
                    </div>
                    <div class="ps-3 pe-3">
                        <strong>
                            <?= Yii::t('app', 'This Option need integrate google map in your academy, To activate it, go to Integration Settings and add your Google Maps API key, You can follow the instructions provided there to learn how to get your Google Maps key') ?>
                        </strong>
                    </div>
                </div>
            </div>
            <div class=" mb-3 ">
                <?= $this->render('@backend/modules/settings/views/default/index/_option_card.php', [
                        'image' => '/admin/modules_images/google_maps.png',
                        'imageSize' =>52,
                        'addClass' =>'map-alert-popup-link',
                        'title' => Yii::t('app', 'Go To Integration'),
                        'subTitle' => Yii::t('app', 'Find Google Map Integration, follow instruction and activate the google map account.'),
                        'link' => Url::to(['/organization/third-party-setting']),
                ]) ?>
            </div>
        </div>
    </div>

<?php
    return false;
}
?>
<div style="width: 100%;height: 500px" id="map"></div>
<script src="https://maps.googleapis.com/maps/api/js?key=<?= $config->api_key ?>&callback=initMap&v=weekly&channel=2"
        async></script>
<script>
    initMap();

    function initMap() {
        if (typeof google == 'undefined') {
            return;
        }

        var map = null;
        var selectedLatLang = '<?=$value?>';
        var selectedLatLangArray = selectedLatLang.split(',');
        var geocoder = new google.maps.Geocoder();
        var address = "<?=Yii::$app->organization->country->name??''?>";

        geocoder.geocode({'address': address}, function (results, status) {
            if (status != google.maps.GeocoderStatus.OK) {
                return false;
            }

            const myLatlng = {
                lat: selectedLatLangArray.length == 2 ? Number(selectedLatLangArray[0]) : results[0].geometry.location.lat(),
                lng: selectedLatLangArray.length == 2 ? Number(selectedLatLangArray[1]) : results[0].geometry.location.lng()
            };

            map = new google.maps.Map(document.getElementById("map"), {
                zoom: 5,
                center: myLatlng,
            });

            // Create the initial InfoWindow.
            let infoWindow = new google.maps.InfoWindow({
                content: selectedLatLangArray.length == 2 ? selectedLatLang : "Click the map to get Lat/Lng!",
                position: myLatlng,
            });

            infoWindow.open(map);
            // Configure the click listener.
            map.addListener("click", (mapsMouseEvent) => {
                // Close the current InfoWindow.
                infoWindow.close();
                // Create a new InfoWindow.
                infoWindow = new google.maps.InfoWindow({
                    position: mapsMouseEvent.latLng,
                });

                const latlng = mapsMouseEvent.latLng.lat() + ',' + mapsMouseEvent.latLng.lng();
                $('#<?=$target?>').find('input[type="text"]').val(latlng);
                $('#<?=$target?>').find('input[type="hidden"]').val(latlng);
                infoWindow.setContent(latlng);
                infoWindow.open(map);
            });
        });
    }
</script>