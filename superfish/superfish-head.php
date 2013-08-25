<link rel="stylesheet" type="text/css" href="<?php base_url(); ?>/assets/superfish/css/superfish.css" media="screen">
<link rel="stylesheet" type="text/css" href="<?php base_url(); ?>/assets/superfish/css/superfish-modified.css" media="screen">

<script type="text/javascript" src="<?php base_url(); ?>/assets/superfish/js/hoverIntent.js"></script>
<script type="text/javascript" src="<?php base_url(); ?>/assets/superfish/js/superfish.js"></script>


<script type="text/javascript">
$(document).ready(function() { 
	$('ul.sf-menu').superfish({ 
		delay:       100,
		animation:   {opacity:'show',height:'show'},
		autoArrows:  true, 
		dropShadows: true	}); 
}); 

</script>