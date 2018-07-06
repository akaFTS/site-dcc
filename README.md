# site-dcc
Novo site do DCC IME-USP feito em Wordpress.

## Como configurar e rodar

- Necessário ter Docker e docker-compose na máquina
- Baixe o repositório
- Suba os containers com `docker-compose up --build` (sudo pode ser necessário se ele reclamar que não encontrou o docker daemon)
- Talvez o container do wordpress dê varios erros e morra
- Deixe o container do mysql rodando
- Rode `docker-compose exec mysql bash` para acessar um prompt dentro do container, execute `mysql -u root -p` e coloque a senha *testedcc*
- Use o comando `show databases;` para verificar se já existe o database wordpress; se não existir rode `create database wordpress;`
- Saia do prompt do mysql e do bash do container
- Rode o comando de restaurar o banco: `cat backup.sql | docker-compose exec -T mysql /usr/bin/mysql -u root --password=testedcc wordpress`
- Derrube os containers com `docker-compose down` e suba de novo
- Tudo deve estar funcionando agora

## Migrando de servidor

- Certifique-se de que os containers estão rodando
- Entre no painel de configurações do Wordpress dentro do site e vá em Configurações > Geral para cadastrar a nova URL
- Vá no painel do OAuth da USP em `https://uspdigital.usp.br/adminws/oauthConsumidorAcessar` e cadastre a nova URL
- Rode o comando de gerar um dump do banco: `docker-compose exec mysql /usr/bin/mysqldump -u root --password=testedcc wordpress > backup.sql`
- Verifique se o arquivo dump tem um warning do MySQL na primeira linha; se tiver apague
- Derrube os containers
- Apague todo o conteúdo da pasta `mysql-data` (deixe a pasta e o .gitkeep)
- Crie um zip ou suba num repositório
- Baixe no outro servidor e siga os passos da seção acima