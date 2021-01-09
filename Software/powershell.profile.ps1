
# Windows PowerShell Aliases
# Setup: Open file with "code $profile" and add this content.


$etchosts = "C:/Windows/System32/drivers/etc/hosts"


function Do-PA {
    $ESC = [char]27
    echo "> $ESC[33mphp artisan$ESC[0m $args"
    php artisan $args
}
Set-Alias pa Do-Pa

function Do-PAOC {
    $ESC = [char]27
    echo "> $ESC[33mphp artisan optimize:clear$ESC[0m $args"
    php artisan optimize:clear $args
}
Set-Alias paoc Do-PAOC

function Do-PAM {
    $ESC = [char]27
    echo "> $ESC[33mphp artisan migrate$ESC[0m $args"
    php artisan migrate $args
}
Set-Alias pam Do-PAM

function Do-PAMF {
    $ESC = [char]27
    echo "> $ESC[33mphp artisan migrate:fresh$ESC[0m $args"
    php artisan migrate:fresh $args
}
Set-Alias pamf Do-PAMF

function Do-PAMFS {
    $ESC = [char]27
    echo "> $ESC[33mphp artisan migrate:fresh --seed$ESC[0m $args"
    php artisan migrate:fresh --seed $args
}
Set-Alias pamfs Do-PAMFS


function Do-CDO {
    $ESC = [char]27
    echo "> $ESC[33mcomposer dump-autoload --optimize$ESC[0m $args"
    composer dump-autoload --optimize $args
}
Set-Alias cdo Do-CDO


function Do-GITS {
    $ESC = [char]27
    echo "> $ESC[33mgit status$ESC[0m $args"
    git status $args
}
Set-Alias gits Do-GITS

function Do-GITP {
    $ESC = [char]27
    echo "> $ESC[33mgit pull$ESC[0m $args"
    git pull $args
}
Set-Alias gitp Do-GITP

function Do-GITACP {
    $ESC = [char]27
    $QUOTE = '"'
    echo "> $ESC[33mgit add .$ESC[0m"
    echo "> $ESC[33mgit commit -m $QUOTE$ESC[0m$args$ESC[33m$QUOTE$ESC[0m"
    echo "> $ESC[33mgit push$ESC[0m"
    git add .
    git commit -m "$args"
    git push
}
Set-Alias gitacp Do-GITACP

function Do-DOTDOT {
    $ESC = [char]27
    echo "> $ESC[33mcd ..$ESC[0m $args"
    cd ..
}
Set-Alias .. Do-DOTDOT

function Do-DOTDOTDOT {
    $ESC = [char]27
    echo "> $ESC[33mcd ../..$ESC[0m $args"
    cd ../..
}
Set-Alias ... Do-DOTDOTDOT


function Do-CDWWW {
    $ESC = [char]27
    echo "> $ESC[33mC:/laragon/www/$ESC[0m$args"
    $www = "C:/laragon/www/$args"
    cd $www
}
Set-Alias cdwww Do-CDWWW


