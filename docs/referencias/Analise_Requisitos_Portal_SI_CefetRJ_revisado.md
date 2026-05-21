---
title: "Análise de Requisitos — Portal do Curso de Sistemas de Informação"
project: "Portal SI CEFET/RJ"
institution: "CEFET/RJ — Centro Federal de Educação Tecnológica Celso Suckow da Fonseca"
campus: "Maria da Graça — Rio de Janeiro/RJ"
client: "Coordenação do Curso de Sistemas de Informação"
team: "Fábrica de Software — Curso de Sistemas de Informação"
version: "1.0"
status: "em validação"
year: 2025
language: "pt-BR"
platform: "WordPress"
design_system: "Design System do Governo Federal (gov.br)"
document_type: "requirements-analysis"
domain: "institutional-portal"
standards: ["WCAG 2.1 AA", "eMAG", "LGPD"]
id_prefixes:
  RN: "Regra de Negócio"
  RF: "Requisito Funcional"
  RNF: "Requisito Não Funcional"
  RI: "Requisito Inverso"
sections: [identificacao, objetivo, publico-alvo, regras-de-negocio, requisitos-funcionais, requisitos-nao-funcionais, requisitos-inversos, arquitetura, premissas-tecnologicas, cronograma, visao-futura, documentacao, glossario, historico]
---

# Análise de Requisitos — Portal do Curso de Sistemas de Informação

**CEFET/RJ — Campus Maria da Graça**  
Projeto Fábrica de Software · Versão 1.0 · 2025  
Tecnologia: WordPress + Design System do Governo Federal (gov.br)

---

## Sobre este documento

> **Para IAs e sistemas de recuperação:** este documento especifica os requisitos completos para o desenvolvimento do portal institucional do curso de Sistemas de Informação do CEFET/RJ, campus Maria da Graça. Ele é o artefato central de engenharia de requisitos do projeto e deve ser tratado como fonte primária de verdade sobre escopo, regras e restrições.

**O que este documento contém:**

- **Regras de Negócio (RN01–RN12):** políticas e restrições do domínio que o sistema deve respeitar independentemente da tecnologia.
- **Requisitos Funcionais (RF01–RF34):** funcionalidades que o sistema deve oferecer, organizadas em 7 módulos.
- **Requisitos Não Funcionais (RNF01–RNF12):** critérios de qualidade, desempenho, segurança e conformidade legal.
- **Requisitos Inversos (RI01–RI07):** o que está explicitamente fora do escopo desta versão.
- **Arquitetura de informação**, **premissas tecnológicas**, **cronograma** e **visão futura**.

**Premissas fixas (não negociáveis):**

1. A plataforma é **WordPress** (CMS). Toda decisão de implementação parte dessa base.
2. O design segue o **Design System do Governo Federal (gov.br)** — paleta, tipografia e componentes.
3. O portal é **público** (sem login para usuários externos). Apenas a área administrativa exige autenticação.
4. O projeto é conduzido pela **Fábrica de Software** do próprio curso de SI do CEFET/RJ.

**Convenção de prioridade dos requisitos:**

| Prioridade | Significado |
|------------|-------------|
| **Alta**   | Essencial para o lançamento (MVP). O sistema não pode ir ao ar sem este requisito. |
| **Média**  | Importante, mas pode ser entregue em sprint posterior ao lançamento inicial. |
| **Baixa**  | Desejável. Entra apenas se houver folga de cronograma. |

**Convenção de IDs:** todos os identificadores são únicos e estáveis. Use-os para referenciar requisitos em qualquer outro documento, código ou discussão. Formato: `[PREFIXO][NÚMERO DE DOIS DÍGITOS]` — ex: `RF01`, `RN12`, `RNF03`.

---

## Sumário

1. [Identificação do Projeto](#1-identificação-do-projeto)
2. [Objetivo do Projeto](#2-objetivo-do-projeto)
3. [Público-Alvo e Perfis de Usuário](#3-público-alvo-e-perfis-de-usuário)
4. [Regras de Negócio (RN)](#4-regras-de-negócio-rn)
5. [Requisitos Funcionais (RF)](#5-requisitos-funcionais-rf)
   - 5.1 [Módulo Institucional](#51-módulo-institucional)
   - 5.2 [Módulo de Pesquisa e Extensão](#52-módulo-de-pesquisa-e-extensão)
   - 5.3 [Módulo Fábrica de Software](#53-módulo-fábrica-de-software)
   - 5.4 [Módulo de Comunicação Institucional](#54-módulo-de-comunicação-institucional)
   - 5.5 [Módulo de Serviços Digitais](#55-módulo-de-serviços-digitais)
   - 5.6 [Módulo de Contato e Atendimento](#56-módulo-de-contato-e-atendimento)
   - 5.7 [Módulo Administrativo (WordPress)](#57-módulo-administrativo-wordpress)
6. [Requisitos Não Funcionais (RNF)](#6-requisitos-não-funcionais-rnf)
7. [Requisitos Inversos (RI)](#7-requisitos-inversos-ri)
8. [Arquitetura de Informação — Mapa do Site](#8-arquitetura-de-informação--mapa-do-site)
9. [Premissas Tecnológicas](#9-premissas-tecnológicas)
10. [Cronograma de Desenvolvimento](#10-cronograma-de-desenvolvimento)
11. [Visão Futura e Escalabilidade](#11-visão-futura-e-escalabilidade)
12. [Documentação do Projeto](#12-documentação-do-projeto)
13. [Glossário](#13-glossário)
14. [Histórico de Versões](#14-histórico-de-versões)

---

## 1. Identificação do Projeto

> Informações gerais de identificação e contexto do portal.

| Campo                     | Informação                                                                                       |
|---------------------------|--------------------------------------------------------------------------------------------------|
| **Nome do Projeto**       | Portal do Curso de Sistemas de Informação — CEFET/RJ                                            |
| **Cliente / Solicitante** | Coordenação do Curso de SI — Campus Maria da Graça                                              |
| **Unidade Institucional** | CEFET/RJ — Centro Federal de Educação Tecnológica Celso Suckow da Fonseca                      |
| **Campus**                | Maria da Graça — Rio de Janeiro/RJ                                                               |
| **Equipe Responsável**    | Fábrica de Software — Curso de Sistemas de Informação                                           |
| **Plataforma**            | WordPress (CMS) com tema customizado baseado no Design System do Governo Federal                 |
| **Design System Adotado** | Design System do Governo Digital Brasileiro (gov.br) — componentes visuais, tipografia e paleta |
| **Versão do Documento**   | 1.0                                                                                              |
| **Data de Elaboração**    | 2025                                                                                             |
| **Status**                | Em validação com o cliente                                                                       |

---

## 2. Objetivo do Projeto

Desenvolver uma plataforma digital institucional para o curso de Sistemas de Informação do CEFET/RJ — Campus Maria da Graça, capaz de centralizar, organizar e disponibilizar de forma acessível e transparente as informações acadêmicas, administrativas e de extensão do curso.

O portal deverá atender simultaneamente a **quatro funções estratégicas**:

- **Informar** — Apresentar o curso de forma clara e completa para candidatos, famílias e público geral.
- **Converter** — Transformar visitantes em candidatos via SISU, ENEM e processos seletivos.
- **Credibilizar** — Elevar a percepção de qualidade institucional com dados reais de empregabilidade, egressos e estrutura.
- **Apoiar** — Ser portal de referência para alunos e professores (grade curricular, eventos, extensão, serviços).

O sistema será desenvolvido com **WordPress** como CMS e adotará o **Design System do Governo Federal (gov.br)** como base visual e de componentes, garantindo conformidade com padrões de acessibilidade (WCAG 2.1 AA / eMAG) e identidade visual institucional.

---

## 3. Público-Alvo e Perfis de Usuário

O portal atende a quatro perfis distintos de usuário, cada um com necessidades e jornadas específicas.

### 3.1 Candidato / Vestibulandos

- Estudantes do ensino médio e seus responsáveis buscando informações sobre o curso.
- **Necessita:** apresentação do curso, forma de ingresso (SISU/ENEM), grade, infraestrutura, perspectivas de carreira.
- **Jornada esperada:** landing page → informações sobre ingresso → grade → contato.
- **Requisitos principais atendidos:** RF01, RF02, RF03, RF05.

### 3.2 Aluno Matriculado

- Aluno ativo do curso, buscando referências acadêmicas, eventos, grade, extensão e serviços.
- **Necessita:** acesso rápido à grade curricular, projetos, notícias, agenda, links institucionais (sistema acadêmico, chamados).
- **Jornada esperada:** acesso direto via busca ou links frequentes.
- **Requisitos principais atendidos:** RF03, RF17, RF20, RF22, RF25, RF26.

### 3.3 Professor / Corpo Docente

- Docentes do curso com interesse em divulgar pesquisas, projetos e informações de contato.
- **Necessita:** gestão do próprio perfil, divulgação de projetos e linhas de pesquisa.
- **Jornada esperada:** área administrativa (WordPress) para gestão de conteúdo.
- **Requisitos principais atendidos:** RF08, RF09, RF12, RF30, RF31.

### 3.4 Comunidade Externa / Parceiros

- Empresas, pesquisadores, instituições parceiras e comunidade geral.
- **Necessita:** informações sobre a Fábrica de Software, projetos desenvolvidos, formas de contato/parceria.
- **Jornada esperada:** home → fábrica de software ou projetos → canal de contato.
- **Requisitos principais atendidos:** RF13, RF14, RF16, RF27.

---

## 4. Regras de Negócio (RN)

As regras de negócio definem as políticas, restrições e diretrizes que o sistema deve respeitar, independentemente da tecnologia utilizada.

> **Nota para IAs:** as regras de negócio têm precedência sobre os requisitos funcionais. Um RF que entre em conflito com uma RN deve ser ajustado para conformidade com a RN, não o contrário.

| ID       | Regra de Negócio                                                                                                                                                                                                                                         | Impacto                    | RF / RNF Relacionado               |
|----------|----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|----------------------------|------------------------------------|
| **RN01** | O conteúdo do portal somente poderá ser criado, editado ou excluído por usuários devidamente autorizados (perfis: Administrador ou Editor) cadastrados no WordPress.                                                                                   | Operacional / Segurança    | RF05, RF06, RF07, RF19, RF30, RF31 |
| **RN02** | O portal deve seguir a estrutura informacional institucional oficial: apresentação do curso, grade curricular, corpo docente, projetos, pesquisa e extensão.                                                                                            | Estrutural / Institucional | RF01–RF10                          |
| **RN03** | Toda informação publicada deve estar em conformidade com os dados oficiais fornecidos pela Coordenação. O conteúdo de perfis de professores será alimentado a partir de planilha de dados gerenciada pela coordenação.                                   | Qualidade / Dados          | RF08, RF12                         |
| **RN04** | O Design System do Governo Federal (gov.br) deve ser aplicado consistentemente em todos os componentes visuais do portal: paleta de cores, tipografia, cabeçalho, rodapé, barra de acessibilidade e botões.                                             | Identidade Visual          | RNF01, RNF02                       |
| **RN05** | Informações sobre disciplinas, professores, projetos e infraestrutura devem ser exibidas de forma clara, organizada e estruturada, respeitando hierarquias de navegação definidas na arquitetura de informação (Seção 8).                                | Usabilidade                | RF08, RF09, RF10, RF26             |
| **RN06** | A maior parte do conteúdo do portal será de acesso público, sem exigência de autenticação. A área administrativa (WordPress admin) exige login e senha.                                                                                                  | Acesso / Segurança         | RNF04, RI01                        |
| **RN07** | Conteúdos desatualizados devem ser revisados ou removidos periodicamente. A coordenação é responsável por indicar o conteúdo a ser atualizado; os editores são responsáveis pela implementação.                                                          | Governança de Conteúdo     | RF06, RF07                         |
| **RN08** | O portal não deverá incluir funcionalidades de matrícula, lançamento de notas, boletins ou qualquer funcionalidade de sistema acadêmico completo. Esses serviços serão referenciados via link externo.                                                  | Escopo / Restrição         | RI02                               |
| **RN09** | A Fábrica de Software do curso deve ter seção exclusiva e destacada no portal, apresentando projetos desenvolvidos e canal de atendimento para parceiros externos.                                                                                       | Negócio / Institucional    | RF13, RF14, RF16                   |
| **RN10** | O portal deve cumprir com os requisitos da LGPD (Lei 13.709/2018), incluindo política de privacidade acessível, aviso de uso de cookies e canal de contato para solicitações de titulares.                                                              | Legal / Compliance         | RNF07                              |
| **RN11** | O calendário acadêmico e agenda de eventos devem refletir o calendário oficial do CEFET/RJ, sendo de responsabilidade da coordenação sua atualização periódica.                                                                                         | Governança                 | RF20                               |
| **RN12** | Os dados de perfil de professores (áreas de atuação, linhas de pesquisa, projetos) serão importados de planilha estruturada via mecanismo PHP nativo do WordPress, eliminando necessidade de input manual campo a campo.                                | Integração / Dados         | RF12                               |

---

## 5. Requisitos Funcionais (RF)

Os requisitos funcionais descrevem as funcionalidades que o sistema deve oferecer, organizados por módulo conforme o escopo aprovado.

> **Nota para IAs:** os 34 RFs estão distribuídos em 7 módulos. Cada RF tem prioridade (Alta / Média — ver legenda na seção "Sobre este documento") e referência ao módulo. As RNs que impõem restrições a cada RF estão indicadas na descrição quando relevante.

---

### 5.1 Módulo Institucional

> Responsável por apresentar as informações gerais, acadêmicas e estruturais do curso. Governa: RN02, RN03, RN07.

| ID       | Descrição                                                                                                                                                                                                                                                     | Prioridade | Módulo        |
|----------|---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|------------|---------------|
| **RF01** | O sistema deve exibir uma **Página Inicial (Home)** com: apresentação resumida do curso, destaques/notícias recentes, números institucionais (empregabilidade, duração, gratuidade) e links de acesso rápido.                                                | Alta       | Institucional |
| **RF02** | O sistema deve exibir a **Página Sobre o Curso** com: histórico, objetivos do curso, perfil do egresso, apresentação da coordenação e direção.                                                                                                               | Alta       | Institucional |
| **RF03** | O sistema deve exibir a **Grade Curricular** com a estrutura de disciplinas por período, incluindo fluxo de progressão acadêmica de forma visual e navegável. Ver também RF26 (fluxo interativo complementar).                                               | Alta       | Institucional |
| **RF04** | O sistema deve exibir a **Página de Infraestrutura** com informações sobre laboratórios, biblioteca, espaços de convivência e recursos disponíveis.                                                                                                          | Média      | Institucional |
| **RF05** | O sistema deve exibir a **Página de Ingresso** com informações sobre SISU, ENEM, datas de processo seletivo, documentação necessária e formas de matrícula. Não inclui o processo de matrícula em si (ver RN08 e RI02).                                      | Alta       | Institucional |
| **RF06** | O sistema deve permitir publicação de **Documentos Institucionais** (PDFs e arquivos): projeto pedagógico, regulamentos, resoluções e documentos de transparência. Sujeito a RN01 (apenas usuários autorizados publicam) e RN07 (revisão periódica).         | Alta       | Institucional |
| **RF07** | O sistema deve exibir informações sobre **Bolsas e Auxílios** estudantis disponíveis no CEFET/RJ.                                                                                                                                                            | Média      | Institucional |

---

### 5.2 Módulo de Pesquisa e Extensão

> Foca na divulgação das atividades acadêmicas de pesquisa, extensão e parcerias do curso. Governa: RN03, RN05, RN12.

| ID       | Descrição                                                                                                                                                                                                                                                           | Prioridade | Módulo        |
|----------|---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|------------|---------------|
| **RF08** | O sistema deve exibir uma **Página de Corpo Docente** com perfil de cada professor, contendo: nome, foto, áreas de atuação, linhas de pesquisa, formação acadêmica e projetos vinculados. Os dados são originados via RF12 (importação de planilha, conforme RN12). | Alta       | Pesquisa/Ext. |
| **RF09** | O sistema deve exibir uma **Página de Projetos de Pesquisa e Extensão** com listagem, descrição, responsável e situação (em andamento / concluído).                                                                                                                | Alta       | Pesquisa/Ext. |
| **RF10** | O sistema deve apresentar informações sobre **Programas de Iniciação Científica** disponíveis no curso, com critérios e contatos.                                                                                                                                  | Média      | Pesquisa/Ext. |
| **RF11** | O sistema deve divulgar **Parcerias e Convênios** institucionais vigentes, com logo das organizações parceiras e breve descrição do acordo.                                                                                                                        | Média      | Pesquisa/Ext. |
| **RF12** | Os dados dos perfis de professores devem poder ser **importados a partir de planilha estruturada** (via mecanismo PHP do WordPress), sem necessidade de preenchimento manual campo a campo. Implementa RN12. Os dados resultantes alimentam RF08.                   | Alta       | Pesquisa/Ext. |

---

### 5.3 Módulo Fábrica de Software

> Destina-se à divulgação e valorização da produção prática dos alunos, professores e projetos de parceiros externos. Governa: RN09.

| ID       | Descrição                                                                                                                                                                                                                       | Prioridade | Módulo     |
|----------|---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|------------|------------|
| **RF13** | O sistema deve possuir uma **Página da Fábrica de Software** apresentando sua missão, metodologia de trabalho, equipe e tipos de projeto atendidos. Atende RN09.                                                              | Alta       | Fábrica SW |
| **RF14** | O sistema deve exibir um **Portfólio de Projetos Desenvolvidos** com: nome do projeto, descrição, tecnologias utilizadas, alunos envolvidos e resultado/entrega. Atende RN09.                                                  | Alta       | Fábrica SW |
| **RF15** | O sistema deve destacar **Soluções Acadêmicas Relevantes**, funcionando como showcase de excelência do curso para parceiros e candidatos.                                                                                       | Média      | Fábrica SW |
| **RF16** | O sistema deve disponibilizar um **Canal Exclusivo de Contato para Parceiros Externos** interessados em novos projetos ou projetos em andamento na Fábrica de Software (formulário de demanda). Atende RN09. Ver também RF27.  | Alta       | Fábrica SW |

---

### 5.4 Módulo de Comunicação Institucional

> Responsável pela divulgação de notícias, eventos e conteúdo multimídia do curso. Governa: RN01, RN07, RN11.

| ID       | Descrição                                                                                                                                                                                         | Prioridade | Módulo      |
|----------|---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|------------|-------------|
| **RF17** | O sistema deve exibir uma **listagem de Notícias e Atualizações** com paginação, filtro por categoria e campo de busca. Relaciona-se com RF33 (busca global).                                   | Alta       | Comunicação |
| **RF18** | O sistema deve permitir a **visualização de uma notícia completa** ao clicar na listagem (página de detalhe do post).                                                                            | Alta       | Comunicação |
| **RF19** | Usuários autorizados devem poder **criar, editar e excluir notícias** via painel WordPress (editor de blocos Gutenberg). Sujeito a RN01 e RN07.                                                  | Alta       | Comunicação |
| **RF20** | O sistema deve exibir uma **Agenda de Eventos e Calendário Acadêmico** com visualização mensal e detalhamento de eventos ao clicar. Conteúdo deve refletir calendário oficial (RN11).           | Alta       | Comunicação |
| **RF21** | O sistema deve disponibilizar uma **Galeria Multimídia** (fotos e vídeos) organizada por evento ou categoria.                                                                                    | Média      | Comunicação |

---

### 5.5 Módulo de Serviços Digitais

> Centraliza o acesso a recursos e ferramentas úteis para alunos e professores. Governa: RN06, RN08.

| ID       | Descrição                                                                                                                                                                                                         | Prioridade | Módulo   |
|----------|-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|------------|----------|
| **RF22** | O sistema deve disponibilizar **links de acesso rápido** a serviços externos: Área do Aluno, Área do Professor e Sistema de Abertura de Chamados. Os sistemas em si não são implementados aqui (RN08 e RI02).   | Alta       | Serviços |
| **RF23** | O sistema deve listar e descrever os **Serviços Acadêmicos disponíveis** (secretaria, biblioteca, SAE, etc.) com contatos e horários.                                                                            | Média      | Serviços |
| **RF24** | O sistema deve divulgar **Benefícios e Ferramentas** disponíveis para alunos: licenças educacionais (GitHub Student Pack, Figma Education, etc.).                                                                | Média      | Serviços |
| **RF25** | O sistema deve disponibilizar um **Repositório de TCCs** (Trabalhos de Conclusão de Curso), com busca por título, autor e ano. Relaciona-se com RF33 (busca global).                                            | Alta       | Serviços |
| **RF26** | O sistema deve exibir o **Fluxo de Disciplinas** de forma visual, permitindo ao aluno visualizar a progressão e pré-requisitos de cada matéria. Complementa RF03 (grade curricular).                             | Alta       | Serviços |

---

### 5.6 Módulo de Contato e Atendimento

> Permite a comunicação entre usuários e a instituição. Governa: RN10 (LGPD aplicada a formulários).

| ID       | Descrição                                                                                                                                                                                 | Prioridade | Módulo  |
|----------|-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|------------|---------|
| **RF27** | O sistema deve exibir uma **Página de Contato** com: endereço, telefones, e-mail institucional, horário de atendimento e mapa integrado (Google Maps embed).                            | Alta       | Contato |
| **RF28** | O sistema deve disponibilizar um **Canal de Ouvidoria** com formulário de envio e informação sobre prazo de resposta. Sujeito a RN10 (LGPD).                                             | Média      | Contato |
| **RF29** | O sistema deve exibir **informações de contato da coordenação** de forma destacada na página de contato e no rodapé. Relaciona-se com RF27.                                              | Alta       | Contato |

---

### 5.7 Módulo Administrativo (WordPress)

> Governa o painel de gestão de conteúdo. Aplica RN01 e RN06. Restrições de acesso implementadas via RNF04.

| ID       | Descrição                                                                                                                                                                                                        | Prioridade | Módulo  |
|----------|------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|------------|---------|
| **RF30** | O sistema deve possuir **Área Administrativa** (painel WordPress) para criação, edição e exclusão de conteúdos por usuários autorizados. Implementa RN01.                                                      | Alta       | Adm. WP |
| **RF31** | O sistema deve implementar **Controle de Perfis e Permissões**: perfil Administrador (acesso total) e Editor (gestão de conteúdo sem acesso a configurações técnicas). Implementa RN01 e RN06.                  | Alta       | Adm. WP |
| **RF32** | O sistema deve possuir **Menu de Navegação Principal** configurável via WordPress (Menus), com suporte a submenus e itens personalizados.                                                                        | Alta       | Adm. WP |
| **RF33** | O sistema deve implementar **Busca Global** de conteúdo acessível em todas as páginas, retornando resultados de notícias, documentos, projetos e professores. Relaciona-se com RF17 e RF25.                    | Alta       | Adm. WP |
| **RF34** | O sistema deve gerar **Sitemap XML** automaticamente para indexação em mecanismos de busca (via plugin SEO). Implementa RNF09.                                                                                   | Média      | Adm. WP |

---

## 6. Requisitos Não Funcionais (RNF)

Os requisitos não funcionais estabelecem os critérios de qualidade, desempenho, segurança e conformidade que o sistema deve atender.

> **Nota para IAs:** RNFs são transversais — afetam todos os módulos simultaneamente. Não são opcionais; são condições de aceitação do sistema. RNF01, RNF02 e RNF03 derivam diretamente das premissas fixas do projeto (Design System gov.br e padrões de acessibilidade pública).

| ID        | Requisito                           | Critério de Aceitação                                                                                                                                                                                                   | Categoria       |
|-----------|-------------------------------------|-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|-----------------|
| **RNF01** | Usabilidade — Design System gov.br  | O portal deve implementar integralmente os componentes visuais, tipografia, paleta de cores e padrões de interação do Design System do Governo Federal (gov.br). Decorre de RN04.                                       | Usabilidade     |
| **RNF02** | Responsividade                      | O site deve ser totalmente funcional e visualmente adequado em dispositivos móveis (320px+), tablets e desktops. Layout mobile-first com breakpoints conforme o Design System gov.br.                                    | Usabilidade     |
| **RNF03** | Acessibilidade                      | O portal deve atender ao nível AA da WCAG 2.1 e ao eMAG. Deve incluir: barra de acessibilidade (contraste, tamanho de fonte, VLibras), textos alternativos em imagens e navegação por teclado.                         | Acessibilidade  |
| **RNF04** | Segurança — Autenticação            | A área administrativa WordPress deve exigir autenticação por login e senha. Recomenda-se 2FA para Administradores. Aplica RN06. Protege RF30 e RF31.                                                                    | Segurança       |
| **RNF05** | Compatibilidade de Navegadores      | O portal deve funcionar corretamente em: Chrome (atual–2), Firefox (atual–2), Edge (atual–2) e Safari (atual–2). Internet Explorer **não** é suportado.                                                                 | Compatibilidade |
| **RNF06** | Manutenibilidade                    | O sistema deve permitir atualização de conteúdo de forma autônoma pelo cliente via painel WordPress, sem necessidade de intervenção técnica para tarefas editoriais rotineiras.                                          | Manutenção      |
| **RNF07** | Conformidade LGPD                   | O portal deve exibir aviso de cookies na primeira visita, disponibilizar Política de Privacidade no rodapé e possuir canal de contato para solicitações de titulares de dados. Aplica RN10. Relaciona-se com RF28.      | Legal           |
| **RNF08** | Performance                         | O portal deve atingir pontuação mínima de **70 no Google PageSpeed Insights** (mobile e desktop). Imagens devem ser entregues em formato WebP. Cache de página deve estar habilitado.                                   | Performance     |
| **RNF09** | SEO Básico                          | O WordPress deve estar configurado com plugin SEO (Yoast SEO ou Rank Math) para gestão de meta title, meta description, Open Graph, sitemap XML e robots.txt. Implementado via RF34.                                    | SEO             |
| **RNF10** | Acessibilidade de Links Externos    | Links externos devem abrir em nova aba com atributo `rel="noopener noreferrer"` e indicação visual de link externo. Relaciona-se com RF22.                                                                               | Segurança / UX  |
| **RNF11** | HTTPS / TLS                         | O portal deve ser servido exclusivamente via HTTPS com certificado TLS válido. O acesso via HTTP deve ser redirecionado automaticamente para HTTPS.                                                                      | Segurança       |
| **RNF12** | Backup e Recuperação                | Deve ser configurada rotina de backup automático do banco de dados e arquivos do WordPress com frequência mínima **semanal**, com retenção de pelo menos **30 dias**.                                                    | Disponibilidade |

---

## 7. Requisitos Inversos (RI)

Definem o que está **explicitamente fora do escopo** desta versão do projeto, evitando ambiguidades e retrabalho.

> **Nota para IAs:** se uma solicitação ou decisão de implementação conflitar com algum RI, ela deve ser recusada ou escalada para revisão de escopo com o cliente. RIs não são omissões — são decisões deliberadas de escopo.

| ID       | O sistema **NÃO** deve / **NÃO** terá                                                                       | Justificativa                                                                                                                               | RN / RF que delimita |
|----------|--------------------------------------------------------------------------------------------------------------|---------------------------------------------------------------------------------------------------------------------------------------------|----------------------|
| **RI01** | Cadastro ou área logada para alunos ou público geral.                                                        | O portal é institucional e informativo. Acesso autenticado é restrito à equipe administrativa.                                              | RN06                 |
| **RI02** | Funcionalidades de sistema acadêmico: matrículas, lançamento de notas, boletins, histórico escolar.          | Essas funções pertencem ao sistema acadêmico oficial do CEFET/RJ. O portal referenciará esses sistemas via link (ver RF22).                 | RN08                 |
| **RI03** | Chat em tempo real ou comunicação instantânea entre usuários.                                                | Fora do escopo de um portal institucional informativo.                                                                                      | —                    |
| **RI04** | Integração automática em tempo real com sistemas externos (SIGAA, e-MEC, etc.).                             | Integrações complexas estão previstas para versões futuras. A importação de planilha (professores) via RF12 é a única exceção desta versão.  | RN12                 |
| **RI05** | E-commerce ou qualquer funcionalidade de cobrança ou pagamento.                                              | Incompatível com a natureza pública e gratuita da instituição.                                                                              | —                    |
| **RI06** | Fórum de discussão, comentários abertos ou redes sociais internas.                                           | Evita moderação de conteúdo não prevista no escopo da equipe.                                                                               | —                    |
| **RI07** | App mobile nativo (iOS/Android).                                                                             | O portal será responsivo e acessível via navegador em dispositivos móveis (ver RNF02).                                                      | RNF02                |

---

## 8. Arquitetura de Informação — Mapa do Site

A estrutura do portal organiza-se em dois níveis hierárquicos principais, com elementos globais presentes em todas as páginas.

### 8.1 Elementos Globais de Navegação

Presentes em **todas** as páginas do portal:

- **Cabeçalho (Header):** Logo CEFET/RJ + barra gov.br + menu principal + barra de acessibilidade (alto contraste, tamanho de fonte, VLibras) + busca global. Implementa RNF01, RNF03 e RF32.
- **Breadcrumbs:** presente em todas as páginas internas — ex: `Home › Sobre o Curso › Objetivos`. Implementa RNF03.
- **Rodapé (Footer):** informações de contato, mapa do site, política de privacidade, aviso LGPD, redes sociais. Implementa RNF07, RF29.

### 8.2 Nível 1 — Páginas Principais

| Página                     | Conteúdo principal                                                        | RF principal           |
|----------------------------|---------------------------------------------------------------------------|------------------------|
| 🏠 **Home**                | Apresentação do curso, destaques, números institucionais, acesso rápido   | RF01                   |
| ⭐ **Ingresso**             | SISU, ENEM, processo seletivo, documentação, matrícula                    | RF05                   |
| 📚 **Sobre o Curso**       | Histórico, objetivos, perfil do egresso, PPC, coordenação                 | RF02                   |
| 📋 **Grade Curricular**    | Estrutura por semestre, fluxo de progressão visual                        | RF03, RF26             |
| 👨‍🏫 **Corpo Docente**    | Perfis, áreas, linhas de pesquisa, projetos vinculados                    | RF08, RF12             |
| 🔬 **Pesquisa & Extensão** | Projetos, IC, parcerias, convênios                                        | RF09, RF10, RF11       |
| 💻 **Fábrica de Software** | Apresentação, portfólio, showcase, canal de parceiros                     | RF13, RF14, RF15, RF16 |
| 🏛 **Infraestrutura**      | Laboratórios, biblioteca, recursos                                        | RF04                   |
| 💼 **Carreira & Egressos** | Empregabilidade, egressos, depoimentos                                    | RF02 (seção)           |
| 🎒 **Vida Estudantil**     | Bolsas, auxílios, benefícios, ferramentas, TCCs                           | RF07, RF24, RF25       |
| 📰 **Notícias**            | Listagem, filtro por categoria, busca, artigo completo                    | RF17, RF18, RF19       |
| 📅 **Agenda / Eventos**    | Calendário mensal, detalhe de evento, galeria                             | RF20, RF21             |
| 📞 **Contato**             | Endereço, mapa, formulário, ouvidoria, contato da coordenação             | RF27, RF28, RF29       |

### 8.3 Nível 2 — Páginas de Suporte Legal e Acessibilidade

| Página                        | Finalidade                                          | RF / RNF principal |
|-------------------------------|-----------------------------------------------------|--------------------|
| ♿ **Acessibilidade**          | Descrição dos recursos e declaração de conformidade | RNF03              |
| 🔒 **Política de Privacidade**| Conforme LGPD                                       | RNF07, RN10        |
| 📜 **Termos de Uso**          | Condições de uso do portal                          | RN10               |
| 🗂 **Mapa do Site**           | Índice navegável de todas as páginas                | RF34               |

---

## 9. Premissas Tecnológicas

As escolhas tecnológicas a seguir são **premissas fixas** do projeto, definidas em acordo com o cliente e a equipe da Fábrica de Software. Não estão sujeitas a revisão no escopo desta versão.

### 9.1 WordPress como CMS

- O portal será desenvolvido sobre **WordPress** (última versão estável).
- Editor de conteúdo: **Gutenberg** (editor de blocos nativo).
- Banco de dados: **MySQL / MariaDB**.
- Linguagem: **PHP** (versão compatível com o WordPress adotado).
- Plugins essenciais:
  - SEO: Yoast SEO ou Rank Math → implementa RNF09 e RF34
  - Cache: WP Rocket ou W3 Total Cache → implementa RNF08
  - Segurança: Wordfence ou similar → implementa RNF04, RNF11
  - Formulários: Contact Form 7 ou WPForms → implementa RF16, RF28
  - Backup: UpdraftPlus → implementa RNF12

### 9.2 Design System do Governo Federal (gov.br)

- A identidade visual do portal seguirá o **Design System do Governo Digital Brasileiro**. Implementa RN04 e RNF01.
- **Paleta de cores:**
  - Azul primário: `#1351B4`
  - Azul escuro: `#0C326F`
  - Amarelo institucional: `#FFCD07`
  - Verde: `#168821`
- **Tipografia:** Rawline (corpo de texto) e Raleway (títulos), conforme DS gov.br.
- **Componentes adotados:** cabeçalho padrão gov.br, barra de acessibilidade, botões, cards, formulários, tags e breadcrumbs.
- **Ícones:** Material Icons ou Font Awesome, conforme orientação do DS gov.br.

### 9.3 Importação de Dados — Perfis de Professores

- O mecanismo de importação será desenvolvido via **PHP nativo do WordPress**. Implementa RF12 e RN12.
- A coordenação manterá planilha padronizada (**Google Sheets ou XLSX**) com campos definidos pela equipe.
- O script de importação lerá a planilha e criará/atualizará os posts de professores no WordPress de forma automatizada.
- **Campos mínimos da planilha** (alimentam RF08):
  - Nome
  - Foto (URL ou caminho)
  - Titulação
  - Áreas de Atuação
  - Linhas de Pesquisa
  - E-mail institucional
  - Projetos vinculados (IDs)

---

## 10. Cronograma de Desenvolvimento

O projeto está estruturado em **7 fases** com duração total de aproximadamente **12 semanas**, com buffer estratégico de 10 dias.

| Fase                              | Período        | Duração    | Objetivo                                           |
|-----------------------------------|----------------|------------|----------------------------------------------------|
| **1. Planejamento**               | 01/04 – 07/04  | 1 semana   | Definir escopo, equipe e estratégia                |
| **2. Levantamento de Requisitos** | 08/04 – 21/04  | 2 semanas  | Refinar necessidades do cliente                    |
| **3. Prototipação (UX/UI)**       | 15/04 – 28/04  | 2 semanas  | Criar telas no Figma e validar usabilidade         |
| **4. Desenvolvimento**            | 29/04 – 02/06  | 5 semanas  | Sprints de construção do sistema                   |
| **5. Testes e Ajustes**           | 20/05 – 09/06  | 3 semanas  | Testes funcionais, usabilidade e correção de bugs  |
| **6. População de Dados**         | 03/06 – 16/06  | 2 semanas  | Inserção e validação de conteúdo real              |
| **7. Entrega e Validação Final**  | 17/06 – 22/06  | 1 semana   | Ajustes finais + entrega ao cliente                |

> **Buffer estratégico:** 10 dias calculados no cronograma, com deadline final em **22/06**.

### Sugestão de Sprints — Fase de Desenvolvimento (Fase 4)

| Sprint   | Foco                                       | RFs envolvidos               |
|----------|--------------------------------------------|------------------------------|
| Sprint 1 | Base do sistema + layout geral             | RNF01, RNF02, RNF03, RF32    |
| Sprint 2 | Módulo Institucional                       | RF01–RF07                    |
| Sprint 3 | Pesquisa & Extensão + Fábrica de Software  | RF08–RF16                    |
| Sprint 4 | Comunicação + Serviços Digitais            | RF17–RF26                    |
| Sprint 5 | Contato, admin, importação e integração    | RF27–RF34, RF12, RNF04–RNF12 |

---

## 11. Visão Futura e Escalabilidade

Esta versão do portal foi desenvolvida com foco no curso de Sistemas de Informação do campus Maria da Graça. Contudo, a arquitetura deve ser projetada considerando a **visão de evolução da instituição**:

- Expansão para outros cursos do campus, com estrutura de **multisite no WordPress** ou arquitetura de páginas modulares por curso.
- Preparação para integração com sistemas externos (**SIGAA, e-MEC**) em versões futuras — hoje bloqueada por RI04.
- Possibilidade de absorver cursos de pós-graduação e técnico no contexto da futura **UFTRJ**.
- Integração futura com plataformas de ensino a distância (**Moodle** ou similar).
- **Internacionalização (i18n)** para suporte a conteúdo em inglês voltado a parcerias internacionais.

---

## 12. Documentação do Projeto

Durante todo o processo de desenvolvimento será produzida documentação técnica e funcional para facilitar a manutenção futura do portal:

- Manual de instalação e configuração do WordPress e plugins.
- Guia de estilo e uso do Design System gov.br no contexto do projeto.
- Manual do usuário para editores de conteúdo (publicação de notícias, atualização de professores, eventos).
- Documentação da API / mecanismo de importação de planilha de professores (RF12).
- Registro de decisões de arquitetura (**ADR** — Architecture Decision Records).
- Plano de testes e casos de teste documentados.

---

## 13. Glossário

| Termo                   | Definição                                                                                                                                                            |
|-------------------------|----------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| **CMS**                 | Content Management System — Sistema de Gerenciamento de Conteúdo. Permite criar e gerenciar conteúdo digital sem necessidade de codificação. Neste projeto: WordPress. |
| **Design System gov.br**| Conjunto de padrões visuais, componentes e diretrizes de UX/UI do Governo Digital Brasileiro, utilizado como base do portal. Aplicado via RN04 e RNF01.              |
| **eMAG**                | Modelo de Acessibilidade em Governo Eletrônico — referência para acessibilidade em portais públicos brasileiros. Exigido por RNF03.                                   |
| **Fábrica de Software** | Unidade do curso de SI que desenvolve projetos de software para a comunidade interna e parceiros externos. Ver módulo 5.3 (RF13–RF16).                               |
| **Gutenberg**           | Editor de blocos nativo do WordPress, usado para criação e edição de conteúdo de forma visual e modular. Usado em RF19 e RF30.                                       |
| **LGPD**                | Lei Geral de Proteção de Dados Pessoais (Lei nº 13.709/2018). Aplicada via RN10 e RNF07.                                                                            |
| **RF**                  | Requisito Funcional — descreve uma funcionalidade que o sistema deve oferecer ao usuário. IDs: RF01 a RF34.                                                          |
| **RI**                  | Requisito Inverso — define explicitamente o que está fora do escopo. IDs: RI01 a RI07.                                                                               |
| **RN**                  | Regra de Negócio — define políticas e restrições do domínio que o sistema deve respeitar. IDs: RN01 a RN12.                                                          |
| **RNF**                 | Requisito Não Funcional — define critérios de qualidade, desempenho, segurança ou conformidade. IDs: RNF01 a RNF12.                                                  |
| **SI**                  | Sistemas de Informação — curso de graduação do CEFET/RJ ao qual este portal é dedicado.                                                                              |
| **SISU**                | Sistema de Seleção Unificada — programa do MEC para ingresso em instituições federais via nota do ENEM. Referenciado em RF05.                                        |
| **TCC**                 | Trabalho de Conclusão de Curso — documento acadêmico obrigatório para colação de grau. Referenciado em RF25.                                                         |
| **WCAG 2.1 AA**         | Web Content Accessibility Guidelines nível AA — padrão internacional de acessibilidade para conteúdo web. Exigido por RNF03.                                         |
| **WordPress**           | CMS de código aberto utilizado como plataforma base do portal. Premissa fixa do projeto. Ver Seção 9.1.                                                              |

---

## 14. Histórico de Versões

| Versão  | Data     | Responsável         | Descrição                                                                                                                                   |
|---------|----------|---------------------|---------------------------------------------------------------------------------------------------------------------------------------------|
| **0.1** | Abr/2025 | Fábrica de Software | Documento de negócio inicial para validação com o cliente.                                                                                  |
| **1.0** | Abr/2025 | Fábrica de Software | Documento completo de Análise de Requisitos elaborado com base no doc avançado, resumo HTML e premissas de WordPress + Design System gov.br. |

---

*Fábrica de Software — CEFET/RJ · Versão 1.0 · 2025*
