# Conteúdo no WordPress vs no código do tema

Guia para **desenvolvimento** e **coordenação editorial**: onde cada informação vive, quem a altera e por que mudar um ficheiro PHP **não** atualiza o site automaticamente.

---

## Princípio geral

O portal usa um modelo **híbrido** (requisitos + layouts MVP):

| Camada | Onde fica | Quem edita | Quando muda |
|--------|-----------|------------|-------------|
| **Estrutura e visual** | Tema (`page-*.php`, `template-parts/`, `assets/css/`, `inc/*.php`) | Equipe de desenvolvimento | Deploy / atualização do tema |
| **Dados estáveis do módulo** | `data/*.php` no tema | Desenvolvimento (ou painel futuro) | Deploy; mudanças pouco frequentes |
| **Conteúdo editorial** | Base de dados WordPress (páginas, posts, CPT) | Editor / Administrador no **wp-admin** | A qualquer momento, sem deploy |

**Regra de ouro:** depois que uma página foi publicada (ou recebeu o *seed* inicial), o que o visitante vê vem do **WordPress**, não do PHP que gerou o texto pela primeira vez.

---

## Seed editorial (bootstrap) — leia isto antes de editar `inc/sobre.php`

Várias páginas do tema são criadas automaticamente na primeira execução. O tema pode **copiar um HTML de exemplo** do código para o campo *Conteúdo* da página no WP — **uma única vez**.

| Página / módulo | Função no código | Opção na BD (marca “já seedou”) |
|-----------------|------------------|----------------------------------|
| **Sobre o Curso** | `portal_si_sobre_default_post_content()` em `inc/sobre.php` | `portal_si_sobre_content_seeded_v1` |
| Post de exemplo (notícias) | seed em `inc/` editorial | `portal_si_editorial_seeded_v1` |

**Comportamento:**

1. Se a página **Sobre o Curso** estiver **vazia** e a opção acima **não** existir → o tema grava o HTML de exemplo e marca a opção.
2. Depois disso, o site usa só `post_content` da página → **editar `inc/sobre.php` não altera o portal**.
3. Para a coordenação: **sempre editar em** wp-admin → **Páginas** → **Sobre o Curso** (modo visual ou código).

**Não confundir:**

- `inc/sobre.php` = modelo inicial + lógica (âncoras, enqueue, ícones). **Não** é o CMS do dia a dia.
- Alterar endereço, nomes, histórico, emails no PHP **sem** atualizar a página no WP → o visitante continua a ver o texto antigo guardado na base de dados.

Para **reaplicar** o texto do código (só em dev, com cuidado): esvaziar o conteúdo da página no WP e apagar a opção `portal_si_sobre_content_seeded_v1` — perde-se edição manual anterior se não houver cópia.

---

## Sobre o Curso (`/sobre-o-curso/`) — mapa por zona

Referência de implementação: [`layout_sobre_o_curso_mvp.md`](referencias/layout_sobre_o_curso_mvp.md).

| Zona | O que é | Editável no **WordPress** | Editável no **código** |
|------|---------|---------------------------|-------------------------|
| **A — Hero** | Título, intro, breadcrumb | **Título** da página; **Resumo** (*excerpt*) para o parágrafo azul; se o resumo estiver vazio, usa fallback | `intro_default` em `data/sobre-o-curso.php`; layout em `template-parts/sobre/hero.php`, `sobre.css` |
| **B — Números** | 4 cards (duração, gratuidade, etc.) | Não (MVP) | `data/sobre-o-curso.php` → chave `stats` |
| **C — Carta** | Boas-vindas + foto | **Sim** — corpo da página (blocos/HTML) | Seed inicial em `inc/sobre.php`; estilos em `sobre.css` |
| **D — Âncoras** | Menu Histórico / Objetivos / … | Textos das **seções** no corpo da página; IDs `#historico`, etc. devem bater com os links | `anchor_sections` em `data/sobre-o-curso.php`; template `anchor-nav.php`; marcador `<!-- portal-sobre-nav -->` no conteúdo separa carta das seções RF02 |
| **E — Corpo RF02** | Histórico, objetivos, perfil, coordenação | **Sim** — todo o HTML após o marcador de navegação | Seed inicial em `inc/sobre.php`; classes CSS no tema |
| **F — CTAs** | “Como ingressar” / “Voltar ao Institucional” | Não (MVP) | `template-parts/sobre/footer-cta.php` |

**Marcador de navegação:** no conteúdo da página deve existir `<!-- portal-sobre-nav -->` entre a carta (Zona C) e as seções RF02 (Zona E). O tema insere a barra de âncoras nesse ponto. Se o marcador faltar, a nav aparece no fim do conteúdo (comportamento de fallback).

---

## Outros módulos (resumo)

| Módulo | Conteúdo no WP | Conteúdo no código / `data/` |
|--------|----------------|------------------------------|
| **Home** | Pouco; estrutura fixa por zona | `inc/home.php`, templates, CSS; **acesso rápido (Zona 5)** em `data/home-service-links.php` (RF22: links externos + Grade/Calendário internos) |
| **Hub Institucional** | Página hub pode ter conteúdo WP | Cards e textos do hub: `data/institucional.php` |
| **Notícias** | Posts, categorias, imagens | Templates `archive` / `single`, listagem em `inc/noticia.php` |
| **Eventos** | CPT `evento` no WP | `inc/evento.php`, templates |
| **Menus** | Menu WP sincronizado uma vez | Definição por módulos em `inc/nav.php` |
| **Navegação / slugs** | Páginas criadas pelo seed de IA | `inc/seed-ia.php`, helpers em `inc/pages.php` |

---

## Para a coordenação e professores

- **Textos longos, fotos, listas, coordenação, endereço, horários, marcos históricos** → editar na **página** no WordPress, não pedir alteração em ficheiro PHP.
- **Números do topo** (4 anos, Bacharelado, campus) → pedir à equipe técnica ou editar `data/sobre-o-curso.php` (requer deploy).
- **Layout, cores, novo tipo de bloco** → equipe de desenvolvimento (tema).
- Papéis e fluxo de publicação: [`WORDPRESS-REDAÇÃO-E-PAPÉIS.txt`](../WORDPRESS-REDAÇÃO-E-PAPÉIS.txt).

---

## Para desenvolvimento

- Tratar `portal_si_*_default_post_content()` e funções semelhantes como **seed de instalação**, não como fonte viva de conteúdo.
- Novos placeholders no seed: usar textos claramente de exemplo; a coordenação substitui no editor.
- Dados que mudam raramente e não devem estar no HTML livre → preferir `data/<modulo>.php` (como `stats` e `anchor_sections` em Sobre o Curso).
- Ao documentar um módulo novo, acrescentar uma linha neste ficheiro ou na secção equivalente do layout MVP.

---

## Problemas frequentes

| Sintoma | Causa provável | Solução |
|---------|----------------|---------|
| Mudei `inc/sobre.php` e o site não mudou | Conteúdo já está na BD após o seed | Editar a página no wp-admin **ou** reset controlado do seed (só dev) |
| Menu de âncoras no sítio errado | Falta `<!-- portal-sobre-nav -->` no conteúdo | Inserir o marcador entre carta e seções RF02 |
| Intro do hero não atualiza | Resumo da página ou cache | Editar **Resumo** da página; limpar cache se houver plugin |
| Números do topo não mudam | Vêm de `data/sobre-o-curso.php` | Alterar o ficheiro de dados e fazer deploy do tema |

---

*Última revisão: alinhada à implementação RF02 (tema `portal-si-cefet` 0.3.9+).*
