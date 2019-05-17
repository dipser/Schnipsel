        var input = document.createElement("input");
        input.setAttribute('type', 'email');
        input.setAttribute('value', e.item);
        if ( !input.checkValidity() ) { e.cancel = true; }
