function previewProductSpecsAlign(args) {

	var $module = $('.fl-node-<?php echo $id; ?> .fl-module-content');
	var $specs = $('.fl-node-<?php echo $id; ?> .bc-product__spec-list');

	switch (args.getValue()) {
		case 'right':
			$module.css('text-align', 'right');
			$specs.css('justify-content', 'flex-end');
			break;
		case 'center':
			$module.css('text-align', 'center');
			$specs.css('justify-content', 'center');
			break;
		case 'left':
		default:
			$module.css('text-align', 'left');
			$specs.css('justify-content', 'flex-start');
			break;
	}


}
