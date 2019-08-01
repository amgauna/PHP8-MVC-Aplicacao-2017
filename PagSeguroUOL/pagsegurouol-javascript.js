// rotina pag seguro uol em javacsript 
// https://pagseguro.uol.com.br/v2/guia-de-integracao/documentacao-da-biblioteca-pagseguro-em-php.html#checkout-transparente
 

\PagSeguroLibrary::init();
\PagSeguroConfig::setEnvironment($environment);

$credentials = new \PagSeguroAccountCredentials(
    $email,
    $token//cada ambiente tem seu próprio token
);
$sessionId = PagSeguroSessionService::getSession($credentials);

// esse session ID precisa ser enviado para o JavaScript
<script type="text/javascript">
  PagSeguroDirectPayment.setSessionId('sessionId');
</script>

// Agora o checkout:
$directPaymentRequest = new \PagSeguroDirectPaymentRequest();
$directPaymentRequest->setPaymentMode('DEFAULT'); // GATEWAY
$directPaymentRequest->setPaymentMethod('CREDIT_CARD');//tipo de pagamento (aqui, em específico, cartão de crédito)
$directPaymentRequest->setCurrency("BRL");
$directPaymentRequest->setReference($referenceCode);//código de referência para o que está sendo vendido (ordem de venda, registro, etc...)
$directPaymentRequest->setReceiverEmail($pagSeguroEmail);//e-mail do cadastro do PagSeguro

$directPaymentRequest->addItem(
    $itemCodigo,
    $descricao,
    1,//quantidade
    $valor
);


//comprador
$directPaymentRequest->setSender(
    $nome,
    $email,
    $ddd,
    $telefone,
    'CPF',//TIPO: CPF ou CNPJ
    $cpf//CPF ou CNPJ
);

// esse é gerado pelo javascript
$directPaymentRequest->setSenderHash($post['sender-hash']);

//parcelas, para cartão de crédito
$installments = new \PagSeguroInstallment(
    array(
        'quantity' => '1',
        'value' => $valor
    )
);

$address = new \PagSeguroAddress(
    array(
        'postalCode' => $cep,
        'street' => $logradouro,
        'number' => $numero,
        'complement' => $complemento,
        'district' => $bairro,
        'city' => $cidade,
        'state' => $uf,
        'country' => $pais
    )
);

//endereço para o pagamento
$billingAddress = new \PagSeguroBilling($address);

$directPaymentRequest->setBillingAdress($billingAddress);

//quando não há frete. Na época era obrigatório adicionar o frete zerado com endereço
$directPaymentRequest->setShipping($address , \PagSeguroShippingType::getCodeByType('NOT_SPECIFIED'));
$directPaymentRequest->setShippingCost(0);

//informações sobre o cartão de crédito. Dados pessoais são do dono do cartão
$creditCardHolder = new \PagSeguroCreditCardHolder(
    array(
        'name' => ,
        'birthDate' => $dataNascimente,
        'areaCode' => $ddd,
        'number' => $telefone,
        'documents' => array(
            'type' => 'CPF',
            'value' => $cpfCartao
        )
    )
);

$creditCardData = new \PagSeguroCreditCardCheckout(
    array(
        'token' => $creditCardToken,//gerado pelo javascript
        'installment' => $installments,
        'billing' => $billingAddress,
        'holder' => $creditCardHolder
    )
);

try {
    $directPaymentRequest->setCreditCard($creditCardData);

    $response = $directPaymentRequest->register($this->entity->getApplication()->getAccountCredentials());

} catch (\PagSeguroServiceException $exception) {
}

