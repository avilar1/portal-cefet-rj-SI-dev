# Prompt de Geração de Layout — Home Page MVP

## Metadados

| Campo | Valor |
|-------|-------|
| **Fase** | Home Page MVP |
| **Sistema** | Portal Institucional — Curso de Sistemas de Informação (CEFET/RJ) |
| **Framework Visual** | Design System gov.br (Padrão Digital de Governo) |
| **Plataforma de Implementação** | WordPress — Blocos Gutenberg nativos + plugins compatíveis (sem React customizado, sem SPA) |
| **Heurísticas Foco** | H4 — Consistência e Padronização · H8 — Estética e Design Minimalista |

> **Restrição técnica importante:** Toda a implementação deve ser viável via WordPress puro (editor de blocos Gutenberg). Soluções que exijam React standalone, Next.js ou build customizado estão fora do escopo. Preferir o caminho correto ao caminho possível.

---

## 1. Tokens de Design — Paleta e Tipografia

> **Referência normativa:** WCAG 2.1 AA — todos os pares de cor devem atingir razão de contraste mínima de 4.5:1 para texto normal e 3:1 para texto grande.

### 1.1 Paleta de Cores

| Token | Hex | Uso |
|-------|-----|-----|
| `color-primary` | `#1351B4` | Azul Interativo — botões, links, elementos de ação |
| `color-secondary` | `#0C326F` | Azul Profundo — headers, fundo de seções institucionais |
| `color-highlight` | `#FFCD07` | Amarelo — estados de foco, atenção e seleção ativa |

### 1.2 Tipografia

| Token | Família | Aplicação |
|-------|---------|-----------|
| `font-body` | Rawline | Parágrafos, labels, metadados |
| `font-heading` | Raleway | Títulos H1–H4, chamadas de seção |

---

## 2. Arquitetura de Página — Visão Geral (baseada no wireframe)

A home é composta por **7 zonas verticais empilhadas**, na seguinte ordem de cima para baixo:

```
┌─────────────────────────────────────────┐
│  ZONA 1 — Banner Superior (topo)        │  ← Barra fina
├─────────────────────────────────────────┤
│  ZONA 2 — Navegação de Itens Legais     │  ← Barra fina secundária
├─────────────────────────────────────────┤
│  ZONA 3 — Navegação Principal           │  ← Header/menu
├─────────────────────────────────────────┤
│  ZONA 4 — Hero / Chamada Principal      │  ← Seção full-height
│          (como ingressar + grade)       │
├─────────────────────────────────────────┤
│  ZONA 5 — Serviços / Links Rápidos      │  ← Seção média
├─────────────────────────────────────────┤
│  ZONA 6 — Notícias (75%) │ Agenda (25%) │  ← Seção dividida em 2 colunas
├─────────────────────────────────────────┤
│  ZONA 7 — Footer (mapa do site)         │  ← Footer largo
├─────────────────────────────────────────┤
│  ZONA 8 — Footer Legal (rodapé mínimo)  │  ← Barra fina
└─────────────────────────────────────────┘
```

---

## 3. Especificação de Cada Zona

---

### ZONA 1 — Banner Superior

**Requisito:** RN04  
**Implementação WordPress:** Bloco HTML customizado no Full Site Editor (FSE) → área `header-top`

- Barra horizontal de altura mínima (~40px)
- Fundo: `color-secondary` (`#0C326F`)
- Conteúdo: Logomarca do CEFET/RJ à esquerda + links de órgãos superiores (MEC) à direita, conforme padrão gov.br
- Texto em cor clara (branco) para garantir contraste WCAG 2.1 AA

---

### ZONA 2 — Navegação de Itens Legais

**Implementação WordPress:** Bloco de Navegação nativo do Gutenberg, inserido via FSE acima do menu principal

- Barra fina (~40px), fundo levemente diferenciado do banner superior (tom neutro ou cinza claro)
- Links: Acessibilidade · VLibras · Mapa do Site · Contraste · Ir para o conteúdo (`#main-content`)
- Texto pequeno, discreto — não deve competir visualmente com a navegação principal

> **Heurística aplicada:** H11 — Acessibilidade (salto de conteúdo, VLibras, contraste)

---

### ZONA 3 — Navegação Principal

**Requisito:** RF32  
**Implementação WordPress:** Bloco de Navegação nativo do Gutenberg + tema compatível com menu sticky

- Altura maior que as barras superiores (~80px)
- Fundo: `color-primary` (`#1351B4`) ou branco com borda inferior na cor primária
- Itens de menu: Institucional · Curso · Grade Curricular · Docentes · Fábrica de Software · Contato
- Busca Global (RF33): ícone de lupa à direita, expansível ao clique
- Responsivo: colapsa em menu hambúrguer em telas menores que 768px

> **Heurística aplicada:** H4 — Consistência · H6 — Reconhecimento (itens sempre visíveis)

---

### ZONA 4 — Hero / Chamada Principal

**Requisito:** RF01 — Destaque Principal  
**Implementação WordPress:** Bloco "Cover" nativo do Gutenberg (suporta imagem de fundo + overlay + conteúdo centralizado)

- **Altura:** Full viewport height (100vh) ou mínimo de 500px
- **Imagem de fundo:** Foto em alta resolução do Campus Maria da Graça
- **Overlay:** Gradiente de `color-secondary` (`#0C326F`) com opacidade ~60% para garantir legibilidade
- **Conteúdo centralizado (vertical e horizontal):**
  - H1: "Sistemas de Informação — CEFET/RJ" (Raleway, branco)
  - Subtítulo: breve descrição do curso (Rawline, branco, máximo 2 linhas)
  - **2 botões CTA lado a lado:**

| Botão | Destino | Estilo |
|-------|---------|--------|
| Como Ingressar | RF05 — Processo Seletivo | Primário (fundo `#1351B4`, texto branco) |
| Grade Curricular | RF03 — Estrutura Curricular | Secundário (borda branca, fundo transparente) |

> **Heurística aplicada:** H2 — Linguagem clara · H8 — Foco no essencial · H3 — Controle (CTAs diretos)

---

### ZONA 5 — Serviços / Links Rápidos

**Requisito:** RF01 · Credibilização Institucional  
**Implementação WordPress:** Bloco "Colunas" nativo do Gutenberg (4 colunas iguais)

- Fundo: tom neutro claro (off-white ou `#F8F8F8`) para separação visual da zona Hero
- **4 cards minimalistas lado a lado**, cada um com:
  - Ícone SVG centralizado (acessível via `aria-label`)
  - Dado principal em destaque (fonte maior, Raleway)
  - Rótulo descritivo (Rawline, tom secundário)

| Ícone | Dado | Rótulo |
|-------|------|--------|
| 🗓️ | 4 anos | Duração do Curso |
| 🎓 | Gratuidade Total | Sem mensalidades |
| 💼 | Alta Empregabilidade | Mercado aquecido |
| 📍 | Campus Maria da Graça | Rio de Janeiro — RJ |

> **Heurística aplicada:** H2 — Linguagem simples · H8 — Design minimalista · H12 — Credibilidade

---

### ZONA 6 — Notícias + Agenda (layout 2 colunas)

**Requisitos:** RF17 · RF20  
**Implementação WordPress:** Bloco "Colunas" nativo (proporção 75% / 25%) + Query Loop para notícias + Lista manual ou plugin de eventos para agenda

#### 6A — Coluna Principal: Notícias (75% da largura)

- Título de seção: "Notícias" (H2, Raleway, `color-secondary`)
- **3 cards de notícias em grade**, cada card contendo:
  - Imagem de capa (thumbnail do post)
  - Tag de categoria (ex.: "Pesquisa", "Extensão", "Institucional")
  - Data de publicação
  - Título do post (link para a notícia completa)
- Implementação: Bloco "Query Loop" nativo do Gutenberg (sem plugin adicional)

#### 6B — Coluna Lateral: Agenda (25% da largura)

- Título de seção: "Agenda" (H2, Raleway, `color-secondary`)
- Lista compacta de próximos eventos do Calendário Acadêmico
- Cada item: data · nome do evento · link de detalhes
- Fundo levemente diferenciado (cinza muito claro) para separação visual
- Implementação: Bloco de Lista nativo ou plugin leve (ex.: The Events Calendar — visualização lista)

> **Heurística aplicada:** H1 — Visibilidade do status (informação datada e atual) · H5 — Prevenção de erros (datas e links verificáveis)

---

### ZONA 7 — Footer — Mapa do Site

**Requisito:** RN10  
**Implementação WordPress:** Área de widgets do rodapé via FSE — 3 colunas de links

- Fundo: `color-secondary` (`#0C326F`), texto branco
- **3 colunas de links agrupados por tema:**

| Coluna 1 | Coluna 2 | Coluna 3 |
|----------|----------|----------|
| Institucional | Docentes | Fábrica de Software |
| Sobre o Curso | Corpo Docente | Projetos |
| História | Horários de Atendimento | Oportunidades |
| Contato | Pesquisa | Parceiros |

- Logo do CEFET/RJ e redes sociais institucionais na parte inferior do bloco

> **Heurística aplicada:** H6 — Reconhecimento (links previsíveis e organizados) · H10 — Ajuda e Documentação

---

### ZONA 8 — Footer Legal

**Requisito:** RNF07  
**Implementação WordPress:** Bloco de texto no rodapé do FSE

- Barra fina (~40px), fundo escuro ou preto
- Conteúdo em linha:
  - © [ano] CEFET/RJ — Todos os direitos reservados
  - Link: Política de Privacidade (conformidade LGPD)
  - Link: Aviso de Cookies / Gerenciar preferências

> **Heurística aplicada:** H12 — Credibilidade e Confiança

---

## 4. Mapeamento Completo — Zonas × Requisitos × Heurísticas

| Zona | Componente | Requisitos | Heurísticas |
|------|------------|------------|-------------|
| 1 | Banner Superior | RN04 | H4, H12 |
| 2 | Nav. Itens Legais | RF32 | H11 |
| 3 | Navegação Principal | RF32, RF33 | H4, H6 |
| 4 | Hero / Chamada Principal | RF01 | H2, H3, H8 |
| 5 | Serviços / Links Rápidos | RF01 | H2, H8, H12 |
| 6A | Notícias | RF17 | H1, H5 |
| 6B | Agenda | RF20 | H1, H5 |
| 7 | Footer — Mapa do Site | RN10 | H6, H10 |
| 8 | Footer Legal | RNF07 | H12 |

---

## 5. Restrições de Implementação WordPress

> Esta seção é crítica para qualquer desenvolvedor ou LLM que gere código a partir deste documento.

- **Editor:** Gutenberg (blocos nativos do WordPress) — sem ACF Pro obrigatório, sem React standalone
- **Tema base recomendado:** Tema compatível com Full Site Editing (FSE), ex.: Twenty Twenty-Four ou tema gov.br adaptado
- **Plugins permitidos para este MVP:**
  - The Events Calendar (agenda — versão gratuita)
  - Bloco Query Loop nativo (feed de notícias — sem plugin adicional)
  - VLibras Widget (acessibilidade)
- **Proibido no escopo deste MVP:** Next.js, SPA, React standalone, Vue, Angular, ou qualquer solução que exija build process externo ao WordPress
- **CSS:** Customizações via `theme.json` (tokens do Design System gov.br) e CSS adicional no Customizador — sem preprocessadores externos obrigatórios
