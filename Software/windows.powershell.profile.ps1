# Windows PowerShell Aliases
# Setup: Open file with "code $profile" and add this content. Save it. Call ". profile" to refresh current session.
# If your Windows is restricted, call: "Set-ExecutionPolicy -ExecutionPolicy RemoteSigned"
# Source: https://github.com/dipser/Schnipsel/blob/master/Software/windows.powershell.profile.ps1
# Gist: https://gist.github.com/dipser/b674e37c724577a58f08780ab460beae


$etchosts = "C:/Windows/System32/drivers/etc/hosts"


function AliasPA {
    $ESC = [char]27
    echo "> $ESC[33mphp artisan$ESC[0m $args"
    php artisan $args
}
Set-Alias pa AliasPa

function AliasPAOC {
    $ESC = [char]27
    echo "> $ESC[33mphp artisan optimize:clear$ESC[0m $args"
    php artisan optimize:clear $args
}
Set-Alias paoc AliasPAOC

function AliasPAM {
    $ESC = [char]27
    echo "> $ESC[33mphp artisan migrate$ESC[0m $args"
    php artisan migrate $args
}
Set-Alias pam AliasPAM

function AliasPAMF {
    $ESC = [char]27
    echo "> $ESC[33mphp artisan migrate:fresh$ESC[0m $args"
    php artisan migrate:fresh $args
}
Set-Alias pamf AliasPAMF

function AliasPAMFS {
    $ESC = [char]27
    echo "> $ESC[33mphp artisan migrate:fresh --seed$ESC[0m $args"
    php artisan migrate:fresh --seed $args
}
Set-Alias pamfs AliasPAMFS


function AliasCDO {
    $ESC = [char]27
    echo "> $ESC[33mcomposer dump-autoload --optimize$ESC[0m $args"
    composer dump-autoload --optimize $args
}
Set-Alias cdo AliasCDO


function AliasGITPU {
	$CurrentBranch = Get-Git-CurrentBranch
	git push --set-upstream origin $CurrentBranch
}
Set-Alias gitpu AliasGITPU

function AliasGITS {
    $ESC = [char]27
    echo "> $ESC[33mgit status$ESC[0m $args"
    git status $args
}
Set-Alias gits AliasGITS

function AliasGITP {
    $ESC = [char]27
    echo "> $ESC[33mgit pull$ESC[0m $args"
    git pull $args
}
Set-Alias gitp AliasGITP

function AliasGITAC {
    $ESC = [char]27
    $QUOTE = '"'
    echo "> $ESC[33mgit add .$ESC[0m"
    git add .
    echo "> $ESC[33mgit commit -m $QUOTE$ESC[0m$args$ESC[33m$QUOTE$ESC[0m"
    git commit -m "$args"
}
Set-Alias gitac AliasGITAC

function AliasGITACP {
    $ESC = [char]27
    $QUOTE = '"'
    echo "> $ESC[33mgit add .$ESC[0m"
    git add .
    echo "> $ESC[33mgit commit -m $QUOTE$ESC[0m$args$ESC[33m$QUOTE$ESC[0m"
    git commit -m "$args"
    echo "> $ESC[33mgit push$ESC[0m"
    git push
}
Set-Alias gitacp AliasGITACP

function AliasDOTDOT {
    $ESC = [char]27
    echo "> $ESC[33mcd ..$ESC[0m $args"
    cd ..
}
Set-Alias .. AliasDOTDOT

function AliasDOTDOTDOT {
    $ESC = [char]27
    echo "> $ESC[33mcd ../..$ESC[0m $args"
    cd ../..
}
Set-Alias ... AliasDOTDOTDOT


function AliasCDWWW {
    $ESC = [char]27
    echo "> $ESC[33mC:/laragon/www/$ESC[0m$args"
    $www = "C:/laragon/www/$args"
    cd $www
}
Set-Alias cdwww AliasCDWWW

