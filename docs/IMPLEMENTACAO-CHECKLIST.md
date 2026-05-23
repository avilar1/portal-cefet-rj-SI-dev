# Checklist de implementação — Portal SI CEFET/RJ

Atualizado conforme entregas da Fábrica de Software. **Tema:** `portal-si-cefet` **0.5.3+**

Referência de requisitos: [`docs/referencias/Analise_Requisitos_Portal_SI_CefetRJ_revisado.md`](referencias/Analise_Requisitos_Portal_SI_CefetRJ_revisado.md)  
Prioridade Alta: [`REQUISITOS-PRIORIDADE.txt`](../REQUISITOS-PRIORIDADE.txt)

---

## Legenda

| Símbolo | Significado |
|---------|-------------|
| ✅ | Feito do nosso lado (MVP ou completo) |
| 🟡 | Parcial / aguardando conteúdo ou colegas |
| ⏸ | Adiado de propósito |
| ⬜ | Pendente (prioridade alta ou média futura) |

---

## Módulo Institucional

| RF | Requisito | Status | Notas |
|----|-----------|--------|-------|
| RF02 | Sobre o Curso | ✅ | Coordenação sincronizada com Contato (Cristiano Fuschilo + vice placeholder) |
| RF03 | Grade curricular | 🟡 | Colegas / conteúdo |
| RF04 | Infraestrutura | ✅ | Mapa campus MG |
| RF05 | Ingresso | ✅ | Links oficiais SISU |
| RF06 | Documentos institucionais | ✅ | Publicações editáveis no wp-admin |
| RF07 | Vida estudantil | ⬜ | Médio |
| RF08 | Corpo docente | ✅ | CPT `portal_professor`; import Excel (RF12) ⏸ |

**Institucional — nosso lado:** feito, exceto Grade (colegas) e RF07 (futuro).

---

## Módulo Pesquisa e Extensão

| RF | Requisito | Status | Notas |
|----|-----------|--------|-------|
| RF09 | Projetos de pesquisa | ⬜ | Médio |
| RF10 | Projetos de extensão | ⬜ | Médio |
| RF11 | Hub Pesquisa e Extensão | 🟡 | Página seed; hub leve |
| RF12 | Importação planilha docentes | ⏸ | Sem Excel da coordenação |

**Corpo docente (RF08)** entregue como base dinâmica no wp-admin.

---

## Módulo Fábrica de Software

| RF | Requisito | Status | Notas |
|----|-----------|--------|-------|
| RF13 | Página da Fábrica | ✅ | Missão, metodologia, equipe, tipos |
| RF14 | Portfólio | ✅ | CPT `portal_fs_projeto` no painel |
| RF15 | Showcase excelência | ⬜ | Médio |
| RF16 | Formulário parceiros | ⏸ | E-mail + página; formulário depois |

---

## Módulo Comunicação Institucional

| RF | Requisito | Status | Notas |
|----|-----------|--------|-------|
| RF17 | Listagem notícias | ✅ | |
| RF18 | Detalhe notícia | ✅ | |
| RF19 | CRUD notícias | ✅ | |
| RF20 | Agenda / eventos | ✅ | CPT `portal_evento` |
| RF21 | Destaques home | 🟡 | Refinar depois |

---

## Módulo Serviços Digitais

| RF | Requisito | Status | Notas |
|----|-----------|--------|-------|
| RF22 | Links serviços externos | ✅ | Home — acesso rápido |
| RF23 | Serviços acadêmicos | ⬜ | Médio |
| RF24 | Ferramentas digitais | ⬜ | Médio |
| RF25 | Repositório TCC | 🟡 | Colegas |
| RF26 | Fluxo de disciplinas | 🟡 | Colegas / Grade |

---

## Módulo Contato e Atendimento

| RF | Requisito | Status | Notas |
|----|-----------|--------|-------|
| RF27 | Página de contato | ✅ | Endereço, mapa, canais — dados [página oficial CEFET](https://www.cefet-rj.br/index.php/bacharelado-em-sistemas-de-informacao-maria-da-graca) |
| RF28 | Ouvidoria (formulário) | 🟡 | Link institucional; formulário futuro |
| RF29 | Contato coordenação | ✅ | Destaque na página + rodapé |

---

## Administração e transversal

| RF / RNF | Item | Status | Notas |
|----------|------|--------|-------|
| RF30–32 | Admin, perfis, menu | 🟡 | WP nativo + seed menus |
| RF33 | Busca global | 🟡 | Páginas, professores, projetos fábrica |
| RF34 | Sitemap XML | 🟡 | Plugin SEO |
| RF12 | Import professores | ⏸ | |
| RNF03–07 | A11y, LGPD, DS gov.br | 🟡 | Contínuo |

---

## Próximos focos sugeridos

1. **Conteúdo real** — vice-coordenação, e-mails confirmados, projetos fábrica publicados, professores no CPT.
2. **Grade + RF26** — quando colegas entregarem.
3. **Formulários** — RF16 / RF28 (Contact Form 7 ou equivalente), quando priorizado.
4. **Comunicação** — refinamentos RF21.
5. **Substituir página legada** Joomla do curso no CEFET/RJ quando coordenação validar go-live.

---

## O portal substitui

A [página única do curso no site CEFET/RJ](https://www.cefet-rj.br/index.php/bacharelado-em-sistemas-de-informacao-maria-da-graca) concentra hoje grade, contato e informações dispersas. Este portal modulariza esse conteúdo em páginas dedicadas editáveis pela equipe.

---

*Última revisão: maio/2026 — Fábrica de Software SI CEFET/RJ.*
