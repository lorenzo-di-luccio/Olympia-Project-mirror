PGDMP         5                x           olympia    12.2    12.2     )           0    0    ENCODING    ENCODING        SET client_encoding = 'UTF8';
                      false            *           0    0 
   STDSTRINGS 
   STDSTRINGS     (   SET standard_conforming_strings = 'on';
                      false            +           0    0 
   SEARCHPATH 
   SEARCHPATH     8   SELECT pg_catalog.set_config('search_path', '', false);
                      false            ,           1262    16393    olympia    DATABASE     �   CREATE DATABASE olympia WITH TEMPLATE = template0 ENCODING = 'UTF8' LC_COLLATE = 'Italian_Italy.1252' LC_CTYPE = 'Italian_Italy.1252';
    DROP DATABASE olympia;
                postgres    false            �            1259    16479    acquisto    TABLE     "  CREATE TABLE public.acquisto (
    username_socio character varying(50) NOT NULL,
    nome_prodotto character varying(50) NOT NULL,
    istante timestamp without time zone NOT NULL,
    qta integer NOT NULL,
    prezzo_da_pagare money NOT NULL,
    CONSTRAINT chk_qta CHECK ((qta >= 0))
);
    DROP TABLE public.acquisto;
       public         heap    postgres    false            �            1259    16617    corso    TABLE     �  CREATE TABLE public.corso (
    nome character varying(30) NOT NULL,
    max_num_posti integer NOT NULL,
    num_posti_rimasti integer NOT NULL,
    num_posti_prenotati integer NOT NULL,
    CONSTRAINT chk_max_num_posti CHECK ((max_num_posti >= 0)),
    CONSTRAINT chk_num_posti_prenotati CHECK ((num_posti_prenotati = (max_num_posti - num_posti_rimasti))),
    CONSTRAINT chk_num_posti_rimasti CHECK (((num_posti_rimasti >= 0) AND (num_posti_rimasti <= max_num_posti)))
);
    DROP TABLE public.corso;
       public         heap    postgres    false            �            1259    16651    prenotazione    TABLE       CREATE TABLE public.prenotazione (
    username_socio character varying(50) NOT NULL,
    nome_corso character varying(25) NOT NULL,
    numero integer NOT NULL,
    istante timestamp without time zone NOT NULL,
    CONSTRAINT chk_numero CHECK ((numero > 0))
);
     DROP TABLE public.prenotazione;
       public         heap    postgres    false            �            1259    16459    prodotto    TABLE     �   CREATE TABLE public.prodotto (
    nome character varying(50) NOT NULL,
    prezzo money NOT NULL,
    qta_disponibile integer NOT NULL,
    CONSTRAINT chk_qta_disponibile CHECK ((qta_disponibile >= 0))
);
    DROP TABLE public.prodotto;
       public         heap    postgres    false            �            1259    16394    utente    TABLE       CREATE TABLE public.utente (
    username character varying(50) NOT NULL,
    password character varying(50) NOT NULL,
    nome character varying(50) NOT NULL,
    cognome character varying(50) NOT NULL,
    data_nascita date NOT NULL,
    sesso character(1) NOT NULL,
    email character varying(50) NOT NULL,
    approvato boolean NOT NULL,
    ruolo character varying(10) NOT NULL,
    abbonamento character varying(25) NOT NULL,
    data_scadenza date,
    CONSTRAINT chk_abbonamento CHECK (((abbonamento)::text = ANY ((ARRAY['-'::character varying, '*'::character varying, 'Crossfit'::character varying, 'Bodybuilding'::character varying, 'Pesistica'::character varying, 'Crossfit & Bodybuilding'::character varying, 'Crossfit & Pesistica'::character varying, 'Bodybuilding & Pesistica'::character varying])::text[]))),
    CONSTRAINT chk_ruolo CHECK (((ruolo)::text = ANY ((ARRAY['admin'::character varying, 'socio'::character varying])::text[]))),
    CONSTRAINT chk_sesso CHECK ((sesso = ANY (ARRAY['M'::bpchar, 'F'::bpchar])))
);
    DROP TABLE public.utente;
       public         heap    postgres    false            $          0    16479    acquisto 
   TABLE DATA           a   COPY public.acquisto (username_socio, nome_prodotto, istante, qta, prezzo_da_pagare) FROM stdin;
    public          postgres    false    204   F        %          0    16617    corso 
   TABLE DATA           \   COPY public.corso (nome, max_num_posti, num_posti_rimasti, num_posti_prenotati) FROM stdin;
    public          postgres    false    205   c        &          0    16651    prenotazione 
   TABLE DATA           S   COPY public.prenotazione (username_socio, nome_corso, numero, istante) FROM stdin;
    public          postgres    false    206   >!       #          0    16459    prodotto 
   TABLE DATA           A   COPY public.prodotto (nome, prezzo, qta_disponibile) FROM stdin;
    public          postgres    false    203   [!       "          0    16394    utente 
   TABLE DATA           �   COPY public.utente (username, password, nome, cognome, data_nascita, sesso, email, approvato, ruolo, abbonamento, data_scadenza) FROM stdin;
    public          postgres    false    202   "       �
           2606    16484    acquisto pk_acquisto 
   CONSTRAINT     v   ALTER TABLE ONLY public.acquisto
    ADD CONSTRAINT pk_acquisto PRIMARY KEY (username_socio, nome_prodotto, istante);
 >   ALTER TABLE ONLY public.acquisto DROP CONSTRAINT pk_acquisto;
       public            postgres    false    204    204    204            �
           2606    16644    corso pk_corso 
   CONSTRAINT     N   ALTER TABLE ONLY public.corso
    ADD CONSTRAINT pk_corso PRIMARY KEY (nome);
 8   ALTER TABLE ONLY public.corso DROP CONSTRAINT pk_corso;
       public            postgres    false    205            �
           2606    16655    prenotazione pk_prenotazione 
   CONSTRAINT     r   ALTER TABLE ONLY public.prenotazione
    ADD CONSTRAINT pk_prenotazione PRIMARY KEY (username_socio, nome_corso);
 F   ALTER TABLE ONLY public.prenotazione DROP CONSTRAINT pk_prenotazione;
       public            postgres    false    206    206            �
           2606    16464    prodotto pk_prodotto 
   CONSTRAINT     T   ALTER TABLE ONLY public.prodotto
    ADD CONSTRAINT pk_prodotto PRIMARY KEY (nome);
 >   ALTER TABLE ONLY public.prodotto DROP CONSTRAINT pk_prodotto;
       public            postgres    false    203            �
           2606    16400    utente pk_username 
   CONSTRAINT     V   ALTER TABLE ONLY public.utente
    ADD CONSTRAINT pk_username PRIMARY KEY (username);
 <   ALTER TABLE ONLY public.utente DROP CONSTRAINT pk_username;
       public            postgres    false    202            �
           2606    16661    prenotazione fk_nome_corso    FK CONSTRAINT     �   ALTER TABLE ONLY public.prenotazione
    ADD CONSTRAINT fk_nome_corso FOREIGN KEY (nome_corso) REFERENCES public.corso(nome) MATCH FULL;
 D   ALTER TABLE ONLY public.prenotazione DROP CONSTRAINT fk_nome_corso;
       public          postgres    false    2717    206    205            �
           2606    16490    acquisto fk_nome_prodotto    FK CONSTRAINT     �   ALTER TABLE ONLY public.acquisto
    ADD CONSTRAINT fk_nome_prodotto FOREIGN KEY (nome_prodotto) REFERENCES public.prodotto(nome) MATCH FULL;
 C   ALTER TABLE ONLY public.acquisto DROP CONSTRAINT fk_nome_prodotto;
       public          postgres    false    204    2713    203            �
           2606    16485    acquisto fk_username_socio    FK CONSTRAINT     �   ALTER TABLE ONLY public.acquisto
    ADD CONSTRAINT fk_username_socio FOREIGN KEY (username_socio) REFERENCES public.utente(username) MATCH FULL;
 D   ALTER TABLE ONLY public.acquisto DROP CONSTRAINT fk_username_socio;
       public          postgres    false    2711    202    204            �
           2606    16656    prenotazione fk_username_socio    FK CONSTRAINT     �   ALTER TABLE ONLY public.prenotazione
    ADD CONSTRAINT fk_username_socio FOREIGN KEY (username_socio) REFERENCES public.utente(username) MATCH FULL;
 H   ALTER TABLE ONLY public.prenotazione DROP CONSTRAINT fk_username_socio;
       public          postgres    false    2711    206    202            $      x������ � �      %   �   x���M�0F�����P���ѕ4M�$.��vc�퐰��:�`�՟�۵�{>�\�O�Y��'&D���G����w\�@#sry�Гj,W;&q��.>q,L"���My(�C���Ь�f=4�BG�����_� �k߀��ݪ��C�gN��l,�q7uSQ7�!!w���&ЯI�;���'�,���e!���G"      &      x������ � �      #   �   x����,*Q�ϩ�-�LT��44�10PxԴ��Ȁ+M:��|0��s~Yj�BpnbQIAF~^*L�)�����T�������#�tTC����D����'ggG�Ă�Ҝ�b#�dNCS|J�@*p��� Ä������<�����w1<����pF�=... 5��7      "   2  x���=o�0��˯�K�J��� �J[�. !�N]�إ'%6��V���5Q)�����8טN��Ĵ���
~@ْ��e�`A�e_�d@TՌ��LX�VsIML�9�{BND0(�"gyɊ"���j&&�,!��M�����b�T,�<h����_�E8}�ڿv�1���طRn�d���#H�c����V�^1��!�x皴SZ���&����ö�F�ލnGke�:�q`���[F_DB��T'�Uz�
�E�sg�� wմ�η�֟�ꍟ2CSp��l{�ȍ�jO���;��"��/��gY���ˁ     