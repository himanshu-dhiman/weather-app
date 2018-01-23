<?php 
	include('header.php');
?>

<div class="container-fluid page-init page-weather">
<div class="row">
	<div class="col-md-8 col-12">	
		<div class="page-heading">
			<p style="font-size: 45px;">Your Locations</p>
		</div>
		<hr>	
		<div class="location-tabs">
			<ul class="nav nav-tabs" id="location_tabs" >
				<?php 
					$i = 0;
					foreach ($locations->saved_locations as $location) {
				?>
				<li class="nav-item" id="nav_link-<?php echo $i; ?>">
					<a class="nav-link <?php if($i == 0) echo "active show"; ?> " data-toggle="tab" href="#location-<?php echo $i; ?>" role="tab"><?php echo $location['full_name']; ?></a>
				</li>
				<?php 
						$i++;
					}
				?>
			</ul>
		</div>&deg;
		<div class="tab-content" role="tablist">
			<?php 
				$i = 0;
				foreach ($locations->saved_locations as $location) {
			?>
			<div class="tab-pane fade <?php if($i == 0) echo "show active";?>" id="location-<?php echo $i ?>" role="tabpanel">
				<div class="condition-data row">
					<div class="weather-content col-12 col-md-6">
						<?php 
							echo "<img src=".$location['icon_url'].">&nbsp;";
							echo $location['weather']."<br />";
							echo "City: ".$location['city']."<br />";
							echo "State: ".$location['state']."<br />";
							echo "Country: ".$location['country']."<br />";
							if ($ip_country == 'US') {
								echo "Temperature: ".$location['temp_f']. " &#8457;<br />";
							} else {
								echo "Temperature: ".$location['temp_c']. " &#8451;<br />";
							}
						?>
					</div>
					<div class="del-button-row col-12 col-md-6">
						<button class="btn btn-danger del-button btn-sm" data-tab_id="<?php echo $i; ?>" data-id="<?php echo $location['id']; ?>" >Delete location</button>
					</div>
				</div>
			</div>
			<?php 
					$i++;
				}
			?>
		</div>
	</div>
	<div class="col-12 col-md-4">
		<div class="row add-button-row">
			<div class="col-12">
				<div class="heading">
					<p style="font-size: 30px; text-align: center;">Add Location</p>
				</div>
				<?php require_once('views/weather-search.php'); ?>
			</div>
		</div>
	</div>
</div>
</div>
