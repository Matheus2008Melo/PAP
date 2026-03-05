3.2. Metodologias de Projeto

Para além das ferramentas de desenvolvimento, a aplicação de metodologias estruturadas foi crucial para o planeamento delineado, a execução técnica e o rigoroso controlo de qualidade do projeto WeAreSchool ao longo do ano letivo.

3.2.1. Planeamento e Gestão

A organização do tempo e a constante maturação das ideias foram geridas com recurso a ferramentas standard da indústria tecnológica:
Diagrama de Gantt: Utilizado para o planeamento macro do projeto (gerido inicialmente através de soluções de folha de cálculo ou software dedicado), definindo os grandes marcos cruciais (milestones) da Prova de Aptidão Profissional, a duração estipulada para a programação de cada módulo e as suas interdependências (ex: o catálogo de projetos só poderia nascer após a construção das Tabelas de Disciplinas e de Autenticação). Permitiu um controlo infalível dos prazos de entrega.
Mapas Mentais e Estruturas em Árvore: Aplicados intensivamente na fase incipiente de ideação e Wireframing mental para visualizar a arquitetura da informação da plataforma (Dashboard de Aluno, Listagem de Disciplinas, Área de Aprovação de Administradores) e clarificar a hierarquia robusta subjacente à base de dados.
Controlo de Versões: Essencial contra a potencial perda catastrófica de código. Permitiu manter um histórico redundante e completo de todas as alterações estruturais e de interface (commits), facilitando testes experimentais em ramos paralelos sem corromper o núcleo operacional do projeto académico.

3.2.2. Análise e Modelação

Para garantir a absoluta integridade estrutural do sistema em ambiente de produção escolar, aplicaram-se metodologias formais de engenharia de software de raiz:
Análise Funcional e Especificação de Requisitos: Documentou exaustivamente as necessidades arquitetónicas. Exemplo de requisito rigoroso: O sistema deve permitir cruzar e catalogar um mesmo projeto em duas ou mais disciplinas e garantir o seu correto aparecimento público e independente em cada uma delas.
Modelação de Dados (Modelo Entidade-Relacionamento): Impreterivelmente antes de qualquer codificação backend, toda a estrutura labiríntica da base de dados foi mapeada num modelo E-R (Entidade-Relacionamento). Isto balizou firmemente a criação de Entidades e os cruciais relacionamentos de 1-para-N (Um projeto tem Múltiplas Tags) e as pontes de pivot Muito-para-Muitos essenciais às lógicas de disciplinas secundárias.
Metodologia Ágil e Pair-Programming: O fluxo real de trabalho adotou princípios de metodologias Ágeis iterativas, focando na organização de resolução de bugs em ciclos extremamente curtos. Como grande inovação tecnológica, estes Sprints e etapas de resolução algorítmica foram frequentemente desenvolvidos em modo de Pair-Programming coadjuvado por Agentes de Inteligência Artificial Especializados, exponenciando a produtividade do fluxo de raciocínio.

4. O Produto: WeAreSchool

Este capítulo encarrega-se de apresentar visual e tecnicamente a materialização e conclusão prática do projeto WeAreSchool, dissecando as artérias da sua arquitetura, as lógicas de programação e interface desenvolvidas e a superior experiência de utilização (User Experience) garantida.

4.1. Descrição Geral da Aplicação

O ecossistema WeAreSchool foi desenhado, de base, como uma aplicação web moderna escolar. Sustentado pelos alicerces do robusto framework Laravel do lado do servidor (backend), o projeto transpira a imediação e fluidez interativa de uma Single Page Application (SPA) contemporânea, cortesia da sintaxe reativa do Livewire e Alpine.js. Esta fusão tecnológica focou-se estrategicamente em três pilares base:
Interatividade de Interface (UI): Desacoplando-se do estigma das interfaces lentas da Administração Pública escolar, todo o ambiente dispõe de caixas flutuantes dinâmicas (dropdowns independentes), pré-visualização no próprio browser de ficheiros anexados (com renderização interna em iFrames sem forçar o download), e sistemas limpos de alertas assíncronos que não desviam a atenção do foco central da navegação.
Estética Institucional Premium: Envergando as metodologias do Tailwind CSS, a interface foi desenhada através de um paleta visual imaculada e moderna. Privilegiando fundos límpidos (brancos e variantes subtis flat de cinzento) contrastados por botões chamativos e tipografias assertivas, a plataforma transmite maturidade e organização universitária ao mesmo tempo que mantém a clareza para utilizadores muito jovens.
Arquivística Pedagógica Inteligente: Mais do que mero repositório de envio passivo de ficheiros, o sistema filtra publicamente por Anos Letivos dinâmicos e Tags (Etiquetas de Tecnologias), transformando um aglomerado cego de entregas digitais num motor de partilha e pesquisa relacional onde projetos interdisciplinares têm o merecido lugar de destaque para consultas de novas turmas.

4.2. Níveis de Acesso e Funcionalidades

Para cumprir a rigorosa legislação e necessidade de triagem no ambiente educacional, a engenharia do WeAreSchool foi seccionada intrinsecamente com múltiplos níveis de acesso distintos baseados em Roles de Base de Dados, cada qual ostentando rotas, ecrãs e permissões altamente isoladas.

Nível 1 (Público): Visitante / Utilizador Não Autenticado
Funcionalidades Disponíveis:
Acesso livre a todo o catálogo público de projetos agrupados por anos letivos e disciplinas.
Utilização irrestrita do motor de pesquisa para filtragem por Tags tecnológicas (ex: Programação, Design).
Pré-visualização de projetos em detalhe e carregamento dinâmico de anexos no browser.

Nível 2 (Restrito): Administrador / Direção de Curso
Funcionalidades Disponíveis:
Acesso a um dashboard protegido por autenticação (Painel Administrativo).
Sistema de interceção e quarentena (aprovação/rejeição de submissões pendentes de alunos).
Gestão completa e isolada do inventário de disciplinas e listagem de utilizadores institucionais.
Monitorização das atividades e moderação da plataforma através de Middlewares de segurança.

4.3. Storyboard e Fluxo de Navegação

A jornada do utilizador foi desenhada cirurgicamente para ser intuitiva e sem atrito, guiando alunos e professores de forma lógica desde a descoberta de projetos até à sua aprovação ou imersão.
Página Inicial (Landing Page): Funciona como a montra da instituição escolar. Apresenta uma hero section visualmente cativante, um convite imediato à exploração, e uma contagem em tempo-real do volume de projetos já arquivados.
Catálogo Geral e Disciplinas: O coração da exploração académica. Combina um sistema de grelha (Cards) que elenca as disciplinas abertas, encaminhando depois para uma barra de filtros avançados (Ano Letivo e Tags) dentro de cada disciplina.
Página de Detalhe do Projeto Académico: O centro de toda a informação técnica e pedagógica. Apresenta o descritivo do projeto, o histórico do aluno autor, as tags associadas e, como trunfo máximo, integra um visualizador embebido (em iframe) que apresenta o relatório final nativamente no ecrã e permite o download do ficheiro compactado (ZIP) com o código-fonte/recursos.
Painel de Submissão de Aluno: A ferramenta de entrada de dados. Permite ao utilizador registado criar uma nova Ficha de Projeto através de um formulário dinâmico multi-passo (com selects de múltiplas disciplinas em Alpine.js) concebido para evitar erros humanos antes do upload para o servidor.
Dashboard de Aprovação (Administrador): Secção restrita dedicada à moderação, onde os coordenadores e professores validam a qualidade pedagógica das entregas. Os projetos ficam reféns de uma mudança de estado assíncrona ("Pendente" para "Aprovado") antes de verem a luz do dia no catálogo público.

4.4. Manuais de Utilização (Resumo)

Para garantir a correta adoção orgânica e a sustentabilidade a longo prazo da plataforma nas escolas, foram delineados fluxos de utilização distintos:
Manual do Aluno (Submissor): Um fluxo prático que ensina o utilizador final a tirar o máximo partido do formulário de entregas, alertando para os requisitos de compactação de pastas (ZIP) e documentação base (PDF), bem como a correta marcação de parcerias com disciplinas secundárias de forma a projetar o portefólio para o máximo de docentes em simultâneo.
Manual do Administrador (Coordenador): Um fluxo técnico destinado ao corpo docente. Explica passo a passo como realizar a vigilância diária (triagem) de novos projetos, os critérios de segurança na consulta de ficheiros e a inserção manual de novas Disciplinas ou Categorias no currículo dinâmico do sistema base.
