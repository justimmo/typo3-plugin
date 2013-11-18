## Official TYPO3 CMS PLUGIN 

This plugin comes with different plugins/widgets to place on your website.
The '''JUSTIMMO Real Estate Search''' queries the justimmo.at REST API to retrieve its objets.

## Widgets we offer

* Search Results
* Quick Search
* Realty Number Search
* Realty Detail
* Detail Search

## Setup

```

plugin.tx_justimmo.settings.api.password = mysupersecretpass
plugin.tx_justimmo.settings.api.username = api-xxxx
# Page ID of the page where the 'Search Results' widget is placed
plugin.tx_justimmo.settings.searchResultsPid = 321
# Page ID of the page where the 'Realty Details' widget is placed
plugin.tx_justimmo.settings.realtyDetailPid = 123


```

## Appendix - Extbase Insights

_Key_
``ext:justimmo``


## Verfügbare Felder in Layouts

Listenansicht
* id
* objektnummer
* titel
* dreizeiler (als SimpleXMLObject)
* naehe
* objektbeschreibung
* anzahl_zimmer
* etage (als SimpleXMLObject)
* tuernummer (als SimpleXMLObject)
* plz
* ort
* kaufpreis
* wohnflaeche
* erstes_bild
* zweites_bild

Detailansicht:

* Position
* Id
* Objektnummer
* Titel
* Objektbeschreibung
* Anzahl_zimmer
* Plz
* Ort
* Kaufpreis
* Gesamtmiete
* Wohnflaeche
* Nutzflaeche
* Erstes_bild
* Pdf_bild
* NbAnhaenge
* Anhaenge
* NbDokumente
* Dokumente
* Objektart
* ObjektartNormalized
* NbNutzungsart
* IsNutzungsartWohnen
* IsNutzungsartGewerbe
* IsNutzungsartAnlage
* ObjektnrExtern
* ObjektnrIntern
* Preise
* Nettomiete
* HasAusstattungsBeschreibung
* HasTelefonZentrale
* HasTelefonHandy
* HasFax
* Geo
* Freitexte
* Objekttitel
* Zustand_angaben
* Flaechen
* Kontaktperson
* Verwaltung_techn
* HasGeokoordinaten
* Breitengrad
* Laengengrad