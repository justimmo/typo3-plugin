(function ($) {
	"use strict";

	/**
	 * geographical filter form elements update plugin
	 *
	 * This plugin enables updating of geographical form elements for the detail
	 * search form.
	 * Note: this only works on single elements queried with jQuery!
	 *
	 * (c) 2012 B&G Consulting & Commerce GmbH <office@bgcc.at>
	 *
	 * @author Thomas Juhnke <tommy@van-tomas.de>
	 */
	$.fn.GeoFilterUpdate = function (options) {
		var
			settings = $.extend({
				// parameter prefix, corresponds with extension plugin name
				paramPrefix: 'tx_justimmo_geofilterupdatexhr',
				// parameter key which should be set for the update action
				paramKey: '',
				// array of objects with url & callback properties set, defining which url should trigger which update action 
				actions: [],
				// prefix for created filter form fields
				filterFieldPrefix: 'tx_justimmo_searchresults'
			}, options),

			methods = {
				/**
				 * creates an option item for <select> lists
				 *
				 * @param integer key
				 * @param object value
				 * @returns {String} the resulting <option> tag
				 */
				buildOptionItem: function (key, value) {
					return '<option value="' + value.name + '">' + value.name + '</option>';
				},

				/**
				 * creates a checkbox item
				 * @param integer key
				 * @param object value
				 * @returns {String} the resulting checkbox markup
				 */
				buildCheckboxItem: function (key, value) {
					var
						checkboxHidden = '<input type="hidden" value="" name="' + settings.filterFieldPrefix + '[filter][region]" />',
						checkbox = '<input id="detail_region_' + value.id + '" type="checkbox" value="' + value.id + '" name="' + settings.filterFieldPrefix + '[filter][region][]">',
						label = '<label for="detail_region_' + value.id + '">' + value.name + '</label>';

					return checkboxHidden + checkbox + label;
				},

				/**
				 * updates the sub divisions filter element
				 *
				 * @param data incoming API response data as a JSON object
				 * @returns {Boolean} false if data.bundesland element couldn't be found
				 */
				updateSubDivisions: function (data) {
					var
						items = [];

					if ('undefined' === typeof data.bundesland) {
						return false;
					}

					items.push('<option value=""></option>');
					$.each(data.bundesland, function (key, val) {
						items.push(methods.buildOptionItem(key, val));
					});

					$('#bundeslandId-container').html('<select id="detail_bundesland_id" name="' + settings.filterFieldPrefix + '[filter][bundeslandId]">' + items.join('') + '</select>');
				},

				/**
				 * updates the region filter elements (checkboxes)
				 * 
				 * @param data incoming API response data as a JSON object
				 * @returns {Boolean} false if data.region element couldn't be found
				 */
				updateRegions: function (data) {
					var
						items = [];

					if ('undefined' === typeof data.region) {
						return false;
					}

					$.each(data.region, function (key, val) {
						items.push(methods.buildCheckboxItem(key, val));
					});

					$('#detail_regions').html('<li>' + items.join('</li><li>') + '</li>');
				}
			};

		/**
		 * binds the change event listener to the incoming jQuery object
		 */
		this.change(function (event) {
			var
				// field value of bound HTML node
				fieldValue = $(this).val();

			// iterate over defined actions
			$.each(settings.actions, function (key, value) {
				var
					// set the action parameters
					actionParam = settings.paramPrefix + '[' + settings.paramKey + ']=' + fieldValue;

				// finally, fire the getJSON request
				$.getJSON(value.url, actionParam, methods[value.callback]);
			});
		});
	};
}(jQuery));