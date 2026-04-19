$ErrorActionPreference = "Stop"
$WorkingDir = "c:\Users\swata\.gemini\antigravity\scratch\Medicare-WebApp-main"
$PhpDir = Join-Path $WorkingDir "bin\php"
$PhpZipPath = Join-Path $WorkingDir "php.zip"

If (-Not (Test-Path "$PhpDir\php.exe")) {
    Write-Host "Downloading PHP 8.2..."
    # Download PHP 8.2 NTS for Windows from archives, as main releases get purged
    Invoke-WebRequest -Uri "https://windows.php.net/downloads/releases/archives/php-8.2.11-nts-Win32-vs16-x64.zip" -OutFile $PhpZipPath
    
    Write-Host "Extracting PHP..."
    Expand-Archive -Path $PhpZipPath -DestinationPath $PhpDir -Force
    Remove-Item $PhpZipPath

    Write-Host "Configuring PHP..."
    $PhpIni = Join-Path $PhpDir "php.ini"
    Copy-Item (Join-Path $PhpDir "php.ini-development") $PhpIni
    
    # Enable PDO SQLite extensions
    $IniContent = Get-Content $PhpIni
    $IniContent = $IniContent -replace ";extension=pdo_sqlite", "extension=pdo_sqlite"
    $IniContent = $IniContent -replace ";extension=sqlite3", "extension=sqlite3"
    $IniContent = $IniContent -replace ";extension_dir = `"ext`"", "extension_dir = `"ext`""
    Set-Content $PhpIni $IniContent
}

Write-Host "Initializing SQLite Database..."
& "$PhpDir\php.exe" "$WorkingDir\medicare-app\initialize_db.php"

Write-Host "Starting PHP Built-in Server on http://localhost:8000/medicare-app/public/"
Set-Location "$WorkingDir"
& "$PhpDir\php.exe" -S localhost:8000
