--
-- PostgreSQL database dump
--

-- Dumped from database version 16.3
-- Dumped by pg_dump version 16.3

-- Started on 2025-02-22 19:47:55

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

--
-- TOC entry 4 (class 2615 OID 2200)
-- Name: public; Type: SCHEMA; Schema: -; Owner: pg_database_owner
--

CREATE SCHEMA public;


ALTER SCHEMA public OWNER TO pg_database_owner;

--
-- TOC entry 4923 (class 0 OID 0)
-- Dependencies: 4
-- Name: SCHEMA public; Type: COMMENT; Schema: -; Owner: pg_database_owner
--

COMMENT ON SCHEMA public IS 'standard public schema';


SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- TOC entry 227 (class 1259 OID 61906)
-- Name: answers; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.answers (
    id bigint NOT NULL,
    question_id bigint NOT NULL,
    content character varying(255) NOT NULL,
    is_correct boolean DEFAULT false NOT NULL,
    "order" integer DEFAULT 0 NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.answers OWNER TO postgres;

--
-- TOC entry 226 (class 1259 OID 61905)
-- Name: answers_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.answers_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.answers_id_seq OWNER TO postgres;

--
-- TOC entry 4924 (class 0 OID 0)
-- Dependencies: 226
-- Name: answers_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.answers_id_seq OWNED BY public.answers.id;


--
-- TOC entry 222 (class 1259 OID 53692)
-- Name: cache; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.cache (
    key character varying(255) NOT NULL,
    value text NOT NULL,
    expiration integer NOT NULL
);


ALTER TABLE public.cache OWNER TO postgres;

--
-- TOC entry 223 (class 1259 OID 53699)
-- Name: cache_locks; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.cache_locks (
    key character varying(255) NOT NULL,
    owner character varying(255) NOT NULL,
    expiration integer NOT NULL
);


ALTER TABLE public.cache_locks OWNER TO postgres;

--
-- TOC entry 230 (class 1259 OID 61931)
-- Name: comments; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.comments (
    id bigint NOT NULL,
    content text NOT NULL,
    table_id character varying(255) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.comments OWNER TO postgres;

--
-- TOC entry 229 (class 1259 OID 61930)
-- Name: comments_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.comments_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.comments_id_seq OWNER TO postgres;

--
-- TOC entry 4925 (class 0 OID 0)
-- Dependencies: 229
-- Name: comments_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.comments_id_seq OWNED BY public.comments.id;


--
-- TOC entry 216 (class 1259 OID 53654)
-- Name: migrations; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.migrations (
    id integer NOT NULL,
    migration character varying(255) NOT NULL,
    batch integer NOT NULL
);


ALTER TABLE public.migrations OWNER TO postgres;

--
-- TOC entry 215 (class 1259 OID 53653)
-- Name: migrations_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.migrations_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.migrations_id_seq OWNER TO postgres;

--
-- TOC entry 4926 (class 0 OID 0)
-- Dependencies: 215
-- Name: migrations_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.migrations_id_seq OWNED BY public.migrations.id;


--
-- TOC entry 228 (class 1259 OID 61919)
-- Name: questions_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.questions_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.questions_id_seq OWNER TO postgres;

--
-- TOC entry 217 (class 1259 OID 53660)
-- Name: questions; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.questions (
    id integer DEFAULT nextval('public.questions_id_seq'::regclass) NOT NULL,
    content text NOT NULL,
    options json NOT NULL,
    "order" integer NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.questions OWNER TO postgres;

--
-- TOC entry 225 (class 1259 OID 53730)
-- Name: response_history; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.response_history (
    id bigint NOT NULL,
    table_id character varying(255) NOT NULL,
    question_id bigint,
    selected_option character varying(255),
    feedback text,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.response_history OWNER TO postgres;

--
-- TOC entry 224 (class 1259 OID 53729)
-- Name: response_history_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.response_history_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.response_history_id_seq OWNER TO postgres;

--
-- TOC entry 4927 (class 0 OID 0)
-- Dependencies: 224
-- Name: response_history_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.response_history_id_seq OWNED BY public.response_history.id;


--
-- TOC entry 219 (class 1259 OID 53668)
-- Name: responses; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.responses (
    id bigint NOT NULL,
    question_id integer,
    selected_option character varying(255),
    table_id character varying(255) NOT NULL,
    feedback text,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.responses OWNER TO postgres;

--
-- TOC entry 218 (class 1259 OID 53667)
-- Name: responses_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.responses_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.responses_id_seq OWNER TO postgres;

--
-- TOC entry 4928 (class 0 OID 0)
-- Dependencies: 218
-- Name: responses_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.responses_id_seq OWNED BY public.responses.id;


--
-- TOC entry 221 (class 1259 OID 53682)
-- Name: users; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.users (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    email character varying(255) NOT NULL,
    email_verified_at timestamp(0) without time zone,
    password character varying(255) NOT NULL,
    remember_token character varying(100),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.users OWNER TO postgres;

--
-- TOC entry 220 (class 1259 OID 53681)
-- Name: users_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.users_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.users_id_seq OWNER TO postgres;

--
-- TOC entry 4929 (class 0 OID 0)
-- Dependencies: 220
-- Name: users_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.users_id_seq OWNED BY public.users.id;


--
-- TOC entry 4731 (class 2604 OID 61909)
-- Name: answers id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.answers ALTER COLUMN id SET DEFAULT nextval('public.answers_id_seq'::regclass);


--
-- TOC entry 4734 (class 2604 OID 61934)
-- Name: comments id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.comments ALTER COLUMN id SET DEFAULT nextval('public.comments_id_seq'::regclass);


--
-- TOC entry 4726 (class 2604 OID 53657)
-- Name: migrations id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.migrations ALTER COLUMN id SET DEFAULT nextval('public.migrations_id_seq'::regclass);


--
-- TOC entry 4730 (class 2604 OID 53733)
-- Name: response_history id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.response_history ALTER COLUMN id SET DEFAULT nextval('public.response_history_id_seq'::regclass);


--
-- TOC entry 4728 (class 2604 OID 53671)
-- Name: responses id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.responses ALTER COLUMN id SET DEFAULT nextval('public.responses_id_seq'::regclass);


--
-- TOC entry 4729 (class 2604 OID 53685)
-- Name: users id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users ALTER COLUMN id SET DEFAULT nextval('public.users_id_seq'::regclass);


--
-- TOC entry 4914 (class 0 OID 61906)
-- Dependencies: 227
-- Data for Name: answers; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.answers (id, question_id, content, is_correct, "order", created_at, updated_at) FROM stdin;
\.


--
-- TOC entry 4909 (class 0 OID 53692)
-- Dependencies: 222
-- Data for Name: cache; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.cache (key, value, expiration) FROM stdin;
\.


--
-- TOC entry 4910 (class 0 OID 53699)
-- Dependencies: 223
-- Data for Name: cache_locks; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.cache_locks (key, owner, expiration) FROM stdin;
\.


--
-- TOC entry 4917 (class 0 OID 61931)
-- Dependencies: 230
-- Data for Name: comments; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.comments (id, content, table_id, created_at, updated_at) FROM stdin;
\.


--
-- TOC entry 4903 (class 0 OID 53654)
-- Dependencies: 216
-- Data for Name: migrations; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.migrations (id, migration, batch) FROM stdin;
1	2024_02_19_162600_create_quiz_tables	1
2	2024_02_19_162900_create_users_table	1
3	2024_02_19_163100_create_cache_table	1
4	2025_02_19_163452_allow_null_selected_option	1
5	2025_02_19_163833_add_feedback_question	1
6	2025_02_19_164811_remove_feedback_question	1
8	2025_02_20_094557_remove_satisfaction_question	2
9	2025_02_20_151748_create_response_history_table	2
10	2025_02_21_095007_create_answers_table	3
11	2025_02_21_111148_fix_questions_id	4
13	2025_02_21_124113_create_comments_table	5
\.


--
-- TOC entry 4904 (class 0 OID 53660)
-- Dependencies: 217
-- Data for Name: questions; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.questions (id, content, options, "order", created_at, updated_at) FROM stdin;
1	Comment avez-vous trouvé la qualité de nos plats ?	["Excellent","Tr\\u00e8s bien","Bien","Peut mieux faire"]	4	2025-02-19 17:01:38	2025-02-21 09:56:01
3	Comment jugez-vous l'ambiance du restaurant ?	["Tr\\u00e8s agr\\u00e9able","Agr\\u00e9able","Correcte","\\u00c0 revoir"]	1	2025-02-19 17:01:38	2025-02-21 10:02:10
6	Avez vous aimez vos plats?	["oui","non","maybe","fasho"]	5	2025-02-21 12:14:39	2025-02-21 12:14:39
2	Le service était-il à la hauteur de vos attentes ?	["Parfait","Tr\\u00e8s satisfaisant","Satisfaisant","\\u00c0 am\\u00e9liorer"]	2	2025-02-19 17:01:38	2025-02-21 13:56:19
4	Le rapport qualité-prix vous semble-t-il justifié ?	["Tout \\u00e0 fait","Plut\\u00f4t oui","Moyen","Non"]	3	2025-02-19 17:01:38	2025-02-21 15:13:18
\.


--
-- TOC entry 4912 (class 0 OID 53730)
-- Dependencies: 225
-- Data for Name: response_history; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.response_history (id, table_id, question_id, selected_option, feedback, created_at, updated_at) FROM stdin;
1	default	1	Excellent	\N	2025-02-20 10:09:52	2025-02-20 10:09:52
2	default	2	À améliorer	\N	2025-02-20 10:09:52	2025-02-20 10:09:52
3	default	3	Correcte	\N	2025-02-20 10:09:52	2025-02-20 10:09:52
4	default	4	Moyen	\N	2025-02-20 10:09:52	2025-02-20 10:09:52
5	default	\N	Commentaire	etgfsdsdf	2025-02-20 10:09:52	2025-02-20 10:09:52
6	default	1	Bien	\N	2025-02-20 10:10:08	2025-02-20 10:10:08
7	default	2	À améliorer	\N	2025-02-20 10:10:08	2025-02-20 10:10:08
8	default	3	Correcte	\N	2025-02-20 10:10:08	2025-02-20 10:10:08
9	default	4	Non	\N	2025-02-20 10:10:08	2025-02-20 10:10:08
10	default	\N	Commentaire	efafez	2025-02-20 10:10:08	2025-02-20 10:10:08
11	default	1	Très bien	\N	2025-02-20 11:50:39	2025-02-20 11:50:39
12	default	2	À améliorer	\N	2025-02-20 11:50:39	2025-02-20 11:50:39
13	default	3	À revoir	\N	2025-02-20 11:50:39	2025-02-20 11:50:39
14	default	4	Moyen	\N	2025-02-20 11:50:39	2025-02-20 11:50:39
15	default	\N	Commentaire	ineadj	2025-02-20 11:50:39	2025-02-20 11:50:39
16	default	1	Excellent	\N	2025-02-20 11:53:15	2025-02-20 11:53:15
17	default	2	Satisfaisant	\N	2025-02-20 11:53:15	2025-02-20 11:53:15
18	default	3	À revoir	\N	2025-02-20 11:53:15	2025-02-20 11:53:15
19	default	4	Non	\N	2025-02-20 11:53:15	2025-02-20 11:53:15
20	default	\N	Commentaire	ghv	2025-02-20 11:53:15	2025-02-20 11:53:15
21	default	1	Très bien	\N	2025-02-20 11:55:35	2025-02-20 11:55:35
22	default	2	À améliorer	\N	2025-02-20 11:55:35	2025-02-20 11:55:35
23	default	3	À revoir	\N	2025-02-20 11:55:35	2025-02-20 11:55:35
24	default	4	Non	\N	2025-02-20 11:55:35	2025-02-20 11:55:35
25	default	\N	Commentaire	yvty	2025-02-20 11:55:35	2025-02-20 11:55:35
26	default	1	Peut mieux faire	\N	2025-02-20 14:07:37	2025-02-20 14:07:37
27	default	2	À améliorer	\N	2025-02-20 14:07:37	2025-02-20 14:07:37
28	default	3	Correcte	\N	2025-02-20 14:07:37	2025-02-20 14:07:37
29	default	4	Plutôt oui	\N	2025-02-20 14:07:37	2025-02-20 14:07:37
30	default	\N	Commentaire	EAAD	2025-02-20 14:07:37	2025-02-20 14:07:37
31	default	1	Très bien	\N	2025-02-20 14:14:17	2025-02-20 14:14:17
32	default	2	À améliorer	\N	2025-02-20 14:14:17	2025-02-20 14:14:17
33	default	3	Correcte	\N	2025-02-20 14:14:17	2025-02-20 14:14:17
34	default	4	Moyen	\N	2025-02-20 14:14:17	2025-02-20 14:14:17
35	default	\N	Commentaire	caecae	2025-02-20 14:14:17	2025-02-20 14:14:17
36	default	1	Très bien	\N	2025-02-20 14:16:51	2025-02-20 14:16:51
37	default	2	Parfait	\N	2025-02-20 14:16:51	2025-02-20 14:16:51
38	default	3	Agréable	\N	2025-02-20 14:16:51	2025-02-20 14:16:51
39	default	4	Moyen	\N	2025-02-20 14:16:51	2025-02-20 14:16:51
40	default	\N	Commentaire	frfzr	2025-02-20 14:16:51	2025-02-20 14:16:51
41	default	3	Agréable	\N	2025-02-21 10:18:55	2025-02-21 10:18:55
42	default	2	À améliorer	\N	2025-02-21 10:18:55	2025-02-21 10:18:55
43	default	4	Non	\N	2025-02-21 10:18:55	2025-02-21 10:18:55
44	default	1	Peut mieux faire	\N	2025-02-21 10:18:55	2025-02-21 10:18:55
46	default	\N	Commentaire	ef	2025-02-21 10:18:55	2025-02-21 10:18:55
47	default	3	Agréable	\N	2025-02-21 10:19:16	2025-02-21 10:19:16
48	default	2	À améliorer	\N	2025-02-21 10:19:16	2025-02-21 10:19:16
49	default	4	Non	\N	2025-02-21 10:19:16	2025-02-21 10:19:16
50	default	1	Peut mieux faire	\N	2025-02-21 10:19:16	2025-02-21 10:19:16
52	default	\N	Commentaire	ddeaz	2025-02-21 10:19:16	2025-02-21 10:19:16
53	default	3	Correcte	\N	2025-02-21 12:13:21	2025-02-21 12:13:21
54	default	2	À améliorer	\N	2025-02-21 12:13:21	2025-02-21 12:13:21
55	default	4	Non	\N	2025-02-21 12:13:21	2025-02-21 12:13:21
56	default	1	Bien	\N	2025-02-21 12:13:21	2025-02-21 12:13:21
57	default	\N	Commentaire	aefzf	2025-02-21 12:13:21	2025-02-21 12:13:21
58	default	3	Agréable	\N	2025-02-21 12:15:00	2025-02-21 12:15:00
59	default	2	À améliorer	\N	2025-02-21 12:15:00	2025-02-21 12:15:00
60	default	4	Moyen	\N	2025-02-21 12:15:00	2025-02-21 12:15:00
61	default	1	Bien	\N	2025-02-21 12:15:00	2025-02-21 12:15:00
62	default	6	maybe	\N	2025-02-21 12:15:00	2025-02-21 12:15:00
63	default	\N	Commentaire	zfz	2025-02-21 12:15:00	2025-02-21 12:15:00
64	default	3	Agréable	\N	2025-02-21 12:52:58	2025-02-21 12:52:58
65	default	2	À améliorer	\N	2025-02-21 12:52:58	2025-02-21 12:52:58
66	default	4	Moyen	\N	2025-02-21 12:52:58	2025-02-21 12:52:58
67	default	1	Peut mieux faire	\N	2025-02-21 12:52:58	2025-02-21 12:52:58
68	default	6	maybe	\N	2025-02-21 12:52:58	2025-02-21 12:52:58
69	default	\N	Commentaire	dzaae	2025-02-21 12:52:58	2025-02-21 12:52:58
70	default	3	Agréable	\N	2025-02-21 13:55:50	2025-02-21 13:55:50
71	default	2	À améliorer	\N	2025-02-21 13:55:50	2025-02-21 13:55:50
72	default	4	Moyen	\N	2025-02-21 13:55:50	2025-02-21 13:55:50
73	default	1	Très bien	\N	2025-02-21 13:55:50	2025-02-21 13:55:50
74	default	6	fasho	\N	2025-02-21 13:55:50	2025-02-21 13:55:50
75	default	\N	Commentaire	faefae	2025-02-21 13:55:50	2025-02-21 13:55:50
76	default	3	À revoir	\N	2025-02-21 15:12:42	2025-02-21 15:12:42
77	default	2	À améliorer	\N	2025-02-21 15:12:42	2025-02-21 15:12:42
78	default	4	Non	\N	2025-02-21 15:12:42	2025-02-21 15:12:42
79	default	1	Bien	\N	2025-02-21 15:12:42	2025-02-21 15:12:42
80	default	6	fasho	\N	2025-02-21 15:12:42	2025-02-21 15:12:42
81	default	\N	Commentaire	ADZFS	2025-02-21 15:12:42	2025-02-21 15:12:42
82	default	3	À revoir	\N	2025-02-21 18:49:39	2025-02-21 18:49:39
83	default	2	À améliorer	\N	2025-02-21 18:49:39	2025-02-21 18:49:39
84	default	4	Moyen	\N	2025-02-21 18:49:39	2025-02-21 18:49:39
85	default	1	Bien	\N	2025-02-21 18:49:39	2025-02-21 18:49:39
86	default	6	non	\N	2025-02-21 18:49:39	2025-02-21 18:49:39
87	default	\N	Commentaire	,hgvhgv	2025-02-21 18:49:39	2025-02-21 18:49:39
88	default	3	Agréable	\N	2025-02-22 19:08:16	2025-02-22 19:08:16
89	default	2	Très satisfaisant	\N	2025-02-22 19:08:16	2025-02-22 19:08:16
90	default	4	Plutôt oui	\N	2025-02-22 19:08:16	2025-02-22 19:08:16
91	default	1	Très bien	\N	2025-02-22 19:08:16	2025-02-22 19:08:16
92	default	6	maybe	\N	2025-02-22 19:08:16	2025-02-22 19:08:16
93	default	\N	Commentaire	DZASQ	2025-02-22 19:08:16	2025-02-22 19:08:16
\.


--
-- TOC entry 4906 (class 0 OID 53668)
-- Dependencies: 219
-- Data for Name: responses; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.responses (id, question_id, selected_option, table_id, feedback, created_at, updated_at) FROM stdin;
1	1	Excellent	default	\N	2025-02-20 10:09:52	2025-02-20 10:09:52
2	2	À améliorer	default	\N	2025-02-20 10:09:52	2025-02-20 10:09:52
3	3	Correcte	default	\N	2025-02-20 10:09:52	2025-02-20 10:09:52
4	4	Moyen	default	\N	2025-02-20 10:09:52	2025-02-20 10:09:52
5	\N	Commentaire	default	etgfsdsdf	2025-02-20 10:09:52	2025-02-20 10:09:52
6	1	Bien	default	\N	2025-02-20 10:10:08	2025-02-20 10:10:08
7	2	À améliorer	default	\N	2025-02-20 10:10:08	2025-02-20 10:10:08
8	3	Correcte	default	\N	2025-02-20 10:10:08	2025-02-20 10:10:08
9	4	Non	default	\N	2025-02-20 10:10:08	2025-02-20 10:10:08
10	\N	Commentaire	default	efafez	2025-02-20 10:10:08	2025-02-20 10:10:08
11	1	Très bien	default	\N	2025-02-20 11:50:39	2025-02-20 11:50:39
12	2	À améliorer	default	\N	2025-02-20 11:50:39	2025-02-20 11:50:39
13	3	À revoir	default	\N	2025-02-20 11:50:39	2025-02-20 11:50:39
14	4	Moyen	default	\N	2025-02-20 11:50:39	2025-02-20 11:50:39
15	\N	Commentaire	default	ineadj	2025-02-20 11:50:39	2025-02-20 11:50:39
16	1	Excellent	default	\N	2025-02-20 11:53:15	2025-02-20 11:53:15
17	2	Satisfaisant	default	\N	2025-02-20 11:53:15	2025-02-20 11:53:15
18	3	À revoir	default	\N	2025-02-20 11:53:15	2025-02-20 11:53:15
19	4	Non	default	\N	2025-02-20 11:53:15	2025-02-20 11:53:15
20	\N	Commentaire	default	ghv	2025-02-20 11:53:15	2025-02-20 11:53:15
21	1	Très bien	default	\N	2025-02-20 11:55:35	2025-02-20 11:55:35
22	2	À améliorer	default	\N	2025-02-20 11:55:35	2025-02-20 11:55:35
23	3	À revoir	default	\N	2025-02-20 11:55:35	2025-02-20 11:55:35
24	4	Non	default	\N	2025-02-20 11:55:35	2025-02-20 11:55:35
25	\N	Commentaire	default	yvty	2025-02-20 11:55:35	2025-02-20 11:55:35
26	1	Peut mieux faire	default	\N	2025-02-20 14:07:37	2025-02-20 14:07:37
27	2	À améliorer	default	\N	2025-02-20 14:07:37	2025-02-20 14:07:37
28	3	Correcte	default	\N	2025-02-20 14:07:37	2025-02-20 14:07:37
29	4	Plutôt oui	default	\N	2025-02-20 14:07:37	2025-02-20 14:07:37
30	\N	Commentaire	default	EAAD	2025-02-20 14:07:37	2025-02-20 14:07:37
31	1	Très bien	default	\N	2025-02-20 14:14:17	2025-02-20 14:14:17
32	2	À améliorer	default	\N	2025-02-20 14:14:17	2025-02-20 14:14:17
33	3	Correcte	default	\N	2025-02-20 14:14:17	2025-02-20 14:14:17
34	4	Moyen	default	\N	2025-02-20 14:14:17	2025-02-20 14:14:17
35	\N	Commentaire	default	caecae	2025-02-20 14:14:17	2025-02-20 14:14:17
36	1	Très bien	default	\N	2025-02-20 14:16:51	2025-02-20 14:16:51
37	2	Parfait	default	\N	2025-02-20 14:16:51	2025-02-20 14:16:51
38	3	Agréable	default	\N	2025-02-20 14:16:51	2025-02-20 14:16:51
39	4	Moyen	default	\N	2025-02-20 14:16:51	2025-02-20 14:16:51
40	\N	Commentaire	default	frfzr	2025-02-20 14:16:51	2025-02-20 14:16:51
41	1	Très bien	default	\N	2025-02-21 09:16:06	2025-02-21 09:16:06
42	2	À améliorer	default	\N	2025-02-21 09:16:07	2025-02-21 09:16:07
43	3	Correcte	default	\N	2025-02-21 09:16:07	2025-02-21 09:16:07
44	4	Moyen	default	\N	2025-02-21 09:16:07	2025-02-21 09:16:07
45	\N	Commentaire	default	eaeaa	2025-02-21 09:16:07	2025-02-21 09:16:07
46	3	À revoir	default	\N	2025-02-21 09:59:41	2025-02-21 09:59:41
47	2	Satisfaisant	default	\N	2025-02-21 09:59:41	2025-02-21 09:59:41
48	4	Moyen	default	\N	2025-02-21 09:59:41	2025-02-21 09:59:41
49	1	Bien	default	\N	2025-02-21 09:59:41	2025-02-21 09:59:41
50	\N	Commentaire	default	eff	2025-02-21 09:59:41	2025-02-21 09:59:41
51	3	Correcte	default	\N	2025-02-21 10:13:36	2025-02-21 10:13:36
52	2	À améliorer	default	\N	2025-02-21 10:13:36	2025-02-21 10:13:36
53	4	Non	default	\N	2025-02-21 10:13:36	2025-02-21 10:13:36
54	1	Peut mieux faire	default	\N	2025-02-21 10:13:36	2025-02-21 10:13:36
56	\N	Commentaire	default	sas	2025-02-21 10:13:36	2025-02-21 10:13:36
57	3	Agréable	default	\N	2025-02-21 10:18:55	2025-02-21 10:18:55
58	2	À améliorer	default	\N	2025-02-21 10:18:55	2025-02-21 10:18:55
59	4	Non	default	\N	2025-02-21 10:18:55	2025-02-21 10:18:55
60	1	Peut mieux faire	default	\N	2025-02-21 10:18:55	2025-02-21 10:18:55
62	\N	Commentaire	default	ef	2025-02-21 10:18:55	2025-02-21 10:18:55
63	3	Agréable	default	\N	2025-02-21 10:19:16	2025-02-21 10:19:16
64	2	À améliorer	default	\N	2025-02-21 10:19:16	2025-02-21 10:19:16
65	4	Non	default	\N	2025-02-21 10:19:16	2025-02-21 10:19:16
66	1	Peut mieux faire	default	\N	2025-02-21 10:19:16	2025-02-21 10:19:16
68	\N	Commentaire	default	ddeaz	2025-02-21 10:19:16	2025-02-21 10:19:16
69	3	Correcte	default	\N	2025-02-21 12:13:21	2025-02-21 12:13:21
70	2	À améliorer	default	\N	2025-02-21 12:13:21	2025-02-21 12:13:21
71	4	Non	default	\N	2025-02-21 12:13:21	2025-02-21 12:13:21
72	1	Bien	default	\N	2025-02-21 12:13:21	2025-02-21 12:13:21
73	\N	Commentaire	default	aefzf	2025-02-21 12:13:21	2025-02-21 12:13:21
74	3	Agréable	default	\N	2025-02-21 12:15:00	2025-02-21 12:15:00
75	2	À améliorer	default	\N	2025-02-21 12:15:00	2025-02-21 12:15:00
76	4	Moyen	default	\N	2025-02-21 12:15:00	2025-02-21 12:15:00
77	1	Bien	default	\N	2025-02-21 12:15:00	2025-02-21 12:15:00
78	6	maybe	default	\N	2025-02-21 12:15:00	2025-02-21 12:15:00
79	\N	Commentaire	default	zfz	2025-02-21 12:15:00	2025-02-21 12:15:00
80	3	Agréable	default	\N	2025-02-21 12:52:58	2025-02-21 12:52:58
81	2	À améliorer	default	\N	2025-02-21 12:52:58	2025-02-21 12:52:58
82	4	Moyen	default	\N	2025-02-21 12:52:58	2025-02-21 12:52:58
83	1	Peut mieux faire	default	\N	2025-02-21 12:52:58	2025-02-21 12:52:58
84	6	maybe	default	\N	2025-02-21 12:52:58	2025-02-21 12:52:58
85	\N	Commentaire	default	dzaae	2025-02-21 12:52:58	2025-02-21 12:52:58
86	3	Agréable	default	\N	2025-02-21 13:55:50	2025-02-21 13:55:50
87	2	À améliorer	default	\N	2025-02-21 13:55:50	2025-02-21 13:55:50
88	4	Moyen	default	\N	2025-02-21 13:55:50	2025-02-21 13:55:50
89	1	Très bien	default	\N	2025-02-21 13:55:50	2025-02-21 13:55:50
90	6	fasho	default	\N	2025-02-21 13:55:50	2025-02-21 13:55:50
91	\N	Commentaire	default	faefae	2025-02-21 13:55:50	2025-02-21 13:55:50
92	3	À revoir	default	\N	2025-02-21 15:12:42	2025-02-21 15:12:42
93	2	À améliorer	default	\N	2025-02-21 15:12:42	2025-02-21 15:12:42
94	4	Non	default	\N	2025-02-21 15:12:42	2025-02-21 15:12:42
95	1	Bien	default	\N	2025-02-21 15:12:42	2025-02-21 15:12:42
96	6	fasho	default	\N	2025-02-21 15:12:42	2025-02-21 15:12:42
97	\N	Commentaire	default	ADZFS	2025-02-21 15:12:42	2025-02-21 15:12:42
98	3	À revoir	default	\N	2025-02-21 18:49:39	2025-02-21 18:49:39
99	2	À améliorer	default	\N	2025-02-21 18:49:39	2025-02-21 18:49:39
100	4	Moyen	default	\N	2025-02-21 18:49:39	2025-02-21 18:49:39
101	1	Bien	default	\N	2025-02-21 18:49:39	2025-02-21 18:49:39
102	6	non	default	\N	2025-02-21 18:49:39	2025-02-21 18:49:39
103	\N	Commentaire	default	,hgvhgv	2025-02-21 18:49:39	2025-02-21 18:49:39
104	3	Agréable	default	\N	2025-02-22 19:08:16	2025-02-22 19:08:16
105	2	Très satisfaisant	default	\N	2025-02-22 19:08:16	2025-02-22 19:08:16
106	4	Plutôt oui	default	\N	2025-02-22 19:08:16	2025-02-22 19:08:16
107	1	Très bien	default	\N	2025-02-22 19:08:16	2025-02-22 19:08:16
108	6	maybe	default	\N	2025-02-22 19:08:16	2025-02-22 19:08:16
109	\N	Commentaire	default	DZASQ	2025-02-22 19:08:16	2025-02-22 19:08:16
\.


--
-- TOC entry 4908 (class 0 OID 53682)
-- Dependencies: 221
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.users (id, name, email, email_verified_at, password, remember_token, created_at, updated_at) FROM stdin;
1	Admin	contact@events-five.com	\N	$2y$12$c4R3oGzvj/qvyOzGm1d0vuS2G/x/qzfF8JKEOi0FGi3ZZavZCf8y.	\N	2025-02-19 17:01:38	2025-02-19 17:01:38
\.


--
-- TOC entry 4930 (class 0 OID 0)
-- Dependencies: 226
-- Name: answers_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.answers_id_seq', 1, false);


--
-- TOC entry 4931 (class 0 OID 0)
-- Dependencies: 229
-- Name: comments_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.comments_id_seq', 1, false);


--
-- TOC entry 4932 (class 0 OID 0)
-- Dependencies: 215
-- Name: migrations_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.migrations_id_seq', 13, true);


--
-- TOC entry 4933 (class 0 OID 0)
-- Dependencies: 228
-- Name: questions_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.questions_id_seq', 6, true);


--
-- TOC entry 4934 (class 0 OID 0)
-- Dependencies: 224
-- Name: response_history_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.response_history_id_seq', 93, true);


--
-- TOC entry 4935 (class 0 OID 0)
-- Dependencies: 218
-- Name: responses_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.responses_id_seq', 109, true);


--
-- TOC entry 4936 (class 0 OID 0)
-- Dependencies: 220
-- Name: users_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.users_id_seq', 2, true);


--
-- TOC entry 4753 (class 2606 OID 61913)
-- Name: answers answers_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.answers
    ADD CONSTRAINT answers_pkey PRIMARY KEY (id);


--
-- TOC entry 4748 (class 2606 OID 53705)
-- Name: cache_locks cache_locks_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.cache_locks
    ADD CONSTRAINT cache_locks_pkey PRIMARY KEY (key);


--
-- TOC entry 4746 (class 2606 OID 53698)
-- Name: cache cache_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.cache
    ADD CONSTRAINT cache_pkey PRIMARY KEY (key);


--
-- TOC entry 4755 (class 2606 OID 61938)
-- Name: comments comments_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.comments
    ADD CONSTRAINT comments_pkey PRIMARY KEY (id);


--
-- TOC entry 4736 (class 2606 OID 53659)
-- Name: migrations migrations_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.migrations
    ADD CONSTRAINT migrations_pkey PRIMARY KEY (id);


--
-- TOC entry 4738 (class 2606 OID 53666)
-- Name: questions questions_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.questions
    ADD CONSTRAINT questions_pkey PRIMARY KEY (id);


--
-- TOC entry 4750 (class 2606 OID 53737)
-- Name: response_history response_history_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.response_history
    ADD CONSTRAINT response_history_pkey PRIMARY KEY (id);


--
-- TOC entry 4740 (class 2606 OID 53675)
-- Name: responses responses_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.responses
    ADD CONSTRAINT responses_pkey PRIMARY KEY (id);


--
-- TOC entry 4742 (class 2606 OID 53691)
-- Name: users users_email_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_email_unique UNIQUE (email);


--
-- TOC entry 4744 (class 2606 OID 53689)
-- Name: users users_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);


--
-- TOC entry 4751 (class 1259 OID 53743)
-- Name: response_history_table_id_created_at_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX response_history_table_id_created_at_index ON public.response_history USING btree (table_id, created_at);


--
-- TOC entry 4758 (class 2606 OID 61914)
-- Name: answers answers_question_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.answers
    ADD CONSTRAINT answers_question_id_foreign FOREIGN KEY (question_id) REFERENCES public.questions(id) ON DELETE CASCADE;


--
-- TOC entry 4757 (class 2606 OID 53738)
-- Name: response_history response_history_question_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.response_history
    ADD CONSTRAINT response_history_question_id_foreign FOREIGN KEY (question_id) REFERENCES public.questions(id) ON DELETE SET NULL;


--
-- TOC entry 4756 (class 2606 OID 53706)
-- Name: responses responses_question_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.responses
    ADD CONSTRAINT responses_question_id_foreign FOREIGN KEY (question_id) REFERENCES public.questions(id);


-- Completed on 2025-02-22 19:47:55

--
-- PostgreSQL database dump complete
--

