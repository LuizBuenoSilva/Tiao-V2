# Como rodar localmente 🚀

⚠️ Necessário Php, Composer, Mysql e Nodejs instalados ⚠️

## Passo a passo

1. Clone o repositório
```bash
git clone (https://github.com/LuizBuenoSilva/Tiao-V2.git)

```
2. Entre na pasta raíz do projeto
```bash
$ cd techpines-teste-tecnico
```
3. Instale as dependencias do PHP e do node
```bash
    $ compose install
    $ cd frontend
    $ npm install
```
4. Crie um arquivo .env na pasta raiz do projeto contendo informações do banco de dados 
```bash
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=techpines
DB_USERNAME=SEU_USUARIO_DO_BANCO
DB_PASSWORD=SUA_SENHA_DO_BANCO
```
5. Execute as migrations para que as tabelas sejam criadas corretamente no banco
```bash
php artisan migrate
```
6. Com um terminal aberto no raiz do projeto inicie o backend Laravel
```bash
docker artisan serve
```
7. Abra um terminal na raiz do projeto, entre na pasta do frontend e inicie o frontend em react
```bash
$ cd frontend
$ npm start
```

