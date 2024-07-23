<?php
	if (! isset($orientation)) {       
        @$orientation = "A4";
    }
?>
<!DOCTYPE html>
<html>
<head>
	<?php 
		if ($orientation == 'A4') {echo "<style>@page { size: A4 }</style>";}
		else if ($orientation == 'A5') {echo "<style>@page { size: A5; margin: 0; }</style>";}
		else if ($orientation == 'A5 landscape') {echo "<style>@page { size: a5 landscape; margin: 0;}</style>";}
		else {echo "<style>@page { size: A4 landscape }</style>";}
	?>
	
	<link href="<?php echo base_url(); ?>assets/pages/css/print.css" rel="stylesheet" type="text/css" />
	<!-- <link href="<?php //echo base_url(); ?>assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/> -->
	<link href="<?php echo base_url(); ?>assets/pages/css/paper.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url(); ?>assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
	
	<title><?php echo 'SID | '.$title ?></title>
	<link rel="shortcut icon" href="<?php echo base_url(); ?>favicon.ico" />
</head>
<body class="<?php echo $orientation ?>"> 
	<div id="slidebar" class="no-print">
		<span class="slidebar-caption"><?php echo 'SID | '.$title ?></span>
		<button id="btnprint" class="" ><i class="fa fa-lg fa-print"></i></button>
	</div>

	<header>
		<?php echo $header ?>
		<!-- <div class="divider"></div> -->
	</header>
	
	<div class="page-content">
		<?php echo $record ?>
	</div>

    <script type="text/javascript">
		(function() {
			var slideSource = document.getElementById('slidebar');
			var buttonPrint = document.getElementById('btnprint');

			//window.load = print_d();
			buttonPrint.onclick = function(){
				//document.getElementsByTagName('tr')[0].removeAttribute('class');
				window.print();
			}
			
			// setTimeout(function() {
			//   slideSource.className = 'fade-out no-shadow';
			//   console.log('fade');
			// }, 1000);

			// slideSource.onmouseover = function(){slideSource.className = 'fade-in';}
			// slideSource.onmouseleave = function(){slideSource.className = 'fade-out no-shadow';}

			document.onmouseleave = function(){slideSource.className = 'fade-out no-shadow no-print';}
			document.onmousemove = function(e){
				//var objLeft = e.pageX;
        		//var objTop = e.pageY;
        		if (e.pageY <= (slideSource.offsetHeight+20)) {
        			slideSource.className = 'fade-in no-print';
        			//console.log('left : ',objLeft,' top: ',objTop, 'ofset : ',slideSource.offsetHeight);
        		} else {
        			slideSource.className = 'fade-out no-shadow no-print';
        		}
				
			};


			// var forEach = function (array, callback, scope) {
			//   for (var i = 0; i < array.length; i++) {
			//     callback.call(scope, i, array[i]); // passes back stuff we need
			//   }
			// };

			// var containers = document.querySelectorAll(".navbar1");

			// forEach(containers, function(index, value) {
			//   value.addEventListener("click", function() {
			//     this.classList.toggle("alert-is-shown");
			//   });
			// })
		})();
	</script>
	
</body>
</html>