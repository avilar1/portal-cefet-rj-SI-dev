# Prompt de Geração de Layout — Sobre o Curso MVP (RF02)

## Metadados

| Campo | Valor |
|-------|-------|
| **Fase** | Sobre o Curso MVP — Sprint 2 / Módulo Institucional |
| **Requisito** | **RF02** — histórico, objetivos, perfil do egresso, coordenação e direção |
| **Sistema** | Portal Institucional — Curso de SI (CEFET/RJ, Campus Maria da Graça) |
| **URL** | `/sobre-o-curso/` (slug WordPress: `sobre-o-curso`) |
| **Pai IA** | Filha do hub `/institucional/` — breadcrumb: `Início › Institucional › Sobre o Curso` |
| **Papel da tela** | Página **narrativa e institucional** — contar a história do curso; **não** é hub nem segunda home |
| **Framework Visual** | Design System gov.br (híbrido: tokens + `br-card`, `br-divider`; sem `core.min.css` completo) |
| **Plataforma** | WordPress — template PHP + **Gutenberg** como área “lego” da coordenação |
| **Heurísticas Foco** | H1 — Visibilidade do Status · H6 — Reconhecimento · H8 — Minimalismo · H12 — Credibilidade |

> **Decisão de produto:** os **números institucionais** ficam **fora do hub** (hub = navegação). Nesta página entram na **Zona B**, no topo, como credibilidade rápida antes da narrativa.

> **Princípio editorial:** a coordenação e os professores **alteram textos, ordem e blocos** no editor. O tema oferece **estrutura, âncoras, padrões visuais e faixa de números** — não um texto fechado no código.

> **Restrição técnica:** viável em WordPress puro (Gutenberg + template parts). Proibido: React standalone, SPA, build externo.

---

## 1. Tokens de Design — Reutilizar do Portal

Usar `ds-tokens.css`, `layout_homepage_mvp_v2.md` e `layout_hub_institucional_mvp.md` — mesma paleta e tipografia (Rawline / Raleway, `#1351B4`, `#0C326F`, `#FFCD07`).

---

## 2. Arquitetura da Página — Visão Geral

Rolagem vertical contínua — **uma história**, do dado objetivo à coordenação.

```
┌─────────────────────────────────────────┐
│  ZONA A — Cabeçalho da página           │  ← H1 + intro curta (WP)
├─────────────────────────────────────────┤
│  ZONA B — Números do curso (credibilidade)│  ← 3–4 cards; dados editáveis (arquivo PHP)
├─────────────────────────────────────────┤
│  ZONA C — Carta de apresentação        │  ← Texto + foto lateral (Gutenberg / imagem destacada)
├─────────────────────────────────────────┤
│  ZONA D — Navegação por âncoras (opc.)  │  ← Links para seções RF02 (desktop sticky ou faixa horizontal)
├─────────────────────────────────────────┤
│  ZONA E — Corpo narrativo (lego)       │  ← Blocos Gutenberg — seções RF02 + extras
│     · Histórico                         │
│     · Objetivos do curso                │
│     · Perfil do egresso                 │
│     · Coordenação e direção             │
│     · (futuro: PPC, vídeo, galeria…)    │
├─────────────────────────────────────────┤
│  ZONA F — Separador / encerramento (opc.)│  ← br-divider ou CTA para Ingresso / hub
└─────────────────────────────────────────┘
```

> **Regra de corte MVP:** A + B + C + E (mínimo RF02). D e F opcionais. Se faltar tempo, D omitir e usar só H2 no conteúdo.

---

## 3. Modelo de Flexibilidade — “Lego” para a Coordenação

### 3.1 Duas camadas

| Camada | Quem edita | O quê |
|--------|------------|--------|
| **Estrutura (tema)** | Desenvolvimento | Breadcrumb, faixa de números (Zona B), estilos, menu de âncoras (Zona D), padrões de bloco, IDs de seção, CSS |
| **Conteúdo (WordPress)** | Editor / Administrador | Textos, imagens, ordem dos blocos, seções extras, remover o que não quiser |

### 3.2 Como a coordenação “brinca de lego”

1. **Editor de blocos (Gutenberg)** como área principal da **Zona E** (`the_content()`).
2. **Padrões de bloco** registrados pelo tema (sugestão de início):
   - “Carta de apresentação” (2 colunas: texto + imagem)
   - “Seção — Histórico” (H2 + parágrafos)
   - “Seção — Objetivos”
   - “Seção — Perfil do egresso”
   - “Seção — Coordenação” (texto + cards de pessoas opcionais)
3. Podem **inserir, remover, reordenar** qualquer bloco nativo (colunas, imagem, lista, citação, vídeo embed).
4. Podem **duplicar** uma seção ou criar “Destaques” novos sem deploy de código.
5. **Números (Zona B):** editados em `data/sobre-o-curso.php` (ou painel futuro) — mudam ~1×/ano; não misturar com postagens.

### 3.2.1 Seed vs WordPress — fonte de verdade (importante)

Na **primeira instalação**, o tema pode copiar o HTML de `inc/sobre.php` (`portal_si_sobre_default_post_content()`) para o campo *Conteúdo* da página no WordPress (**uma vez**, opção `portal_si_sobre_content_seeded_v1`).

**Depois do seed:**

- Endereço, histórico, coordenação, emails, etc. → editar em **wp-admin → Páginas → Sobre o Curso**.
- Alterar só `inc/sobre.php` **não** atualiza o site (o visitante vê o que está na base de dados).

Documentação completa (todas as zonas e outros módulos): [`../conteudo-wordpress-vs-codigo.md`](../conteudo-wordpress-vs-codigo.md).

### 3.3 IDs de âncora (obrigatórios nos padrões de bloco)

Para o menu da Zona D e links internos funcionarem:

| ID | Seção RF02 |
|----|------------|
| `#apresentacao` | Carta de apresentação (Zona C) |
| `#historico` | Histórico |
| `#objetivos` | Objetivos do curso |
| `#perfil-egresso` | Perfil do egresso |
| `#coordenacao` | Coordenação e direção |

> Os padrões Gutenberg devem gerar `<h2 id="historico">` (etc.) ou wrapper com `id` correspondente.

### 3.4 O que o tema **não** deve fazer

- Travar ordem fixa de seções **somente em PHP** sem saída no editor.
- Colocar textos longos hardcoded (exceto placeholders de seed e fallbacks).
- Impedir remoção de uma seção (se remover bloco, some da página — OK).

---

## 4. Especificação de Cada Zona

---

### ZONA A — Cabeçalho da Página *(Obrigatória)*

**Requisito:** RF02, RN02  
**Implementação:** `portal-page-header` + título da página no WP

| Elemento | Regra |
|----------|--------|
| Breadcrumb | `Início › Institucional › Sobre o Curso` |
| H1 | “Sobre o Curso” — editável no WordPress |
| Intro | 1 parágrafo opcional — **excerpt** da página; máx. ~300 caracteres |
| Visual | Compacto; sem hero 100vh |

**Texto sugerido (excerpt, editável):**
> O curso de Sistemas de Informação do CEFET/RJ forma profissionais para desenvolver, gerir e inovar em soluções de software. Conheça nossa trajetória, objetivos e equipe.

---

### ZONA B — Números do Curso *(Obrigatória no MVP)*

**Requisito:** RF01 (subset de credibilidade), RF02  
**Implementação:** template part `template-parts/sobre/stats.php` + `data/sobre-o-curso.php`

**Função:** impacto rápido com dados objetivos (o que o hub **não** exibiu de propósito).

| Regra | Valor |
|-------|--------|
| Quantidade | 3 ou 4 itens |
| Layout desktop | Grade 4 colunas (ou 2×2 em telas médias) |
| Formato | Valor grande (Raleway) + rótulo (Rawline) |
| Estilo | Cards leves em fundo `#F8F8F8` ou faixa azul-clara — alinhado à faixa de números do layout hub (referência visual), sem competir com Zona C |

**Dados sugeridos (editáveis no arquivo PHP):**

| Valor | Rótulo |
|-------|--------|
| 4 anos | Duração do curso |
| Gratuidade total | Instituição federal |
| Bacharelado | Título conferido |
| Campus Maria da Graça | Rio de Janeiro — RJ |

> **Diferença intencional em relação à Home:** a Home exibe "Alta Empregabilidade" neste slot. Aqui o quarto item é "Bacharelado" — dado mais relevante para quem já está lendo sobre o curso e quer entender o título que vai receber. **Não copiar os dados da Home sem revisar esta decisão.** Fonte: `data/sobre-o-curso.php` — arquivo independente de qualquer `data/home.php`.

> Alternativa futura: bloco Gutenberg customizado “Número institucional” — MVP usa arquivo PHP por simplicidade.

---

### ZONA C — Carta de Apresentação *(Obrigatória)*

**Requisito:** RF02 (tom institucional / coordenação)  
**Implementação:** padrão Gutenberg **ou** template part com `the_content()` restrito ao topo

**Função:** “carta” da coordenação — humanizar antes do histórico formal.

| Elemento | Regra |
|----------|--------|
| Layout desktop | 2 colunas: **texto ~60%** \| **imagem ~40%** |
| Layout mobile | Texto primeiro; imagem abaixo ou acima (definir: **imagem abaixo do primeiro parágrafo**) |
| Imagem | Foto campus, turma ou coordenação; proporção ~4:3; `alt` obrigatório |
| Texto | 2–4 parágrafos; tom acolhedor e institucional; assinatura opcional (“Coordenação do curso de SI”) |
| ID âncora | `#apresentacao` no H2 ou wrapper |

**Não usar:** hero full-width; vídeo autoplay.

---

### ZONA D — Navegação por Âncoras *(Opcional — recomendada)*

**Requisito:** RF02 (navegação interna) · RNF03 (conformidade de acessibilidade)  
**Heurística:** H6 — Reconhecimento em vez de Memorização · H7 — Eficiência de Uso  
**Implementação:** template part `template-parts/sobre/anchor-nav.php`

| Regra | Valor |
|-------|--------|
| Desktop | Faixa horizontal abaixo da carta **ou** menu lateral sticky (escolher um no implementação; padrão: **faixa horizontal** com scroll em mobile) |
| Itens | Histórico · Objetivos · Perfil do egresso · Coordenação |
| Comportamento | Scroll suave para `#id`; item ativo opcional (fase 2) |
| Acessibilidade | Lista de links `<nav aria-label="Nesta página">` |

> Se a coordenação remover um bloco com H2, o link pode permanecer (leva a vazio) ou o tema oculta links sem destino — preferir **ocultar** âncoras sem conteúdo (fase 2).

---

### ZONA E — Corpo Narrativo — Lego Gutenberg *(Obrigatória)*

**Requisito:** RF02 (conteúdo integral)  
**Implementação:** `the_content()` na largura do portal + estilos `.entry-content` / `.portal-sobre-section`

#### Seções mínimas (conteúdo obrigatório RF02)

Cada uma: **H2** com `id` de âncora + corpo em blocos livres.

| Ordem sugerida | H2 | ID | Conteúdo esperado |
|----------------|-----|-----|-------------------|
| 1 | Histórico | `#historico` | Linha do tempo ou parágrafos; marcos do curso no CEFET |
| 2 | Objetivos do curso | `#objetivos` | Competências, o que o aluno aprende; pode linkar PPC (PDF) |
| 3 | Perfil do egresso | `#perfil-egresso` | O que o egresso sabe fazer; mercado; link opcional para Carreira e Egressos |
| 4 | Coordenação e direção | `#coordenacao` | Nomes, cargos, contatos; foto opcional por pessoa (bloco colunas ou card simples) |

#### Separadores

- `br-divider` com rótulo central **opcional** entre blocos grandes (ex.: “Formação”).
- Não abusar — máx. 2 separadores na página.

#### Extensões permitidas (sem novo RF)

A coordenação pode adicionar via Gutenberg:

- Galeria de fotos
- Vídeo YouTube (embed)
- Bloco de citação / depoimento de egresso
- Botão de download PPC
- Nova seção H2 (ex.: “Projeto pedagógico”) — âncora aparece só se registrar padrão ou manual

---

### ZONA F — Encerramento *(Opcional)*

| Elemento | Regra |
|----------|--------|
| CTA | Link “Como ingressar” → `/ingresso/` e/ou “Voltar ao Institucional” → `/institucional/` |
| Estilo | Botão primário + link texto; fundo branco |

---

## 5. Comportamento Global

### 5.1 Hierarquia de headings

```
H1 — Sobre o Curso (Zona A)
  H2 — Carta / Apresentação (Zona C) — id apresentacao
  H2 — Histórico — id historico
  H2 — Objetivos — id objetivos
  H2 — Perfil do egresso — id perfil-egresso
  H2 — Coordenação — id coordenacao
  H3 — Subtítulos dentro de cada bloco (livre)
```

### 5.2 Responsividade

| Breakpoint | Comportamento |
|------------|---------------|
| ≥ 64rem | Números 4 col.; carta 2 col.; conteúdo max-width 72rem |
| 30–64rem | Números 2 col.; carta empilhada |
| < 30rem | 1 coluna; âncoras com scroll horizontal se faixa |

### 5.3 Acessibilidade

- Um `<main id="main-content">`
- Imagens com `alt`; contraste AA
- Links de âncora com foco visível (`#FFCD07`)
- Alto contraste: reutilizar regras de `a11y.css` para cards de números

---

## 6. Implementação Técnica (para o dev / IA)

| Item | Convenção |
|------|-----------|
| Template | `page-sobre-o-curso.php` (slug) |
| Lógica | `inc/sobre.php` |
| Dados estáticos (números) | `data/sobre-o-curso.php` |
| Template parts | `template-parts/sobre/{stats,anchor-nav,carta}.php` — carta opcional se tudo for Gutenberg |
| CSS | `assets/css/sobre.css` — enqueue só nesta página |
| Body class | `portal-is-sobre-curso` |
| Conteúdo editorial | **`the_content()`** — prioridade máxima para Zona E |
| Block patterns | Registrar em `inc/sobre.php` ou `inc/block-patterns.php` |
| Seed | Conteúdo inicial com padrões pré-inseridos (opcional, uma vez) |

**Padrão desacoplado** (igual notícias / institucional):

```
inc/sobre.php
data/sobre-o-curso.php
template-parts/sobre/*
page-sobre-o-curso.php
assets/css/sobre.css
```

---

## 7. Decisões de Escopo — Preencher Antes de Codar

| Decisão | Opções | Sugestão MVP |
|---------|--------|----------------|
| Zona B (números) | PHP (`data/`) · Bloco Gutenberg custom | **PHP** |
| Zona C (carta) | Só Gutenberg · Template part fixo + imagem destacada | **Gutenberg** + padrão de bloco |
| Zona D (âncoras) | Sim · Não | **Sim** (faixa horizontal) |
| Zona E | 100% Gutenberg · PHP por seção | **100% Gutenberg** |
| Seed de conteúdo | Página vazia · Blocos pré-montados | **Blocos pré-montados** (facilita coordenação) |
| Coordenação (cards de pessoas) | Bloco colunas manual · CPT “membro” (futuro) | **Blocos colunas** no MVP |

---

## 8. Critérios de Aceite

- [ ] `/sobre-o-curso/` com breadcrumb `Início › Institucional › Sobre o Curso`
- [ ] Faixa de 3–4 números visível no topo (Zona B)
- [ ] Carta de apresentação com texto + imagem lateral (Zona C)
- [ ] Conteúdo RF02 presente: histórico, objetivos, perfil do egresso, coordenação
- [ ] Editor consegue alterar textos e reordenar blocos sem alterar código
- [ ] Coordenação consegue adicionar/remover seção H2 via Gutenberg
- [ ] Layout responsivo e Lighthouse Accessibility ≥ 95
- [ ] Sem hero 100vh; página mais densa em texto que o hub

---

## 9. Mapeamento Zonas × Requisitos × Heurísticas

| Zona | RF / RN | Heurísticas | Prioridade |
|------|---------|-------------|------------|
| A | RF02, RN02 | H1, H6 | Obrigatória |
| B | RF01 subset, RF02 | H12, H2 | Obrigatória |
| C | RF02 | H12, H8 | Obrigatória |
| D | RF02, RNF03 | H6, H7 | Recomendada |
| E | RF02 | H6, H8, H12 | Obrigatória |
| F | RF05 (link) | H3 | Opcional |

---

## 10. Relação com Outras Telas

| Tela | Relação |
|------|---------|
| **Hub Institucional** | Entrada por card “Sobre o Curso”; hub sem números |
| **Carreira e Egressos** | Aprofunda empregabilidade; link a partir de “Perfil do egresso” |
| **Documentos** | PPC pode ser link em Objetivos ⚠️ slug ainda indefinido — ver Decisão 3 no `layout_hub_institucional_mvp.md` |
| **Ingresso** | CTA opcional no rodapé da página (Zona F) |

---

*Documento para validação com a coordenação antes da implementação. Após aprovação, implementar conforme Seção 6 e critérios da Seção 8.*
