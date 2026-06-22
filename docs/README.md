# Documentação do projeto — Portal SI CEFET/RJ

Pasta **versionada** com a documentação de produto e UX que orienta o desenvolvimento.

A pasta `contexto/` na raiz do repositório permanece no `.gitignore` (materiais locais, pacotes DS, rascunhos). Os artefatos **oficiais para a equipe** ficam aqui em `docs/referencias/`.

## Referências obrigatórias

| Arquivo | Uso |
|---------|-----|
| [Analise_Requisitos_Portal_SI_CefetRJ_revisado.md](referencias/Analise_Requisitos_Portal_SI_CefetRJ_revisado.md) | Regras de negócio (RN), requisitos funcionais (RF), IA (Seção 8), cronograma |
| [heuristicas_governo_eletronico.md](referencias/heuristicas_governo_eletronico.md) | Heurísticas H1–H12 para portais de governo eletrônico |

## Status de implementação

| Documento | Conteúdo |
|-----------|----------|
| [**IMPLEMENTACAO-CHECKLIST.md**](IMPLEMENTACAO-CHECKLIST.md) | **Checklist por RF** — entregue, parcial e evolução |

## Operação e continuidade

| Documento | Conteúdo |
|-----------|----------|
| [**DEPLOY.md**](DEPLOY.md) | **Deploy** — VM, Docker, Caddy/HTTPS, atualização do tema, go-live |
| [**BACKUP.md**](BACKUP.md) | **Backup e restauração** — BD, uploads, handoff para novo dev |

## Editorial vs código (obrigatório para a equipe)

| Documento | Conteúdo |
|-----------|----------|
| [**conteudo-wordpress-vs-codigo.md**](conteudo-wordpress-vs-codigo.md) | O que se edita no **wp-admin**, o que fica no **tema/`data/`**, e por que alterar PHP não atualiza a página depois do *seed* |
| [**edicao-calendario-academico.md**](edicao-calendario-academico.md) | **Rotina anual** — como atualizar datas e PDF do calendário (sem código) |
| [**edicao-documentos-institucionais.md**](edicao-documentos-institucionais.md) | **Publicações do curso** — normativos, memorandos e PDFs enviados pela coordenação (sem código) |
| [**edicao-contato.md**](edicao-contato.md) | **Contato** — coordenação, mapa, parcerias Fábrica |
| [**edicao-fabrica-de-software.md**](edicao-fabrica-de-software.md) | **Fábrica de Software** — projetos e textos editáveis |
| [**edicao-corpo-docente.md**](edicao-corpo-docente.md) | **Corpo docente** — perfis de professores no wp-admin |

## Layouts aprovados (prompts de implementação)

| Arquivo | Tela |
|---------|------|
| [layout_homepage_mvp_v2.md](referencias/layout_homepage_mvp_v2.md) | Página inicial (8 zonas) |
| [layout_hub_institucional_mvp.md](referencias/layout_hub_institucional_mvp.md) | Hub `/institucional/` |
| [layout_sobre_o_curso_mvp.md](referencias/layout_sobre_o_curso_mvp.md) | Sobre o Curso — RF02 (`/sobre-o-curso/`) |

Ao alterar requisitos ou layouts, atualize os ficheiros **nesta pasta** e abra pull request para a equipe inteira receber a mesma versão.
