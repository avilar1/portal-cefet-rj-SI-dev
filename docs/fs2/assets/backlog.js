/**
 * Backlog FS II — Portal SI CEFET/RJ
 * Fonte editável: RF, status, sprint alvo, responsável, DoD
 */
window.FS2_BACKLOG = {
	version: "1.0",
	updated: "2026-08-24",
	sprints: [
		{ id: "S0", name: "Sprint 0 — Fundação", start: "2026-08-25", end: "2026-09-03", deliverable: "Project Charter + Gantt + backlog" },
		{ id: "S1", name: "Sprint 1 — Institucional", start: "2026-09-04", end: "2026-09-18", deliverable: "Módulo institucional 100% validado" },
		{ id: "S2", name: "Sprint 2 — P&E e Docentes", start: "2026-09-19", end: "2026-10-03", deliverable: "Hub P&E + importação docentes" },
		{ id: "S3", name: "Sprint 3 — Fábrica e Serviços", start: "2026-10-04", end: "2026-10-18", deliverable: "Fábrica + serviços + repositório TCC" },
		{ id: "S4", name: "Sprint 4 — Transversal", start: "2026-10-19", end: "2026-11-02", deliverable: "Admin, busca, SEO, qualidade" },
		{ id: "S5", name: "Sprint 5 — Go-live", start: "2026-11-03", end: "2026-11-15", deliverable: "Produto no servidor CEFET + credenciais" },
		{ id: "S6", name: "Sprint 6 — Acadêmico", start: "2026-11-16", end: "2026-11-30", deliverable: "Apresentação e aceite formal" }
	],
	milestones: [
		{ id: "M1", date: "2026-09-03", label: "Entrega Project Charter (acadêmico)" },
		{ id: "M2", date: "2026-11-15", label: "Deadline produto (go-live + credenciais)" },
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
		{ id: "RF03", module: "Institucional", title: "Grade curricular completa", priority: "Alta", status: "partial", sprint: "S1", owner: "[Colega 1]", dod: "Estrutura por período + ementas/conteúdo real validado pelo cliente" },
		{ id: "RF07", module: "Institucional", title: "Vida estudantil / bolsas", priority: "Média", status: "pending", sprint: "S1", owner: "[Colega 1]", dod: "Página publicada com bolsas e auxílios CEFET" },
		{ id: "RF26", module: "Serviços", title: "Fluxo de disciplinas", priority: "Alta", status: "partial", sprint: "S1", owner: "[Colega 1]", dod: "Visualização de progressão e pré-requisitos vinculada à grade" },
		{ id: "RF21", module: "Comunicação", title: "Destaques home / galeria", priority: "Média", status: "partial", sprint: "S1", owner: "[Colega 3]", dod: "Refino visual destaques; galeria multimídia se priorizado" },
		{ id: "TR-TI-1", module: "Infra", title: "Primeiro contato TI CEFET", priority: "—", status: "pending", sprint: "S1", owner: "[Gerente]", dod: "Reunião agendada; requisitos servidor documentados" },
		{ id: "TR-CT-1", module: "Conteúdo", title: "Coleta grade e docentes", priority: "—", status: "pending", sprint: "S1", owner: "[Gerente]", dod: "Planilhas/listas recebidas da coordenação" },

		/* —— Sprint 2 —— */
		{ id: "RF09", module: "Pesquisa/Ext.", title: "Projetos de pesquisa", priority: "Alta", status: "pending", sprint: "S2", owner: "[Colega 2]", dod: "Listagem com responsável e situação" },
		{ id: "RF10", module: "Pesquisa/Ext.", title: "Iniciação científica", priority: "Média", status: "pending", sprint: "S2", owner: "[Colega 2]", dod: "Critérios e contatos publicados" },
		{ id: "RF11", module: "Pesquisa/Ext.", title: "Hub P&E / parcerias", priority: "Média", status: "partial", sprint: "S2", owner: "[Colega 2]", dod: "Hub com listagens completas e convênios" },
		{ id: "RF12", module: "Pesquisa/Ext.", title: "Importação planilha docentes", priority: "Alta", status: "paused", sprint: "S2", owner: "[Colega 2]", dod: "Import CSV/planilha funcional ou fallback documentado" },

		/* —— Sprint 3 —— */
		{ id: "RF15", module: "Fábrica SW", title: "Showcase excelência", priority: "Média", status: "pending", sprint: "S3", owner: "[Colega 3]", dod: "Destaque de soluções acadêmicas relevantes" },
		{ id: "RF16", module: "Fábrica SW", title: "Formulário parceiros", priority: "Alta", status: "paused", sprint: "S3", owner: "[Colega 3]", dod: "Canal exclusivo de demanda para parceiros externos" },
		{ id: "RF23", module: "Serviços", title: "Serviços acadêmicos", priority: "Média", status: "pending", sprint: "S3", owner: "[Colega 1]", dod: "Secretaria, biblioteca, SAE com contatos e horários" },
		{ id: "RF24", module: "Serviços", title: "Ferramentas digitais", priority: "Média", status: "pending", sprint: "S3", owner: "[Colega 1]", dod: "GitHub Student Pack, Figma Education, etc." },
		{ id: "RF25", module: "Serviços", title: "Repositório TCC", priority: "Alta", status: "partial", sprint: "S3", owner: "[Colega 3]", dod: "Busca por título/autor/ano + conteúdo inicial curado" },

		/* —— Sprint 4 —— */
		{ id: "RF28", module: "Contato", title: "Ouvidoria", priority: "Média", status: "partial", sprint: "S4", owner: "[Colega 3]", dod: "Formulário ou integração com prazo de resposta" },
		{ id: "RF30", module: "Admin", title: "Área administrativa", priority: "Alta", status: "partial", sprint: "S4", owner: "[Gerente]", dod: "Painel WP configurado para operação" },
		{ id: "RF31", module: "Admin", title: "Perfis Admin / Editor", priority: "Alta", status: "partial", sprint: "S4", owner: "[Gerente]", dod: "2 professores com credenciais testadas" },
		{ id: "RF32", module: "Admin", title: "Menu configurável", priority: "Alta", status: "partial", sprint: "S4", owner: "[Gerente]", dod: "Menus wp-admin alinhados à IA" },
		{ id: "RF33", module: "Admin", title: "Busca global", priority: "Alta", status: "partial", sprint: "S4", owner: "[Colega 1]", dod: "Notícias, docs, projetos, professores indexados" },
		{ id: "RF34", module: "Admin", title: "Sitemap XML", priority: "Média", status: "partial", sprint: "S4", owner: "[Colega 1]", dod: "Plugin SEO configurado" },
		{ id: "RNF", module: "Transversal", title: "A11y, LGPD, performance", priority: "—", status: "partial", sprint: "S4", owner: "Equipe", dod: "Checklist RNF03–07; Lighthouse a11y ≥ 90" },
		{ id: "TR-TI-2", module: "Infra", title: "Provisionamento servidor CEFET", priority: "—", status: "pending", sprint: "S4", owner: "[Gerente]", dod: "Acesso SSH/VM; Docker ou stack acordada com TI" },
		{ id: "TR-CT-2", module: "Conteúdo", title: "População dados reais (pico)", priority: "—", status: "pending", sprint: "S4", owner: "Equipe", dod: "Docentes, notícias (≥5), projetos, docs oficiais" },

		/* —— Sprint 5 —— */
		{ id: "TR-DEPLOY", module: "Infra", title: "Deploy produção CEFET", priority: "—", status: "pending", sprint: "S5", owner: "[Gerente]", dod: "Portal acessível no servidor institucional" },
		{ id: "TR-TEST", module: "QA", title: "Testes aceite final (100% RF)", priority: "—", status: "pending", sprint: "S5", owner: "Equipe", dod: "IMPLEMENTACAO-CHECKLIST sem pendências bloqueadoras" },
		{ id: "TR-TRAIN", module: "Operação", title: "Treinamento administradores", priority: "—", status: "pending", sprint: "S5", owner: "[Gerente]", dod: "Sessão com 2 professores; guias docs/edicao-*.md" },
		{ id: "TR-CRED", module: "Operação", title: "Entrega credenciais + termo aceite", priority: "—", status: "pending", sprint: "S5", owner: "[Gerente]", dod: "Admins operacionais; termo assinado até 15/11" },

		/* —— Sprint 6 —— */
		{ id: "TR-DOC", module: "Documentação", title: "Documentação final operação", priority: "—", status: "pending", sprint: "S6", owner: "[Gerente]", dod: "DEPLOY.md + BACKUP.md revisados pós-go-live" },
		{ id: "TR-PRES", module: "Acadêmico", title: "Apresentação final disciplina", priority: "—", status: "pending", sprint: "S6", owner: "Equipe", dod: "Demo + slides; aceite formal 30/11" }
	]
};
