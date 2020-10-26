<?php


if ( !function_exists('active_path') ) {
    function active_path($path)
    {
        $isPath = call_user_func_array('Request::is', (array)$path);
        return $isPath;
    }
}


// Source: https://github.com/laravel/ideas/issues/828
use Carbon\Carbon;
if ( !function_exists('carbonize') ) {
    /**
     * @param mixed $datetime
     * @param string|null $tz
     * @return Carbon
     * @throws InvalidArgumentException
     */
    function carbonize($datetime = null, $tz = null)
    {
        switch (true) {
            case is_null($datetime):
                return new Carbon(null, $tz);
            case $datetime instanceof Carbon:
                $dt = clone $datetime;
                return is_null($tz) ? $dt : $dt->setTimezone($tz);
            case $datetime instanceof DateTimeInterface:
                $dt = new Carbon($datetime->format('Y-m-d H:i:s.u'), $datetime->getTimezone());
                return is_null($tz) ? $dt : $dt->setTimezone($tz);
            case is_numeric($datetime) && (string) (int) $datetime === (string) $datetime:
                return Carbon::createFromTimestamp((int) $datetime, $tz);
            case is_string($datetime) && strtotime($datetime) !== false:
                $dt = new Carbon($datetime, $tz);
                return is_null($tz) ? $dt : $dt->setTimezone($tz);
            default:
                throw new InvalidArgumentException(
                    "That is not a date time of any sort that I can deal with"
                );
        }
    }
}
if ( !function_exists('carbon') ) {
    /**
     * @param mixed $datetime
     * @param string|null $tz
     * @return Carbon
     * @throws InvalidArgumentException
     */
    function carbon($datetime = null, $tz = null)
    {
        return carbonize($datetime, $tz);
    }
}



use Illuminate\Mail\Markdown;
if ( !function_exists('markdown_to_html') ) {
    /**
     * @param string $text
     * @return String
     */
    function markdown_to_html($text = null)
    {
        $text = (String) ($text ?? '');
        return Markdown::parse($text);
    }
}



if ( !function_exists('mask_iban') ) {
    // Versteckt ein paar Zeichen innerhalb der IBAN
    function mask_iban($iban)
    {
        return substr($iban, 0, 9) . str_repeat('*', strlen($iban) - 13) . substr($iban, -4);
    }
}


if ( !function_exists('price') ) {
    // Preisformat
    function price($price = 0)
    {
        return money_format('%!.2n', $price);
    }
}
