/**
 * Dados do Gantt FS II — sprints, atividades e marcos
 * Formato compatível com Frappe Gantt
 */
window.FS2_GANTT = {
	viewMode: "Day",
	milestones: [
		{ date: "2026-09-03", label: "M1 — Charter acadêmico", class: "milestone-charter" },
		{ date: "2026-11-27", label: "M2 — Go-live Oracle + credenciais", class: "milestone-product" },
		{ date: "2026-11-30", label: "M3 — Entrega acadêmica", class: "milestone-academic" }
	],
	tasks: [
		/* Sprint 0 */
		{ id: "s0-charter", name: "S0: Redigir Project Charter HTML", start: "2026-08-25", end: "2026-08-28", progress: 100, custom_class: "bar-sprint", group: "S0" },
		{ id: "s0-gantt", name: "S0: Gantt interativo + backlog", start: "2026-08-27", end: "2026-08-29", progress: 100, dependencies: "s0-charter", custom_class: "bar-sprint", group: "S0" },
		{ id: "s0-review", name: "S0: Revisão equipe (4 devs)", start: "2026-08-30", end: "2026-09-02", progress: 100, dependencies: "s0-gantt", custom_class: "bar-sprint", group: "S0" },
		{ id: "m1-charter", name: "M1 — Entrega Charter ao professor", start: "2026-09-03", end: "2026-09-03", progress: 100, dependencies: "s0-review", custom_class: "bar-milestone", group: "Marcos" },

		/* Sprint 1 */
		{ id: "s1-rf03", name: "S1: RF03 Grade curricular completa", start: "2026-09-04", end: "2026-09-18", progress: 90, dependencies: "m1-charter", custom_class: "bar-content", group: "S1" },
		{ id: "s1-rf07", name: "S1: RF07 Vida estudantil", start: "2026-09-04", end: "2026-09-15", progress: 100, dependencies: "m1-charter", custom_class: "bar-content", group: "S1" },
		{ id: "s1-rf26", name: "S1: RF26 Fluxo de disciplinas", start: "2026-09-08", end: "2026-09-18", progress: 100, dependencies: "s1-rf03", custom_class: "bar-content", group: "S1" },
		{ id: "s1-rf21", name: "S1: RF21 Galeria multimídia", start: "2026-09-10", end: "2026-09-18", progress: 100, dependencies: "m1-charter", custom_class: "bar-content", group: "S1" },
		{ id: "s1-ti", name: "S1: Trilha TI — primeiro contato", start: "2026-09-04", end: "2026-09-18", progress: 0, dependencies: "m1-charter", custom_class: "bar-infra", group: "S1" },
		{ id: "s1-content", name: "S1: Coleta conteúdo grade/docentes", start: "2026-09-04", end: "2026-09-18", progress: 70, dependencies: "m1-charter", custom_class: "bar-content", group: "S1" },

		/* Sprint 2 */
		{ id: "s2-rf09", name: "S2: RF09 Projetos pesquisa", start: "2026-09-19", end: "2026-10-03", progress: 100, dependencies: "s1-rf03", custom_class: "bar-content", group: "S2" },
		{ id: "s2-rf10", name: "S2: RF10 Iniciação científica", start: "2026-09-19", end: "2026-10-03", progress: 100, dependencies: "s1-rf03", custom_class: "bar-content", group: "S2" },
		{ id: "s2-rf11", name: "S2: RF11 Hub P&E completo", start: "2026-09-19", end: "2026-10-03", progress: 80, dependencies: "s1-rf03", custom_class: "bar-content", group: "S2" },
		{ id: "s2-rf12", name: "S2: RF12 Import planilha docentes", start: "2026-09-19", end: "2026-10-03", progress: 0, dependencies: "s1-content", custom_class: "bar-content", group: "S2" },
		{ id: "s2-pop", name: "S2: População corpo docente real", start: "2026-09-22", end: "2026-10-03", progress: 20, dependencies: "s2-rf12", custom_class: "bar-content", group: "S2" },

		/* Sprint 3 */
		{ id: "s3-rf15", name: "S3: RF15 Showcase excelência", start: "2026-10-04", end: "2026-10-18", progress: 0, dependencies: "s2-rf11", custom_class: "bar-content", group: "S3" },
		{ id: "s3-rf16", name: "S3: RF16 Formulário parceiros", start: "2026-10-04", end: "2026-10-18", progress: 0, dependencies: "s2-rf11", custom_class: "bar-content", group: "S3" },
		{ id: "s3-rf23", name: "S3: RF23 Serviços acadêmicos", start: "2026-10-04", end: "2026-10-18", progress: 0, dependencies: "s2-rf11", custom_class: "bar-content", group: "S3" },
		{ id: "s3-rf24", name: "S3: RF24 Ferramentas digitais", start: "2026-10-04", end: "2026-10-18", progress: 0, dependencies: "s2-rf11", custom_class: "bar-content", group: "S3" },
		{ id: "s3-rf25", name: "S3: RF25 Repositório TCC", start: "2026-10-04", end: "2026-10-18", progress: 90, dependencies: "s2-rf11", custom_class: "bar-content", group: "S3" },

		/* Sprint 4 */
		{ id: "s4-rf28", name: "S4: RF28 Ouvidoria", start: "2026-10-19", end: "2026-11-02", progress: 40, dependencies: "s3-rf25", custom_class: "bar-content", group: "S4" },
		{ id: "s4-rf30", name: "S4: RF30–32 Admin e menus", start: "2026-10-19", end: "2026-11-02", progress: 70, dependencies: "s3-rf25", custom_class: "bar-content", group: "S4" },
		{ id: "s4-rf33", name: "S4: RF33 Busca global", start: "2026-10-19", end: "2026-11-02", progress: 70, dependencies: "s3-rf25", custom_class: "bar-content", group: "S4" },
		{ id: "s4-rf34", name: "S4: RF34 Sitemap / SEO", start: "2026-10-22", end: "2026-11-02", progress: 40, dependencies: "s4-rf33", custom_class: "bar-content", group: "S4" },
		{ id: "s4-rnf", name: "S4: RNF A11y, LGPD, performance", start: "2026-10-19", end: "2026-11-02", progress: 60, dependencies: "s3-rf25", custom_class: "bar-content", group: "S4" },
		{ id: "s4-ti", name: "S4: Servidor CEFET — não bloqueia o go-live", start: "2026-10-19", end: "2026-11-02", progress: 0, dependencies: "s1-ti", custom_class: "bar-infra", group: "S4" },
		{ id: "s4-pop", name: "S4: População dados reais (pico)", start: "2026-10-19", end: "2026-11-02", progress: 20, dependencies: "s2-pop", custom_class: "bar-content", group: "S4" },

		/* Sprint 5 — replanejada em 19/11. M2 saiu de 15/11. */
		{ id: "s5-prep", name: "S5: Preparar VM Oracle (padrão da homologação)", start: "2026-11-19", end: "2026-11-22", progress: 15, custom_class: "bar-infra", group: "S5" },
		{ id: "s5-deploy", name: "S5: Publicar na Oracle Always Free", start: "2026-11-23", end: "2026-11-25", progress: 0, dependencies: "s5-prep", custom_class: "bar-infra", group: "S5" },
		{ id: "s5-test", name: "S5: Teste do portal publicado", start: "2026-11-24", end: "2026-11-26", progress: 0, dependencies: "s5-deploy", custom_class: "bar-sprint", group: "S5" },
		{ id: "s5-cred", name: "S5: Credenciais dos professores", start: "2026-11-25", end: "2026-11-27", progress: 0, dependencies: "s5-deploy", custom_class: "bar-sprint", group: "S5" },
		{ id: "m2-product", name: "M2 — Go-live Oracle + credenciais", start: "2026-11-27", end: "2026-11-27", progress: 0, dependencies: "s5-cred,s5-test", custom_class: "bar-milestone", group: "Marcos" },

		/* Sprint 6 */
		{ id: "s6-doc", name: "S6: DEPLOY e BACKUP desta publicação", start: "2026-11-23", end: "2026-11-28", progress: 0, dependencies: "s5-deploy", custom_class: "bar-sprint", group: "S6" },
		{ id: "s6-pres", name: "S6: Apresentação da disciplina", start: "2026-11-26", end: "2026-11-30", progress: 0, dependencies: "m2-product", custom_class: "bar-sprint", group: "S6" },
		{ id: "m3-academic", name: "M3 — Entrega acadêmica", start: "2026-11-30", end: "2026-11-30", progress: 0, dependencies: "s6-pres", custom_class: "bar-milestone", group: "Marcos" },

		/* Reserva: só as duas primeiras semanas de dezembro */
		{ id: "buf-dec", name: "Reserva — ajuste pós-feedback e domínio institucional", start: "2026-12-01", end: "2026-12-12", progress: 0, dependencies: "m3-academic", custom_class: "bar-content", group: "Contingência" }
	],
	groups: ["S0", "S1", "S2", "S3", "S4", "S5", "S6", "Marcos", "Contingência"]
};
