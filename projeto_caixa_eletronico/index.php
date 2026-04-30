<?php
date_default_timezone_set('America/Sao_Paulo');

class CaixaEletronico {
    private float $saldo;
    private array $extrato;

    public function __construct() {
        $this->saldo = 0.0;
        $this->extrato = [];
        $this->registrarNoExtrato("Abertura da conta. Saldo: R$ 0,00");
    }

    public function depositar(float $valor): array {
        if ($valor > 0) {
            $this->saldo += $valor;
            $this->registrarNoExtrato("Depósito: + R$ " . $this->formatarMoeda($valor));
            return ['tipo' => 'sucesso', 'texto' => "Depósito de R$ {$this->formatarMoeda($valor)} efetuado com sucesso."];
        }
        return ['tipo' => 'erro', 'texto' => "Erro: O valor do depósito deve ser maior que zero."];
    }

    public function sacar(float $valor): array {
        if ($valor <= 0) {
            return ['tipo' => 'erro', 'texto' => "Erro: O valor do saque deve ser maior que zero."];
        }
        if ($valor > $this->saldo) {
            return ['tipo' => 'erro', 'texto' => "Operação Negada: Saldo insuficiente para saque de R$ {$this->formatarMoeda($valor)}."];
        }
        
        $this->saldo -= $valor;
        $this->registrarNoExtrato("Saque: - R$ " . $this->formatarMoeda($valor));
        return ['tipo' => 'info', 'texto' => "Saque de R$ {$this->formatarMoeda($valor)} efetuado com sucesso."];
    }

    public function getSaldo(): float {
        return $this->saldo;
    }

    public function getExtrato(): array {
        return $this->extrato;
    }

    public function formatarMoeda(float $valor): string {
        return number_format($valor, 2, ',', '.');
    }

    private function registrarNoExtrato(string $mensagem): void {
        $this->extrato[] = "[" . date('d/m/Y H:i:s') . "] " . $mensagem;
    }
}

session_start();

if (!isset($_SESSION['conta'])) {
    $_SESSION['conta'] = new CaixaEletronico();
}

$conta = $_SESSION['conta'];
$mensagemAlerta = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['acao'])) {
        $valorInformado = isset($_POST['valor']) ? (float)$_POST['valor'] : 0.0;

        if ($_POST['acao'] === 'depositar') {
            $mensagemAlerta = $conta->depositar($valorInformado);
        } elseif ($_POST['acao'] === 'sacar') {
            $mensagemAlerta = $conta->sacar($valorInformado);
        } elseif ($_POST['acao'] === 'reiniciar') {
            session_destroy();
            header("Location: index.php");
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Internet Banking</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<div class="container">
    <header>
        <h2>Internet Banking</h2>
    </header>

    <?php if ($mensagemAlerta): ?>
        <div class="alerta alerta-<?php echo $mensagemAlerta['tipo']; ?>">
            <?php echo $mensagemAlerta['texto']; ?>
        </div>
    <?php endif; ?>

    <div class="painel">
        <div class="operacoes">
            <div class="saldo-display">
                <p>Saldo Disponível</p>
                <h3>R$ <?php echo $conta->formatarMoeda($conta->getSaldo()); ?></h3>
            </div>

            <form method="POST" action="index.php">
                <div class="form-group">
                    <label for="valor">Informe o Valor (R$)</label>
                    <input type="number" id="valor" name="valor" step="0.01" min="0.01" placeholder="Ex: 100.50" required>
                </div>

                <div class="botoes">
                    <button type="submit" name="acao" value="depositar" class="btn btn-deposito">Depositar</button>
                    <button type="submit" name="acao" value="sacar" class="btn btn-saque">Sacar</button>
                </div>
            </form>

            <form method="POST" action="index.php" style="margin-top: 15px;">
                <button type="submit" name="acao" value="reiniciar" class="btn btn-encerrar">Sair da Conta</button>
            </form>
        </div>

        <div class="extrato-container">
            <h4>Extrato de Conta Corrente</h4>
            <div class="extrato-lista">
                <?php foreach ($conta->getExtrato() as $registro): ?>
                    <span><?php echo $registro; ?></span>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

</body>
</html>