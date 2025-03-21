PGDMP                      |            Alumnos    16.2    16.2     �           0    0    ENCODING    ENCODING        SET client_encoding = 'UTF8';
                      false            �           0    0 
   STDSTRINGS 
   STDSTRINGS     (   SET standard_conforming_strings = 'on';
                      false            �           0    0 
   SEARCHPATH 
   SEARCHPATH     8   SELECT pg_catalog.set_config('search_path', '', false);
                      false            �           1262    24576    Alumnos    DATABASE     }   CREATE DATABASE "Alumnos" WITH TEMPLATE = template0 ENCODING = 'UTF8' LOCALE_PROVIDER = libc LOCALE = 'Spanish_Mexico.1252';
    DROP DATABASE "Alumnos";
                postgres    false            �            1259    41277    prestamo_student    TABLE     W  CREATE TABLE public.prestamo_student (
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
 $   DROP TABLE public.prestamo_student;
       public         heap    postgres    false            �            1259    41276    prestamos_id_seq    SEQUENCE     �   CREATE SEQUENCE public.prestamos_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 '   DROP SEQUENCE public.prestamos_id_seq;
       public          postgres    false    221            �           0    0    prestamos_id_seq    SEQUENCE OWNED BY     L   ALTER SEQUENCE public.prestamos_id_seq OWNED BY public.prestamo_student.id;
          public          postgres    false    220            `           2604    41280    prestamo_student id    DEFAULT     s   ALTER TABLE ONLY public.prestamo_student ALTER COLUMN id SET DEFAULT nextval('public.prestamos_id_seq'::regclass);
 B   ALTER TABLE public.prestamo_student ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    221    220    221            �          0    41277    prestamo_student 
   TABLE DATA           �   COPY public.prestamo_student (id, codigo_usuario, id_libro, ejemplar, fecha_salida, fecha_limite, multa, devuelto, fecha_devolucion) FROM stdin;
    public          postgres    false    221   �       �           0    0    prestamos_id_seq    SEQUENCE SET     ?   SELECT pg_catalog.setval('public.prestamos_id_seq', 38, true);
          public          postgres    false    220            d           2606    41284    prestamo_student prestamos_pkey 
   CONSTRAINT     ]   ALTER TABLE ONLY public.prestamo_student
    ADD CONSTRAINT prestamos_pkey PRIMARY KEY (id);
 I   ALTER TABLE ONLY public.prestamo_student DROP CONSTRAINT prestamos_pkey;
       public            postgres    false    221            e           2606    41285 +   prestamo_student fk_codigo_usuario_students    FK CONSTRAINT     �   ALTER TABLE ONLY public.prestamo_student
    ADD CONSTRAINT fk_codigo_usuario_students FOREIGN KEY (codigo_usuario) REFERENCES public.students(codigo) ON UPDATE CASCADE ON DELETE CASCADE;
 U   ALTER TABLE ONLY public.prestamo_student DROP CONSTRAINT fk_codigo_usuario_students;
       public          postgres    false    221            f           2606    41295 !   prestamo_student fk_isbn_ejemplar    FK CONSTRAINT     �   ALTER TABLE ONLY public.prestamo_student
    ADD CONSTRAINT fk_isbn_ejemplar FOREIGN KEY (id_libro, ejemplar) REFERENCES public.books(isbn, ejemplar) ON UPDATE CASCADE ON DELETE CASCADE;
 K   ALTER TABLE ONLY public.prestamo_student DROP CONSTRAINT fk_isbn_ejemplar;
       public          postgres    false    221    221            �      x������ � �     