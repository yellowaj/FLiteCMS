/*
Copyright (c) 2003-2012, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

CKEDITOR.editorConfig = function( config )
{
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';

	config.width = '94%';
	config.height = '400';

	// config the file browser
	config.filebrowserBrowseUrl 		= '/ci/resources/js/libs/kcfinder/browse.php?type=files';
    config.filebrowserImageBrowseUrl 	= '/ci/resources/js/libs/kcfinder/browse.php?type=images';
    config.filebrowserFlashBrowseUrl	= '/ci/resources/js/libs/kcfinder/browse.php?type=flash';
    config.filebrowserUploadUrl 		= '/ci/resources/js/libs/kcfinder/upload.php?type=files';
    config.filebrowserImageUploadUrl 	= '/ci/resources/js/libs/kcfinder/upload.php?type=images';
    config.filebrowserFlashUploadUrl 	= '/ci/resources/js/libs/kcfinder/upload.php?type=flash';

};
