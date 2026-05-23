# Como editar Documentos Institucionais no portal

Guia para **editores e administradores**. O portal separa três tipos de conteúdo — você só precisa do painel WordPress para publicações do curso.

---

## Os três tipos (resumo)

| Tipo | Exemplo | Quem altera | Onde |
|------|---------|-------------|------|
| **Publicações do curso** | Normativo sobre mudança de grade, memorando, PDF para alunos | **Editor / Admin no wp-admin** | Páginas → Documentos Institucionais → caixa **«Publicações do curso»** |
| **Links fixos do portal** | Calendário acadêmico (página interna), textos de introdução | Equipe técnica (tema) ou resumo no WP | Ficheiro `data/documentos-institucionais.php` + excerpt da página |
| **Links externos CEFET/RJ** | Regulamento geral, transparência institucional | Equipe técnica (URLs estáveis) | `data/documentos-institucionais.php` |

**Regra prática:** se é um arquivo **novo** enviado à comunidade do curso → use a caixa **Publicações do curso**. Se é um link que **sempre existe** no site do CEFET → fica no bloco fixo (só a equipe técnica muda, se o URL mudar).

---

## Publicar um normativo, memorando ou PDF (passo a passo)

1. Aceda ao **wp-admin** → **Páginas** → **Documentos Institucionais**.
2. Desça até **«Publicações do curso (PDF e arquivos)»**.
3. Clique **Adicionar publicação** (ou preencha a linha em branco).
4. Preencha:
   - **Título** — ex.: *Normativo — adequação de grade curricular 2026*
   - **Tipo** — Normativo, Memorando, Comunicado, etc.
   - **Data da publicação** — opcional; ordena do mais recente para o mais antigo no site
   - **Resumo** — uma frase para o visitante entender o conteúdo
   - **Arquivo** — **Escolher na biblioteca** → envie o PDF (ou selecione um já enviado)
   - **Ou link externo** — só se o ficheiro estiver noutro site (Google Drive institucional, etc.)
5. Clique **Atualizar** na página.
6. Abra `/documentos-institucionais/` no site e confira a secção **Comunicados e publicações do curso** no topo.

### Remover uma publicação antiga

Na mesma caixa, abra a publicação e clique **Remover**, depois **Atualizar**.  
Se for a única linha, **Remover** apenas limpa os campos.

### PPC e documentos “fixos” do curso

O **Projeto Pedagógico (PPC)** e outros PDFs permanentes podem ser publicados **nesta mesma caixa** (tipo *Documento* ou *Normativo*), sem precisar de programador.

---

## O que não aparece nesta caixa

- Links para o site geral do CEFET/RJ (regulamentos, transparência) — mantidos pelo tema.
- Link para a página **Calendário Acadêmico** do portal — também fixo no tema.

Alterações nesses blocos pedem à equipe técnica ou abertura de tarefa no repositório.

---

## Resumo da página no site (ordem)

1. **Comunicados e publicações do curso** — tudo o que vocês enviam no wp-admin  
2. **Curso de Sistemas de Informação** — calendário interno, etc.  
3. **Normas e regulamentos** — CEFET/RJ  
4. **Transparência** — CEFET/RJ  

---

## Checklist rápido

- [ ] Título claro e tipo correto (Normativo / Memorando / …)
- [ ] PDF enviado na biblioteca **ou** link externo válido
- [ ] Data preenchida (recomendado)
- [ ] Página **Atualizar** clicada
- [ ] Conferido no site público

---

*Versão do tema: caixa de publicações a partir de 0.4.6.*
