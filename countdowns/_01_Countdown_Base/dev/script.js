// initialize images
regenImages();

// load the current config file
loadConfig();

// initialize tooltips
$('.info-tooltip').tooltip({
	animation: true
});

// initialize color pickers
const font_color_pickr = Pickr.create({
    el: '#font-color-pickr',
    theme: 'nano',
    default: '#ffffff',
    lockOpacity: true,
    swatches: [
        'rgba(244, 67, 54, 1)',
        'rgba(233, 30, 99, 1)',
        'rgba(156, 39, 176, 1)',
        'rgba(103, 58, 183, 1)',
        'rgba(63, 81, 181, 1)',
        'rgba(33, 150, 243, 1)',
        'rgba(3, 169, 244, 1)',
        'rgba(0, 188, 212, 1)',
        'rgba(0, 150, 136, 1)',
        'rgba(76, 175, 80, 1)',
        'rgba(139, 195, 74, 1)',
        'rgba(205, 220, 57, 1)',
        'rgba(255, 235, 59, 1)',
        'rgba(255, 193, 7, 1)'
    ],

    components: {

        // Main components
        preview: true,
        opacity: false,
        hue: true,

        // Input / output Options
        interaction: {
            hex: true,
            rgba: true,
            hsla: false,
            hsva: false,
            cmyk: false,
            input: true,
            clear: false,
            save: true,
            cancel: true
        }
    }
});
font_color_pickr.on('init', instance => {
   
}).on('save', (color, instance) => {
    $('#fontColor').val(color.toHEXA().toString()).change();
    // save configuration and reload images
    if (initialized && autosaveEnabled) {
		autoSave();
	}

}).on('change', (color, instance) => {
    
}).on('swatchselect', (color, instance) => {
    
});

const dt_transparent_pickr = Pickr.create({
    el: '#dt-transparent-color-pickr',
    theme: 'nano',
    default: '#ffffff',
    lockOpacity: true,
    swatches: [
        'rgba(244, 67, 54, 1)',
        'rgba(233, 30, 99, 1)',
        'rgba(156, 39, 176, 1)',
        'rgba(103, 58, 183, 1)',
        'rgba(63, 81, 181, 1)',
        'rgba(33, 150, 243, 1)',
        'rgba(3, 169, 244, 1)',
        'rgba(0, 188, 212, 1)',
        'rgba(0, 150, 136, 1)',
        'rgba(76, 175, 80, 1)',
        'rgba(139, 195, 74, 1)',
        'rgba(205, 220, 57, 1)',
        'rgba(255, 235, 59, 1)',
        'rgba(255, 193, 7, 1)'
    ],

    components: {

        // Main components
        preview: true,
        opacity: false,
        hue: true,

        // Input / output Options
        interaction: {
            hex: true,
            rgba: true,
            hsla: false,
            hsva: false,
            cmyk: false,
            input: true,
            clear: false,
            save: true,
            cancel: true
        }
    }
});
dt_transparent_pickr.on('init', instance => {
   
}).on('save', (color, instance) => {
    $('#desktopTransparent').val(color.toHEXA().toString()).change();
    // save configuration and reload images

    // sync transparent background colors if the box is checked
	const syncColours = $('#copy-dt').prop('checked');
	if (syncColours) {
		$('#mobileTransparent').val(color.toHEXA().toString()).change();
		mb_transparent_pickr.setColor(color.toHEXA().toString());
	}

    if (initialized && autosaveEnabled) {
		autoSave();
	}

}).on('change', (color, instance) => {
    
}).on('swatchselect', (color, instance) => {
    
});

const mb_transparent_pickr = Pickr.create({
    el: '#mb-transparent-color-pickr',
    theme: 'nano',
    default: '#ffffff',
    lockOpacity: true,
    swatches: [
        'rgba(244, 67, 54, 1)',
        'rgba(233, 30, 99, 1)',
        'rgba(156, 39, 176, 1)',
        'rgba(103, 58, 183, 1)',
        'rgba(63, 81, 181, 1)',
        'rgba(33, 150, 243, 1)',
        'rgba(3, 169, 244, 1)',
        'rgba(0, 188, 212, 1)',
        'rgba(0, 150, 136, 1)',
        'rgba(76, 175, 80, 1)',
        'rgba(139, 195, 74, 1)',
        'rgba(205, 220, 57, 1)',
        'rgba(255, 235, 59, 1)',
        'rgba(255, 193, 7, 1)'
    ],

    components: {

        // Main components
        preview: true,
        opacity: false,
        hue: true,

        // Input / output Options
        interaction: {
            hex: true,
            rgba: true,
            hsla: false,
            hsva: false,
            cmyk: false,
            input: true,
            clear: false,
            save: true,
            cancel: true
        }
    }
});
mb_transparent_pickr.on('init', instance => {
   
}).on('save', (color, instance) => {
    $('#mobileTransparent').val(color.toHEXA().toString()).change();
    // save configuration and reload images

    //only save if checkbox is not checked
    const syncColours = $('#copy-dt').prop('checked');
	if (!syncColours && initialized && autosaveEnabled) {
		autoSave();
	}

}).on('change', (color, instance) => {
    
}).on('swatchselect', (color, instance) => {
    
});

// handle clicking on the regen button
$('#regen-btn').on('click', function() {
	// save configuration and reload images
	saveConfig();
});

// handle clicking on the checkbox
$('#copy-dt').on('input', function(){
	const syncColours = $(this).prop('checked');
	
	if (syncColours) {
		mb_transparent_pickr.disable();
		mb_transparent_pickr.setColor(dt_transparent_pickr.getColor().toHEXA().toString());
	} else {
		mb_transparent_pickr.enable();
	}
});


function regenImages() {
	// clear values
	$('#error-msg').html('');

	// call PHP generate script
	$.ajax({
		method: "POST",
		url: "../generate_cd.php"
	})
	.done(function( msg ) {

		const now = new Date().getTime();
		// refresh images
		$('.dt-image').attr('src', '../index.php?'+ now);
		$('.mb-image').attr('src', '../index.php?'+ now +'&mb=y');

		// refresh image information
		let dt_img = new Image();
		let dt_info;
		dt_img.src = '../index.php?'+ now;
		dt_img.onload = function() {
			dt_info = this.width + 'px × ' + this.height + 'px / ';

			var xhr = new XMLHttpRequest();
			xhr.open('HEAD', '../index.php?'+ now, true);
			xhr.onreadystatechange = function(){
			  if ( xhr.readyState == 4 ) {
			    if ( xhr.status == 200 ) {
			      // alert('Size in bytes: ' + xhr.getResponseHeader('Content-Length'));
			      const size_in_kb = parseInt(xhr.getResponseHeader('Content-Length') / 1024);
			      //alert(size_in_kb);

			      	// get pixel color in top left
			      	var img = document.getElementById('dt-image');
					var canvas = document.createElement('canvas');
					canvas.width = img.width;
					canvas.height = img.height;
					canvas.getContext('2d').drawImage(img, 0, 0, img.width, img.height);
					var pixelData = canvas.getContext('2d').getImageData(0, 0, 1, 1).data;

					const topLeftHex = RGBToHex(pixelData[0],pixelData[1],pixelData[2],pixelData[3]);

					//console.log(pixelData);

			      dt_info = dt_info + size_in_kb + 'kb / ' + '0,0 color: ' +topLeftHex;

			    } else {
			      dt_info += "could not determine size"
			    }

			    $('#desktop-info .info').html(dt_info);
			  }
			};
			xhr.send(null);

			
		};

		let mb_img = new Image();
		let mb_info;
		mb_img.src = '../index.php?'+ now +'&mb=y';
		mb_img.onload = function() {
			mb_info = this.width + 'px × ' + this.height + 'px / ';

			var xhr = new XMLHttpRequest();
			xhr.open('HEAD', '../index.php?'+ now +'&mb=y', true);
			xhr.onreadystatechange = function(){
			  if ( xhr.readyState == 4 ) {
			    if ( xhr.status == 200 ) {

			    	// get image size in KB
			      	const size_in_kb = parseInt(xhr.getResponseHeader('Content-Length') / 1024);

			      	// get pixel color in top left
			      	var img = document.getElementById('mb-image');
					var canvas = document.createElement('canvas');
					canvas.width = img.width;
					canvas.height = img.height;
					canvas.getContext('2d').drawImage(img, 0, 0, img.width, img.height);
					var pixelData = canvas.getContext('2d').getImageData(0, 0, 1, 1).data;

					const topLeftHex = RGBToHex(pixelData[0],pixelData[1],pixelData[2],pixelData[3]);

			      	mb_info = mb_info + size_in_kb + 'kb / ' + '0,0 color: ' +topLeftHex;

			      
			    } else {
			      	mb_info += "could not determine size";
			    }

			    $('#mobile-info .info').html(mb_info);
			  }
			};
			xhr.send(null);

			
		};

		// reset canvases
		$('#dt-frames-body').html('<img src="../index.php?'+new Date().getTime()+'" class="dt-image-for-frames"><div class="spinner-border text-info loading-spinner-dt" role="status"><span class="sr-only">Loading...</span></div><div id="dt-frames"></div><br>');
		$('#mb-frames-body').html('<img src="../index.php?'+new Date().getTime()+'&mb=y" class="mb-image-for-frames"><div class="spinner-border text-info loading-spinner-mb" role="status"><span class="sr-only">Loading...</span></div><div id="mb-frames"></div><br>');

		if (msg == "success") {

			$('.dt-image-for-frames').each(function (idx, img_tag) {

			      var rub = new SuperGif({ gif: img_tag, progressbar_height: 0 } );
			      rub.load(function(){
			      	$('.loading-spinner-dt').remove();
			        for (var i = 0; i < rub.get_length(); i++)
			        {

			           rub.move_to(i); 
			           var canvas = cloneCanvas(rub.get_canvas());
			           canvas.classList.add('dt-frame');
			           $("#dt-frames").append(canvas);
			        }
			        
			      });

			  });

			$('.mb-image-for-frames').each(function (idx, img_tag) {

			      var rub = new SuperGif({ gif: img_tag, progressbar_height: 0 } );
			      rub.load(function(){
			      	$('.loading-spinner-mb').remove();
			        for (var i = 0; i < rub.get_length(); i++)
			        {

						rub.move_to(i); 
						var canvas = cloneCanvas(rub.get_canvas());
						canvas.classList.add('mb-frame');
						$("#mb-frames").append(canvas);
			        }
			      });

			  });
		} else {

			$('#error-msg').html(msg);

		}
	});
}


function loadConfig() {

	const now = new Date().getTime();
	
	$.getJSON( "../config.json?"+now, function( data ) {

		// set up date variables
		const now = new Date();

		const now_actual_month = now.getMonth() + 1;

		const now_yy = now.getFullYear();
		const now_mm = now_actual_month < 10 ? "0" + now_actual_month : now_actual_month;
		const now_dd = now.getDate() < 10 ? "0" + now.getDate() : now.getDate();

		const hh = now.getHours() < 10 ? "0" + now.getHours() : now.getHours();
		const ii = now.getMinutes() < 10 ? "0" + now.getMinutes() : now.getMinutes();
		const ss = now.getSeconds() < 10 ? "0" + now.getSeconds() : now.getSeconds();

		// populate the fields

		if (data.ends === '') {
			const new_ends = new Date();
			new_ends.setDate(new_ends.getDate()+11);
			
			const actual_month = new_ends.getMonth() + 1;

			const yyyy = new_ends.getFullYear();
			const mm = actual_month < 10 ? "0" +  actual_month :  actual_month;
			const dd = new_ends.getDate() < 10 ? "0" + new_ends.getDate() : new_ends.getDate();

			//console.log(yyyy + "-" + mm + "-" + dd + " 23:59:59");
			
			$('#datetimepicker1').datetimepicker({
				format: 'YYYY-MM-DD HH:mm:00',
				defaultDate: yyyy + "-" + mm + "-" + dd + " 23:59:00",
				minDate: now_yy + "-" + now_mm + "-" + now_dd + " " + hh + ":" + ii + ":00"
			});

		} else {
			$('#datetimepicker1').datetimepicker({
				format: 'YYYY-MM-DD HH:mm:00',
				defaultDate: data.ends,
				minDate: now_yy + "-" + now_mm + "-" + now_dd + " " + hh + ":" + ii + ":00"
			});
		}
		


		$('#desktopSize').val(data.font_size_dt);
		$('#mobileSize').val(data.font_size_mb);
		$('#fontColor').val(data.text_color);
		$('#fontColorBG').css("background-color", data.text_color);

		font_color_pickr.setColor(data.text_color);

		$('#desktopTransparent').val(data.transparent_color_dt);
		$('#desktopTransparentBG').css("background-color", data.transparent_color_dt);

		dt_transparent_pickr.setColor(data.transparent_color_dt);
		mb_transparent_pickr.setColor(data.transparent_color_dt);

		if (data.transparent_color_mb == data.transparent_color_dt) {
			$('#copy-dt').prop('checked', true);
			mb_transparent_pickr.disable();
		}

		$('#mobileTransparent').val(data.transparent_color_mb);
		$('#mobileTransparentBG').css("background-color", data.transparent_color_mb);

		$('#numColors').val(data.num_colors);
		$('#numFrames').val(data.num_frames);

		if (data.dither) {
			$('#dither_true').click().blur();
		}
		if (!data.dither) {
			$('#dither_false').click().blur();
		}

		$('#dt_days_2dig').val(data.digit_coordinates.desktop.days_2digit[0]+','+data.digit_coordinates.desktop.days_2digit[1]);
		$('#dt_days_1dig').val(data.digit_coordinates.desktop.days_1digit[0]+','+data.digit_coordinates.desktop.days_1digit[1]);
		$('#dt_hours').val(data.digit_coordinates.desktop.hours[0]+','+data.digit_coordinates.desktop.hours[1]);
		$('#dt_minutes').val(data.digit_coordinates.desktop.minutes[0]+','+data.digit_coordinates.desktop.minutes[1]);
		$('#dt_seconds').val(data.digit_coordinates.desktop.seconds[0]+','+data.digit_coordinates.desktop.seconds[1]);

		$('#mb_days_2dig').val(data.digit_coordinates.mobile.days_2digit[0]+','+data.digit_coordinates.mobile.days_2digit[1]);
		$('#mb_days_1dig').val(data.digit_coordinates.mobile.days_1digit[0]+','+data.digit_coordinates.mobile.days_1digit[1]);
		$('#mb_hours').val(data.digit_coordinates.mobile.hours[0]+','+data.digit_coordinates.mobile.hours[1]);
		$('#mb_minutes').val(data.digit_coordinates.mobile.minutes[0]+','+data.digit_coordinates.mobile.minutes[1]);
		$('#mb_seconds').val(data.digit_coordinates.mobile.seconds[0]+','+data.digit_coordinates.mobile.seconds[1]);


		// if the "ends" key in the config.json file is blank, this is a new countdown, so let's initialize it
		if (data.ends === '') {
			saveConfig();
		}

		initialized = true;

	});

	
}

function saveConfig() {

	let dither_val;
	if ($("input[name='dither']:checked").val() == "true") {
		dither_val = true;
	} else {
		dither_val = false;
	}

	const configData = {
		"end_format": "2019-04-27 09:30:00",
		"ends": $('#datetimepicker1').data('date'),
		"font_size_dt": Number($('#desktopSize').val()),
		"font_size_mb": Number($('#mobileSize').val()),
		"text_color": $('#fontColor').val(),
		"transparent_color_dt": $('#desktopTransparent').val(),
		"transparent_color_mb": $('#mobileTransparent').val(),
		"num_colors": Number($('#numColors').val()),
		"num_frames": Number($('#numFrames').val()),
		"dither": dither_val,
		"digit_coordinates": {
			"desktop": {
				"days_1digit": [Number($('#dt_days_1dig').val().split(',')[0]),Number($('#dt_days_1dig').val().split(',')[1])],
				"days_2digit": [Number($('#dt_days_2dig').val().split(',')[0]),Number($('#dt_days_2dig').val().split(',')[1])],
				"hours": [Number($('#dt_hours').val().split(',')[0]),Number($('#dt_hours').val().split(',')[1])],
				"minutes": [Number($('#dt_minutes').val().split(',')[0]),Number($('#dt_minutes').val().split(',')[1])],
				"seconds": [Number($('#dt_seconds').val().split(',')[0]),Number($('#dt_seconds').val().split(',')[1])]
			},
			"mobile": {
				"days_1digit": [Number($('#mb_days_1dig').val().split(',')[0]),Number($('#mb_days_1dig').val().split(',')[1])],
				"days_2digit": [Number($('#mb_days_2dig').val().split(',')[0]),Number($('#mb_days_2dig').val().split(',')[1])],
				"hours": [Number($('#mb_hours').val().split(',')[0]),Number($('#mb_hours').val().split(',')[1])],
				"minutes": [Number($('#mb_minutes').val().split(',')[0]),Number($('#mb_minutes').val().split(',')[1])],
				"seconds": [Number($('#mb_seconds').val().split(',')[0]),Number($('#mb_seconds').val().split(',')[1])]
			}
		}
	};

	let status;

	$.ajax({
		method: "POST",
		url: "./saveConfig.php",
		data: {configData: JSON.stringify(configData)}
	}).done(function(data){
		// alert( "request completed: " + data );
		if (data == "saved") {

			// config file was saved, so let's regenerate the images
			regenImages();

		} else {
			// some PHP error occurred
			if(!alert("an error occurred: code 1. "+data)){window.location.reload();}
		}

		// reset saving variable
		saving = false;

		// restore button text
		restoreRegenBtn();

	}).fail(function( jqXHR, textStatus ) {
	  	// alert( "Request failed: " + textStatus );
	  	if(!alert("an error occurred: code 2: "+textStatus)){window.location.reload();}

		// reset saving variable
		saving = false;

		// restore button text
		restoreRegenBtn();

	});

	
}


function restoreRegenBtn() {

	var regenBtnState;
	var regenBtnText;
	var autosaveOn = $('#autosave-switch').prop('checked');

	if (autosaveOn) {
		regenBtnState = true;
		regenBtnText = 'Autosave is on';
	} else {
		regenBtnState = false;
		regenBtnText = 'Save countdown';
	}

	$("#regen-btn").prop('disabled', regenBtnState).html(regenBtnText);
}

// handle input changes to grey out deploy button until saved
$('input:not(.ignore-autosave)').on('input', function(){
	
	if (autosaveEnabled) {
		autoSave();
	}
	
});
$('input:not(.ignore-autosave):not([type="number"])').on('change', function(){
	
	if (autosaveEnabled) {
		autoSave();
	}
	
});

var initialized = false;
var autoSaveTimer;
var autosaveEnabled = true;
var saving = false;

function autoSave() {
	if (initialized) {

		// show autosaving message
		var regenBtnText = $("#regen-btn").html();
		$("#regen-btn").prop('disabled', true).html('Autosaving...<span class="autosave-bar"></span>');

		clearTimeout(autoSaveTimer);
		saving = true;
		autoSaveTimer = setTimeout(function() {
			console.log('saving...');
			saveConfig(regenBtnText);

		}, 1500);
	}

}

//handle the autosave input being switched on/off 
$('#autosave-switch').on('change', function() {
	var autosaveOn = $(this).prop('checked');
	var saveButton = $('#regen-btn');
	var autosaveSwitchLabel = $('#autosave-switch-label');

	if (autosaveOn) {
		autosaveEnabled = true;
		saveButton.prop('disabled', true).html('Autosave is on');
		autosaveSwitchLabel.html('Autosave ON');
	} else {
		autosaveEnabled = false;
		saveButton.prop('disabled', false).html('Save countdown');
		autosaveSwitchLabel.html('Autosave OFF');
	}
});


function cloneCanvas(oldCanvas) {

    //create a new canvas
    var newCanvas = document.createElement('canvas');
    var context = newCanvas.getContext('2d');

    //set dimensions
    newCanvas.width = oldCanvas.width;
    newCanvas.height = oldCanvas.height;

    //apply the old canvas to the new one
    context.drawImage(oldCanvas, 0, 0);

    //return the new canvas
    return newCanvas;
}

//Function to convert hex format to a rgb color
function RGBToHex(r,g,b,a=null) {
  r = r.toString(16);
  g = g.toString(16);
  b = b.toString(16);

  if (a !== null) {
  	a = a.toString(16);
  }
  

  if (r.length == 1)
    r = "0" + r;
  if (g.length == 1)
    g = "0" + g;
  if (b.length == 1)
    b = "0" + b;

	if (a !== null) {
		if (a.length == 1)
    		a = "0" + a;
	}
 
	if (a === null) {
		return"#" + r + g + b;
	} else {
		if (a === "00") {
			return "transparent";
		} else {
			return "#" + r + g + b;
		}
		
	}
  
}