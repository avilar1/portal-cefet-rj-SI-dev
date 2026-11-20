/**
 * Dados do Gantt FS II — sprints, subtarefas e marcos
 * Formato compatível com Frappe Gantt 0.6.1
 *
 * baseline_start / baseline_end = plano original (antes do replanejamento 19/11),
 * usado no gráfico como barra de tendência (planejado × realizado).
 *
 * Folga visual FS: sucessor começa pelo menos 2 dias após o fim do predecessor
 * (1 dia vazio no meio). Sem isso o Frappe trunca a seta quando as barras se tocam.
 */
window.FS2_GANTT = {
	viewMode: "Day",
	asOf: "2026-11-20",
	baselineLabel: "Baseline (plano original até o replanejamento de 19/11)",
	milestones: [
		{ date: "2026-09-03", label: "M1 — Charter acadêmico", class: "milestone-charter" },
		{ date: "2026-11-27", label: "M2 — Go-live Oracle + credenciais", class: "milestone-product" },
		{ date: "2026-11-30", label: "M3 — Entrega acadêmica", class: "milestone-academic" }
	],
	tasks: [
		/* —— S0 — Fundação —— */
		{
			id: "sum-s0",
			name: "S0 — Fundação",
			start: "2026-08-25",
			end: "2026-09-03",
			progress: 100,
			custom_class: "bar-summary",
			group: "S0",
			summary: true,
			baseline_start: "2026-08-25",
			baseline_end: "2026-09-03"
		},
		{ id: "s0-charter", name: "S0: Redigir Project Charter HTML", start: "2026-08-25", end: "2026-08-27", progress: 100, custom_class: "bar-done", group: "S0", baseline_start: "2026-08-25", baseline_end: "2026-08-28" },
		{ id: "s0-gantt", name: "S0: Gantt interativo + backlog", start: "2026-08-29", end: "2026-08-30", progress: 100, dependencies: "s0-charter", custom_class: "bar-done", group: "S0", baseline_start: "2026-08-27", baseline_end: "2026-08-29" },
		{ id: "s0-review", name: "S0: Revisão equipe (4 devs)", start: "2026-09-01", end: "2026-09-01", progress: 100, dependencies: "s0-gantt", custom_class: "bar-done", group: "S0", baseline_start: "2026-08-30", baseline_end: "2026-09-02" },
		{ id: "m1-charter", name: "M1 — Entrega Charter ao professor", start: "2026-09-03", end: "2026-09-03", progress: 100, dependencies: "s0-review", custom_class: "bar-milestone", group: "S0", baseline_start: "2026-09-03", baseline_end: "2026-09-03" },

		/* —— S1 —— */
		{
			id: "sum-s1",
			name: "S1 — Institucional",
			start: "2026-09-04",
			end: "2026-09-16",
			progress: 100,
			custom_class: "bar-summary",
			group: "S1",
			summary: true,
			baseline_start: "2026-09-04",
			baseline_end: "2026-09-18"
		},
		{ id: "s1-rf07", name: "S1: RF07 Vida estudantil", start: "2026-09-04", end: "2026-09-08", progress: 100, custom_class: "bar-done", group: "S1", baseline_start: "2026-09-04", baseline_end: "2026-09-15" },
		{ id: "s1-rf03-done", name: "S1: RF03 Grade — estrutura/PPC no painel", start: "2026-09-04", end: "2026-09-10", progress: 100, custom_class: "bar-done", group: "S1", baseline_start: "2026-09-04", baseline_end: "2026-09-18" },
		{ id: "s1-rf26", name: "S1: RF26 Fluxo de disciplinas", start: "2026-09-09", end: "2026-09-12", progress: 100, custom_class: "bar-done", group: "S1", baseline_start: "2026-09-08", baseline_end: "2026-09-18" },
		{ id: "s1-rf21", name: "S1: RF21 Galeria multimídia", start: "2026-09-10", end: "2026-09-12", progress: 100, custom_class: "bar-done", group: "S1", baseline_start: "2026-09-10", baseline_end: "2026-09-18" },
		{ id: "s1-content-done", name: "S1: Coleta inicial grade/docentes", start: "2026-09-04", end: "2026-09-16", progress: 100, custom_class: "bar-done", group: "S1", baseline_start: "2026-09-04", baseline_end: "2026-09-18" },

		/* —— S2 —— */
		{
			id: "sum-s2",
			name: "S2 — P&E e Docentes",
			start: "2026-09-19",
			end: "2026-10-01",
			progress: 100,
			custom_class: "bar-summary",
			group: "S2",
			summary: true,
			baseline_start: "2026-09-19",
			baseline_end: "2026-10-03"
		},
		{ id: "s2-rf09", name: "S2: RF09 Projetos pesquisa", start: "2026-09-19", end: "2026-09-23", progress: 100, custom_class: "bar-done", group: "S2", baseline_start: "2026-09-19", baseline_end: "2026-10-03" },
		{ id: "s2-rf10", name: "S2: RF10 Iniciação científica", start: "2026-09-22", end: "2026-09-25", progress: 100, custom_class: "bar-done", group: "S2", baseline_start: "2026-09-19", baseline_end: "2026-10-03" },
		{ id: "s2-rf11-done", name: "S2: RF11 Hub P&E — listagens", start: "2026-09-19", end: "2026-09-30", progress: 100, custom_class: "bar-done", group: "S2", baseline_start: "2026-09-19", baseline_end: "2026-10-03" },
		{ id: "s2-pop-done", name: "S2: População docente — lote inicial", start: "2026-09-24", end: "2026-10-01", progress: 100, custom_class: "bar-done", group: "S2", baseline_start: "2026-09-22", baseline_end: "2026-10-03" },

		/* —— S3 —— */
		{
			id: "sum-s3",
			name: "S3 — Fábrica e Serviços",
			start: "2026-10-04",
			end: "2026-10-15",
			progress: 100,
			custom_class: "bar-summary",
			group: "S3",
			summary: true,
			baseline_start: "2026-10-04",
			baseline_end: "2026-10-18"
		},
		{ id: "s3-rf25-done", name: "S3: RF25 Repositório TCC — busca/página/PDF", start: "2026-10-04", end: "2026-10-15", progress: 100, custom_class: "bar-done", group: "S3", baseline_start: "2026-10-04", baseline_end: "2026-10-18" },

		/* —— S4 —— */
		{
			id: "sum-s4",
			name: "S4 — Transversal",
			start: "2026-10-19",
			end: "2026-11-04",
			progress: 100,
			custom_class: "bar-summary",
			group: "S4",
			summary: true,
			baseline_start: "2026-10-19",
			baseline_end: "2026-11-02"
		},
		{ id: "s4-rf28-done", name: "S4: RF28 Ouvidoria — formulário base", start: "2026-10-19", end: "2026-10-23", progress: 100, custom_class: "bar-done", group: "S4", baseline_start: "2026-10-19", baseline_end: "2026-11-02" },
		{ id: "s4-rf30-done", name: "S4: RF30–32 Admin, perfis e menus", start: "2026-10-20", end: "2026-10-28", progress: 100, custom_class: "bar-done", group: "S4", baseline_start: "2026-10-19", baseline_end: "2026-11-02" },
		{ id: "s4-rf33-done", name: "S4: RF33 Busca global — indexação", start: "2026-10-22", end: "2026-10-29", progress: 100, custom_class: "bar-done", group: "S4", baseline_start: "2026-10-19", baseline_end: "2026-11-02" },
		{ id: "s4-rf34-done", name: "S4: RF34 Sitemap / SEO — base", start: "2026-10-31", end: "2026-11-04", progress: 100, dependencies: "s4-rf33-done", custom_class: "bar-done", group: "S4", baseline_start: "2026-10-22", baseline_end: "2026-11-02" },
		{ id: "s4-rnf-done", name: "S4: RNF A11y, LGPD, performance — checklist", start: "2026-10-19", end: "2026-10-29", progress: 100, custom_class: "bar-done", group: "S4", baseline_start: "2026-10-19", baseline_end: "2026-11-02" },
		{ id: "s4-pop-done", name: "S4: População dados — segundo lote", start: "2026-10-27", end: "2026-11-03", progress: 100, custom_class: "bar-done", group: "S4", baseline_start: "2026-10-19", baseline_end: "2026-11-02" },

		{ id: "buf-gap-nov", name: "Pausa técnica — demandas externas / outro projeto", start: "2026-11-05", end: "2026-11-17", progress: 100, custom_class: "bar-buffer", group: "Contingência" },

		/* —— S5 — realizado (Oracle). Baseline = plano antigo (CEFET / go-live 15/11) —— */
		{
			id: "sum-s5",
			name: "S5 — Go-live Oracle",
			start: "2026-11-19",
			end: "2026-11-27",
			progress: 8,
			custom_class: "bar-summary",
			group: "S5",
			summary: true,
			baseline_start: "2026-11-03",
			baseline_end: "2026-11-15"
		},
		{ id: "s5-prep", name: "S5: Preparar VM Oracle (padrão da homologação)", start: "2026-11-19", end: "2026-11-21", progress: 15, dependencies: "buf-gap-nov", custom_class: "bar-critical", group: "S5", baseline_start: "2026-11-03", baseline_end: "2026-11-05" },
		{ id: "s5-deploy", name: "S5: Publicar na Oracle Always Free", start: "2026-11-23", end: "2026-11-23", progress: 0, dependencies: "s5-prep", custom_class: "bar-critical", group: "S5", baseline_start: "2026-11-03", baseline_end: "2026-11-08" },
		{ id: "s5-test", name: "S5: Teste do portal publicado", start: "2026-11-25", end: "2026-11-25", progress: 0, dependencies: "s5-deploy", custom_class: "bar-critical", group: "S5", baseline_start: "2026-11-03", baseline_end: "2026-11-10" },
		{ id: "s5-cred", name: "S5: Credenciais dos professores", start: "2026-11-25", end: "2026-11-25", progress: 0, dependencies: "s5-deploy", custom_class: "bar-critical", group: "S5", baseline_start: "2026-11-12", baseline_end: "2026-11-14" },
		{ id: "m2-product", name: "M2 — Go-live Oracle + credenciais", start: "2026-11-27", end: "2026-11-27", progress: 0, dependencies: "s5-cred,s5-test", custom_class: "bar-milestone", group: "S5", baseline_start: "2026-11-15", baseline_end: "2026-11-15" },

		/* —— S6 —— */
		{
			id: "sum-s6",
			name: "S6 — Entrega acadêmica",
			start: "2026-11-23",
			end: "2026-11-30",
			progress: 0,
			custom_class: "bar-summary",
			group: "S6",
			summary: true,
			baseline_start: "2026-11-16",
			baseline_end: "2026-11-30"
		},
		{ id: "s6-doc", name: "S6: DEPLOY e BACKUP desta publicação", start: "2026-11-23", end: "2026-11-28", progress: 0, dependencies: "s5-prep", custom_class: "bar-planned", group: "S6", baseline_start: "2026-11-16", baseline_end: "2026-11-25" },
		{ id: "s6-pres", name: "S6: Apresentação da disciplina", start: "2026-11-26", end: "2026-11-28", progress: 0, dependencies: "s5-deploy", custom_class: "bar-planned", group: "S6", baseline_start: "2026-11-23", baseline_end: "2026-11-29" },
		{ id: "m3-academic", name: "M3 — Entrega acadêmica", start: "2026-11-30", end: "2026-11-30", progress: 0, dependencies: "s6-pres,m2-product", custom_class: "bar-milestone", group: "S6", baseline_start: "2026-11-30", baseline_end: "2026-11-30" },

		/* —— Contingência —— */
		{
			id: "sum-buf",
			name: "Contingência e paralisadas",
			start: "2026-11-05",
			end: "2026-12-12",
			progress: 0,
			custom_class: "bar-summary",
			group: "Contingência",
			summary: true
		},
		{ id: "s1-rf03-pause", name: "Paralisada: RF03 validação coordenação / ementas", start: "2026-12-01", end: "2026-12-03", progress: 0, custom_class: "bar-paused", group: "Contingência" },
		{ id: "s1-content-pause", name: "Paralisada: coleta complementar (dado externo)", start: "2026-12-01", end: "2026-12-03", progress: 0, custom_class: "bar-paused", group: "Contingência" },
		{ id: "s2-rf11-pause", name: "Paralisada: RF11 convênios reais", start: "2026-12-01", end: "2026-12-04", progress: 0, custom_class: "bar-paused", group: "Contingência" },
		{ id: "s2-rf12-pause", name: "Paralisada: RF12 import planilha docentes", start: "2026-12-01", end: "2026-12-05", progress: 0, custom_class: "bar-paused", group: "Contingência", baseline_start: "2026-09-19", baseline_end: "2026-10-03" },
		{ id: "s2-pop-pause", name: "Paralisada: população docente restante", start: "2026-12-03", end: "2026-12-08", progress: 0, custom_class: "bar-paused", group: "Contingência" },
		{ id: "s3-rf25-pause", name: "Paralisada: RF25 lista real de TCCs", start: "2026-12-01", end: "2026-12-04", progress: 0, custom_class: "bar-paused", group: "Contingência" },
		{ id: "s3-rf15-pause", name: "Paralisada: RF15 Showcase excelência", start: "2026-12-01", end: "2026-12-05", progress: 0, custom_class: "bar-paused", group: "Contingência", baseline_start: "2026-10-04", baseline_end: "2026-10-18" },
		{ id: "s3-rf16-pause", name: "Paralisada: RF16 Formulário parceiros", start: "2026-12-05", end: "2026-12-09", progress: 0, custom_class: "bar-paused", group: "Contingência", baseline_start: "2026-10-04", baseline_end: "2026-10-18" },
		{ id: "s3-rf23-pause", name: "Paralisada: RF23 Serviços acadêmicos", start: "2026-12-01", end: "2026-12-05", progress: 0, custom_class: "bar-paused", group: "Contingência", baseline_start: "2026-10-04", baseline_end: "2026-10-18" },
		{ id: "s3-rf24-pause", name: "Paralisada: RF24 Ferramentas digitais", start: "2026-12-03", end: "2026-12-08", progress: 0, custom_class: "bar-paused", group: "Contingência", baseline_start: "2026-10-04", baseline_end: "2026-10-18" },
		{ id: "s4-rf28-pause", name: "Paralisada: RF28 prazo/integração ouvidoria", start: "2026-12-01", end: "2026-12-03", progress: 0, custom_class: "bar-paused", group: "Contingência" },
		{ id: "s4-rf30-pause", name: "Paralisada: RF30–32 ajuste fino operação", start: "2026-12-01", end: "2026-12-03", progress: 0, custom_class: "bar-paused", group: "Contingência" },
		{ id: "s4-rf33-pause", name: "Paralisada: RF33 cobertura residual da busca", start: "2026-12-01", end: "2026-12-03", progress: 0, custom_class: "bar-paused", group: "Contingência" },
		{ id: "s4-rf34-pause", name: "Paralisada: RF34 SEO / sitemap residual", start: "2026-12-03", end: "2026-12-05", progress: 0, custom_class: "bar-paused", group: "Contingência" },
		{ id: "s4-rnf-pause", name: "Paralisada: RNF Lighthouse / polimento", start: "2026-12-01", end: "2026-12-04", progress: 0, custom_class: "bar-paused", group: "Contingência" },
		{ id: "s4-pop-pause", name: "Paralisada: população dados — pico restante", start: "2026-12-04", end: "2026-12-09", progress: 0, custom_class: "bar-paused", group: "Contingência" },
		{ id: "s1-ti-pause", name: "Paralisada: TI CEFET — primeiro contato", start: "2026-12-01", end: "2026-12-05", progress: 0, custom_class: "bar-paused", group: "Contingência", baseline_start: "2026-09-04", baseline_end: "2026-09-18" },
		{ id: "s4-ti-pause", name: "Paralisada: servidor institucional CEFET", start: "2026-12-05", end: "2026-12-12", progress: 0, custom_class: "bar-paused", group: "Contingência", baseline_start: "2026-10-19", baseline_end: "2026-11-02" },
		{ id: "buf-dec", name: "Reserva — ajuste pós-feedback e domínio", start: "2026-12-02", end: "2026-12-12", progress: 0, dependencies: "m3-academic", custom_class: "bar-planned", group: "Contingência", baseline_start: "2026-12-01", baseline_end: "2026-12-31" }
	],
	groups: ["S0", "S1", "S2", "S3", "S4", "S5", "S6", "Contingência"]
};
