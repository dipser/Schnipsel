<INCLUDE_TYPOSCRIPT: source="FILE:fileadmin/ts/config.ts">
<INCLUDE_TYPOSCRIPT: source="FILE:fileadmin/ts/language.ts">
#<INCLUDE_TYPOSCRIPT: source="FILE:fileadmin/ts/mainnav.ts">
<INCLUDE_TYPOSCRIPT: source="FILE:fileadmin/ts/mainnav-multilevel.ts">
#<INCLUDE_TYPOSCRIPT: source="FILE:fileadmin/ts/subnav.ts">
<INCLUDE_TYPOSCRIPT: source="FILE:fileadmin/ts/breadcrumb.ts">
<INCLUDE_TYPOSCRIPT: source="FILE:fileadmin/ts/metanav.ts">

page = PAGE

page.meta.X-UA-Compatible = IE=edge,chrome=1
page.meta.X-UA-Compatible.httpEquivalent = 1

page.meta.description.data = page:description
page.meta.keywords.data = page:keywords
page.meta.viewport  = width=device-width, initial-scale=1.0
page.meta.robots = index,follow
page.meta.date.data = page:SYS_LASTCHANGED

<INCLUDE_TYPOSCRIPT: source="FILE:fileadmin/ts/css.ts">
<INCLUDE_TYPOSCRIPT: source="FILE:fileadmin/ts/js.ts">


# Template 
Template = TEXT
Template.value = standardseite.html
[globalVar = TSFE:page|backend_layout = 2]
    Template.value = startseite.html
[global]

page.10 = FLUIDTEMPLATE
page.10 {
    file < Template.value
    file.wrap = fileadmin/templates/|
    partialRootPath = fileadmin/templates/partials
    layoutRootPath = fileadmin/templates/layouts
    variables {
        # col = 0
        content < styles.content.get
        # col = 1
        cleft < styles.content.getLeft
        # col = 2
        cright < styles.content.getRight
        # col = 3
        cborder < styles.content.getBorder
        # col = 4 (kopiert Darstellung von getBorder und holt Inhalt aus col 4)
        #cfour < styles.content.getBorder.select.where = colPos=4
    }

    # Zusätzliche Variablen -- Verwendung im Template via: {siteName}
    siteName = TEXT
    siteName.value = MEIN SEITENTITEL
}




