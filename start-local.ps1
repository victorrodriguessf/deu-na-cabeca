$ErrorActionPreference = 'Stop'
$projectRoot = $PSScriptRoot
$phpExecutable = (Get-Command php -ErrorAction Stop).Source
$localState = Join-Path $projectRoot '.local'
New-Item -ItemType Directory -Path $localState -Force | Out-Null

# The widget refreshes in the browser; only the local PHP server is needed.
$listener = Get-NetTCPConnection -LocalPort 8000 -State Listen -ErrorAction SilentlyContinue
if (-not $listener) {
    $publicPath = Join-Path $projectRoot 'public'
    $routerPath = Join-Path $projectRoot 'vendor/laravel/framework/src/Illuminate/Foundation/resources/server.php'
    $server = Start-Process -FilePath $phpExecutable -WorkingDirectory $publicPath -WindowStyle Hidden -PassThru -ArgumentList @(
        '-S', '127.0.0.1:8000', '-t', ('"' + $publicPath + '"'), ('"' + $routerPath + '"')
    ) -RedirectStandardOutput (Join-Path $localState 'server.out.log') -RedirectStandardError (Join-Path $localState 'server.err.log')
    $server.Id | Set-Content -LiteralPath (Join-Path $localState 'server.pid')
}

$schedulerPidFile = Join-Path $localState 'scheduler.pid'
if (Test-Path -LiteralPath $schedulerPidFile) {
    $savedPid = (Get-Content -LiteralPath $schedulerPidFile -Raw).Trim()
    if ($savedPid -match '^\d+$') {
        $savedProcess = Get-CimInstance Win32_Process -Filter "ProcessId = $savedPid" -ErrorAction SilentlyContinue
        if ($savedProcess -and $savedProcess.CommandLine.Contains($projectRoot) -and $savedProcess.CommandLine.Contains('schedule:work')) {
            Stop-Process -Id ([int]$savedPid) -ErrorAction SilentlyContinue
        }
    }
}
Write-Output 'Deu na Cabeça: http://127.0.0.1:8000 (servidor em segundo plano; resultados PT Rio via widget)'
