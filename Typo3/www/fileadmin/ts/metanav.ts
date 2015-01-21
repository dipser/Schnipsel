
# Meta Navigation
lib.metanav = COA
lib.metanav {
 
  10 = HMENU
  10 {
    special = directory
    # ID des Systemverzeichnis
    special.value = 5
 
    1 = TMENU
    1 {
      wrap = <ul class="metanav">|</ul>
      expAll = 0
      noBlur = 1
 
      NO {
        wrapItemAndSub = <li class="first">|</li>|*|<li>|</li>|*|<li class="last">|</li>
      }
    }
  }
 
}

