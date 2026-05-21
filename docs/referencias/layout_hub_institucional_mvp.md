# Prompt de Geração de Layout — Hub Institucional MVP

## Metadados

| Campo | Valor |
|-------|-------|
| **Fase** | Hub Institucional MVP |
| **Sistema** | Portal Institucional — Curso de Sistemas de Informação (CEFET/RJ, Campus Maria da Graça) |
| **URL** | `/institucional/` (slug WordPress: `institucional`) |
| **Papel da tela** | Hub de navegação — orientar o visitante e encaminhar para páginas filhas; **não é segunda home** |
| **Framework Visual** | Design System gov.br (híbrido: tokens + `br-card`, `br-divider`; sem `core.min.css` completo) |
| **Plataforma** | WordPress — PHP template parts + CSS do módulo (sem React standalone, sem build externo) |
| **Heurísticas Foco** | H1 — Visibilidade do Status · H6 — Reconhecimento em vez de Memorização · H8 — Estética e Design Minimalista |

> **Restrição de escopo:** esta tela não replica a Home. Quem busca impacto emocional vai à Home (RF01). Quem busca "entender o curso e para onde ir" vem ao Institucional. Empilhar hero, números e notícias aqui é erro de arquitetura.

> **Restrição técnica:** toda implementação deve ser viável via WordPress puro (template PHP + Gutenberg). Proibido: React standalone, SPA, Next.js ou qualquer solução com build process externo ao WordPress.

---

## 1. Tokens de Design — Reutilizar do Portal

> Não redefinir. Usar os tokens já declarados em `ds-tokens.css` e no documento `layout_homepage_mvp_v2`.

| Token | Uso nesta tela |
|-------|----------------|
| `color-primary` (`#1351B4`) | Links, ícones, borda de foco nos cards, botão CTA |
| `color-secondary` (`#0C326F`) | H1, H2 de seção, títulos de cards |
| `color-highlight` (`#FFCD07`) | Estado de foco visível (WCAG) |
| `font-heading` — Raleway | H1, H2, títulos dos cards |
| `font-body` — Rawline | Intro, descrições dos cards, texto corrido |
| `--portal-max-width` (72rem) | Largura máxima do conteúdo |
| `--portal-space` | Padding horizontal das seções |

**Contraste:** WCAG 2.1 AA obrigatório em todos os pares texto/fundo.

---

## 2. Arquitetura da Página — Visão Geral

A página é composta por **5 zonas verticais**, das quais apenas **A e B são obrigatórias no MVP**. As demais entram somente se explicitadas na decisão de escopo (Seção 6).

```
┌─────────────────────────────────────────┐
│  ZONA A — Cabeçalho da Área             │  ← Obrigatória — breadcrumb + H1 + intro
├─────────────────────────────────────────┤
│  ZONA B — Grade de Cards (navegação)    │  ← Obrigatória — coração do hub
├─────────────────────────────────────────┤
│  ZONA C — Destaque + CTA               │  ← Opcional — 1 bloco, máx. 1 CTA
├─────────────────────────────────────────┤
│  ZONA D — Credibilidade / Números       │  ← Opcional — omitir se duplicar Home
├─────────────────────────────────────────┤
│  ZONA E — Teaser de Notícias            │  ← Opcional — omitir no MVP por padrão
└─────────────────────────────────────────┘
```

> **Regra de corte:** se o layout ficar pesado, remover na ordem E → D → C. A Zona B nunca é removida.

---

## 3. Especificação de Cada Zona

---

### ZONA A — Cabeçalho da Área *(Obrigatória)*

**Requisito:** RN02  
**Implementação WordPress:** excerpt/campo da página no editor Gutenberg; H1 editável pelo admin

**Função:** orientar em uma frase onde o visitante está. Sem hero, sem imagem full-width.

| Elemento | Regra |
|----------|-------|
| Breadcrumb | `Início › Institucional` — gerado pelo tema (já existente) |
| H1 | "Institucional" — editável no WordPress |
| Intro | 1 parágrafo, máx. 2–3 linhas (~280 caracteres); tom informativo, sem marketing longo |
| Altura | Compacta — significativamente menor que o hero da Home |
| Imagem | Proibido usar imagem de fundo full-width ou banner |

**Texto de intro sugerido (editável no WP):**
> Conheça o Curso de Sistemas de Informação do CEFET/RJ — sua estrutura acadêmica, corpo docente, formas de ingresso e vida estudantil. Navegue pelas seções abaixo.

> **Heurística aplicada:** H1 — Visibilidade do Status (o visitante sabe exatamente onde está) · H6 — Reconhecimento (contexto imediato, sem necessidade de memorizar)

---

### ZONA B — Grade de Navegação por Cards *(Obrigatória)*

**Requisitos:** RF02, RF03, RF04, RF05, RF06, RF07 + Carreira e Egressos (Seção 8 dos Requisitos)  
**Implementação WordPress:** template part `template-parts/institucional/zona-b.php` + `br-card` com modificador hover; CSS em `assets/css/institucional.css`

**Função:** encaminhar o visitante para as páginas filhas — é o elemento central desta tela.

#### Layout Responsivo

| Breakpoint | Colunas |
|------------|---------|
| Desktop (≥ 64rem) | 3 colunas |
| Tablet (30rem–64rem) | 2 colunas |
| Mobile (< 30rem) | 1 coluna |

#### Anatomia de cada card

- Ícone SVG à esquerda ou centralizado (com `aria-label` descritivo)
- Título do destino (Raleway, negrito, `color-primary`)
- Descrição de uma linha, máx. 80 caracteres (Rawline, tom cinza secundário)
- Card inteiro clicável (`<a class="br-card">` — não `div` com click JS)
- Hover: borda esquerda `color-primary` ou sombra sutil
- Foco visível em `color-highlight` (`#FFCD07`) — WCAG 2.1 AA

#### Cards do MVP (7 itens — grade 3×2 + 1)

| Ícone | Título | Descrição (máx. 80 char) | Slug destino | RF |
|-------|--------|--------------------------|--------------|-----|
| 📖 | Sobre o Curso | Histórico, objetivos e perfil do egresso | `sobre-o-curso` | RF02 |
| 🎓 | Ingresso | SISU, ENEM, processo seletivo e matrícula | `ingresso` | RF05 |
| 📋 | Grade Curricular | Disciplinas por semestre e fluxo de progressão | `grade-curricular` | RF03 |
| 🏛 | Infraestrutura | Laboratórios, biblioteca e recursos do campus | `infraestrutura` | RF04 |
| 👩‍🏫 | Corpo Docente | Professores, áreas de atuação e pesquisa | `corpo-docente` | RF08 |
| 💼 | Carreira e Egressos | Empregabilidade, depoimentos e trajetórias | `carreira-e-egressos` | RF02 (seção) |
| 🎒 | Vida Estudantil | Bolsas, auxílios, benefícios e ferramentas | `vida-estudantil` | RF07 |

> **Regra:** nenhum card pode apontar para página não publicada. Link morto invalida o critério de aceite.

**Título H2 da seção (opcional):** "Explore o Institucional" — incluir apenas se o layout pedir separação visual clara da Zona A.

> **Heurística aplicada:** H6 — Reconhecimento (destinos visíveis, sem necessidade de memorizar caminhos) · H7 — Eficiência de Uso (acesso direto com 1 clique) · H8 — Design minimalista (ícone + título + 1 linha)

---

### ZONA C — Destaque Editorial + CTA *(Opcional)*

**Requisito:** RF05 (conversão de candidatos)  
**Implementação WordPress:** bloco "Colunas" Gutenberg (2 colunas desktop) ou template part `zona-c.php`

**Função:** uma mensagem de valor focada no perfil candidato + um único botão de conversão.

| Elemento | Regra |
|----------|-------|
| Layout | 2 colunas no desktop (texto à esquerda, imagem/ícone à direita) |
| H2 | Curto — ex.: "Quer estudar aqui?" ou "Pronto para ingressar?" |
| Parágrafo | Máx. 4 linhas — foco em candidatos; tom acolhedor e direto |
| CTA | **1 botão primário apenas** — "Como ingressar" → `/ingresso/` |
| Fundo | Branco ou cinza muito claro (`#F8F8F8`); sem faixa azul tipo header |
| Proibido | Segundo CTA competindo · imagem grande · vídeo autoplay |

> **Heurística aplicada:** H3 — Controle e Liberdade (1 ação clara, sem sobrecarga de opções) · H8 — Minimalismo

---

### ZONA D — Credibilidade / Números *(Opcional — avaliar duplicação com Home)*

**Requisito:** RF01 (subset)  
**Implementação WordPress:** template part `zona-d.php` + array PHP em `data/institucional.php` (dados estáticos, alteração ~1×/ano; não usar postagens WP)

**Função:** reforço rápido de dados institucionais para visitantes que chegam direto nesta URL sem passar pela Home.

> **Decisão de MVP:** incluir esta zona **somente se** a análise de tráfego indicar acesso direto frequente a `/institucional/` sem passagem pela Home. Por padrão, **omitir no MVP** para evitar duplicação.

| Elemento | Regra |
|----------|-------|
| Quantidade | 3 ou 4 itens |
| Formato | Valor grande (Raleway) + rótulo pequeno (Rawline) |
| Estilo | Discreto — não compete visualmente com a grade de cards |

| Valor | Rótulo |
|-------|--------|
| 4 anos | Duração do curso |
| Gratuidade total | Sem mensalidades |
| Alta empregabilidade | Mercado aquecido |
| Campus Maria da Graça | Rio de Janeiro — RJ |

> **Heurística aplicada:** H12 — Credibilidade e Confiança · H2 — Linguagem simples

---

### ZONA E — Teaser de Notícias *(Opcional — omitir no MVP por padrão)*

**Requisito:** RF17  
**Implementação WordPress:** reutilizar `template-parts/noticia/card.php` + Query Loop Gutenberg

> **Motivo para omitir no MVP:** a Home já cobre RF17 com feed de 3 notícias. Repetir aqui gera sensação de "portal duplicado" e dilui o foco do hub.

Se incluída futuramente, respeitar estas regras:

| Elemento | Regra |
|----------|-------|
| Quantidade | 2 notícias apenas |
| Separador | `br-divider` com rótulo central ("Últimas notícias") |
| Link ao final | "Ver todas as notícias" → `/noticias/` |
| Proibido | Carrossel automático · mais de 2 posts nesta zona |

> **Heurística aplicada:** H1 — Visibilidade do Status (informação datada e atual)

---

## 4. Comportamento Global

### 4.1 Relação com Header e Menu Principal

- O item "Institucional" no menu principal aponta para `/institucional/` (este hub)
- "Sobre o Curso" permanece página própria, acessível apenas pelo card da Zona B
- A Zona B é a única navegação interna — não duplicar links no corpo da Zona A

### 4.2 Hierarquia de Headings

```
H1 — Institucional (Zona A)
  H2 — Explore o Institucional (Zona B — opcional)
  H2 — [título da Zona C, se ativa]
  H2 — [título da Zona D, se ativa]
```

> Nunca pular níveis. Nunca usar H1 fora da Zona A nesta página.

### 4.3 Responsividade

| Breakpoint | Comportamento |
|------------|---------------|
| Desktop ≥ 64rem | Grade 3 colunas, Zona C em 2 colunas |
| Tablet 30rem–64rem | Grade 2 colunas, Zona C empilhada |
| Mobile < 30rem | 1 coluna em todas as zonas |

- Área de toque mínima: 44×44px em cards e CTAs (RNF02 / WCAG 2.5.5)

### 4.4 Acessibilidade

- Uma única `<main id="main-content">` por página
- Títulos em ordem sem pular níveis (H1 → H2)
- Cards como links `<a class="br-card">` — nunca `div` com evento JS
- Regras de alto contraste em `a11y.css` reutilizando `.portal-service-card`
- Sem carrossel automático em nenhuma zona

---

## 5. Implementação Técnica

| Item | Convenção |
|------|-----------|
| Template | `page-institucional.php` (slug) |
| Lógica auxiliar | `inc/institucional.php` |
| Template parts | `template-parts/institucional/zona-{a,b,c,d,e}.php` |
| Estilos | `assets/css/institucional.css` — enqueue **somente nesta página** |
| Body class | `portal-is-institucional-hub` |
| Helpers DS | `portal_si_br_card_class()`, `portal_si_section_divider()` |
| Dados estáticos (Zona D) | `data/institucional.php` — array PHP; não usar CPT nem postagens |
| DS | **Não usar** `core.min.css` completo do gov.br |

---

## 6. Decisões de Escopo — Preencher Antes de Codar

> Estas decisões devem ser registradas e validadas com o cliente antes do início do desenvolvimento da tela.

| Decisão | Opções | Status |
|---------|--------|--------|
| Zonas ativas no MVP | A + B apenas · A + B + C · A + B + C + D | ⬜ A definir |
| Fonte do texto da intro (Zona A) | WP (excerpt) · JSON/PHP · Híbrido (H1 no WP, intro no arquivo) | ⬜ A definir |
| Slug do card Documentos | Página dedicada (`/documentos/`) · Seção âncora em `/sobre-o-curso/#documentos` | ⬜ A definir |
| Incluir Zona D (números)? | Sim — justificar ausência na Home · Não — evitar duplicação | ⬜ A definir |
| H2 na grade de cards (Zona B)? | Sim: "Explore o Institucional" · Não: cards começam direto após a intro | ⬜ A definir |

---

## 7. Critérios de Aceite

- `/institucional/` carrega com header/footer padrão e breadcrumb correto (`Início › Institucional`)
- Visitante identifica em menos de 5 segundos que pode navegar para Ingresso, Sobre, Grade etc.
- Nenhum hero 100vh — página visivelmente mais baixa que a Home
- Todos os cards da Zona B apontam para páginas publicadas (sem link morto)
- Layout aprovado em mobile (320px+), tablet e desktop
- Lighthouse Accessibility ≥ 95; contraste e foco validados
- Zonas C, D e E presentes somente se explicitadas na Seção 6

---

## 8. Mapeamento Zonas × Requisitos × Heurísticas

| Zona | Componente | Requisitos | Heurísticas | Prioridade MVP |
|------|------------|------------|-------------|----------------|
| A | Cabeçalho da Área | RN02 | H1, H6 | Obrigatória |
| B | Grade de Cards | RF02–RF07, RF08 (card docente) | H6, H7, H8 | Obrigatória |
| C | Destaque + CTA | RF05 | H3, H8 | Opcional |
| D | Credibilidade / Números | RF01 (subset) | H2, H12 | Opcional — evitar duplicar Home |
| E | Teaser de Notícias | RF17 | H1 | Opcional — omitir no MVP |
