lib.breadcrumb = COA
lib.breadcrumb {
	20 = HMENU
	20 {
		# rooline - geht die linie der navigation nach und nicht hierarchisch
		special = rootline
		# -1 steht für "Home"
		special.range = 0|-1
		wrap = <ol class="breadcrumb">|</ol>

		1 = TMENU
		1 {
			#wrap = |
			expAll = 1

			NO = 1
			NO.wrapItemAndSub = <li rowl="active">|</li>
			CUR = 1
			CUR < .NO
			ACT = 1
			ACT < .CUR
			ACT.wrapItemAndSub = <li>|</li>
		}
	}
}
