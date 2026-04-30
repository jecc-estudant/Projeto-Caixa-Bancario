# 🏦 Internet Banking Simulator

Um simulador simples e interativo de um sistema de Internet Banking / Caixa Eletrônico. Este projeto foi desenvolvido para demonstrar operações bancárias básicas utilizando **Programação Orientada a Objetos (POO)**, contando com uma interface web moderna.

---

## ✨ Funcionalidades

O sistema simula as principais operações de uma conta corrente:

* 💰 **Depósito:** Permite ao usuário inserir um valor positivo para adicionar ao saldo da conta.
* 💸 **Saque:** Permite retirar um valor do saldo, contando com validação rigorosa (o sistema impede saques de valores negativos, zerados ou superiores ao saldo disponível).
* 🧾 **Extrato Bancário:** Exibe um histórico completo de todas as movimentações (abertura da conta, depósitos e saques), formatado com data e hora de cada transação. A lista exibe as transações mais recentes no topo.
* 🔄 **Controle de Sessão:** Botão "Log Out" que encerra a sessão ativa do usuário, limpando o histórico de transações e zerando o saldo da simulação.
* 🎨 **Interface Responsiva:** Painel administrativo (Dashboard) com barra lateral (*sidebar*) e layout em cartões (*cards*), adaptável para dispositivos móveis e desktops.
* 🔔 **Feedback Visual (Alertas):** Mensagens dinâmicas informam o usuário sobre o sucesso das operações ou exibem alertas de erro caso alguma regra de negócio seja violada.

---

## 🛠️ Tecnologias Utilizadas

* **Linguagem Backend:** [PHP 8+](https://www.php.net/) (Utilizando Classes, Métodos, Tipagem Forte e Superglobais `$_SESSION` e `$_POST`).
* **Linguagem de Marcação:** HTML5
* **Estilização:** CSS3 puro (Flexbox, responsividade com Media Queries e design inspirado em dashboards administrativos).

---

## 📂 Estrutura do Projeto

```text
├── index.php    # Contém a classe CaixaEletronico, a lógica de sessão e a estrutura HTML.
├── styles.css   # Contém toda a estilização, cores, layout responsivo e tipografia.
└── README.md    # Documentação do projeto.
