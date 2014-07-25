function filter_email($mail) {
    if ( ! filter_var($mail, FILTER_VALIDATE_EMAIL) ) {
        $in = explode('@', $mail);
        if (function_exists('idn_to_ascii')) { // PHP 5 >= 5.3.0
            $in[0] = idn_to_ascii($in[0]);
            $in[1] = idn_to_ascii($in[1]);
        }
        return (bool) filter_var(implode('@', $in), FILTER_VALIDATE_EMAIL);
    }
    return true;
}
//filter_email('mäx@domäne.com')
