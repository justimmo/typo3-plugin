== Official TYPO3 CMS PLUGIN ==

This plugin comes with different plugins/widgets to place on your website.
The '''JUSTIMMO Real Estate Search''' queries the justimmo.at REST API to retrieve its objets.

=== Widgets we offer ===

* Search Results
* Quick Search
* Realty Number Search
* Realty Detail
* Detail Search

== Setup ==

```

plugin.tx_justimmo.settings.api.password = mysupersecretpass
plugin.tx_justimmo.settings.api.username = api-xxxx
# Page ID of the page where the 'Search Results' widget is placed
plugin.tx_justimmo.settings.searchResultsPid = 321
# Page ID of the page where the 'Realty Details' widget is placed
plugin.tx_justimmo.settings.realtyDetailPid = 123


```

== Appendix - Extbase Insights ==

'''Key'''
``ext:justimmo``

