PGDMP  4    	                |            Alumnos    16.2    16.2     �           0    0    ENCODING    ENCODING        SET client_encoding = 'UTF8';
                      false            �           0    0 
   STDSTRINGS 
   STDSTRINGS     (   SET standard_conforming_strings = 'on';
                      false            �           0    0 
   SEARCHPATH 
   SEARCHPATH     8   SELECT pg_catalog.set_config('search_path', '', false);
                      false            �           1262    24576    Alumnos    DATABASE     }   CREATE DATABASE "Alumnos" WITH TEMPLATE = template0 ENCODING = 'UTF8' LOCALE_PROVIDER = libc LOCALE = 'Spanish_Mexico.1252';
    DROP DATABASE "Alumnos";
                postgres    false            �            1259    41007    books    TABLE       CREATE TABLE public.books (
    isbn character varying(20) NOT NULL,
    ejemplar integer NOT NULL,
    titulo character varying(100),
    autor character varying(100),
    editorial character varying(100),
    anio_public integer,
    disponible boolean DEFAULT true NOT NULL
);
    DROP TABLE public.books;
       public         heap    postgres    false            �          0    41007    books 
   TABLE DATA           b   COPY public.books (isbn, ejemplar, titulo, autor, editorial, anio_public, disponible) FROM stdin;
    public          postgres    false    218          b           2606    41011    books books_pkey 
   CONSTRAINT     Z   ALTER TABLE ONLY public.books
    ADD CONSTRAINT books_pkey PRIMARY KEY (isbn, ejemplar);
 :   ALTER TABLE ONLY public.books DROP CONSTRAINT books_pkey;
       public            postgres    false    218    218            �   �  x�͖K��@���)� 4����QF�d�M65�0NL��m���&�,�����I&XH��a�Բ���R��Uqh��v���f6�A�O�'P���/U��9�(�
>!������aN�^t����BIv�u�t�˲Xي�HD�#'V䋐��m%��$mgE�sX���Cf#��sz�3����?�,y�ï���m�k�^�@�i��4�>4p=��~�.�N�;���ub[xn����^ͻ(vU�{��J�<dH��%����
:�t�-��[��?A��m�l*{$��;�wy�<���h:&���d�I��'�����J+�y��K�I
��)�`������κgC~A�(3�;v���<���6>����?����I;�7�(v`�¥��2J�}��.�b���0�� �ͧp=���S����+m&��J����f��E�$ �_໫q=��Vy�j&�@�JӃ~��6�j���@)P��.W���4�p`x0��0hŶǷVS����j����sF/I�*@&��Y�j�c]Z�d��4�x��-�vpfHA-�i��6F�#�"=/�/ܝ;]��J�r���r���&e6Q���wM��r5"�ϔѽ�Д��2�h�%
�B�a��4����&��$��E����[^w����u�&zj^w-���u��||�;�V��|K     