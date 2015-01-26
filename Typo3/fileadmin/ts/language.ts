lib.language = HMENU
lib.language {
  special = language
  special.value = 0,2,3,4

  1 = TMENU
  1 {
    wrap = <ul class="language">|</ul>

    # Normal
    NO = 1  
    NO {
      stdWrap.cObject = TEXT
      stdWrap.cObject {
        value  (
          <img src="typo3/gfx/flags/de.gif" alt="Deutsch" /> || 
          <img src="typo3/gfx/flags/gb.gif" alt="English" /> ||
          <img src="typo3/gfx/flags/fr.gif" alt="Francais" /> ||
          <img src="typo3/gfx/flags/es.gif" alt="Espanol" />
        )
      }
      allWrap = <li class="language">|</li>
    }

    # Atkiv.
    ACT < lib.language.1.NO
    ACT = 1
    ACT {
      doNotLinkIt = 1
      allWrap = <li class="language language-active">|</li>
    }

    # Keine Übersetzung vorhanden.
    USERDEF1 < lib.language.1.NO
    USERDEF1 {
      doNotLinkIt = 1
      allWrap = <li class="language language-empty">|</li>
    }

    # Keine Übersetzung vorhanden. Aktiv.
    USERDEF2 < lib.language.1.NO
    USERDEF2 {
      doNotLinkIt = 1
      allWrap = <li class="language language-active language-empty">|</li>
    }
  }
}

