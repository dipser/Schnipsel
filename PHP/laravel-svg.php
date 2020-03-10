<?php

function svg($filename): HtmlString
{
    return new HtmlString(
        file_get_contents(resource_path("assets/svg/{$filename}.svg"))
    );
}
