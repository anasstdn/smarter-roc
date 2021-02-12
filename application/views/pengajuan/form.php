<style>
  #map-container {
    width: 100%;
    height: 400px;
  }
  #map {
    height: 100%;
  }

  #description {
    font-family: Roboto;
    font-size: 15px;
    font-weight: 300;
  }

  #infowindow-content .title {
    font-weight: bold;
  }

  #infowindow-content {
    display: none;
  }

  #map #infowindow-content {
    display: inline;
  }

  .pac-card {
    margin: 10px 10px 0 0;
    border-radius: 2px 0 0 2px;
    box-sizing: border-box;
    -moz-box-sizing: border-box;
    outline: none;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
    background-color: #fff;
    font-family: Roboto;
  }

  #pac-container {
    padding-bottom: 12px;
    margin-right: 12px;
  }

  .pac-controls {
    display: inline-block;
    padding: 5px 11px;
  }

  .pac-controls label {
    font-family: Roboto;
    font-size: 13px;
    font-weight: 300;
  }

  #pac-input {
    font-size: 15px;
    font-weight: 300;
    padding: 0 11px 0 13px;
    text-overflow: ellipsis;
  }

  #pac-input:focus {
    border-color: #4d90fe;
  }

  #title {
    color: #fff;
    background-color: #4d90fe;
    font-size: 25px;
    font-weight: 500;
    padding: 6px 12px;
  }

  #target {
    width: 345px;
  }

  .map_wrapper {
    padding: 14px;
    border: 1px solid #e0e0e0;
    background: #fff;
    box-shadow: 0 3px 3px rgba(0,0,0,0.19), 0 6px 6px rgba(0,0,0,0.23);
    border-radius: 5px;
  }


</style>

<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Form Pengajuan Keluhan</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Pengajuan Keluhan</a></li>
          <li class="breadcrumb-item active">Buat Pengajuan</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
 <div class="container-fluid">
  <div class="row">
    <!-- left column -->
    <div class="col-md-12">
      <!-- general form elements -->
      <div class="card card-primary">
        <div class="card-header">
          <h3 class="card-title">Form Isian</h3>
        </div>
        <form action="<?php echo base_url('pengajuan/store'); ?>" method="post" id="form" enctype="multipart/form-data">
          <div class="card-body">
            <div class="row col-lg-12" style="margin-bottom: 0.8rem">
              <label for="nama" style="font-size:9pt" class="col-form-label col-sm-1 offset-md-0">Latitude</label>
              <div class="col-lg-3">
                <input name="map_lat" placeholder="" id="map_lat" class="form-control form-control-sm" value="" type="text" readonly="">
                <span id="help-block"></span>
              </div>
              <label for="nama" style="font-size:9pt" class="col-form-label col-sm-1 offset-md-0">Longitude</label>
              <div class="col-lg-3">
                <input name="map_lng" placeholder="" id="map_lng" class="form-control form-control-sm" value="" type="text" readonly="">
                <span id="help-block"></span>
              </div>
            </div>

            <div class="row col-lg-12" style="margin-bottom: 0.8rem">
              <label for="nama" style="font-size:9pt" class="col-form-label col-sm-1 offset-md-0">Alamat Map</label>
              <div class="col-lg-7">
                <textarea rows="3" class="form-control form-control-sm" name="map_address" id="map_address" readonly></textarea>
                <span id="help-block"></span>
              </div>
            </div>
            <div class="row col-lg-12" style="margin-bottom: 0.8rem">
              <label for="nama" style="font-size:9pt" class="col-form-label col-sm-1 offset-md-0">Keterangan</label>
              <div class="col-lg-7">
                <textarea rows="5" class="form-control form-control-sm" name="keterangan" id="keterangan" required></textarea>
                <span id="help-block"></span>
              </div>
            </div>
            <div class="row col-lg-12" style="margin-bottom: 0.8rem">
              <label for="nama" style="font-size:9pt" class="col-form-label col-sm-1 offset-md-0">Foto</label>
              <div class="col-lg-7">
                <div class="input-group">
                  <div class="custom-file">
                    <input type="file" class="custom-file-input" id="foto" name="foto" required="">
                    <label class="custom-file-label" for="exampleInputFile">Silahkan Pilih File</label>
                  </div> 
                  <!-- <div class="input-group-append">
                    <span class="input-group-text" id="">Upload</span>
                  </div> -->
                </div>
                <span id="help-block"></span>
              </div>
            </div>

            <div class="row col-lg-12" style="margin-bottom: 0.8rem; margin-top: 5rem">
              <input name="cari_lokasi" placeholder="Cari Lokasi" id="pac-input" class="form-control form-control-sm" value="" type="text">
              <span id="help-block"></span>
            </div>

            <div class="row col-lg-12" style="margin-bottom: 0.8rem">
              <div id="map-container" class="map_wrapper" style="">
                <div id="map"></div>
              </div>
              <div id="infowindow-content">
                <span id="place-address"></span>
              </div>
            </div>
          </div>
          <div class="card-footer text-right">
            <button type="submit" id="submit" class="btn btn-primary">Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
</section>

<script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
<script defer
src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCMpVloajVzTS_WGKUnZr3KHh4XxLK28Pw&callback=initMap&&libraries=places&v=weekly">
</script>
<script src="<?php echo base_url();?>assets/template/plugins/jquery/jquery.min.js"></script>
<script src="<?php echo base_url();?>assets/template/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<script type="text/javascript">

  $(function(){
    bsCustomFileInput.init();

    $('#form').submit('#submit', function(e){
      if(!confirm('Apakah anda yakin untuk menyimpan data?')) {
        e.preventDefault();
      }
    })
  })

  function isInfoWindowOpen(infoWindow){
    var map = infoWindow.getMap();
    return (map !== null && typeof map !== "undefined");
  }

  function initMap() {

    var geocoder = new google.maps.Geocoder;
    var infowindow = new google.maps.InfoWindow({
      maxWidth: 300,
    });
    
        //Set Content of Info Window, with HTML Tag
        var infowindowContent = document.getElementById('infowindow-content');

        
        map_lat = '-7.782962938864839';
        map_lng = '110.36706447601318';
        
        var map_center = new google.maps.LatLng(map_lat,map_lng);
        var mapOptions = {
          zoom : 15,
          center : map_center,
          mapTypeControl: false,
          streetViewControl: false,
        }
        var map = new google.maps.Map(document.getElementById('map'), mapOptions);
        var marker = new google.maps.Marker({
          position: map_center,
          map: map,
          draggable: true
        });

    //Hide or Show InfoWindow by Click the Marker
    marker.addListener('click', function() {
      if (isInfoWindowOpen(infowindow)){
        infowindow.close(map, marker);
      } else {
        infowindow.open(map, marker);
      }
    });


    //Set Marker and center of map
    geocoder.geocode({'latLng': map_center }, function(results, status) {
      if (status == google.maps.GeocoderStatus.OK) {
        if (results[0]) {
          console.log(results[0]);
          
                    //set value of InfoWindow
                    infowindowContent.children['place-address'].textContent = results[0].formatted_address;
                    infowindow.setContent(infowindowContent);
                    infowindow.open(map, marker);

          //set value to form
          document.getElementById('map_lat').value = marker.getPosition().lat();
          document.getElementById('map_lng').value = marker.getPosition().lng();
          document.getElementById('map_address').value = results[0].formatted_address;
          
        }
      }
    });

    // Close InfoWindow when moving the marker
    google.maps.event.addListener(marker, 'drag', function() {
      infowindow.close();
    });

    // Open InfoWindow when Drop the Marker
    google.maps.event.addListener(marker, 'dragend', function() {
            //update lat long when drop the marker
            geocoder.geocode({'latLng': marker.getPosition()}, function(results, status) {
              if (status == google.maps.GeocoderStatus.OK) {
                if (results[0]) {
                  console.log(results[0]);

            //set value of InfoWindow
            infowindowContent.children['place-address'].textContent = results[0].formatted_address;
            infowindow.setContent(infowindowContent);
            infowindow.open(map, marker);

            //set value of form
            document.getElementById('map_lat').value = marker.getPosition().lat();
            document.getElementById('map_lng').value = marker.getPosition().lng();
            document.getElementById('map_address').value = results[0].formatted_address;

          }
        }
      });
          });


    // Search place by using search box (input the place's name)
    const input = document.getElementById("pac-input");
    const searchBox = new google.maps.places.SearchBox(input);
    
    //Listen for the event fired when the user selects a prediction and retrieve
        // more details for that place.
        map.addListener("bounds_changed", () => {
          searchBox.setBounds(map.getBounds());
        });
        

        
    // Listener when place changed
    searchBox.addListener("places_changed", () => {
      infowindow.close();

      const places = searchBox.getPlaces();
      const place = places[0];
      if (!place.place_id) {
        return;
      }
      geocoder.geocode({'placeId': place.place_id}, function(results, status) {
        if (status !== 'OK') {
          window.alert('Geocoder failed due to: ' + status);
          return;
        }
        
        // Set the position of the marker using location.
        map.setCenter(results[0].geometry.location);
        marker.setPosition(results[0].geometry.location);
        marker.setVisible(true);
        
        
        //set value of InfoWindow
        infowindowContent.children['place-address'].textContent = results[0].formatted_address;
        infowindow.setContent(infowindowContent);
        infowindow.open(map, marker);

        //set value of form
        document.getElementById('map_lat').value = marker.getPosition().lat();
        document.getElementById('map_lng').value = marker.getPosition().lng();
        document.getElementById('map_address').value = results[0].formatted_address;

      });
    });
  }
</script>