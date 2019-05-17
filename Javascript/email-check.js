let email = 'asdf@asdf.de';
let input = document.createElement('input');
input.setAttribute('type', 'email');
input.setAttribute('value', email);
if ( !input.checkValidity() ) {
        // WRONG
}
