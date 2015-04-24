lib.subnav = COA
lib.subnav.wrap = <ul class="nav nav-pills">|</ul>
lib.subnav {
	20 = HMENU
	20.wrap = |
	20 {
		# Eintrittsebene
		entryLevel = 2
		1 = TMENU
		1 {
			#wrap = |
			expAll = 0

			NO = 1
			NO.allWrap >
			NO.wrapItemAndSub = <li role="presentation">|</li>
			CUR = 1
			CUR < .NO
			CUR.wrapItemAndSub = <li role="presentation" class="active">|</li>
			ACT = 1
			ACT < .CUR
		}
	}
}
