<?php 
class App_template extends CI_Model {
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }    function load_styles($array){
    	if(!empty($array)){
    		foreach ($array as $style) { ?>
				<link rel="stylesheet" type="text/css" href="<?php echo base_url($style); ?>" />
				<?php
			}
		}
    }	function load_scripts($array){
    	if(!empty($array)){
    		foreach ($array as $script) { ?>
				<script type="text/javascript" src="<?php echo site_url($script) ?>"></script>
				<?php
			}
		}
    }
}?>