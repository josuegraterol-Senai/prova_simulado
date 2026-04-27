# Entrega 01 – Requisitos Funcionais

Este documento detalha as funcionalidades do Sistema de Gestão de Estoque SAEP.

## 1. Módulo de Acesso e Segurança
- **RF01 - Login de Operador:** O sistema deve validar e-mail e senha para conceder acesso às áreas restritas.
- **RF02 - Cadastro de Usuário:** Permitir o registro de novos operadores do almoxarifado.
- **RF03 - Controle de Sessão:** Impedir o acesso às páginas de gestão sem autenticação prévia e permitir o encerramento da sessão (Logout).

## 2. Módulo de Cadastro de Produtos (Almoxarifado)
- **RF04 - Gestão de Produtos (CRUD):** Possibilidade de cadastrar, visualizar, editar e excluir informações de equipamentos (smartphones, notebooks e smart TVs).
- **RF05 - Pesquisa de Itens:** Filtro dinâmico para localizar produtos por nome ou especificações técnicas.
- **RF06 - Validação de Dados:** Impedir o salvamento de produtos com campos obrigatórios em branco.

## 3. Módulo de Movimentação de Estoque
- **RF07 - Registro de Fluxo:** Registrar entradas e saídas de produtos com indicação de data, quantidade e responsável.
- **RF08 - Alerta de Estoque Mínimo:** Exibir notificação em destaque quando o saldo de um produto estiver abaixo do limite configurado.
- **RF09 - Ordenação Algorítmica:** A lista de gestão de estoque deve ser organizada alfabeticamente utilizando o algoritmo **Bubble Sort**.
- **RF10 - Rastreabilidade:** Manter um histórico de cada movimentação para auditoria.
