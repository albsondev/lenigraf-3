<?php

$recipient = 'orcamento@lenigraf.com.br';
$sender = 'orcamento@lenigraf.com.br';
$siteName = 'LENIGRAF';

function respond($status, $title, $message)
{
    $statusMessages = array(
        200 => 'OK',
        400 => 'Bad Request',
        405 => 'Method Not Allowed',
        500 => 'Internal Server Error'
    );

    if (isset($statusMessages[$status])) {
        if (function_exists('http_response_code')) {
            http_response_code($status);
        } else {
            header('HTTP/1.1 ' . $status . ' ' . $statusMessages[$status]);
        }
    }

    header('Content-Type: text/html; charset=UTF-8');

    $safeTitle = htmlspecialchars($title, ENT_QUOTES, 'UTF-8');
    $safeMessage = htmlspecialchars($message, ENT_QUOTES, 'UTF-8');
    $isSuccess = ($status >= 200 && $status < 300);

    if ($isSuccess) {
        $stateLabel = 'ENVIO CONCLUÍDO';
        $stateSymbol = '&#10003;';
        $stateClass = 'success';
    } else {
        $stateLabel = 'VERIFIQUE OS DADOS';
        $stateSymbol = '!';
        $stateClass = 'error';
    }

    echo '<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="theme-color" content="#0a2d72">
  <title>' . $safeTitle . ' | LENIGRAF</title>
  <style>
    * {
      box-sizing: border-box;
    }

    body {
      min-height: 100vh;
      margin: 0;
      padding: 28px 16px;
      display: flex;
      align-items: center;
      justify-content: center;
      background: #f3f5f8;
      color: #172033;
      font-family: Arial, Helvetica, sans-serif;
    }

    .confirmation-card {
      width: 100%;
      max-width: 560px;
      overflow: hidden;
      background: #ffffff;
      border: 1px solid #e3e8ef;
      border-radius: 12px;
      box-shadow: 0 16px 44px rgba(10, 45, 114, 0.12);
    }

    .brand-header {
      padding: 24px 28px 22px;
      background: #0a2d72;
      color: #ffffff;
    }

    .brand-name {
      margin: 0;
      font-size: 28px;
      line-height: 1;
      font-weight: 900;
      font-style: italic;
      letter-spacing: -1px;
    }

    .brand-caption {
      margin: 7px 0 0;
      color: #e7edf8;
      font-size: 10px;
      line-height: 1.4;
      letter-spacing: 1px;
    }

    .gradient-border {
      height: 5px;
      background: linear-gradient(90deg, #42b9e8 0%, #e33136 52%, #f4c400 100%);
    }

    .confirmation-content {
      padding: 38px 32px 32px;
      text-align: center;
    }

    .status-icon {
      width: 58px;
      height: 58px;
      margin: 0 auto 18px;
      display: flex;
      align-items: center;
      justify-content: center;
      border-radius: 50%;
      font-size: 30px;
      font-weight: bold;
    }

    .status-icon.success {
      background: #e8f7ed;
      color: #18864b;
    }

    .status-icon.error {
      background: #fff0ed;
      color: #c83e32;
    }

    .state-label {
      margin: 0 0 9px;
      color: #687386;
      font-size: 11px;
      font-weight: bold;
      letter-spacing: 1.2px;
    }

    h1 {
      margin: 0;
      color: #0a2d72;
      font-size: 27px;
      line-height: 1.25;
    }

    .message {
      max-width: 420px;
      margin: 14px auto 26px;
      color: #586477;
      font-size: 15px;
      line-height: 1.65;
    }

    .back-link {
      min-height: 46px;
      padding: 0 22px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      border-radius: 6px;
      background: #0a2d72;
      color: #ffffff;
      font-size: 14px;
      font-weight: bold;
      text-decoration: none;
      transition: background-color 160ms ease, transform 160ms ease;
    }

    .back-link:hover {
      background: #123f91;
      transform: translateY(-1px);
    }

    .back-link:focus-visible {
      outline: 3px solid #42b9e8;
      outline-offset: 3px;
    }

    .card-footer {
      padding: 15px 24px;
      border-top: 1px solid #e8ecf1;
      color: #7b8493;
      font-size: 12px;
      line-height: 1.5;
      text-align: center;
    }

    @media (max-width: 480px) {
      body {
        padding: 18px 12px;
      }

      .brand-header {
        padding: 21px 22px;
      }

      .confirmation-content {
        padding: 32px 22px 26px;
      }

      h1 {
        font-size: 24px;
      }
    }
  </style>
</head>
<body>
  <main class="confirmation-card">
    <header class="brand-header">
      <p class="brand-name">LENIGRAF</p>
      <p class="brand-caption">SERVIÇOS DE ACABAMENTOS GRÁFICOS LTDA</p>
    </header>

    <div class="gradient-border" aria-hidden="true"></div>

    <section class="confirmation-content" aria-live="polite">
      <div class="status-icon ' . $stateClass . '" aria-hidden="true">' . $stateSymbol . '</div>
      <p class="state-label">' . $stateLabel . '</p>
      <h1>' . $safeTitle . '</h1>
      <p class="message">' . $safeMessage . '</p>
      <a class="back-link" href="/">Voltar ao site</a>
    </section>

    <footer class="card-footer">
      LENIGRAF · Serviços de Acabamentos Gráficos
    </footer>
  </main>
</body>
</html>';

    exit;
}

function getPostValue($key, $maxBytes)
{
    if (!isset($_POST[$key])) {
        return '';
    }

    if (!is_string($_POST[$key])) {
        return false;
    }

    $value = trim(str_replace(chr(0), '', $_POST[$key]));

    if (strlen($value) > $maxBytes) {
        return false;
    }

    return $value;
}

if (!isset($_SERVER['REQUEST_METHOD']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Allow: POST');
    respond(405, 'Método não permitido', 'Envie o formulário pelo site.');
}

$name = getPostValue('nome', 1024);
$surname = getPostValue('ultimo_nome', 1024);
$email = getPostValue('email', 254);
$phone = getPostValue('telefone', 1024);
$message = getPostValue('mensagem', 20000);

if (
    $name === false ||
    $surname === false ||
    $email === false ||
    $phone === false ||
    $message === false
) {
    respond(400, 'Dados inválidos', 'Confira os campos e tente novamente.');
}

if ($name === '' || $email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    respond(400, 'Dados inválidos', 'Informe seu nome e um endereço de e-mail válido.');
}

$normalisedName = preg_replace('/\s+/u', ' ', $name);
$normalisedSurname = preg_replace('/\s+/u', ' ', $surname);

if ($normalisedName === null || $normalisedName === false) {
    $normalisedName = $name;
}

if ($normalisedSurname === null || $normalisedSurname === false) {
    $normalisedSurname = $surname;
}

$fullName = $normalisedName;

if (
    $normalisedSurname !== '' &&
    substr($normalisedName, -strlen($normalisedSurname)) !== $normalisedSurname
) {
    $fullName = trim($normalisedName . ' ' . $normalisedSurname);
}

$safeName = htmlspecialchars($fullName, ENT_QUOTES, 'UTF-8');
$safeEmail = htmlspecialchars($email, ENT_QUOTES, 'UTF-8');
$safePhone = htmlspecialchars(
    $phone !== '' ? $phone : 'Não informado',
    ENT_QUOTES,
    'UTF-8'
);
$safeMessage = nl2br(
    htmlspecialchars(
        $message !== '' ? $message : 'Não informada',
        ENT_QUOTES,
        'UTF-8'
    )
);

$subject = 'Nova solicitacao de orcamento | LENIGRAF';

$body = <<<HTML
<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Nova solicitação de orçamento</title>
</head>
<body style="margin:0;padding:24px;background-color:#f3f5f8;font-family:Arial,Helvetica,sans-serif;color:#172033;">
  <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="max-width:640px;margin:0 auto;background-color:#ffffff;border:1px solid #e3e8ef;border-radius:10px;">
    <tr>
      <td style="padding:24px 28px 22px;background-color:#0a2d72;border-radius:10px 10px 0 0;">
        <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0">
          <tr>
            <td align="left" valign="middle">
              <div style="font-size:30px;line-height:1;font-weight:900;font-style:italic;letter-spacing:-1px;color:#ffffff;">
                LENIGRAF
              </div>
              <div style="margin-top:7px;font-size:10px;line-height:1.4;letter-spacing:1px;color:#ffffff;">
                SERVIÇOS DE ACABAMENTOS GRÁFICOS LTDA
              </div>
            </td>
            <td align="right" valign="middle">
              <table role="presentation" cellspacing="0" cellpadding="0" border="0" align="right">
                <tr>
                  <td width="13" height="13" bgcolor="#42b9e8" style="width:13px;height:13px;background-color:#42b9e8;font-size:0;line-height:0;">&nbsp;</td>
                  <td width="4" style="width:4px;font-size:0;line-height:0;">&nbsp;</td>
                  <td width="13" height="13" bgcolor="#e33136" style="width:13px;height:13px;background-color:#e33136;font-size:0;line-height:0;">&nbsp;</td>
                  <td width="4" style="width:4px;font-size:0;line-height:0;">&nbsp;</td>
                  <td width="13" height="13" bgcolor="#f4c400" style="width:13px;height:13px;background-color:#f4c400;font-size:0;line-height:0;">&nbsp;</td>
                </tr>
              </table>
              <div style="margin-top:9px;font-size:10px;letter-spacing:1px;font-weight:bold;color:#ffffff;">
                CONTATO
              </div>
            </td>
          </tr>
        </table>

        <h1 style="margin:22px 0 0;font-size:22px;line-height:1.3;color:#ffffff;">
          Nova solicitação de orçamento
        </h1>
      </td>
    </tr>
    <tr>
      <td height="5" bgcolor="#42b9e8" style="height:5px;background-color:#42b9e8;background-image:linear-gradient(90deg,#42b9e8 0%,#e33136 52%,#f4c400 100%);font-size:0;line-height:0;">
        &nbsp;
      </td>
    </tr>
    <tr>
      <td style="padding:26px 28px;">
        <p style="margin:0 0 20px;font-size:15px;line-height:1.6;">
          Um novo contato foi recebido pelo formulário do site.
        </p>

        <p style="margin:0 0 12px;font-size:14px;line-height:1.6;">
          <strong>Nome:</strong> {$safeName}
        </p>
        <p style="margin:0 0 12px;font-size:14px;line-height:1.6;">
          <strong>E-mail:</strong> {$safeEmail}
        </p>
        <p style="margin:0 0 20px;font-size:14px;line-height:1.6;">
          <strong>Telefone:</strong> {$safePhone}
        </p>

        <div style="padding:16px 18px;background-color:#f6f8fb;border-left:4px solid #e6b82e;border-radius:4px;">
          <p style="margin:0 0 8px;font-size:14px;font-weight:bold;color:#0a2d72;">
            Mensagem
          </p>
          <p style="margin:0;font-size:14px;line-height:1.7;">
            {$safeMessage}
          </p>
        </div>
      </td>
    </tr>
    <tr>
      <td style="padding:16px 28px;border-top:1px solid #e8ecf1;color:#687386;font-size:12px;line-height:1.5;">
        Mensagem enviada pelo formulário de contato do site LENIGRAF.
      </td>
    </tr>
  </table>
</body>
</html>
HTML;

$isWindows = DIRECTORY_SEPARATOR === '\\';
$lineBreak = $isWindows ? "\r\n" : "\n";

$headers = 'MIME-Version: 1.0' . $lineBreak;
$headers .= 'Content-Type: text/html; charset=UTF-8' . $lineBreak;
$headers .= 'Content-Transfer-Encoding: 8bit' . $lineBreak;
$headers .= 'From: ' . $siteName . ' <' . $sender . '>' . $lineBreak;
$headers .= 'Reply-To: ' . $email . $lineBreak;
$headers .= 'Return-Path: ' . $sender;

$sent = false;

if (function_exists('mail')) {
    if ($isWindows) {
        $sent = mail($recipient, $subject, $body, $headers);
    } else {
        // A hospedagem Linux da Locaweb usa Postfix e requer o remetente de envelope via -r.
        $sent = mail($recipient, $subject, $body, $headers, '-r' . $sender);
    }
}

if (!$sent) {
    error_log('LENIGRAF: mail() não aceitou a mensagem.');

    respond(
        500,
        'Não foi possível enviar',
        'Ocorreu um erro ao enviar sua solicitação. Tente novamente mais tarde ou entre em contato por telefone.'
    );
}

respond(
    200,
    'Solicitação enviada',
    'Obrigado pelo contato. Sua mensagem foi encaminhada para a equipe da LENIGRAF.'
);
