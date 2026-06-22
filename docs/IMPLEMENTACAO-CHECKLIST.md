# Checklist de implementação — Portal SI CEFET/RJ

Atualizado conforme entregas da Fábrica de Software. **Tema:** `portal-si-cefet` **0.5.5+**

Referência de requisitos: [`docs/referencias/Analise_Requisitos_Portal_SI_CefetRJ_revisado.md`](referencias/Analise_Requisitos_Portal_SI_CefetRJ_revisado.md)  
Prioridade Alta: [`REQUISITOS-PRIORIDADE.txt`](../REQUISITOS-PRIORIDADE.txt)

---

## Legenda

| Símbolo | Significado |
|---------|-------------|
| ✅ | Entregue (MVP ou completo) |
| 🟡 | Parcial / conteúdo editorial em evolução |
| ⏸ | Adiado de propósito |
| ⬜ | Pendente (prioridade média ou baixa) |

---

## Módulo Institucional

| RF | Requisito | Status | Notas |
|----|-----------|--------|-------|
| RF02 | Sobre o Curso | ✅ | Coordenação sincronizada com Contato; vice-coordenação editável no wp-admin |
| RF03 | Grade curricular | 🟡 | Estrutura pronta; conteúdo editorial (grade, ementas) |
| RF04 | Infraestrutura | ✅ | Mapa campus MG |
| RF05 | Ingresso | ✅ | Links oficiais SISU |
| RF06 | Documentos institucionais | ✅ | Publicações editáveis no wp-admin |
| RF07 | Vida estudantil | ⬜ | Prioridade média |
| RF08 | Corpo docente | ✅ | CPT `portal_professor`; importação em lote (RF12) ⏸ |

**Institucional — MVP:** estrutura entregue; grade (RF03) e vida estudantil (RF07) dependem de conteúdo editorial.

---

## Módulo Pesquisa e Extensão

| RF | Requisito | Status | Notas |
|----|-----------|--------|-------|
| RF09 | Projetos de pesquisa | ⬜ | Prioridade média |
| RF10 | Projetos de extensão | ⬜ | Prioridade média |
| RF11 | Hub Pesquisa e Extensão | 🟡 | Hub publicado; listagens em evolução |
| RF12 | Importação planilha docentes | ⏸ | Evolução futura; cadastro manual ativo |

**Corpo docente (RF08)** entregue como base dinâmica no wp-admin.

---

## Módulo Fábrica de Software

| RF | Requisito | Status | Notas |
|----|-----------|--------|-------|
| RF13 | Página da Fábrica | ✅ | Missão, metodologia, equipe, tipos |
| RF14 | Portfólio | ✅ | CPT `portal_fs_projeto` no painel |
| RF15 | Showcase excelência | ⬜ | Prioridade média |
| RF16 | Formulário parceiros | ⏸ | Contato + e-mail; formulário dedicado opcional |

---

## Módulo Comunicação Institucional

| RF | Requisito | Status | Notas |
|----|-----------|--------|-------|
| RF17 | Listagem notícias | ✅ | |
| RF18 | Detalhe notícia | ✅ | |
| RF19 | CRUD notícias | ✅ | |
| RF20 | Agenda / eventos | ✅ | CPT `portal_evento` |
| RF21 | Destaques home | 🟡 | Refinamento visual opcional |

---

## Módulo Serviços Digitais

| RF | Requisito | Status | Notas |
|----|-----------|--------|-------|
| RF22 | Links serviços externos | ✅ | Home — acesso rápido |
| RF23 | Serviços acadêmicos | ⬜ | Prioridade média |
| RF24 | Ferramentas digitais | ⬜ | Prioridade média |
| RF25 | Repositório TCC | 🟡 | Estrutura prevista; conteúdo editorial |
| RF26 | Fluxo de disciplinas | 🟡 | Vinculado à grade (RF03) |

---

## Módulo Contato e Atendimento

| RF | Requisito | Status | Notas |
|----|-----------|--------|-------|
| RF27 | Página de contato | ✅ | Endereço, mapa, canais — dados [página oficial CEFET](https://www.cefet-rj.br/index.php/bacharelado-em-sistemas-de-informacao-maria-da-graca) |
| RF28 | Ouvidoria (formulário) | 🟡 | Link ouvidoria CEFET; integração opcional |
| RF29 | Contato coordenação | ✅ | Destaque na página + rodapé |

---

## Administração e transversal

| RF / RNF | Item | Status | Notas |
|----------|------|--------|-------|
| RF30–32 | Admin, perfis, menu | 🟡 | WP nativo + seed menus |
| RF33 | Busca global | 🟡 | Páginas, professores, projetos fábrica |
| RF34 | Sitemap XML | 🟡 | Plugin SEO |
| RF12 | Import professores | ⏸ | Evolução futura |
| RNF03–07 | A11y, LGPD, DS gov.br | 🟡 | Contínuo |

**Operação:** deploy e backup documentados em [`DEPLOY.md`](DEPLOY.md) e [`BACKUP.md`](BACKUP.md).

---

## Evolução sugerida (pós-MVP)

1. **Conteúdo editorial** — vice-coordenação, professores, projetos fábrica, notícias.
2. **Grade (RF03) e fluxo (RF26)** — publicação de ementas e fluxograma.
3. **Repositório TCC (RF25)** — conteúdo e regras de curadoria.
4. **Formulários dedicados** — RF16 / RF28, se priorizado pela coordenação.
5. **Go-live institucional** — substituir [página legada do curso](https://www.cefet-rj.br/index.php/bacharelado-em-sistemas-de-informacao-maria-da-graca) após validação.

---

## O portal substitui

A [página única do curso no site CEFET/RJ](https://www.cefet-rj.br/index.php/bacharelado-em-sistemas-de-informacao-maria-da-graca) concentra hoje grade, contato e informações dispersas. Este portal modulariza esse conteúdo em páginas dedicadas editáveis pela equipe.

---

*Última revisão: jun/2026 — Fábrica de Software SI CEFET/RJ.*
