# Entrega 08 – Descritivo de Teste de Software

Este documento apresenta o plano de testes funcionais para validar os requisitos do sistema.

### 8.1. Plano de Casos de Teste (Funcional)

| ID | Cenário de Teste | Ação do Usuário | Resultado Esperado |
|----|------------------|-----------------|--------------------|
| **CT01** | Falha de Login | Inserir senha incorreta. | Exibição de erro: "Senha incorreta". |
| **CT02** | Cadastro de Usuário | Registrar nova conta e logar. | Acesso concedido ao Dashboard. |
| **CT03** | Cadastro de Produto | Preencher dados e salvar. | Produto aparecer na tabela geral. |
| **CT04** | Pesquisa de Produto | Digitar termo no campo de busca. | Tabela exibir apenas itens correspondentes. |
| **CT05** | Saída de Estoque | Registrar saída de 5 unidades. | Saldo atualizado e registro no histórico. |
| **CT06** | Alerta de Mínimo | Deixar saldo abaixo do mínimo. | Exibição de alerta crítico em vermelho. |
| **CT07** | Ordenação Automática | Acessar tela de Gestão. | Lista organizada de A a Z via Bubble Sort. |
| **CT08** | Encerramento | Clicar em "Sair". | Sessão destruída e retorno ao Login. |

### 8.2. Ambiente e Ferramentas
- **Tecnologias**: PHP 8.2 / MySQL (MariaDB).
- **Servidor**: Apache (via XAMPP).
- **Testes**: Manuais e exploratórios baseados na lista de requisitos.
