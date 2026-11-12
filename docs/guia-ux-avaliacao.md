# Guia de UX — o que a avaliação do portal mostrou

Destilação para quem desenvolve o tema `portal-si-cefet`. A fonte é o TCC *A importância de boas práticas de UI e UX nos serviços públicos digitais* (Vial, 2026), que não entra neste repositório. As heurísticas completas estão em [`referencias/heuristicas_governo_eletronico.md`](referencias/heuristicas_governo_eletronico.md). A regra que o agente aplica no tema é `.cursor/rules/prioridades-ux.mdc`.

## Limite da evidência

A pesquisa ouviu 20 pessoas, por conveniência, numa escala Likert de 1 a 5 e numa nota geral de 1 a 10. São percepções desses participantes, não uma medida da população de usuários de serviços públicos. Três portais foram comparados sem nome no formulário:

| Portal | Contexto | Nota geral (1–10) | Média Likert |
|--------|----------|-------------------|--------------|
| A | Maior capacidade de investimento | 7,15 | 3,69 |
| B | Menor capacidade de investimento | 4,80 | 3,18 |
| C | MVP acadêmico da Fábrica de Software I (2026.1), este portal | 8,45 | 4,25 |

O portal C ficou à frente na maior parte dos blocos. O que a equipe deve guardar não é a nota: é quais práticas o cidadão percebeu e onde este portal ainda foi fraco.

## O que separou a experiência

Orçamento ajudou o portal A a oferecer mais atalhos e serviços (H7 = 4,45). Não bastou. No mesmo portal, voltar ou cancelar ficou em 3,30. O portal C manteve navegação equilibrada (H3 = 4,25, H4 = 4,30, H7 = 4,15).

Linguagem simples foi bem avaliada nos três (H2 de 3,65 a 4,45). O que separou a experiência foi a forma de apresentar: páginas limpas (H8) e ajuda localizável (H10).

| Heurística | A | B | C |
|------------|---|---|---|
| H2 — Linguagem simples | 4,00 | 3,65 | 4,45 |
| H8 — Página limpa | 3,30 | 2,45 | 4,45 |
| H10 — Ajuda encontrável | 3,15 | 2,30 | 3,55 |

Acessibilidade foi o pior bloco nos três portais. As pessoas olharam contraste, aumento de fonte e uso no celular. Comentários do portal B descreveram o desktop espremido na tela pequena. No portal A, o excesso de informação no menu também foi lido como barreira.

Credibilidade ficou abaixo de 4 nos três (A 3,60, B 2,75, C 3,83). No portal de menor investimento, a desconfiança veio de imagem quebrada, visual antigo e órgão pouco identificável — não de uma auditoria de segurança. Segurança percebida de dados foi um dos poucos itens em que o portal A superou o C.

Reconhecimento em vez de memória (H6) empatou A e B em 3,15; o C ficou em 4,15. A tarefa não tinha formulário longo, então o bloco diz pouco sobre fluxos com várias etapas.

Comentários livres sobre o portal C citaram facilidade, clareza e organização, e também link em construção e função incompleta.

## Prioridades no tema

1. **Página enxuta (H8).** Um assunto por bloco. Não empilhar o mesmo destino no menu, num card e num parágrafo.
2. **Volta clara (H3).** Breadcrumb e retorno à home em toda página. Atalho que não deixa voltar repete o problema do portal A.
3. **Atalho visível (H7).** Acesso rápido na home, sem esconder busca e menu.
4. **Linguagem cidadã (H2).** Sigla explicada na primeira ocorrência. Este item já é barato e já funcionou até no portal de menor investimento.
5. **Órgão reconhecível (H12).** Faixa, rodapé, contato da coordenação e link externo identificado. Sem imagem quebrada.
6. **Celular e contraste (H11).** Layout próprio para tela estreita, contraste e texto que não dependa só de cor.
7. **Ajuda encontrável (H10).** Orientação curta a partir da tarefa. Foi a heurística mais baixa do portal C no bloco de conteúdo (3,55).
8. **Incompleto anunciado.** Usar `template-parts/shared/coming-soon.php`: selo, o que falta e caminho de contato. Não oferecer a página como serviço pronto.

## Pergunta que o participante respondeu

Cada item abaixo é o critério observável. A interface nova deve permitir responder “sim” sem explicar o sistema.

| Código | Pergunta |
|--------|----------|
| H3 | Dá para cancelar ou voltar sem perder o que já foi feito? |
| H4 | O visual e a linguagem são os mesmos em todas as páginas? |
| H7 | Existe atalho para o que é mais importante? |
| H2 | A linguagem é simples, sem juridiquês nem sigla solta? |
| H8 | A página mostra só o necessário, sem banner nem texto irrelevante? |
| H10 | Dá para achar dúvidas frequentes ou uma orientação de como fazer? |
| H6 | Instrução e opção continuam visíveis, sem memorizar a tela anterior? |
| H11 | Contraste, fonte e celular atendem perfis diferentes, inclusive conexão lenta? |
| H12.1 | O órgão responsável e um canal humano estão fáceis de achar? |
| H12.2 | Fica claro o que acontece com os dados e como obter um comprovante? |

H1 (status), H5 (prevenir erro) e H9 (recuperar erro) ficaram de fora do questionário porque a navegação exploratória não tinha fluxo com falha. Entram quando houver formulário ou etapas: contato, busca sem resultado, envio.

## Roteiro de três tarefas

O mesmo roteiro da coleta, para revisar uma tela antes de considerar o módulo fechado. Fazer no celular e no desktop.

1. Iniciar um caminho (serviço, formulário ou seção) e voltar à home pelo próprio site, não só pelo botão do navegador.
2. Achar uma informação institucional e o canal de contato da coordenação.
3. Achar ajuda ou uma orientação curta da tarefa. Se a página ainda não tem conteúdo, o aviso de “em breve” precisa dizer isso e oferecer o contato.

## O que não levar para o código

A numeração HGE01–HGE14 de Maciel (2025) já está consolidada nas heurísticas H1–H12 do projeto. Revisão de literatura, amostra, estatística e o termo de consentimento permanecem no TCC.
