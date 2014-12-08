config.no_cache = 1

config.sys_language_uid = 0
# Sprache
config.language = de
# Lokalisierung
config.locale_all = de_DE
config.baseURL = http://domain.de/
config.htmlTag_langKey = de

#en_EN
[globalVar = GP:L=1] || [globalString = ENV:HTTP_HOST=domain.de]
config.sys_language_uid = 1
config.language = en
config.locale_all = en_EN
config.htmlTag_langKey = en
config.sys_language_mode = content_fallback; 0
config.sys_language_overlay =1
[global]

#config.layout = "default"
page = PAGE
page.includeCSS.bootstrap = /fileadmin/bsdist/lib/bootstrap/3.2/css/bootstrap.css
#page.includeCSS.glyphicons = /fileadmin/bsdist/lib/3.2/css/glyphicons.css
#page.includeCSS.custom = /css/custom.css
[browser = msie] and [version= <9]
page.includeJSFooter.html5shiv = /fileadmin/bsdist/lib/bootstrap/js/html5shiv.min.js
page.includeJSFooter.respond = /fileadmin/bootstrap/assets/jquery/respond.min.js
[global]

page.includeJSFooter.jquery = /fileadmin/bsdist/lib/bootstrap/jquery/jquery-2.1.1.min.js
page.includeJSFooter.bootstrap = /fileadmin/bsdist/lib/bootstrap/jquery/bootstrap.js

page.10 = FLUIDTEMPLATE
page.10 {
  file = fileadmin/templates/template1.html
  partialRootPath = fileadmin/templates/partials
  layoutRootPath = fileadmin/templates/layouts
  variables {
    cleft < styles.content.getLeft
    content < styles.content.get
    cright < styles.content.getRight
    cborder < styles.content.getBorder
   
    # Zusätzliche Variable.
    # Verwendung im Template via: {siteName}
    siteName = TEXT
    siteName.value = MEINSEITENTITEL
  }
}


# 
page.20 = CONTENT
page.20 {
	table = tt_content
	select.where = colPos = 4
	select.languageField=sys_language_uid
}
page.20.wrap = <div class="row">|</div>


# Bootstrap Navigation
lib.mainmenu = HMENU
lib.mainmenu {
	entryLevel = 0
	1 = TMENU
	1 {
		wrap = <ul class="nav navbar-nav">|</ul>
		NO = 1
		NO {
			wrapItemAndSub = <li>|</li>
			stdWrap.htmlSpecialChars = 1
		}
		ACT < .NO
		ACT {
			wrapItemAndSub = <li class="active">|</li>
		}
	}
}


# Inhaltselement
# Verwendung im Template via: <f:cObject typoscriptObjectPath="lib.contentY" />
lib.contentY = TEXT
lib.contentY {
	current = 1
	htmlSpecialChars = 1
	value = ausgabe
	wrap = <div>Inhalt: |</div>
}
