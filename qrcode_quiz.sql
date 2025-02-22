PGDMP                       }            qrcode_quiz    16.3    16.3 a    n           0    0    ENCODING    ENCODING        SET client_encoding = 'UTF8';
                      false            o           0    0 
   STDSTRINGS 
   STDSTRINGS     (   SET standard_conforming_strings = 'on';
                      false            p           0    0 
   SEARCHPATH 
   SEARCHPATH     8   SELECT pg_catalog.set_config('search_path', '', false);
                      false            q           1262    29614    qrcode_quiz    DATABASE     ~   CREATE DATABASE qrcode_quiz WITH TEMPLATE = template0 ENCODING = 'UTF8' LOCALE_PROVIDER = libc LOCALE = 'French_France.1252';
    DROP DATABASE qrcode_quiz;
                postgres    false            �            1259    30419    cache    TABLE     �   CREATE TABLE public.cache (
    key character varying(255) NOT NULL,
    value text NOT NULL,
    expiration integer NOT NULL
);
    DROP TABLE public.cache;
       public         heap    postgres    false            �            1259    30426    cache_locks    TABLE     �   CREATE TABLE public.cache_locks (
    key character varying(255) NOT NULL,
    owner character varying(255) NOT NULL,
    expiration integer NOT NULL
);
    DROP TABLE public.cache_locks;
       public         heap    postgres    false            �            1259    30495    events    TABLE     *  CREATE TABLE public.events (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    description text,
    start_date timestamp(0) without time zone NOT NULL,
    end_date timestamp(0) without time zone NOT NULL,
    location character varying(255),
    qr_code_url character varying(255),
    max_participants integer,
    is_active boolean DEFAULT true NOT NULL,
    created_by bigint NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone
);
    DROP TABLE public.events;
       public         heap    postgres    false            �            1259    30494    events_id_seq    SEQUENCE     v   CREATE SEQUENCE public.events_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 $   DROP SEQUENCE public.events_id_seq;
       public          postgres    false    230            r           0    0    events_id_seq    SEQUENCE OWNED BY     ?   ALTER SEQUENCE public.events_id_seq OWNED BY public.events.id;
          public          postgres    false    229            �            1259    30555    events_statistics    TABLE     �   CREATE TABLE public.events_statistics (
    id bigint NOT NULL,
    event_id bigint NOT NULL,
    data json NOT NULL,
    stat_date date NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);
 %   DROP TABLE public.events_statistics;
       public         heap    postgres    false            �            1259    30554    events_statistics_id_seq    SEQUENCE     �   CREATE SEQUENCE public.events_statistics_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 /   DROP SEQUENCE public.events_statistics_id_seq;
       public          postgres    false    238            s           0    0    events_statistics_id_seq    SEQUENCE OWNED BY     U   ALTER SEQUENCE public.events_statistics_id_seq OWNED BY public.events_statistics.id;
          public          postgres    false    237            �            1259    30434    failed_jobs    TABLE     &  CREATE TABLE public.failed_jobs (
    id bigint NOT NULL,
    uuid character varying(255) NOT NULL,
    connection text NOT NULL,
    queue text NOT NULL,
    payload text NOT NULL,
    exception text NOT NULL,
    failed_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL
);
    DROP TABLE public.failed_jobs;
       public         heap    postgres    false            �            1259    30433    failed_jobs_id_seq    SEQUENCE     {   CREATE SEQUENCE public.failed_jobs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 )   DROP SEQUENCE public.failed_jobs_id_seq;
       public          postgres    false    220            t           0    0    failed_jobs_id_seq    SEQUENCE OWNED BY     I   ALTER SEQUENCE public.failed_jobs_id_seq OWNED BY public.failed_jobs.id;
          public          postgres    false    219            �            1259    30446    jobs    TABLE     �   CREATE TABLE public.jobs (
    id bigint NOT NULL,
    queue character varying(255) NOT NULL,
    payload text NOT NULL,
    attempts smallint NOT NULL,
    reserved_at integer,
    available_at integer NOT NULL,
    created_at integer NOT NULL
);
    DROP TABLE public.jobs;
       public         heap    postgres    false            �            1259    30445    jobs_id_seq    SEQUENCE     t   CREATE SEQUENCE public.jobs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 "   DROP SEQUENCE public.jobs_id_seq;
       public          postgres    false    222            u           0    0    jobs_id_seq    SEQUENCE OWNED BY     ;   ALTER SEQUENCE public.jobs_id_seq OWNED BY public.jobs.id;
          public          postgres    false    221            �            1259    30413 
   migrations    TABLE     �   CREATE TABLE public.migrations (
    id integer NOT NULL,
    migration character varying(255) NOT NULL,
    batch integer NOT NULL
);
    DROP TABLE public.migrations;
       public         heap    postgres    false            �            1259    30412    migrations_id_seq    SEQUENCE     �   CREATE SEQUENCE public.migrations_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 (   DROP SEQUENCE public.migrations_id_seq;
       public          postgres    false    216            v           0    0    migrations_id_seq    SEQUENCE OWNED BY     G   ALTER SEQUENCE public.migrations_id_seq OWNED BY public.migrations.id;
          public          postgres    false    215            �            1259    30455    password_reset_tokens    TABLE     �   CREATE TABLE public.password_reset_tokens (
    email character varying(255) NOT NULL,
    token character varying(255) NOT NULL,
    created_at timestamp(0) without time zone
);
 )   DROP TABLE public.password_reset_tokens;
       public         heap    postgres    false            �            1259    30529    qr_scans    TABLE     4  CREATE TABLE public.qr_scans (
    id bigint NOT NULL,
    user_id bigint NOT NULL,
    event_id bigint NOT NULL,
    scanned_at timestamp(0) without time zone NOT NULL,
    scan_location character varying(255),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);
    DROP TABLE public.qr_scans;
       public         heap    postgres    false            �            1259    30528    qr_scans_id_seq    SEQUENCE     x   CREATE SEQUENCE public.qr_scans_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 &   DROP SEQUENCE public.qr_scans_id_seq;
       public          postgres    false    234            w           0    0    qr_scans_id_seq    SEQUENCE OWNED BY     C   ALTER SEQUENCE public.qr_scans_id_seq OWNED BY public.qr_scans.id;
          public          postgres    false    233            �            1259    30484 	   questions    TABLE     =  CREATE TABLE public.questions (
    id bigint NOT NULL,
    question character varying(255) NOT NULL,
    options json NOT NULL,
    correct_answer integer DEFAULT 0 NOT NULL,
    is_active boolean DEFAULT true NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);
    DROP TABLE public.questions;
       public         heap    postgres    false            �            1259    30483    questions_id_seq    SEQUENCE     y   CREATE SEQUENCE public.questions_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 '   DROP SEQUENCE public.questions_id_seq;
       public          postgres    false    228            x           0    0    questions_id_seq    SEQUENCE OWNED BY     E   ALTER SEQUENCE public.questions_id_seq OWNED BY public.questions.id;
          public          postgres    false    227            �            1259    30510 	   responses    TABLE     C  CREATE TABLE public.responses (
    id bigint NOT NULL,
    user_id bigint NOT NULL,
    question_id bigint NOT NULL,
    selected_answer integer NOT NULL,
    is_correct boolean NOT NULL,
    answers jsonb,
    feedback text,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);
    DROP TABLE public.responses;
       public         heap    postgres    false            �            1259    30509    responses_id_seq    SEQUENCE     y   CREATE SEQUENCE public.responses_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 '   DROP SEQUENCE public.responses_id_seq;
       public          postgres    false    232            y           0    0    responses_id_seq    SEQUENCE OWNED BY     E   ALTER SEQUENCE public.responses_id_seq OWNED BY public.responses.id;
          public          postgres    false    231            �            1259    30474    sessions    TABLE     �   CREATE TABLE public.sessions (
    id character varying(255) NOT NULL,
    user_id bigint,
    ip_address character varying(45),
    user_agent text,
    payload text NOT NULL,
    last_activity integer NOT NULL
);
    DROP TABLE public.sessions;
       public         heap    postgres    false            �            1259    30546 
   statistics    TABLE     �   CREATE TABLE public.statistics (
    id bigint NOT NULL,
    stat_type character varying(255) NOT NULL,
    data json NOT NULL,
    stat_date date NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);
    DROP TABLE public.statistics;
       public         heap    postgres    false            �            1259    30545    statistics_id_seq    SEQUENCE     z   CREATE SEQUENCE public.statistics_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 (   DROP SEQUENCE public.statistics_id_seq;
       public          postgres    false    236            z           0    0    statistics_id_seq    SEQUENCE OWNED BY     G   ALTER SEQUENCE public.statistics_id_seq OWNED BY public.statistics.id;
          public          postgres    false    235            �            1259    30463    users    TABLE     �  CREATE TABLE public.users (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    email character varying(255) NOT NULL,
    email_verified_at timestamp(0) without time zone,
    password character varying(255) NOT NULL,
    is_admin boolean DEFAULT false NOT NULL,
    remember_token character varying(100),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone
);
    DROP TABLE public.users;
       public         heap    postgres    false            �            1259    30462    users_id_seq    SEQUENCE     u   CREATE SEQUENCE public.users_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 #   DROP SEQUENCE public.users_id_seq;
       public          postgres    false    225            {           0    0    users_id_seq    SEQUENCE OWNED BY     =   ALTER SEQUENCE public.users_id_seq OWNED BY public.users.id;
          public          postgres    false    224            �           2604    30498 	   events id    DEFAULT     f   ALTER TABLE ONLY public.events ALTER COLUMN id SET DEFAULT nextval('public.events_id_seq'::regclass);
 8   ALTER TABLE public.events ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    230    229    230            �           2604    30558    events_statistics id    DEFAULT     |   ALTER TABLE ONLY public.events_statistics ALTER COLUMN id SET DEFAULT nextval('public.events_statistics_id_seq'::regclass);
 C   ALTER TABLE public.events_statistics ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    237    238    238            �           2604    30437    failed_jobs id    DEFAULT     p   ALTER TABLE ONLY public.failed_jobs ALTER COLUMN id SET DEFAULT nextval('public.failed_jobs_id_seq'::regclass);
 =   ALTER TABLE public.failed_jobs ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    219    220    220            �           2604    30449    jobs id    DEFAULT     b   ALTER TABLE ONLY public.jobs ALTER COLUMN id SET DEFAULT nextval('public.jobs_id_seq'::regclass);
 6   ALTER TABLE public.jobs ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    222    221    222            �           2604    30416    migrations id    DEFAULT     n   ALTER TABLE ONLY public.migrations ALTER COLUMN id SET DEFAULT nextval('public.migrations_id_seq'::regclass);
 <   ALTER TABLE public.migrations ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    215    216    216            �           2604    30532    qr_scans id    DEFAULT     j   ALTER TABLE ONLY public.qr_scans ALTER COLUMN id SET DEFAULT nextval('public.qr_scans_id_seq'::regclass);
 :   ALTER TABLE public.qr_scans ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    233    234    234            �           2604    30487    questions id    DEFAULT     l   ALTER TABLE ONLY public.questions ALTER COLUMN id SET DEFAULT nextval('public.questions_id_seq'::regclass);
 ;   ALTER TABLE public.questions ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    228    227    228            �           2604    30513    responses id    DEFAULT     l   ALTER TABLE ONLY public.responses ALTER COLUMN id SET DEFAULT nextval('public.responses_id_seq'::regclass);
 ;   ALTER TABLE public.responses ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    231    232    232            �           2604    30549    statistics id    DEFAULT     n   ALTER TABLE ONLY public.statistics ALTER COLUMN id SET DEFAULT nextval('public.statistics_id_seq'::regclass);
 <   ALTER TABLE public.statistics ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    235    236    236            �           2604    30466    users id    DEFAULT     d   ALTER TABLE ONLY public.users ALTER COLUMN id SET DEFAULT nextval('public.users_id_seq'::regclass);
 7   ALTER TABLE public.users ALTER COLUMN id DROP DEFAULT;
       public          postgres    false    225    224    225            V          0    30419    cache 
   TABLE DATA           7   COPY public.cache (key, value, expiration) FROM stdin;
    public          postgres    false    217   �r       W          0    30426    cache_locks 
   TABLE DATA           =   COPY public.cache_locks (key, owner, expiration) FROM stdin;
    public          postgres    false    218   $�       c          0    30495    events 
   TABLE DATA           �   COPY public.events (id, name, description, start_date, end_date, location, qr_code_url, max_participants, is_active, created_by, created_at, updated_at, deleted_at) FROM stdin;
    public          postgres    false    230   A�       k          0    30555    events_statistics 
   TABLE DATA           b   COPY public.events_statistics (id, event_id, data, stat_date, created_at, updated_at) FROM stdin;
    public          postgres    false    238   ^�       Y          0    30434    failed_jobs 
   TABLE DATA           a   COPY public.failed_jobs (id, uuid, connection, queue, payload, exception, failed_at) FROM stdin;
    public          postgres    false    220   {�       [          0    30446    jobs 
   TABLE DATA           c   COPY public.jobs (id, queue, payload, attempts, reserved_at, available_at, created_at) FROM stdin;
    public          postgres    false    222   ��       U          0    30413 
   migrations 
   TABLE DATA           :   COPY public.migrations (id, migration, batch) FROM stdin;
    public          postgres    false    216   ��       \          0    30455    password_reset_tokens 
   TABLE DATA           I   COPY public.password_reset_tokens (email, token, created_at) FROM stdin;
    public          postgres    false    223   �       g          0    30529    qr_scans 
   TABLE DATA           l   COPY public.qr_scans (id, user_id, event_id, scanned_at, scan_location, created_at, updated_at) FROM stdin;
    public          postgres    false    234   7�       a          0    30484 	   questions 
   TABLE DATA           m   COPY public.questions (id, question, options, correct_answer, is_active, created_at, updated_at) FROM stdin;
    public          postgres    false    228   T�       e          0    30510 	   responses 
   TABLE DATA           �   COPY public.responses (id, user_id, question_id, selected_answer, is_correct, answers, feedback, created_at, updated_at) FROM stdin;
    public          postgres    false    232   )�       _          0    30474    sessions 
   TABLE DATA           _   COPY public.sessions (id, user_id, ip_address, user_agent, payload, last_activity) FROM stdin;
    public          postgres    false    226   ��       i          0    30546 
   statistics 
   TABLE DATA           \   COPY public.statistics (id, stat_type, data, stat_date, created_at, updated_at) FROM stdin;
    public          postgres    false    236   `�       ^          0    30463    users 
   TABLE DATA           �   COPY public.users (id, name, email, email_verified_at, password, is_admin, remember_token, created_at, updated_at, deleted_at) FROM stdin;
    public          postgres    false    225   �       |           0    0    events_id_seq    SEQUENCE SET     <   SELECT pg_catalog.setval('public.events_id_seq', 1, false);
          public          postgres    false    229            }           0    0    events_statistics_id_seq    SEQUENCE SET     G   SELECT pg_catalog.setval('public.events_statistics_id_seq', 1, false);
          public          postgres    false    237            ~           0    0    failed_jobs_id_seq    SEQUENCE SET     A   SELECT pg_catalog.setval('public.failed_jobs_id_seq', 1, false);
          public          postgres    false    219                       0    0    jobs_id_seq    SEQUENCE SET     :   SELECT pg_catalog.setval('public.jobs_id_seq', 1, false);
          public          postgres    false    221            �           0    0    migrations_id_seq    SEQUENCE SET     ?   SELECT pg_catalog.setval('public.migrations_id_seq', 2, true);
          public          postgres    false    215            �           0    0    qr_scans_id_seq    SEQUENCE SET     >   SELECT pg_catalog.setval('public.qr_scans_id_seq', 1, false);
          public          postgres    false    233            �           0    0    questions_id_seq    SEQUENCE SET     >   SELECT pg_catalog.setval('public.questions_id_seq', 7, true);
          public          postgres    false    227            �           0    0    responses_id_seq    SEQUENCE SET     >   SELECT pg_catalog.setval('public.responses_id_seq', 7, true);
          public          postgres    false    231            �           0    0    statistics_id_seq    SEQUENCE SET     ?   SELECT pg_catalog.setval('public.statistics_id_seq', 2, true);
          public          postgres    false    235            �           0    0    users_id_seq    SEQUENCE SET     :   SELECT pg_catalog.setval('public.users_id_seq', 1, true);
          public          postgres    false    224            �           2606    30432    cache_locks cache_locks_pkey 
   CONSTRAINT     [   ALTER TABLE ONLY public.cache_locks
    ADD CONSTRAINT cache_locks_pkey PRIMARY KEY (key);
 F   ALTER TABLE ONLY public.cache_locks DROP CONSTRAINT cache_locks_pkey;
       public            postgres    false    218            �           2606    30425    cache cache_pkey 
   CONSTRAINT     O   ALTER TABLE ONLY public.cache
    ADD CONSTRAINT cache_pkey PRIMARY KEY (key);
 :   ALTER TABLE ONLY public.cache DROP CONSTRAINT cache_pkey;
       public            postgres    false    217            �           2606    30503    events events_pkey 
   CONSTRAINT     P   ALTER TABLE ONLY public.events
    ADD CONSTRAINT events_pkey PRIMARY KEY (id);
 <   ALTER TABLE ONLY public.events DROP CONSTRAINT events_pkey;
       public            postgres    false    230            �           2606    30562 (   events_statistics events_statistics_pkey 
   CONSTRAINT     f   ALTER TABLE ONLY public.events_statistics
    ADD CONSTRAINT events_statistics_pkey PRIMARY KEY (id);
 R   ALTER TABLE ONLY public.events_statistics DROP CONSTRAINT events_statistics_pkey;
       public            postgres    false    238            �           2606    30442    failed_jobs failed_jobs_pkey 
   CONSTRAINT     Z   ALTER TABLE ONLY public.failed_jobs
    ADD CONSTRAINT failed_jobs_pkey PRIMARY KEY (id);
 F   ALTER TABLE ONLY public.failed_jobs DROP CONSTRAINT failed_jobs_pkey;
       public            postgres    false    220            �           2606    30444 #   failed_jobs failed_jobs_uuid_unique 
   CONSTRAINT     ^   ALTER TABLE ONLY public.failed_jobs
    ADD CONSTRAINT failed_jobs_uuid_unique UNIQUE (uuid);
 M   ALTER TABLE ONLY public.failed_jobs DROP CONSTRAINT failed_jobs_uuid_unique;
       public            postgres    false    220            �           2606    30453    jobs jobs_pkey 
   CONSTRAINT     L   ALTER TABLE ONLY public.jobs
    ADD CONSTRAINT jobs_pkey PRIMARY KEY (id);
 8   ALTER TABLE ONLY public.jobs DROP CONSTRAINT jobs_pkey;
       public            postgres    false    222            �           2606    30418    migrations migrations_pkey 
   CONSTRAINT     X   ALTER TABLE ONLY public.migrations
    ADD CONSTRAINT migrations_pkey PRIMARY KEY (id);
 D   ALTER TABLE ONLY public.migrations DROP CONSTRAINT migrations_pkey;
       public            postgres    false    216            �           2606    30461 0   password_reset_tokens password_reset_tokens_pkey 
   CONSTRAINT     q   ALTER TABLE ONLY public.password_reset_tokens
    ADD CONSTRAINT password_reset_tokens_pkey PRIMARY KEY (email);
 Z   ALTER TABLE ONLY public.password_reset_tokens DROP CONSTRAINT password_reset_tokens_pkey;
       public            postgres    false    223            �           2606    30534    qr_scans qr_scans_pkey 
   CONSTRAINT     T   ALTER TABLE ONLY public.qr_scans
    ADD CONSTRAINT qr_scans_pkey PRIMARY KEY (id);
 @   ALTER TABLE ONLY public.qr_scans DROP CONSTRAINT qr_scans_pkey;
       public            postgres    false    234            �           2606    30493    questions questions_pkey 
   CONSTRAINT     V   ALTER TABLE ONLY public.questions
    ADD CONSTRAINT questions_pkey PRIMARY KEY (id);
 B   ALTER TABLE ONLY public.questions DROP CONSTRAINT questions_pkey;
       public            postgres    false    228            �           2606    30517    responses responses_pkey 
   CONSTRAINT     V   ALTER TABLE ONLY public.responses
    ADD CONSTRAINT responses_pkey PRIMARY KEY (id);
 B   ALTER TABLE ONLY public.responses DROP CONSTRAINT responses_pkey;
       public            postgres    false    232            �           2606    30480    sessions sessions_pkey 
   CONSTRAINT     T   ALTER TABLE ONLY public.sessions
    ADD CONSTRAINT sessions_pkey PRIMARY KEY (id);
 @   ALTER TABLE ONLY public.sessions DROP CONSTRAINT sessions_pkey;
       public            postgres    false    226            �           2606    30553    statistics statistics_pkey 
   CONSTRAINT     X   ALTER TABLE ONLY public.statistics
    ADD CONSTRAINT statistics_pkey PRIMARY KEY (id);
 D   ALTER TABLE ONLY public.statistics DROP CONSTRAINT statistics_pkey;
       public            postgres    false    236            �           2606    30473    users users_email_unique 
   CONSTRAINT     T   ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_email_unique UNIQUE (email);
 B   ALTER TABLE ONLY public.users DROP CONSTRAINT users_email_unique;
       public            postgres    false    225            �           2606    30471    users users_pkey 
   CONSTRAINT     N   ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);
 :   ALTER TABLE ONLY public.users DROP CONSTRAINT users_pkey;
       public            postgres    false    225            �           1259    30454    jobs_queue_index    INDEX     B   CREATE INDEX jobs_queue_index ON public.jobs USING btree (queue);
 $   DROP INDEX public.jobs_queue_index;
       public            postgres    false    222            �           1259    30482    sessions_last_activity_index    INDEX     Z   CREATE INDEX sessions_last_activity_index ON public.sessions USING btree (last_activity);
 0   DROP INDEX public.sessions_last_activity_index;
       public            postgres    false    226            �           1259    30481    sessions_user_id_index    INDEX     N   CREATE INDEX sessions_user_id_index ON public.sessions USING btree (user_id);
 *   DROP INDEX public.sessions_user_id_index;
       public            postgres    false    226            �           2606    30504     events events_created_by_foreign    FK CONSTRAINT     �   ALTER TABLE ONLY public.events
    ADD CONSTRAINT events_created_by_foreign FOREIGN KEY (created_by) REFERENCES public.users(id);
 J   ALTER TABLE ONLY public.events DROP CONSTRAINT events_created_by_foreign;
       public          postgres    false    230    225    4782            �           2606    30563 4   events_statistics events_statistics_event_id_foreign    FK CONSTRAINT     �   ALTER TABLE ONLY public.events_statistics
    ADD CONSTRAINT events_statistics_event_id_foreign FOREIGN KEY (event_id) REFERENCES public.events(id) ON DELETE CASCADE;
 ^   ALTER TABLE ONLY public.events_statistics DROP CONSTRAINT events_statistics_event_id_foreign;
       public          postgres    false    4790    230    238            �           2606    30540 "   qr_scans qr_scans_event_id_foreign    FK CONSTRAINT     �   ALTER TABLE ONLY public.qr_scans
    ADD CONSTRAINT qr_scans_event_id_foreign FOREIGN KEY (event_id) REFERENCES public.events(id) ON DELETE CASCADE;
 L   ALTER TABLE ONLY public.qr_scans DROP CONSTRAINT qr_scans_event_id_foreign;
       public          postgres    false    230    234    4790            �           2606    30535 !   qr_scans qr_scans_user_id_foreign    FK CONSTRAINT     �   ALTER TABLE ONLY public.qr_scans
    ADD CONSTRAINT qr_scans_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE CASCADE;
 K   ALTER TABLE ONLY public.qr_scans DROP CONSTRAINT qr_scans_user_id_foreign;
       public          postgres    false    225    4782    234            �           2606    30523 '   responses responses_question_id_foreign    FK CONSTRAINT     �   ALTER TABLE ONLY public.responses
    ADD CONSTRAINT responses_question_id_foreign FOREIGN KEY (question_id) REFERENCES public.questions(id) ON DELETE CASCADE;
 Q   ALTER TABLE ONLY public.responses DROP CONSTRAINT responses_question_id_foreign;
       public          postgres    false    228    232    4788            �           2606    30518 #   responses responses_user_id_foreign    FK CONSTRAINT     �   ALTER TABLE ONLY public.responses
    ADD CONSTRAINT responses_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE CASCADE;
 M   ALTER TABLE ONLY public.responses DROP CONSTRAINT responses_user_id_foreign;
       public          postgres    false    4782    232    225            V   =  x��[�n��Ѿ�~
�7����e[�d��&em$E�@@�EJ�,j#�~�~�~�T.Z,yz2@2��u�:_-_�!��q����O�,���k�����
�P�ݙ>rg�����%6���nla߱�}bh
cj�����A�����4o��D�146�kw� �|�;����[x�6��Dk,m���z�N&w�G�E{9���sԚq���[���'ak�^�[������Z��mf��cL�p�5��B���<�s�z���X�����/�E�ڰ�*α�uT'�4o�pL��s�Y�)�8))�շ��O�'�|�'�^vl�sh�>�پ踾t��v,0���&�pl��Q���� �z�<���Dl���o��.`챬��O��kp +�=�"��;���=�H�.`��g�2��3�s����qR��O8�%�����r�1��vʏ �z�x�E�Tw��!�����')=��	�?�0'Y
�+�s��:S]�-q�K"�=��ٸ���m�M ]����m"	�͌��_S:�����:��Y�/�,	0�2��y��� �A�DZ�g��ao��u�=6��v�k�.,����뜰!���Ӝ�z@}���e�>�~�G7ǣy3���!4\;�[�cy�J�1���L&�[{y�J'b�܎�\[o/���κ�7@G6�tR���S{)�7<��
��&����$q�J"ڃ>�����k�3��0ƭ��s�����3h�o*
�����s_-I�R�5����~4��N|���!��lIX�#���ٜ��v�*�>&lÅ����6�C�>�-�K�a��0GJ�ľLZ�����:��`1e���sY"�~��F��<���إ/��^�ص�}��O�㧀�gz?�ѸŢ|9���0�~�;�0퓂}��K��]����6Z`tݬX���(h��F�=8������|�E�(&|pytE�����ai�}ځ�Y��g�<��{���d�2��6�_�Џq��aMNcbFu̩���cqg�����V/��Lm�ueo#&��O��K_4b�g���o���K�W���x�yP0�p�� GB|�B�7t���]!shkBj���{v�����7L�;�)���*���VO!���`8�B���Y�������Y�!�i�9��Qyvh[�����	 ����ԙ��r��|��8��Ժ��w�g��Ò�)�l0�Z���sO�����|�<�`��U_W���l�ov�=g@a���τ�;N,d_I!��(+�Pۛ���Y�!�<A{�]�B��P�}}X���QP�]j6ㄝ���әQ\�*6&6bY�'�ݹv9��ڕ�]���5~�������# .ov>pBw���a9��/�72�%�r���.�36`�ʩ��y�J}X|��R�:-����u��Ϻ2�F�;�!ط���y��ϐg�6��hQ�����nR�s�M�c��� ��T7R��<�G�9��7�2�t��I�r(�bԋE��.���|J74�<J��<�b�,�g���i��I��ǿ���D� /��9�[��P�En
��K��9i'/�k��]�Yw�1V�+��!�՝!�ڹ'�sa��������9ʷYW/�0�,Po�]���H9??ͮ�0���O�o���g�w�E��5=7s� ��A�X��"4��~�32��<�)���X�X������9Z��ܲց�땘���b[l�t��`k�;3�ݝ�Hu�+����F��mQ<\�5�eޕ���̢~<�/�|�m��'�����|�,����z�$�mr�e^����Þ(�g:���������w�-p}B��訦�[y\�lD�ZAc�Q����vF0�g�uS���u�-�B�'��>�\�>^.bFY����������\@�<]�79��1���|Z�Ct��Gѕ<���Ks���4�<�4�}��(<8��v���9��u�=�i�_�d,�
d4t7.����3�y
�e�z~�䓣� -��Ś�W���%�' �=�X���z�ԝ� ��B�)}�OdWy�6�#G�ʚΗz�������3�s�{�6P߱�Ȃ�@�w����KZ���{V��������a/��ec���;Y��g��|�����J�b�	y�9�ؓ�Θ�.�m(ż��:=���we�^ޕ ���hc]�����1�ni��k��?����V?��@�k�X���+0'1Ͼ��,�~~�rn�E9�;�r�[����[�p�.�����>��=�m��9������<Bc�:z*�d�'� n�`<~tw�w�u[t�9wĮ����3�g���;�4Y����t�ۿ������n�������/Ք��g��������֐<�r�J�����9����D� k��5�ҙ�S����jj�g�Ԭ�o�ųy�ST���2>���:q���l1;}����$��ޓ`Q�ޓX������Flf��K�y�qy۠?�ȏ���|�����_:у���9���0��8�{����8��q<{���_������E�/��� �R����0z�w��s�lG9c�ni�>r��L߯�m� kQ��֙`+�f��	��v�����_�'�?|���5=w��Ͱ���}��-�;'�%��3]e��n��i6����W�]?����q>��@�ãm�x�?��J�!�k|�`Bj��N4tYO������v����ß���ow��x���#�"�s�F�����;��s�1�&��}�\���g�>��z3�|6F���6�M�%SjGO��c��Q����/��a#u��������+j{r��O�쐻��x�b��㠱�ENφ9������	}__���9���#j�2E����˭�=45�Ge��T��1�}ns��~�5B���2�*�3�9��_Ȫ�w_����H �˜O�~ǴG�����ޯ�W������ c�'�1�%��V0:���Zx	��n��lT�ó�LiǳP�Ih���G��(�3&��21������!γ�\Ko��T<���������L�%9��e�b����gU�����v��K_�If�< ��5�;����_����s?�SNr�W��)j�����z����ٿ�{�/ÿ��'������i�$q&�?���N~2���zM�g�Yo�3i>5�ފ����4����p���S�ƚoֈ{k��~VfH���q0��b�k�;X��e��޼{5W4�>t�K� �p��мk;+����d�^y���_�7m���^�.����<��J�\G ��4Y�y;+�ks�/d7Y��K��Rv�~~��-���Úݰ���c���o�Q��m��[�����Т�o�4���C��wl�QE�6�%Jy/_b��� �=�V�J|r��#�_A�ɭ'�����6��k���k���-|l@,o��5��Ń=J��Ǫ����p]v"b,_uJ��9�}��ì)���q�����#�s��ƫ �Vo֞�%`NX���Cx�Я�ڍ�
SP[�ܚc������ac	!����?�P�_�O�<vٛ�h�N|ڄ����B'��k����a��:�"v�y���M�GM|�T�����=\s��sȨ9��f���N��9-�/ÌZw������Eۡ�I�0�3�l �aa���Q�b�L>{�錄����Q�<����B
_?"����oQh�lti��W�r�q��Z��$�����^=b&�0�@s�Bx�����$��[1+˱+1�Zd �����N�L�J@J���lT�'I�+��IK2�l3�z�{\/�gYu>�u��U/_l������;,8���|1I�^�ur:��g�� ���$�
��}	1���p��sm���˧O��)F�      W      x������ � �      c      x������ � �      k      x������ � �      Y      x������ � �      [      x������ � �      U   U   x�U�1� @љ�P�ۘ4:0(�-��G��?<)�LiEB\��.T��`2�Q|������V:�
ݣ=3b��eS� ��      \      x������ � �      g      x������ � �      a   �  x����n�0���S���e��x�{ڡ�6X��a違8[�Ly�l ������������%�?��$�Ѡ1(���Pi+��(>G��[p�����ZR�w��hbg�i5����G�x�.�d�JD����u�Vn��.I��Q߱}��NH�wl����(��L����#�N3�dY:���%����ǹQT��E��*ae�	Ո�G��.��&�1���������Ο{��(|#���_;9��F�����˪�e���-=O�xmt�Z"	�n=n��x�������?l���LDJ�NH5.,��$b�w�^۾#,�����(�R،��zq�/n���E���G@�4>@��<P���En���Vrp��|�٧�F�h2x�(�'��|�j���|f�}<K�TX�/MR��Zh甇��½�b�%�u�	���-��W���f���W$�      e   y   x���1� �Ṝ�0���B�,���f��τ�����O���21n������8� (�i4��h��ܴ���!��s�9�gn�-�_oN`z��R%��9U�(�S)D��ګQ1�W��}������ri      _   �  x�=PMs�@=㯘cR���T*"A�ٸ(B�/�� $"(�~�uk�]���������BMºꓯ,��xC����y�#~biթ�%��SY�H32��6��S�NY3���P�_� ���X}f��<ȓ�fҧ����'���*N�V�3X�M�� R�N�����)������!v�!'J�������j�������N�Wf�7b�D�N6.��=y�6���lM�9�O^<�
e�1��E�|2�ؘ���'���Z�x ��K��[v-M�#h�v�H��j�g����}`Z�"�/S�օ�-M��ͯ����:�KS���("�����6�)��>R��2�9��W�1�mIj�������V�,�cVo�������Ԩ�+�oKK[?~��JPGs�`h����d2�)(��      i   �   x����� Eg�
�l�v�[L�}5$(<:h�wm������=W1\0�I��Y��\�.(�T��Gf��"��byU�T=d�
���ʶo�j�jJ���O�[6Ww3	��n�}2�C�o�bc�yn����\������8�O�Xp      ^   �   x�3�tL����L��+IL.qH-K�+)�M�,K�K���4202�50�56T04�25�21�T1�T14R���)3�(�M56p1έp,�.MO���K�r�Έ0,�	0M�ӫ2�,�/-M4	��N�,���j*6�?�=... ��,T     