
config.no_cache = 0

# Extention: Indexed_search
plugin.tx_indexedsearch._DEFAULT_PI_VARS.lang = 0
config.no_search = 0
config.index_enable = 1


config {
    concatenateJs = 1
    concatenateCss = 1
    compressJs = 1
    compressCss = 1
}
config.metaCharset = utf-8




# ID der Frontend-Sprache festlegen
config.sys_language_uid = 0
# Sprache (= Reine Übersetzung)
# ISO-Kennung der Frontend-Sprache festlegen (2-stellig)
config.language = de
# Lokalisierung (= Umgebung und Kultur)
# Locale festlegen (5-stelliger ISO-Code + Zeichensatz)
config.locale_all = de_DE
config.htmlTag_langKey = de

# Bei nicht übersetzten Seiten nicht zur Default-Sprache wechseln
config.sys_language_mode = content_fallback
# Nicht übersetzte Inhalte in der Default-Sprache anzeigen
config.sys_language_overlay = 1

# Konfiguration wenn &L=1 angegeben
[globalVar = GP:L = 1] || [globalString = ENV:HTTP_HOST=domain.de]
  config.sys_language_uid = 1
  config.language = en
  config.locale_all = en_EN
  config.htmlTag_langKey = en
[global]

# Konfiguration wenn &L=2 angegeben
[globalVar = GP:L = 2]
  config.sys_language_uid = 2
  config.language = fr
  #config.locale_all = fr_FR
  config.sys_language_mode = content_fallback; 1
  config.sys_language_overlay =1
[global]

# Konfiguration wenn &L=3 angegeben
[globalVar = GP:L = 3]
  config.sys_language_uid = 3
  config.language = es
  #config.locale_all = es_ES
[global]

# der Paramter L soll durchgereicht werden
config.linkVars := addToList(L)
# der Paramter soll eindeutig sein (kein doppeltes Auftreten in einer URL)
config.uniqueLinkVars = 1


# Extention: RealUrl
config.simulateStaticDocuments = 0
config.baseURL = http://lyra.et-inf.fho-emden.de:14011/
config.tx_realurl_enable = 1
config.disablePrefixComment = 1
config.prefixLocalAnchors = all






#/*
config.baseURL = http://lyra.et-inf.fho-emden.de:14011/
[globalString = ENV:HTTPS=on]
  config.baseURL = https://lyra.et-inf.fho-emden.de:15011/
[global]
#*/



# http://docs.typo3.org/typo3cms/TyposcriptReference/ContentObjects/Image/Index.html
lib.logoimage = IMAGE
lib.logoimage {
	file = fileadmin/res/img/logoimg.png
}


lib.logo < lib.logoimage
lib.logo {
	params = class="img-responsive"
	# c = Croppen / Ausschneiden
	# m = Minimieren
	#file.width = 20m
	#file.height = 20m
	#file.noScale = 1

	stdWrap.typolink.parameter = 1
	stdWrap.typolink.ATagParams = class="home"
	stdWrap.typolink.title = Zur Startseite
}


lib.rechtespalte = CONTENT
lib.rechtespalte {
	table = tt_content
	# ID deiner Seite
	select.pidInList = 14


	renderObj = COA
	renderObj {

		10 = TEXT

		# Im Feld tt_content.header steht die Überschrift.
		10.field = header

		10.wrap = <h3>|</h3>

		20 = TEXT

		# Im feld tt_content.bodytext steht der Text.
		20.field = bodytext

		20.wrap = <p>|</p>
	}

        wrap = <div class="important">|</div>
}