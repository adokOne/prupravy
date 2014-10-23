<div id="gmap" style="width: 50%; height: 99%; float: left;">
	Завантаження карти...
</div>
<div style="width: 50%; height: 99%;  float: left;background-color: #d0d0d0;">
	<div id="cityselect" style="height: 25px; text-align: center;" >
		Місто:
		<select id="city_id" onchange="load_districts()" style="width: 300px;">
		<?php foreach ($cities as $city){ ?>
			 <option <?php echo $city->id==2 ? 'selected' :"" ?> value="<?php echo $city->id ?>"><?php echo $city->name ?></option>
		<?php } ?>
		</select>
	</div>
	<div id="distrlist">
		
	</div>
	<div id="distrform" style="height: 100px; padding: 10px; font-size: 13px;" >
		
		Назва района: <input type="text" id="new_district_name" onfocus="setMapCenter()">
		Колір: #<input type="text" id="new_district_color" value="ff0000" style="width: 50px;"><br><br>
		Координати центра: Lon:<input type="text" id="new_district_center_lon" onfocus="setMapCenter()" style="width: 120px;"> Lat:<input type="text" id="new_district_center_lat" onfocus="setMapCenter()" style="width: 120px;"><br><br>
		Збільшення: <input type="text" id="new_district_zoom" value="13" style="width: 30px;"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button onclick="createDistrict();">Зберігти</button>
		<br><br>
		
		
		<fieldset style="border: 1px solid silver;">
			<legend>Координати полігона</legend>
			<form action="" id="polyform">
			
			</form>
			<button onclick="addMarker()" id="addMarkerButton">Створити полігон</button>
		</fieldset>
		
		<fieldset style="border: 1px solid silver;">
			<legend>Координати маркера</legend>
			<br>
			Latitude: <input type="text" value="" id="longitude" style="width: 118px;">
			Longitude: <input type="text" value="" id="latitude" style="width: 118px;">
			<br>
			<br>
		</fieldset>
		
	</div>

</div>
