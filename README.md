<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>


## Como executar o projeto depois de baixado

Supondondo que voce ja tenha o xampp,composer,npm e o laravel instalado faça:
-Clone o repositorio;
-Digite o commando no terminal do seu desktop "composer install" . Ele vai instalar todos os pacotes php necessários;
-Duplicar o arquivo ".env.example" e renomear para ".env" e fazer as configurações de acesso a banco;
-Digite o commando no terminal do seu desktop "php artisan key:generate". Esse vai gerar uma chave dentro do .env para sua aplicação;
-Digite o commando no termnial do seu desktop "npm install". Vai instalar o pacote do node necesario para executar a aplicaçao;
-Instalar o drive do postgres no seu php.ini
-Executar o comando das migrations "php artisan migrate " para criar as tabelas no seu banco ou executar as querys a seguir no seu sgbd;

## Query's

-- Criar Database crudmatricula : 

CREATE DATABASE crudmatricula
    WITH 
    OWNER = postgres
    ENCODING = 'UTF8'
    LC_COLLATE = 'Portuguese_Brazil.1252'
    LC_CTYPE = 'Portuguese_Brazil.1252'
    TABLESPACE = pg_default
    CONNECTION LIMIT = -1;

-- Tabelas :

-- Tabela: public.alunos

    CREATE TABLE IF NOT EXISTS public.alunos
    (
        id bigint NOT NULL DEFAULT nextval('alunos_id_seq'::regclass),
        nome character varying(255) COLLATE pg_catalog."default" NOT NULL,
        email character varying(255) COLLATE pg_catalog."default" NOT NULL,
        curso_id bigint NOT NULL,
        created_at timestamp(0) without time zone,
        updated_at timestamp(0) without time zone,
        CONSTRAINT alunos_pkey PRIMARY KEY (id),
        CONSTRAINT alunos_curso_id_foreign FOREIGN KEY (curso_id)
            REFERENCES public.cursos (id) MATCH SIMPLE
            ON UPDATE NO ACTION
            ON DELETE NO ACTION
    )

    TABLESPACE pg_default;

    ALTER TABLE IF EXISTS public.alunos
        OWNER to postgres;
    
-- Tabela: public.cursos

    CREATE TABLE IF NOT EXISTS public.cursos
    (
        id bigint NOT NULL DEFAULT nextval('cursos_id_seq'::regclass),
        nome_curso character varying(255) COLLATE pg_catalog."default" NOT NULL,
        created_at timestamp(0) without time zone,
        updated_at timestamp(0) without time zone,
        CONSTRAINT cursos_pkey PRIMARY KEY (id)
    )

    TABLESPACE pg_default;

    ALTER TABLE IF EXISTS public.cursos
        OWNER to postgres;
  
  ## Insert 
  -- Necessario para o dropdownlist
  
      INSERT INTO public.cursos(nome_curso)
	                    VALUES ('Inglês'),
                               ('Francês'),
                               ('Espanhol');
   
   ## Depois dessas configurações ja pode executar o projeto com o comando "php artisan serve"
