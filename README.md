# Portal SI CEFET/RJ — ambiente e tema (WordPress)

Repositório da **Fábrica de Software** do curso de **Sistemas de Informação** (CEFET/RJ — Campus Maria da Graça).

Portal institucional em **WordPress** com tema próprio `portal-si-cefet`, identidade alinhada ao **Design System do Governo Federal (gov.br)** e escopo definido na **Análise de Requisitos** do projeto.

**Versão atual do tema:** `0.3.8`

---

## Premissas do projeto (leia antes de codar)

O desenvolvimento segue **três referências obrigatórias**, versionadas em [`docs/referencias/`](docs/referencias/):

| Premissa | Documento | Papel |
|----------|-----------|--------|
| **Regras de negócio e escopo** | [`Analise_Requisitos_Portal_SI_CefetRJ_revisado.md`](docs/referencias/Analise_Requisitos_Portal_SI_CefetRJ_revisado.md) | Fonte de verdade: RN, RF, RNF, RI, arquitetura de informação (Seção 8), módulos e cronograma |
| **Usabilidade em governo eletrônico** | [`heuristicas_governo_eletronico.md`](docs/referencias/heuristicas_governo_eletronico.md) | Heurísticas **H1–H12** (Nielsen adaptadas + acessibilidade e credibilidade no setor público) |
| **Identidade visual e componentes** | **DS gov.br** (`@govbr-ds/core` 3.7.0) | Tokens, tipografia (Rawline/Raleway), `br-card`, `br-divider` — uso **híbrido** no tema (sem `core.min.css` completo) |

**Layouts fechados** (prompts de implementação), também em `docs/referencias/`:

- [`layout_homepage_mvp_v2.md`](docs/referencias/layout_homepage_mvp_v2.md) — Home (8 zonas)
- [`layout_hub_institucional_mvp.md`](docs/referencias/layout_hub_institucional_mvp.md) — Hub Institucional

> A pasta `contexto/` na raiz continua **fora do Git** (`.gitignore`) para materiais locais pesados. O que a equipe deve **compartilhar e revisar** está em **`docs/`**.

Prioridade de entrega: requisitos funcionais de **prioridade Alta** — ver também [`REQUISITOS-PRIORIDADE.txt`](REQUISITOS-PRIORIDADE.txt).

---

## Para quem é este README

| Público | Uso |
|---------|-----|
| **Equipe (dev)** | Clonar, Docker, tema, padrão de módulos — secção [Passo a passo](#passo-a-passo) |
| **Coordenação / professores** | O que já está pronto e o que falta — secções [Entregue](#o-que-já-está-implementado) e [Próximos passos](#próximos-passos) |

---

## O que já está implementado

### Infraestrutura

- **Docker Compose:** WordPress + MariaDB 11 + perfil WP-CLI; tema montado por bind mount.
- **Seed de IA:** páginas do mapa do site, menus, front “Início”, blog em “Notícias” (execução única no admin).
- **Seed editorial:** categorias + post de exemplo; comentários desligados (RI06).

### Tema `portal-si-cefet` — módulos em produção no código

| Área | Conteúdo |
|------|----------|
| **Shell global** | Header (faixa gov.br, menu legal, nav principal, busca), breadcrumbs, rodapé (mapa + barra legal), alto contraste e `prefers-reduced-motion` |
| **Design System** | Tokens (`ds-tokens.css`), vendor gov.br 3.7.0 (card, divider, core-tokens), `ds-compat.css` |
| **Home (RF01)** | 8 zonas: hero, acesso rápido (`br-card`), notícias + agenda |
| **Comunicação** | Notícias (`inc/noticia.php`, templates, listagem 9/página); CPT **eventos** + agenda + single evento |
| **Institucional** | Hub `/institucional/` (zonas A/B/C), dados em `data/institucional.php`, páginas filhas com breadcrumb `Início › Institucional › …` |
| **Navegação** | Menu por **módulos** (requisitos §5): Institucional, Docentes, Pesquisa e Extensão, Fábrica, Comunicação, Contato — ver `inc/nav.php` |

### Padrão técnico para novos módulos

```
inc/<modulo>.php              → dados, CPT, consultas
template-parts/<modulo>/      → componentes reutilizáveis
page-*.php / front-page.php   → composição da tela
assets/css/<modulo>.css       → estilos do módulo (enqueue condicional)
```

O que **não** está versionado aqui: WordPress core e `wp-content` completo (volume Docker `wp_data`).

---

## Estrutura do repositório

```
projeto/
├── README.md                      ← este arquivo
├── docs/
│   ├── README.md                  ← índice da documentação
│   └── referencias/               ← requisitos, heurísticas, layouts (versionados)
├── docker-compose.yml
├── env.example
├── REQUISITOS-PRIORIDADE.txt
├── PLUGINS-WORDPRESS.txt
├── WORDPRESS-REDAÇÃO-E-PAPÉIS.txt
├── scripts/install-plugins.ps1
└── wp-content/themes/portal-si-cefet/
    ├── inc/                       ← lógica (nav, home, institucional, evento, notícia, a11y, …)
    ├── template-parts/            ← header, footer, home, institucional, notícia, evento
    ├── data/institucional.php     ← textos/cards do hub (editável pela equipe)
    ├── assets/css/                ← home, pages, notícias, institucional, a11y, ds-*
    └── assets/vendor/govbr-ds/3.7.0/
```

---

## Passo a passo

### Obrigatório (máquina nova)

1. Instalar **[Docker Desktop](https://www.docker.com/products/docker-desktop/)** e deixá-lo em execução.
2. Clonar o repositório e entrar na pasta `projeto/`.
3. Criar `.env` a partir do modelo:
   ```powershell
   Copy-Item env.example .env
   ```
   Preencher `WORDPRESS_DB_PASSWORD` e `MARIADB_ROOT_PASSWORD`.
4. Subir containers:
   ```powershell
   docker compose up -d
   ```
5. Instalar WordPress em `http://localhost:8080` (porta em `WP_PORT` no `.env`), idioma **PT-BR**, utilizador **Administrador**.
6. No painel (`/wp-admin`):
   - **Links permanentes:** “Nome do post”
   - **Fuso:** São Paulo
   - **Aparência → Temas:** ativar **Portal SI CEFET/RJ**
7. Uma visita ao **wp-admin** como Administrador dispara os seeds (páginas, menus, conteúdo de exemplo).
8. Criar utilizador **Editor** para testar notícias — [`WORDPRESS-REDAÇÃO-E-PAPÉIS.txt`](WORDPRESS-REDAÇÃO-E-PAPÉIS.txt).

### Recomendado

| Ação | Referência |
|------|------------|
| `.\scripts\install-plugins.ps1` | [`PLUGINS-WORDPRESS.txt`](PLUGINS-WORDPRESS.txt) |
| Ler `docs/referencias/` antes de implementar telas | Requisitos + heurísticas + layout MD |

---

## Mapa rápido de URLs (desenvolvimento)

| URL / slug | Módulo |
|------------|--------|
| `/` (front) | Home |
| `/institucional/` | Hub institucional |
| `/sobre-o-curso/`, `/ingresso/`, … | Filhas do institucional (breadcrumb com hub) |
| `/noticias/` | Comunicação — notícias |
| `/agenda-e-eventos/`, `/evento/.../` | Comunicação — eventos |
| `/corpo-docente/`, `/pesquisa-e-extensao/` | Docentes / pesquisa |
| `/fabrica-de-software/` | Fábrica de Software |
| `/contato/` | Contato |

---

## Próximos passos

Ordem alinhada ao cronograma da Análise de Requisitos (Sprint 2+):

1. **Páginas institucionais** — Sobre o Curso (RF02), Ingresso (RF05), Grade (RF03/RF26), Infraestrutura (RF04), Documentos (RF06).
2. **Corpo docente** — CPT + importação planilha (RF08, RF12).
3. **Pesquisa e extensão**, **Fábrica de Software** (RF09–RF16).
4. **Serviços digitais** — links úteis, TCCs (RF22–RF25).
5. **Contato** — formulários, mapa (RF27–RF29).
6. **Breadcrumb gov.br** (`br-breadcrumb`) e refinamentos de acessibilidade.

---

## Documentação no repositório

| Caminho | Conteúdo |
|---------|----------|
| [`docs/referencias/`](docs/referencias/) | Requisitos, heurísticas, layouts MVP |
| [`docs/README.md`](docs/README.md) | Índice da pasta docs |
| `REQUISITOS-PRIORIDADE.txt` | RFs Alta resumidos |
| `PLUGINS-WORDPRESS.txt` | Stack e checklist |
| `WORDPRESS-REDAÇÃO-E-PAPÉIS.txt` | Papéis WP e editorial |

---

## Para relatório / apresentação

> Entregamos ambiente **Docker + WordPress**, tema **portal-si-cefet** com **Home**, **módulo de comunicação** (notícias e agenda/eventos), **hub institucional** e navegação organizada por **módulos do documento de requisitos**, com base no **DS gov.br** (híbrido) e heurísticas de **governo eletrônico**. A documentação de produto está versionada em **`docs/referencias/`**. Próximas sprints cobrem páginas filhas do institucional, docentes, Fábrica e contato, priorizando RFs de **Alta** prioridade.

---

## Problemas frequentes

| Sintoma | Verificação |
|---------|-------------|
| Docker não sobe | Docker Desktop em execução |
| Plugins ausentes | `.\scripts\install-plugins.ps1` |
| Tema desatualizado | Bind mount em `docker-compose.yml`; `docker compose up -d` |
| Menu antigo no mobile | Recarregar o site (sync única `portal_si_nav_modules_sync_v1`) ou visitar wp-admin |
| Breadcrumb sem “Institucional” | Páginas filhas devem ter pai `institucional` (sync em `inc/institucional.php`) |

---

## Licença e autoria

Projeto académico **Fábrica de Software — SI CEFET/RJ**. Respeitar licenças de WordPress, plugins e **Design System gov.br**.

Se o README divergir do código, **o repositório prevalece** — corrija via pull request.
