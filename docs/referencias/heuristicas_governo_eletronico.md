# Heurísticas de Usabilidade para Governo Eletrônico

## Metadados do Documento

- **Título original:** Especificação Final das Heurísticas para Governo Eletrônico
- **Domínio:** Usabilidade e Interação Humano-Computador (IHC) aplicada a portais de governo eletrônico (e-gov)
- **Finalidade:** Conjunto de 12 heurísticas especializadas para avaliação e projeto de interfaces de serviços públicos digitais no Brasil
- **Base teórica:** Adaptação e extensão das 10 heurísticas de Nielsen (1994) com acréscimo de heurísticas específicas para o contexto governamental
- **Público-alvo das heurísticas:** Avaliadores, designers e desenvolvedores de portais e serviços de governo eletrônico
- **Contexto de uso deste documento:** Referência técnica para avaliação heurística de usabilidade em sistemas de e-gov

---

## Contextualização para Uso por LLMs

> **Nota para processamento automatizado:** Este documento define 12 heurísticas numeradas (H1–H12). Cada heurística possui nome, descrição funcional e conjunto de perguntas de verificação (checklist). As heurísticas H1–H10 são adaptações das heurísticas de Nielsen para o contexto de governo eletrônico. As heurísticas H11 e H12 são originais, criadas especificamente para este domínio. O documento pode ser usado para: (1) avaliar interfaces de e-gov, (2) guiar projetos de design de serviços públicos digitais, (3) treinar avaliadores em usabilidade governamental, (4) embasar pesquisas acadêmicas em IHC e e-gov.

---

## Heurística H1 — Visibilidade do Status do Sistema

**Definição:** O sistema deve sempre manter os usuários informados sobre o que está ocorrendo, através de feedback apropriado dentro de um tempo razoável.

**Aplicação no contexto de e-gov:** Em portais governamentais, o cidadão precisa saber em que etapa de um processo ou serviço se encontra, qual o andamento de solicitações e qual o status de transações realizadas.

### Perguntas de Verificação (Checklist H1)

1. O sistema informa ao usuário o que está acontecendo durante o processamento de solicitações?
2. O sistema fornece feedback imediato após ações do usuário?
3. O sistema indica claramente o progresso em processos multi-etapas (ex.: cadastros, solicitações de serviços)?
4. O sistema informa o usuário sobre erros ocorridos e como corrigi-los?
5. O sistema apresenta confirmações após a conclusão de tarefas importantes?
6. O sistema indica o tempo estimado para conclusão de processos demorados?

---

## Heurística H2 — Correspondência entre o Sistema e o Mundo Real

**Definição:** O sistema deve falar a linguagem do usuário, com palavras, frases e conceitos familiares ao cidadão, em vez de termos orientados ao sistema. Deve seguir convenções do mundo real, apresentando as informações em ordem natural e lógica.

**Aplicação no contexto de e-gov:** Portais governamentais frequentemente utilizam jargão técnico-burocrático ou jurídico que dificulta a compreensão pelo cidadão comum. A linguagem deve ser simples, direta e acessível.

### Perguntas de Verificação (Checklist H2)

1. O sistema utiliza linguagem compreensível para o cidadão comum, evitando jargão técnico e burocrático?
2. Os termos utilizados correspondem aos conceitos que os cidadãos usam no cotidiano?
3. As metáforas e ícones utilizados são familiares e compreensíveis para o público-alvo?
4. A ordem de apresentação das informações segue uma lógica natural para o usuário?
5. O sistema evita siglas e abreviações sem explicação?
6. Quando termos técnicos são necessários, o sistema fornece explicações adequadas?

---

## Heurística H3 — Controle e Liberdade do Usuário

**Definição:** Usuários frequentemente escolhem funções do sistema por engano e precisam de "saída de emergência" claramente marcada para sair do estado indesejado sem ter que percorrer um diálogo extenso. O sistema deve suportar desfazer e refazer ações.

**Aplicação no contexto de e-gov:** O cidadão deve poder cancelar operações, retornar a etapas anteriores em formulários e corrigir informações sem perder o trabalho já realizado.

### Perguntas de Verificação (Checklist H3)

1. O usuário pode cancelar operações em andamento facilmente?
2. O sistema permite que o usuário retorne a etapas anteriores em processos multi-etapas?
3. O sistema preserva dados já inseridos quando o usuário navega entre etapas?
4. Existe a possibilidade de desfazer ações realizadas?
5. O usuário pode sair de qualquer ponto do sistema sem consequências não desejadas?
6. O sistema solicita confirmação antes de executar ações irreversíveis?

---

## Heurística H4 — Consistência e Padronização

**Definição:** Usuários não devem ter que se perguntar se diferentes palavras, situações ou ações significam a mesma coisa. O sistema deve seguir convenções da plataforma e manter consistência interna.

**Aplicação no contexto de e-gov:** Portais governamentais frequentemente são compostos por sistemas heterogêneos desenvolvidos por diferentes equipes. A consistência visual, terminológica e de interação é essencial para a experiência do cidadão.

### Perguntas de Verificação (Checklist H4)

1. O sistema mantém consistência visual (cores, fontes, layouts) em todas as suas páginas?
2. Termos e rótulos são usados de forma consistente em todo o portal?
3. Elementos de interação (botões, links, formulários) se comportam de forma previsível e consistente?
4. O sistema segue padrões e convenções estabelecidos para portais governamentais?
5. Ícones e símbolos têm o mesmo significado em todo o sistema?
6. A navegação segue padrões consistentes em todas as seções do portal?

---

## Heurística H5 — Prevenção de Erros

**Definição:** Melhor do que boas mensagens de erro é um design cuidadoso que previne a ocorrência de problemas em primeiro lugar. O sistema deve eliminar condições propensas a erros ou verificá-las e apresentar ao usuário uma opção de confirmação antes de executar a ação.

**Aplicação no contexto de e-gov:** Em serviços governamentais, erros podem ter consequências sérias (perda de prazos, dados incorretos em cadastros, retrabalho burocrático). A prevenção de erros é especialmente crítica neste contexto.

### Perguntas de Verificação (Checklist H5)

1. O sistema valida dados em tempo real durante o preenchimento de formulários?
2. O sistema fornece exemplos e orientações antes do preenchimento de campos críticos?
3. O sistema utiliza restrições de entrada (máscaras, listas de seleção) para evitar erros de digitação?
4. O sistema alerta o usuário antes de ações com consequências importantes ou irreversíveis?
5. O sistema verifica a consistência dos dados inseridos antes de prosseguir?
6. Campos obrigatórios são claramente identificados antes que o usuário tente submeter o formulário?

---

## Heurística H6 — Reconhecimento em vez de Memorização

**Definição:** Minimizar a carga de memória do usuário tornando objetos, ações e opções visíveis. O usuário não deve ter que lembrar informações de uma parte do diálogo para outra. Instruções de uso do sistema devem estar visíveis ou facilmente acessíveis.

**Aplicação no contexto de e-gov:** Cidadãos acessam portais governamentais esporadicamente e para tarefas específicas. O sistema não deve exigir que o usuário memorize procedimentos ou informações entre sessões ou entre diferentes etapas de um processo.

### Perguntas de Verificação (Checklist H6)

1. O sistema apresenta as opções disponíveis de forma visível, sem exigir que o usuário as memorize?
2. Informações necessárias para completar uma tarefa estão disponíveis no contexto da tarefa?
3. O sistema oferece histórico de ações ou solicitações anteriores do cidadão?
4. Instruções e orientações estão disponíveis durante a realização das tarefas, não apenas no início?
5. O sistema utiliza listas suspensas, autocomplete e sugestões para reduzir a necessidade de digitação?
6. Informações de progresso (ex.: etapa atual em um processo) são sempre visíveis?

---

## Heurística H7 — Flexibilidade e Eficiência de Uso

**Definição:** Aceleradores, invisíveis ao usuário novato, frequentemente aumentam a velocidade de interação para o usuário experiente, de modo que o sistema possa atender tanto usuários inexperientes quanto experientes. O sistema deve permitir que os usuários adaptem ações frequentes.

**Aplicação no contexto de e-gov:** O portal deve ser acessível para cidadãos com pouca experiência digital, mas também eficiente para usuários frequentes (servidores públicos, profissionais que utilizam o sistema regularmente).

### Perguntas de Verificação (Checklist H7)

1. O sistema oferece atalhos ou formas aceleradas de acesso para usuários experientes?
2. O sistema se adapta às necessidades de diferentes perfis de usuários (novatos e experientes)?
3. Tarefas frequentes podem ser realizadas de forma eficiente, sem passos desnecessários?
4. O sistema permite personalização ou configuração conforme as preferências do usuário?
5. Recursos avançados estão disponíveis sem prejudicar a simplicidade para usuários básicos?
6. O sistema oferece acesso rápido a serviços ou informações utilizados frequentemente?

---

## Heurística H8 — Estética e Design Minimalista

**Definição:** Diálogos não devem conter informações irrelevantes ou raramente necessárias. Cada unidade extra de informação em um diálogo compete com as unidades relevantes de informação e diminui sua visibilidade relativa.

**Aplicação no contexto de e-gov:** Portais governamentais frequentemente apresentam excesso de informações, menus extensos e páginas sobrecarregadas. O design deve priorizar clareza e objetividade para que o cidadão encontre o que precisa rapidamente.

### Perguntas de Verificação (Checklist H8)

1. As páginas apresentam apenas as informações necessárias para a tarefa em questão?
2. O design visual é limpo e não sobrecarregado com elementos decorativos desnecessários?
3. Menus e listas de opções são concisos e organizados de forma lógica?
4. O sistema evita a duplicação de informações na mesma tela?
5. A hierarquia visual orienta o usuário para as informações e ações mais importantes?
6. O conteúdo textual é conciso e objetivo, sem informações redundantes?

---

## Heurística H9 — Suporte ao Usuário para Reconhecer, Diagnosticar e Recuperar Erros

**Definição:** Mensagens de erro devem ser expressas em linguagem simples (sem códigos), indicar precisamente o problema e sugerir uma solução construtiva.

**Aplicação no contexto de e-gov:** Erros em serviços governamentais devem ser comunicados de forma clara, indicando exatamente o que está errado e como o cidadão pode corrigir a situação, sem gerar frustração ou insegurança.

### Perguntas de Verificação (Checklist H9)

1. As mensagens de erro são escritas em linguagem simples e compreensível para o cidadão?
2. As mensagens de erro indicam claramente qual é o problema?
3. As mensagens de erro sugerem ações concretas para resolver o problema?
4. O sistema evita mensagens de erro técnicas (códigos de erro, mensagens em inglês, stack traces)?
5. As mensagens de erro são apresentadas de forma visível e próxima ao elemento que gerou o erro?
6. O sistema orienta o usuário sobre como obter ajuda adicional quando necessário?

---

## Heurística H10 — Ajuda e Documentação

**Definição:** Mesmo que seja melhor se o sistema puder ser usado sem documentação, pode ser necessário fornecer ajuda e documentação. Tais informações devem ser fáceis de pesquisar, focadas na tarefa do usuário, listar passos concretos a serem realizados e não ser muito extensas.

**Aplicação no contexto de e-gov:** A complexidade dos serviços governamentais frequentemente demanda documentação e ajuda contextual. Esta deve ser clara, orientada à tarefa e facilmente acessível durante a realização de qualquer serviço.

### Perguntas de Verificação (Checklist H10)

1. O sistema oferece ajuda contextual relevante para cada etapa dos processos?
2. A documentação é fácil de encontrar e navegar?
3. O conteúdo de ajuda é orientado à tarefa do usuário, com passos concretos?
4. Perguntas frequentes (FAQ) são disponibilizadas e estão atualizadas?
5. O sistema oferece tutoriais ou guias para serviços complexos?
6. Há informações claras sobre canais de suporte humano (telefone, presencial, chat) quando a ajuda online não for suficiente?

---

## Heurística H11 — Acessibilidade

**Definição (específica para e-gov):** O sistema deve ser acessível a todos os cidadãos, independentemente de suas capacidades físicas, sensoriais ou cognitivas, nível de escolaridade, tipo de dispositivo utilizado ou qualidade da conexão à internet.

**Aplicação no contexto de e-gov:** A acessibilidade em governo eletrônico é um requisito legal e ético. O Estado deve garantir que todos os cidadãos possam acessar serviços públicos digitais, incluindo pessoas com deficiência, idosos, usuários com baixa literacia digital e usuários em regiões com infraestrutura tecnológica limitada.

> **Observação:** Esta heurística é original, desenvolvida especificamente para o contexto de governo eletrônico, sem correspondência direta nas heurísticas de Nielsen.

### Perguntas de Verificação (Checklist H11)

1. O sistema está em conformidade com as diretrizes de acessibilidade web (ex.: WCAG 2.1, e-MAG)?
2. O sistema é utilizável com leitores de tela e outras tecnologias assistivas?
3. O conteúdo pode ser percebido sem depender exclusivamente de uma modalidade sensorial (ex.: apenas cor, apenas áudio)?
4. O sistema funciona adequadamente em diferentes dispositivos (computadores, tablets, smartphones)?
5. O sistema é utilizável em condições de baixa largura de banda?
6. O sistema oferece alternativas para usuários com baixa literacia digital ou dificuldades cognitivas?
7. Textos alternativos são fornecidos para imagens e elementos não textuais?
8. O contraste visual é suficiente para usuários com baixa acuidade visual?

---

## Heurística H12 — Credibilidade e Confiança

**Definição (específica para e-gov):** O sistema deve transmitir credibilidade e gerar confiança no cidadão, por meio de elementos que identifiquem claramente a autoria governamental, garantam a segurança das informações e demonstrem transparência sobre os processos e dados envolvidos.

**Aplicação no contexto de e-gov:** A confiança do cidadão nos serviços digitais governamentais é fundamental para a adoção e uso efetivo do governo eletrônico. O sistema deve comunicar claramente sua origem, responsabilidade, segurança e legalidade.

> **Observação:** Esta heurística é original, desenvolvida especificamente para o contexto de governo eletrônico, sem correspondência direta nas heurísticas de Nielsen.

### Perguntas de Verificação (Checklist H12)

1. O portal identifica claramente o órgão governamental responsável?
2. O sistema comunica de forma visível e compreensível as políticas de privacidade e uso de dados?
3. O sistema utiliza certificação de segurança (HTTPS) e informa o usuário sobre a proteção de seus dados?
4. Informações sobre prazos, responsabilidades e consequências dos serviços são apresentadas de forma transparente?
5. O sistema oferece comprovantes ou protocolos para as transações realizadas?
6. Dados de contato e canais oficiais para esclarecimentos são facilmente acessíveis?
7. O sistema evita elementos que possam gerar desconfiança (ex.: publicidade, links para sites externos não identificados)?
8. Atualizações, manutenções e indisponibilidades são comunicadas proativamente ao cidadão?

---

## Resumo Comparativo das Heurísticas

| Código | Nome | Origem |
|--------|------|--------|
| H1 | Visibilidade do Status do Sistema | Adaptada de Nielsen |
| H2 | Correspondência entre o Sistema e o Mundo Real | Adaptada de Nielsen |
| H3 | Controle e Liberdade do Usuário | Adaptada de Nielsen |
| H4 | Consistência e Padronização | Adaptada de Nielsen |
| H5 | Prevenção de Erros | Adaptada de Nielsen |
| H6 | Reconhecimento em vez de Memorização | Adaptada de Nielsen |
| H7 | Flexibilidade e Eficiência de Uso | Adaptada de Nielsen |
| H8 | Estética e Design Minimalista | Adaptada de Nielsen |
| H9 | Suporte ao Usuário para Reconhecer, Diagnosticar e Recuperar Erros | Adaptada de Nielsen |
| H10 | Ajuda e Documentação | Adaptada de Nielsen |
| H11 | Acessibilidade | **Original — específica para e-gov** |
| H12 | Credibilidade e Confiança | **Original — específica para e-gov** |

---

## Referências Base

- **Nielsen, J. (1994).** Heuristic evaluation. In Nielsen, J., & Mack, R. L. (Eds.), *Usability Inspection Methods*. John Wiley & Sons.
- Diretrizes de Acessibilidade para Conteúdo Web — **WCAG 2.1** (W3C)
- Modelo de Acessibilidade em Governo Eletrônico — **e-MAG** (Brasil)
