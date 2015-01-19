<INCLUDE_TYPOSCRIPT: source="FILE:fileadmin/ts/config.ts">
<INCLUDE_TYPOSCRIPT: source="FILE:fileadmin/ts/mainnav.ts">
<INCLUDE_TYPOSCRIPT: source="FILE:fileadmin/ts/subnav.ts">
<INCLUDE_TYPOSCRIPT: source="FILE:fileadmin/ts/breadcrumb.ts">

page = PAGE

<INCLUDE_TYPOSCRIPT: source="FILE:fileadmin/ts/css.ts">
<INCLUDE_TYPOSCRIPT: source="FILE:fileadmin/ts/js.ts">

page.10 = FLUIDTEMPLATE
page.10 {
	file = fileadmin/templates/Home.html
	partialRootPath = fileadmin/templates/partials
	layoutRootPath = fileadmin/templates/layouts
	variables {
		cleft < styles.content.getLeft
		content < styles.get
		cright < styles.getRight
		cborder < styles.getBorder
	}
}
