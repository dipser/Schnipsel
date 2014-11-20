config.no_cache = 1

config.sys_language_uid = 0
config.language = de
config.locale_all = de_DE
config.baseURL = http://t3.heinerjuetting.de/
config.htmlTag_langKey = de

#en_EN
[globalVar = GP:L=1] || [globalString = ENV:HTTP_HOST=t3.heinerjuetting.de]
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
   
  }
}


page.20 = CONTENT
page.20 {
	table = tt_content
	select.where = colPos = 4
	select.languageField=sys_language_uid
}
page.20.wrap = <div class="row">|</div>
