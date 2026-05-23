# Edição do Corpo Docente

Guia para **coordenação e editores** — como cadastrar e manter os perfis dos professores no portal (RF08).

---

## Onde editar

No wp-admin: **Professores** (menu lateral, ícone de pessoas).

Cada professor é um registo independente — pode **adicionar**, **editar**, **reordenar** ou **remover** a qualquer momento, sem alterar código.

A listagem pública fica em: `/corpo-docente/` (dentro do hub Institucional).

---

## Campos por professor

| Campo | Onde no wp-admin | Obrigatório | Aparece no site |
|-------|------------------|-------------|-----------------|
| **Nome** | Título do registo | Sim | Listagem e perfil |
| **Foto** | Imagem destacada (caixa à direita) | Recomendado | Listagem e perfil; sem foto, mostra iniciais |
| **Currículo Lattes** | Caixa «Perfil do professor» | Recomendado | Link no card e no perfil |
| **Formação acadêmica** | Caixa «Perfil do professor» | Não | Só no perfil, se preenchido |
| **Biografia** | Caixa «Perfil do professor» | Não | Só no perfil, se preenchido |
| **Linhas de pesquisa** | Caixa «Perfil do professor» | Não | Tags no perfil; na listagem, a primeira linha pode aparecer como resumo |
| **Resumo** | Campo *Resumo* (excerpt) | Não | Texto curto no card da listagem |

**Regra:** campos vazios **não** aparecem no site — não é preciso preencher tudo de uma vez.

---

## Ordem na listagem

Use o campo **Ordem** (caixa *Atributos da página* ao editar o professor). Números menores aparecem primeiro. Professores com a mesma ordem são ordenados por nome.

---

## Publicar ou rascunho

Só professores com estado **Publicado** aparecem em `/corpo-docente/`. Use **Rascunho** enquanto o perfil ainda não estiver pronto.

---

## Importação por planilha (futuro — RF12)

Quando a equipe entregar a planilha Excel com os dados, a importação será feita pela equipe técnica e alimentará estes mesmos registos. Até lá, o cadastro manual no wp-admin é o fluxo oficial.

---

## Página Corpo Docente

Em **Páginas → Corpo Docente** pode editar:

- **Resumo** — parágrafo introdutório abaixo do título
- **Conteúdo** — texto extra opcional (blocos Gutenberg)

A grade de professores é montada automaticamente a partir dos registos publicados.

---

*Alinhado ao tema `portal-si-cefet` 0.4.9+.*
