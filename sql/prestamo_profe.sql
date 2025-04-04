PGDMP                       |            Alumnos    16.2    16.2     �           0    0    ENCODING    ENCODING        SET client_encoding = 'UTF8';
                      false            �           0    0 
   STDSTRINGS 
   STDSTRINGS     (   SET standard_conforming_strings = 'on';
                      false            �           0    0 
   SEARCHPATH 
   SEARCHPATH     8   SELECT pg_catalog.set_config('search_path', '', false);
                      false            �           1262    24576    Alumnos    DATABASE     }   CREATE DATABASE "Alumnos" WITH TEMPLATE = template0 ENCODING = 'UTF8' LOCALE_PROVIDER = libc LOCALE = 'Spanish_Mexico.1252';
    DROP DATABASE "Alumnos";
                postgres    false            �            1259    41329    prestamo_profe    TABLE     U  CREATE TABLE public.prestamo_profe (
    id integer NOT NULL,
    codigo_usuario integer NOT NULL,
    id_libro character varying(20) NOT NULL,
    ejemplar integer NOT NULL,
    fecha_salida date NOT NULL,
    fecha_limite date NOT NULL,
    multa numeric(10,2) DEFAULT 0.0,
    devuelto boolean DEFAULT false,
    fecha_devolucion date
);
 "   DROP TABLE public.prestamo_profe;
       public         heap    postgres    false            �            1259    41328    prestamo_profe_id_seq    SEQUENCE     �   CREATE SEQUENCE public.prestamo_profe_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 ,   DROP SEQUENCE public.prestamo_profe_id_seq;
       public          postgres    false    223            �           0    0    prestamo_profe_id_seq    SEQUENCE OWNED BY     O   ALTER SEQUENCE public.prestamo_profe_id_seq OWNED BY public.prestamo_profe.id;
          public          postgres    false    222            `           2604    41332    prestamo_profe id    DEFAULT     v   ALTER TABLE ONLY public.prestamo_profe ALTER COLUMN id SET DEFAULT nextval('public.prestamo_profe_id_seq'::regclass);
 @   ALTER TABLE public.prestamo_profe ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    222    223    223            �          0    41329    prestamo_profe 
   TABLE DATA           �   COPY public.prestamo_profe (id, codigo_usuario, id_libro, ejemplar, fecha_salida, fecha_limite, multa, devuelto, fecha_devolucion) FROM stdin;
    public          postgres    false    223   �       �           0    0    prestamo_profe_id_seq    SEQUENCE SET     C   SELECT pg_catalog.setval('public.prestamo_profe_id_seq', 3, true);
          public          postgres    false    222            d           2606    41336 "   prestamo_profe prestamo_profe_pkey 
   CONSTRAINT     `   ALTER TABLE ONLY public.prestamo_profe
    ADD CONSTRAINT prestamo_profe_pkey PRIMARY KEY (id);
 L   ALTER TABLE ONLY public.prestamo_profe DROP CONSTRAINT prestamo_profe_pkey;
       public            postgres    false    223            e           2606    41337 +   prestamo_profe fk_codigo_usuario_profesores    FK CONSTRAINT     �   ALTER TABLE ONLY public.prestamo_profe
    ADD CONSTRAINT fk_codigo_usuario_profesores FOREIGN KEY (codigo_usuario) REFERENCES public.profesores(codigo_profesor) ON UPDATE CASCADE ON DELETE CASCADE;
 U   ALTER TABLE ONLY public.prestamo_profe DROP CONSTRAINT fk_codigo_usuario_profesores;
       public          postgres    false    223            f           2606    41342    prestamo_profe fk_isbn_ejemplar    FK CONSTRAINT     �   ALTER TABLE ONLY public.prestamo_profe
    ADD CONSTRAINT fk_isbn_ejemplar FOREIGN KEY (id_libro, ejemplar) REFERENCES public.books(isbn, ejemplar) ON UPDATE CASCADE ON DELETE CASCADE;
 I   ALTER TABLE ONLY public.prestamo_profe DROP CONSTRAINT fk_isbn_ejemplar;
       public          postgres    false    223    223            �      x������ � �     