# Projeto Golden Raspberry Awards

Este é um projeto Laravel que fornece uma API para analisar prêmios de filmes. Ele permite obter informações sobre o produtor com o maior intervalo entre dois prêmios consecutivos e o produtor que obteve dois prêmios mais rapidamente.

## Pré-requisitos

Certifique-se de que você tenha o seguinte instalado em seu sistema:

- PHP
- Composer
- Extensão PHP SQLite3

Além disso, você precisará do Laravel instalado. Siga as instruções em [laravel.com/docs/10.x/installation](https://laravel.com/docs/10.x/installation) para a instalação.

## Instalação do Projeto

1. Clone este repositório no diretório em que você deseja executar a aplicação.

2. Navegue até o diretório do projeto e execute o seguinte comando para instalar as dependências:

   ```bash
   composer install
   ```
3. Em seguida, execute as migrações do banco de dados para criar as tabelas necessárias:
   O Laravel irá perguntar se deseja criar um arquivo de banco de dados; você pode responder "Sim."
   ```bash
   php artisan migrate
   ```
   
4. Com o banco de dados configurado, você pode usar o seguinte comando personalizado para importar os dados em nossa base:  
   Lembre-se de que o movies.csv pode ser substituído por outros nomes de arquivo, se necessário. O comando irá retornar a mensagem "CSV data imported successfully" quando concluído.
   ```bash
   php artisan import:csv storage/movies.csv
   ```
   
5. Por fim, você pode iniciar o servidor Laravel com o seguinte comando:
   ```bash
   php artisan serve
   ```
   
# Uso da API
Após iniciar o servidor, você pode fazer uma solicitação GET para a rota:  
**[host:port]**/api/get-awards-interval
   ```bash
   http://127.0.0.1:8000/api/get-awards-interval
   ```
Alternativamente, se você estiver usando o PHPStorm Professional, pode executar o arquivo localizado em tests/HttpRequest.http.

A API retornará dados JSON no seguinte formato:

```json
{
  "min": [
    {
      "producer": "Producer 1",
      "interval": 1,
      "previousWin": 2008,
      "followingWin": 2009
    },
    {
      "producer": "Producer 2",
      "interval": 1,
      "previousWin": 2018,
      "followingWin": 2019
    }
  ],
  "max": [
    {
      "producer": "Producer 1",
      "interval": 99,
      "previousWin": 1900,
      "followingWin": 1999
    },
    {
      "producer": "Producer 2",
      "interval": 99,
      "previousWin": 2000,
      "followingWin": 2099
    }
  ]
}
```

# Testando o Código

Você pode testar o código executando o seguinte comando:

```bash
php artisan test
```

Isso executará os testes automatizados para garantir que o sistema esteja funcionando corretamente.
