### ZF2 Cache Teste


### Teste com Cache DOCTRINE 2(ODM/ORM)
- Cache utilizando Redis
- Cache utilizando Memcached

### Teste de armazenamento em sessão
- Utilizando os mecanismos acima

### Comandos

```bash

#RODAR NO MYSQL
CREATE DATABASE zf-cache;

php public/index.php orm:schema-tool:create
php public/index.php orm:schema-tool:drop --force

php public/index.php odm:schema:create
php public/index.php odm:schema:drop 


```

### Ferramentas

http://redisdesktop.com/
http://robomongo.org/
http://phpmemcacheadmin.googlecode.com(http://phpmemcacheadmin.googlecode.com/files/phpMemcachedAdmin-1.2.2-r262.tar.gz)