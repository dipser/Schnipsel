#http://www.typo3.net/tsref/menu-objects/menu-zustaende/

# ContentObjectArray - Da kann alles rein was man möchte
lib.navbar = COA
lib.navbar.wrap = <nav class="navbar navbar-default" role="navigation">|</nav>
lib.navbar {

	# Einfacher Text der am Anfang ausgegeben wird
	10 = TEXT
	10 {
		value = <span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>
		wrap = <div class="navbar-header"><button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#mainnavbar">|</button><a class="navbar-brand" href="#"><i class="glyphicon glyphicon-home"></i></a></div>
	}

	# Hirarchisches Menü
	20 = HMENU
	20.wrap = <div class="collapse navbar-collapse" id="mainnavbar"><ul class="nav navbar-nav">|</ul></div>
	20 {
		entryLevel = 0
		# Seite mit ID 6 nicht anzeigen
		#excludeUidList = 6

		# Textmenü
		1 = TMENU
		1 {
			wrap = |
			# Alle Elemente im Menü anzeigen
			expAll = 1
			# NO: Normal
			NO = 1
			# Alle wraps werden hiermit weggeschmissen die von styledContent geliefert werden
			NO.allWrap >
			NO.wrapItemAndSub = <li>|</li>
			# CUR: Current
			CUR = 1
			# Alles von Normal übernehmen
			CUR < .NO
			# Überschreiben des item-wraps
			CUR.wrapItemAndSub = <li class="active">|</li>
			# ACT: Active
			ACT = 1
			ACT < .CUR

			# Falls es ein Submenü gibt
			IFSUB = 1
			IFSUB < .NO
			IFSUB.wrapItemAndSub = <li class="dropdown">|</li>
			IFSUB.ATagParams = class="dropdown-toggle" role="button" data-toggle="dropdown" data-target="#"
			IFSUB.ATagBeforeWrap = 1
			IFSUB.stdWrap.wrap = |<b class="caret"></b>
			CURIFSUB = 1
			CURIFSUB < .IFSUB
			CURIFSUB.wrapItemAndSub = <li class="dropdown active">|</li>
			ACTIFSUB = 1
			ACTIFSUB < .CURIFSUB
		}

		# Textmenü
		2 = TMENU
		2 {
			wrap = <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">|</ul>
			expAll = 1

			NO = 1
			NO.allWrap >
			NO.wrapItemAndSub = <li>|</li>
			# Rootline definieren
			#ACT = 1
			#ACT < .NO
			#ACT.wrapItemAndSub = <li class="dropdown-submenu active">|</li>
			# Aktiver Navipunkt
			CUR = 1
			CUR < .NO
			CUR.wrapItemAndSub = <li class="active">|</li>

			# Achtung: [ACT/CUR]IFSUB wird vor ACT und CUR ausgeführt
			IFSUB < .NO
			IFSUB.wrapItemAndSub = <li class="dropdown-submenu">|</li>
			ACTIFSUB < .NO
			ACTIFSUB.wrapItemAndSub = <li class="dropdown-submenu active">|</li>
			CURIFSUB < .NO
			CURIFSUB.wrapItemAndSub = <li class="dropdown-submenu active">|</li>

			#SPC = 1
			#SPC.doNotLinkIt = 1
			#SPC.doNotShowLink = 1
			#SPC.allWrap = <li class="divider"></li>
		}

		3 < .2
		3.IFSUB < .2.IFSUB
		3.ACTIFSUB < .2.ACTIFSUB
		3.CURIFSUB < .2.CURIFSUB

		4 < .3
		4.IFSUB < .3.IFSUB
		4.ACTIFSUB < .3.ACTIFSUB
		4.CURIFSUB < .3.CURIFSUB

		5 < .4
		5.IFSUB < .4.IFSUB
		5.ACTIFSUB < .4.ACTIFSUB
		5.CURIFSUB < .4.CURIFSUB

		6 < .5
		6.IFSUB < .5.IFSUB
		6.ACTIFSUB < .5.ACTIFSUB
		6.CURIFSUB < .5.CURIFSUB
	}
}

