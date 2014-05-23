<we:sessionStart />



    <!--
      Umschaltung zwischen den Ansichten für
      eingeloggte und nicht eingeloggte Kunden
    -->
    <we:registerSwitch/>

    <!-- Ansicht für eingeloggte Kunden -->
    <we:ifRegisteredUser>
      <p>
        Hallo <we:sessionField name="Username" type="print"/>.
      </p>

      <!-- Standard-Kundenlogout-Link -->
      <p>
        <we:sessionLogout id="self">Logout</we:sessionLogout>
      </p>

      <!-- Kundenlogout-Formular -->
      <!-- 
        Im Gegensatz zum Standard-Kundenlogout werden bei dem Formular auch alle eventuell
        vorliegenden POST- und GET-Parameter auf die nächste Seite weitergegeben.
      -->
      <?php
        // URL der Zielseite in eine PHP-Variable speichern
        // Alle per GET an die aktuelle Seite übergebenen Parameter werden an die nächste Seite weitergegeben.
        $str_action = (string) 'index.php'.(!empty($_SERVER['QUERY_STRING']) ? '?'.$_SERVER['QUERY_STRING'] : '');
      ?>
      <we:form action="\$str_action" method="post">
        <!-- Parameter für den Logout des Kunden -->
        <input type="hidden" name="we_webUser_logout" value="1" />
        <?php
          // Alle per POST an die aktuelle Seite übergebenen Parameter werden an die nächste Seite weitergegeben.
          foreach ($_POST as $str_key => $str_value)
          {
            if (!is_array($str_value))
            {
              echo '<input type="hidden" name="'.$str_key.'" value="'.htmlentities($str_value).'" />';
            }
          }
        ?>
        <p>
          <input type="submit" value="Logout" />
        </p>
      </we:form>

    </we:ifRegisteredUser>

    <!-- Ansicht für nicht eingeloggte Kunden -->
    <we:ifNotRegisteredUser> 
      <p>
        Sie sind nicht eingeloggt.<br />
        Bitte loggen Sie sich ein!
      </p>

      <we:ifLoginFailed>
        <p>
          <strong>
            Ihr Loginversuch ist fehlgeschlagen.<br/>
          </strong>
          Bitte versuchen Sie es erneut.
        </p>
      </we:ifLoginFailed>

      <!-- Loginformular -->
      <we:form id="self" method="post">
        <p>
          <label for="username">Benutzername:</label>
          <we:sessionField name="Username" type="textinput" id="username" value="maxmustermann" />
        </p>
        <p>
          <label for="password">Kennwort:</label>
          <we:sessionField name="Password" type="password" id="password" value="maxmustermann" />
        </p>
        <p>
          <input type="submit" value="Login" />
        </p>
      </we:form>
    </we:ifNotRegisteredUser>

