# Instala e ativa plugins essenciais (secção 9.1 do documento de requisitos).
# Uso: na raiz do repositório, executar: .\scripts\install-plugins.ps1

$ErrorActionPreference = 'Stop'
$root = Split-Path -Parent $PSScriptRoot
Set-Location -LiteralPath $root

if (-not (Get-Command docker -ErrorAction SilentlyContinue)) {
	Write-Error 'Comando "docker" não encontrado. Instale o Docker Desktop e tente de novo.'
	exit 1
}

$plugins = @(
	'wordpress-seo',
	'w3-total-cache',
	'wordfence',
	'contact-form-7',
	'updraftplus'
)

docker compose --profile wpcli run --rm wpcli wp plugin install @plugins --activate

Write-Host ''
Write-Host 'Concluído. Abra o wp-admin e complete os assistentes (Yoast, Wordfence, Updraft, W3TC).' -ForegroundColor Green
Write-Host 'Detalhes: PLUGINS-WORDPRESS.txt' -ForegroundColor Gray
