PGDMP  1                     }         
   Biblioteca    16.2    16.2     �           0    0    ENCODING    ENCODING        SET client_encoding = 'UTF8';
                      false            �           0    0 
   STDSTRINGS 
   STDSTRINGS     (   SET standard_conforming_strings = 'on';
                      false            �           0    0 
   SEARCHPATH 
   SEARCHPATH     8   SELECT pg_catalog.set_config('search_path', '', false);
                      false            �           1262    24735 
   Biblioteca    DATABASE     �   CREATE DATABASE "Biblioteca" WITH TEMPLATE = template0 ENCODING = 'UTF8' LOCALE_PROVIDER = libc LOCALE = 'English_United States.1252';
    DROP DATABASE "Biblioteca";
                postgres    false            �            1259    24759    students    TABLE        CREATE TABLE public.students (
    codigo integer NOT NULL,
    nombre character varying(50) NOT NULL,
    apellido character varying(50) NOT NULL,
    carrera character varying(4),
    correo character varying(255),
    num_prestamos integer DEFAULT 0
);
    DROP TABLE public.students;
       public         heap    postgres    false            �            1259    24763    usuarios_id_seq    SEQUENCE     �   CREATE SEQUENCE public.usuarios_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 &   DROP SEQUENCE public.usuarios_id_seq;
       public          postgres    false    216            �           0    0    usuarios_id_seq    SEQUENCE OWNED BY     G   ALTER SEQUENCE public.usuarios_id_seq OWNED BY public.students.codigo;
          public          postgres    false    217            `           2604    24764    students codigo    DEFAULT     n   ALTER TABLE ONLY public.students ALTER COLUMN codigo SET DEFAULT nextval('public.usuarios_id_seq'::regclass);
 >   ALTER TABLE public.students ALTER COLUMN codigo DROP DEFAULT;
       public          postgres    false    217    216            �          0    24759    students 
   TABLE DATA           \   COPY public.students (codigo, nombre, apellido, carrera, correo, num_prestamos) FROM stdin;
    public          postgres    false    216   �       �           0    0    usuarios_id_seq    SEQUENCE SET     =   SELECT pg_catalog.setval('public.usuarios_id_seq', 2, true);
          public          postgres    false    217            c           2606    24766    students usuarios_pkey 
   CONSTRAINT     X   ALTER TABLE ONLY public.students
    ADD CONSTRAINT usuarios_pkey PRIMARY KEY (codigo);
 @   ALTER TABLE ONLY public.students DROP CONSTRAINT usuarios_pkey;
       public            postgres    false    216            e           2606    24768    students usuarios_username_key 
   CONSTRAINT     [   ALTER TABLE ONLY public.students
    ADD CONSTRAINT usuarios_username_key UNIQUE (nombre);
 H   ALTER TABLE ONLY public.students DROP CONSTRAINT usuarios_username_key;
       public            postgres    false    216            �      x������ � �     