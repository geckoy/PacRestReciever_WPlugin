(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

	$(document).ready( function () {
		$('#Account-Pokemons-table').DataTable();
	} );

	$(document).ready( function () {
		$('#Account-Items-table').DataTable();
	} );



	/**
	 * Player data table search engine
	 */
		$(document).ready(function(){
			$("#player_data_search").on("keyup", function() {
			var value = $(this).val().toLowerCase();
			$("#player_data_table tr").filter(function() {
				$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
			});
			});
		});

	/**
	 * Account items table search engine
	 */
	$(document).ready(function(){
		$("#account_items_search").on("keyup", function() {
		var value = $(this).val().toLowerCase();
		$("#account_items_table tr").filter(function() {
			$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
		});
		});
	});

	/**
	 * Account items table search engine
	 */
	$(document).ready(function(){
		$("#account_candy_search").on("keyup", function() {
		var value = $(this).val().toLowerCase();
		$("#account_candy_table tr").filter(function() {
			$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
		});
		});
	});

	/**
	 * Account items table search engine
	 */
	$(document).ready(function(){
		$("#account_mega_energy_search").on("keyup", function() {
		var value = $(this).val().toLowerCase();
		$("#account_mega_energy_table tr").filter(function() {
			$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
		});
		});
	});

	
})( jQuery );

function display_data(btn)
{
	var secure_text = btn.previousElementSibling;
	if(secure_text.getAttribute("type") == 'password')
	{
		secure_text.setAttribute("type", "text");
		btn.setAttribute("value", "Hide");
	}else{
		secure_text.setAttribute("type", "password");
		btn.setAttribute("value", "display");
	}
	
}

function copyClipboard(input)
{
	var allowed = input.nextElementSibling;
	if(allowed.getAttribute("value") == "Hide")
	{
		input.select();
		input.setSelectionRange(0, 99999)
		document.execCommand("copy");
	}	
}

function allow_edits(input, editbtn)
{
	switch(input) {
		case "username":
		var edited_input = "un_data";
		  break;
		case "password":
		var edited_input = "pw_data";
		  break;
		default:
		var edited_input = undefined;
	}

	var dataInput = document.getElementById(edited_input);

	if(dataInput.hasAttribute("readonly"))
	{
		allow_edits_checkbtn(editbtn);
		dataInput.removeAttribute('readonly');
		alert("WARNING!! Allowed Access to " + input);
	}else
	{
		allow_edits_checkbtn(editbtn);
		alert("WARNING!! Access Already allowed to " + input);
	}	
}

function allow_edits_checkbtn(editbtn)
{
	var securing_btn = editbtn.previousElementSibling; 
	if(securing_btn.value == "display")
	{
		securing_btn.click();
	}
}