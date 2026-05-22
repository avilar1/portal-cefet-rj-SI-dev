# Como editar o Calendário Acadêmico no portal

Guia para **editores e administradores** (perfil Editor ou Administrador no WordPress). Não é necessário editar ficheiros PHP nem fazer deploy do tema para atualizar **datas** e o **PDF** do calendário.

---

## O que é o quê


| No site                                             | O que mostra                                                       | Onde editar                                                          |
| --------------------------------------------------- | ------------------------------------------------------------------ | -------------------------------------------------------------------- |
| **Calendário Acadêmico** (`/calendario-academico/`) | Ano letivo oficial, recessos, prazos de matrícula, download do PDF | **Página Calendário Acadêmico** no wp-admin (caixa abaixo do editor) |
| **Agenda e Eventos**                                | Palestras, reuniões, atividades do curso                           | Menu **Eventos** / página Agenda — **não** é o calendário oficial    |


---

## Passo a passo (rotina anual ou quando o CONPUS publicar versão nova)

### 1. Entrar no painel

1. Aceda ao **wp-admin** (ex.: `http://localhost:8080/wp-admin`).
2. Menu **Páginas** → abra **Calendário Acadêmico**.
3. Desça até à caixa **「Calendário acadêmico — datas e PDF」** (acima ou abaixo do conteúdo da página).

### 2. Campos gerais


| Campo                          | O que preencher                                                                    |
| ------------------------------ | ---------------------------------------------------------------------------------- |
| **Ano letivo**                 | Ex.: `2027` quando mudar o ano                                                     |
| **Última atualização do documento** | Data em que o **PDF oficial (CONPUS)** foi publicado — aparece junto ao botão de download |
| **Última revisão no portal** (só leitura) | **Automática** ao clicar **Atualizar** — data/hora e quem salvou |
| **PDF oficial**                | Clique **Escolher PDF na biblioteca** → envie ou selecione o ficheiro `.pdf` novo  |
| **Texto do botão de download** | Ex.: `Calendário Acadêmico 2027 — CONPUS (PDF unificado)`                          |


Se não escolher PDF na biblioteca, o site tenta usar o PDF padrão incluído no tema (só a equipe técnica altera esse ficheiro).

### 3. Dois tipos de “última atualização” no site

| No site público | Significado |
|----------------|-------------|
| **Informações revisadas no portal em:** … **por** [nome] | Alguém com perfil Editor/Administrador **salvou** esta página (qualquer campo). Atualiza sozinho. |
| **Última atualização do documento oficial:** (caixa azul do PDF) | Data que **você informou** do PDF do CONPUS — não muda ao salvar a página. |

### 4. Visão geral do ano

Tabela com **4 blocos fixos** (nomes não mudam):

- Recesso de início de ano  
- 1º semestre letivo  
- Recesso de meio de ano  
- 2º semestre letivo

Edite apenas **Período / datas** e **Detalhe** (ex.: `23/02/2027 a 03/07/2027`, `24 dias`).

Use o mesmo formato que no PDF oficial (`dd/mm/aaaa` ou intervalos `dd/mm a dd/mm`).

Os títulos **1º semestre (AAAA.1)** e **Renovação de matrícula — AAAA.1** usam o **Ano letivo** do campo acima — ao mudar para 2027, os rótulos passam a **2027.1** / **2027.2** automaticamente no site e no painel.

### 5. Marcos do semestre

Dois blocos fixos (1º e 2º semestre):

- **Período do semestre** — intervalo completo das aulas  
- Até **4 linhas** por semestre: **Data** + **Descrição** (ex.: início das aulas, término, período facultativo)  
- Linhas vazias são ignoradas no site

### 6. Prazos administrativos (graduação)

Três grupos fixos:

1. Renovação de matrícula — AAAA.1 (segue o **Ano letivo**)
2. Renovação de matrícula — AAAA.2
3. Outros prazos recorrentes

Em cada grupo, até **4 linhas**: nome do prazo + período. Confira sempre no **PDF do CONPUS** antes de publicar.

### 7. Texto de abertura da página (opcional)

No campo **Resumo** da página (painel lateral ou topo), pode ajustar o parágrafo introdutório abaixo do título. Se estiver vazio, o tema usa um texto padrão.

O **corpo** da página (editor de blocos) é opcional; o resumo estruturado vem da caixa do calendário, não dos blocos Gutenberg.

### 8. Publicar

1. Clique **Atualizar** na página (ou salvar).
2. Abra **Ver página no site** (link na caixa do calendário ou pré-visualizar) ou atualize a página aberta e confira:
   - “Informações revisadas no portal” atualizada  
   - Data do documento oficial (PDF) correta  
  - Cartões com datas corretas  
  - PDF abre o ficheiro novo

---

## Checklist rápido (fim de ano)

```
□ Novo PDF na biblioteca de media (ou confirmar PDF padrão do tema)
□ Ano letivo atualizado
□ Última atualização do documento = data da versão oficial do PDF
□ (Automático) Revisão no portal ao clicar Atualizar
□ Texto do botão do PDF
□ 4 blocos da visão geral
□ Marcos dos 2 semestres
□ Prazos administrativos (renovação etc.)
□ Atualizar página e rever no site público
```

---

## O que a equipe técnica faz (não é rotina da coordenação)

- Layout, cores e novos tipos de secção → tema `portal-si-cefet`  
- PDF de fallback em `assets/documentos/` (se não usarem biblioteca)  
- Valores iniciais de instalação em `data/calendario-academico.php` (só primeira vez / reset)  
- Link externo fixo para [calendários do CEFET/RJ — Campus Maria da Graça](https://www.cefet-rj.br/index.php/calendarios-campus-maria-da-graca)

---

## Problemas frequentes


| Problema                         | Solução                                                                                                      |
| -------------------------------- | ------------------------------------------------------------------------------------------------------------ |
| Caixa do calendário não aparece  | Confirme que está a editar a página **Calendário Acadêmico** (slug `calendario-academico`), não outra página |
| Alterei datas e o site não mudou | Clicou **Atualizar**? Limpe cache do browser (Ctrl+F5)                                                       |
| PDF antigo ainda abre            | Escolheu o PDF novo na biblioteca e atualizou a página?                                                      |
| Secções vazias no site           | Preencha pelo menos o campo **Período** nos blocos da visão geral                                            |
| Confusão com eventos do curso    | Use **Agenda e Eventos**, não esta página                                                                    |


---

## Referências

- [Conteúdo WordPress vs código](conteudo-wordpress-vs-codigo.md) — visão geral do portal  
- [WORDPRESS-REDAÇÃO-E-PAPÉIS.txt](../WORDPRESS-REDAÇÃO-E-PAPÉIS.txt) — perfis Editor / Administrador

