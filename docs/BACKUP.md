# Backup e restauração — Portal SI CEFET/RJ

Guia para **preservar e repassar** o site completo (conteúdo + mídia + banco), não apenas o código do Git.

> O repositório Git contém o **tema** e a **infra Docker**.  
> Páginas, notícias, professores, uploads e plugins ficam nos **volumes Docker** — sem backup, um novo desenvolvedor não vê o mesmo portal.

---

## O que precisa ser guardado

| Componente | Onde está | Incluir no backup? |
|------------|-----------|-------------------|
| Tema `portal-si-cefet` | Git + bind mount | ✅ (Git) |
| Banco MariaDB | Volume `db_data` | ✅ **obrigatório** |
| Uploads (PDFs, imagens) | Volume `wp_data` → `wp-content/uploads/` | ✅ **obrigatório** |
| Plugins instalados | Volume `wp_data` → `wp-content/plugins/` | ✅ recomendado |
| `.env` (senhas) | Ficheiro local na VM | ✅ guardar em local **seguro** (cofre de senhas) |
| Certificados Caddy | `/var/lib/caddy/` (host) | Opcional (renovam sozinhos) |

---

## 1. Backup manual (VM / servidor)

Executar na pasta do projeto (`~/projeto`):

### 1.1 Banco de dados (SQL)

```bash
cd ~/projeto
mkdir -p ~/backups-portal

docker compose exec -T db mariadb-dump \
  -u wordpress -p"${WORDPRESS_DB_PASSWORD}" wordpress \
  > ~/backups-portal/portal-$(date +%Y%m%d-%H%M)-db.sql
```

> Substituir a senha ou exportar antes: `export WORDPRESS_DB_PASSWORD='...'` a partir do `.env`.

Alternativa com root (se necessário):

```bash
docker compose exec -T db mariadb-dump \
  -u root -p"${MARIADB_ROOT_PASSWORD}" wordpress \
  > ~/backups-portal/portal-$(date +%Y%m%d-%H%M)-db.sql
```

### 1.2 Uploads e plugins (volume WordPress)

```bash
docker run --rm \
  -v projeto_wp_data:/data:ro \
  -v ~/backups-portal:/backup \
  alpine tar czf /backup/portal-$(date +%Y%m%d-%H%M)-wp-content.tar.gz \
  -C /data/wp-content uploads plugins
```

> Ajustar `projeto_wp_data` se o prefixo do volume for outro (`docker volume ls`).

### 1.3 Cópia do `.env` (fora do Git)

```bash
cp ~/projeto/.env ~/backups-portal/env-$(date +%Y%m%d).env.example-local
chmod 600 ~/backups-portal/env-*.env.example-local
```

**Nunca** commitar este ficheiro no Git.

### 1.4 Empacotar tudo (opcional)

```bash
cd ~/backups-portal
tar czf portal-backup-$(date +%Y%m%d).tar.gz portal-*-db.sql portal-*-wp-content.tar.gz env-*.env.example-local
```

Transferir o `.tar.gz` para armazenamento seguro (disco externo, nuvem institucional, OneDrive da equipe).

---

## 2. Backup via plugin (alternativa)

Com **UpdraftPlus** instalado ([`PLUGINS-WORDPRESS.txt`](../PLUGINS-WORDPRESS.txt)):

1. wp-admin → **Configurações → UpdraftPlus Backups**
2. **Fazer backup agora** (base de dados + plugins + uploads + temas)
3. Descarregar os ficheiros gerados
4. Agendar backup semanal (recomendado em homologação/produção)

Útil para equipe não técnica; o backup manual acima continua válido para migração entre VMs.

---

## 3. Restaurar em máquina nova

### 3.1 Preparar ambiente

1. Clonar repositório e criar `.env` (mesmas senhas **ou** novas — se novas, ajustar após import)
2. `docker compose up -d`
3. Concluir instalação WordPress **ou** importar sobre instalação vazia

### 3.2 Restaurar banco

```bash
cd ~/projeto

# Instalação vazia já criada — importar por cima:
docker compose exec -T db mariadb -u wordpress -p"${WORDPRESS_DB_PASSWORD}" wordpress \
  < ~/backups-portal/portal-YYYYMMDD-HHMM-db.sql
```

### 3.3 Restaurar uploads e plugins

```bash
docker run --rm \
  -v projeto_wp_data:/data \
  -v ~/backups-portal:/backup \
  alpine sh -c "cd /data/wp-content && tar xzf /backup/portal-YYYYMMDD-HHMM-wp-content.tar.gz"
```

### 3.4 Ajustar URLs (se mudou domínio ou IP)

Ver [`DEPLOY.md`](DEPLOY.md) — secção *Ajustar URLs no WordPress* (`wp search-replace`).

### 3.5 Verificar

- [ ] wp-admin login
- [ ] Páginas e menus
- [ ] PDFs do calendário / documentos institucionais
- [ ] Professores e projetos fábrica (CPTs)
- [ ] Tema **Portal SI CEFET/RJ** ativo

---

## 4. Desenvolvimento local a partir de backup de produção

Para um dev ver o **mesmo conteúdo** da VM no PC:

1. Restaurar SQL + `wp-content` conforme secção 3 (volumes locais do Docker Desktop)
2. Ajustar URLs para `http://localhost:8080`:

```powershell
docker compose --profile wpcli run --rm wpcli wp search-replace `
  'https://SEU_DOMINIO' 'http://localhost:8080' --all-tables

docker compose --profile wpcli run --rm wpcli wp option update home 'http://localhost:8080'
docker compose --profile wpcli run --rm wpcli wp option update siteurl 'http://localhost:8080'
```

3. Não commitar dump SQL nem uploads no Git

---

## 5. Frequência recomendada

| Ambiente | Frequência | Retenção |
|----------|------------|----------|
| **Homologação (MVP)** | Semanal + antes de demo/apresentação | Últimas 4 cópias |
| **Produção (go-live)** | Diário automático | 30 dias + mensal |
| **Antes de migração** | Backup completo imediato | Até validação |

---

## 6. Checklist de continuidade (handoff)

Entregar à pessoa que assume o projeto:

- [ ] Acesso SSH à VM (ou documento de solicitação à TI)
- [ ] Cópia recente do `.env` (cofre de senhas)
- [ ] Backup SQL + uploads datado
- [ ] URL pública atual e domínio DNS
- [ ] Utilizador admin WordPress (ou procedimento de reset via WP-CLI)
- [ ] Este ficheiro + [`DEPLOY.md`](DEPLOY.md)

### Reset de senha admin (emergência)

```bash
docker compose --profile wpcli run --rm wpcli wp user update admin \
  --user_pass='NovaSenhaForte'
```

Substituir `admin` pelo login real.

---

## Referências

- [`DEPLOY.md`](DEPLOY.md) — deploy e atualização
- [`conteudo-wordpress-vs-codigo.md`](conteudo-wordpress-vs-codigo.md) — o que está na BD
- [`WORDPRESS-REDAÇÃO-E-PAPÉIS.txt`](../WORDPRESS-REDAÇÃO-E-PAPÉIS.txt) — papéis Editor/Admin

---

*Fábrica de Software — SI CEFET/RJ.*
