/**
 * @license Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here.
	// For complete reference see:
	// http://docs.ckeditor.com/#!/api/CKEDITOR.config
	config.height = '600px';
	// The toolbar groups arrangement, optimized for two toolbar rows.
	config.toolbarGroups = [
		{ name: 'clipboard',    groups: [ 'clipboard', 'undo' ] },
		{ name: 'styles'},
		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup', 'Undo' ] },
		{ name: 'paragraph',   groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ] },
		{ name: 'links' },
		{ name: 'insert' },
		{ name: 'forms' },
		{ name: 'tools' },
		{ name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
		{ name: 'others' }
	];

	// Remove some buttons provided by the standard plugins, which are
	// not needed in the Standard(s) toolbar.
	config.removeButtons = 'Cut,Copy,Paste,Styles,Redo,Indent,Outdent,Strike,Subscript,Superscript,Anchor,SpecialChar,Table,HorizontalRule';

	// Set the most common block elements.
	config.format_tags = 'p;h3;h4';

	// Simplify the dialog windows.
	config.removeDialogTabs = 'link:advanced';
	config.enterMode = CKEDITOR.ENTER_P;
	config.shiftEnterMode = CKEDITOR.ENTER_BR;
	config.language = 'zh-cn';
};

CKEDITOR.on('instanceReady', function(ev) {
	ev.editor.on('paste', function(ev) {
		ev.data.dataValue = ev.data.dataValue.replace(/<br>/g, '</p><p>');
	});
});