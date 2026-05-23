# Edição — Fábrica de Software

Guia para coordenação e editores (RF13 + portfólio RF14).

---

## Por que a página parecia “vazia” no wp-admin?

O layout da Fábrica **não** usa o editor de blocos (área “Digite / para escolher um bloco”). O conteúdo estruturado vem do tema + tipos de conteúdo dedicados.

Ao editar **Páginas → Fábrica de Software**, role até a caixa:

**«Portal — Fábrica de Software»**

Lá estão o resumo, o texto do portfólio e o e-mail de parcerias.

---

## Onde editar cada coisa

| O quê | Onde no wp-admin |
|-------|------------------|
| **Resumo** (intro abaixo do título) | Páginas → Fábrica de Software → caixa **Portal — Fábrica de Software** |
| **Texto acima da lista de projetos** | Mesma caixa → **Intro do portfólio** |
| **E-mail para parcerias** | Mesma caixa → **E-mail para parcerias** |
| **Cada projeto** (nome, descrição, tecnologias, link da solução…) | Menu lateral → **Projetos Fábrica** |
| Missão, metodologia, equipe, parceria (textos fixos) | Ficheiro `data/fabrica-software.php` (equipe técnica / deploy) |

---

## Adicionar um projeto (portfólio dinâmico)

1. **Projetos Fábrica → Adicionar projeto**
2. **Título** = nome do projeto
3. **Editor** = descrição
4. **Imagem destacada** (opcional) — aparece no card
5. Caixa **Detalhes do projeto**:
   - Ano / turma
   - Tecnologias
   - Equipe (alunos)
   - Entrega / resultado
   - **Link da solução ou apresentação** (demo, slides, GitHub, vídeo)
6. **Publicar**

**Ordem na página:** campo **Ordem** em *Atributos da página* (número menor = aparece primeiro).

### Primeira vez no site

Se ainda não existir nenhum projeto, o tema pode criar **3 rascunhos de exemplo** a partir do ficheiro `data/`. Abra cada um em **Projetos Fábrica**, ajuste e **publique**. Depois que houver pelo menos um projeto **publicado**, a lista do site usa só o painel (não os exemplos do ficheiro).

---

## Atalho na página Fábrica

Na caixa **Portal — Fábrica de Software** há botões:

- **Adicionar projeto**
- **Ver todos os projetos**

---

## Conteúdo extra no editor de blocos

O campo de blocos da página continua **opcional** (aviso, vídeo incorporado, etc.). Não substitui o portfólio nem as secções fixas.

---

*Alinhado ao tema `portal-si-cefet` 0.5.1+.*
