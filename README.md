# Symfony Simple CRUD RESTFull API
Welcome to this little API Rest achieve with Symfony 2.

### Requirements
- PHP 7.0
- PDO-MYSQL PHP extension enabled
- and the [usual Symfony application requirements.](https://symfony.com/doc/2.8/reference/requirements.html "usual Symfony application requirements.")

### Installation
Execute this command to install the project:
> $ git clone https://github.com/SergeChristophe/crudApi.git

In the project directory:
> $ composer install

Change the parameters in *app/config/parameters.yml* as you want.

Execute these commands.
> $ php app/console doctrine:database:create
$ php app/console doctrine:schema:update --force

Create an user
> $ php app/console fos:user:create

Fill in the *Post* table
> $ php app/console doctrine:fixtures:load

And launch the server:
> $ php app/console server:run

### Operation
To make queries in the API you have to authenticate:
- install and run [Postman](https://www.getpostman.com/ "Postman")
- make a *POST* request with URL: *localhost:8000/api/login_check* and body parameter:
> username: your_username
password: your_password
- It will generate a Token like this:
> {
    "token": "eyJhbGciOiJSUzI1NiJ9.eyJyb2xlcyI6WyJST0xFX1VTRVIiXSwidXNlcm5hbWUiOiJ1c2VyIiwiaWF0IjoxNTE2ODYwMjQyLCJleHAiOjE1MTY4NzgyNDJ9.BtKm6AT4XVcQKyh_jq8u7WrZp5BYGVXWnO8Kn_9y2teG4VZ_iagjyD-jPlT6BDia--FfzAqQ1fZ4C5My9e6ZPqHBVfkwC-FZ32X2KBrbZXkwhzSQaMqpJzek7UjhizfchaTezR-H6iMABGxQ0HWSYwgvzKRYWqNuZQiJpyCPSSKBB9nNxmiKwlLF8XUIvKX1zu-aVLVecVsSxn2KAqSKs7RuBblAgz1pdlAl0tHyzy74JBbNqpn6khAsNjuz42OWETOlH-7aY1rpi_2yHwU5tTHPya2pdZ8dn8wlXTAB9IQWuuQ6_VsXtBEZ7A3regvHMYDq8MU-qXrshlcHYY1qNd7qfUwZq79DOcwVn6j8z_dYrac7ZqmRavvNFVUF80oeQs7zYQEl8nxwCrFxy63ym3IkAdrU10PQGlosHKMFw77pqenbMXfH5YZT7LGnJsL1IduewhvmeOVN3wmIRRPt7G0UAVK_OvU2JsY6VRbYvxuskFQaef9E7u7iWEgEXdb5htDHaig-a-VnribIVr9J-lyUIVZhb1wxsXlKwPMT-INl1BrQhM4Cg3b5pY0y2kmniTSRKIr0qM8fakdK0b0mZ0o0Tnol3zcwl-42zsURPj1bDSpao5FC_bvZXnWJ7ZAA4bL98oasU-0JmQ86OmY2eW8z_5NnLzUW5MivyNe5yT0"
}
- List all *Post* on *localhost/api/post* with *GET* method an headers parameter:
> Authorization: Bearer {token}
- All method on *localhost:8000/api/doc*