config.no_cache = 1

config {
    concatenateJs = 1
    concatenateCss = 1
    compressJs = 1
    compressCss = 1
}

config.sys_language_uid = 0
# Sprache
config.language = de
# Lokalisierung
config.locale_all = de_DE
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


# Extention: RealUrl
config.simulateStaticDocuments = 0
config.baseURL = http://wpfcms.local
config.tx_realurl_enable = 1
config.disablePrefixComment = 1
config.prefixLocalAnchors = all

#config.baseURL = http://www.domain.de/
[globalString = ENV:HTTPS=on]
#  config.baseURL = https://www.domain.de/
[global]
