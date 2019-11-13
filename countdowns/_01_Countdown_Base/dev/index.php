<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/css/tempusdominus-bootstrap-4.min.css" />
	<link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@simonwep/pickr/dist/themes/nano.min.css"/>
	<link rel="stylesheet" type="text/css" href="styles.css">


	<title></title>
</head>
<body>

	<div class="grid-container">
		<div class="tools grid-section">
			<form>
				<div class="form-group">
					<label for="datetimepicker1" class="h5">Countdown end date</label>
					<div class="input-group date" id="datetimepicker" data-target-input="nearest">
	                    <input type="text" class="form-control datetimepicker-input" data-target="#datetimepicker1" id="datetimepicker1" required>
	                    <div class="input-group-append" data-target="#datetimepicker1" data-toggle="datetimepicker">
	                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
	                    </div>
	                </div>

				</div>

				<hr>

				<div class="form-row">
					<div class="form-group col-md-12 mb-0">
						<p class="h5">Font settings</p>
					</div>
					<div class="form-group col-md-4">
						<label for="desktopSize">Desktop size</label>
						<input type="number" class="form-control" id="desktopSize" required>
					</div>
					<div class="form-group col-md-4">
						<label for="mobileSize">Mobile size</label>
						<input type="number" class="form-control" id="mobileSize" required>
					</div>
					<div class="form-group col-md-4">
						<label for="fontColor">Color</label>
						<div class="input-group">
							<div class="input-group-prepend with-color-picker">
								<div id="font-color-pickr"></div>
							</div>
							<input type="text" class="form-control" id="fontColor" placeholder="Enter hex" required readonly>
						</div>
					</div>
				</div>

				<hr>

				<div class="form-row">
					<div class="form-group col-md-12 mb-0">
						<p class="h5">GIF settings</p>
					</div>
					<div class="form-group col-md-6">
						<label for="desktopTransparent">Transparent color desktop</label>
						<div class="input-group">
							<div class="input-group-prepend with-color-picker">
								<div id="dt-transparent-color-pickr"></div>
							</div>

							<input type="text" class="form-control" id="desktopTransparent" maxlength="7" required readonly>
						</div>
					</div>
					<div class="form-group col-md-6">
						<label for="mobileTransparent">Transparent color mobile</label>
						<div class="input-group">
							<div class="input-group-prepend with-color-picker">
								<div id="mb-transparent-color-pickr"></div>
							</div>
							<input type="text" class="form-control" id="mobileTransparent" maxlength="7" required readonly>
						</div>
						<div class="custom-control custom-checkbox pl-4" style="text-align: left;">
							<input type="checkbox" class="custom-control-input" id="copy-dt"><label class="custom-control-label small-label" for="copy-dt">use same colour as desktop</label>
						</div>
					</div>
					<div class="form-group col-md-4">
						<label for="numColors">Number of colors</label>
						<input type="number" class="form-control" id="numColors" required>
					</div>
					<div class="form-group col-md-4">
						<label for="numFrames">Number of frames</label>
						<input type="number" class="form-control" id="numFrames" required>
					</div>
					<div class="form-group col-md-4">
						<label for="dither">Dither</label>
						<div class="btn-group btn-group-toggle w-100" data-toggle="buttons">
							<label class="btn btn-info">
								<input type="radio" name="dither" id="dither_false" autocomplete="off" value="false" required> False
							</label>
							<label class="btn btn-info">
								<input type="radio" name="dither" id="dither_true" autocomplete="off" value="true" required> True
							</label>
						</div>
					</div>
				</div>

				<hr>

				<div class="form-row">
					<div class="form-group col-md-12 mb-0">
						<p class="h5">Number coordinates</p>
					</div>
					<div class="form-group col-md-12 mb-0">
						<p class="h6">Desktop</p>
					</div>
					<div class="form-group col">
						<label for="dt_days_2dig" class="small-label">Days (10+)</label>
						<input type="text" class="form-control" id="dt_days_2dig" required>
					</div>
					<div class="form-group col">
						<label for="dt_days_1dig" class="small-label">Days (1-9)</label>
						<input type="text" class="form-control" id="dt_days_1dig" required>
					</div>
					<div class="form-group col">
						<label for="dt_hours" class="small-label">Hours</label>
						<input type="text" class="form-control" id="dt_hours" required>
					</div>
					<div class="form-group col">
						<label for="dt_minutes" class="small-label">Minutes</label>
						<input type="text" class="form-control" id="dt_minutes" required>
					</div>
					<div class="form-group col">
						<label for="dt_seconds" class="small-label">Seconds</label>
						<input type="text" class="form-control" id="dt_seconds" required>
					</div>
					

					<div class="form-group col-md-12 mb-0">
						<p class="h6">Mobile</p>
					</div>
					<div class="form-group col">
						<label for="mb_days_2dig" class="small-label">Days (10+)</label>
						<input type="text" class="form-control" id="mb_days_2dig" required>
					</div>	
					<div class="form-group col">
						<label for="mb_days_1dig" class="small-label">Days (1-9)</label>
						<input type="text" class="form-control" id="mb_days_1dig" required>
					</div>
					<div class="form-group col">
						<label for="mb_hours" class="small-label">Hours</label>
						<input type="text" class="form-control" id="mb_hours" required>
					</div>
					<div class="form-group col">
						<label for="mb_minutes" class="small-label">Minutes</label>
						<input type="text" class="form-control" id="mb_minutes" required>
					</div>
					<div class="form-group col">
						<label for="mb_seconds" class="small-label">Seconds</label>
						<input type="text" class="form-control" id="mb_seconds" required>
					</div>
							
				</div>

				<hr>

				<div class="form-row">
					<div class="form-group col-7 mb-0">
						<button type="button" id="regen-btn" class="btn btn-info btn-lg btn-block" disabled>Autosave is on</button>
					</div>
					<div class="form-group col-5 mb-0 align-self-center text-center autosave-btn-outer">
						<div class="custom-control custom-switch">
							<input type="checkbox" class="custom-control-input ignore-autosave" id="autosave-switch" checked>
							<label class="custom-control-label" for="autosave-switch" id="autosave-switch-label">Autosave ON</label>&nbsp;&nbsp;<span class="info-tooltip" data-toggle="tooltip" title="Leaving this ON will commit saves 1s after no futher changes have been detected."><i class="fa fa-info-circle" aria-hidden="true"></i></span>
						</div>

					</div>
				</div>

			</form>

			
		</div>
		<div class="desktop grid-section">
			<div id="desktop-info">
				<div class="title">Desktop</div>
				<div class="info">loading info...</div>
			</div>
			<div class="main-cd">
				<img src="../index.php" class="dt-image cd-image" id="dt-image">

				<br><br>

				<div id="error-msg"></div>

				<div class="link">

					<button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#desktopFrames">
					  	See frames
					</button>
				</div>

			</div>

			
		</div>
		<div class="mobile grid-section">
			<div id="mobile-info">
				<div class="title">Mobile</div>
				<div class="info">loading info...</div>
			</div>

			<div class="main-cd">
				<img src="../index.php?mb=y" class="mb-image cd-image" id="mb-image">

				<div class="link">

					<button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#mobileFrames">
					  	See frames
					</button>
				</div>
			</div>
			
		</div>
		<div class="desktop-other grid-section">
			<div id="desktop-info">
				<div class="title other">Desktop fallbacks</div>
			</div>
			<div class="fallbacks bottom-label" data-label="zero">
				<img src="../cd_dt_zero.png" class="dt-other">
			</div>
			
			<div class="fallbacks bottom-label" data-label="fallback">
				<img src="../cd_dt_fallback.png" class="dt-other">
			</div>
		</div>
		<div class="mobile-other grid-section">
			<div id="mobile-info">
				<div class="title other">Mobile fallbacks</div>
			</div>

			<div class="fallbacks bottom-label" data-label="zero">
				<img src="../cd_mb_zero.png" class="mb-other">
			</div>
			<div class="fallbacks bottom-label" data-label="fallback">
				<img src="../cd_mb_fallback.png" class="mb-other">
			</div>
		</div>
	</div>

	<!-- MODALS -->

	<div class="modal fade bd-example-modal-lg" id="desktopFrames" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalCenterTitle">Desktop Frames</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body" style="text-align: center;" id="dt-frames-body">
					<img src="../index.php" class="dt-image-for-frames">
					<div class="spinner-border text-info loading-spinner-dt" role="status">
					  	<span class="sr-only">Loading...</span>
					</div>
					<div id="dt-frames"></div>
					<br>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade bd-example-modal-lg" id="mobileFrames" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalCenterTitle">Desktop Frames</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body" style="text-align: center;" id="mb-frames-body">
					<img src="../index.php?mb=y" class="mb-image-for-frames">
					<div class="spinner-border text-info loading-spinner-mb" role="status">
					  	<span class="sr-only">Loading...</span>
					</div>
					<div id="mb-frames"></div>
					<br>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>

	<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	<script src="https://cdn.rawgit.com/buzzfeed/libgif-js/master/libgif.js"></script>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.4/clipboard.min.js"></script>

	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/js/tempusdominus-bootstrap-4.min.js"></script>

	<script src="https://cdn.jsdelivr.net/npm/@simonwep/pickr/dist/pickr.min.js"></script>

	<script src="./script.js"></script>
</body>
</html>