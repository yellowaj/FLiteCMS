/* =============================================================================
	Admin js scripts
    @author Adam Jacox
   ========================================================================== */

(function() {   

var base = '/ranch/',
	baseUrl = base + 'admin/';


/* =============================================================================
   generic functions
   ========================================================================== */ 

// hide message box after displaying
$('.message').show().delay(3500).slideUp();

// tooltip popup box
$('.info.icon-question-sign').tooltip();

// header message function 
var setMessage = function(msg) {
	if($('.message').length > 0) { // message already set
		$('.message').text(msg);
	} else {
		var msgHtml = '<div class="message">' + msg + '</div>';
		$('header .navbar').after(msgHtml);
	}	
	$('.message').slideDown(700).delay(3500).slideUp(600);
};

// confirm box prior to deleting
$('.delete-item').on('click', function(e) {
	if(confirm('Are you sure you want to delete this record?')){
		return true;
	}
	return false;
}); 



/* =============================================================================
   user management page
   ========================================================================== */

// select all check box
$('.user-checkbox-all').on('click', function() {

	$('.select-user').each(function() {
		$(this).attr('checked', true);
	});

});

$('.user-checkbox-clear').on('click', function() {

	$('.select-user').each(function() {
		$(this).attr('checked', false);
	});

});

// bulk delete function
$('select#users-select').change(function(){

	if($('option#option-delete').is(':selected')) {
		
		// get all the selected checkboxes
		var idArr = [];
		$('.select-user:checked').each(function() {
			idArr.push($(this).attr('value'));
		});

		if(confirm('Are you sure you want to delete multiple records?')){
			window.location.replace(baseUrl + "users/delete/" + idArr.join('-'));
			//console.log(idArr.join());
		}
		return false;
	}	
});


/*
 *	add user page
 */

// alert prior to making new user an admin
$('#role').on('click', function() {
	if($(this).is(':checked')) {
		if(!confirm('Are you sure you want to give this user full admin access?')) {
			return false;
		}
	}
});


/*
 *	edit user page
 */ 

// hide and display password box
$('.pswd-box').hide();
$('#change-pswd-btn').show().on('click', function() {
	$('.pswd-box').toggle('slideDown');
});

// hide and display ban reason box
var setBanStatus = function() {
	var banned = $('input[name=banned]'),
		btnText = '';
	if(Math.round(banned.val()) == 1) {
		btnText = 'remove ban';		
	} else {
		btnText = 'ban user';
		$('.ban-box').hide();
	}
	$('#ban-btn').text(btnText);	
};
setBanStatus();
$('#ban-btn').on('click', function() {
	var banned = $('input[name=banned]'),
		btnText = '';
	if(Math.round(banned.val()) == 0) {
		// ban user
		btnText = 'remove ban';
		$('.ban-box').slideDown();
		banned.val(1);		
	} else { 
		// remove ban
		btnText = 'ban user';
		$('.ban-box').slideUp();
		$('#ban-reason').val('');
		banned.val(0);
	}
	$('#ban-btn').text(btnText);
});


/* =============================================================================
   manage pages section
   ========================================================================== */

// select all check box
$('.page-checkbox-all').on('click', function() {
	$('.select-page').each(function() {
		$(this).attr('checked', true);
	});
});

$('.page-checkbox-clear').on('click', function() {
	$('.select-page').each(function() {
		$(this).attr('checked', false);
	});
});


// bulk delete function
$('select#pages-select').change(function(){

	if($('option#option-delete').is(':selected')) {
		
		// get all the selected checkboxes
		var idArr = [];
		$('.select-page:checked').each(function() {
			idArr.push($(this).attr('value'));
		});

		if(confirm('Are you sure you want to delete multiple records?')){
			window.location.replace(baseUrl + "pages/delete/" + idArr.join('-'));
			//console.log(idArr.join());
		}
		return false;
	}	

});


// TinyMCE editor on pages section
if($.isFunction($.fn.tinymce)) {
$('#content').tinymce({
    // Location of TinyMCE script
    script_url : base +'resources/js/libs/tinymce/jscripts/tiny_mce/tiny_mce.js',

    // callback to open KCFinder
    file_browser_callback: 'openKCFinder',

    // General options
    theme : "advanced",
    plugins : "pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",
    width: '900',
    height: '400',

    // Theme options
    theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
    theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
    theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
    theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak",
    theme_advanced_toolbar_location : "top",
    theme_advanced_toolbar_align : "left",
    theme_advanced_statusbar_location : "bottom",
    theme_advanced_resizing : true,
    theme_advanced_resizing_max_width : 900,
    theme_advanced_resizing_max_height : 700,
    theme_advanced_resizing_use_cookie : false,
    theme_advanced_fonts : "Andale Mono=andale mono,times;"+
			                "Arial=arial,helvetica,sans-serif;"+
			                "Arial Black=arial black,avant garde;"+
			                "Book Antiqua=book antiqua,palatino;"+
			                "Comic Sans MS=comic sans ms,sans-serif;"+
			                "Courier New=courier new,courier;"+
			                "Droid Sans=andale mono,times;"+
			                "Georgia=georgia,palatino;"+
			                "Helvetica=helvetica;"+
			                "Impact=impact,chicago;"+
			                "Symbol=symbol;"+
			                "Tahoma=tahoma,arial,helvetica,sans-serif;"+
			                "Terminal=terminal,monaco;"+
			                "Times New Roman=times new roman,times;"+
			                "Trebuchet MS=trebuchet ms,geneva;"+
			                "Verdana=verdana,geneva;"+
			                "Webdings=webdings;"+
			                "Wingdings=wingdings,zapf dingbats;",


});
}


function openKCFinder(field_name, url, type, win) {
    tinyMCE.activeEditor.windowManager.open({
        file: base +'resources/js/admin/libs/kcfinder/browse.php?opener=tinymce&type=' + type,
        title: 'File Manager',
        width: 700,
        height: 500,
        resizable: "yes",
        inline: true,
        close_previous: "no",
        popup_css: false
    }, {
        window: win,
        input: field_name
    });
    return false;
}


function updatePageType() {
	$('.page-type-box').hide();
	var val = $('#page-type').val();
	$("#type-" + val).show();
}
updatePageType();

// select page type
$('#page-type').on('change', function() {
	updatePageType();
});

// example url 
var defaultUrl = $('#sample-url').html();
// validate and prep inputed url value
$('input#url').on('blur', function() {
	var inputVal = $('input#url').val().toLowerCase(),
		urlEnding = $('#url-ending'),
		sampleUrl = $('#sample-url');

	if(sampleUrl.text() == 'URL already taken') {
		sampleUrl.html(defaultUrl);
	}	

	if(inputVal.length > 0) {
		// reset sampleUrl to empty
		urlEnding.html('');
		// prepare new uri string 
		var cleanInput = inputVal.replace(/\s+/g, '-'),
			newHtml = '/' + cleanInput;

		// ajax - check if url available
		if(inputVal.length >= 3 && inputVal != $('#url').data('url')) {
			$.ajax({
				url: baseUrl + 'pages/check_url',
				type: "POST",
				data: { url: cleanInput, csrf_test_name: $('input[name=csrf_test_name]').val() },
				success: function(msg) {
					if(msg != '1') {
						sampleUrl.html('URL already taken');
						setMessage('URL already taken, please enter another value');
					} 
				},
				error: function(msg) {
					console.log('error');
				}
			});
		}	
		// update new uri in DOM	
		$('#url-ending').html(newHtml);
	} else {
		// reset url ending to empty
		urlEnding.html('');
	}
});


/* =============================================================================
   testimonial page
   ========================================================================== */

// function to return testimonial html to add to DOM
var testimonialHtml = function(obj) {
	var htmlCode = [
		'<blockquote>',
            '<p>'+ obj.testimonial +'</p>',
            '<span class="delete-testimonial pull-right btn btn-mini" id="'+ obj.id +'"><i class="icon-trash"></i></span>',
	        '<p class="author">'+ obj.name +' ('+ obj.location +')</p>',
	    '</blockquote>'
		];
	return htmlCode.join('');	
};
// add new testimonial ajax
$('#add-testimonial').on('click', function(e) {
	e.preventDefault();
	// get testimonial data
	var dataObj = {
		pageId: $(this).data('pageid'),
		name: $('#testimonial-name').val(),
		location: $('#testimonial-location').val(),
		testimonial: $('#testimonial-body').val()
	};
	$.ajax({
		type: 'POST',
		url: baseUrl + 'pages/ajax_add_testimonial',
		data: 'testimonial=' + JSON.stringify(dataObj) + '&csrf_test_name=' + $('input[name=csrf_test_name]').val(),
		success: function(msg) {
			var msgObj = JSON.parse(msg);
			if(msgObj.success) {
				// success, add testimonial to DOM
				if($('.no-testimonials').length > 0) {
					$('.no-testimonials').remove();
				}
				dataObj.id = msgObj.testimonialId;
				$('#testimonials-box').append(testimonialHtml(dataObj));
				setMessage('Successfully added testimonial');
				// reset form inputs
				$('#testimonial-name').val('');
				$('#testimonial-location').val('');
				$('#testimonial-body').val('');
			} else {
				setMessage('Error adding testimonial');
			}
		}, 
		error: function() {
			alert('Error connecting to server');
		}
	}); // end ajax 
});

// delete testimonial ajax
$('#testimonials-box').on('click', '.delete-testimonial', function() {
	if(confirm('Are you sure you want to delete this testimonial?')) {
		// get testimonial id
		var $this = $(this),
			id = $this.attr('id');
		//$(this).parent().remove();
		$.ajax({
			type: 'POST',
			url: baseUrl + 'pages/ajax_delete_testimonial',
			data: 'testimonial_id=' + id + '&csrf_test_name=' + $('input[name=csrf_test_name]').val(),
			success: function(msg) {
				var msgObj = JSON.parse(msg);
				if(msgObj.success) {
					// success, remove testimonial from DOM
					$this.parent().remove();
					setMessage('Successfully deleted testimonial');
				} else {
					setMessage('Error deleting testimonial');
				}
			}, 
			error: function() {
				alert('Error connecting to server');
			}
		}); // end ajax 
		return true;
	}
	return false;
});


/* =============================================================================
   contact form functions
   ========================================================================== */

// reset input type to text on page load
$('#input-type').val('text');

// add form item
var noFormItems = $('#no-form-items');
$('#add-form-btn').on('click', function() {

	var titleVal = $('#input-title').val(),
		typeVal = $('#input-type').val(),
		nameVal = $('#internal-name').val(),
		activeVal = ($('#item-required').val() == 1) ? 1 : 0;

	// check title and name are set
	if((titleVal != '' && titleVal.length > 0) && (nameVal != '' && nameVal.length > 0)) {

		// make sure inputs don't contain array separator character (,)
		if( (nameVal.match(/,/) != null) || (titleVal.match(/,/) != null) ) {
			setMessage('Inputs can not contain ","');
			return false;
		}

		// check if submit input has already been added - if so exit
		if(($('#form-list').find('input[value="submit"]').length > 0) && (typeVal == 'submit')) {
			setMessage('You can not have more than one submit input per form');
			return false;
		}

		if(noFormItems.length > 0) {
			noFormItems.remove();
		}

		// prep name value
		var newNameVal = nameVal.replace(/\s+/g, '_'),
			newNameVal = newNameVal.toLowerCase();

		// prep form_item
		var valBool = false,
			form_item = $.trim(titleVal)+','+$.trim(typeVal)+','+$.trim(newNameVal)+','+$.trim(activeVal),
			typeInputs = $('.type-inputs');

		if(typeInputs.val()) {
			var retVal = true,
				item_arr = [];
			typeInputs.each(function() {
				if($(this).val().length > 0 && $(this).val() != '') {
					if($(this).val().match(/,/) != null || $(this).val().match(/\|/) != null) {
						setMessage('Inputs can not contain "," or "|"');
						retVal = false;	
					}
					item_arr.push($.trim($(this).val()));
				}
			});
			if(retVal === false) { return false; }
			form_item = form_item + ',' + item_arr.join('|');
			valBool = true;
		} 	

		// append new form input
		var formItemHtml = [
				'<li id="' + titleVal + '">',
					'<div class="form-box">',
						titleVal + '<span class="btn btn-mini form-delete-btn pull-right"><i class="icon-trash"></i></span>&nbsp;&nbsp;<span class="btn btn-mini form-box-btn pull-right">details</span>',
					'</div>',
					'<div class="form-box-settings">',
						'<label for="setting-input-type">input type</label>',
						'<input type="text" name="setting_input_type" value="' + typeVal +'" id="setting-input-type" maxlength="255" size="22"  />',
						((valBool) ? '<label>values</label><input type="text" value="' + item_arr.join('|') +'" size="22" />' : ''),
						'<label for="setting-internal-name">internal name</label>',
						'<input type="text" name="setting_internal_name" value="' + newNameVal +'" id="setting-internal" maxlength="255" size="22"  />',
						(activeVal == 1) ? '<p>required</p>' : '',
						'<input type="hidden" name="form_item[]" value="'+ form_item +'" />',
					'</div>',
				'</li>'
		];
		$('#form-list').append(formItemHtml.join(''));

		// reset inputs
		$('#input-title').val('');
		$('#input-type').val('text');
		$('#internal-name').val('');
		$('#item-required').attr('checked', false);
		$('.input-options').remove();

	} else {
		setMessage('You need to enter an input title, type and internal name to add a new form item');
		return false;
	}
});


// delete form box
$('#form-boxes').on('click', '.form-delete-btn', function() {
	$(this).closest('li').remove();
	// reset 'no form items created' text if no items set
	if($('.form-box').length < 1) {
		$('#form-boxes').append(noFormItems);
	}
});

// accordion for form boxes on 'edit'
$('#form-boxes').on('click', '.form-box-btn, .form-cancel-btn', function() {
	var $this = $(this);
	$this.parent().next().slideToggle();
	// update the btn text
	var btnText = $this.text();
	(btnText == 'details') ? $this.text('close') : $this.text('details');
});

// accordion for form boxes on 'cancel'
$('#form-boxes').on('click', '.form-cancel-btn', function() {
	$(this).closest('.form-box-settings').slideUp();
});


// sortable on the form boxes
$('#form-list').sortable({
	start: function() {
		$('.form-box-settings').slideUp();
	}
});
$('#form-list').disableSelection();


// check if internal name already exists
$('#internal-name').on('blur', function() {	
	var $this = $(this);
	if($this.val().length >= 3) {
		$.ajax({
			type: 'POST',
			url: baseUrl + 'pages/ajax_internal_name_exists',
			data: 'name=' + $this.val() + '&csrf_test_name=' + $('input[name=csrf_test_name]').val(),
			success: function(msg) {
				if(msg == '1') {
					setMessage('Internal name already taken by another input item');
					$this.val('');
				} 
			}
		});
	}
});	


// functions when input type changes
$('#input-type').on('change', function() {
	var $this = $(this),
		inputTypeVal = $this.val();

	if($('.input-options').length > 0) {
		$('.input-options').remove();
	}	

	if(inputTypeVal == 'dropdown' || inputTypeVal == 'radio' || inputTypeVal == 'checkbox') {
		var inputTypeHtml = [
				'<div class="input-options">',
					'<label>'+ inputTypeVal +' options</label>',
					'<input type="text" class="type-inputs" maxlength="255" size="18" />',
					'<div class="btn btn-mini" id="add-input">add another</div>',
				'</div>'
		];
		$this.after(inputTypeHtml.join(''));
	}
});


// add another dropdown item
$('.darker-box-bg').on('click', '#add-input', function() {
	$(this).before('<input type="text" class="type-inputs" maxlength="255" size="18" />');
});


// add another email recipient input 
var emailHtml = [
	'<div class="input-append">',
		'<input class="email-receive span5" type="text" size="35" maxlength="255" value="" name="receive_email[]">',
		'<span class="delete-email btn add-on"><i class="icon-trash"></i></span>',
	'</div>'	
];
$('#add-email-receiver').on('click', function() {
	$(this).parent().before(emailHtml.join(''));
});


// remove email recipient input
$('.form-content').on('click', '.delete-email', function() {
	$(this).parent().remove();
	if($('.email-receive').length < 1) {
		$('#add-email-receiver').parent().before(emailHtml.join(''));
	}
});


// check if email input is valid email
$('.form-content').on('blur', '.receive-email-input', function() {
	if($(this).val().match(/^(.)+@(.)+\.(.)+$/i) == null) {
		setMessage('Invalid email type');
	}
});


/* =============================================================================
   custom fields - pages sections
   ========================================================================== */

// base html for new custom field row
var fieldHtml = [
	'<div class="row field-box">',
        '<div class="span4">', 
 			'<label>field name <i class="info icon-question-sign" rel="tooltip" title="Internal variable name - used to access variable on page. Must be unique to each page"></i>',
  			'<input type="text" name="field_key[]" class="span4 field-key" maxlength="255" size="35">',
			'</div>',
	        '<div class="span6">', 
  			'<label>field value <i class="info icon-question-sign" rel="tooltip" title="Value of field (can be html, img path, simple data, etc)"></i>',
  			'<textarea name="field_value[]" class="span6 field-value" rows="1" cols="50"></textarea>',
  		'</div>',
		'<div class="delete-field btn btn-mini"><i class="icon-trash"></i></div>',
	'</div>'
];

// add field
$('#add-field-btn').on('click', function() {
	$(this).before(fieldHtml.join(''));
});


// delete field
$('#custom-fields').on('click', '.delete-field', function() {
	$(this).parent().remove();
	if($('.field-box').length < 1) {
		$('#custom-fields legend').after(fieldHtml.join(''));
	}
});


/* =============================================================================
   media page
   ========================================================================== */

/*
$('#kcfinder-iframe').load(function() {

	$('#kcfinder-iframe').contents().find('#enable-edit').on('click', function() {
		
		var imgArr = [];
		$('#kcfinder-iframe').contents().find('.name').each(function() {
			imgArr.push($(this).html());
			//console.log($(this).html());
		});
		console.log(imgArr);
	});
});
*/


/* =============================================================================
   manage menu page
   ========================================================================== */

// prevent multiple inputs when adding menu item
$('#target-url').on('blur', function() {
	if($(this).val().length >= 4) {
		// reset dropdown
		$('#target-page').val('null');
	}
});

$('#target-page').on('change', function() {
	$('#target-url').val('');
});


// add menu item
var noMenuItems = $('#no-menu-items');
$('#add-menu-btn').on('click', function() {

	var targetVal = '',
		typeVal = '',
		titleVal = $('#title').val(),
		urlInputVal = $('#target-url').val(),
		selectVal = $('#target-page').val();

	// check both title and target are set
	if( (titleVal != '' && titleVal.length > 0) && (urlInputVal.length > 0 || selectVal != 'null') ) {

		// make sure inputs don't contain array separator character (,)
		if(urlInputVal.match(/,/) != null || titleVal.match(/,/) != null) {
			setMessage('Inputs can not contain ","');
			return false;
		}

		if(noMenuItems.length > 0) {
			noMenuItems.remove();
		}

		if(urlInputVal == '' || urlInputVal.length == 0) {
			if(selectVal != '' && selectVal.length != 0) {
				targetVal = selectVal;
				targetStr = selectVal;
				typeVal = 'page';
			}	
		} else {
			targetStr = urlInputVal;
			targetVal = urlInputVal;
			typeVal = 'url';
		}	

		// append new menu box
		var menuBoxHtml = [
			'<li id="' + titleVal + '">',
                '<div class="menu-box">',
                	titleVal + '<span class="btn btn-mini menu-delete-btn pull-right"><i class="icon-trash"></i></span>&nbsp;&nbsp;<span class="btn btn-mini menu-box-btn pull-right">details</span>',
              	'</div>',
              	'<div class="menu-box-settings">',
                    '<label for="setting-target-url">target</label>',
                    '<input type="text" name="setting_target_url" id="setting-target-url" value="'+ targetStr +'" maxlength="255" size="25">',
                    '<input type="hidden" name="menu_item[]" value="'+titleVal+','+targetVal+','+typeVal+'" />',
              	'</div>',
            '</li>'
		];
		$('#menu-list').append(menuBoxHtml.join(''));

		// reset inputs
		$('#title').val('');
		$('#target-url').val('');
		$('#target-page').val('null');
	
	} else {
		setMessage('You need to enter both menu title and target');
		return false;
	}
});


// delete menu box
$('#menu-list').on('click', '.menu-delete-btn', function() {
	$(this).closest('li').remove();
	// reset 'no menu items created' text if no items set
	if($('.menu-box').length < 1) {
		$('#menu-list').append('<p id="no-menu-items">No menu items created</p>');
	}
});

// accordion for menu boxes on 'edit'
$('#menu-list').on('click', '.menu-box-btn', function() {
	$(this).parent().next().slideToggle();
});

// accordion for menu boxes on 'cancel'
$('#menu-list').on('click', '.menu-cancel-btn', function() {
	$(this).closest('.menu-box-settings').slideUp();
});


// sortable on the menu boxes
$('#menu-list').sortable({
	start: function() {
		$('.menu-box-settings').slideUp();
	},
	update: function(event, ui) {
		var sortArr = $(this).sortable('toArray').join(',');
		$('#menu-form input[name=order]').val(sortArr);
	}
});
$('#menu-list').disableSelection();


/* =============================================================================
   settings section
   ========================================================================== */

// warning message
$('.plugin-check').on('click', function() {
	if(! $(this).is(':checked')) {
		if(confirm('Are you sure you want to disable this plugin?')) {
			return true;
		}
		return false;
	}		
});


/* =============================================================================
   online quotes
   ========================================================================== */

// select all check box
$('.quote-checkbox-all').on('click', function() {
	$('.select-quote').each(function() {
		$(this).attr('checked', true);
	});
});

// clear all checkbox
$('.quote-checkbox-clear').on('click', function() {
	$('.select-quote').each(function() {
		$(this).attr('checked', false);
	});
});

// bulk delete function
$('select#quote-select').change(function(){
	if($('option#option-delete').is(':selected')) {
		// get all the selected checkboxes
		var idArr = [];
		$('.select-quote:checked').each(function() {
			idArr.push($(this).attr('value'));
		});
		if(idArr.length == 0) { 
			$('option#option-delete').val('bulk actions');
			setMessage('No items selected'); 
			return false; 
		}
		if(confirm('Are you sure you want to delete multiple records?')){
			window.location.replace(baseUrl + "quote/delete/" + idArr.join('-'));
		}
		$('option#option-delete').val('bulk actions');
		return false;
	}	
});


/* =============================================================================
   horses
   ========================================================================== */

$('.file-inputs').change('upload-img', function() {
	// add new file input to DOM
	console.log($('.file-box').length);
	if($('.file-box').length < 5) {
		var fileHTML = [
			'<div class="file-box">',
				'<input type="file" name="horse_img[]" class="upload-img" />',
			'</div>'
		];
		$(this).append(fileHTML.join(''));
	} else {
		$(this).append('<p class="img-guidelines">limit 5 uploads</p>');
	}
});

// select all check box
$('.horse-checkbox-all').on('click', function() {
	$('.select-horse').each(function() {
		$(this).attr('checked', true);
	});
});

// clear all checkbox
$('.horse-checkbox-clear').on('click', function() {
	$('.select-horse').each(function() {
		$(this).attr('checked', false);
	});
});

// bulk delete function
$('select#horses-select').change(function(){
	var optionDelete = $('option#option-delete');
	if(optionDelete.is(':selected')) {
		// get all the selected checkboxes
		var idArr = [];
		$('.select-horse:checked').each(function() {
			idArr.push($(this).attr('value'));
		});
		if(idArr.length == 0) { 
			optionDelete.val('bulk actions');
			setMessage('No items selected'); 
			return false; 
		}
		if(confirm('Are you sure you want to delete multiple records?')){
			window.location.replace(baseUrl + "horses/delete/" + idArr.join('-'));
			//console.log(idArr.join('-'));
		}
		optionDelete.val('bulk actions');
		return false;
	}	
});

// set default main image
$('.horse-thumbs img').on('click', function() {
	var $this = $(this);
	// remove class from existing thumb
	$('.thumb-highlight').removeClass('thumb-highlight');
	$this.toggleClass('thumb-highlight');	
	$('#main-img').val($this.attr('src'));
});

// delete horse img ajax
$('.thumb-delete').on('click', function() {
	if(! confirm('Are you sure you want to delete this record?')){
		return false;
	}
	var $this = $(this);
	var fileData = {
		filename: $this.parent().find('img').attr('src'),
		horseId: $this.data('id')
	};
	$.ajax({
		type: 'POST',
		url: baseUrl + 'horses/ajax_delete_horse_img',
		data: 'img=' + JSON.stringify(fileData) + '&csrf_test_name=' + $('input[name=csrf_test_name]').val(),
		success: function(msg) {
			var dataObj = JSON.parse(msg);
			if(dataObj.success) {
				// remove img from DOM
				$this.parent().remove();
				setMessage('Image successfully deleted');
			} else {
				setMessage(dataObj.message);
			}
		},
		error: function(msg) {
			alert('Error accessing resource');
		}
	});
});






})(); // js file end