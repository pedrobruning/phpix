# PhPix 

Simples biblioteca que facilita a integração com WebServices para PIX.

## Serviços disponíveis

- OpenPix (<https://developers.openpix.com.br/api/>)

## Requisitos
- Necessário PHP 8.0 ou superior.
- Necessário o pacote **symfony/http-client** na versão ^6.0

## Utilização

Para utilizar essa biblioteca basta seguir os exemplos a seguir.

```php 
<?php
require __DIR__ . 'vendor/autoload.php';

//DEPENDÊNCIAS
use PedroBruning\PhPix\Services\PhPixServiceFactory;
use PedroBruning\PhPix\Services\Providers;
use Symfony\Component\HttpClient\HttpClient; 

//INSTÂNCIA
$provider = Providers::OpenPix;
$phPixService = PhPixServiceFactory::make($provider, $client);
```

### Obter Cobrança por Id
```php
$chargeId = 'chargeId';
$charge = $phPixService->charges()->getById($chargeId);
```

### Obter Cobranças por Filtro

```php
$filter = [
    'start' => '2021-03-01T17:28:51.882Z',
    'end' => '2021-03-05T17:28:51.882Z',
    'status' => 'ACTIVE',
];
$charges = $phPixService->charges()->getByFilter($filter);
```

### Criar Cobrança
Todos os campos que podem ser utilizados para criação da cobrança podem ser consultados na própria classe de Request chamada.
```php
use PedroBruning\PhPix\Models\OpenPix\ChargeRequest;
$chargeRequest = new ChargeRequest(
    correlationId: 'validCorrelation',
    value: 100,
    comment: 'validComment',
    identifier: 'validIdentifier',
    customer: [
        'name' => 'Test Customer',
        'email' => 'email@test.com',
        'phone' => '(00) 00000-0000',
        'taxID' => '000000000000'
    ]
);
$charge = $phPixService->charges()->create($chargeRequest);
```