# Windows PowerShell Aliases
# Setup: Open file with "code $profile" and add this content. Save it. Call ". $profile" to refresh current session.
# If your Windows is restricted, call: "Set-ExecutionPolicy -ExecutionPolicy RemoteSigned"
# Source: https://github.com/dipser/Schnipsel/blob/master/Software/windows.powershell.profile.ps1
# Gist: https://gist.github.com/dipser/b674e37c724577a58f08780ab460beae


$etchosts = "C:/Windows/System32/drivers/etc/hosts"


#
# PHP ARTISAN
#

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


function AliasSail {
    $ESC = [char]27
    echo "> $ESC[33m./vendor/bin/sail$ESC[0m $args"
    ./vendor/bin/sail $args
}
Set-Alias sail AliasSail


function AliasCDAO {
    $ESC = [char]27
    echo "> $ESC[33mcomposer dump-autoload --optimize$ESC[0m $args"
    composer dump-autoload --optimize $args
}
Set-Alias cdao AliasCDAO
Set-Alias cdo AliasCDAO


#
# NPM
#

function AliasNPMU {
    $ESC = [char]27
    echo "> $ESC[33mnpm install -g npm-check-updates$ESC[0m"
    git status $args
    echo "> $ESC[33mncu -u$ESC[0m"
    ncu -u
}
Set-Alias gs AliasNPMU



#
# GIT
#

function AliasGS {
    $ESC = [char]27
    echo "> $ESC[33mgit status$ESC[0m $args"
    git status $args
}
Set-Alias gs AliasGS

function AliasGP {
    $ESC = [char]27
    echo "> $ESC[33mgit pull$ESC[0m $args"
    git pull $args
}
#Set-Alias gp AliasGP
Set-Alias gg AliasGP

function AliasGPU {
	$CurrentBranch = Get-Git-CurrentBranch
	git push --set-upstream origin $CurrentBranch
}
Set-Alias gpu AliasGPU

function AliasGAC {
    $ESC = [char]27
    $QUOTE = '"'
    echo "> $ESC[33mgit add .$ESC[0m"
    git add .
    echo "> $ESC[33mgit commit -m $QUOTE$ESC[0m$args$ESC[33m$QUOTE$ESC[0m"
    git commit -m "$args"
}
Set-Alias gac AliasGAC

function AliasGACP {
    $ESC = [char]27
    $QUOTE = '"'
    echo "> $ESC[33mgit add .$ESC[0m"
    git add .
    echo "> $ESC[33mgit commit -m $QUOTE$ESC[0m$args$ESC[33m$QUOTE$ESC[0m"
    git commit -m "$args"
    echo "> $ESC[33mgit push$ESC[0m"
    git push
}
Set-Alias gacp AliasGACP


#
# cd
#

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

function AliasWWW {
    $ESC = [char]27
    echo "> $ESC[33mC:/laragon/www/$ESC[0m$args"
    $www = "C:/laragon/www/$args"
    cd $www
}
Set-Alias www AliasWWW

function AliasCreateWWW {
    $ESC = [char]27
    echo "> $ESC[33mC:/laragon/www/$ESC[0m$args"
    $www = "C:/laragon/www/"
    $folder = "C:/laragon/www/$args"
    #mkdir -p $folder
    New-Item -Path $folder -ItemType Directory
    start "C:/Program Files/Microsoft VS Code/Code.exe" $folder
}
Set-Alias createwww AliasCreateWWW
Set-Alias cwww AliasCreateWWW
