# Visão Arquitetural: Sistema de Workflow (PHP 5.0)

Este documento apresenta uma análise detalhada da arquitetura do projeto **Workflow System**, desenvolvido em PHP 5.0 legatário (sem o uso de Composer ou frameworks modernos). O sistema implementa uma arquitetura própria baseada no padrão **MVC (Model-View-Controller)** em conjunto com o padrão **DAO (Data Access Object)** para persistência de dados.

## 1. Padrão Arquitetural Principal

O sistema utiliza uma divisão clara de responsabilidades através da estrutura de diretórios e nomenclatura de arquivos. A arquitetura é uma adaptação do padrão MVC clássico, dividida nas seguintes camadas:

*   **Models / Entidades (`/classe`)**: Contém as classes que representam o domínio da aplicação (ex: `Atividade.php`, `Processo.php`, `Usuario.php`). São basicamente DTOs (Data Transfer Objects) ou POPOs (Plain Old PHP Objects) com atributos e métodos Getters/Setters.
*   **Controllers (`/controle`)**: Contém as classes de controle (ex: `controladorAtividade.php`, `controladorProcesso.php`). Recebem as requisições da camada de apresentação, aplicam regras de negócio, interagem com a camada de dados (DAOs) e preparam os dados para as Views.
*   **DAOs / Persistência (`/modulo`)**: Contém as classes de acesso a dados (ex: `daoAtividade.php`, `daoProcesso.php`). Estas classes estendem a classe mãe `DaoBase` (`daoBase.php`), que gerencia a conexão com o banco de dados via `mysqli` e contém métodos utilitários para gerar SQL dinamicamente (Selects, Inserts, Updates lógicos).
*   **Views / Apresentação (`/view`)**: Contém os arquivos responsáveis por gerar a interface do usuário em HTML mesclado com PHP (ex: `viewAtividade.php`).

## 2. Fluxo de Requisição (Entry Points e Roteamento)

O sistema não possui um roteador moderno. O fluxo de execução de ações dinâmicas é gerenciado principalmente pelo arquivo **`controlador.php`**, que atua como um *Front Controller* simplificado para requisições POST.

1.  **Acesso Inicial**: O usuário acessa `index.php` (Página de Login) ou `main.php` (Painel Principal).
2.  **Requisições de Ação (POST)**: Formulários ou chamadas AJAX enviam dados via POST para `controlador.php`.
    *   No payload, são passados dois parâmetros fundamentais: `controlador` (nome da classe do Controller) e `funcao` (nome do método a ser executado).
3.  **Despacho (Dispatch)**: O `controlador.php` limpa esses parâmetros de roteamento do `$_POST`, instancializa a classe do `controlador` especificada e chama o método `funcao` dinamicamente (`$class->$funcao($post);`), passando o restante dos dados do formulário.
4.  **Resposta**: O controller processa, interage com o DAO e dá um `echo` na View resultante, devolvendo o HTML ou resultado para o navegador.

## 3. Autoloading Customizado

Sem o Composer (`vendor/autoload.php`), o projeto utiliza um mecanismo de autoloading próprio no arquivo **`classe/Autoload.php`**. A função mágica `__autoload($classe)` é usada para procurar dinamicamente o arquivo da classe que está sendo instanciada em múltiplos diretórios:
*   `classe/`
*   `controle/`
*   `interface/`
*   `view/`
*   `modulo/`

## 4. Estrutura de Diretórios e Componentes

| Diretório/Arquivo | Descrição e Propósito |
| :--- | :--- |
| `/classe` | Classes de modelo/entidade (ex: `Usuario.php`, `Processo.php`). Também contém o `Autoload.php`. |
| `/controle` | Classes de controle (Controllers). Implementam as regras de negócio e orquestram Models, DAOs e Views. |
| `/modulo` | Classes DAO (Data Access Objects). Centralizam as queries SQL. A classe `DaoBase` manipula conexões e queries genéricas. |
| `/view` | Camada de apresentação. Arquivos PHP que geram as telas em HTML. |
| `/assets`, `/imagens`, `/arquivos` | Arquivos estáticos: CSS (Bootstrap), JavaScript (jQuery), fontes, imagens da aplicação e uploads do sistema. |
| `/scripts_sql` | Scripts de banco de dados, possivelmente o *dump* de criação da estrutura do MySQL. |
| `index.php` | Ponto de entrada público do sistema (Tela de Login). Inicia a sessão e reseta o login ativo. |
| `controlador.php` | *Front Controller* interno que despacha as requisições para os Controllers específicos. |
| `api.php`, `batch.php` | Scripts independentes, possivelmente para processamentos em lote ou endpoints externos/AJAX. |
| `include.php`, `required.php`, `lib.php` | Arquivos de inclusão base, contendo bibliotecas de funções gerais, carregamento de dependências locais e sessão. |

## 5. Gerenciamento de Banco de Dados

*   **Driver**: Utiliza a extensão `mysqli` (MySQL Improved) nativa do PHP.
*   **DaoBase (`modulo/daoBase.php`)**: Funciona como um ORM (Object-Relational Mapping) primitivo.
    *   Mapeia resultados do banco (Objetos Genéricos) para Entidades fortemente tipadas através do método `modelMapper`.
    *   Constrói strings SQL (Insert, Update) dinamicamente lendo os métodos *Getters* dos objetos (`get_class_methods`).
    *   Padrão de Exclusão: Utiliza **Soft Delete** (exclusão lógica). O método `sqlExcluir` apenas altera a coluna `status = '0'`.

## 6. Pontos de Atenção (Débito Técnico e Segurança)

Como se trata de uma arquitetura PHP 5.0 legada, existem pontos críticos que exigem cautela ao dar manutenção:

1.  **Injeção de SQL (SQL Injection)**: O `daoBase.php` monta queries concatenando strings (ex: `$sql .= " ".strtolower($campo)." = '".$objeto->$method()."',";`). Não há uso de **Prepared Statements** (bind parameters). Isso torna a aplicação altamente vulnerável a ataques caso os inputs (via POST) não sejam rigorosamente limpos.
2.  **Segurança de Sessão**: O sistema usa `session_start()` padrão, sem mecanismos avançados contra *Session Hijacking* visíveis na superfície.
3.  **Tratamento de Erros**: O controlador base apenas faz `echo $e;` em blocos Try/Catch, o que pode expor detalhes sensíveis (Stack Traces) do sistema e do banco de dados em ambiente de produção.
4.  **Autoload Depreciado**: A função `__autoload` utilizada foi declarada como obsoleta no PHP 7.2 e removida no PHP 8.0. Para atualizar a versão do PHP no futuro, será necessário migrar para `spl_autoload_register`.
