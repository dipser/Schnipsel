<INCLUDE_TYPOSCRIPT: source="FILE:fileadmin/ts/config.ts">
<INCLUDE_TYPOSCRIPT: source="FILE:fileadmin/ts/mainnav.ts">
#<INCLUDE_TYPOSCRIPT: source="FILE:fileadmin/ts/subnav.ts">
<INCLUDE_TYPOSCRIPT: source="FILE:fileadmin/ts/breadcrumb.ts">
<INCLUDE_TYPOSCRIPT: source="FILE:fileadmin/ts/metanav.ts">

page = PAGE

<INCLUDE_TYPOSCRIPT: source="FILE:fileadmin/ts/css.ts">
<INCLUDE_TYPOSCRIPT: source="FILE:fileadmin/ts/js.ts">

page.10 = FLUIDTEMPLATE
page.10 {
	file = fileadmin/templates/template.html
	partialRootPath = fileadmin/templates/partials
	layoutRootPath = fileadmin/templates/layouts
	variables {
		cleft < styles.content.getLeft
		content < styles.content.get
		cright < styles.content.getRight
		cborder < styles.content.getBorder
	}
	
	# Zusätzliche Variable.
	# Verwendung im Template via: {siteName}
	siteName = TEXT
	siteName.value = MEINSEITENTITEL
}
