/**
 * Backlog FS II — Portal SI CEFET/RJ
 * Fonte editável: RF, status, sprint alvo, responsável, DoD
 */
window.FS2_BACKLOG = {
	version: "1.2",
	updated: "2026-11-20",
	sprints: [
		{ id: "S0", name: "Sprint 0 — Fundação", start: "2026-08-25", end: "2026-09-03", deliverable: "Project Charter + Gantt + backlog" },
		{ id: "S1", name: "Sprint 1 — Institucional", start: "2026-09-04", end: "2026-09-18", deliverable: "Entregas técnicas do módulo institucional (validação residual paralisada)" },
		{ id: "S2", name: "Sprint 2 — P&E e Docentes", start: "2026-09-19", end: "2026-10-03", deliverable: "Hub P&E (listagens); import/convênios paralisados" },
		{ id: "S3", name: "Sprint 3 — Fábrica e Serviços", start: "2026-10-04", end: "2026-10-18", deliverable: "Repositório TCC (busca/página); lista real e médias paralisados" },
		{ id: "S4", name: "Sprint 4 — Transversal", start: "2026-10-19", end: "2026-11-04", deliverable: "Admin, busca, SEO e RNF na base; polimento paralisado" },
		{ id: "S5", name: "Sprint 5 — Go-live", start: "2026-11-19", end: "2026-11-27", deliverable: "Publicação na Oracle Always Free + credenciais dos professores" },
		{ id: "S6", name: "Sprint 6 — Acadêmico", start: "2026-11-23", end: "2026-11-30", deliverable: "Apresentação e aceite formal" }
	],
	milestones: [
		{ id: "M1", date: "2026-09-03", label: "Entrega Project Charter (acadêmico)" },
		{ id: "M2", date: "2026-11-27", label: "Go-live na Oracle Always Free + credenciais dos professores" },
		{ id: "M3", date: "2026-11-30", label: "Entrega acadêmica final" }
	],
	items: [
		/* —— Entregues (manutenção) —— */
		{ id: "RF01", module: "Institucional", title: "Página Inicial (Home)", priority: "Alta", status: "done", sprint: "—", owner: "Equipe", dod: "8 zonas publicadas; acesso rápido e notícias/agenda funcionais" },
		{ id: "RF02", module: "Institucional", title: "Sobre o Curso", priority: "Alta", status: "done", sprint: "—", owner: "Equipe", dod: "Seções RF02 editáveis no wp-admin" },
		{ id: "RF04", module: "Institucional", title: "Infraestrutura", priority: "Média", status: "done", sprint: "—", owner: "Equipe", dod: "Página campus MG publicada" },
		{ id: "RF05", module: "Institucional", title: "Ingresso", priority: "Alta", status: "done", sprint: "—", owner: "Equipe", dod: "Links SISU/ENEM oficiais" },
		{ id: "RF06", module: "Institucional", title: "Documentos institucionais", priority: "Alta", status: "done", sprint: "—", owner: "Equipe", dod: "Publicações editáveis no painel" },
		{ id: "RF08", module: "Pesquisa/Ext.", title: "Corpo docente (CPT)", priority: "Alta", status: "done", sprint: "S2", owner: "[Colega 2]", dod: "CPT portal_professor + perfis reais populados" },
		{ id: "RF13", module: "Fábrica SW", title: "Página da Fábrica", priority: "Alta", status: "done", sprint: "—", owner: "Equipe", dod: "Missão, metodologia, equipe publicados" },
		{ id: "RF14", module: "Fábrica SW", title: "Portfólio de projetos", priority: "Alta", status: "done", sprint: "—", owner: "Equipe", dod: "CPT portal_fs_projeto funcional" },
		{ id: "RF17", module: "Comunicação", title: "Listagem de notícias", priority: "Alta", status: "done", sprint: "—", owner: "Equipe", dod: "Paginação e categorias" },
		{ id: "RF18", module: "Comunicação", title: "Detalhe de notícia", priority: "Alta", status: "done", sprint: "—", owner: "Equipe", dod: "Single post template" },
		{ id: "RF19", module: "Comunicação", title: "CRUD notícias", priority: "Alta", status: "done", sprint: "—", owner: "Equipe", dod: "Editor + perfil Editor testado" },
		{ id: "RF20", module: "Comunicação", title: "Agenda / eventos", priority: "Alta", status: "done", sprint: "—", owner: "Equipe", dod: "CPT portal_evento + calendário acadêmico separado" },
		{ id: "RF22", module: "Serviços", title: "Links serviços externos", priority: "Alta", status: "done", sprint: "—", owner: "Equipe", dod: "Acesso rápido na home" },
		{ id: "RF27", module: "Contato", title: "Página de contato", priority: "Alta", status: "done", sprint: "—", owner: "Equipe", dod: "Mapa, canais, endereço oficial" },
		{ id: "RF29", module: "Contato", title: "Contato coordenação", priority: "Alta", status: "done", sprint: "—", owner: "Equipe", dod: "Destaque na página e rodapé" },

		/* —— Sprint 1 —— */
		{ id: "RF03", module: "Institucional", title: "Grade curricular completa", priority: "Alta", status: "paused", sprint: "S1", owner: "[Colega 1]", dod: "Subtarefa entregue: estrutura/PPC no painel. Paralisada: validação da coordenação / ementas finais (não bloqueia M2)" },
		{ id: "RF07", module: "Institucional", title: "Vida estudantil / bolsas", priority: "Média", status: "done", sprint: "S1", owner: "[Colega 1]", dod: "Página publicada com bolsas e auxílios CEFET" },
		{ id: "RF26", module: "Serviços", title: "Fluxo de disciplinas", priority: "Alta", status: "done", sprint: "S1", owner: "[Colega 1]", dod: "Visualização de progressão e pré-requisitos vinculada à grade" },
		{ id: "RF21", module: "Comunicação", title: "Galeria multimídia", priority: "Média", status: "done", sprint: "S1", owner: "[Colega 3]", dod: "Álbuns de fotos e vídeos por categoria, editáveis no painel, com faixa opcional na home (sem alterar as zonas existentes)" },
		{ id: "TR-TI-1", module: "Infra", title: "Primeiro contato TI CEFET", priority: "—", status: "paused", sprint: "S1", owner: "[Gerente]", dod: "Paralisada: aguarda agenda/TI. Fora do caminho crítico do go-live Oracle" },
		{ id: "TR-CT-1", module: "Conteúdo", title: "Coleta grade e docentes", priority: "—", status: "paused", sprint: "S1", owner: "[Gerente]", dod: "Subtarefa entregue: lote inicial. Paralisada: coleta complementar (dado externo)" },

		/* —— Sprint 2 —— */
		{ id: "RF09", module: "Pesquisa/Ext.", title: "Projetos de pesquisa", priority: "Alta", status: "done", sprint: "S2", owner: "[Colega 2]", dod: "Listagem com responsável e situação (CPT editável com filtros)" },
		{ id: "RF10", module: "Pesquisa/Ext.", title: "Iniciação científica", priority: "Média", status: "done", sprint: "S2", owner: "[Colega 2]", dod: "Critérios e contatos publicados (página editável + projetos com vagas automáticos)" },
		{ id: "RF11", module: "Pesquisa/Ext.", title: "Hub P&E / parcerias", priority: "Média", status: "paused", sprint: "S2", owner: "[Colega 2]", dod: "Subtarefa entregue: listagens do hub. Paralisada: convênios reais (lista externa)" },
		{ id: "RF12", module: "Pesquisa/Ext.", title: "Importação planilha docentes", priority: "Alta", status: "paused", sprint: "S2", owner: "[Colega 2]", dod: "Paralisada: import CSV/planilha ou fallback — não bloqueia M2" },

		/* —— Sprint 3 —— */
		{ id: "RF15", module: "Fábrica SW", title: "Showcase excelência", priority: "Média", status: "paused", sprint: "S3", owner: "[Colega 3]", dod: "Paralisada (prioridade média): não bloqueia M2" },
		{ id: "RF16", module: "Fábrica SW", title: "Formulário parceiros", priority: "Alta", status: "paused", sprint: "S3", owner: "[Colega 3]", dod: "Paralisada: canal de demanda externa — não bloqueia M2" },
		{ id: "RF23", module: "Serviços", title: "Serviços acadêmicos", priority: "Média", status: "paused", sprint: "S3", owner: "[Colega 1]", dod: "Paralisada (prioridade média): não bloqueia M2" },
		{ id: "RF24", module: "Serviços", title: "Ferramentas digitais", priority: "Média", status: "paused", sprint: "S3", owner: "[Colega 1]", dod: "Paralisada (prioridade média): não bloqueia M2" },
		{ id: "RF25", module: "Serviços", title: "Repositório TCC", priority: "Alta", status: "paused", sprint: "S3", owner: "[Colega 3]", dod: "Subtarefa entregue: busca, filtros, página e PDF/link. Paralisada: substituir exemplos pela lista real de TCCs" },

		/* —— Sprint 4 —— */
		{ id: "RF28", module: "Contato", title: "Ouvidoria", priority: "Média", status: "paused", sprint: "S4", owner: "[Colega 3]", dod: "Subtarefa entregue: formulário base. Paralisada: prazo/integração — não bloqueia M2" },
		{ id: "RF30", module: "Admin", title: "Área administrativa", priority: "Alta", status: "paused", sprint: "S4", owner: "[Gerente]", dod: "Subtarefa entregue: painel configurado. Paralisada: ajuste fino de operação" },
		{ id: "RF31", module: "Admin", title: "Perfis Admin / Editor", priority: "Alta", status: "paused", sprint: "S4", owner: "[Gerente]", dod: "Base pronta; credenciais dos professores fecham no S5 (TR-CRED). Polimento residual paralisado" },
		{ id: "RF32", module: "Admin", title: "Menu configurável", priority: "Alta", status: "paused", sprint: "S4", owner: "[Gerente]", dod: "Subtarefa entregue: menus alinhados. Paralisada: ajuste fino" },
		{ id: "RF33", module: "Admin", title: "Busca global", priority: "Alta", status: "paused", sprint: "S4", owner: "[Colega 1]", dod: "Subtarefa entregue: indexação base. Paralisada: cobertura residual" },
		{ id: "RF34", module: "Admin", title: "Sitemap XML", priority: "Média", status: "paused", sprint: "S4", owner: "[Colega 1]", dod: "Subtarefa entregue: SEO/sitemap base. Paralisada: residual" },
		{ id: "RNF", module: "Transversal", title: "A11y, LGPD, performance", priority: "—", status: "paused", sprint: "S4", owner: "Equipe", dod: "Subtarefa entregue: checklist. Paralisada: Lighthouse/polimento — não bloqueia M2" },
		{ id: "TR-TI-2", module: "Infra", title: "Servidor institucional CEFET", priority: "—", status: "paused", sprint: "S4", owner: "[Gerente]", dod: "Paralisada. Fora do caminho crítico. Go-live 27/11 na Oracle Always Free" },
		{ id: "TR-CT-2", module: "Conteúdo", title: "População dados reais (pico)", priority: "—", status: "paused", sprint: "S4", owner: "Equipe", dod: "Subtarefa entregue: lotes iniciais. Paralisada: pico restante (dado externo)" },

		/* —— Sprint 5 —— */
		{ id: "TR-DEPLOY", module: "Infra", title: "Publicar na Oracle Always Free", priority: "—", status: "pending", sprint: "S5", owner: "[Gerente]", dod: "Mesmo padrão da homologação (Docker + Caddy). Portal no ar até 27/11" },
		{ id: "TR-TEST", module: "QA", title: "Teste do portal publicado", priority: "—", status: "pending", sprint: "S5", owner: "Equipe", dod: "Home, contato, notícias e login dos professores conferidos no endereço público" },
		{ id: "TR-TRAIN", module: "Operação", title: "Entrega do acesso aos professores", priority: "—", status: "pending", sprint: "S5", owner: "[Gerente]", dod: "Dois professores com credencial de editor e os guias docs/edicao-*.md" },
		{ id: "TR-CRED", module: "Operação", title: "Credenciais dos professores", priority: "—", status: "pending", sprint: "S5", owner: "[Gerente]", dod: "Usuários criados na publicação Oracle até 27/11" },

		/* —— Sprint 6 —— */
		{ id: "TR-DOC", module: "Documentação", title: "Documentação final operação", priority: "—", status: "pending", sprint: "S6", owner: "[Gerente]", dod: "DEPLOY.md + BACKUP.md revisados pós-go-live" },
		{ id: "TR-PRES", module: "Acadêmico", title: "Apresentação final disciplina", priority: "—", status: "pending", sprint: "S6", owner: "Equipe", dod: "Demo + slides; aceite formal 30/11" }
	]
};
