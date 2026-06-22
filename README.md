# Portal SI CEFET/RJ — ambiente e tema (WordPress)

Repositório da **Fábrica de Software** do curso de **Sistemas de Informação** (CEFET/RJ — Campus Maria da Graça).

Portal institucional em **WordPress** com tema próprio `portal-si-cefet`, identidade alinhada ao **Design System do Governo Federal (gov.br)** e escopo definido na **Análise de Requisitos** do projeto.

**Versão atual do tema:** `0.5.3`

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
- [`layout_sobre_o_curso_mvp.md`](docs/referencias/layout_sobre_o_curso_mvp.md) — Sobre o Curso (RF02)

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
| **Home (RF01)** | 8 zonas: hero, acesso rápido (RF22 externos + Grade + **Calendário Acadêmico**), notícias + **Agenda** (eventos) |
| **Calendário Acadêmico** | `/calendario-academico/` — datas editáveis no wp-admin ([guia](docs/edicao-calendario-academico.md)); ≠ Agenda |
| **Comunicação** | Notícias (`inc/noticia.php`, templates, listagem 9/página); CPT **eventos** + agenda + single evento |
| **Institucional** | Hub `/institucional/` (zonas A/B/C), dados em `data/institucional.php`, páginas filhas com breadcrumb `Início › Institucional › …` |
| **Sobre o Curso (RF02)** | `/sobre-o-curso/` — hero, números, carta, âncoras, seções RF02; **textos no WP**, números em `data/sobre-o-curso.php` — ver [`docs/conteudo-wordpress-vs-codigo.md`](docs/conteudo-wordpress-vs-codigo.md) |
| **Ingresso (RF05)** | `/ingresso/` — SISU 2026, passo a passo, links oficiais CEFET/MEC, documentação resumida; dados em `data/ingresso.php` |
| **Documentos (RF06)** | `/documentos-institucionais/` — publicações editáveis no wp-admin + links fixos |
| **Infraestrutura (RF04)** | `/infraestrutura/` — campus Maria da Graça, laboratórios, biblioteca, convivência; `data/infraestrutura.php` |
| **Corpo docente (RF08)** | `/corpo-docente/` — CPT `portal_professor` |
| **Fábrica de Software (RF13–14)** | `/fabrica-de-software/` — CPT `portal_fs_projeto` |
| **Contato (RF27, RF29)** | `/contato/` — coordenação, mapa, rodapé |
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
| `/sobre-o-curso/`, `/calendario-academico/`, `/ingresso/`, … | Filhas do institucional (breadcrumb com hub) |
| `/agenda-e-eventos/` | Eventos do curso (comunicação) — não é o calendário oficial |
| `/noticias/` | Comunicação — notícias |
| `/agenda-e-eventos/`, `/evento/.../` | Comunicação — eventos |
| `/corpo-docente/`, `/pesquisa-e-extensao/` | Docentes / pesquisa |
| `/fabrica-de-software/` | Fábrica de Software |
| `/contato/` | Contato |

---

## Próximos passos

Checklist completo por RF: [`docs/IMPLEMENTACAO-CHECKLIST.md`](docs/IMPLEMENTACAO-CHECKLIST.md).

Resumo:

1. **Conteúdo editorial** — vice-coordenação, professores, projetos fábrica, validação de e-mails.
2. **Grade (RF03) + Fluxo (RF26) + TCC (RF25)** — colegas.
3. **Formulários** — RF16 parceiros, RF28 ouvidoria (adiado).
4. **Pesquisa e extensão** — RF09–RF11 (médio).
5. **Go-live** — substituir [página legada do curso no CEFET/RJ](https://www.cefet-rj.br/index.php/bacharelado-em-sistemas-de-informacao-maria-da-graca). Ver [`docs/DEPLOY.md`](docs/DEPLOY.md) e [`docs/BACKUP.md`](docs/BACKUP.md).

---

## Documentação no repositório

| Caminho | Conteúdo |
|---------|----------|
| [`docs/referencias/`](docs/referencias/) | Requisitos, heurísticas, layouts MVP |
| [`docs/README.md`](docs/README.md) | Índice da pasta docs |
| [`docs/IMPLEMENTACAO-CHECKLIST.md`](docs/IMPLEMENTACAO-CHECKLIST.md) | **Status por RF** — o que está feito, parcial e pendente |
| [`docs/DEPLOY.md`](docs/DEPLOY.md) | **Deploy** — homologação, HTTPS, atualização na VM |
| [`docs/BACKUP.md`](docs/BACKUP.md) | **Backup** — BD, uploads, restauração e handoff |
| [`docs/conteudo-wordpress-vs-codigo.md`](docs/conteudo-wordpress-vs-codigo.md) | **WP vs código** — seed, Sobre o Curso, quem edita o quê |
| [`REQUISITOS-PRIORIDADE.txt`](REQUISITOS-PRIORIDADE.txt) | RFs Alta resumidos |
| `PLUGINS-WORDPRESS.txt` | Stack e checklist |
| `WORDPRESS-REDAÇÃO-E-PAPÉIS.txt` | Papéis WP e editorial |

---

## Para relatório / apresentação

> Entregamos ambiente **Docker + WordPress**, tema **portal-si-cefet** com **Home**, **comunicação** (notícias e agenda), **hub institucional**, **Sobre o Curso**, **corpo docente**, **Fábrica de Software**, **contato** e navegação por **módulos do documento de requisitos**, com base no **DS gov.br** (híbrido). Status detalhado: [`docs/IMPLEMENTACAO-CHECKLIST.md`](docs/IMPLEMENTACAO-CHECKLIST.md). Próximo foco: conteúdo editorial, Grade/TCC (colegas) e formulários RF16/RF28.

---

## Problemas frequentes

| Sintoma | Verificação |
|---------|-------------|
| Docker não sobe | Docker Desktop em execução |
| Plugins ausentes | `.\scripts\install-plugins.ps1` |
| Tema desatualizado | Bind mount em `docker-compose.yml`; `docker compose up -d` |
| Menu antigo no mobile | Recarregar o site (sync única `portal_si_nav_modules_sync_v1`) ou visitar wp-admin |
| Breadcrumb sem “Institucional” | Páginas filhas devem ter pai `institucional` (sync em `inc/institucional.php`) |
| Alterei `inc/sobre.php` e o site não mudou | Conteúdo já está na BD; editar **Páginas → Sobre o Curso** no WP — ver [`docs/conteudo-wordpress-vs-codigo.md`](docs/conteudo-wordpress-vs-codigo.md) |

---

## Licença e autoria

Projeto académico **Fábrica de Software — SI CEFET/RJ**. Respeitar licenças de WordPress, plugins e **Design System gov.br**.

Se o README divergir do código, **o repositório prevalece** — corrija via pull request.
