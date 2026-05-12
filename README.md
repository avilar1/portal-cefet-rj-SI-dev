# Portal SI CEFET/RJ — ambiente e tema (WordPress)

Repositório da **Fábrica de Software** do curso de **Sistemas de Informação** (CEFET/RJ — Maria da Graça).  
Objetivo: base técnica do **portal institucional** descrito na *Análise de Requisitos* (WordPress + tema próprio; identidade **gov.br** virá com o layout fechado).

---

## Para quem é este README

| Público | Uso principal |
|--------|----------------|
| **Equipe (colegas)** | Clonar, subir o ambiente, trabalhar no tema e nos módulos — siga a secção **Passo a passo**. |
| **Professores / coordenação** | Visão do que já existe e do que vem a seguir — secções **O que já foi feito** e **Perspectivas** servem de base para relatório. |

**Premissa de escopo:** priorizar requisitos funcionais de **prioridade ALTA** (ver `REQUISITOS-PRIORIDADE.txt`). O layout visual (Design System gov.br fechado) pode esperar; o desenvolvimento seguirá **módulo a módulo** em cima desta base.

---

## O que já foi feito (resumo técnico)

- **Docker Compose:** WordPress oficial + MariaDB 11, volumes persistentes, tema montado a partir deste repositório.
- **Tema `portal-si-cefet`:** estrutura inicial (cabeçalho com faixa gov.br *stub*, rodapé, menus, breadcrumbs, busca global, templates de post/arquivo/pesquisa).
- **Seed da arquitetura de informação:** criação automática (uma vez) das páginas do mapa do site, dois menus (principal e rodapé), página inicial estática “Início” e blog em “Notícias”.
- **Seed editorial:** categorias de exemplo + post em rascunho para testes (notícias).
- **Comentários** desativados em posts e páginas (alinhado ao RI06).
- **Scripts / documentação auxiliar:** instalação de plugins via WP-CLI, texto sobre plugins, redação e papéis, prioridade de RFs.

O que **não** está neste repositório: arquivos do WordPress core nem `wp-content` completo — só o **tema** versionado; o resto vive no volume Docker (`wp_data`) na máquina de cada desenvolvedor.

---

## Estrutura do repositório

```
projeto/
├── README.md                 ← este arquivo
├── docker-compose.yml        ← WordPress + MariaDB + serviço WP-CLI (perfil wpcli)
├── env.example               ← modelo de variáveis (copiar para .env)
├── .gitignore
├── REQUISITOS-PRIORIDADE.txt # RFs Alta vs Média/Baixa
├── PLUGINS-WORDPRESS.txt     # Stack de plugins e checklist pós-instalação
├── WORDPRESS-REDAÇÃO-E-PAPÉIS.txt  # Editores, notícias, comentários RI06
├── scripts/
│   └── install-plugins.ps1   # Instala plugins oficiais do projeto (WP-CLI)
└── wp-content/themes/portal-si-cefet/   ← tema custom (é o que mais editamos)
```

---

## Passo a passo — o que a equipe deve fazer

### Obrigatório (para qualquer máquina nova)

1. **Instalar [Docker Desktop](https://www.docker.com/products/docker-desktop/)** (Windows ou macOS) e garantir que está **correndo** antes dos comandos.

2. **Clonar** este repositório e entrar na pasta do projeto.

3. **Criar o arquivo `.env`** a partir do modelo (não commitar senhas reais):
   ```powershell
   Copy-Item env.example .env
   ```
   Editar `.env` e preencher `WORDPRESS_DB_PASSWORD` e `MARIADB_ROOT_PASSWORD` com valores fortes (apenas para desenvolvimento local).

4. **Subir os containers:**
   ```powershell
   docker compose up -d
   ```

5. **Instalar o WordPress** no navegador: abrir `http://localhost:8080` (ou a porta definida em `WP_PORT` no `.env`), idioma **Português do Brasil**, criar utilizador **Administrador**.

6. **Ajustes mínimos no painel** (`/wp-admin`):
   - **Ajustes → Links permanentes:** “Nome do post”.
   - **Ajustes → Geral:** fuso **São Paulo** (ou equivalente).
   - **Aparência → Temas:** ativar **Portal SI CEFET/RJ**.

7. **Uma visita ao wp-admin como Administrador** dispara os *seeds* automáticos (páginas do mapa + categorias/post de exemplo, se ainda não tiverem corrido).

8. **Criar pelo menos um utilizador com função Editor** (Utilizadores → Adicionar novo) para testar o fluxo de notícias — ver `WORDPRESS-REDAÇÃO-E-PAPÉIS.txt`.

### Opcional (recomendado, mas não bloqueia o “Hello World”)

| Ação | Para quê |
|------|-----------|
| Executar `.\scripts\install-plugins.ps1` | Instala Yoast SEO, W3 Total Cache, Wordfence, Contact Form 7, UpdraftPlus (ver `PLUGINS-WORDPRESS.txt`). |
| Completar assistentes dos plugins | SEO, segurança, backup e cache alinhados aos RNFs do documento. |
| `docker compose --profile wpcli run --rm wpcli wp …` | Comandos WP-CLI (listar plugins, criar utilizadores, etc.). |

**Nota:** `docker compose up -d` **não** instala plugins sozinho; o script ou o comando WP-CLI é que instalam.

---

## Perspectivas (o que vem depois)

Ordem típica acordada com a equipe — **só depois do layout gov.br fechado** para a parte visual fina; até lá pode avançar-se em **lógica e conteúdo**:

1. **Módulo a módulo** conforme a *Análise de Requisitos*, priorizando **RF Alta** (institucional, pesquisa/extensão, Fábrica, comunicação, serviços, contato).
2. **Custom Post Types** e campos (ex.: professores + importação de planilha RF12, TCCs RF25) com listagens no tema.
3. **Formulários** (parceiros RF16, ouvidoria RF28) com Contact Form 7 + textos LGPD validados pela coordenação.
4. **Acessibilidade e DS gov.br** no tema (barra completa, tipografia Rawline/Raleway, VLibras, contraste) quando o layout estiver definido.
5. **Hospedagem de produção:** exportar base de dados + ficheiros (ou pipeline de deploy) e HTTPS, conforme RNF11.

---

## Documentação de apoio (arquivo no repo)

| Arquivo | Conteúdo |
|----------|-----------|
| `REQUISITOS-PRIORIDADE.txt` | Lista de RFs **Alta** e nota sobre RF34/sitemap. |
| `PLUGINS-WORDPRESS.txt` | Plugins, comandos manuais, checklist pós-instalação. |
| `WORDPRESS-REDAÇÃO-E-PAPÉIS.txt` | Administrador vs Editor, notícias, comentários (RI06), seed editorial. |

A **fonte de verdade** do produto continua sendo o documento de **Análise de Requisitos** aprovado com a coordenação.

---

## Para o relatório aos professores

> Entregamos a **base WordPress em Docker**, o **tema institucional inicial** (navegação, busca, notícias, comentários desligados por política do projeto) e a **estrutura de páginas** do portal. O **layout final gov.br** e os **módulos funcionais** (conteúdo e integrações) serão desenvolvidos **módulo a módulo** em sprints seguintes, priorizando requisitos de **prioridade Alta**. A equipe já consegue **publicar notícias**, testar **papéis Editor/Administrador** e repetir o ambiente em qualquer máquina com Docker.

---

## Problemas frequentes

| Sintoma | O que verificar |
|---------|------------------|
| Erro de *pipe* / Docker Engine | Docker Desktop aberto e a “correr”. |
| Plugins não aparecem após `up` | Rodar `.\scripts\install-plugins.ps1` (ou comando em `PLUGINS-WORDPRESS.txt`). |
| Tema não atualiza | Confirmar *bind mount* em `docker-compose.yml` para `wp-content/themes/portal-si-cefet` e reiniciar `docker compose up -d`. |

---

## Licença e autoria

Projeto académico **Fábrica de Software — SI CEFET/RJ**. Respeitar licenças de terceiros (WordPress, plugins, fontes gov.br quando integradas).

Se algo neste README estiver desatualizado ao código, **o repositório prevalece**: proponham correção em pull request.
