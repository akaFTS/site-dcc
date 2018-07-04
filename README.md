# site-dcc
Novo site do DCC IME-USP feito em Wordpress.

## Como rodar

- Necessário ter Docker e docker-compose na máquina
- Baixe o repositório
- Crie uma pasta mysql-data vazia
- Suba os containers com `docker-compose up --build` (sudo pode ser necessário se ele reclamar que não encontrou o docker daemon)
- Talvez o container do wordpress dê varios erros e morra
- Deixe o container do mysql rodando
- Rode `docker-compose exec mysql bash` para acessar um prompt dentro do container, execute `mysql -u root -p` e coloque a senha *testedcc*
- Use o comando `show databases;` para verificar se já existe o database wordpress; se não existir rode `create database wordpress;`
- Saia do prompt do mysql e do bash do container
- Rode o comando de restaurar o banco que está no arquivo txt
- Derrube os containers com `docker-compose down` e suba de novo
- Tudo deve estar funcionando agora
- Ao migrar de servidor, cadastre a nova URL em configurações > geral no painel do Wordpress e também no painel do OAuth da USP