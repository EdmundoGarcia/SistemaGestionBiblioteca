PGDMP                      |            Alumnos    16.2    16.2     �           0    0    ENCODING    ENCODING        SET client_encoding = 'UTF8';
                      false            �           0    0 
   STDSTRINGS 
   STDSTRINGS     (   SET standard_conforming_strings = 'on';
                      false            �           0    0 
   SEARCHPATH 
   SEARCHPATH     8   SELECT pg_catalog.set_config('search_path', '', false);
                      false            �           1262    24576    Alumnos    DATABASE     }   CREATE DATABASE "Alumnos" WITH TEMPLATE = template0 ENCODING = 'UTF8' LOCALE_PROVIDER = libc LOCALE = 'Spanish_Mexico.1252';
    DROP DATABASE "Alumnos";
                postgres    false            �            1259    24603    usuarios    TABLE     �   CREATE TABLE public.usuarios (
    username character varying(255) NOT NULL,
    password character varying(255),
    tipo_usuario character varying(255)
);
    DROP TABLE public.usuarios;
       public         heap    postgres    false            �          0    24603    usuarios 
   TABLE DATA           D   COPY public.usuarios (username, password, tipo_usuario) FROM stdin;
    public          postgres    false    217   �       a           2606    24609    usuarios usuarios_pkey1 
   CONSTRAINT     [   ALTER TABLE ONLY public.usuarios
    ADD CONSTRAINT usuarios_pkey1 PRIMARY KEY (username);
 A   ALTER TABLE ONLY public.usuarios DROP CONSTRAINT usuarios_pkey1;
       public            postgres    false    217            �   .   x�s��qut��L�-�IMLɇ3�]|=�8Sr3� $W� �R1     