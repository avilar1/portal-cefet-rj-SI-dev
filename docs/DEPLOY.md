# Deploy — Portal SI CEFET/RJ

Guia de **continuidade** para subir, atualizar e publicar o portal fora da máquina de desenvolvimento.

> **Escopo deste documento:** ambiente de **homologação / MVP** (VM na nuvem ou servidor interno).  
> O **go-live no domínio oficial** do CEFET/RJ (`*.cefet-rj.br`) é fase posterior, com validação da coordenação e da TI institucional.

---

## Arquitetura resumida

```
Internet
   │
   ▼
[Caddy na VM]  ── HTTPS (443) / HTTP (80) ── Let's Encrypt
   │
   └── reverse_proxy → localhost:8080
                          │
                          ▼
                   [Docker: WordPress :80]
                          │
                          ▼
                   [Docker: MariaDB 11]
```

| Camada | O quê |
|--------|--------|
| **Git** | Tema `portal-si-cefet` + `docker-compose.yml` |
| **Volume `wp_data`** | WordPress core, plugins, uploads |
| **Volume `db_data`** | Banco MariaDB |
| **Bind mount** | `./wp-content/themes/portal-si-cefet` (atualiza com `git pull`) |
| **Caddy (host)** | TLS e proxy; **não** está no repositório |

---

## Pré-requisitos na VM

- Ubuntu 20.04+ (ou similar)
- Docker Engine + Docker Compose plugin
- Git
- Portas liberadas no **firewall da nuvem** e no **iptables** da VM: **22**, **80**, **443** (e **8080** só se acesso direto for necessário)
- Domínio ou subdomínio apontando para o IP da VM (ex.: DuckDNS para homologação)

---

## 1. Primeira instalação na VM

### 1.1 Clonar o repositório

```bash
cd ~
git clone <URL_DO_REPOSITORIO> projeto
cd projeto
```

### 1.2 Configurar ambiente

```bash
cp env.example .env
nano .env   # senhas fortes em WORDPRESS_DB_PASSWORD e MARIADB_ROOT_PASSWORD
```

### 1.3 Subir containers

```bash
docker compose up -d
```

WordPress fica em `http://<IP-DA-VM>:8080` até configurar o proxy HTTPS.

### 1.4 Instalação WordPress (primeira vez)

1. Aceder `http://<IP-DA-VM>:8080`
2. Idioma **Português do Brasil**
3. Criar utilizador **Administrador**
4. No wp-admin:
   - **Links permanentes:** Nome do post
   - **Fuso horário:** São Paulo
   - **Aparência → Temas:** ativar **Portal SI CEFET/RJ**
5. Visitar o wp-admin dispara os *seeds* (páginas, menus, conteúdo de exemplo)

### 1.5 Plugins recomendados

Ver [`PLUGINS-WORDPRESS.txt`](../PLUGINS-WORDPRESS.txt). Na VM (Linux):

```bash
docker compose --profile wpcli run --rm wpcli wp plugin install \
  wordpress-seo contact-form-7 w3-total-cache wordfence updraftplus \
  --activate
```

Ou instalar manualmente no wp-admin.

---

## 2. HTTPS com Caddy (homologação)

O Caddy corre **no host** (fora do Docker), faz proxy para `localhost:8080` e obtém certificado Let's Encrypt.

### 2.1 Instalar Caddy (Ubuntu)

```bash
sudo apt install -y debian-keyring debian-archive-keyring apt-transport-https curl
curl -1sLf 'https://dl.cloudsmith.io/public/caddy/stable/gpg.key' | sudo gpg --dearmor -o /usr/share/keyrings/caddy-stable-archive-keyring.gpg
curl -1sLf 'https://dl.cloudsmith.io/public/caddy/stable/debian.deb.txt' | sudo tee /etc/apt/sources.list.d/caddy-stable.list
sudo apt update && sudo apt install caddy
```

### 2.2 Exemplo de Caddyfile

Substituir `SEU_DOMINIO` pelo domínio real (ex.: `portal-si-cefet.duckdns.org`):

```caddyfile
SEU_DOMINIO {
    reverse_proxy localhost:8080
}
```

Ficheiro usual: `/etc/caddy/Caddyfile`

```bash
sudo systemctl reload caddy
sudo systemctl enable caddy
```

### 2.3 iptables na VM (Oracle Cloud / similar)

Se a VM tiver regra `REJECT all` no final da chain, garantir **antes** dela:

```bash
sudo iptables -I INPUT 6 -m state --state NEW -p tcp --dport 80 -j ACCEPT
sudo iptables -I INPUT 6 -m state --state NEW -p tcp --dport 443 -j ACCEPT
sudo iptables -I INPUT 6 -m state --state NEW -p tcp --dport 8080 -j ACCEPT
```

Persistir (ex.: `iptables-persistent`) para sobreviver a reboot.

### 2.4 Ajustar URLs no WordPress

Depois de ativar HTTPS, atualizar URLs antigas (IP, localhost, http):

```bash
cd ~/projeto

docker compose --profile wpcli run --rm wpcli wp search-replace \
  'http://IP-ANTIGO:8080' 'https://SEU_DOMINIO' --all-tables

docker compose --profile wpcli run --rm wpcli wp search-replace \
  'http://localhost:8080' 'https://SEU_DOMINIO' --all-tables

docker compose --profile wpcli run --rm wpcli wp option update home 'https://SEU_DOMINIO'
docker compose --profile wpcli run --rm wpcli wp option update siteurl 'https://SEU_DOMINIO'
```

> **Importante:** usar sempre `docker compose --profile wpcli run --rm wpcli wp …`  
> **Não** usar `docker compose exec wordpress wp` (WP-CLI não vem no container Apache).

---

## 3. Atualização do código (deploy rotineiro)

Quando há alterações no tema ou no `docker-compose.yml`:

```bash
cd ~/projeto
git pull

# Se mudou docker-compose.yml ou .env:
docker compose up -d

# Se mudou só o tema (bind mount): basta git pull; recarregar o site.
# Opcional: limpar cache de plugin (W3 Total Cache) no wp-admin.
```

### Checklist pós-deploy

- [ ] Site abre em HTTPS sem erro de certificado
- [ ] Home, menu principal e uma página institucional OK
- [ ] wp-admin acessível
- [ ] Formulário de contato (se SMTP configurado)
- [ ] Sem links quebrados para URL antiga (IP/localhost)

---

## 4. O que vai no Git vs. o que fica na VM

| Item | Onde |
|------|------|
| Tema `portal-si-cefet` | Git → bind mount |
| `docker-compose.yml`, `docker/` | Git |
| `.env` (senhas) | **Só na VM** — nunca commitar |
| WordPress core, plugins, uploads | Volume Docker `wp_data` |
| Banco de dados | Volume Docker `db_data` |
| Caddyfile, certificados TLS | Host da VM |
| Backup | Ver [`BACKUP.md`](BACKUP.md) |

Quem clona o repo **não** recebe o site completo — só o código. Para reproduzir o ambiente com conteúdo, restaurar backup (BD + uploads).

---

## 5. Go-live institucional (fase futura)

Quando a coordenação validar substituir a [página legada do curso](https://www.cefet-rj.br/index.php/bacharelado-em-sistemas-de-informacao-maria-da-graca):

1. Definir domínio oficial com TI CEFET/RJ
2. Migrar DNS / certificado institucional
3. Reexecutar `wp search-replace` para o domínio final
4. Configurar SMTP institucional (formulários, notificações)
5. Revisar plugins de cache, SEO e backup em produção
6. Política de backup automático e monitoramento

---

## 6. Problemas frequentes

| Sintoma | Verificação |
|---------|-------------|
| Site não abre de fora | Security List / NSG na nuvem + iptables + Caddy ativo |
| HTTPS não funciona | DNS apontando para IP correto; portas 80/443 abertas |
| Tema desatualizado após `git pull` | Bind mount OK; `docker compose up -d` |
| Imagens/links com URL antiga | `wp search-replace` (secção 2.4) |
| `Permission denied` no wp-cli | Usar serviço `wpcli` do compose, não `exec wordpress` |
| Rede corporativa bloqueia DuckDNS | Testar de casa/4G; domínio oficial resolve na go-live |

---

## Referências no repositório

- [`README.md`](../README.md) — desenvolvimento local
- [`BACKUP.md`](BACKUP.md) — backup e restauração
- [`IMPLEMENTACAO-CHECKLIST.md`](IMPLEMENTACAO-CHECKLIST.md) — status por RF
- [`conteudo-wordpress-vs-codigo.md`](conteudo-wordpress-vs-codigo.md) — o que editar no wp-admin

---

*Fábrica de Software — SI CEFET/RJ. Revisar este guia quando mudar provedor, domínio ou stack.*
