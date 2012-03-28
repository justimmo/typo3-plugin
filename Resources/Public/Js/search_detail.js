jQuery(function ($) {
	function buildRegionItem(key, val) {
		var
			checkboxHidden = '<input type="hidden" value="" name="tx_justimmo_searchresults[filter][region]" />',
			checkbox = '<input id="detail_region_' + val.id + '" type="checkbox" value="' + val.id + '" name="tx_justimmo_searchresults[filter][region][]">',
			label = '<label for="detail_region_' + val.id + '">' + val.name + '</label>';

		return checkboxHidden + checkbox + label;
	}

	$('#detail_land_id').change(function (event) {
		var
			actionParams = {
				'tx_justimmo_geofilterupdatexhr[countryIdent]': $(this).val()
			},
			items = [];

		$.getJSON(geoFilterUpdateUrls.subDivisions, actionParams, function (data) {
			if ('undefined' === typeof data.bundesland) {
				return false;
			}

			$.each(data.bundesland, function (key, val) {
				items.push('<option value="' + val.name + '">' + val.name + '</option>');
			});

			$('#detail_bundesland_id').html(items.join(''));
		});
		$.getJSON(geoFilterUpdateUrls.regions, actionParams, function (data) {
			if ('undefined' === typeof data.region) {
				return false;
			}

			items = [];

			$.each(data.region, function (key, val) {
				items.push(buildRegionItem(key, val));
			});

			$('#detail_regions').html('<li>' + items.join('</li><li>') + '</li>');
		});
	});

	$('#detail_bundesland_id').change(function (event) {
		var
			actionParams = {
				'tx_justimmo_geofilterupdatexhr[subdivisionIdent]': $(this).val()
			},
			items = [];

		$.getJSON(geoFilterUpdateUrls.regions, actionParams, function (data) {
			if ('undefined' === typeof data.region) {
				return false;
			}

			$.each(data.region, function (key, val) {
				items.push(buildRegionItem(key, val));
			});

			$('#detail_regions').html('<li>' + items.join('</li><li>') + '</li>');
		});
	});
});