PGDMP                      }         
   Biblioteca    16.2    16.2     �           0    0    ENCODING    ENCODING        SET client_encoding = 'UTF8';
                      false            �           0    0 
   STDSTRINGS 
   STDSTRINGS     (   SET standard_conforming_strings = 'on';
                      false            �           0    0 
   SEARCHPATH 
   SEARCHPATH     8   SELECT pg_catalog.set_config('search_path', '', false);
                      false            �           1262    24735 
   Biblioteca    DATABASE     �   CREATE DATABASE "Biblioteca" WITH TEMPLATE = template0 ENCODING = 'UTF8' LOCALE_PROVIDER = libc LOCALE = 'English_United States.1252';
    DROP DATABASE "Biblioteca";
                postgres    false            �            1259    24772 
   profesores    TABLE     �   CREATE TABLE public.profesores (
    codigo_profesor integer NOT NULL,
    nombre character varying(50),
    apellido character varying(50),
    carrera character varying(4),
    correo character varying(255),
    num_prestamos integer
);
    DROP TABLE public.profesores;
       public         heap    postgres    false            �          0    24772 
   profesores 
   TABLE DATA           g   COPY public.profesores (codigo_profesor, nombre, apellido, carrera, correo, num_prestamos) FROM stdin;
    public          postgres    false    218   #       a           2606    24776    profesores profesores_pkey 
   CONSTRAINT     e   ALTER TABLE ONLY public.profesores
    ADD CONSTRAINT profesores_pkey PRIMARY KEY (codigo_profesor);
 D   ALTER TABLE ONLY public.profesores DROP CONSTRAINT profesores_pkey;
       public            postgres    false    218            �      x������ � �     